<?php

namespace Modules\Paquete4Inventarios\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\Paquete4Inventarios\Models\OrdenCompra;
use Modules\Paquete4Inventarios\Models\OrdenCompraDetalle;
use Modules\Paquete4Inventarios\Models\InventarioBruto;
use Carbon\Carbon;

class OrdenCompraController extends Controller
{
    /**
     * Listar órdenes de compra
     */
    public function index()
    {
        return OrdenCompra::with(['proveedor', 'usuario.persona'])
            ->latest()
            ->get();
    }

    /**
     * CU27: Registrar orden de compra
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_proveedor' => 'required|exists:proveedores,id',
            'detalles' => 'required|array|min:1',
            'detalles.*.id_bruto' => 'required|exists:inventario_bruto,id',
            'detalles.*.cantidad' => 'required|numeric|gt:0',
            'detalles.*.precio_unitario' => 'required|numeric|min:0',
        ], [
            'id_proveedor.required' => 'El proveedor es obligatorio.',
            'id_proveedor.exists' => 'El proveedor seleccionado no existe.',
            'detalles.required' => 'Debe incluir al menos un detalle en la orden.',
            'detalles.array' => 'El detalle debe ser una lista.',
            'detalles.*.id_bruto.exists' => 'Uno de los insumos seleccionados no existe en inventario.',
            'detalles.*.cantidad.numeric' => 'La cantidad debe ser numérica.',
            'detalles.*.cantidad.gt' => 'La cantidad debe ser mayor a 0.',
            'detalles.*.precio_unitario.numeric' => 'El precio debe ser numérico.',
        ]);

        $usuarioId = Auth::id();

        return DB::transaction(function () use ($request, $usuarioId) {
            // Calcular monto total
            $montoTotal = collect($request->detalles)->sum(fn($d) => $d['cantidad'] * $d['precio_unitario']);

            // Crear la orden de compra
            $orden = OrdenCompra::create([
                'id_proveedor' => $request->id_proveedor,
                'id_usuario' => $usuarioId,
                'monto_total' => $montoTotal,
                'estado' => 'Pendiente',
                'fecha_orden' => Carbon::now()
            ]);

            // Crear los detalles
            foreach ($request->detalles as $det) {
                OrdenCompraDetalle::create([
                    'id_orden_compra' => $orden->id,
                    'id_bruto' => $det['id_bruto'],
                    'cantidad' => $det['cantidad'],
                    'precio_unitario' => $det['precio_unitario'],
                    'subtotal' => $det['cantidad'] * $det['precio_unitario']
                ]);
            }

            return response()->json([
                'message' => 'Orden de compra registrada con éxito.',
                'orden' => $orden->load(['proveedor', 'detalles.bruto'])
            ], 201);
        });
    }

    /**
     * CU23: Emisión de detalle compra
     */
    public function show($id)
    {
        $orden = OrdenCompra::with(['proveedor', 'usuario.persona', 'detalles.bruto'])->find($id);

        if (!$orden) {
            return response()->json(['message' => 'Orden de compra no encontrada.'], 404);
        }

        return response()->json($orden, 200);
    }

    /**
     * CU28: Recepción de mercancía
     */
    public function recepcion(Request $request, $id)
    {
        $orden = OrdenCompra::find($id);

        if (!$orden) {
            return response()->json(['message' => 'Orden de compra no encontrada.'], 404);
        }

        if ($orden->estado !== 'Pendiente') {
            return response()->json([
                'message' => 'La orden ya ha sido recibida o cancelada previamente.'
            ], 400);
        }

        return DB::transaction(function () use ($orden) {
            // Actualizar estado de la orden
            $orden->update([
                'estado' => 'Recibida',
                'fecha_recepcion' => Carbon::now()
            ]);

            // Cargar stock en Inventario Bruto
            foreach ($orden->detalles as $detalle) {
                $bruto = $detalle->bruto;
                if ($bruto) {
                    $bruto->increment('stock', $detalle->cantidad);
                }
            }

            return response()->json([
                'message' => 'Mercancía recibida con éxito. El inventario se ha actualizado.',
                'orden' => $orden->load(['proveedor', 'detalles.bruto'])
            ], 200);
        });
    }

    /**
     * Cancelar orden de compra
     */
    public function cancelar($id)
    {
        $orden = OrdenCompra::find($id);

        if (!$orden) {
            return response()->json(['message' => 'Orden de compra no encontrada.'], 404);
        }

        if ($orden->estado !== 'Pendiente') {
            return response()->json([
                'message' => 'Solo se pueden cancelar órdenes que estén en estado Pendiente.'
            ], 400);
        }

        $orden->update(['estado' => 'Cancelada']);

        return response()->json([
            'message' => 'Orden de compra cancelada con éxito.',
            'orden' => $orden
        ], 200);
    }
}
