<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Contrato - Grupo Vivencia</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f5f5;
        color: #333;
        line-height: 1.6;
    }

    .container {
        max-width: 600px;
        margin: 0 auto;
        background-color: #ffffff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .header {
        background: linear-gradient(135deg, #1a4e9b 0%, #15396b 100%);
        color: white;
        padding: 40px 20px;
        text-align: center;
    }

    .header img {
        max-width: 150px;
        height: auto;
        margin-bottom: 15px;
    }

    .header h1 {
        font-size: 28px;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .header p {
        font-size: 14px;
        opacity: 0.95;
    }

    .body {
        padding: 40px 30px;
    }

    .greeting {
        font-size: 18px;
        margin-bottom: 20px;
        color: #1a4e9b;
        font-weight: 600;
    }

    .message {
        font-size: 14px;
        color: #555;
        margin-bottom: 30px;
        line-height: 1.8;
    }

    .contract-details {
        background-color: #f9f9f9;
        border-left: 4px solid #1a4e9b;
        padding: 20px;
        margin-bottom: 30px;
        border-radius: 4px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #e0e0e0;
        font-size: 14px;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: #1a4e9b;
        width: 40%;
    }

    .detail-value {
        color: #333;
        text-align: right;
        word-break: break-word;
    }

    .status-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-top: 10px;
    }

    .status-reserva {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-inicial {
        background-color: #cfe2ff;
        color: #084298;
    }

    .status-contado {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .info-box {
        background-color: #e7f3ff;
        border: 1px solid #b3d9ff;
        border-radius: 4px;
        padding: 15px;
        margin-bottom: 20px;
        font-size: 13px;
        color: #004085;
    }

    .info-box strong {
        color: #004085;
    }

    .button {
        display: inline-block;
        background-color: #1a4e9b;
        color: white;
        padding: 12px 30px;
        text-decoration: none;
        border-radius: 4px;
        font-weight: 600;
        margin-top: 20px;
        transition: background-color 0.3s;
    }

    .button:hover {
        background-color: #15396b;
    }

    .footer {
        background-color: #f5f5f5;
        padding: 25px 30px;
        text-align: center;
        font-size: 12px;
        color: #777;
        border-top: 1px solid #e0e0e0;
    }

    .footer p {
        margin: 5px 0;
    }

    .footer-contact {
        margin-top: 15px;
        font-size: 11px;
    }

    .divider {
        height: 2px;
        background: linear-gradient(to right, #1a4e9b, transparent);
        margin: 25px 0;
    }

    .important-note {
        background-color: #fff8e1;
        border-left: 4px solid #ff9800;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
        font-size: 13px;
        color: #e65100;
    }

    @media (max-width: 600px) {
        .body {
            padding: 25px 15px;
        }

        .detail-row {
            flex-direction: column;
        }

        .detail-label {
            width: 100%;
            margin-bottom: 5px;
        }

        .detail-value {
            text-align: left;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="<?php echo site_url('assets/front/img/logo/Recursovivencia.png'); ?>" alt="Grupo Vivencia">
            <h1>Confirmación de Contrato</h1>
            <p>Transacción inmobiliaria registrada exitosamente</p>
        </div>

        <!-- Body -->
        <div class="body">
            <div class="greeting">¡Hola <?php echo esc($nombre); ?>!</div>

            <div class="message">
                Agradecemos tu confianza. Tu transacción ha sido procesada correctamente y se han generado los
                documentos correspondientes.
                <br><br>
                A continuación se detallan los datos de tu operación:
            </div>

            <!-- Detalles del Contrato -->
            <div class="contract-details">
                <div class="detail-row">
                    <span class="detail-label">Número de Contrato:</span>
                    <span class="detail-value"><strong><?php echo esc($contract_number); ?></strong></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Lote:</span>
                    <span class="detail-value"><?php echo esc($lote_nombre); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Manzana:</span>
                    <span class="detail-value"><?php echo esc($manzana); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Monto Total:</span>
                    <span class="detail-value"><strong style="color: #27ae60;">S/
                            <?php echo number_format($precio, 2, '.', ','); ?></strong></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tipo de Transacción:</span>
                    <span class="detail-value">
                        <?php 
                            $tipo_texto = '';
                            $clase_badge = '';
                            if ($accion === 'reservar') {
                                $tipo_texto = 'Reserva';
                                $clase_badge = 'status-reserva';
                            } elseif ($accion === 'inicial') {
                                $tipo_texto = 'Inicial';
                                $clase_badge = 'status-inicial';
                            } elseif ($accion === 'contado') {
                                $tipo_texto = 'Contado';
                                $clase_badge = 'status-contado';
                            }
                        ?>
                        <span class="status-badge <?php echo $clase_badge; ?>"><?php echo $tipo_texto; ?></span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Fecha de Registro:</span>
                    <span class="detail-value"><?php echo date('d/m/Y H:i'); ?></span>
                </div>
                <?php if ($accion === 'reservar'): ?>
                <div class="detail-row">
                    <span class="detail-label">Monto de Reserva:</span>
                    <span class="detail-value"><strong style="color: #e74c3c;">S/ 1,000.00</strong></span>
                </div>
                <?php elseif ($accion === 'inicial'): ?>
                <div class="detail-row">
                    <span class="detail-label">Monto Inicial:</span>
                    <span class="detail-value"><strong style="color: #3498db;">S/ 10,000.00</strong></span>
                </div>
                <?php endif; ?>
            </div>

            <!-- Información Importante -->
            <div class="important-note">
                <strong>⚠️ Importante:</strong> Tu contrato se encuentra registrado en nuestro sistema. Se ha generado
                un cronograma de pagos según el plan de financiamiento seleccionado.
            </div>

            <!-- Información de Contacto -->
            <div class="info-box">
                <strong>Datos Registrados:</strong>
                <br>DNI: <?php echo esc($dni); ?>
                <br>Correo: <?php echo esc($email); ?>
            </div>

            <!-- Próximos Pasos -->
            <div
                style="background-color: #f0f8ff; border: 1px solid #87ceeb; border-radius: 4px; padding: 15px; margin-bottom: 20px; font-size: 13px;">
                <strong style="color: #0066cc;">Próximos Pasos:</strong>
                <ul style="margin: 10px 0 0 20px; color: #0066cc;">
                    <li>Revisa tu correo para documentos adicionales</li>
                    <li>El cronograma de pagos será enviado por correo separado</li>
                    <li>Mantente atento a nuestras comunicaciones</li>
                </ul>
            </div>

            <div class="divider"></div>

            <div style="text-align: center; font-size: 13px; color: #666; margin-top: 20px;">
                ¿Tienes preguntas? Contáctanos en<br>
                <strong>jtarrillochuquiruna@gmail.com</strong><br>
                o visita nuestro sitio web
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Grupo Vivencia S.A.C</strong></p>
            <p>Especialistas en soluciones inmobiliarias</p>
            <div class="footer-contact">
                <p>RUC: 20612232998</p>
                <p>Correo: jtarrillochuquiruna@gmail.com</p>
                <p style="margin-top: 15px; border-top: 1px solid #ccc; padding-top: 10px;">
                    Este es un mensaje automático. Por favor no respondas directamente a este correo.
                </p>
            </div>
        </div>
    </div>
</body>

</html>