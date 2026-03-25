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
                                                <h5>Declaraciones Tributarias</h5>
                                                <a href="/dashboard/tributario/crear_declaracion" class="btn btn-primary btn-sm float-right">
                                                    <i class="feather icon-plus"></i> Nueva Declaración
                                                </a>
                                                <span class="d-block m-t-5">Gestión de declaraciones de impuestos</span>
                                            </div>
                                            <div class="card-block">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
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
                                                                        <td><?php echo $decl['periodo']; ?></td>
                                                                        <td>$<?php echo number_format($decl['total_ventas'], 2); ?></td>
                                                                        <td>$<?php echo number_format($decl['total_compras'], 2); ?></td>
                                                                        <td><strong>$<?php echo number_format($decl['igv_a_pagar'], 2); ?></strong></td>
                                                                        <td><span class="label label-info"><?php echo $decl['estado']; ?></span></td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <tr><td colspan="5" class="text-center text-muted">No hay declaraciones</td></tr>
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
