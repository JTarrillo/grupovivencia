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
                                        <h5 class="m-b-10">Consolidacion</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard/inmueble">Panel</a></li>
                                        <li class="breadcrumb-item"><a>Consolidacion</a></li>
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
                                            <h5>Modulo de Consolidacion de Excel</h5>
                                            <span class="d-block m-t-5">Este modulo es independiente de Compras y esta listo para el flujo de consolidacion.</span>
                                        </div>
                                        <div class="card-block">
                                            <div class="alert alert-info mb-0" role="alert">
                                                Aqui se integrara la carga de archivos Excel y el proceso de consolidacion de movimientos.
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
</body>

</html>
