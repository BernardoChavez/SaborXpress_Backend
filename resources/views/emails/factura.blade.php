<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Factura Digital - SaborXpress</title>
    <style>
        body,
        table,
        td,
        p,
        a,
        li,
        blockquote {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }
    </style>
</head>

<body style="margin: 0; padding: 0; background-color: #f1f5f9; color: #334155;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%"
        style="background-color: #f1f5f9; padding: 40px 15px;">
        <tr>
            <td align="center">
                <!-- Contenedor Principal (600px max) -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%"
                    style="max-width: 600px; background-color: #ffffff; border-radius: 24px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); overflow: hidden; border: 1px solid #e2e8f0;">

                    <!-- Header Banner -->
                    <tr>
                        <td align="center" style="background-color: #0f172a; padding: 35px 20px; text-align: center;">
                            <h1
                                style="margin: 0; color: #ffffff; font-size: 30px; font-weight: 900; letter-spacing: -0.5px;">
                                Sabor<span style="color: #ff5722;">Xpress</span>
                            </h1>
                            <p
                                style="margin: 6px 0 0 0; color: #94a3b8; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 2px;">
                                Facturación Digital
                            </p>
                        </td>
                    </tr>

                    <!-- Cuerpo del Mensaje -->
                    <tr>
                        <td style="padding: 40px 35px;">

                            <p style="margin: 0 0 16px 0; font-size: 20px; color: #0f172a; font-weight: 800;">
                                ¡Hola, {{ $venta->nombre_cliente ?? 'Cliente Valioso' }}!
                            </p>

                            <p style="margin: 0 0 24px 0; font-size: 15px; line-height: 1.6; color: #475569;">
                                Gracias por tu compra en SaborXpress. Hemos procesado tu pago exitosamente y tu factura
                                electrónica ya se encuentra generada.
                            </p>

                            <!-- Tarjeta de Factura Digital -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 18px; margin-bottom: 30px;">
                                <tr>
                                    <td align="center" style="padding: 24px;">
                                        <span
                                            style="display: inline-block; background-color: #e2e8f0; color: #475569; font-size: 11px; font-weight: 800; padding: 5px 14px; border-radius: 9999px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">
                                            FACTURA N° {{ str_pad($venta->nro_factura, 5, '0', STR_PAD_LEFT) }}
                                        </span>
                                        <p style="margin: 0; color: #64748b; font-size: 13px; font-weight: 600;">Importe
                                            Total Pagado</p>
                                        <h2
                                            style="margin: 6px 0 12px 0; color: #0f172a; font-size: 32px; font-weight: 900;">
                                            {{ number_format($venta->monto_total, 2) }} Bs.
                                        </h2>
                                        <div
                                            style="border-top: 1px dashed #cbd5e1; padding-top: 12px; margin-top: 4px;">
                                            <p style="margin: 0; color: #0f172a; font-size: 13px; font-weight: 600;">
                                                Documento PDF adjunto a este correo.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <p
                                style="margin: 0; font-size: 15px; color: #475569; text-align: center; font-weight: 600;">
                                ¡Esperamos verte pronto de nuevo por aquí!
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #0f172a; padding: 30px 20px; text-align: center;">
                            <p style="margin: 0 0 8px 0; color: #ffffff; font-weight: 800; font-size: 16px;">
                                SaborXpress
                            </p>
                            <p style="margin: 0 0 16px 0; color: #94a3b8; font-size: 13px;">
                                La mejor experiencia gastronómica directo a tu mesa.
                            </p>
                            <div style="height: 1px; background-color: #1e293b; margin: 16px auto; max-width: 200px;">
                            </div>
                            <p style="margin: 0; color: #475569; font-size: 11px;">
                                &copy; {{ date('Y') }} SaborXpress. Todos los derechos reservados.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>