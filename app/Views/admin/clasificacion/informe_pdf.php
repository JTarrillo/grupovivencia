<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Informe de Gastos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
            margin: 15px;
            line-height: 1.4;
        }
        .header {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #004B97;
        }
        .header-content h1 {
            font-size: 12px;
            color: #004B97;
            margin: 0 0 2px 0;
            font-weight: bold;
        }
        .header-content .subtitle {
            font-size: 9px;
            color: #666;
            margin: 0 0 2px 0;
        }
        .header-content .title {
            font-size: 9px;
            color: #000;
            margin: 0;
        }
        .info-row {
            margin-bottom: 3px;
            font-size: 10px;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 70px;
            vertical-align: top;
        }
        .period-info {
            background-color: #E8F4F8;
            padding: 8px;
            margin: 12px 0;
            border-left: 3px solid #004B97;
            font-size: 10px;
        }
        .description {
            text-align: justify;
            margin: 12px 0;
            font-size: 10px;
            line-height: 1.5;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            font-size: 10px;
        }
        thead {
            background-color: #004B97;
            color: white;
        }
        th {
            padding: 5px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
        }
        td {
            padding: 4px;
            border: 1px solid #ddd;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .total-row {
            background-color: #E8F4F8;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 2px;
            color: white;
            font-size: 9px;
            font-weight: bold;
        }
        .section-title {
            background-color: #004B97;
            color: white;
            padding: 5px;
            margin: 12px 0 8px 0;
            font-weight: bold;
            font-size: 11px;
        }
        .footer {
            margin-top: 20px;
            padding-top: 8px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 9px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>ÁREA DE CONTABILIDAD</h1>
            <div class="subtitle">"Vive una experiencia 2026"</div>
            <div class="title">INFORME <?php echo esc($numero_informe); ?> - ÁREA DE CONTABILIDAD<br>GRUPO VIVENCIA S.A.C.</div>
        </div>
    </div>

    <div class="info-row"><span class="info-label">A</span>: C.P.P LUIS ENRIQUE RUIZ FLORES<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CONTADOR PÚBLICO COLEGIADO</div>
    <div class="info-row"><span class="info-label">DE</span>: BACH. CONT. DEISSY FIORELLA CHURA LOZANO<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ÁREA DE CONTABILIDAD</div>
    <div class="info-row"><span class="info-label">ASUNTO</span>: <?php echo esc($asunto); ?></div>
    <div class="info-row"><span class="info-label">FECHA</span>: Cusco, <?php 
        $meses_min = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
        echo date('d') . ' de ' . $meses_min[(int)date('m') - 1] . ' de ' . date('Y');
    ?></div>

    <hr style="border: 1px solid #333; margin: 10px 0;">

    <div class="description">
        <?php
        $lineasCuerpo = preg_split('/\r\n|\r|\n/', (string) $cuerpo_informe);
        foreach ($lineasCuerpo as $linea) {
            $linea = trim($linea);
            if ($linea === '') {
                continue;
            }
            echo '<p>' . esc($linea) . '</p>';
        }
        ?>
    </div>

    <div class="period-info">
        <strong>Cuadro resumen de adquisiciones</strong>
        <div style="margin-top: 5px;">
            Período: <?php echo date('d/m/Y', strtotime($fecha_inicio)); ?> al <?php echo date('d/m/Y', strtotime($fecha_fin)); ?> - <?php echo $cantidadRegistros; ?> registros
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="12%">Fecha</th>
                <th width="14%">Factura</th>
                <th width="36%">Descripción</th>
                <th width="14%">Tipo</th>
                <th width="13%" style="text-align: right;">Monto (S/.)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($gastos as $gasto): ?>
                <tr>
                    <td><?php echo date('d/m/Y', strtotime($gasto['fecha_compra'])); ?></td>
                    <td><?php echo $gasto['numero_comprobante']; ?></td>
                    <td><?php echo substr($gasto['observaciones'] ?? 'Sin obs.', 0, 45); ?></td>
                    <td class="text-center">
                        <span class="badge" style="background-color: <?php echo $gasto['color'] ?? '#999'; ?>;">
                            <?php echo substr($gasto['tipo_nombre'] ?? 'N/A', 0, 10); ?>
                        </span>
                    </td>
                    <td class="text-right"><?php echo number_format($gasto['monto_compra'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="total-row">
                <td colspan="4" style="text-align: right;"><strong>TOTAL GENERAL:</strong></td>
                <td class="text-right"><strong><?php echo number_format($totalGeneral, 2); ?></strong></td>
            </tr>
        </tbody>
    </table>

    <?php if (!empty($totalesPorTipo)): ?>
        <div class="section-title">Resumen por Concepto de Gasto</div>
        <table>
            <thead>
                <tr>
                    <th width="45%">Concepto</th>
                    <th width="18%" class="text-center">Cantidad</th>
                    <th width="18%" class="text-right">Total (S/.)</th>
                    <th width="15%" class="text-right">%</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($totalesPorTipo as $tipo => $datos): ?>
                    <tr>
                        <td><?php echo $tipo; ?></td>
                        <td class="text-center"><?php echo $datos['cantidad']; ?></td>
                        <td class="text-right"><?php echo number_format($datos['total'], 2); ?></td>
                        <td class="text-right">
                            <?php 
                                $pct = ($totalGeneral > 0) ? ($datos['total'] / $totalGeneral) * 100 : 0;
                                echo number_format($pct, 1) . '%';
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td><strong>TOTAL GENERAL</strong></td>
                    <td class="text-center"><strong><?php echo count($gastos); ?></strong></td>
                    <td class="text-right"><strong><?php echo number_format($totalGeneral, 2); ?></strong></td>
                    <td class="text-right"><strong>100%</strong></td>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="footer">
        <p style="margin: 5px 0;">Atentamente,</p>
        <p style="margin: 15px 0 5px 0;">Área de Contabilidad</p>
    </div>
</body>
</html>
