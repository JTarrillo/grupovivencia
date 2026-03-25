<?php echo view('admin/header'); ?>

<section class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Gestión de Proveedores</h5>
                                <a href="/pagos/crear_proveedor" class="btn btn-primary btn-sm float-right">+ Nuevo Proveedor</a>
                            </div>
                            <div class="card-block">
                                <?php if (session()->getFlashdata('success')): ?>
                                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                                <?php endif; ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Razón Social</th>
                                                <th>RUC</th>
                                                <th>Contacto</th>
                                                <th>Teléfono</th>
                                                <th>Email</th>
                                                <th>Tipo</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($proveedores)): ?>
                                                <?php foreach ($proveedores as $prov): ?>
                                                <tr>
                                                    <td><?= esc($prov['razon_social']) ?></td>
                                                    <td><?= esc($prov['ruc']) ?></td>
                                                    <td><?= esc($prov['contacto']) ?></td>
                                                    <td><?= esc($prov['telefono']) ?></td>
                                                    <td><?= esc($prov['email']) ?></td>
                                                    <td><?= esc($prov['tipo_proveedor']) ?></td>
                                                    <td>
                                                        <a href="/pagos/editar_proveedor/<?= $prov['id'] ?>" class="btn btn-warning btn-xs">Editar</a>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr><td colspan="7" class="text-center">Sin proveedores registrados</td></tr>
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
</section>
