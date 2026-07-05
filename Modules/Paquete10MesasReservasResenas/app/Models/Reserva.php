<?php

namespace Modules\Paquete10MesasReservasResenas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Paquete10MesasReservasResenas\Database\Factories\ReservaFactory;

class Reserva extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['mesa_id', 'cliente_nombre', 'fecha', 'hora', 'personas', 'estado'];

    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }

    // protected static function newFactory(): ReservaFactory
    // {
    //     // return ReservaFactory::new();
    // }
}
