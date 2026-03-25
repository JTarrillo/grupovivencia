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
                                                <h5>Crear Nuevo Recibo</h5>
                                                <span class="d-block m-t-5">Genere un nuevo recibo de honorarios</span>
                                            </div>
                                            <div class="card-block">
                                                <form method="post">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Beneficiario</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="text" class="form-control" name="beneficiario" placeholder="Nombre del beneficiario" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Concepto</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="text" class="form-control" name="concepto" placeholder="Concepto del honorario" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Monto</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="number" class="form-control" name="monto" placeholder="0.00" step="0.01" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Fecha Emisión</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="date" class="form-control" name="fecha_emision" value="<?= date('Y-m-d') ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">RUC/DNI</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="text" class="form-control" name="ruc_dni" placeholder="RUC o DNI">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-sm-9 offset-sm-3">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="feather icon-check"></i> Crear Recibo
                                                            </button>
                                                            <a href="/dashboard/pagos/recibos_honorarios" class="btn btn-secondary">
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