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
                                        <h5 class="m-b-10">Listado de Informes de Comisiones</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard/commission-reports') ?>">Comisiones</a></li>
                                        <li class="breadcrumb-item"><a>Todos los Informes</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-body">
                        <div class="page-wrapper">

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fa fa-list"></i>
                        Todos los Informes de Comisiones
                    </h4>
                </div>

                <div class="card-body">
                    <!-- Filtro por Estado -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form method="get" id="formFiltro" class="form-row align-items-end">
                                <div class="form-group col-md-4">
                                    <label for="status">Filtrar por Estado:</label>
                                    <select class="form-control" id="status" name="status" onchange="document.getElementById('formFiltro').submit();">
                                        <option value="">-- Todos los Estados --</option>
                                        <option value="pending" <?php echo isset($current_status) && $current_status === 'pending' ? 'selected' : ''; ?>>Pendiente</option>
                                        <option value="reviewed" <?php echo isset($current_status) && $current_status === 'reviewed' ? 'selected' : ''; ?>>Revisado</option>
                                        <option value="approved" <?php echo isset($current_status) && $current_status === 'approved' ? 'selected' : ''; ?>>Aprobado</option>
                                        <option value="rejected" <?php echo isset($current_status) && $current_status === 'rejected' ? 'selected' : ''; ?>>Rechazado</option>
                                        <option value="paid" <?php echo isset($current_status) && $current_status === 'paid' ? 'selected' : ''; ?>>Pagado</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i> Filtrar
                                    </button>
                                    <a href="<?php echo site_url('dashboard/commission-reports'); ?>" class="btn btn-secondary">
                                        <i class="fa fa-redo"></i> Limpiar
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tabla de Informes -->
                    <?php if (!empty($reports)): ?>
                        <div class="alert alert-info mb-3">
                            <i class="fa fa-info-circle"></i>
                            Se encontraron <strong><?php echo count($reports); ?></strong> informes
                            <?php if (isset($current_status) && $current_status): ?>
                                con estado <strong><?php echo ucfirst($current_status); ?></strong>
                            <?php endif; ?>
                        </div>

                        <div class="table-responsive mb-4">
                            <table class="table table-hover table-sm" id="tablaInformes">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="10%">Nº Informe</th>
                                        <th width="18%">Patrocinador</th>
                                        <th width="12%">Monto (S/)</th>
                                        <th width="12%">Factura</th>
                                        <th width="12%">Fecha Creación</th>
                                        <th width="14%">Estado</th>
                                        <th width="22%">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reports as $report): ?>
                                        <tr>
                                            <td class="fw-bold text-primary"><?php echo $report['report_number']; ?></td>
                                            <td>
                                                <?php echo $report['patron_name'] ?? 'N/A'; ?>
                                                <br>
                                                <small class="text-muted"><?php echo $report['patron_position'] ?? ''; ?></small>
                                            </td>
                                            <td>
                                                <strong class="text-success">S/<?php echo number_format($report['total_amount'], 2); ?></strong>
                                            </td>
                                            <td><?php echo $report['invoice_number'] ?? '-'; ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($report['created_at'])); ?></td>
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
                                                    <i class="fa fa-tag"></i> <?php echo $text; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="<?php echo site_url('/dashboard/commission-reports/view/' . $report['id']); ?>" class="btn btn-sm btn-primary" title="Ver detalle">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger btn-delete-report" data-id="<?php echo $report['id']; ?>" title="Eliminar informe">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <?php if (isset($pager)): ?>
                            <nav aria-label="Page navigation" class="mt-4">
                                <ul class="pagination justify-content-center">
                                    <?php echo $pager->links(); ?>
                                </ul>
                            </nav>
                        <?php endif; ?>

                    <?php else: ?>
                        <div class="alert alert-warning" role="alert">
                            <i class="fa fa-exclamation-circle"></i>
                            <strong>No hay informes</strong> que coincidan con los criterios de búsqueda.
                            <a href="<?php echo site_url('dashboard/commission-reports'); ?>">Ver todos los informes</a>
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
    
    <script>
    $(document).ready(function() {
        $('.btn-delete-report').on('click', function(e) {
            e.preventDefault();
            var reportId = $(this).data('id');
            var row = $(this).closest('tr');
            
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esta acción. El informe será eliminado permanentemente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?php echo site_url('dashboard/commission-reports/delete/'); ?>" + reportId,
                        type: "POST",
                        dataType: "json",
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    '¡Eliminado!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    row.fadeOut(400, function() {
                                        $(this).remove();
                                        if ($('table tbody tr').length === 0) {
                                            location.reload();
                                        }
                                    });
                                });
                            } else {
                                Swal.fire('Error', response.message, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'No se pudo procesar la solicitud', 'error');
                        }
                    });
                }
            });
        });
    });
    </script>
</body>
</html>
