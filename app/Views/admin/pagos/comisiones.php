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
                                                <h5>Comisiones</h5>
                                                <a href="/dashboard/pagos/crear_comision" class="btn btn-primary btn-sm float-right">
                                                    <i class="feather icon-plus"></i> Nueva Comisión
                                                </a>
                                                <span class="d-block m-t-5">Registro y control de comisiones de ventas</span>
                                            </div>
                                            <div class="card-block">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Proveedor</th>
                                                                <th>Porcentaje</th>
                                                                <th>Monto Mínimo</th>
                                                                <th>Descripción</th>
                                                                <th>Estado</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($comisiones)): ?>
                                                                <?php foreach ($comisiones as $comision): ?>
                                                                    <tr>
                                                                        <td><strong><?php echo $comision['proveedor_id']; ?></strong></td>
                                                                        <td><?php echo $comision['porcentaje']; ?>%</td>
                                                                        <td>S/ <?php echo number_format($comision['monto_minimo'], 2); ?></td>
                                                                        <td><?php echo substr($comision['descripcion'], 0, 40); ?>...</td>
                                                                        <td>
                                                                            <?php 
                                                                            $estado = strtolower($comision['estado']);
                                                                            $class = ($estado == 'activa') ? 'label-success' : 'label-danger';
                                                                            ?>
                                                                            <span class="label <?php echo $class; ?>"><?php echo $comision['estado']; ?></span>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <tr><td colspan="5" class="text-center text-muted">No hay comisiones registradas</td></tr>
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