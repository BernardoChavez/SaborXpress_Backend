<?php

namespace Modules\Paquete10CombosyPromociones\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComboProducto extends Model
{
    use HasFactory;

    protected $table = 'combo_productos';

    protected $fillable = [
        'combo_id',
        'producto_id',
        'cantidad'
    ];

    /**
     * Relación: A qué combo pertenece este detalle.
     */
    public function combo()
    {
        return $this->belongsTo(Combo::class, 'combo_id');
    }

    /**
     * Relación: Cuál es el producto físico real (del Paquete 3 Configuración).
     * Nota: Se asume que el namespace de Producto es Modules\Paquete3Configuracion\Models\Producto.
     */
    public function producto()
    {
        // Se usa string para evitar errores si el módulo no está compilado, pero la relación funciona igual
        return $this->belongsTo('Modules\Paquete3Configuracion\Models\Producto', 'producto_id');
    }
}
