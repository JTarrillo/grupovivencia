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
                                                <h5>Registrar Nueva Venta</h5>
                                                <span class="d-block m-t-5">Complete los datos para registrar una nueva venta</span>
                                            </div>
                                            <div class="card-block">
                                                <form method="post">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Cliente</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="text" class="form-control" name="cliente_id" placeholder="ID del cliente" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Comprobante</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="text" class="form-control" name="numero_comprobante" placeholder="Número de comprobante" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Tipo Comprobante</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <select class="form-control" name="tipo_comprobante" required>
                                                                <option value="">Seleccionar</option>
                                                                <option value="factura">Factura</option>
                                                                <option value="boleta">Boleta</option>
                                                                <option value="nota_credito">Nota de Crédito</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Fecha</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="date" class="form-control" name="fecha_venta" value="<?= date('Y-m-d') ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Subtotal</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="number" class="form-control" name="subtotal" placeholder="0.00" step="0.01" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">IGV</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="number" class="form-control" name="igv" placeholder="0.00" step="0.01" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Descripción</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <textarea class="form-control" name="descripcion" rows="3" placeholder="Descripción de la venta"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-sm-9 offset-sm-3">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="feather icon-check"></i> Guardar Venta
                                                            </button>
                                                            <a href="/dashboard/tributario/ventas" class="btn btn-secondary">
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