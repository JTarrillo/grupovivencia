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
                                        <h5 class="m-b-10">Registros VIVELAND</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard/">Panel</a></li>
                                        <li class="breadcrumb-item"><a>Registros VIVELAND</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- ESTADÍSTICAS -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="card text-center">
                                        <div class="card-block">
                                            <h6 class="m-0">Total</h6>
                                            <h3 class="m-b-0 text-primary"><?= $stats['total'] ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-center">
                                        <div class="card-block">
                                            <h6 class="m-0">Pendiente</h6>
                                            <h3 class="m-b-0 text-warning"><?= $stats['pendiente'] ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-center">
                                        <div class="card-block">
                                            <h6 class="m-0">Confirmado</h6>
                                            <h3 class="m-b-0 text-success"><?= $stats['confirmado'] ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-center">
                                        <div class="card-block">
                                            <h6 class="m-0">Cancelado</h6>
                                            <h3 class="m-b-0 text-danger"><?= $stats['cancelado'] ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TABLA DE REGISTROS -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="col-12 mb-3">
                                                <h5>Listado de Registros</h5>
                                            </div>
                                            <div class="col-12">
                                                <a href="<?= site_url('admin/viveland_registros/exportar') ?>" class="btn btn-success">
                                                    <i class="fa fa-download"></i> Exportar CSV
                                                </a>
                                            </div>
                                        </div>

                                        <div class="card-block">
                                            <!-- FILTROS -->
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" id="search" placeholder="Buscar nombre, email, ciudad..." value="<?= $filtros['search'] ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-control" id="filtro_estado">
                                                        <option value="">Todos</option>
                                                        <option value="pendiente" <?= $filtros['estado'] == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                                        <option value="confirmado" <?= $filtros['estado'] == 'confirmado' ? 'selected' : '' ?>>Confirmado</option>
                                                        <option value="cancelado" <?= $filtros['estado'] == 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <button class="btn btn-primary w-100" onclick="filtrar()">Filtrar</button>
                                                </div>
                                                <div class="col-md-2">
                                                    <button class="btn btn-secondary w-100" onclick="limpiar_filtros()">Limpiar</button>
                                                </div>
                                            </div>

                                            <!-- TABLA -->
                                            <div class="table-responsive">
                                                <table id="viveland-table" class="display table nowrap table-striped table-hover dataTable" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Nombre</th>
                                                            <th>Email</th>
                                                            <th>Teléfono</th>
                                                            <th>Ciudad</th>
                                                            <th>Interés</th>
                                                            <th>Estado</th>
                                                            <th>Fecha Registro</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (count($registros) > 0): ?>
                                                            <?php foreach ($registros as $index => $registro): ?>
                                                                <tr>
                                                                    <td><?= $registro['id'] ?></td>
                                                                    <td><?= htmlspecialchars($registro['nombre']) ?></td>
                                                                    <td><?= htmlspecialchars($registro['email']) ?></td>
                                                                    <td><?= htmlspecialchars($registro['telefono'] ?? '-') ?></td>
                                                                    <td><?= htmlspecialchars($registro['ciudad'] ?? '-') ?></td>
                                                                    <td><?= htmlspecialchars($registro['interes'] ?? '-') ?></td>
                                                                    <td>
                                                                        <span class="badge bg-<?= $registro['estado'] == 'confirmado' ? 'success' : ($registro['estado'] == 'pendiente' ? 'warning' : 'danger') ?>">
                                                                            <?= ucfirst($registro['estado']) ?>
                                                                        </span>
                                                                    </td>
                                                                    <td><?= date('d/m/Y H:i', strtotime($registro['fecha_registro'])) ?></td>
                                                                    <td>
                                                                        <a href="<?= site_url("admin/viveland_registros/view/" . $registro['id']) ?>" class="btn btn-sm btn-info" title="Ver detalles">
                                                                            <i class="fa fa-eye"></i>
                                                                        </a>
                                                                        <?php if ($registro['estado'] != 'confirmado'): ?>
                                                                            <button class="btn btn-sm btn-success" onclick="confirmar_registro(<?= $registro['id'] ?>)" title="Confirmar">
                                                                                <i class="fa fa-check"></i>
                                                                            </button>
                                                                        <?php endif; ?>
                                                                        <?php if ($registro['estado'] != 'cancelado'): ?>
                                                                            <button class="btn btn-sm btn-danger" onclick="cambiar_estado(<?= $registro['id'] ?>, 'cancelado')" title="Cancelar">
                                                                                <i class="fa fa-times"></i>
                                                                            </button>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <tr>
                                                                <td colspan="9" class="text-center text-muted py-4">
                                                                    Sin registros encontrados
                                                                </td>
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

    <script>
        function filtrar() {
            const search = document.getElementById('search').value;
            const estado = document.getElementById('filtro_estado').value;

            let url = '<?= site_url("admin/viveland_registros") ?>';
            const params = new URLSearchParams();

            if (search) params.append('search', search);
            if (estado) params.append('estado', estado);

            if (params.toString()) {
                url += '?' + params.toString();
            }

            window.location.href = url;
        }

        function limpiar_filtros() {
            window.location.href = '<?= site_url("admin/viveland_registros") ?>';
        }

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
