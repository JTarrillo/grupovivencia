<?php echo view('admin/header'); ?>

<section class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Gestión de Comisiones</h5>
                                <a href="/pagos/crear_comision" class="btn btn-primary btn-sm float-right">+ Nueva Comisión</a>
                            </div>
                            <div class="card-block">
                                <?php if (session()->getFlashdata('success')): ?>
                                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                                <?php endif; ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Contrato</th>
                                                <th>Agente</th>
                                                <th>Porcentaje</th>
                                                <th>Monto Total</th>
                                                <th>Comisión</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($comisiones)): ?>
                                                <?php foreach ($comisiones as $com): ?>
                                                <tr>
                                                    <td><?= $com['contrato_id'] ?></td>
                                                    <td><?= $com['agente_id'] ?></td>
                                                    <td><?= $com['porcentaje'] ?>%</td>
                                                    <td><?= number_format($com['monto_total'], 2) ?></td>
                                                    <td><?= number_format($com['monto_comision'], 2) ?></td>
                                                    <td><span class="label label-info"><?= ucfirst($com['estado']) ?></span></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr><td colspan="6" class="text-center">Sin comisiones</td></tr>
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
