<?php

namespace Modules\Paquete10MesasReservasResenas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Paquete10MesasReservasResenas\Database\Factories\ResenaFactory;

class Resena extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['venta_id', 'calificacion', 'comentario', 'leido'];

    public function venta()
    {
        // Adjust the namespace if Venta is located elsewhere
        return $this->belongsTo(\Modules\Paquete5Ventas\Models\Venta::class, 'venta_id');
    }

    // protected static function newFactory(): ResenaFactory
    // {
    //     // return ResenaFactory::new();
    // }
}
