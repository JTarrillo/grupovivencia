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
                                                <h5>Registrar Pago a Proveedor</h5>
                                                <span class="d-block m-t-5">Registre un nuevo pago a un proveedor</span>
                                            </div>
                                            <div class="card-block">
                                                <form method="post">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Proveedor</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <select class="form-control" name="proveedor_id" required>
                                                                <option value="">Seleccionar proveedor</option>
                                                                <?php if (!empty($proveedores)): ?>
                                                                    <?php foreach ($proveedores as $proveedor): ?>
                                                                        <option value="<?php echo $proveedor['id']; ?>"><?php echo $proveedor['nombre']; ?></option>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Monto</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="number" class="form-control" name="monto" placeholder="0.00" step="0.01" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Fecha Pago</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="date" class="form-control" name="fecha_pago" value="<?= date('Y-m-d') ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Método Pago</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <select class="form-control" name="metodo_pago" required>
                                                                <option value="">Seleccionar</option>
                                                                <option value="efectivo">Efectivo</option>
                                                                <option value="transferencia">Transferencia Bancaria</option>
                                                                <option value="cheque">Cheque</option>
                                                                <option value="tarjeta">Tarjeta</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Observaciones</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <textarea class="form-control" name="observaciones" rows="3" placeholder="Observaciones adicionales"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-sm-9 offset-sm-3">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="feather icon-check"></i> Registrar Pago
                                                            </button>
                                                            <a href="/dashboard/pagos/pagos_proveedores" class="btn btn-secondary">
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