<?php

namespace Modules\Paquete10MesasReservasResenas\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Paquete10MesasReservasResenas\Models\Mesa;

class MesaController extends Controller
{
    public function index()
    {
        $mesas = Mesa::with(['zona', 'reservas'])->orderBy('fila', 'asc')->orderBy('id', 'asc')->get();
        return response()->json($mesas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'zona_id' => 'required|exists:zonas,id',
            'numero' => 'required|string',
            'capacidad' => 'required|integer'
        ]);
        $mesa = Mesa::create($request->all());
        return response()->json($mesa, 201);
    }

    public function show($id)
    {
        $mesa = Mesa::with(['zona', 'reservas'])->findOrFail($id);
        return response()->json($mesa);
    }

    public function update(Request $request, $id)
    {
        $mesa = Mesa::findOrFail($id);
        $mesa->update($request->all());
        return response()->json($mesa);
    }

    public function destroy($id)
    {
        Mesa::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
