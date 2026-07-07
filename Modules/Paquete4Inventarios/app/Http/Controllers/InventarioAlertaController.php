<?php

namespace Modules\Paquete4Inventarios\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Paquete4Inventarios\Models\InventarioAlertaConfig;
use Modules\Paquete4Inventarios\Models\InventarioAlertaGenerada;
use Modules\Paquete4Inventarios\Models\InventarioBruto;
use Modules\Paquete4Inventarios\Models\InventarioProcesado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class InventarioAlertaController extends Controller
{
    // Obtener configuración de alertas (para dropdowns y tabla)
    public function index(Request $request)
    {
        $query = InventarioAlertaGenerada::orderBy('created_at', 'desc');

        if ($request->filled('estado') && $request->estado !== 'Todos') {
            $query->where('estado', $request->estado);
        }
        
        if ($request->filled('tipo_inventario') && $request->tipo_inventario !== 'Todos') {
            $query->where('tipo_inventario', $request->tipo_inventario);
        }

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->fecha_inicio)->startOfDay(), 
                Carbon::parse($request->fecha_fin)->endOfDay()
            ]);
        }

        $alertas = $query->get()->map(function($alerta) {
            $prod = $alerta->producto;
            $alerta->producto_nombre = $prod ? $prod->nombre : 'Desconocido';
            return $alerta;
        });

        // Filtrado por search (búsqueda en memoria por nombre de producto o código)
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $alertas = $alertas->filter(function($alerta) use ($search) {
                return str_contains(strtolower($alerta->codigo), $search) || 
                       str_contains(strtolower($alerta->producto_nombre), $search);
            })->values();
        }

        return response()->json($alertas);
    }

    // Historial de alertas enviadas (las que ya tienen correo_destinatario)
    public function historial()
    {
        $alertas = InventarioAlertaGenerada::whereNotNull('fecha_envio_correo')
            ->orderBy('fecha_envio_correo', 'desc')
            ->take(50)
            ->get()
            ->map(function($alerta) {
                $prod = $alerta->producto;
                $alerta->producto_nombre = $prod ? $prod->nombre : 'Desconocido';
                return $alerta;
            });
            
        return response()->json($alertas);
    }

    // Configurar una alerta para un producto
    public function configurar(Request $request)
    {
        $request->validate([
            'tipo_inventario' => 'required|string|in:Materia Prima,Elaborado',
            'inventario_id' => 'required|integer',
            'alerta_activa' => 'required|boolean',
            'correo_destinatario' => 'nullable|email',
            'correo_remitente' => 'nullable|email',
            'encargado' => 'nullable|string|max:255'
        ]);

        DB::beginTransaction();
        try {
            if ($request->tipo_inventario === 'Materia Prima') {
                $prod = InventarioBruto::findOrFail($request->inventario_id);
            } else {
                $prod = InventarioProcesado::findOrFail($request->inventario_id);
            }

            // Guardar configuración de la alerta
            $config = InventarioAlertaConfig::updateOrCreate(
                [
                    'tipo_inventario' => $request->tipo_inventario,
                    'inventario_id' => $request->inventario_id
                ],
                [
                    'alerta_activa' => $request->alerta_activa,
                    'correo_destinatario' => $request->correo_destinatario,
                    'correo_remitente' => $request->correo_remitente,
                    'encargado' => $request->encargado
                ]
            );

            // Trigger inmediato: Verificar si genera alerta automáticamente
            if ($config->alerta_activa && $prod->stock <= $prod->stock_minimo) {
                $existe = InventarioAlertaGenerada::where('tipo_inventario', $config->tipo_inventario)
                    ->where('inventario_id', $config->inventario_id)
                    ->where('estado', 'Pendiente')
                    ->exists();

                if (!$existe) {
                    $codigo = 'ALT-' . str_pad(InventarioAlertaGenerada::max('id') + 1, 4, '0', STR_PAD_LEFT);
                    
                    $alerta = InventarioAlertaGenerada::create([
                        'codigo' => $codigo,
                        'tipo_inventario' => $config->tipo_inventario,
                        'inventario_id' => $config->inventario_id,
                        'stock_actual' => $prod->stock,
                        'stock_minimo' => $prod->stock_minimo,
                        'estado' => 'Pendiente',
                        'correo_remitente' => $config->correo_remitente,
                        'correo_destinatario' => $config->correo_destinatario,
                        'encargado' => $config->encargado
                    ]);

                    // Si tiene correo, enviarlo
                    if ($config->correo_destinatario) {
                        try {
                            $asunto = "Alerta de Inventario: {$prod->nombre}";
                            $mensaje = "El producto {$prod->nombre} ({$config->tipo_inventario}) ha alcanzado su stock mínimo.\n\n"
                                     . "Stock actual: {$prod->stock} {$prod->unidad_medida}\n"
                                     . "Stock mínimo: {$prod->stock_minimo} {$prod->unidad_medida}\n\n"
                                     . "Encargado: " . ($config->encargado ?: 'No asignado') . "\n\n"
                                     . "Por favor, reabastezca este producto a la brevedad.";

                            if ($config->correo_remitente) {
                                config(['mail.from.address' => $config->correo_remitente]);
                                config(['mail.from.name' => 'SaborXpress (Alertas)']);
                            }

                            Mail::raw($mensaje, function ($m) use ($config, $asunto) {
                                $m->to($config->correo_destinatario)->subject($asunto);
                            });

                            $alerta->update(['fecha_envio_correo' => now()]);
                        } catch (\Exception $e) {
                            \Illuminate\Support\Facades\Log::error("Error enviando alerta instantanea: " . $e->getMessage());
                        }
                    }
                }
            }

            DB::commit();
            return response()->json(['message' => 'Configuración guardada exitosamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al guardar configuración', 'error' => $e->getMessage()], 500);
        }
    }

    // Obtener la configuración actual de un producto para llenar el form
    public function getConfig($tipo_inventario, $inventario_id)
    {
        $config = InventarioAlertaConfig::where('tipo_inventario', $tipo_inventario)
            ->where('inventario_id', $inventario_id)
            ->first();

        if ($tipo_inventario === 'Materia Prima') {
            $prod = InventarioBruto::find($inventario_id);
        } else {
            $prod = InventarioProcesado::find($inventario_id);
        }

        return response()->json([
            'stock_minimo' => $prod ? $prod->stock_minimo : 0,
            'alerta_activa' => $config ? $config->alerta_activa : false,
            'correo_destinatario' => $config ? $config->correo_destinatario : '',
            'correo_remitente' => $config ? $config->correo_remitente : '',
            'encargado' => $config ? $config->encargado : ''
        ]);
    }

    // Marcar una alerta como atendida
    public function marcarAtendida($id)
    {
        $alerta = InventarioAlertaGenerada::findOrFail($id);
        $alerta->update(['estado' => 'Atendida']);
        return response()->json(['message' => 'Alerta marcada como atendida', 'alerta' => $alerta]);
    }

    // Reenviar el correo manualmente
    public function reenviarCorreo($id)
    {
        $alerta = InventarioAlertaGenerada::findOrFail($id);
        
        if (!$alerta->correo_destinatario) {
            return response()->json(['message' => 'No hay destinatario configurado para esta alerta'], 400);
        }

        // Simulación o envío real:
        if ($alerta->correo_remitente) {
            config(['mail.from.address' => $alerta->correo_remitente]);
            config(['mail.from.name' => 'SaborXpress (Alertas)']);
        }

        $prod = $alerta->producto;
        if ($prod) {
            $asunto = "Recordatorio de Alerta de Inventario: {$prod->nombre}";
            $mensaje = "El producto {$prod->nombre} ({$alerta->tipo_inventario}) sigue por debajo de su stock mínimo.\n\n"
                     . "Stock actual: {$prod->stock} {$prod->unidad_medida}\n"
                     . "Stock mínimo: {$prod->stock_minimo} {$prod->unidad_medida}\n\n"
                     . "Encargado: " . ($alerta->encargado ?: 'No asignado') . "\n\n"
                     . "Por favor, reabastezca este producto a la brevedad.";
            
            try {
                \Illuminate\Support\Facades\Mail::raw($mensaje, function ($m) use ($alerta, $asunto) {
                    $m->to($alerta->correo_destinatario)->subject($asunto);
                });
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error al enviar el correo: ' . $e->getMessage()], 500);
            }
        }

        $alerta->update(['fecha_envio_correo' => now()]);
        
        return response()->json(['message' => 'Correo reenviado exitosamente']);
    }

    // Eliminar alerta
    public function destroyAlerta($id)
    {
        $alerta = InventarioAlertaGenerada::findOrFail($id);
        $alerta->delete();
        return response()->json(['message' => 'Alerta eliminada exitosamente']);
    }

    // Eliminar configuración
    public function destroyConfig($tipo_inventario, $inventario_id)
    {
        $config = InventarioAlertaConfig::where('tipo_inventario', $tipo_inventario)
            ->where('inventario_id', $inventario_id)
            ->firstOrFail();
            
        $config->delete();
        
        return response()->json(['message' => 'Configuración eliminada exitosamente']);
    }

    // Endpoint rápido para probar configuración de correo en Railway
    public function testEmail(Request $request)
    {
        $destinatario = $request->query('correo', 'chavezbernardo15@gmail.com');
        try {
            \Illuminate\Support\Facades\Mail::raw("¡Felicidades! Tu configuración de correo en Railway está funcionando al 100%.", function ($m) use ($destinatario) {
                $m->to($destinatario)->subject('Prueba Exitosa - SaborXpress Railway');
            });
            return response()->json(['success' => true, 'message' => "¡Correo enviado con éxito a $destinatario desde Railway!"]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage(), 'message' => "Fallo al enviar correo desde Railway: " . $e->getMessage()], 500);
        }
    }
}
