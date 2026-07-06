<?php

namespace Modules\Paquete10CombosyPromociones\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Paquete10CombosyPromociones\Models\Promocion;
use Modules\Paquete10CombosyPromociones\Models\PromocionAplicacion;

class PromocionController extends Controller
{
    /**
     * Listar todas las promociones con sus aplicaciones.
     */
    public function index()
    {
        $promociones = Promocion::with('aplicaciones.aplicable')->get();
        return response()->json($promociones);
    }

    /**
     * Crear una nueva promoción.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'tipo_descuento' => 'required|in:porcentaje,monto_fijo,2x1',
            'fecha_inicio' => 'required|date',
            'aplicaciones' => 'required|array'
        ]);

        $promocion = Promocion::create($request->only([
            'nombre', 'descripcion', 'tipo_descuento', 'valor_descuento', 
            'fecha_inicio', 'fecha_fin', 'dias_aplicables', 'estado'
        ]));

        // Guardar a qué entidades (Productos/Combos/Categorias) aplica esta promoción
        foreach ($request->aplicaciones as $aplicacion) {
            PromocionAplicacion::create([
                'promocion_id' => $promocion->id,
                'aplicable_type' => $aplicacion['aplicable_type'], // ej: Modules\Paquete3Configuracion\Models\Producto
                'aplicable_id' => $aplicacion['aplicable_id']
            ]);
        }

        return response()->json(['message' => 'Promoción creada con éxito', 'promocion' => $promocion->load('aplicaciones')], 201);
    }

    /**
     * Mostrar una promoción.
     */
    public function show($id)
    {
        $promocion = Promocion::with('aplicaciones.aplicable')->findOrFail($id);
        return response()->json($promocion);
    }

    /**
     * Actualizar una promoción.
     */
    public function update(Request $request, $id)
    {
        $promocion = Promocion::findOrFail($id);
        $promocion->update($request->only([
            'nombre', 'descripcion', 'tipo_descuento', 'valor_descuento', 
            'fecha_inicio', 'fecha_fin', 'dias_aplicables', 'estado'
        ]));

        if ($request->has('aplicaciones')) {
            $promocion->aplicaciones()->delete();
            foreach ($request->aplicaciones as $aplicacion) {
                PromocionAplicacion::create([
                    'promocion_id' => $promocion->id,
                    'aplicable_type' => $aplicacion['aplicable_type'],
                    'aplicable_id' => $aplicacion['aplicable_id']
                ]);
            }
        }

        return response()->json(['message' => 'Promoción actualizada', 'promocion' => $promocion->load('aplicaciones')]);
    }

    /**
     * Eliminar promoción.
     */
    public function destroy($id)
    {
        $promocion = Promocion::findOrFail($id);
        $promocion->delete();
        return response()->json(['message' => 'Promoción eliminada con éxito']);
    }
}
