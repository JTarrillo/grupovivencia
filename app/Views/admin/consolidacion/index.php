<html>
<?php echo view('admin/head'); ?>

<body>
    <?php echo view('admin/header'); ?>
    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">Conciliacion</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard/panel">Panel</a></li>
                                        <li class="breadcrumb-item"><a>Conciliacion</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Conciliacion Mensual de Compras y Ventas</h5>
                                            <span class="d-block m-t-5">Gastos = Compras, Ingresos = Ventas. El sistema arma automaticamente el reporte mensual.</span>
                                        </div>
                                        <div class="card-block">
                                            <form method="get" action="<?php echo site_url('dashboard/conciliacion'); ?>" class="mb-4">
                                                <div class="form-row">
                                                    <div class="form-group col-md-2">
                                                        <label>Mes</label>
                                                        <select name="month" class="form-control" required>
                                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                <option value="<?php echo $i; ?>" <?php echo ((int)$month === $i) ? 'selected' : ''; ?>>
                                                                    <?php echo str_pad((string)$i, 2, '0', STR_PAD_LEFT); ?>
                                                                </option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label>Anio</label>
                                                        <input type="number" name="year" class="form-control" min="2000" max="2100" value="<?php echo (int)$year; ?>" required>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label>Saldo Anterior</label>
                                                        <input type="number" step="0.01" name="saldo_anterior" class="form-control" value="<?php echo number_format((float)$saldo_anterior, 2, '.', ''); ?>">
                                                    </div>
                                                    <div class="form-group col-md-5">
                                                        <label>Descripcion EE.CC</label>
                                                        <input type="text" name="desc_cuenta" class="form-control" value="<?php echo esc($desc_cuenta); ?>" placeholder="Ejemplo: TRANSF.BCO.BBVA">
                                                    </div>
                                                </div>
                                                <div class="d-flex" style="gap:10px;">
                                                    <button type="submit" class="btn btn-primary">Generar Conciliacion</button>
                                                    <a class="btn btn-success" href="<?php echo site_url('dashboard/conciliacion/exportar?month=' . (int)$month . '&year=' . (int)$year . '&saldo_anterior=' . urlencode((string)$saldo_anterior) . '&desc_cuenta=' . urlencode((string)$desc_cuenta)); ?>">
                                                        Descargar Excel
                                                    </a>
                                                </div>
                                            </form>

                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <div class="alert alert-success mb-0" role="alert">
                                                        <strong>Total Ingreso:</strong><br>
                                                        S/ <?php echo number_format((float)$resumen['total_ingreso'], 2); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="alert alert-danger mb-0" role="alert">
                                                        <strong>Total Egreso:</strong><br>
                                                        S/ <?php echo number_format((float)$resumen['total_egreso'], 2); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="alert alert-info mb-0" role="alert">
                                                        <strong>Saldo Final:</strong><br>
                                                        S/ <?php echo number_format((float)$resumen['saldo_final'], 2); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="alert alert-secondary mb-0" role="alert">
                                                        <strong>Movimientos:</strong><br>
                                                        <?php echo (int)$resumen['cantidad']; ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php if (isset($debug_info['api_boletas']) && is_array($debug_info['api_boletas'])): ?>
                                                <?php
                                                $apiBoletas = $debug_info['api_boletas'];
                                                $fuentes = $debug_info['fuentes'] ?? [];
                                                $ventasComprobantes = (int)($fuentes['ventas_comprobantes'] ?? 0);
                                                $ventasLocal = (int)($fuentes['ventas_local'] ?? 0);
                                                $showApiWarning = (
                                                    ((int)($apiBoletas['rows_after_filter'] ?? 0) === 0) &&
                                                    ($ventasComprobantes === 0) &&
                                                    ($ventasLocal === 0)
                                                );
                                                ?>
                                                <?php if ($showApiWarning): ?>
                                                    <div class="alert alert-warning" role="alert">
                                                        <strong>Debug API Ventas:</strong> no ingresaron boletas API al periodo.<br>
                                                        token_present=<?php echo !empty($apiBoletas['token_present']) ? 'true' : 'false'; ?>,
                                                        http_code=<?php echo esc((string)($apiBoletas['http_code'] ?? 'null')); ?>,
                                                        response_success=<?php echo esc((string)($apiBoletas['response_success'] ?? 'null')); ?>,
                                                        raw_items=<?php echo esc((string)($apiBoletas['raw_items'] ?? '0')); ?>,
                                                        rows_after_filter=<?php echo esc((string)($apiBoletas['rows_after_filter'] ?? '0')); ?>,
                                                        curl_error=<?php echo esc((string)($apiBoletas['curl_error'] ?? '')); ?>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Fecha</th>
                                                            <th>Correlativo</th>
                                                            <th>Tipo Operacion</th>
                                                            <th>Nro Operacion</th>
                                                            <th>Desc. EE.CC</th>
                                                            <th>Desc. Operacion</th>
                                                            <th>Tipo Doc</th>
                                                            <th>Serie-Numero</th>
                                                            <th>RUC/DNI</th>
                                                            <th>Razon Social</th>
                                                            <th>Ingreso</th>
                                                            <th>Egreso</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($movimientos)): ?>
                                                            <?php foreach ($movimientos as $mov): ?>
                                                                <tr>
                                                                    <td><?php echo esc($mov['fecha_operacion']); ?></td>
                                                                    <td><?php echo esc($mov['correlativo']); ?></td>
                                                                    <td><?php echo esc($mov['tipo_operacion']); ?></td>
                                                                    <td><?php echo esc($mov['nro_operacion']); ?></td>
                                                                    <td><?php echo esc($mov['desc_eecc']); ?></td>
                                                                    <td><?php echo esc($mov['desc_operacion']); ?></td>
                                                                    <td><?php echo esc($mov['tipo_documento']); ?></td>
                                                                    <td><?php echo esc($mov['serie_numero']); ?></td>
                                                                    <td><?php echo esc($mov['ruc_dni']); ?></td>
                                                                    <td><?php echo esc($mov['razon_social']); ?></td>
                                                                    <td class="text-right">S/ <?php echo number_format((float)$mov['ingreso'], 2); ?></td>
                                                                    <td class="text-right">S/ <?php echo number_format((float)$mov['egreso'], 2); ?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <tr>
                                                                <td colspan="12" class="text-center">No hay movimientos para el periodo seleccionado.</td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <?php echo view('admin/footer'); ?>
    <script>
        (function() {
            var debugPayload = <?php echo json_encode(
                $debug_info ?? [],
                JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
            ); ?>;

            console.groupCollapsed('[Conciliacion Debug] Datos enviados a la vista');
            console.log('Payload completo:', debugPayload);
            console.log('Filtros:', debugPayload.filtros || {});
            console.log('Fuentes:', debugPayload.fuentes || {});
            console.log('API Boletas:', debugPayload.api_boletas || {});
            console.log('Resumen:', debugPayload.resumen || {});

            if (debugPayload.muestra_movimientos && debugPayload.muestra_movimientos.length) {
                console.table(debugPayload.muestra_movimientos);
            } else {
                console.log('Muestra de movimientos: sin datos');
            }

            console.groupEnd();
        })();
    </script>
</body>

</html>
