<!doctype html>
<html lang="es-PE">
<?php echo view("admin/head"); ?>

<body data-new-gr-c-s-check-loaded="14.1042.0" data-gr-ext-installed="">
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
                                        <h5 class="m-b-10"><?= $title ?></h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard/panel">Panel</a></li>
                                        <li class="breadcrumb-item"><a>Inmueble</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- Stats Cards -->
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-8">
                                                    <h4 class="text-c-purple"><?= count($projects) ?></h4>
                                                    <h6 class="text-muted m-b-0">Proyectos</h6>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <i class="feather icon-home f-28"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-8">
                                                    <h4 class="text-c-green"><?= $available_lots ?></h4>
                                                    <h6 class="text-muted m-b-0">Lotes Disponibles</h6>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <i class="feather icon-map f-28"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-8">
                                                    <h4 class="text-c-red"><?= $total_lots ?></h4>
                                                    <h6 class="text-muted m-b-0">Total Lotes</h6>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <i class="feather icon-grid f-28"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-8">
                                                    <h4 class="text-c-blue"><?= $active_contracts ?></h4>
                                                    <h6 class="text-muted m-b-0">Contratos Activos</h6>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <i class="feather icon-file-text f-28"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Acciones Rápidas</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <a href="/dashboard/inmueble/projects"
                                                        class="btn btn-primary btn-block">
                                                        <i class="feather icon-home mr-2"></i>Gestionar Proyectos
                                                    </a>
                                                </div>
                                                <div class="col-md-3">
                                                    <a href="/dashboard/inmueble/lots"
                                                        class="btn btn-success btn-block">
                                                        <i class="feather icon-map mr-2"></i>Gestionar Lotes
                                                    </a>
                                                </div>
                                                <div class="col-md-3">
                                                    <a href="/dashboard/inmueble/payment_plans"
                                                        class="btn btn-info btn-block">
                                                        <i class="feather icon-credit-card mr-2"></i>Planes de Pago
                                                    </a>
                                                </div>
                                                <div class="col-md-3">
                                                    <a href="/dashboard/inmueble/contracts"
                                                        class="btn btn-warning btn-block">
                                                        <i class="feather icon-file-text mr-2"></i>Contratos
                                                    </a>
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
    <?php echo view("admin/footer"); ?>
</body>

</html>