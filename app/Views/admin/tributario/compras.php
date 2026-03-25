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
                                                <h5>Registro de Compras</h5>
                                                <a href="/dashboard/tributario/registrar_compra" class="btn btn-primary btn-sm float-right">
                                                    <i class="feather icon-plus"></i> Nueva Compra
                                                </a>
                                                <span class="d-block m-t-5">Control y seguimiento de compras con IGV</span>
                                            </div>
                                            <div class="card-block">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Documento</th>
                                                                <th>Proveedor</th>
                                                                <th>Monto Bruto</th>
                                                                <th>IGV</th>
                                                                <th>Total</th>
                                                                <th>Fecha</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($compras)): ?>
                                                                <?php foreach ($compras as $compra): ?>
                                                                    <tr>
                                                                        <td><?php echo $compra['numero_documento']; ?></td>
                                                                        <td><?php echo $compra['proveedor']; ?></td>
                                                                        <td>$<?php echo number_format($compra['monto_bruto'], 2); ?></td>
                                                                        <td>$<?php echo number_format($compra['igv'], 2); ?></td>
                                                                        <td><strong>$<?php echo number_format($compra['monto_total'], 2); ?></strong></td>
                                                                        <td><?php echo $compra['fecha_compra']; ?></td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <tr><td colspan="6" class="text-center text-muted">No hay compras</td></tr>
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
