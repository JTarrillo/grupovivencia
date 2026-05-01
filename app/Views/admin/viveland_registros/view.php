<html>
<?php echo view("admin/head"); ?>

<body data-new-gr-c-s-check-loaded="14.1042.0" data-gr-ext-installed="">
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
                                        <h5 class="m-b-10">Detalles del Registro</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard/">Panel</a></li>
                                        <li class="breadcrumb-item"><a href="<?= site_url('admin/viveland_registros') ?>">Registros VIVELAND</a></li>
                                        <li class="breadcrumb-item"><a>Detalles</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header" style="background: linear-gradient(135deg, #5a7ca8 0%, #6b8dbf 100%); color: white; border: none;">
                                            <div class="col-12">
                                                <h5 class="m-0"><i class="fa fa-user"></i> Información del Registro</h5>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <div class="form-group">
                                                <label class="control-label">Nombre</label>
                                                <p class="form-control-static"><?= htmlspecialchars($registro['nombre']) ?></p>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Email</label>
                                                <p class="form-control-static">
                                                    <a href="mailto:<?= htmlspecialchars($registro['email']) ?>">
                                                        <?= htmlspecialchars($registro['email']) ?>
                                                    </a>
                                                </p>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Teléfono</label>
                                                <p class="form-control-static"><?= htmlspecialchars($registro['telefono'] ?? 'No proporcionado') ?></p>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Zona Seleccionada</label>
                                                <p class="form-control-static">
                                                    <span class="badge" style="font-size: 1rem; padding: 8px 12px; background-color: <?= match($registro['zona']) {
                                                        'Zona Viveland' => '#8B4513',
                                                        'Zona VIP' => '#FFD700',
                                                        'Zona Platinum' => '#C0C0C0',
                                                        'Zona General' => '#87CEEB',
                                                        default => '#6c757d'
                                                    } ?>; color: <?= in_array($registro['zona'], ['Zona VIP', 'Zona Platinum']) ? '#000' : '#fff' ?>">
                                                        <?= htmlspecialchars($registro['zona'] ?? 'No especificada') ?>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Interés Principal</label>
                                                <p class="form-control-static">
                                                    <i class="fa fa-star" style="color: #FFD700;"></i> <?= htmlspecialchars($registro['interes'] ?? 'No especificado') ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <!-- ESTADO -->
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header" style="background: linear-gradient(135deg, #c994ca 0%, #d9a5d9 100%); color: white; border: none;">
                                            <div class="col-12">
                                                <h5 class="m-0"><i class="fa fa-info-circle"></i> Estado Actual</h5>
                                            </div>
                                        </div>
                                        <div class="card-block text-center py-4">
                                            <span class="badge bg-<?= $registro['estado'] == 'confirmado' ? 'success' : ($registro['estado'] == 'pendiente' ? 'warning' : 'danger') ?>" style="font-size: 18px; padding: 12px 20px;">
                                                <i class="fa fa-<?= match($registro['estado']) {
                                                    'confirmado' => 'check-circle',
                                                    'pendiente' => 'hourglass',
                                                    'cancelado' => 'times-circle',
                                                    default => 'question-circle'
                                                } ?>"></i> <?= ucfirst($registro['estado']) ?>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- INFORMACIÓN DE FECHAS -->
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header" style="background: linear-gradient(135deg, #7db3d1 0%, #9ac9e0 100%); color: white; border: none;">
                                            <div class="col-12">
                                                <h5 class="m-0"><i class="fa fa-calendar"></i> Información de Fechas</h5>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <div class="form-group">
                                                <label class="control-label"><i class="fa fa-plus-circle"></i> Fecha de Registro</label>
                                                <p class="form-control-static fw-bold">
                                                    <?= date('d/m/Y \a \l\a\s H:i:s', strtotime($registro['fecha_registro'])) ?>
                                                </p>
                                            </div>
                                            <?php if ($registro['fecha_confirmacion']): ?>
                                                <div class="form-group">
                                                    <label class="control-label"><i class="fa fa-check-circle"></i> Fecha de Confirmación</label>
                                                    <p class="form-control-static fw-bold text-success">
                                                        <?= date('d/m/Y \a \l\a\s H:i:s', strtotime($registro['fecha_confirmacion'])) ?>
                                                    </p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- ACCIONES -->
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header" style="background: linear-gradient(135deg, #d8a89a 0%, #e8bfb0 100%); color: white; border: none;">
                                            <div class="col-12">
                                                <h5 class="m-0"><i class="fa fa-cogs"></i> Acciones</h5>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <div class="btn-group-vertical w-100 gap-2">
                                                <?php if ($registro['estado'] != 'confirmado'): ?>
                                                    <button class="btn btn-success" onclick="confirmar_registro(<?= $registro['id'] ?>)" style="border-radius: 8px;">
                                                        <i class="fa fa-check-circle"></i> Confirmar Registro
                                                    </button>
                                                <?php endif; ?>

                                                <?php if ($registro['estado'] != 'cancelado'): ?>
                                                    <button class="btn btn-danger" onclick="cambiar_estado(<?= $registro['id'] ?>, 'cancelado')" style="border-radius: 8px;">
                                                        <i class="fa fa-times-circle"></i> Cancelar Registro
                                                    </button>
                                                <?php endif; ?>

                                                <button class="btn btn-outline-danger" onclick="eliminar_registro(<?= $registro['id'] ?>)" style="border-radius: 8px;">
                                                    <i class="fa fa-trash"></i> Eliminar Registro
                                                </button>

                                                <a href="mailto:<?= htmlspecialchars($registro['email']) ?>" class="btn btn-info" style="border-radius: 8px;">
                                                    <i class="fa fa-envelope"></i> Enviar Email
                                                </a>

                                                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $registro['telefono']) ?>" target="_blank" class="btn btn-success" style="border-radius: 8px; background-color: #25D366;">
                                                    <i class="fab fa-whatsapp"></i> Contactar WhatsApp
                                                </a>

                                                <a href="<?= site_url('admin/viveland_registros') ?>" class="btn btn-outline-secondary" style="border-radius: 8px;">
                                                    <i class="fa fa-arrow-left"></i> Volver a la Lista
                                                </a>
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

    <script>
        function confirmar_registro(id) {
            if (confirm('¿Confirmar este registro?')) {
                fetch('<?= site_url("admin/viveland_registros/confirmar") ?>/' + id, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Registro confirmado');
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
            }
        }

        function cambiar_estado(id, estado) {
            if (confirm('¿Cambiar estado a ' + estado + '?')) {
                fetch('<?= site_url("admin/viveland_registros/cambiar_estado") ?>/' + id + '/' + estado, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Estado actualizado');
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
            }
        }

        function eliminar_registro(id) {
            if (confirm('¿Eliminar este registro de forma permanente? Esta acción no se puede deshacer.')) {
                fetch('<?= site_url("admin/viveland_registros/eliminar") ?>/' + id, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Registro eliminado correctamente');
                        window.location.href = '<?= site_url("admin/viveland_registros") ?>';
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al eliminar el registro');
                });
            }
        }
    </script>
</body>
</html>
