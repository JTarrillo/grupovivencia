<!DOCTYPE html>
<html lang="en">
<?php echo view("backoffice_new/head"); ?>

<body data-kt-name="metronic" id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
    <?php echo view("backoffice_new/header"); ?>
    <?php echo view("backoffice_new/toolbar"); ?>
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
                    <div class="content flex-row-fluid" id="kt_content">
                        <h2 class="fw-bold mb-6">Mis Contratos</h2>
                        <!-- Tarjetas resumen -->
                        <div class="row mb-8">
                            <div class="col-md-3">
                                <div class="card mb-4"
                                    style="background: linear-gradient(90deg, #36c6ff 0%, #3f51b5 100%); color: #fff;">
                                    <div class="card-body text-center">
                                        <div class="fs-2 fw-bold"><?= isset($contracts) ? count($contracts) : 0 ?></div>
                                        <div class="fs-6">Total Contratos</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mb-4"
                                    style="background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%); color: #fff;">
                                    <div class="card-body text-center">
                                        <div class="fs-2 fw-bold">
                                            <?php
                                            $activos = 0;
                                            if (isset($contracts)) {
                                                foreach ($contracts as $c) {
                                                    if (strtolower($c['status']) == 'activo') $activos++;
                                                }
                                            }
                                            echo $activos;
                                            ?>
                                        </div>
                                        <div class="fs-6">Contratos Activos</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mb-4"
                                    style="background: linear-gradient(90deg, #f7971e 0%, #ffd200 100%); color: #fff;">
                                    <div class="card-body text-center">
                                        <div class="fs-2 fw-bold">
                                            <?php
                                            $valor_total = 0;
                                            if (isset($contracts)) {
                                                foreach ($contracts as $c) {
                                                    $valor_total += isset($c['amount']) ? $c['amount'] : 0;
                                                }
                                            }
                                            echo 'S/ ' . number_format($valor_total, 0, '.', ',') . 'K';
                                            ?>
                                        </div>
                                        <div class="fs-6">Valor Total</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mb-4"
                                    style="background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%); color: #fff;">
                                    <div class="card-body text-center">
                                        <div class="fs-2 fw-bold">
                                            <?php
                                            $progress = 0;
                                            $total = isset($contracts) ? count($contracts) : 0;
                                            if ($total > 0) {
                                                foreach ($contracts as $c) {
                                                    $progress += isset($c['progress']) ? $c['progress'] : 0;
                                                }
                                                $progress = round($progress / $total);
                                            }
                                            echo $progress . '%';
                                            ?>
                                        </div>
                                        <div class="fs-6">Progreso Promedio</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Listado de contratos -->
                        <div class="card shadow-sm">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Listado de Contratos</h4>
                                    <span class="text-muted fs-7">Administra todos tus contratos inmobiliarios</span>
                                </div>
                                <a href="<?= site_url('contracts/create') ?>" class="btn btn-primary">+ Nuevo
                                    Contrato</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th>Contrato</th>
                                                <th>Proyecto/Lote</th>
                                                <th>Financiamiento</th>
                                                <th>Estado</th>
                                                <th>Fecha</th>
                                                <th>Progreso</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(isset($contracts) && count($contracts) > 0): ?>
                                            <?php 
                                            // Ordenar contratos: más recientes primero
                                            usort($contracts, function($a, $b) {
                                                $dateA = strtotime($a['signed_date'] ?? $a['created_at'] ?? '0');
                                                $dateB = strtotime($b['signed_date'] ?? $b['created_at'] ?? '0');
                                                return $dateB - $dateA; // Descendente (más reciente primero)
                                            });
                                            ?>
                                            <?php foreach($contracts as $contract): ?>
                                            <tr>
                                                <td>
                                                    <span
                                                        class="fw-bold"><?= esc($contract['code'] ?? $contract['id']) ?></span><br>
                                                    <span
                                                        class="badge bg-light text-dark"><?= esc($contract['type'] ?? 'Arras') ?></span>
                                                </td>
                                                <td>
                                                    <span><?= esc($contract['project_name']) ?></span><br>
                                                    <span class="text-muted">Lote
                                                        <?= esc($contract['lot_code']) ?></span><br>
                                                    <span
                                                        class="text-muted"><?= esc($contract['lot_area'] ?? '250 m²') ?></span>
                                                </td>
                                                <td>
                                                    <span class="fw-bold text-success">S/
                                                        <?= number_format($contract['amount'] ?? 0, 2) ?></span><br>
                                                    <span class="text-muted">Inicial: S/
                                                        <?= number_format($contract['initial'] ?? 0, 2) ?></span><br>
                                                    <span class="text-muted">S/
                                                        <?= number_format($contract['monthly'] ?? 0, 2) ?>/mes</span><br>
                                                    <span
                                                        class="text-muted"><?= esc($contract['installments'] ?? '36 cuotas') ?></span>
                                                </td>
                                                <td>
                                                    <?php if(strtolower($contract['status']) == 'activo'): ?>
                                                    <span class="badge bg-success">Activo</span>
                                                    <?php else: ?>
                                                    <span
                                                        class="badge bg-secondary"><?= esc($contract['status']) ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?= esc($contract['signed_date']) ?><br>
                                                    <span class="text-muted">Inicio:
                                                        <?= esc($contract['start_date'] ?? $contract['signed_date']) ?></span>
                                                </td>
                                                <td>
                                                    <div class="progress" style="height: 8px;">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: <?= esc($contract['progress'] ?? 0) ?>%;"
                                                            aria-valuenow="<?= esc($contract['progress'] ?? 0) ?>"
                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span class="fs-7"><?= esc($contract['progress'] ?? 0) ?>%
                                                        completado</span>
                                                </td>
                                                <td>
                                                    <a href="<?= site_url('backoffice_new/contracts/detail/'.$contract['id']) ?>"
                                                        class="btn btn-sm btn-info" title="Ver"><i
                                                            class="fa fa-eye"></i></a>

                                                    <a href="#" class="btn btn-sm btn-danger btn-delete-contract"
                                                        data-id="<?= $contract['id'] ?>" title="Eliminar"><i
                                                            class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <?php else: ?>
                                            <tr>
                                                <td colspan="7" class="text-center">No hay contratos registrados.</td>
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

    <script src="<?php echo site_url() . 'assets/metronic8/plugins/global/plugins.bundle.js'; ?>"></script>
    <script src="<?php echo site_url() . 'assets/metronic8/js/scripts.bundle.js'; ?>"></script>
    <script src="<?php echo site_url() . 'assets/metronic8/plugins/custom/datatables/datatables.bundle.js?123'; ?>">
    </script>
    <script src="<?php echo site_url() . 'assets/metronic8/plugins/custom/prismjs/prismjs.bundle.js'; ?>"></script>
    <script src="<?php echo site_url() . 'assets/metronic8/js/widgets.bundle.js'; ?>"></script>
    <script src="<?php echo site_url() . 'assets/metronic8/js/custom/widgets.js'; ?>"></script>
</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-delete-contract').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var contractId = this.getAttribute('data-id');
            Swal.fire({
                title: '¿Está seguro?',
                text: 'Esta acción eliminará el contrato de forma permanente.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href =
                        '<?= site_url('backoffice_new/contracts/delete/') ?>' +
                        contractId;
                }
            });
        });
    });
});
</script>
</body>

</html>