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
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Archivos Digitales</h5>
                                                <a href="/dashboard/documental/subir_archivo" class="btn btn-primary btn-sm float-right">
                                                    <i class="feather icon-upload"></i> Subir Archivo
                                                </a>
                                                <span class="d-block m-t-5">Gestión centralizada de archivos y documentos digitales</span>
                                            </div>
                                            <div class="card-block">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Nombre</th>
                                                                <th>Tipo</th>
                                                                <th>Fecha Subida</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($archivos)): ?>
                                                                <?php foreach ($archivos as $archivo): ?>
                                                                    <tr>
                                                                        <td><i class="feather icon-file"></i> <?php echo $archivo['nombre']; ?></td>
                                                                        <td><span class="label label-info"><?php echo $archivo['tipo']; ?></span></td>
                                                                        <td><?php echo date('d/m/Y', strtotime($archivo['fecha_subida'])); ?></td>
                                                                        <td>
                                                                            <a href="/dashboard/documental/descargar_archivo/<?php echo $archivo['id']; ?>" class="btn btn-info btn-xs" title="Descargar">
                                                                                <i class="feather icon-download"></i>
                                                                            </a>
                                                                            <a href="/dashboard/documental/eliminar_archivo/<?php echo $archivo['id']; ?>" class="btn btn-danger btn-xs" title="Eliminar" onclick="return confirm('¿Desea eliminar este archivo?');">
                                                                                <i class="feather icon-trash-2"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <tr><td colspan="4" class="text-center text-muted">No hay archivos cargados</td></tr>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>
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
        </div>
    </section>

    <?php echo view("admin/footer"); ?>
</body>
</html>
