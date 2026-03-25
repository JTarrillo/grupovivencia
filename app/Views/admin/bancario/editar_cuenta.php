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
                                                <h5>Editar Cuenta Bancaria</h5>
                                                <span class="d-block m-t-5">Actualice los datos de la cuenta bancaria</span>
                                            </div>
                                            <div class="card-block">
                                                <form method="post">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Banco</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="text" class="form-control" name="banco" value="<?= esc($cuenta['banco']) ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">N° Cuenta</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="text" class="form-control" name="numero_cuenta" value="<?= esc($cuenta['numero_cuenta']) ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Tipo de Cuenta</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <select class="form-control" name="tipo_cuenta" required>
                                                                <option value="corriente" <?= $cuenta['tipo_cuenta'] === 'corriente' ? 'selected' : '' ?>>Corriente</option>
                                                                <option value="ahorros" <?= $cuenta['tipo_cuenta'] === 'ahorros' ? 'selected' : '' ?>>Ahorros</option>
                                                                <option value="plazo_fijo" <?= $cuenta['tipo_cuenta'] === 'plazo_fijo' ? 'selected' : '' ?>>Plazo Fijo</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Saldo</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="number" class="form-control" name="saldo" value="<?= $cuenta['saldo'] ?>" step="0.01" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-sm-9 offset-sm-3">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="feather icon-check"></i> Guardar Cambios
                                                            </button>
                                                            <a href="/dashboard/bancario/cuentas" class="btn btn-secondary">
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
