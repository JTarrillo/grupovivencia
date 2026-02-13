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
                                <h4>Gestión de Lotes/Terrenos</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Proyecto</th>
                                            <th>Manzana</th>
                                            <th>Estado</th>
                                            <th>Precio Base</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(isset($lots) && count($lots) > 0): ?>
                                            <?php foreach($lots as $lot): ?>
                                                <tr>
                                                    <td><?= esc($lot['code']) ?></td>
                                                    <td><?= esc($lot['project_name']) ?></td>
                                                    <td><?= esc($lot['block']) ?></td>
                                                    <td><?= esc($lot['status']) ?></td>
                                                    <td>S/ <?= number_format($lot['base_price'], 2) ?></td>
                                                    <td>
                                                        <a href="<?= site_url('lots/edit/'.$lot['id']) ?>" class="btn btn-sm btn-primary">Editar</a>
                                                        <a href="<?= site_url('lots/delete/'.$lot['id']) ?>" class="btn btn-sm btn-danger">Eliminar</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr><td colspan="6" class="text-center">No hay lotes registrados.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <a href="<?= site_url('lots/create') ?>" class="btn btn-success">Agregar Nuevo Lote</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
