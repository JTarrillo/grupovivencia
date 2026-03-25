<?php echo view('admin/header'); ?>

<section class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Archivos Digitales</h5>
                                <a href="/documental/subir_archivo" class="btn btn-primary btn-sm float-right">+ Subir Archivo</a>
                            </div>
                            <div class="card-block">
                                <?php if (session()->getFlashdata('success')): ?>
                                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                                <?php endif; ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Tipo Documento</th>
                                                <th>Tamaño</th>
                                                <th>Fecha Subida</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($archivos)): ?>
                                                <?php foreach ($archivos as $arch): ?>
                                                <tr>
                                                    <td><?= esc($arch['nombre_original']) ?></td>
                                                    <td><?= esc($arch['tipo_documento']) ?></td>
                                                    <td><?= number_format($arch['tamaño'] / 1024, 2) ?> KB</td>
                                                    <td><?= $arch['fecha_subida'] ?></td>
                                                    <td><span class="label label-success"><?= esc($arch['estado']) ?></span></td>
                                                    <td>
                                                        <a href="/documental/descargar_archivo/<?= $arch['id'] ?>" class="btn btn-info btn-xs">Descargar</a>
                                                        <a href="/documental/eliminar_archivo/<?= $arch['id'] ?>" class="btn btn-danger btn-xs" onclick="return confirm('¿Está seguro?')">Eliminar</a>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr><td colspan="6" class="text-center">Sin archivos</td></tr>
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
