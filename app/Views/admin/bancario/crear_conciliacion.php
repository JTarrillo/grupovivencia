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
                                                <h5>Crear Nueva Conciliación</h5>
                                                <span class="d-block m-t-5">Registre una nueva conciliación bancaria</span>
                                            </div>
                                            <div class="card-block">
                                                <form method="post">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Cuenta</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <select class="form-control" name="cuenta_id" required>
                                                                <option value="">Seleccionar cuenta</option>
                                                                <?php if (!empty($cuentas)): ?>
                                                                    <?php foreach ($cuentas as $cuenta): ?>
                                                                        <option value="<?php echo $cuenta['id']; ?>"><?php echo $cuenta['numero_cuenta']; ?> - <?php echo $cuenta['banco']; ?></option>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Fecha Conciliación</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="date" class="form-control" name="fecha_conciliacion" value="<?= date('Y-m-d') ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Saldo Sistema</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="number" class="form-control" name="saldo_sistema" placeholder="0.00" step="0.01" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Saldo Banco</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="number" class="form-control" name="saldo_banco" placeholder="0.00" step="0.01" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Observaciones</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <textarea class="form-control" name="observaciones" rows="3" placeholder="Observaciones de la conciliación"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-sm-9 offset-sm-3">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="feather icon-check"></i> Crear Conciliación
                                                            </button>
                                                            <a href="/dashboard/bancario/conciliaciones" class="btn btn-secondary">
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