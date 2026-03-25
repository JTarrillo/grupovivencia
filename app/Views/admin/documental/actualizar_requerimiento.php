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
                                                <h5>Actualizar Requerimiento</h5>
                                                <span class="d-block m-t-5">Actualice los datos del requerimiento documental</span>
                                            </div>
                                            <div class="card-block">
                                                <form method="post">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Descripción</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <textarea class="form-control" name="descripcion" rows="3" required><?php echo $requerimiento['descripcion']; ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Prioridad</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <select class="form-control" name="prioridad" required>
                                                                <option value="baja" <?php echo ($requerimiento['prioridad'] == 'baja') ? 'selected' : ''; ?>>Baja</option>
                                                                <option value="media" <?php echo ($requerimiento['prioridad'] == 'media') ? 'selected' : ''; ?>>Media</option>
                                                                <option value="alta" <?php echo ($requerimiento['prioridad'] == 'alta') ? 'selected' : ''; ?>>Alta</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Estado</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <select class="form-control" name="estado" required>
                                                                <option value="pendiente" <?php echo ($requerimiento['estado'] == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                                                <option value="en_proceso" <?php echo ($requerimiento['estado'] == 'en_proceso') ? 'selected' : ''; ?>>En Proceso</option>
                                                                <option value="completado" <?php echo ($requerimiento['estado'] == 'completado') ? 'selected' : ''; ?>>Completado</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Responsable</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="text" class="form-control" name="responsable" value="<?php echo $requerimiento['responsable']; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Fecha Vencimiento</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="date" class="form-control" name="fecha_vencimiento" value="<?php echo $requerimiento['fecha_vencimiento']; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-sm-9 offset-sm-3">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="feather icon-check"></i> Guardar Cambios
                                                            </button>
                                                            <a href="/dashboard/documental/requerimientos" class="btn btn-secondary">
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