<?php echo view("backoffice_new/head"); ?>
<?php echo view("backoffice_new/header", ['nav' => 'commission_reports']); ?>

<body>
    <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
        <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
            <div class="content flex-row-fluid" id="kt_content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Mis Informes de Comisiones</h3>
                        <div class="card-toolbar">
                            <a href="<?php echo site_url(BACKOFFICE . '/commission_reports/create'); ?>" class="btn btn-sm btn-primary">
                                <i class="ki-duotone ki-plus fs-2"></i> Nuevo Informe
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (empty($reports)): ?>
                            <div class="alert alert-info" role="alert">
                                <strong>No tienes informes aún.</strong> 
                                <a href="<?php echo site_url(BACKOFFICE . '/commission_reports/create'); ?>">Crea tu primer informe</a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 gy-7">
                                    <thead>
                                        <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                                            <th>Nº Informe</th>
                                            <th>Asunto</th>
                                            <th>Monto</th>
                                            <th>Estado</th>
                                            <th>Fecha de Creación</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($reports as $report): ?>
                                            <tr>
                                                <td class="text-dark fw-bold"><?php echo $report['report_number']; ?></td>
                                                <td><?php echo substr($report['subject'], 0, 50); ?>...</td>
                                                <td>S/<?php echo number_format($report['total_amount'], 2); ?></td>
                                                <td>
                                                    <?php 
                                                    $statusBadge = [
                                                        'pending' => '<span class="badge badge-light-warning">Pendiente</span>',
                                                        'reviewed' => '<span class="badge badge-light-info">Revisado</span>',
                                                        'approved' => '<span class="badge badge-light-success">Aprobado</span>',
                                                        'rejected' => '<span class="badge badge-light-danger">Rechazado</span>',
                                                        'paid' => '<span class="badge badge-light-primary">Pagado</span>'
                                                    ];
                                                    echo $statusBadge[$report['status']] ?? $report['status'];
                                                    ?>
                                                </td>
                                                <td><?php echo date('d/m/Y', strtotime($report['created_at'])); ?></td>
                                                <td>
                                                    <?php if ($report['status'] == 'pending'): ?>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteReport(<?php echo $report['id']; ?>)" title="Eliminar informe">
                                                        <i class="ti-trash"></i> Eliminar
                                                    </button>
                                                    <?php endif; ?>
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
    <script src="<?php echo site_url() . "assets/metronic8/plugins/global/plugins.bundle.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/js/scripts.bundle.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/js/widgets.bundle.js"; ?>"></script>
    <script>
    function deleteReport(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('<?php echo site_url(BACKOFFICE . '/commission_reports/delete/'); ?>' + id, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        Swal.fire(
                            'Eliminado',
                            data.message,
                            'success'
                        ).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            data.message,
                            'error'
                        );
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire(
                        'Error',
                        'Ocurrió un error al intentar eliminar el informe',
                        'error'
                    );
                });
            }
        });
    }
    </script>
    <?php echo view("backoffice_new/footer"); ?>
</body>
</html>
