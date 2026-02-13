<!DOCTYPE html>
<html lang="en">
<?php echo view("backoffice_new/head"); ?>

<body data-kt-name="metronic" id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
    <?php echo view("backoffice_new/header"); ?>
    <?php echo view("backoffice_new/toolbar", ['title' => 'Detalle de Contrato']); ?>
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
                    <div class="content flex-row-fluid" id="kt_content">
                        <!-- Card principal -->
                        <div class="card mb-8"
                            style="background: linear-gradient(90deg, #7f7fd5 0%, #86a8e7 100%); color: #fff;">
                            <div class="card-body d-flex flex-row justify-content-between align-items-center">
                                <div>
                                    <h3 class="fw-bold mb-1"><?= esc($contract['code']) ?></h3>
                                    <div><?= esc($contract['type']) ?></div>
                                    <div class="fs-7"><i class="fa fa-building"></i>
                                        <?= esc($contract['project_name']) ?> - Lote #<?= esc($contract['lot_code']) ?>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-success">Activo</span><br>
                                    <span class="fs-7">Fecha de contrato<br><?= esc($contract['signed_date']) ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row g-6 mb-8">
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5 class="fw-bold mb-3">Información Financiera</h5>
                                        <div class="fs-1 fw-bold mb-2" style="color:#43cea2">S/
                                            <?= number_format($contract['amount'], 2) ?></div>
                                        <div class="fs-7 mb-4">Valor Total del Contrato</div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <div class="p-3 rounded bg-light mb-2">
                                                    <div class="fs-7">
                                                        <?php
                                                        if ((isset($contract['contract_type']) && strtolower($contract['contract_type']) === 'arras')) {
                                                            echo 'Pago Reservado';
                                                        } else {
                                                            echo 'Pago Inicial';
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="fw-bold">S/
                                                        <?php
                                                        if ((isset($contract['contract_type']) && strtolower($contract['contract_type']) === 'arras') && isset($contract['reservation_amount'])) {
                                                            echo number_format($contract['reservation_amount'], 0);
                                                        } else {
                                                            echo number_format($contract['initial'], 0);
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="p-3 rounded bg-light mb-2">
                                                    <div class="fs-7">Cuota Mensual</div>
                                                    <div class="fw-bold">S/
                                                        <?= number_format($contract['monthly'], 0) ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <div class="p-3 rounded bg-warning mb-2">
                                                    <div class="fs-7">Financiado</div>
                                                    <div class="fw-bold">S/
                                                        <?= number_format($contract['amount'] - $contract['initial'], 0) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="p-3 rounded bg-light mb-2">
                                                    <div class="fs-7">Plazo</div>
                                                    <div class="fw-bold"><?= esc($contract['installments']) ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fs-7 mt-2">Tasa de Interés<br><span class="fw-bold">4.00%
                                                anual</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5 class="fw-bold mb-3">Información del Proyecto</h5>
                                        <div class="mb-2"><i class="fa fa-building"></i> <span class="fw-bold">Proyecto
                                                Inmobiliario</span></div>
                                        <div class="mb-2"><i class="fa fa-map-marker"></i> Lima, Perú</div>
                                        <div class="mb-2"><i class="fa fa-hashtag"></i> Lote
                                            #<?= esc($contract['lot_code']) ?></div>
                                        <div class="mb-2"><i class="fa fa-expand"></i> <?= esc($contract['lot_area']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-6 mb-8">
                            <div class="col-md-8">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5 class="fw-bold mb-3">Progreso del Contrato</h5>
                                        <div class="progress mb-2" style="height: 8px;">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: <?= esc($contract['progress']) ?>%;"
                                                aria-valuenow="<?= esc($contract['progress']) ?>" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                        <span class="fs-7">Has completado <?= esc($contract['progress']) ?>% de tus
                                            pagos programados</span>
                                        <ul class="mt-4">
                                            <li>Contrato Firmado <span
                                                    class="text-muted ms-2"><?= esc($contract['signed_date']) ?></span>
                                            </li>
                                            <li>Contrato Activo <span
                                                    class="text-muted ms-2"><?= esc($contract['start_date']) ?></span>
                                            </li>
                                            <!-- Puedes agregar más hitos aquí -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5 class="fw-bold mb-3">Acciones</h5>
                                        <a href="#" class="btn btn-primary w-100 mb-2">Descargar Contrato</a>
                                        <a href="#" class="btn btn-purple w-100 mb-2">Contactar Soporte</a>
                                        <?php if (!empty($contract) && isset($contract['id'])): ?>
                                        <a href="<?php echo site_url('backoffice_new/contracts/cronograma/' . esc($contract['id'])); ?>"
                                            class="btn btn-info w-100">Ver Cronograma</a>
                                        <?php else: ?>
                                        <a href="#" class="btn btn-info w-100 disabled">Ver Cronograma</a>
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

    </script>
    <script src="<?php echo site_url() . 'assets/metronic8/plugins/global/plugins.bundle.js'; ?>"></script>
    <script src="<?php echo site_url() . 'assets/metronic8/js/scripts.bundle.js'; ?>"></script>
    <script src="<?php echo site_url() . 'assets/metronic8/plugins/custom/datatables/datatables.bundle.js?123'; ?>">
    </script>
    <script src="<?php echo site_url() . 'assets/metronic8/plugins/custom/prismjs/prismjs.bundle.js'; ?>"></script>
    <script src="<?php echo site_url() . 'assets/metronic8/js/widgets.bundle.js'; ?>"></script>
    <script src="<?php echo site_url() . 'assets/metronic8/js/custom/widgets.js'; ?>"></script>
    <script>
    // Inicialización de menú y perfil (igual que en cronograma.php)
    document.addEventListener('DOMContentLoaded', function() {
        // Menú lateral
        var menuBtn = document.querySelector('button, .btn, #menuBtn');
        var menuPanel = document.querySelector('#menuPanel, .menu-panel');
        if (menuBtn && menuPanel) {
            menuBtn.addEventListener('click', function() {
                menuPanel.classList.toggle('show');
            });
        }
        // Perfil (avatar)
        var avatar = document.querySelector('.user-avatar, .profile-avatar, .kt-user-avatar, .rounded-circle');
        var profileDropdown = document.querySelector('#profileDropdown, .profile-dropdown');
        if (avatar && profileDropdown) {
            avatar.addEventListener('click', function() {
                profileDropdown.classList.toggle('show');
            });
            document.addEventListener('click', function(e) {
                if (!profileDropdown.contains(e.target) && !avatar.contains(e.target)) {
                    profileDropdown.classList.remove('show');
                }
            });
        }
    });
    </script>
</body>

</html>