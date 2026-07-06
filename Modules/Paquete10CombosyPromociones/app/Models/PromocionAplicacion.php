<?php

namespace Modules\Paquete10CombosyPromociones\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PromocionAplicacion extends Model
{
    use HasFactory;

    protected $table = 'promocion_aplicaciones';

    protected $fillable = [
        'promocion_id',
        'aplicable_type',
        'aplicable_id'
    ];

    /**
     * Relación: A qué promoción pertenece esta regla.
     */
    public function promocion()
    {
        return $this->belongsTo(Promocion::class, 'promocion_id');
    }

    /**
     * Relación Polimórfica: Obtiene el modelo dueño (Producto, Combo o Categoría)
     * al que se le aplicará el descuento de manera dinámica.
     */
    public function aplicable()
    {
        return $this->morphTo();
    }
}
