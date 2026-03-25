<!doctype html>
<html lang="es-PE">

<?php echo view("admin/head"); ?>

<body>
    <?php echo view("admin/header"); ?>
    
    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Conciliaciones Bancarias</h5>
                                                <a href="/dashboard/bancario/crear_conciliacion" class="btn btn-primary btn-sm float-right">
                                                    <i class="feather icon-plus"></i> Nueva Conciliación
                                                </a>
                                                <span class="d-block m-t-5">Control y reconciliación de saldos bancarios</span>
                                            </div>
                                            <div class="card-block">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Fecha</th>
                                                                <th>Saldo Sistema</th>
                                                                <th>Saldo Banco</th>
                                                                <th>Diferencia</th>
                                                                <th>Estado</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($conciliaciones)): ?>
                                                                <?php foreach ($conciliaciones as $conc): ?>
                                                                    <tr>
                                                                        <td><?= date('d/m/Y', strtotime($conc['fecha_conciliacion'])) ?></td>
                                                                        <td><strong>S/ <?= number_format($conc['saldo_sistema'], 2) ?></strong></td>
                                                                        <td>S/ <?= number_format($conc['saldo_banco'], 2) ?></td>
                                                                        <td>
                                                                            <span class="<?= $conc['diferencia'] == 0 ? 'text-success' : 'text-danger' ?>">
                                                                                S/ <?= number_format($conc['diferencia'], 2) ?>
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            <?php 
                                                                            $estado = strtolower($conc['estado']);
                                                                            $class = ($estado == 'conciliado') ? 'label-success' : 'label-info';
                                                                            ?>
                                                                            <span class="label <?php echo $class; ?>"><?= esc($conc['estado']) ?></span>
                                                                        </td>
                                                                        <td>
                                                                            <a href="/dashboard/bancario/detalle_conciliacion/<?= $conc['id'] ?>" class="btn btn-info btn-xs" title="Ver detalles">
                                                                                <i class="feather icon-eye"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <tr><td colspan="6" class="text-center text-muted">No hay conciliaciones registradas</td></tr>
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
        </div>
    </section>

    <?php echo view("admin/footer"); ?>
</body>
</html>
