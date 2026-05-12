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
                                        <h5 class="m-b-10">Detalle de Informe de Comisiones</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard/commission-reports') ?>">Informes</a></li>
                                        <li class="breadcrumb-item"><a><?php echo $report['report_number']; ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-body">
                        <div class="page-wrapper">

<div class="container-fluid mt-4">
    <div class="row">
        <!-- Columna Izquierda - Información del Informe -->
        <div class="col-md-8">
            <!-- Card de Información General -->
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fa fa-file-invoice"></i>
                        Información del Informe: <?php echo $report['report_number']; ?>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Patrocinador:</label>
                            <p><?php echo $report['patron_name']; ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Posición:</label>
                            <p><?php echo $report['patron_position']; ?></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Contacto Contabilidad:</label>
                            <p><?php echo $report['accounting_contact']; ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Número de Factura:</label>
                            <p><?php echo $report['invoice_number']; ?></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="fw-bold text-muted">Asunto:</label>
                            <p><?php echo $report['subject']; ?></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="fw-bold text-muted">Proyectos:</label>
                            <p><?php echo nl2br($report['projects']); ?></p>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Monto Total:</label>
                            <p class="fs-5">
                                <span class="badge bg-success">S/ <?php echo number_format($report['total_amount'], 2); ?></span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Fecha de Creación:</label>
                            <p><?php echo date('d/m/Y H:i', strtotime($report['created_at'])); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card de Descripción -->
            <div class="card shadow mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fa fa-align-left"></i>
                        Descripción de Comisiones
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-justify">
                        <?php echo nl2br(htmlspecialchars($report['description'])); ?>
                    </div>
                </div>
            </div>

            <!-- Card de Archivos Adjuntos -->
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fa fa-paperclip"></i>
                        Archivos Adjuntos
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <?php if ($report['attachment_excel']): ?>
                        <a href="<?php echo site_url('dashboard/commission-reports/download/' . $report['id'] . '/excel'); ?>" 
                           class="list-group-item list-group-item-action" target="_blank">
                            <i class="fa fa-file-excel text-success"></i>
                            <strong>Cuadro Excel</strong>
                            <span class="badge bg-success float-end">Descargar</span>
                        </a>
                        <?php endif; ?>

                        <?php if ($report['attachment_vauchers']): ?>
                        <a href="<?php echo site_url('dashboard/commission-reports/download/' . $report['id'] . '/vauchers'); ?>" 
                           class="list-group-item list-group-item-action" target="_blank">
                            <i class="fa fa-file-pdf text-danger"></i>
                            <strong>Vauchers de Depósito</strong>
                            <span class="badge bg-danger float-end">Descargar</span>
                        </a>
                        <?php endif; ?>

                        <?php if ($report['attachment_invoices']): ?>
                        <a href="<?php echo site_url('dashboard/commission-reports/download/' . $report['id'] . '/invoices'); ?>" 
                           class="list-group-item list-group-item-action" target="_blank">
                            <i class="fa fa-file-pdf text-danger"></i>
                            <strong>Boletas de Venta</strong>
                            <span class="badge bg-danger float-end">Descargar</span>
                        </a>
                        <?php endif; ?>

                        <?php if ($report['attachment_factura_pdf']): ?>
                        <a href="<?php echo site_url('dashboard/commission-reports/download/' . $report['id'] . '/factura'); ?>" 
                           class="list-group-item list-group-item-action" target="_blank">
                            <i class="fa fa-file-pdf text-danger"></i>
                            <strong>Factura PDF</strong>
                            <span class="badge bg-danger float-end">Descargar</span>
                        </a>
                        <?php endif; ?>

                        <?php if (!$report['attachment_excel'] && !$report['attachment_vauchers'] && !$report['attachment_invoices'] && !$report['attachment_factura_pdf']): ?>
                        <div class="alert alert-warning mb-0">
                            <i class="fa fa-exclamation-circle"></i> No hay archivos adjuntos
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna Derecha - Panel de Gestión -->
        <div class="col-md-4">
            <!-- Card de Estado -->
            <div class="card shadow mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <i class="fa fa-cog"></i>
                        Gestión del Informe
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Estado Actual -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Estado Actual:</label>
                        <div>
                            <span class="badge badge-<?php 
                                switch($report['status']) {
                                    case 'pending': echo 'warning'; break;
                                    case 'reviewed': echo 'info'; break;
                                    case 'approved': echo 'success'; break;
                                    case 'rejected': echo 'danger'; break;
                                    case 'paid': echo 'primary'; break;
                                }
                            ?>" style="font-size: 1.1em; padding: 0.5em 0.75em;">
                                <i class="fa fa-tag"></i>
                                <?php 
                                    $statusText = [
                                        'pending' => 'Pendiente',
                                        'reviewed' => 'Revisado',
                                        'approved' => 'Aprobado',
                                        'rejected' => 'Rechazado',
                                        'paid' => 'Pagado'
                                    ];
                                    echo $statusText[$report['status']] ?? $report['status'];
                                ?>
                            </span>
                        </div>
                    </div>

                    <!-- Cambiar Estado -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Cambiar Estado:</label>
                        <select class="form-select" id="status_select">
                            <option value="">-- Seleccionar nuevo estado --</option>
                            <option value="reviewed">Revisado</option>
                            <option value="approved">Aprobado</option>
                            <option value="rejected">Rechazado</option>
                            <option value="paid">Pagado</option>
                        </select>
                    </div>

                    <!-- Notas -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Notas (Opcional):</label>
                        <textarea class="form-control" id="admin_notes" rows="5" 
                                  placeholder="Agrega notas sobre la revisión, aprobación o rechazo..."></textarea>
                    </div>

                    <!-- Botón Actualizar -->
                    <button type="button" class="btn btn-primary w-100 mb-3" onclick="updateStatus()">
                        <i class="fa fa-save"></i> Actualizar Estado
                    </button>

                    <a href="<?php echo site_url('dashboard/commission-reports'); ?>" class="btn btn-secondary w-100">
                        <i class="fa fa-arrow-left"></i> Volver
                    </a>

                    <hr class="my-4">

                    <!-- Notas Anteriores -->
                    <?php if ($report['admin_notes']): ?>
                    <div class="alert alert-info mb-0">
                        <strong><i class="fa fa-history"></i> Historial de Notas:</strong>
                        <div class="mt-2 p-2 bg-white rounded">
                            <?php echo nl2br(htmlspecialchars($report['admin_notes'])); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Card de Timeline -->
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fa fa-clock"></i>
                        Información de Auditoría
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <p class="text-muted small">Creado</p>
                                <p class="fw-bold"><?php echo date('d/m/Y H:i', strtotime($report['created_at'])); ?></p>
                            </div>
                        </div>

                        <?php if ($report['reviewed_at']): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <p class="text-muted small">Última Revisión</p>
                                <p class="fw-bold"><?php echo date('d/m/Y H:i', strtotime($report['reviewed_at'])); ?></p>
                                <?php if ($report['reviewed_by']): ?>
                                <p class="text-muted small">Por: Admin ID #<?php echo $report['reviewed_by']; ?></p>
                                <?php endif; ?>
                            </div>
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
        </div>
    </section>

<script>
function updateStatus() {
    const status = document.getElementById('status_select').value;
    const notes = document.getElementById('admin_notes').value;
    const reportId = <?php echo $report['id']; ?>;

    if (!status) {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'Por favor selecciona un estado'
        });
        return;
    }

    fetch('<?php echo site_url('dashboard/commission-reports/update-status'); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams({
            report_id: reportId,
            status: status,
            notes: notes
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: data.message
            }).then(() => {
                window.location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al actualizar el estado'
        });
    });
}
</script>

    <?php echo view("admin/footer"); ?>
</body>
</html>
