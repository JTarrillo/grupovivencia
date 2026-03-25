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
                                                <h5>Proveedores</h5>
                                                <a href="/dashboard/pagos/crear_proveedor" class="btn btn-primary btn-sm float-right">
                                                    <i class="feather icon-plus"></i> Nuevo Proveedor
                                                </a>
                                                <span class="d-block m-t-5">Registro y gestión de proveedores</span>
                                            </div>
                                            <div class="card-block">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Nombre</th>
                                                                <th>RUC/DNI</th>
                                                                <th>Contacto</th>
                                                                <th>Teléfono</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($proveedores)): ?>
                                                                <?php foreach ($proveedores as $proveedor): ?>
                                                                    <tr>
                                                                        <td><strong><?php echo $proveedor['nombre']; ?></strong></td>
                                                                        <td><?php echo $proveedor['ruc_dni']; ?></td>
                                                                        <td><?php echo $proveedor['contacto']; ?></td>
                                                                        <td><?php echo $proveedor['telefono']; ?></td>
                                                                        <td>
                                                                            <a href="/dashboard/pagos/editar_proveedor/<?php echo $proveedor['id']; ?>" class="btn btn-info btn-xs">
                                                                                <i class="feather icon-edit-2"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <tr><td colspan="5" class="text-center text-muted">No hay proveedores registrados</td></tr>
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