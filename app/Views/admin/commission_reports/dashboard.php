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
                                        <h5 class="m-b-10">Gestión de Informes de Comisiones</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard/comisiones') ?>">Comisiones</a></li>
                                        <li class="breadcrumb-item"><a>Informes</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-body">
                        <div class="page-wrapper">

<div class="container-fluid mt-4">
    <!-- Resumen de Estados -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Pendientes</h6>
                    <h3 class="text-warning"><?php echo isset($summary['pending']) ? $summary['pending'] : 0; ?></h3>
                    <small class="text-muted">En espera de revisión</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Revisados</h6>
                    <h3 class="text-info"><?php echo isset($summary['reviewed']) ? $summary['reviewed'] : 0; ?></h3>
                    <small class="text-muted">En revisión</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Aprobados</h6>
                    <h3 class="text-success"><?php echo isset($summary['approved']) ? $summary['approved'] : 0; ?></h3>
                    <small class="text-muted">Listos para pago</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Pagados</h6>
                    <h3 class="text-primary"><?php echo isset($summary['paid']) ? $summary['paid'] : 0; ?></h3>
                    <small class="text-muted">Procesados</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Últimos Informes -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fa fa-list"></i>
                        Últimos Informes Registrados
                    </h4>
                </div>

                <div class="card-body">
                    <?php if (empty($pending_reports)): ?>
                        <div class="alert alert-info" role="alert">
                            <i class="fa fa-info-circle"></i>
                            No hay informes pendientes de revisión en este momento.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-sm" id="tablaPendientes">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="12%">Nº Informe</th>
                                        <th width="20%">Patrocinador</th>
                                        <th width="15%">Monto</th>
                                        <th width="15%">Factura</th>
                                        <th width="10%">Estado</th>
                                        <th width="15%">Fecha</th>
                                        <th width="13%">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pending_reports as $report): ?>
                                        <tr>
                                            <td><strong><?php echo $report['report_number']; ?></strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar bg-light-primary text-primary rounded-circle mr-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                                        <?php echo substr($report['patron_name'], 0, 1); ?>
                                                    </div>
                                                    <div>
                                                        <div class="font-weight-bold"><?php echo $report['patron_name']; ?></div>
                                                        <small class="text-muted">ID: <?php echo $report['customer_id']; ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><strong class="text-success">S/ <?php echo number_format($report['total_amount'], 2); ?></strong></td>
                                            <td>
                                                <?php if (!empty($report['invoice_number'])): ?>
                                                    <span class="badge badge-light-secondary border"><i class="fa fa-file-invoice"></i> <?php echo $report['invoice_number']; ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $statusBadge = [
                                                        'pending' => 'badge-warning',
                                                        'reviewed' => 'badge-info',
                                                        'approved' => 'badge-success',
                                                        'rejected' => 'badge-danger',
                                                        'paid' => 'badge-primary'
                                                    ];
                                                    $statusText = [
                                                        'pending' => 'Pendiente',
                                                        'reviewed' => 'Revisado',
                                                        'approved' => 'Aprobado',
                                                        'rejected' => 'Rechazado',
                                                        'paid' => 'Pagado'
                                                    ];
                                                    $badge = $statusBadge[$report['status']] ?? 'badge-secondary';
                                                    $text = $statusText[$report['status']] ?? $report['status'];
                                                ?>
                                                <span class="badge <?php echo $badge; ?>">
                                                    <?php echo $text; ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($report['created_at'])); ?></td>
                                            <td>
                                                <a href="<?php echo site_url('/dashboard/commission-reports/view/' . $report['id']); ?>" class="btn btn-sm btn-primary" title="Ver detalle">
                                                    <i class="fa fa-eye"></i> Ver
                                                </a>
                                                <a href="<?php echo site_url('/dashboard/commission-reports/list'); ?>" class="btn btn-sm btn-secondary" title="Ver todos los informes">
                                                    <i class="fa fa-list"></i> Más
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
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
