<?php

namespace Modules\Paquete5Ventas\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Paquete1Seguridad\Models\Autenticacion;

class EgresoCaja extends Model
{
    protected $table = 'egresos_caja';
    protected $fillable = [
        'id_caja',
        'id_usuario',
        'monto',
        'motivo'
    ];

    public function caja()
    {
        return $this->belongsTo(Caja::class, 'id_caja');
    }

    public function usuario()
    {
        return $this->belongsTo(Autenticacion::class, 'id_usuario', 'id_persona');
    }
}
