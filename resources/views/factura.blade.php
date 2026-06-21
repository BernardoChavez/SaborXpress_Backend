<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura N° {{ str_pad($venta->nro_factura, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .header-table td {
            vertical-align: top;
        }
        .empresa-info {
            width: 60%;
        }
        .factura-info {
            width: 40%;
            text-align: right;
        }
        .empresa-nombre {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .factura-box {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
            text-align: left;
            width: 100%;
        }
        .factura-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
            margin: 20px 0 10px 0;
        }
        .client-info {
            margin-bottom: 20px;
        }
        .client-info table {
            width: 100%;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th {
            background-color: #f5f5f5;
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
            padding: 8px;
            text-align: left;
        }
        .items-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .text-right {
            text-align: right !important;
        }
        .text-center {
            text-align: center !important;
        }
        .totals-table {
            width: 100%;
            margin-bottom: 30px;
        }
        .totals-table td {
            padding: 5px 8px;
        }
        .total-row {
            font-weight: bold;
            font-size: 14px;
        }
        .literal {
            font-style: italic;
            color: #555;
        }
        .footer {
            text-align: center;
            font-size: 9px;
            color: #666;
            margin-top: 50px;
            line-height: 1.4;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td class="empresa-info">
                <div class="empresa-nombre">{{ $empresa->nombre }} / {{ $empresa->sucursal ?? 'CASA MATRIZ' }}</div>
                <div>{{ $empresa->direccion }}</div>
                <div>Teléfono: {{ $empresa->telefono ?? '-' }}</div>
                <div>{{ $empresa->ciudad ?? 'SANTA CRUZ' }} - BOLIVIA</div>
            </td>
            <td class="factura-info">
                <div class="factura-box">
                    <div><strong>NIT:</strong> {{ $empresa->nit }}</div>
                    <div><strong>FACTURA N°:</strong> {{ str_pad($venta->nro_factura, 5, '0', STR_PAD_LEFT) }}</div>
                    <div style="word-break: break-all;"><strong>CÓD. AUTORIZACIÓN:</strong> <br>{{ $empresa->codigo_autorizacion ?? '-' }}</div>
                </div>
            </td>
        </tr>
    </table>

    <div class="factura-title">FACTURA</div>
    <div class="text-center" style="font-size: 10px; margin-bottom: 20px;">(Con Derecho a Crédito Fiscal)</div>

    <div class="client-info">
        <table>
            <tr>
                <td width="15%"><strong>Fecha:</strong></td>
                <td width="55%">{{ $venta->created_at->format('d/m/Y h:i A') }}</td>
                <td width="10%"><strong>NIT/CI:</strong></td>
                <td width="20%">{{ $venta->nit_cliente }}</td>
            </tr>
            <tr>
                <td><strong>Señor(es):</strong></td>
                <td colspan="3">{{ $venta->nombre_cliente }}</td>
            </tr>
        </table>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th width="15%" class="text-center">CANTIDAD</th>
                <th width="50%">DETALLE</th>
                <th width="15%" class="text-right">PRECIO UNIT.</th>
                <th width="20%" class="text-right">SUB TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta->detalles as $detalle)
            <tr>
                <td class="text-center">{{ $detalle->cantidad }}</td>
                <td>{{ $detalle->producto->nombre ?? 'Producto' }}</td>
                <td class="text-right">{{ number_format($detalle->precio_unitario, 2) }}</td>
                <td class="text-right">{{ number_format($detalle->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals-table">
        <tr>
            <td width="65%" class="literal">Son: {{ NumberFormatter::create('es', NumberFormatter::SPELLOUT)->format($venta->monto_total) }} {{ $empresa->moneda ?? 'Bs.' }}</td>
            <td width="15%" class="text-right"><strong>Subtotal:</strong></td>
            <td width="20%" class="text-right">{{ number_format($venta->monto_total, 2) }}</td>
        </tr>
        <tr>
            <td></td>
            <td class="text-right total-row">TOTAL A PAGAR:</td>
            <td class="text-right total-row">{{ number_format($venta->monto_total, 2) }}</td>
        </tr>
    </table>

    <div class="footer">
        <p><strong>ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS, EL USO ILÍCITO SERÁ SANCIONADO PENALMENTE DE ACUERDO A LEY</strong></p>
        <p>{{ $empresa->leyenda_factura ?? 'Ley N° 453: La interrupción del servicio debe comunicarse con anterioridad a las Autoridades que correspondan y a los usuarios afectados.' }}</p>
        <p>Este documento es la Representación Gráfica de un Documento Fiscal Digital emitido en una modalidad de facturación en línea</p>
    </div>

</body>
</html>
