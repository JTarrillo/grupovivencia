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
                                                <h5>Pagos a Proveedores</h5>
                                                <a href="/dashboard/pagos/registrar_pago" class="btn btn-primary btn-sm float-right">
                                                    <i class="feather icon-plus"></i> Nuevo Pago
                                                </a>
                                                <span class="d-block m-t-5">Registro y control de pagos a proveedores</span>
                                            </div>
                                            <div class="card-block">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Proveedor</th>
                                                                <th>Monto</th>
                                                                <th>Fecha</th>
                                                                <th>Estado</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($pagos)): ?>
                                                                <?php foreach ($pagos as $pago): ?>
                                                                    <tr>
                                                                        <td><?php echo $pago['id']; ?></td>
                                                                        <td><?php echo $pago['proveedor_id']; ?></td>
                                                                        <td><strong>$<?php echo number_format($pago['monto'], 2); ?></strong></td>
                                                                        <td><?php echo $pago['fecha_pago']; ?></td>
                                                                        <td><span class="label label-info"><?php echo $pago['estado']; ?></span></td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <tr><td colspan="5" class="text-center text-muted">No hay pagos registrados</td></tr>
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
