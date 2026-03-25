<?php echo view('admin/header'); ?>

<section class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Declaraciones Tributarias</h5>
                                <a href="/tributario/crear_declaracion" class="btn btn-primary btn-sm float-right">+ Nueva Declaración</a>
                            </div>
                            <div class="card-block">
                                <?php if (session()->getFlashdata('success')): ?>
                                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                                <?php endif; ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Período</th>
                                                <th>Total Ventas</th>
                                                <th>Total Compras</th>
                                                <th>IGV a Pagar</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($declaraciones)): ?>
                                                <?php foreach ($declaraciones as $decl): ?>
                                                <tr>
                                                    <td><?= $decl['periodo'] ?></td>
                                                    <td><?= number_format($decl['total_ventas'], 2) ?></td>
                                                    <td><?= number_format($decl['total_compras'], 2) ?></td>
                                                    <td><?= number_format($decl['igv_a_pagar'], 2) ?></td>
                                                    <td><span class="label label-info"><?= ucfirst($decl['estado']) ?></span></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr><td colspan="5" class="text-center">Sin declaraciones</td></tr>
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
