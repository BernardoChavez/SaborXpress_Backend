<?php

namespace Modules\Paquete5Ventas\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Paquete5Ventas\Models\Venta;
use Modules\Paquete5Ventas\Models\VentaDetalle;
use Modules\Paquete5Ventas\Models\Caja;
use Modules\Paquete4Inventarios\Models\Receta;
use Modules\Paquete6Produccion\Models\Comanda;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    /**
     * CU17: Registrar pedido (POS)
     */
    public function store(Request $request)
    {
        $request->validate([
            'metodo_pago' => 'required|in:Efectivo,QR',
            'tipo_entrega' => 'required|in:Mesa,Llevar',
            'detalles' => 'required|array|min:1',
            'detalles.*.id_producto' => 'required|exists:producto,id',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_unitario' => 'required|numeric',
            'VentaEstado' => 'nullable|string|max:255',
        ]);

        $usuario = Auth::user();
        $usuarioId = $usuario->id;

        // VALIDACIÓN CU16: Caja abierta.
        // Si es un cliente o un administrador simulando una compra desde el portal de cliente sin caja abierta,
        // buscamos cualquier caja abierta en el sistema, o en su defecto, la última registrada para cumplir con la FK.
        $caja = Caja::where('id_usuario', $usuarioId)->where('estado', 'Abierta')->first();
        if (!$caja) {
            $caja = Caja::where('estado', 'Abierta')->first();
            if (!$caja) {
                $caja = Caja::latest('id')->first();
            }
        }

        if (!$caja) {
            return response()->json(['message' => 'Se requiere al menos una caja registrada en el sistema para procesar la venta.'], 403);
        }

        return DB::transaction(function () use ($request, $caja, $usuarioId) {
            
            // Calcular monto total
            $montoTotal = collect($request->detalles)->sum(fn($d) => $d['cantidad'] * $d['precio_unitario']);

            // Generar número de pedido correlativo del día (simplificado)
            $nroPedido = Venta::whereDate('created_at', today())->count() + 1;

            // Manejo de facturación (CU26)
            $nroFactura = null;
            if ($request->requiere_factura) {
                // Generar número de factura secuencial
                $ultimaFactura = Venta::whereNotNull('nro_factura')->max('nro_factura');
                $nroFactura = $ultimaFactura ? $ultimaFactura + 1 : 1;
            }

            // Crear Venta
            $venta = Venta::create([
                'id_caja' => $caja->id,
                'id_usuario' => $usuarioId,
                'monto_total' => $montoTotal,
                'metodo_pago' => $request->metodo_pago,
                'codigo_qr' => $request->codigo_qr ?? null,
                'tipo_entrega' => $request->tipo_entrega,
                'estado' => 'Pagado', // En este flujo simplificado, el POS cobra inmediatamente
                'nro_pedido' => $nroPedido,
                'VentaEstado' => $request->VentaEstado,
                'requiere_factura' => $request->requiere_factura ?? false,
                'nit_cliente' => $request->nit_cliente,
                'nombre_cliente' => $request->nombre_cliente,
                'email_cliente' => $request->email_cliente,
                'nro_factura' => $nroFactura
            ]);

            // Crear Detalles y realizar descargo (CU32)
            foreach ($request->detalles as $det) {
                VentaDetalle::create([
                    'id_venta' => $venta->id,
                    'id_producto' => $det['id_producto'],
                    'cantidad' => $det['cantidad'],
                    'precio_unitario' => $det['precio_unitario'],
                    'subtotal' => $det['cantidad'] * $det['precio_unitario']
                ]);

                // CU32: Descargo automático de stock basado en recetas
                $this->descargarStock($det['id_producto'], $det['cantidad']);
            }

            // CU20: Crear Comanda para Cocina
            Comanda::create([
                'id_venta' => $venta->id,
                'estado' => 'Pendiente',
                'area' => 'Cocina' // Podría derivarse del tipo de producto en un futuro
            ]);

            // Enviar Correo si hay email (CU26)
            if ($request->requiere_factura && $request->email_cliente) {
                try {
                    $empresa = \Modules\Paquete3Configuracion\Models\Empresa::first();
                    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('factura', compact('venta', 'empresa'));
                    $pdfContent = $pdf->output();

                    \Illuminate\Support\Facades\Mail::to($request->email_cliente)->send(new \App\Mail\FacturaMail($venta, $pdfContent));
                } catch (\Exception $e) {
                    // Logear el error pero no detener la venta
                    \Illuminate\Support\Facades\Log::error('Error enviando email: ' . $e->getMessage());
                }
            }

            return response()->json([
                'message' => 'Venta registrada con éxito',
                'nro_pedido' => $nroPedido,
                'venta' => $venta->load('detalles.producto')
            ], 201);
        });
    }

    /**
     * CU32: Lógica de descargo automático
     */
    private function descargarStock($idProducto, $cantidadVendida)
    {
        $recetas = Receta::where('id_producto', $idProducto)->get();

        foreach ($recetas as $receta) {
            $insumo = $receta->procesado;
            if ($insumo) {
                $cantidadADescontar = $receta->cantidad * $cantidadVendida;
                $insumo->decrement('stock', $cantidadADescontar);
            }
        }
    }

    public function index()
    {
        $usuario = Auth::user();
        $query = Venta::with(['detalles.producto', 'usuario.persona']);

        if ($usuario && $usuario->tipo_usuario === 'Cliente') {
            $query->where('id_usuario', $usuario->id);
        }

        return $query->latest()->take(50)->get();
    }

    /**
     * CU22 / CU25: Generar y re-imprimir ticket/factura operativa.
     */
    public function generarTicket($id)
    {
        $venta = Venta::with(['detalles.producto', 'usuario.persona'])->findOrFail($id);
        $empresa = \Modules\Paquete3Configuracion\Models\Empresa::first() ?? (object)[
            'nombre' => 'Sabor Xpress',
            'nit' => '00000000',
            'direccion' => 'Dirección General',
            'telefono' => '000000'
        ];

        $lineaSeparadora = str_repeat("=", 34) . "\n";
        $lineaSimple = str_repeat("-", 34) . "\n";

        // Formatear texto del ticket para ticketera térmica (34 caracteres de ancho)
        $text = "";
        $text .= str_pad("SABOR XPRESS", 34, " ", STR_PAD_BOTH) . "\n";
        $text .= str_pad($empresa->nombre, 34, " ", STR_PAD_BOTH) . "\n";
        $text .= str_pad("NIT: " . $empresa->nit, 34, " ", STR_PAD_BOTH) . "\n";
        $text .= str_pad("Dir: " . $empresa->direccion, 34, " ", STR_PAD_BOTH) . "\n";
        $text .= str_pad("Tel: " . $empresa->telefono, 34, " ", STR_PAD_BOTH) . "\n";
        $text .= $lineaSeparadora;
        
        $text .= "Pedido: #" . str_pad($venta->nro_pedido, 3, "0", STR_PAD_LEFT) . "   ";
        $text .= "Fecha: " . $venta->created_at->format('d/m/Y') . "\n";
        $text .= "Cajero: " . ($venta->usuario->persona->nombre ?? 'Sistema') . "\n";
        $text .= "Entrega: " . $venta->tipo_entrega . "\n";
        $text .= $lineaSimple;
        $text .= "Cant Producto           Subtotal \n";
        $text .= $lineaSimple;

        foreach ($venta->detalles as $det) {
            $cantStr = str_pad($det->cantidad, 3, " ", STR_PAD_RIGHT);
            $nombreProd = substr($det->producto->nombre ?? 'Producto', 0, 18);
            $nombreProdStr = str_pad($nombreProd, 18, " ", STR_PAD_RIGHT);
            $subtotalStr = str_pad(number_format($det->subtotal, 2), 10, " ", STR_PAD_LEFT);
            $text .= $cantStr . " " . $nombreProdStr . " " . $subtotalStr . "\n";
        }
        $text .= $lineaSimple;
        
        $totalLabel = "TOTAL:";
        $totalVal = number_format($venta->monto_total, 2) . " Bs.";
        $text .= str_pad($totalLabel, 15, " ", STR_PAD_RIGHT) . str_pad($totalVal, 19, " ", STR_PAD_LEFT) . "\n";
        $text .= "Metodo Pago: " . $venta->metodo_pago . "\n";
        $text .= $lineaSeparadora;
        $text .= str_pad("¡Gracias por su preferencia!", 34, " ", STR_PAD_BOTH) . "\n";
        $text .= str_pad("Sabor Xpress POS", 34, " ", STR_PAD_BOTH) . "\n";
        $text .= $lineaSeparadora;

        return response()->json([
            'empresa' => $empresa,
            'venta' => $venta,
            'ticket_text' => $text
        ], 200);
    }

    /**
     * Obtener ticket público para el cliente final (sin autenticación)
     */
    public function generarTicketPublico($id)
    {
        return $this->generarTicket($id);
    }

    /**
     * Obtener estado de preparación público para el cliente final (sin autenticación)
     */
    public function getEstadoPublico($id)
    {
        $venta = Venta::findOrFail($id);
        return response()->json([
            'id' => $venta->id,
            'nro_pedido' => $venta->nro_pedido,
            'estado_preparacion' => $venta->VentaEstado ?? 'En preparación',
            'monto_total' => $venta->monto_total,
            'created_at' => $venta->created_at->toIso8601String()
        ]);
    }

    /**
     * Anular una venta/ticket
     */
    public function anular(Request $request, $id)
    {
        $request->validate([
            'motivo_anulacion' => 'required|string|min:5'
        ]);

        $venta = Venta::findOrFail($id);
        
        if ($venta->estado === 'Cancelado') {
            return response()->json(['message' => 'El ticket ya se encuentra anulado.'], 400);
        }

        $venta->estado = 'Cancelado';
        $venta->motivo_anulacion = $request->motivo_anulacion;
        $venta->fecha_anulacion = now();
        $venta->save();

        // Anular comanda asociada si existe (CU20)
        $comanda = \Modules\Paquete6Produccion\Models\Comanda::where('id_venta', $venta->id)->first();
        if ($comanda) {
            $comanda->estado = 'Anulado';
            $comanda->save();
        }

        // Opcional: Revertir stock (comentado si no es requerido revertir en caja aún)
        // foreach ($venta->detalles as $det) { ... }

        return response()->json(['message' => 'Ticket anulado correctamente.', 'venta' => $venta], 200);
    }

    /**
     * Listar ventas anuladas
     */
    public function anuladas()
    {
        return Venta::with(['usuario.persona'])
            ->where('estado', 'Cancelado')
            ->latest('fecha_anulacion')
            ->get();
    }

    /**
     * CU26: Generar PDF de Factura
     */
    public function factura($id)
    {
        $venta = Venta::with(['detalles.producto', 'caja', 'usuario'])->findOrFail($id);

        if (!$venta->requiere_factura || !$venta->nro_factura) {
            return response()->json(['message' => 'Esta venta no tiene factura emitida.'], 400);
        }

        $empresa = \Modules\Paquete3Configuracion\Models\Empresa::first();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('factura', compact('venta', 'empresa'));
        
        return $pdf->stream('Factura_' . str_pad($venta->nro_factura, 5, '0', STR_PAD_LEFT) . '.pdf');
    }
}
