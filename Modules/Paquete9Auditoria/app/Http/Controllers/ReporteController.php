<?php

namespace Modules\Paquete9Auditoria\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Paquete5Ventas\Models\Venta;
use Modules\Paquete4Inventarios\Models\InventarioBruto;
use Modules\Paquete4Inventarios\Models\InventarioProcesado;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
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

    /**
     * CU36 y CU34: Reporte Dinámico (Gráficos)
     */
    public function reporteDinamico()
    {
        // 1. Ventas de los últimos 7 días
        $ventasUltimosDias = Venta::select(
                DB::raw('DATE(created_at) as fecha'),
                DB::raw('SUM(monto_total) as total')
            )
            ->where('created_at', '>=', now()->subDays(7))
            ->where('estado', '!=', 'Cancelado')
            ->groupBy('fecha')
            ->orderBy('fecha', 'asc')
            ->get();

        // 2. Ventas por método de pago
        $ventasPorMetodo = Venta::select(
                'metodo_pago as nombre',
                DB::raw('COUNT(*) as cantidad'),
                DB::raw('SUM(monto_total) as total')
            )
            ->where('estado', '!=', 'Cancelado')
            ->groupBy('metodo_pago')
            ->get();

        // 3. Productos más vendidos
        $productosTop = DB::table('venta_detalles')
            ->join('ventas', 'venta_detalles.id_venta', '=', 'ventas.id')
            ->join('producto', 'venta_detalles.id_producto', '=', 'producto.id')
            ->select('producto.nombre', DB::raw('SUM(venta_detalles.cantidad) as total_vendido'))
            ->where('ventas.estado', '!=', 'Cancelado')
            ->groupBy('producto.id', 'producto.nombre')
            ->orderByDesc('total_vendido')
            ->limit(5)
            ->get();

        // 4. Inventario Crítico
        $criticoBruto = InventarioBruto::whereColumn('stock', '<=', 'stock_minimo')
            ->select('nombre', 'stock', 'stock_minimo', 'unidad_medida', DB::raw("'Materia Prima' as tipo"))
            ->get();
            
        $criticoProcesado = InventarioProcesado::whereColumn('stock', '<=', 'stock_minimo')
            ->select('nombre', 'stock', 'stock_minimo', 'unidad_medida', DB::raw("'Procesado' as tipo"))
            ->get();
            
        $inventarioCritico = $criticoBruto->concat($criticoProcesado);

        return response()->json([
            'ventas_dias' => $ventasUltimosDias,
            'ventas_metodos' => $ventasPorMetodo,
            'productos_top' => $productosTop,
            'inventario_critico' => $inventarioCritico
        ]);
    }

    /**
     * CU33: Reporte de Rentabilidad
     */
    public function rentabilidad()
    {
        // En un escenario real, cruzaríamos VentaDetalle -> Recetas -> Inventario (Costo).
        // Por simplicidad, tomaremos un costo estimado de los productos basado en un porcentaje.
        // Simularemos los márgenes basados en los ingresos actuales.
        
        $ventasTotales = Venta::where('estado', '!=', 'Cancelado')->sum('monto_total');
        
        // Simulación de costos para el prototipo (aprox 40% del precio de venta es costo de materia prima)
        $costoMateriaPrima = $ventasTotales * 0.40;
        
        $utilidadBruta = $ventasTotales - $costoMateriaPrima;
        $margen = $ventasTotales > 0 ? ($utilidadBruta / $ventasTotales) * 100 : 0;

        return response()->json([
            'ingresos_totales' => number_format($ventasTotales, 2, '.', ''),
            'costos_materia_prima' => number_format($costoMateriaPrima, 2, '.', ''),
            'utilidad_bruta' => number_format($utilidadBruta, 2, '.', ''),
            'margen_rentabilidad' => number_format($margen, 2, '.', '')
        ]);
    }
}
