<?php

namespace Modules\Paquete10CombosyPromociones\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Combo extends Model
{
    use HasFactory;

    protected $table = 'combos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_venta',
        'imagen',
        'estado'
    ];

    /**
     * Relación: Un combo tiene muchos productos que lo componen.
     * Esta función permite acceder a los detalles del combo para descontar inventario o mostrarlos.
     */
    public function productos()
    {
        return $this->hasMany(ComboProducto::class, 'combo_id');
    }
    
    /**
     * Relación Polimórfica Inversa: Un combo puede tener promociones aplicadas a él.
     * Por ejemplo, "Descuento del 10% en el Combo Familiar".
     */
    public function promocionesAplicadas()
    {
        return $this->morphMany(PromocionAplicacion::class, 'aplicable');
    }
}
