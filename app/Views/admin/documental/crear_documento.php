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
                                                <h5>Crear Documento</h5>
                                                <span class="d-block m-t-5">Registre un nuevo documento interno</span>
                                            </div>
                                            <div class="card-block">
                                                <form method="post">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Título</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="text" class="form-control" name="titulo"
                                                                placeholder="Título del documento" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Tipo Documento</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <select class="form-control" name="tipo_documento" required>
                                                                <option value="">Seleccionar</option>
                                                                <option value="política">Política</option>
                                                                <option value="procedimiento">Procedimiento</option>
                                                                <option value="manual">Manual</option>
                                                                <option value="informe">Informe</option>
                                                                <option value="otro">Otro</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Contenido</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <textarea class="form-control" name="contenido" rows="4"
                                                                placeholder="Contenido del documento"
                                                                required></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Responsable</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="text" class="form-control"
                                                                name="usuario_responsable"
                                                                placeholder="Responsable del documento">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Versión</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="text" class="form-control" name="version"
                                                                placeholder="Versión (ej: 1.0)" value="1.0">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-sm-9 offset-sm-3">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="feather icon-check"></i> Crear Documento
                                                            </button>
                                                            <a href="/dashboard/documental/documentos"
                                                                class="btn btn-secondary">
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