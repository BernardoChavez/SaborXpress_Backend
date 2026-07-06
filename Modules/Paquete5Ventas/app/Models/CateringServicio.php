<?php

namespace Modules\Paquete5Ventas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Paquete5Ventas\Database\Factories\CateringServicioFactory;

class CateringServicio extends Model
{
    use HasFactory;

    protected $table = 'catering_servicios';

    protected $fillable = [
        'codigo',
        'cliente',
        'telefono',
        'fecha_evento',
        'hora_evento',
        'modalidad',
        'direccion',
        'cantidad_personas',
        'observaciones',
        'precio_total',
        'estado'
    ];

    public function detalles()
    {
        return $this->hasMany(CateringServicioDetalle::class, 'catering_servicio_id');
    }

    // protected static function newFactory(): CateringServicioFactory
    // {
    //     // return CateringServicioFactory::new();
    // }
}
