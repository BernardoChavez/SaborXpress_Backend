<?php

namespace Modules\Paquete11ServiciosEspeciales\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Paquete11ServiciosEspeciales\Database\Factories\CateringServicioDetalleFactory;

class CateringServicioDetalle extends Model
{
    use HasFactory;

    protected $table = 'catering_servicio_detalles';

    protected $fillable = [
        'catering_servicio_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal'
    ];

    public function servicio()
    {
        return $this->belongsTo(CateringServicio::class, 'catering_servicio_id');
    }

    public function producto()
    {
        return $this->belongsTo(\Modules\Paquete3Configuracion\Models\Producto::class, 'producto_id');
    }

    // protected static function newFactory(): CateringServicioDetalleFactory
    // {
    //     // return CateringServicioDetalleFactory::new();
    // }
}
