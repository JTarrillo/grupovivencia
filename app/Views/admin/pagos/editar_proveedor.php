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
                                    <div class="col-md-8 offset-md-2">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Editar Proveedor</h5>
                                                <span class="d-block m-t-5">Actualice los datos del proveedor</span>
                                            </div>
                                            <div class="card-block">
                                                <form method="post">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Nombre</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="text" class="form-control" name="nombre" value="<?php echo $proveedor['nombre']; ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">RUC/DNI</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="text" class="form-control" name="ruc_dni" value="<?php echo $proveedor['ruc_dni']; ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Contacto</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="text" class="form-control" name="contacto" value="<?php echo $proveedor['contacto']; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Teléfono</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="text" class="form-control" name="telefono" value="<?php echo $proveedor['telefono']; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Email</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="email" class="form-control" name="email" value="<?php echo $proveedor['email']; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Dirección</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="text" class="form-control" name="direccion" value="<?php echo $proveedor['direccion']; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-sm-9 offset-sm-3">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="feather icon-check"></i> Guardar Cambios
                                                            </button>
                                                            <a href="/dashboard/pagos/proveedores" class="btn btn-secondary">
                                                                <i class="feather icon-x"></i> Cancelar
                                                            </a>
                                                        </div>
                                                    </div>
                                                </form>
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