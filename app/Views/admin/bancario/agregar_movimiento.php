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
                                                <h5>Agregar Movimiento Bancario</h5>
                                                <span class="d-block m-t-5">Registre un nuevo movimiento para la cuenta</span>
                                            </div>
                                            <div class="card-block">
                                                <form method="post">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Tipo de Movimiento</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <select class="form-control" name="tipo" required>
                                                                <option value="">Seleccionar</option>
                                                                <option value="entrada">Entrada</option>
                                                                <option value="salida">Salida</option>
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
                                                        <label class="col-sm-3 col-form-label">Fecha</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="date" class="form-control" name="fecha" value="<?= date('Y-m-d') ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Descripción</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <textarea class="form-control" name="descripcion" rows="3" placeholder="Descripción del movimiento"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Referencia</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="text" class="form-control" name="referencia" placeholder="Comprobante o referencia">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-sm-9 offset-sm-3">
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="feather icon-check"></i> Guardar Movimiento
                                                            </button>
                                                            <a href="/dashboard/bancario/movimientos/<?= $cuenta['id'] ?>" class="btn btn-secondary">
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
