<?php

namespace Modules\Paquete10MesasReservasResenas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Paquete10MesasReservasResenas\Database\Factories\MesaFactory;

class Mesa extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['zona_id', 'numero', 'capacidad', 'estado', 'fila', 'reserva_nombre', 'reserva_telefono', 'reserva_hora'];

    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    // protected static function newFactory(): MesaFactory
    // {
    //     // return MesaFactory::new();
    // }
}
