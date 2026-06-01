<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas - Sabor Xpress</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #334155;
            font-size: 11px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .header {
            border-bottom: 2px solid #f97316;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header table {
            width: 100%;
        }
        .logo {
            font-size: 24px;
            font-weight: 800;
            color: #1e293b;
            font-style: italic;
        }
        .logo span {
            color: #f97316;
        }
        .title {
            text-align: right;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            color: #0f172a;
            letter-spacing: 0.5px;
        }
        .subtitle {
            text-align: right;
            font-size: 10px;
            color: #64748b;
        }
        .info-panel {
            margin-bottom: 20px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px;
        }
        .info-panel table {
            width: 100%;
        }
        .info-panel td {
            font-size: 10px;
        }
        .kpi-container {
            margin-bottom: 20px;
            width: 100%;
            display: block;
        }
        .kpi-box {
            width: 45%;
            display: inline-block;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }
        .kpi-val {
            font-size: 20px;
            font-weight: bold;
            color: #f97316;
            margin-top: 5px;
        }
        .kpi-lbl {
            font-size: 9px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: bold;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .data-table th {
            background-color: #1e293b;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
            padding: 8px 10px;
            text-align: left;
        }
        .data-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        .data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .text-right {
            text-align: right;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-success { background-color: #dcfce7; color: #15803d; }
        .badge-warning { background-color: #fef9c3; color: #a16207; }
        .badge-info { background-color: #e0f2fe; color: #0369a1; }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            border-top: 1px solid #e2e8f0;
            padding-top: 5px;
            text-align: center;
            font-size: 8px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td class="logo" style="width: 50%;">Sabor<span>Xpress</span></td>
                <td class="title" style="width: 50%;">Reporte de Ventas</td>
            </tr>
            <tr>
                <td style="width: 50%;">Sistema POS e Inventarios</td>
                <td class="subtitle" style="width: 50%;">Generado el: {{ date('d/m/Y H:i:s') }}</td>
            </tr>
        </table>
    </div>

    <div class="info-panel">
        <table style="width: 100%;">
            <tr>
                <td style="width: 30%;"><strong>Filtros Aplicados:</strong></td>
                <td class="text-right" style="width: 70%;">
                    Rango: 
                    @if($fechaInicio || $fechaFin)
                        {{ $fechaInicio ?? 'Inicio' }} al {{ $fechaFin ?? 'Hoy' }}
                    @else
                        Todo el Historial
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="kpi-container">
        <div class="kpi-box" style="margin-right: 4%;">
            <div class="kpi-lbl">Total Recaudado</div>
            <div class="kpi-val">{{ number_format($ventas->sum('monto_total'), 2) }} Bs.</div>
        </div>
        <div class="kpi-box">
            <div class="kpi-lbl">Transacciones Consolidadas</div>
            <div class="kpi-val">{{ $ventas->count() }} órdenes</div>
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pedido</th>
                <th>Fecha/Hora</th>
                <th>Cajero</th>
                <th>Pago</th>
                <th>Entrega</th>
                <th>Estado</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
                <tr>
                    <td>#{{ $venta->id }}</td>
                    <td>{{ $venta->nro_pedido }}</td>
                    <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $venta->usuario->persona->nombre ?? 'Sistema' }}</td>
                    <td>{{ $venta->metodo_pago }}</td>
                    <td>{{ $venta->tipo_entrega }}</td>
                    <td>
                        <span class="badge badge-success">{{ $venta->estado }}</span>
                    </td>
                    <td class="text-right"><strong>{{ number_format($venta->monto_total, 2) }}</strong> Bs.</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Sabor Xpress POS - Documento Operativo Confidencial
    </div>
</body>
</html>
