<?php

namespace Modules\Paquete4Inventarios\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Paquete1Seguridad\Models\Autenticacion;

class Merma extends Model
{
    protected $table = 'mermas';
    protected $fillable = ['id_producto', 'cantidad', 'motivo', 'id_usuario'];

    public function producto()
    {
        return $this->belongsTo(InventarioProcesado::class, 'id_producto');
    }

    public function usuario()
    {
        return $this->belongsTo(Autenticacion::class, 'id_usuario', 'id_persona');
    }
}
