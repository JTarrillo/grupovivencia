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
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="col-12">
                                                <h5>Información del Registro</h5>
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
                                                <label class="control-label">Ciudad</label>
                                                <p class="form-control-static"><?= htmlspecialchars($registro['ciudad'] ?? 'No proporcionado') ?></p>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Interés</label>
                                                <p class="form-control-static"><?= htmlspecialchars($registro['interes'] ?? 'No especificado') ?></p>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Mensaje</label>
                                                <p class="form-control-static">
                                                    <?= nl2br(htmlspecialchars($registro['mensaje'] ?? 'Sin mensaje')) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <!-- ESTADO -->
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="col-12">
                                                <h5>Estado</h5>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <p class="text-center">
                                                <span class="badge bg-<?= $registro['estado'] == 'confirmado' ? 'success' : ($registro['estado'] == 'pendiente' ? 'warning' : 'danger') ?>" style="font-size: 16px; padding: 10px;">
                                                    <?= ucfirst($registro['estado']) ?>
                                                </span>
                                            </p>
                                        </div>
                                    </div>

                                    <!-- INFORMACIÓN DE FECHAS -->
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="col-12">
                                                <h5>Información de Registro</h5>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <div class="form-group">
                                                <label class="control-label">Fecha de Registro</label>
                                                <p class="form-control-static">
                                                    <?= date('d/m/Y H:i:s', strtotime($registro['fecha_registro'])) ?>
                                                </p>
                                            </div>
                                            <?php if ($registro['fecha_confirmacion']): ?>
                                                <div class="form-group">
                                                    <label class="control-label">Fecha de Confirmación</label>
                                                    <p class="form-control-static">
                                                        <?= date('d/m/Y H:i:s', strtotime($registro['fecha_confirmacion'])) ?>
                                                    </p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- ACCIONES -->
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="col-12">
                                                <h5>Acciones</h5>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <div class="btn-group-vertical w-100">
                                                <?php if ($registro['estado'] != 'confirmado'): ?>
                                                    <button class="btn btn-success btn-block mb-2" onclick="confirmar_registro(<?= $registro['id'] ?>)">
                                                        <i class="fa fa-check"></i> Confirmar Registro
                                                    </button>
                                                <?php endif; ?>

                                                <?php if ($registro['estado'] != 'cancelado'): ?>
                                                    <button class="btn btn-danger btn-block mb-2" onclick="cambiar_estado(<?= $registro['id'] ?>, 'cancelado')">
                                                        <i class="fa fa-times"></i> Cancelar Registro
                                                    </button>
                                                <?php endif; ?>

                                                <a href="mailto:<?= htmlspecialchars($registro['email']) ?>" class="btn btn-info btn-block mb-2">
                                                    <i class="fa fa-envelope"></i> Enviar Email
                                                </a>

                                                <a href="<?= site_url('admin/viveland_registros') ?>" class="btn btn-secondary btn-block">
                                                    <i class="fa fa-arrow-left"></i> Volver
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
    </script>
</body>
</html>
