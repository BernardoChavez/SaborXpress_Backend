<?php

namespace Modules\Paquete10MesasReservasResenas\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Paquete10MesasReservasResenas\Models\Reserva;

class ReservaController extends Controller
{
    public function index()
    {
        $reservas = Reserva::with('mesa.zona')->get();
        return response()->json($reservas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'mesa_id' => 'required|exists:mesas,id',
            'cliente_nombre' => 'required|string',
            'fecha' => 'required|date',
            'hora' => 'required',
            'personas' => 'required|integer'
        ]);
        $reserva = Reserva::create($request->all());
        return response()->json($reserva, 201);
    }

    public function show($id)
    {
        $reserva = Reserva::with('mesa.zona')->findOrFail($id);
        return response()->json($reserva);
    }

    public function update(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->update($request->all());
        return response()->json($reserva);
    }

    public function destroy($id)
    {
        Reserva::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
