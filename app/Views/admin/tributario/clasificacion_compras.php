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
                                                <h5>Clasificación de Compras</h5>
                                                <span class="d-block m-t-5">Clasificación y categorización de compras para análisis tributario</span>
                                            </div>
                                            <div class="card-block">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Clasificación</th>
                                                                <th>Descripción</th>
                                                                <th>Cantidad Compras</th>
                                                                <th>Monto Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($clasificaciones)): ?>
                                                                <?php foreach ($clasificaciones as $clase): ?>
                                                                    <tr>
                                                                        <td><?php echo $clase['id']; ?></td>
                                                                        <td><strong><?php echo $clase['nombre_clasificacion']; ?></strong></td>
                                                                        <td><?php echo $clase['descripcion']; ?></td>
                                                                        <td><span class="label label-info"><?php echo $clase['cantidad_compras']; ?></span></td>
                                                                        <td>S/ <?php echo number_format($clase['monto_total'], 2); ?></td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <tr><td colspan="5" class="text-center text-muted">No hay clasificaciones registradas</td></tr>
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