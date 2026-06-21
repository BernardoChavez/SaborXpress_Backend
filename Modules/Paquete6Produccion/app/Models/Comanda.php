<?php
 
namespace Modules\Paquete6Produccion\Models;
 
use Modules\Paquete5Ventas\Models\Venta;
use Illuminate\Database\Eloquent\Model;
 
class Comanda extends Model
{
    protected $table = 'comandas';
    protected $fillable = ['id_venta', 'estado', 'area'];
 
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id_venta');
    }
}
