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
                                                            <th>Fecha Generada</th>
                                                            <th>Nombre</th>
                                                            <th>Beneficiario</th>
                                                            <th>Tipo de Comisión</th>
                                                            <th>Monto</th>
                                                            <th>Porcentaje</th>
                                                            <th>Venta</th>
                                                            <th>Estado Comisión</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($comisionesData)): ?>
                                                        <?php foreach ($comisionesData as $c): ?>
                                                        <tr>
                                                            <td><?= esc($c['id']) ?></td>
                                                            <td><?= date('d/m/Y H:i', strtotime($c['fecha_generada'])) ?>
                                                            </td>
                                                            <td><?= !empty($c['customer_name']) ? esc($c['customer_name']) : '-' ?>
                                                            </td>
                                                            <td>
                                                                <?php if (!empty($c['beneficiario_id'])): ?>
                                                                <small>ID: <?= esc($c['beneficiario_id']) ?></small>
                                                                <?php else: ?>
                                                                -
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                switch ($c['tipo_comision']) {
                                                                    case 'bono_reserva': echo 'Bono de Reserva'; break;
                                                                    case 'venta_base': echo 'Comisión Base'; break;
                                                                    case 'nivel_1': echo 'Nivel 1'; break;
                                                                    case 'nivel_2': echo 'Nivel 2'; break;
                                                                    default: echo ucfirst($c['tipo_comision']);
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                // Mostrar desglose si es reserva
                                                                $isReserva = false;
                                                                $monto5 = null;
                                                                // Intentar obtener el monto base desde el contrato si no está en el array
                                                                if (
                                                                    isset($c['venta_id']) &&
                                                                    isset($c['tipo_comision']) &&
                                                                    $c['tipo_comision'] === 'venta_base'
                                                                ) {
                                                                    if (isset($c['total_amount'])) {
                                                                        $base = floatval($c['total_amount']);
                                                                    } else {
                                                                        // Buscar el contrato en la BD si no está en el array
                                                                        $db = \Config\Database::connect();
                                                                        $contrato = $db->table('contracts')->where('id', $c['venta_id'])->get()->getRowArray();
                                                                        $base = isset($contrato['total_amount']) ? floatval($contrato['total_amount']) : null;
                                                                    }
                                                                    $monto5 = $base ? round($base * 0.05, 2) : null;
                                                                    if ($monto5 !== null && abs(floatval($c['monto']) - ($monto5 + 300)) < 1.01) {
                                                                        $isReserva = true;
                                                                    }
                                                                }
                                                                if ($isReserva && $monto5 !== null) {
                                                                    echo 'S/ ' . number_format($monto5, 2) . ' <span style="color:#2196f3;font-weight:bold;">+ S/ 300 (reserva)</span><br><b>Total: S/ ' . number_format($c['monto'], 2) . '</b>';
                                                                } else {
                                                                    echo 'S/ ' . number_format($c['monto'], 2);
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?= $c['porcentaje'] !== null ? $c['porcentaje'] . '%' : '-' ?>
                                                            </td>
                                                            <td><?= esc($c['venta_id']) ?></td>
                                                            <td>
                                                                <?php
                                                                switch ($c['estado']) {
                                                                    case 'pendiente':
                                                                        echo '<span class="badge" style="background:#ffe082;color:#333;">Pendiente</span>';
                                                                        break;
                                                                    case 'aprobada':
                                                                        echo '<span class="badge" style="background:#b3e5fc;color:#333;">Aprobada</span>';
                                                                        break;
                                                                    case 'pagada':
                                                                        echo '<span class="badge" style="background:#c8e6c9;color:#333;">Pagada</span>';
                                                                        break;
                                                                    case 'rechazada':
                                                                        echo '<span class="badge" style="background:#ffcdd2;color:#333;">Rechazada</span>';
                                                                        break;
                                                                    default:
                                                                        echo '<span class="badge bg-secondary">' . esc($c['estado']) . '</span>';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td style="text-align:center;">
                                                                <!-- Dropdown Cambiar Estado -->
                                                                <div class="dropdown" style="display:inline-block;">
                                                                    <button class="btn btn-outline-info btn-sm dropdown-toggle" 
                                                                            type="button" 
                                                                            id="dropdownEstado<?= esc($c['id']) ?>" 
                                                                            data-bs-toggle="dropdown" 
                                                                            aria-expanded="false"
                                                                            title="Cambiar estado">
                                                                        <i class="fa fa-edit"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu" aria-labelledby="dropdownEstado<?= esc($c['id']) ?>">
                                                                        <li>
                                                                            <form method="POST" action="/admin/comisiones/cambiar_estado" class="status-form-item" style="display:inline;">
                                                                                <input type="hidden" name="id" value="<?= esc($c['id']) ?>">
                                                                                <input type="hidden" name="estado" value="pendiente">
                                                                                <button type="button" class="dropdown-item status-btn-item">Pendiente</button>
                                                                            </form>
                                                                        </li>
                                                                        <li>
                                                                            <form method="POST" action="/admin/comisiones/cambiar_estado" class="status-form-item" style="display:inline;">
                                                                                <input type="hidden" name="id" value="<?= esc($c['id']) ?>">
                                                                                <input type="hidden" name="estado" value="aprobada">
                                                                                <button type="button" class="dropdown-item status-btn-item">Aprobada</button>
                                                                            </form>
                                                                        </li>
                                                                        <li>
                                                                            <form method="POST" action="/admin/comisiones/cambiar_estado" class="status-form-item" style="display:inline;">
                                                                                <input type="hidden" name="id" value="<?= esc($c['id']) ?>">
                                                                                <input type="hidden" name="estado" value="pagada">
                                                                                <button type="button" class="dropdown-item status-btn-item">Pagada</button>
                                                                            </form>
                                                                        </li>
                                                                        <li>
                                                                            <form method="POST" action="/admin/comisiones/cambiar_estado" class="status-form-item" style="display:inline;">
                                                                                <input type="hidden" name="id" value="<?= esc($c['id']) ?>">
                                                                                <input type="hidden" name="estado" value="rechazada">
                                                                                <button type="button" class="dropdown-item status-btn-item">Rechazada</button>
                                                                            </form>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                
                                                                <!-- Botón Eliminar -->
                                                                <form method="POST" action="/admin/comisiones/eliminar"
                                                                    class="delete-form" style="display:inline;">
                                                                    <input type="hidden" name="id"
                                                                        value="<?= esc($c['id']) ?>">
                                                                    <button type="button"
                                                                        class="btn btn-outline-danger btn-sm delete-btn"
                                                                        style="background-color: #f8d7da; color: #721c24; border: none;"
                                                                        title="Eliminar permanentemente">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                                <script
                                                                    src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
                                                                </script>
                                                                <script>
                                                                // Botones del dropdown Cambiar Estado
                                                                document.querySelectorAll('.status-btn-item').forEach(
                                                                    function(btn) {
                                                                        btn.addEventListener('click', function(e) {
                                                                            e.preventDefault();
                                                                            const form = btn.closest('form');
                                                                            const estado = form.querySelector('input[name="estado"]').value;
                                                                            
                                                                            const textos = {
                                                                                'pendiente': 'Cambiar a Pendiente',
                                                                                'aprobada': 'Cambiar a Aprobada',
                                                                                'pagada': 'Cambiar a Pagada',
                                                                                'rechazada': 'Cambiar a Rechazada'
                                                                            };
                                                                            
                                                                            Swal.fire({
                                                                                title: '¿Estás seguro?',
                                                                                text: 'Se cambiará el estado de la comisión a: ' + estado.toUpperCase(),
                                                                                icon: 'info',
                                                                                showCancelButton: true,
                                                                                confirmButtonColor: '#3085d6',
                                                                                cancelButtonColor: '#6c757d',
                                                                                confirmButtonText: 'Sí, cambiar',
                                                                                cancelButtonText: 'Cancelar'
                                                                            }).then((result) => {
                                                                                if (result.isConfirmed) {
                                                                                    form.submit();
                                                                                }
                                                                            });
                                                                        });
                                                                    });

                                                                // Botón Eliminar
                                                                document.querySelectorAll('.delete-btn').forEach(
                                                                    function(btn) {
                                                                        btn.addEventListener('click', function(e) {
                                                                            e.preventDefault();
                                                                            Swal.fire({
                                                                                title: '¿ELIMINAR PERMANENTEMENTE?',
                                                                                text: 'Esta acción eliminará la comisión de forma PERMANENTE de la base de datos. No se puede deshacer.',
                                                                                icon: 'error',
                                                                                showCancelButton: true,
                                                                                confirmButtonColor: '#d33',
                                                                                cancelButtonColor: '#3085d6',
                                                                                confirmButtonText: 'Sí, eliminar',
                                                                                cancelButtonText: 'Cancelar'
                                                                            }).then((result) => {
                                                                                if (result.isConfirmed) {
                                                                                    btn.closest('form').submit();
                                                                                }
                                                                            });
                                                                        });
                                                                    });
                                                                </script>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                        <?php else: ?>
                                                        <tr>
                                                            <td colspan="8" class="text-center">No hay comisiones
                                                                registradas.</td>
                                                        </tr>
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