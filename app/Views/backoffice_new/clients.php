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
                                <h4>Gestión de Clientes</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>DNI</th>
                                            <th>Email</th>
                                            <th>Teléfono</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(isset($clients) && count($clients) > 0): ?>
                                            <?php foreach($clients as $client): ?>
                                                <tr>
                                                    <td><?= esc($client['name']) ?></td>
                                                    <td><?= esc($client['dni']) ?></td>
                                                    <td><?= esc($client['email']) ?></td>
                                                    <td><?= esc($client['phone']) ?></td>
                                                    <td><?= esc($client['status']) ?></td>
                                                    <td>
                                                        <a href="<?= site_url('clients/edit/'.$client['id']) ?>" class="btn btn-sm btn-primary">Editar</a>
                                                        <a href="<?= site_url('clients/delete/'.$client['id']) ?>" class="btn btn-sm btn-danger">Eliminar</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr><td colspan="6" class="text-center">No hay clientes registrados.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <a href="<?= site_url('clients/create') ?>" class="btn btn-success">Agregar Nuevo Cliente</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
