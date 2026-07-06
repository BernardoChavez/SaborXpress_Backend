<?php

namespace Modules\Paquete4Inventarios\Models;

use Illuminate\Database\Eloquent\Model;

class InventarioAlertaGenerada extends Model
{
    protected $table = 'inventario_alertas_generadas';
    protected $fillable = [
        'codigo',
        'tipo_inventario',
        'inventario_id',
        'stock_actual',
        'stock_minimo',
        'estado',
        'fecha_envio_correo',
        'correo_remitente',
        'correo_destinatario',
        'encargado'
    ];

    protected $casts = [
        'fecha_envio_correo' => 'datetime',
    ];

    public function getProductoAttribute()
    {
        if ($this->tipo_inventario === 'Materia Prima') {
            return InventarioBruto::find($this->inventario_id);
        } else {
            return InventarioProcesado::find($this->inventario_id);
        }
    }
}
