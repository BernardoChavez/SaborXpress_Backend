<?php

namespace Modules\Paquete10MesasReservasResenas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Paquete10MesasReservasResenas\Database\Factories\ZonaFactory;

class Zona extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['nombre', 'estado'];

    public function mesas()
    {
        return $this->hasMany(Mesa::class)->orderBy('fila', 'asc')->orderBy('id', 'asc');
    }

    // protected static function newFactory(): ZonaFactory
    // {
    //     // return ZonaFactory::new();
    // }
}
