<?php

namespace Modules\Paquete5Ventas\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Paquete5Ventas\Models\Venta;
use Modules\Paquete4Inventarios\Models\InventarioBruto;
use Modules\Paquete4Inventarios\Models\InventarioProcesado;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    /**
     * CU36: Reporte de Ventas en formato CSV (compatible con Excel)
     */
    public function reporteVentasCSV(Request $request)
    {
        $fechaInicio = $request->query('fecha_inicio');
        $fechaFin = $request->query('fecha_fin');

        $query = Venta::with(['usuario.persona', 'comanda']);

        if ($fechaInicio) {
            $query->whereDate('created_at', '>=', $fechaInicio);
        }
        if ($fechaFin) {
            $query->whereDate('created_at', '<=', $fechaFin);
        }

        $ventas = $query->latest()->get();

        $filename = "reporte_ventas_" . date('Ymd_His') . ".csv";

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($ventas) {
            $file = fopen('php://output', 'w');
            
            // Añadir el BOM de UTF-8 para compatibilidad con Excel en español
            fwrite($file, "\xEF\xBB\xBF");
            
            // Cabeceras de columnas
            fputcsv($file, [
                'ID Venta', 
                'Nro Pedido', 
                'Fecha', 
                'Cajero', 
                'Método de Pago', 
                'Tipo Entrega', 
                'Estado Venta', 
                'Estado Comanda', 
                'Total (Bs.)'
            ], ';');

            foreach ($ventas as $venta) {
                fputcsv($file, [
                    $venta->id,
                    $venta->nro_pedido,
                    $venta->created_at->format('Y-m-d H:i:s'),
                    $venta->usuario->persona->nombre ?? 'Sistema',
                    $venta->metodo_pago,
                    $venta->tipo_entrega,
                    $venta->estado,
                    $venta->comanda->estado ?? 'N/A',
                    number_format($venta->monto_total, 2)
                ], ';');
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * CU36: Reporte de Niveles de Inventario en formato CSV
     */
    public function reporteInventarioCSV()
    {
        $inventarioBruto = InventarioBruto::all();
        $inventarioProcesado = InventarioProcesado::all();

        $filename = "reporte_inventario_" . date('Ymd_His') . ".csv";

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($inventarioBruto, $inventarioProcesado) {
            $file = fopen('php://output', 'w');
            
            // Añadir el BOM de UTF-8
            fwrite($file, "\xEF\xBB\xBF");
            
            fputcsv($file, [
                'ID', 
                'Tipo Insumo', 
                'Nombre', 
                'Stock Actual', 
                'Unidad de Medida', 
                'Stock Mínimo', 
                'Estado Alerta'
            ], ';');

            // Materia Prima
            foreach ($inventarioBruto as $item) {
                $alerta = ($item->stock <= $item->stock_minimo) ? 'Bajo Stock' : 'Normal';
                fputcsv($file, [
                    $item->id,
                    'Materia Prima (Bruto)',
                    $item->nombre,
                    number_format($item->stock, 2),
                    $item->unidad_medida,
                    number_format($item->stock_minimo, 2),
                    $alerta
                ], ';');
            }

            // Insumos Cocina
            foreach ($inventarioProcesado as $item) {
                $alerta = ($item->stock <= $item->stock_minimo) ? 'Bajo Stock' : 'Normal';
                fputcsv($file, [
                    $item->id,
                    'Cocina (Procesado)',
                    $item->nombre,
                    number_format($item->stock, 2),
                    $item->unidad_medida,
                    number_format($item->stock_minimo, 2),
                    $alerta
                ], ';');
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * CU36: Reporte de Ventas en formato PDF
     */
    public function reporteVentasPDF(Request $request)
    {
        $fechaInicio = $request->query('fecha_inicio');
        $fechaFin = $request->query('fecha_fin');

        $query = Venta::with(['usuario.persona', 'comanda']);

        if ($fechaInicio) {
            $query->whereDate('created_at', '>=', $fechaInicio);
        }
        if ($fechaFin) {
            $query->whereDate('created_at', '<=', $fechaFin);
        }

        $ventas = $query->latest()->get();

        $pdf = Pdf::loadView('reportes.ventas_pdf', compact('ventas', 'fechaInicio', 'fechaFin'));
        
        return $pdf->download('reporte_ventas_' . date('Ymd_His') . '.pdf');
    }

    /**
     * CU36: Reporte de Inventario en formato PDF
     */
    public function reporteInventarioPDF()
    {
        $inventarioBruto = InventarioBruto::all();
        $inventarioProcesado = InventarioProcesado::all();

        $pdf = Pdf::loadView('reportes.inventario_pdf', compact('inventarioBruto', 'inventarioProcesado'));

        return $pdf->download('reporte_inventario_' . date('Ymd_His') . '.pdf');
    }
}
