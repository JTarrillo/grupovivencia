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
                                                <h5>Costos por Proyecto</h5>
                                                <a href="/dashboard/tributario/registrar_costo" class="btn btn-primary btn-sm float-right">
                                                    <i class="feather icon-plus"></i> Nuevo Costo
                                                </a>
                                                <span class="d-block m-t-5">Control y seguimiento de costos asociados a proyectos</span>
                                            </div>
                                            <div class="card-block">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Proyecto</th>
                                                                <th>Descripción</th>
                                                                <th>Tipo de Costo</th>
                                                                <th>Monto</th>
                                                                <th>Fecha Registro</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($costos)): ?>
                                                                <?php foreach ($costos as $costo): ?>
                                                                    <tr>
                                                                        <td><strong><?php echo $costo['proyecto_id']; ?></strong></td>
                                                                        <td><?php echo substr($costo['descripcion'], 0, 50); ?>...</td>
                                                                        <td><span class="label label-warning"><?php echo $costo['tipo_costo']; ?></span></td>
                                                                        <td>S/ <?php echo number_format($costo['monto'], 2); ?></td>
                                                                        <td><?php echo date('d/m/Y', strtotime($costo['fecha_registro'])); ?></td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <tr><td colspan="5" class="text-center text-muted">No hay costos registrados</td></tr>
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