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
                                                <h5>Requerimientos Documentales</h5>
                                                <a href="/dashboard/documental/crear_requerimiento" class="btn btn-primary btn-sm float-right">
                                                    <i class="feather icon-plus"></i> Nuevo Requerimiento
                                                </a>
                                                <span class="d-block m-t-5">Seguimiento de requisitos y documentos necesarios</span>
                                            </div>
                                            <div class="card-block">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Número</th>
                                                                <th>Descripción</th>
                                                                <th>Prioridad</th>
                                                                <th>Estado</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($requerimientos)): ?>
                                                                <?php foreach ($requerimientos as $req): ?>
                                                                    <tr>
                                                                        <td><strong><?php echo $req['numero_requerimiento']; ?></strong></td>
                                                                        <td><?php echo substr($req['descripcion'], 0, 50); ?>...</td>
                                                                        <td>
                                                                            <?php 
                                                                            $prioridad = strtolower($req['prioridad']);
                                                                            $class = ($prioridad == 'alta') ? 'label-danger' : (($prioridad == 'media') ? 'label-warning' : 'label-success');
                                                                            ?>
                                                                            <span class="label <?php echo $class; ?>"><?php echo $req['prioridad']; ?></span>
                                                                        </td>
                                                                        <td><span class="label label-info"><?php echo $req['estado']; ?></span></td>
                                                                        <td>
                                                                            <a href="/dashboard/documental/actualizar_requerimiento/<?php echo $req['id']; ?>" class="btn btn-info btn-xs" title="Ver detalles">
                                                                                <i class="feather icon-eye"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <tr><td colspan="5" class="text-center text-muted">No hay requerimientos registrados</td></tr>
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
