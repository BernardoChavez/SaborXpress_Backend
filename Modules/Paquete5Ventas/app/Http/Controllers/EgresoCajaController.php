<?php

namespace Modules\Paquete5Ventas\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Paquete5Ventas\Models\Caja;
use Modules\Paquete5Ventas\Models\EgresoCaja;

class EgresoCajaController extends Controller
{
    /**
     * CU32: Registrar egreso de caja chica
     */
    public function store(Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric|gt:0',
            'motivo' => 'required|string|max:255',
        ], [
            'monto.required' => 'El monto es obligatorio.',
            'monto.numeric' => 'El monto debe ser numérico.',
            'monto.gt' => 'El monto debe ser mayor a 0.',
            'motivo.required' => 'El motivo del egreso es obligatorio.',
            'motivo.max' => 'El motivo no puede superar los 255 caracteres.',
        ]);

        $usuarioId = Auth::id();

        // Validar si el usuario tiene una caja abierta
        $caja = Caja::where('id_usuario', $usuarioId)->where('estado', 'Abierta')->first();
        if (!$caja) {
            return response()->json([
                'message' => 'No se puede registrar el egreso. Debes abrir caja primero.'
            ], 403);
        }

        // Crear el egreso
        $egreso = EgresoCaja::create([
            'id_caja' => $caja->id,
            'id_usuario' => $usuarioId,
            'monto' => $request->monto,
            'motivo' => $request->motivo
        ]);

        return response()->json([
            'message' => 'Egreso de caja chica registrado con éxito.',
            'egreso' => $egreso
        ], 201);
    }

    /**
     * Listar egresos de la caja chica
     */
    public function index()
    {
        return EgresoCaja::with(['caja', 'usuario.persona'])
            ->latest()
            ->get();
    }
}
