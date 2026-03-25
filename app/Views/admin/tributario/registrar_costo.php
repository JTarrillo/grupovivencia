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
                                                <h5>Registrar Nuevo Costo</h5>
                                                <span class="d-block m-t-5">Complete los datos para registrar un costo de proyecto</span>
                                            </div>
                                            <div class="card-block">
                                                <form method="post">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Proyecto</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="text" class="form-control" name="proyecto_id" placeholder="ID del proyecto" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Descripción</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <textarea class="form-control" name="descripcion" rows="3" placeholder="Descripción del costo" required></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Tipo de Costo</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <select class="form-control" name="tipo_costo" required>
                                                                <option value="">Seleccionar</option>
                                                                <option value="mano_de_obra">Mano de Obra</option>
                                                                <option value="materiales">Materiales</option>
                                                                <option value="equipos">Equipos</option>
                                                                <option value="servicios">Servicios</option>
                                                                <option value="otros">Otros</option>
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
                                                        <div class="col-sm-9 offset-sm-3">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="feather icon-check"></i> Guardar Costo
                                                            </button>
                                                            <a href="/dashboard/tributario/costo_proyecto" class="btn btn-secondary">
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