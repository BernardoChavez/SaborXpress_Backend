<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Inventario - Sabor Xpress</title>
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
            border-bottom: 2px solid #10b981;
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
            color: #10b981;
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
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #1e293b;
            margin-top: 25px;
            margin-bottom: 10px;
            text-transform: uppercase;
            border-left: 3px solid #10b981;
            padding-left: 8px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
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
        .badge-danger { background-color: #fee2e2; color: #b91c1c; }
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
                <td class="title" style="width: 50%;">Estado de Inventario</td>
            </tr>
            <tr>
                <td style="width: 50%;">Sistema POS e Inventarios</td>
                <td class="subtitle" style="width: 50%;">Generado el: {{ date('d/m/Y H:i:s') }}</td>
            </tr>
        </table>
    </div>

    <div class="section-title">Materia Prima (Inventario Bruto)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th class="text-right">Stock Actual</th>
                <th>Unidad</th>
                <th class="text-right">Stock Mínimo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventarioBruto as $item)
                @php
                    $bajoStock = $item->stock <= $item->stock_minimo;
                @endphp
                <tr>
                    <td>#{{ $item->id }}</td>
                    <td><strong>{{ $item->nombre }}</strong></td>
                    <td class="text-right">{{ number_format($item->stock, 2) }}</td>
                    <td>{{ $item->unidad_medida }}</td>
                    <td class="text-right">{{ number_format($item->stock_minimo, 2) }}</td>
                    <td>
                        @if($bajoStock)
                            <span class="badge badge-danger">Bajo Stock</span>
                        @else
                            <span class="badge badge-success">Normal</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Insumos de Cocina (Inventario Procesado)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th class="text-right">Stock Actual</th>
                <th>Unidad</th>
                <th class="text-right">Stock Mínimo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventarioProcesado as $item)
                @php
                    $bajoStock = $item->stock <= $item->stock_minimo;
                @endphp
                <tr>
                    <td>#{{ $item->id }}</td>
                    <td><strong>{{ $item->nombre }}</strong></td>
                    <td class="text-right">{{ number_format($item->stock, 2) }}</td>
                    <td>{{ $item->unidad_medida }}</td>
                    <td class="text-right">{{ number_format($item->stock_minimo, 2) }}</td>
                    <td>
                        @if($bajoStock)
                            <span class="badge badge-danger">Bajo Stock</span>
                        @else
                            <span class="badge badge-success">Normal</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Sabor Xpress POS - Documento Operativo Confidencial
    </div>
</body>
</html>
