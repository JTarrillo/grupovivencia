<!doctype html>
<html lang="es-PE">

<?php echo view("admin/head"); ?>

<body>
    <?php echo view("admin/header"); ?>
    
    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Recibos de Honorarios</h5>
                                                <a href="/dashboard/pagos/crear_recibo" class="btn btn-primary btn-sm float-right">
                                                    <i class="feather icon-plus"></i> Nuevo Recibo
                                                </a>
                                                <span class="d-block m-t-5">Registro y emisión de recibos de honorarios profesionales</span>
                                            </div>
                                            <div class="card-block">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Número</th>
                                                                <th>Beneficiario</th>
                                                                <th>Monto</th>
                                                                <th>Concepto</th>
                                                                <th>Estado</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($recibos)): ?>
                                                                <?php foreach ($recibos as $recibo): ?>
                                                                    <tr>
                                                                        <td><strong><?php echo $recibo['numero_recibo']; ?></strong></td>
                                                                        <td><?php echo $recibo['beneficiario']; ?></td>
                                                                        <td>$<?php echo number_format($recibo['monto'], 2); ?></td>
                                                                        <td><?php echo $recibo['concepto']; ?></td>
                                                                        <td><span class="label label-success"><?php echo $recibo['estado']; ?></span></td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <tr><td colspan="5" class="text-center text-muted">No hay recibos registrados</td></tr>
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
                </div>
            </div>
        </div>
    </section>

    <?php echo view("admin/footer"); ?>
</body>
</html>
