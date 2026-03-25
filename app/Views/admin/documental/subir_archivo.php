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
                                                <h5>Subir Archivo</h5>
                                                <span class="d-block m-t-5">Cargue un nuevo archivo digital al sistema</span>
                                            </div>
                                            <div class="card-block">
                                                <form method="post" enctype="multipart/form-data">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Nombre</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="text" class="form-control" name="nombre" placeholder="Nombre del archivo" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Descripción</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <textarea class="form-control" name="descripcion" rows="3" placeholder="Descripción del archivo"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Archivo</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="file" class="form-control" name="archivo" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-sm-9 offset-sm-3">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="feather icon-upload"></i> Subir Archivo
                                                            </button>
                                                            <a href="/dashboard/documental/archivos" class="btn btn-secondary">
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