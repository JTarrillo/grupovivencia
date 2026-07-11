<html>
<?php echo view("admin/head"); ?>

<body>
    <?php echo view("admin/header"); ?>
    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">Modulo de Gastos</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard/">Panel</a></li>
                                        <li class="breadcrumb-item"><a>Gastos</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <h6 class="text-muted">Gastos Este Mes</h6>
                                            <h3 class="mb-0">S/. <?php echo number_format($resumen['mes_actual'] ?? 0, 2); ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <h6 class="text-muted">Mes Anterior</h6>
                                            <h3 class="mb-0">S/. <?php echo number_format($resumen['mes_anterior'] ?? 0, 2); ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <h6 class="text-muted">Acumulado Trimestral</h6>
                                            <h3 class="mb-0">S/. <?php echo number_format($resumen['trimestre_actual'] ?? 0, 2); ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <h6 class="text-muted">Total Gastos</h6>
                                            <h3 class="mb-0">S/. <?php echo number_format(array_sum(array_column($gastos ?? [], 'total')), 2); ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5><i class="fa fa-list"></i> Listado de Gastos</h5>
                                                <div style="display: flex; gap: 8px;">
                                                    <a href="<?php echo base_url('dashboard/compras'); ?>" class="btn btn-sm btn-primary">
                                                        <i class="fa fa-plus"></i> Nueva Compra
                                                    </a>
                                                    <a href="<?php echo base_url('dashboard/gastos/reporte'); ?>" class="btn btn-sm btn-info">
                                                        <i class="fa fa-bar-chart"></i> Ver Reporte
                                                    </a>
                                                </div>
                                            </div>
                                            <span class="text-muted d-block m-t-5">Gestione los gastos por periodo</span>

                                            <form method="get" class="form-inline" id="formGastosPeriodo" style="margin-top: 12px;">
                                                <div class="form-group mr-3" style="display: flex; align-items: center;">
                                                    <label for="periodo_fecha_gastos" class="mr-2" style="margin-bottom: 0;"><strong>Periodo:</strong></label>
                                                    <input
                                                        type="date"
                                                        id="periodo_fecha_gastos"
                                                        name="periodo_fecha"
                                                        class="form-control"
                                                        value="<?php echo $periodo_fecha ?? date('Y-m-d'); ?>"
                                                        onchange="document.getElementById('formGastosPeriodo').submit();"
                                                        style="max-width: 150px; border-radius: 5px; border: 1px solid #ddd; padding: 8px 12px; font-size: 14px;">
                                                </div>
                                                <a href="<?php echo site_url('dashboard/gastos'); ?>" class="btn btn-sm btn-secondary">
                                                    <i class="fa fa-redo"></i> Limpiar
                                                </a>
                                            </form>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Comprobante</th>
                                                            <th>Fecha</th>
                                                            <th>Proveedor</th>
                                                            <th>Tipo de Gasto</th>
                                                            <th>Subcategoria</th>
                                                            <th>Total</th>
                                                            <th>Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($gastos)): ?>
                                                            <?php foreach ($gastos as $gasto): ?>
                                                                <tr>
                                                                    <td><?php echo $gasto['numero_comprobante']; ?></td>
                                                                    <td><?php echo date('d/m/Y', strtotime($gasto['fecha_compra'] ?? date('Y-m-d'))); ?></td>
                                                                    <td><?php echo $gasto['proveedor_nombre'] ?? 'N/A'; ?></td>
                                                                    <td>
                                                                        <span class="badge badge-info">
                                                                            <?php echo esc($gasto['tipo_nombre'] ?? 'Sin tipo'); ?>
                                                                        </span>
                                                                    </td>
                                                                    <td><?php echo esc($gasto['subcategoria_nombre'] ?? 'Sin subcategoria'); ?></td>
                                                                    <td>S/. <?php echo number_format($gasto['total'] ?? 0, 2); ?></td>
                                                                    <td>
                                                                        <?php
                                                                        $estadoBadgeClass = 'warning';
                                                                        if (($gasto['estado'] ?? '') === 'aprobado') {
                                                                            $estadoBadgeClass = 'success';
                                                                        } elseif (($gasto['estado'] ?? '') === 'clasificado') {
                                                                            $estadoBadgeClass = 'info';
                                                                        }
                                                                        ?>
                                                                        <span class="badge badge-<?php echo $estadoBadgeClass; ?>">
                                                                            <?php echo ucfirst($gasto['estado'] ?? 'pendiente'); ?>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <tr>
                                                                <td colspan="7" class="text-center p-4">
                                                                    <p class="text-muted">No hay gastos registrados</p>
                                                                </td>
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
    <?php echo view("admin/footer"); ?>
</body>
</html>
