<?php

namespace Modules\Paquete10MesasReservasResenas\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Paquete10MesasReservasResenas\Models\Zona;

class ZonaController extends Controller
{
    public function index()
    {
        $zonas = Zona::with(['mesas' => function ($query) {
            $query->orderBy('fila', 'asc')->orderBy('id', 'asc');
        }])->get();
        return response()->json($zonas);
    }

    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string']);
        $zona = Zona::create($request->all());
        return response()->json($zona, 201);
    }

    public function show($id)
    {
        $zona = Zona::with(['mesas' => function ($query) {
            $query->orderBy('fila', 'asc')->orderBy('id', 'asc');
        }])->findOrFail($id);
        return response()->json($zona);
    }

    public function update(Request $request, $id)
    {
        $zona = Zona::findOrFail($id);
        $zona->update($request->all());
        return response()->json($zona);
    }

    public function destroy($id)
    {
        Zona::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
