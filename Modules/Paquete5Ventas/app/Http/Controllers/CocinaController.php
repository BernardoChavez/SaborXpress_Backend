<?php
 
namespace Modules\Paquete5Ventas\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Paquete5Ventas\Models\Comanda;
 
class CocinaController extends Controller
{
    /**
     * Listar comandas pendientes y en preparación
     */
    public function index()
    {
        return Comanda::with(['venta.detalles.producto'])
            ->whereIn('estado', ['Pendiente', 'En preparación', 'Listo'])
            ->orderBy('created_at', 'asc')
            ->get();
    }
 
    /**
     * Actualizar estado de la comanda (CU22)
     */
    public function updateEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:Pendiente,En preparación,Listo,Entregado,Anulado'
        ]);

        $comanda = Comanda::findOrFail($id);
        $comanda->update(['estado' => $request->estado]);

        // CU21 / CU20: Sync comanda preparation state to Venta for real-time tracking
        if (in_array($request->estado, ['Pendiente', 'En preparación', 'Listo'])) {
            $comanda->venta()->update(['VentaEstado' => $request->estado]);
        }

        return response()->json([
            'message' => 'Estado de comanda actualizado con éxito.',
            'comanda' => $comanda->load('venta')
        ]);
    }
}
