<?php

namespace Modules\Paquete11ServiciosEspeciales\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Paquete11ServiciosEspeciales\Models\CateringServicio;
use Illuminate\Support\Facades\DB;

class CateringServicioController extends Controller
{
    public function index(Request $request)
    {
        $query = CateringServicio::with('detalles.producto')->orderBy('created_at', 'desc');

        if ($request->filled('estado') && $request->estado !== 'Todos') {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('cliente', 'like', "%{$search}%");
            });
        }

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha_evento', [$request->fecha_inicio, $request->fecha_fin]);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente' => 'required|string',
            'telefono' => 'nullable|string',
            'fecha_evento' => 'required|date',
            'hora_evento' => 'required',
            'modalidad' => 'required|string|in:Recoger en Restaurante,Servicio Externo',
            'direccion' => 'nullable|string',
            'cantidad_personas' => 'required|integer',
            'observaciones' => 'nullable|string',
            'detalles' => 'required|array|min:1',
            'detalles.*.producto_id' => 'required|exists:producto,id',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_unitario' => 'required|numeric'
        ]);

        DB::beginTransaction();
        try {
            // Generate Code CAT-0001
            $lastId = CateringServicio::max('id') ?? 0;
            $codigo = 'CAT-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

            $precio_total = 0;
            foreach ($request->detalles as $det) {
                $precio_total += ($det['cantidad'] * $det['precio_unitario']);
            }

            $servicio = CateringServicio::create(array_merge(
                $request->only(['cliente', 'telefono', 'fecha_evento', 'hora_evento', 'modalidad', 'direccion', 'cantidad_personas', 'observaciones']),
                ['codigo' => $codigo, 'precio_total' => $precio_total, 'estado' => 'Pendiente']
            ));

            foreach ($request->detalles as $det) {
                $servicio->detalles()->create([
                    'producto_id' => $det['producto_id'],
                    'cantidad' => $det['cantidad'],
                    'precio_unitario' => $det['precio_unitario'],
                    'subtotal' => $det['cantidad'] * $det['precio_unitario']
                ]);
            }

            DB::commit();
            return response()->json($servicio->load('detalles.producto'), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al registrar', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $servicio = CateringServicio::with('detalles.producto')->findOrFail($id);
        return response()->json($servicio);
    }

    public function update(Request $request, $id)
    {
        $servicio = CateringServicio::findOrFail($id);

        $validated = $request->validate([
            'cliente' => 'required|string',
            'telefono' => 'nullable|string',
            'fecha_evento' => 'required|date',
            'hora_evento' => 'required',
            'modalidad' => 'required|string|in:Recoger en Restaurante,Servicio Externo',
            'direccion' => 'nullable|string',
            'cantidad_personas' => 'required|integer',
            'observaciones' => 'nullable|string',
            'detalles' => 'required|array|min:1',
            'detalles.*.producto_id' => 'required|exists:producto,id',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_unitario' => 'required|numeric'
        ]);

        DB::beginTransaction();
        try {
            $precio_total = 0;
            foreach ($request->detalles as $det) {
                $precio_total += ($det['cantidad'] * $det['precio_unitario']);
            }

            $servicio->update(array_merge(
                $request->only(['cliente', 'telefono', 'fecha_evento', 'hora_evento', 'modalidad', 'direccion', 'cantidad_personas', 'observaciones']),
                ['precio_total' => $precio_total]
            ));

            $servicio->detalles()->delete();
            foreach ($request->detalles as $det) {
                $servicio->detalles()->create([
                    'producto_id' => $det['producto_id'],
                    'cantidad' => $det['cantidad'],
                    'precio_unitario' => $det['precio_unitario'],
                    'subtotal' => $det['cantidad'] * $det['precio_unitario']
                ]);
            }

            DB::commit();
            return response()->json($servicio->load('detalles.producto'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al actualizar', 'error' => $e->getMessage()], 500);
        }
    }

    public function changeState(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|string|in:Pendiente,Confirmado,En preparación,Entregado,Cancelado'
        ]);

        $servicio = CateringServicio::findOrFail($id);
        $servicio->update(['estado' => $request->estado]);
        return response()->json($servicio);
    }

    public function destroy($id)
    {
        $servicio = CateringServicio::findOrFail($id);
        $servicio->delete();
        return response()->json(['message' => 'Eliminado exitosamente']);
    }
}
