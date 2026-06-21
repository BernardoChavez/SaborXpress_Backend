<?php

namespace Modules\Paquete8Compras\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Paquete4Inventarios\Models\InventarioBruto;

class OrdenCompraDetalle extends Model
{
    use HasFactory;

    protected $table = 'orden_compra_detalles';
    protected $fillable = [
        'id_orden_compra',
        'id_bruto',
        'cantidad',
        'precio_unitario',
        'subtotal'
    ];

    public function ordenCompra()
    {
        return $this->belongsTo(OrdenCompra::class, 'id_orden_compra');
    }

    public function bruto()
    {
        return $this->belongsTo(InventarioBruto::class, 'id_bruto');
    }
}
