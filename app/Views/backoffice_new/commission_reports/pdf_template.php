<?php
$meses = [
    'January' => 'enero',
    'February' => 'febrero',
    'March' => 'marzo',
    'April' => 'abril',
    'May' => 'mayo',
    'June' => 'junio',
    'July' => 'julio',
    'August' => 'agosto',
    'September' => 'septiembre',
    'October' => 'octubre',
    'November' => 'noviembre',
    'December' => 'diciembre'
];
$mes_nombre = isset($created_at) ? $meses[date('F', strtotime($created_at))] : $meses[date('F')];
$dia_numero = isset($created_at) ? date('d', strtotime($created_at)) : date('d');
$anio_numero = isset($created_at) ? date('Y', strtotime($created_at)) : date('Y');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe de Comisiones</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.2;
            color: #000;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 15px;
            font-size: 12pt;
        }
        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .info-table td {
            vertical-align: top;
            padding: 2px 0;
        }
        .info-table td.label {
            width: 15%;
            font-weight: bold;
        }
        .info-table td.colon {
            width: 5%;
        }
        .info-table td.value {
            width: 80%;
        }
        .content {
            text-align: justify;
            margin-bottom: 15px;
        }
        .content p {
            margin-top: 0;
            margin-bottom: 10px;
        }
        .signature-section {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <div class="header">
        <?= mb_strtoupper($report_number) ?>-AREA DE VENTAS-GRUPO VIVENCIA S.A.C.
    </div>

    <table class="info-table">
        <tr>
            <td class="label">A</td>
            <td class="colon">:</td>
            <td class="value">
                BACH.DEISSY FIORELA CHURA LOZANO<br>
                <strong>AREA DE CONTABILIDAD</strong>
            </td>
        </tr>
        <tr>
            <td class="label">DE</td>
            <td class="colon">:</td>
            <td class="value"><?= mb_strtoupper($patron_name) ?></td>
        </tr>
        <tr>
            <td class="label">ASUNTO</td>
            <td class="colon">:</td>
            <td class="value">
                <?= mb_strtoupper($subject) ?><br>
                <strong>(<?= $projects ?>)</strong>
            </td>
        </tr>
        <tr>
            <td class="label">FECHA</td>
            <td class="colon">:</td>
            <td class="value">Cusco, <?= $dia_numero ?> de <?= ucfirst($mes_nombre) ?> del <?= $anio_numero ?></td>
        </tr>
    </table>

    <hr style="border: 0; border-top: 1.5px solid #000; margin-bottom: 15px;">

    <div class="content">
        <p>Previo un cordial saludo, me dirijo a Usted con la finalidad de detallar el cierre mensual del mes de <?= $mes_nombre ?> del <?= $anio_numero ?>, se presenta el desglose de las comisiones generadas por mis ventas realizadas en las asociaciones (<?= $projects ?>) mencionados de manera detallada en el cuadro Excel, adjuntando nuestras comisiones por reserva, inicial y cuotas de los clientes.</p>

        <p><?= nl2br(htmlspecialchars($description)) ?></p>

        <p>Asimismo, el porcentaje por cada lote sumando un total de <strong>S/ <?= number_format($total_amount, 2) ?></strong> factura número <?= htmlspecialchars($invoice_number) ?> a la empresa GRUPO VIVENCIA S.A.C</p>

        <p>Este informe refleja las comisiones correspondientes al mes de <?= $mes_nombre ?> del <?= $anio_numero ?>.</p>

        <p>Los montos presentados están calculados de acuerdo con los procedimientos establecidos en la empresa y se encuentran listos para su verificación y pago por el departamento de contabilidad.</p>
        
        <p style="margin-bottom: 3px;">Se adjunta:</p>
        <p style="margin-bottom: 3px; padding-left: 20px;">1. CUADRO EXCEL</p>
        <p style="margin-bottom: 3px; padding-left: 20px;">2. VAUCHERS DE DEPOSITO</p>
        <p style="margin-bottom: 10px; padding-left: 20px;">3. BOLETAS DE VENTA</p>

        <p>Es cuanto informo a su despacho para su conocimiento y acciones correspondientes.</p>
        
        <p style="text-align: center; margin-bottom: 0;">Atentamente</p>
    </div>

    <div class="signature-section">
        <?php if (!empty($digital_signature)): ?>
            <!-- For Word to correctly render base64 images, we need special formatting or just a regular img tag with explicit width/height -->
            <img src="<?= htmlspecialchars($digital_signature) ?>" width="200" height="90" style="border-bottom: 1px solid #000; margin-bottom: 5px; display: block; margin-left: auto; margin-right: auto;" alt="Firma Digital">
        <?php else: ?>
            <div style="height: 80px; border-bottom: 1px solid #000; width: 200px; margin: 0 auto;"></div>
        <?php endif; ?>
        <br>
        <div class="signature-name" style="font-weight: bold;"><?= mb_strtoupper($patron_name) ?></div>
        <div><?= mb_strtoupper($patron_position) ?></div>
    </div>

</body>
</html>