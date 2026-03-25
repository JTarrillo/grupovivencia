<?php echo view('admin/header'); ?>

<section class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Requerimientos</h5>
                                <a href="/documental/crear_requerimiento" class="btn btn-primary btn-sm float-right">+ Nuevo Requerimiento</a>
                            </div>
                            <div class="card-block">
                                <?php if (session()->getFlashdata('success')): ?>
                                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                                <?php endif; ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Cliente</th>
                                                <th>Tipo</th>
                                                <th>Documento Requerido</th>
                                                <th>Vencimiento</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($requerimientos)): ?>
                                                <?php foreach ($requerimientos as $req): ?>
                                                <tr>
                                                    <td><?= $req['cliente_id'] ?></td>
                                                    <td><?= esc($req['tipo_requerimiento']) ?></td>
                                                    <td><?= esc($req['documento_requerido']) ?></td>
                                                    <td><?= $req['fecha_vencimiento'] ?></td>
                                                    <td><span class="label label-warning"><?= ucfirst($req['estado']) ?></span></td>
                                                    <td>
                                                        <a href="/documental/actualizar_requerimiento/<?= $req['id'] ?>" class="btn btn-info btn-xs">Actualizar</a>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr><td colspan="6" class="text-center">Sin requerimientos</td></tr>
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
