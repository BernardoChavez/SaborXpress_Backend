<?php

namespace Modules\Paquete10MesasReservasResenas\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Paquete10MesasReservasResenas\Models\Resena;

class ResenaController extends Controller
{
    public function index()
    {
        $resenas = Resena::with('venta')->orderBy('created_at', 'desc')->get();
        
        $promedio = Resena::avg('calificacion') ?? 0;
        $total = Resena::count();

        return response()->json([
            'resenas' => $resenas,
            'estadisticas' => [
                'promedio' => round($promedio, 1),
                'total' => $total
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'venta_id' => 'required|exists:ventas,id',
            'calificacion' => 'required|integer|min:1|max:5'
        ]);
        
        // Verifica si ya existe reseña para esa venta
        if (Resena::where('venta_id', $request->venta_id)->exists()) {
            return response()->json(['message' => 'Esta factura ya fue calificada.'], 400);
        }

        $resena = Resena::create($request->all());
        return response()->json($resena, 201);
    }

    public function show($id)
    {
        $resena = Resena::with('venta')->findOrFail($id);
        return response()->json($resena);
    }

    public function update(Request $request, $id)
    {
        $resena = Resena::findOrFail($id);
        $resena->update($request->only(['leido', 'calificacion', 'comentario']));
        return response()->json($resena);
    }

    public function destroy($id)
    {
        Resena::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
