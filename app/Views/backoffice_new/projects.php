<!DOCTYPE html>
<html lang="en">
<?php echo view("backoffice_new/head"); ?>
<body data-kt-name="metronic" id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
    <?php echo view("backoffice_new/header"); ?>
    <?php echo view("backoffice_new/toolbar"); ?>
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
                    <div class="content flex-row-fluid" id="kt_content">
                        <div class="card">
                            <div class="card-header text-center">
                                <h4>Gestión de Proyectos Inmobiliarios</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Código</th>
                                            <th>Ubicación</th>
                                            <th>Tasa de Interés</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(isset($projects) && count($projects) > 0): ?>
                                            <?php foreach($projects as $project): ?>
                                                <tr>
                                                    <td><?= esc($project['name']) ?></td>
                                                    <td><?= esc($project['code']) ?></td>
                                                    <td><?= esc($project['location']) ?></td>
                                                    <td><?= esc($project['base_interest_rate']) ?>%</td>
                                                    <td><?= esc($project['status']) ?></td>
                                                    <td>
                                                        <a href="<?= site_url('projects/edit/'.$project['id']) ?>" class="btn btn-sm btn-primary">Editar</a>
                                                        <a href="<?= site_url('projects/delete/'.$project['id']) ?>" class="btn btn-sm btn-danger">Eliminar</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr><td colspan="6" class="text-center">No hay proyectos registrados.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <a href="<?= site_url('projects/create') ?>" class="btn btn-success">Agregar Nuevo Proyecto</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
