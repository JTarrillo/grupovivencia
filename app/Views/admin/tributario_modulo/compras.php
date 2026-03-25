<?php echo view('admin/header'); ?>

<section class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Registro de Compras</h5>
                                <a href="/tributario/registrar_compra" class="btn btn-primary btn-sm float-right">+ Nueva Compra</a>
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
                                                <th>Proveedor</th>
                                                <th>Comprobante</th>
                                                <th>Subtotal</th>
                                                <th>IGV</th>
                                                <th>Total</th>
                                                <th>Clasificación</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($compras)): ?>
                                                <?php foreach ($compras as $comp): ?>
                                                <tr>
                                                    <td><?= $comp['fecha_compra'] ?></td>
                                                    <td><?= $comp['proveedor_id'] ?></td>
                                                    <td><?= esc($comp['numero_comprobante']) ?></td>
                                                    <td><?= number_format($comp['subtotal'], 2) ?></td>
                                                    <td><?= number_format($comp['igv'], 2) ?></td>
                                                    <td><?= number_format($comp['total'], 2) ?></td>
                                                    <td><?= esc($comp['clasificacion']) ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr><td colspan="7" class="text-center">Sin compras registradas</td></tr>
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
