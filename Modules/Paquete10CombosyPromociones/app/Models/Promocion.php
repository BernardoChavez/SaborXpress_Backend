<?php

namespace Modules\Paquete10CombosyPromociones\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promocion extends Model
{
    use HasFactory;

    protected $table = 'promociones';

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo_descuento',
        'valor_descuento',
        'fecha_inicio',
        'fecha_fin',
        'dias_aplicables',
        'estado'
    ];

    /**
     * Casteos automáticos de Laravel.
     * Convierte el campo JSON 'dias_aplicables' de la BD a un Array en PHP automáticamente,
     * y asegura que las fechas se traten como objetos Carbon (fechas).
     */
    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'dias_aplicables' => 'array', 
        'estado' => 'boolean'
    ];

    /**
     * Relación: Obtiene los enlaces que indican a qué productos, combos o categorías se aplica esta promoción.
     */
    public function aplicaciones()
    {
        return $this->hasMany(PromocionAplicacion::class, 'promocion_id');
    }
}
