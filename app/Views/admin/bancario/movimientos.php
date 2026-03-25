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
                                                <h5>Movimientos de Cuenta: <?= esc($cuenta['numero_cuenta']) ?></h5>
                                                <a href="/dashboard/bancario/agregar_movimiento/<?= $cuenta['id'] ?>" class="btn btn-success btn-sm float-right">
                                                    <i class="feather icon-plus"></i> Nuevo Movimiento
                                                </a>
                                                <span class="d-block m-t-5">Banco: <?= esc($cuenta['banco']) ?> | Saldo: S/ <?= number_format($cuenta['saldo'], 2) ?></span>
                                            </div>
                                            <div class="card-block">

                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Fecha</th>
                                                                <th>Tipo</th>
                                                                <th>Monto</th>
                                                                <th>Saldo Anterior</th>
                                                                <th>Saldo Nuevo</th>
                                                                <th>Descripción</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($movimientos)): ?>
                                                                <?php foreach ($movimientos as $mov): ?>
                                                                    <tr>
                                                                        <td><?= date('d/m/Y', strtotime($mov['fecha'])) ?></td>
                                                                        <td>
                                                                            <span class="label <?= $mov['tipo'] === 'entrada' ? 'label-success' : 'label-danger' ?>">
                                                                                <?= ucfirst($mov['tipo']) ?>
                                                                            </span>
                                                                        </td>
                                                                        <td>S/ <?= number_format($mov['monto'], 2) ?></td>
                                                                        <td>S/ <?= number_format($mov['saldo_anterior'], 2) ?></td>
                                                                        <td><strong>S/ <?= number_format($mov['saldo_nuevo'], 2) ?></strong></td>
                                                                        <td><?= esc($mov['descripcion']) ?></td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <tr><td colspan="6" class="text-center text-muted">No hay movimientos registrados</td></tr>
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
