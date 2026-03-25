<?php echo view('admin/header'); ?>

<section class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Registro de Ventas</h5>
                                <a href="/tributario/registrar_venta" class="btn btn-primary btn-sm float-right">+ Nueva Venta</a>
                            </div>
                            <div class="card-block">
                                <?php if (session()->getFlashdata('success')): ?>
                                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                                <?php endif; ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Cliente</th>
                                                <th>Comprobante</th>
                                                <th>Subtotal</th>
                                                <th>IGV</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($ventas)): ?>
                                                <?php foreach ($ventas as $vta): ?>
                                                <tr>
                                                    <td><?= $vta['fecha_venta'] ?></td>
                                                    <td><?= $vta['cliente_id'] ?></td>
                                                    <td><?= esc($vta['numero_comprobante']) ?></td>
                                                    <td><?= number_format($vta['subtotal'], 2) ?></td>
                                                    <td><?= number_format($vta['igv'], 2) ?></td>
                                                    <td><?= number_format($vta['total'], 2) ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr><td colspan="6" class="text-center">Sin ventas registradas</td></tr>
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
