<?php

namespace Modules\Paquete4Inventarios\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Paquete4Inventarios\Models\Proveedor;

class ProveedorController extends Controller
{
    public function index()
    {
        return Proveedor::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:100',
            'direccion' => 'nullable|string|max:200'
        ], [
            'nombre.required' => 'El nombre del proveedor es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres.',
            'correo.email' => 'El formato del correo electrónico no es válido.',
            'correo.max' => 'El correo no puede superar los 100 caracteres.',
            'telefono.max' => 'El teléfono no puede superar los 20 caracteres.',
            'direccion.max' => 'La dirección no puede superar los 200 caracteres.'
        ]);

        $proveedor = Proveedor::create($validated);

        return response()->json([
            'message' => 'Proveedor registrado con éxito.',
            'proveedor' => $proveedor
        ], 201);
    }

    public function show($id)
    {
        $proveedor = Proveedor::find($id);

        if (!$proveedor) {
            return response()->json(['message' => 'Proveedor no encontrado.'], 404);
        }

        return response()->json($proveedor, 200);
    }

    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::find($id);

        if (!$proveedor) {
            return response()->json(['message' => 'Proveedor no encontrado.'], 404);
        }

        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:100',
            'direccion' => 'nullable|string|max:200'
        ], [
            'nombre.required' => 'El nombre del proveedor es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres.',
            'correo.email' => 'El formato del correo electrónico no es válido.',
            'correo.max' => 'El correo no puede superar los 100 caracteres.',
            'telefono.max' => 'El teléfono no puede superar los 20 caracteres.',
            'direccion.max' => 'La dirección no puede superar los 200 caracteres.'
        ]);

        $proveedor->update($validated);

        return response()->json([
            'message' => 'Proveedor actualizado con éxito.',
            'proveedor' => $proveedor
        ], 200);
    }

    public function destroy($id)
    {
        $proveedor = Proveedor::find($id);

        if (!$proveedor) {
            return response()->json(['message' => 'Proveedor no encontrado.'], 404);
        }

        // Evitar eliminar proveedores con órdenes de compra asociadas
        if ($proveedor->ordenesCompra()->exists()) {
            return response()->json([
                'message' => 'No se puede eliminar el proveedor porque tiene órdenes de compra asociadas.'
            ], 400);
        }

        $proveedor->delete();

        return response()->json(['message' => 'Proveedor eliminado correctamente.'], 200);
    }
}
