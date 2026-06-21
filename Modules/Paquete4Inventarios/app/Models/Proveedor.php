<?php

namespace Modules\Paquete4Inventarios\Models;

use Modules\Paquete8Compras\Models\OrdenCompra;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';
    protected $fillable = ['nombre', 'telefono', 'correo', 'direccion'];

    public function ordenesCompra()
    {
        return $this->hasMany(OrdenCompra::class, 'id_proveedor');
    }
}
