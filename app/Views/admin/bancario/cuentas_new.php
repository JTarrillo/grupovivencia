<!doctype html>
<html lang="es-PE">

<?php echo view("admin/head"); ?>

<body>
    <div id="cronogramaModalContainer"></div>
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
                                                <h5>Cuentas Bancarias</h5>
                                                <a href="/dashboard/bancario/crear_cuenta" class="btn btn-primary btn-sm float-right">
                                                    <i class="feather icon-plus"></i> Nueva Cuenta
                                                </a>
                                                <span class="d-block m-t-5">Gestión de cuentas bancarias del sistema</span>
                                            </div>
                                            <div class="card-block">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Banco</th>
                                                                <th>Número de Cuenta</th>
                                                                <th>Titular</th>
                                                                <th>Saldo Actual</th>
                                                                <th>Estado</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($cuentas)): ?>
                                                                <?php foreach ($cuentas as $cuenta): ?>
                                                                    <tr>
                                                                        <td><?php echo $cuenta['banco']; ?></td>
                                                                        <td><?php echo $cuenta['numero_cuenta']; ?></td>
                                                                        <td><?php echo $cuenta['titular']; ?></td>
                                                                        <td><strong>$<?php echo number_format($cuenta['saldo_actual'], 2); ?></strong></td>
                                                                        <td><span class="label label-success"><?php echo $cuenta['estado']; ?></span></td>
                                                                        <td>
                                                                            <a href="/dashboard/bancario/editar_cuenta/<?php echo $cuenta['id']; ?>" class="label theme-bg text-white f-12">Editar</a>
                                                                            <a href="/dashboard/bancario/movimientos/<?php echo $cuenta['id']; ?>" class="label theme-bg2 text-white f-12">Movimientos</a>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <tr><td colspan="6" class="text-center text-muted">No hay cuentas registradas</td></tr>
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
