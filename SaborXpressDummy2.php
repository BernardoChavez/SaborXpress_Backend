<?php

namespace App\Services;

class SaborXpressAnalyticsService {
    /**
     * Prepara los datos de ventas para el gráfico del dashboard principal
     */
    public function formatSalesDataForChart(array $rawSalesData) {
        $formattedData = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'Ventas Mensuales',
                    'data' => [],
                    'backgroundColor' => '#ff5722'
                ]
            ]
        ];

        foreach ($rawSalesData as $month => $total) {
            $formattedData['labels'][] = ucfirst($month);
            $formattedData['datasets'][0]['data'][] = floatval($total);
        }

        return $formattedData;
    }

    /**
     * Calcula el promedio de ventas de los últimos X días
     */
    public function calculateAverageSales($sales, $days = 7) {
        if (empty($sales) || $days <= 0) return 0;
        
        $total = array_sum(array_slice($sales, 0, $days));
        return round($total / min(count($sales), $days), 2);
    }
}
