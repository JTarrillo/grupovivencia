<!DOCTYPE html>
<html lang="en">
<?php echo view("backoffice_new/head"); ?>
<body data-kt-name="metronic" id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
    <?php echo view("backoffice_new/header"); ?>
    <?php echo view("backoffice_new/toolbar"); ?>
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
                    <div class="content flex-row-fluid" id="kt_content">
                        <div class="card">
                            <div class="card-header text-center">
                                <h4>Gestión de Pagos y Cronogramas</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Proyecto</th>
                                            <th>Lote</th>
                                            <th>Cuota</th>
                                            <th>Fecha de Vencimiento</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(isset($payments) && count($payments) > 0): ?>
                                            <?php foreach($payments as $payment): ?>
                                                <tr>
                                                    <td><?= esc($payment['client_name']) ?></td>
                                                    <td><?= esc($payment['project_name']) ?></td>
                                                    <td><?= esc($payment['lot_code']) ?></td>
                                                    <td><?= esc($payment['installment_number']) ?></td>
                                                    <td><?= esc($payment['due_date']) ?></td>
                                                    <td><?= esc($payment['status']) ?></td>
                                                    <td>
                                                        <a href="<?= site_url('payments/edit/'.$payment['id']) ?>" class="btn btn-sm btn-primary">Editar</a>
                                                        <a href="<?= site_url('payments/delete/'.$payment['id']) ?>" class="btn btn-sm btn-danger">Eliminar</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr><td colspan="7" class="text-center">No hay pagos registrados.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <a href="<?= site_url('payments/create') ?>" class="btn btn-success">Agregar Nuevo Pago</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
