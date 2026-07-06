<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Paquete4Inventarios\Models\InventarioAlertaConfig;
use Modules\Paquete4Inventarios\Models\InventarioAlertaGenerada;
use Modules\Paquete4Inventarios\Models\InventarioBruto;
use Modules\Paquete4Inventarios\Models\InventarioProcesado;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CheckInventarioAlertas extends Command
{
    protected $signature = 'inventario:check-alertas';
    protected $description = 'Verifica el stock de los productos y genera alertas si están por debajo del mínimo';

    public function handle()
    {
        $configs = InventarioAlertaConfig::where('alerta_activa', true)->get();

        foreach ($configs as $config) {
            $prod = null;
            if ($config->tipo_inventario === 'Materia Prima') {
                $prod = InventarioBruto::find($config->inventario_id);
            } else {
                $prod = InventarioProcesado::find($config->inventario_id);
            }

            if ($prod && $prod->stock <= $prod->stock_minimo) {
                // Verificar si ya existe una alerta "Pendiente" para este producto
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
                            // Enviar correo (usando formato simple)
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
                            $this->info("Alerta generada y correo enviado para: {$prod->nombre}");
                        } catch (\Exception $e) {
                            Log::error("Error enviando alerta de inventario: " . $e->getMessage());
                            $this->error("Alerta generada pero falló el envío de correo para: {$prod->nombre}");
                        }
                    } else {
                        $this->info("Alerta generada (sin correo) para: {$prod->nombre}");
                    }
                }
            } else if ($prod && $prod->stock > $prod->stock_minimo) {
                // Si el stock ya superó el mínimo (se reabasteció), auto-atender la alerta pendiente
                InventarioAlertaGenerada::where('tipo_inventario', $config->tipo_inventario)
                    ->where('inventario_id', $config->inventario_id)
                    ->where('estado', 'Pendiente')
                    ->update(['estado' => 'Atendida']);
            }
        }
    }
}
