<?php

namespace Modules\Paquete4Inventarios\Models;

use Illuminate\Database\Eloquent\Model;

class InventarioAlertaConfig extends Model
{
    protected $table = 'inventario_alertas_config';
    protected $fillable = [
        'tipo_inventario',
        'inventario_id',
        'alerta_activa',
        'correo_remitente',
        'correo_destinatario',
        'encargado'
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
