<!doctype html>
<html lang="es-PE">
<?php echo view("admin/head"); ?>

<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php echo view("admin/header"); ?>
    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">Comisiones Inmobiliarias</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a
                                                href="<?php echo site_url() . "dashboard/panel"; ?>">Panel</a></li>
                                        <li class="breadcrumb-item"><a>Comisiones</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Listado de Comisiones</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <?php
                                                $comisionesData = isset($obj_commissions) ? $obj_commissions : (isset($comisiones) ? $comisiones : []);
                                                if (!empty($comisionesData)) {
                                                    $logPath = WRITEPATH . 'logs/comisionadmin.log';
                                                    $logMsg = date('Y-m-d H:i:s') . "\n" . print_r($comisionesData, true) . "\n----------------------\n";
                                                    file_put_contents($logPath, $logMsg, FILE_APPEND);
                                                }
                                                ?>
                                                <table class="table table-bordered table-hover align-middle">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Fecha</th>
                                                            <th>Cliente</th>
                                                            <th>Tipo</th>
                                                            <th>Porcentaje</th>
                                                            <th>Monto</th>
                                                            <th>Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($comisionesData)): ?>
                                                        <?php foreach ($comisionesData as $c): ?>
                                                        <tr>
                                                            <td><?= esc($c['id'] ?? '-') ?></td>
                                                            <td><?= isset($c['fecha_generada']) ? date('d/m/Y', strtotime($c['fecha_generada'])) : '-' ?>
                                                            </td>
                                                            <td><?= esc($c['customer_name'] ?? $c['beneficiario_id'] ?? '-') ?>
                                                            </td>
                                                            <td><?= esc($c['tipo_comision'] ?? '-') ?></td>
                                                            <td><?= esc($c['porcentaje'] ?? '-') ?>%</td>
                                                            <td>S/ <?= number_format($c['monto'] ?? 0, 2) ?></td>
                                                            <td>
                                                                <span
                                                                    class="label <?= (strtolower($c['estado'] ?? '') == 'pagada') ? 'label-success' : 'label-warning' ?>">
                                                                    <?= esc($c['estado'] ?? 'pendiente') ?>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                        <?php else: ?>
                                                        <tr>
                                                            <td colspan="7" class="text-center text-muted">No hay
                                                                comisiones registradas</td>
                                                        </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
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
    </section>
    <?php echo view("admin/footer"); ?>
    <?php if (session('success')): ?>
    <script>
    Swal.fire({
        icon: 'success',
        title: '¡Rechazado!',
        text: '<?= session('success') ?>',
        confirmButtonColor: '#3085d6',
    });
    </script>
    <?php endif; ?>
</body>

</html>