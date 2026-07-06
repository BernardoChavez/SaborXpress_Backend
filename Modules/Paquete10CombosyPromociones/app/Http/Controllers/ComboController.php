<?php

namespace Modules\Paquete10CombosyPromociones\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Paquete10CombosyPromociones\Models\Combo;
use Modules\Paquete10CombosyPromociones\Models\ComboProducto;

class ComboController extends Controller
{
    /**
     * Listar todos los combos con sus productos.
     */
    public function index()
    {
        $combos = Combo::with('productos.producto')->get();
        return response()->json($combos);
    }

    /**
     * Crear un nuevo combo.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'precio_venta' => 'required|numeric',
            'productos' => 'required|array'
        ]);

        $combo = Combo::create($request->only(['nombre', 'descripcion', 'precio_venta', 'imagen', 'estado']));

        // Guardar los productos que componen este combo
        foreach ($request->productos as $prod) {
            ComboProducto::create([
                'combo_id' => $combo->id,
                'producto_id' => $prod['producto_id'],
                'cantidad' => $prod['cantidad'] ?? 1
            ]);
        }

        return response()->json(['message' => 'Combo creado con éxito', 'combo' => $combo->load('productos')], 201);
    }

    /**
     * Mostrar un combo específico.
     */
    public function show($id)
    {
        $combo = Combo::with('productos.producto')->findOrFail($id);
        return response()->json($combo);
    }

    /**
     * Actualizar un combo.
     */
    public function update(Request $request, $id)
    {
        $combo = Combo::findOrFail($id);
        $combo->update($request->only(['nombre', 'descripcion', 'precio_venta', 'imagen', 'estado']));

        // Si envían nueva lista de productos, reemplazamos los antiguos
        if ($request->has('productos')) {
            $combo->productos()->delete();
            foreach ($request->productos as $prod) {
                ComboProducto::create([
                    'combo_id' => $combo->id,
                    'producto_id' => $prod['producto_id'],
                    'cantidad' => $prod['cantidad'] ?? 1
                ]);
            }
        }

        return response()->json(['message' => 'Combo actualizado', 'combo' => $combo->load('productos')]);
    }

    /**
     * Eliminar un combo.
     */
    public function destroy($id)
    {
        $combo = Combo::findOrFail($id);
        $combo->delete();
        return response()->json(['message' => 'Combo eliminado con éxito']);
    }
}
