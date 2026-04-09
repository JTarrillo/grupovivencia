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
                                        <h5 class="m-b-10">Clasificación de Gastos</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item"><a>Clasificación</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- Cards resumen -->
                            <div class="row">
                                <div class="col-md-6 col-xl-3">
                                    <div class="card theme-bg bitcoin-wallet" style="border-radius: 15px;">
                                        <div class="card-block">
                                            <h5 class="text-white mb-2">Pendientes de Clasificar</h5>
                                            <h2 class="text-white mb-2 f-w-300"><?= $total_sin_clasificar ?></h2>
                                            <span class="d-block"><a class="text-white" href="#"><b
                                                        style="color:yellow">Compras</b></a></span>
                                            <i class="fa fa-inbox f-70 fa-4x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card theme-bg2 bitcoin-wallet" style="border-radius: 15px;">
                                        <div class="card-block">
                                            <h5 class="text-white mb-2">Ya Clasificadas</h5>
                                            <h2 class="text-white mb-2 f-w-300"><?= $total_clasificadas ?></h2>
                                            <span class="text-white d-block">Procesadas</span>
                                            <i class="fa fa-check-circle f-70 fa-4x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card theme-bg2 bitcoin-wallet" style="border-radius: 15px;">
                                        <div class="card-block">
                                            <h5 class="text-white mb-2">Total de Compras</h5>
                                            <h2 class="text-white mb-2 f-w-300"><?= count($compras) ?></h2>
                                            <span class="text-white d-block">En sistema</span>
                                            <i class="fa fa-shopping-cart f-70 fa-4x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-3">
                                    <div class="card theme-bg2 visitor" style="border-radius: 15px;">
                                        <div class="card-block text-center">
                                            <h5 class="text-white m-0">Porcentaje</h5>
                                            <?php $porcentaje = count($compras) > 0 ? round(($total_clasificadas / count($compras)) * 100, 1) : 0; ?>
                                            <h3 class="text-white m-t-20 f-w-300"><?= $porcentaje ?>%</h3>
                                            <span class="text-white">Clasificación</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabla de compras -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><i class="fa fa-list"></i> Compras para Clasificar</h5>
                                            <span class="text-muted d-block m-t-5">Gestione la clasificación de compras
                                                y gastos</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-striped">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th>Comprobante</th>
                                                            <th>Proveedor</th>
                                                            <th>Fecha</th>
                                                            <th>Total</th>
                                                            <th>Estado</th>
                                                            <th>Clasificación</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (empty($compras)): ?>
                                                        <tr>
                                                            <td colspan="7" class="text-center text-muted">
                                                                <i class="fa fa-inbox"></i> No hay compras para
                                                                clasificar
                                                            </td>
                                                        </tr>
                                                        <?php else: ?>
                                                        <?php foreach ($compras as $compra): ?>
                                                        <tr>
                                                            <td>
                                                                <strong><?= $compra['numero_comprobante'] ?></strong>
                                                                <small
                                                                    class="text-muted d-block"><?= $compra['tipo_comprobante'] ?></small>
                                                            </td>
                                                            <td><?= $compra['proveedor_nombre'] ?? 'Sin proveedor' ?>
                                                            </td>
                                                            <td><?= date('d/m/Y', strtotime($compra['fecha_compra'])) ?>
                                                            </td>
                                                            <td class="text-end">
                                                                <strong>S/
                                                                    <?= number_format($compra['total'], 2) ?></strong>
                                                            </td>
                                                            <td>
                                                                <?php if ($compra['estado'] == 'registrado'): ?>
                                                                <span class="badge bg-warning">Registrado</span>
                                                                <?php elseif ($compra['estado'] == 'clasificado'): ?>
                                                                <span class="badge bg-success">Clasificado</span>
                                                                <?php else: ?>
                                                                <span
                                                                    class="badge bg-secondary"><?= $compra['estado'] ?></span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($compra['tiene_clasificacion'] > 0): ?>
                                                                <span class="badge bg-info"><i class="fa fa-check"></i>
                                                                    Sí</span>
                                                                <?php else: ?>
                                                                <span class="badge bg-secondary">No</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <a href="<?= site_url('dashboard/clasificacion/clasificar/' . $compra['id']) ?>"
                                                                    class="btn btn-sm btn-primary" title="Clasificar">
                                                                    <i class="fa fa-tag"></i> Clasificar
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
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
    </section>

    <?php echo view("admin/footer"); ?>
</body>

</html>