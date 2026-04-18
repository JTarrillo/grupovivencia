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
                                        <h5 class="m-b-10">Módulo de Compras</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard/">Panel</a></li>
                                        <li class="breadcrumb-item"><a>Compras</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5><i class="fa fa-list"></i> Listado de Compras</h5>
                                                <div style="display: flex; gap: 8px;">
                                                    <a href="<?php echo base_url('dashboard/compras/create'); ?>" class="btn btn-sm btn-success">
                                                        <i class="fa fa-plus"></i> Nueva Compra
                                                    </a>
                                                    <a href="<?php echo base_url('dashboard/compras/reporte'); ?>" class="btn btn-sm btn-primary">
                                                        <i class="fa fa-bar-chart"></i> Reporte
                                                    </a>
                                                </div>
                                            </div>
                                            <span class="text-muted d-block m-t-5">Registros y gestión de compras</span>

                                            <!-- Filtro de Período con Date Picker Moderno -->
                                            <form method="get" class="form-inline" id="formComprasPeriodo" style="margin-top: 12px;">
                                                <div class="form-group mr-3" style="display: flex; align-items: center;">
                                                    <label for="periodo_fecha_compras" class="mr-2" style="margin-bottom: 0;"><strong>Período:</strong></label>
                                                    <input 
                                                        type="date" 
                                                        id="periodo_fecha_compras" 
                                                        name="periodo_fecha" 
                                                        class="form-control" 
                                                        value="<?php echo $periodo_fecha ?? date('Y-m-d'); ?>"
                                                        onchange="document.getElementById('formComprasPeriodo').submit();"
                                                        style="max-width: 150px; border-radius: 5px; border: 1px solid #ddd; padding: 8px 12px; font-size: 14px;">
                                                </div>
                                                <a href="<?php echo site_url('dashboard/compras'); ?>" class="btn btn-sm btn-secondary">
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
                                                            <th>Total</th>
                                                            <th>Estado</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($compras)): ?>
                                                            <?php foreach ($compras as $compra): ?>
                                                                <tr>
                                                                    <td><strong><?php echo $compra['numero_comprobante']; ?></strong></td>
                                                                    <td><?php echo date('d/m/Y', strtotime($compra['fecha_compra'] ?? date('Y-m-d'))); ?></td>
                                                                    <td><?php echo $compra['proveedor_nombre'] ?? 'N/A'; ?></td>
                                                                    <td>S/. <?php echo number_format($compra['total'] ?? 0, 2); ?></td>
                                                                    <td>
                                                                        <?php 
                                                                            $badgeColor = match($compra['estado']) {
                                                                                'registrado' => 'warning',
                                                                                'clasificado' => 'info',
                                                                                'aprobado' => 'success',
                                                                                default => 'secondary'
                                                                            };
                                                                        ?>
                                                                        <span class="badge badge-<?php echo $badgeColor; ?>">
                                                                            <?php echo ucfirst($compra['estado']); ?>
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a href="<?php echo base_url('dashboard/compras/view/' . $compra['id']); ?>" title="Ver" class="btn btn-sm btn-info">
                                                                            <i class="fa fa-eye"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <tr>
                                                                <td colspan="6" class="text-center p-4">
                                                                    <p class="text-muted">No hay compras registradas</p>
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
