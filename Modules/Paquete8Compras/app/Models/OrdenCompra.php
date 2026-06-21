<?php

namespace Modules\Paquete8Compras\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Paquete1Seguridad\Models\Autenticacion;
use Modules\Paquete4Inventarios\Models\Proveedor;

class OrdenCompra extends Model
{
    use HasFactory;

    protected $table = 'ordenes_compra';
    protected $fillable = [
        'id_proveedor',
        'id_usuario',
        'monto_total',
        'estado',
        'fecha_orden',
        'fecha_recepcion'
    ];

    protected $casts = [
        'fecha_orden' => 'datetime',
        'fecha_recepcion' => 'datetime',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function usuario()
    {
        return $this->belongsTo(Autenticacion::class, 'id_usuario', 'id_persona');
    }

    public function detalles()
    {
        return $this->hasMany(OrdenCompraDetalle::class, 'id_orden_compra');
    }
}
