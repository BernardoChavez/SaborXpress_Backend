<!DOCTYPE html>
<html>
<head>
    <title>Tu Factura</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Hola, {{ $venta->nombre_cliente }}</h2>
    <p>Gracias por tu compra en SaborXpress.</p>
    <p>Adjunto a este correo encontrarás el documento PDF correspondiente a tu factura <strong>N° {{ str_pad($venta->nro_factura, 5, '0', STR_PAD_LEFT) }}</strong> por un total de <strong>Bs. {{ number_format($venta->monto_total, 2) }}</strong>.</p>
    <br>
    <p>Atentamente,</p>
    <p><strong>El equipo de SaborXpress</strong></p>
</body>
</html>
