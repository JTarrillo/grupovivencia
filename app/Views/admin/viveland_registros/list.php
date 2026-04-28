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
                            <div class="row mb-4">
                                <div class="col-md-3 mb-3">
                                    <div class="card text-center border-0 shadow-sm" style="background: linear-gradient(135deg, #5a7ca8 0%, #6b8dbf 100%); color: white;">
                                        <div class="card-block py-4">
                                            <i class="fa fa-users" style="font-size: 2rem; opacity: 0.7;"></i>
                                            <h6 class="m-0 mt-2" style="font-size: 0.9rem; opacity: 0.9;">Total Registros</h6>
                                            <h2 class="m-b-0 mt-2 fw-bold"><?= $stats['total'] ?></h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card text-center border-0 shadow-sm" style="background: linear-gradient(135deg, #c994ca 0%, #d9a5d9 100%); color: white;">
                                        <div class="card-block py-4">
                                            <i class="fa fa-clock-o" style="font-size: 2rem; opacity: 0.7;"></i>
                                            <h6 class="m-0 mt-2" style="font-size: 0.9rem; opacity: 0.9;">Pendientes</h6>
                                            <h2 class="m-b-0 mt-2 fw-bold"><?= $stats['pendiente'] ?></h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card text-center border-0 shadow-sm" style="background: linear-gradient(135deg, #7db3d1 0%, #9ac9e0 100%); color: white;">
                                        <div class="card-block py-4">
                                            <i class="fa fa-check-circle" style="font-size: 2rem; opacity: 0.7;"></i>
                                            <h6 class="m-0 mt-2" style="font-size: 0.9rem; opacity: 0.9;">Confirmados</h6>
                                            <h2 class="m-b-0 mt-2 fw-bold"><?= $stats['confirmado'] ?></h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card text-center border-0 shadow-sm" style="background: linear-gradient(135deg, #d8a89a 0%, #e8bfb0 100%); color: white;">
                                        <div class="card-block py-4">
                                            <i class="fa fa-ban" style="font-size: 2rem; opacity: 0.7;"></i>
                                            <h6 class="m-0 mt-2" style="font-size: 0.9rem; opacity: 0.9;">Cancelados</h6>
                                            <h2 class="m-b-0 mt-2 fw-bold"><?= $stats['cancelado'] ?></h2>
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
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Nombre</th>
                                                            <th>Email</th>
                                                            <th>Teléfono</th>
                                                            <th>Zona</th>
                                                            <th>Interés</th>
                                                            <th>Estado</th>
                                                            <th>Fecha Registro</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (count($registros) > 0): ?>
                                                            <?php foreach ($registros as $index => $registro): ?>
                                                                <tr class="align-middle">
                                                                    <td><strong><?= $registro['id'] ?></strong></td>
                                                                    <td><?= htmlspecialchars($registro['nombre']) ?></td>
                                                                    <td><a href="mailto:<?= htmlspecialchars($registro['email']) ?>"><?= htmlspecialchars($registro['email']) ?></a></td>
                                                                    <td><?= htmlspecialchars($registro['telefono'] ?? '-') ?></td>
                                                                    <td>
                                                                        <span class="badge" style="background-color: <?= match($registro['zona']) {
                                                                            'Zona Viveland' => '#8B4513',
                                                                            'Zona VIP' => '#FFD700',
                                                                            'Zona Platinum' => '#C0C0C0',
                                                                            'Zona General' => '#87CEEB',
                                                                            default => '#6c757d'
                                                                        } ?>; color: <?= in_array($registro['zona'], ['Zona VIP', 'Zona Platinum']) ? '#000' : '#fff' ?>">
                                                                            <?= htmlspecialchars($registro['zona'] ?? '-') ?>
                                                                        </span>
                                                                    </td>
                                                                    <td><?= htmlspecialchars($registro['interes'] ?? '-') ?></td>
                                                                    <td>
                                                                        <span class="badge bg-<?= $registro['estado'] == 'confirmado' ? 'success' : ($registro['estado'] == 'pendiente' ? 'warning' : 'danger') ?>">
                                                                            <?= ucfirst($registro['estado']) ?>
                                                                        </span>
                                                                    </td>
                                                                    <td><small><?= date('d/m/Y H:i', strtotime($registro['fecha_registro'])) ?></small></td>
                                                                    <td>
                                                                        <div class="btn-group" role="group">
                                                                            <button class="btn btn-sm btn-info" onclick="abrirModal(<?= $registro['id'] ?>)" title="Ver detalles">
                                                                                <i class="fa fa-eye"></i>
                                                                            </button>
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
                                                                            <button class="btn btn-sm btn-outline-danger" onclick="eliminar_registro(<?= $registro['id'] ?>)" title="Eliminar registro">
                                                                                <i class="fa fa-trash"></i>
                                                                            </button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <tr>
                                                                <td colspan="9" class="text-center text-muted py-4">
                                                                    <i class="fa fa-inbox"></i> Sin registros encontrados
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

    <!-- MODAL PARA VER DETALLES -->
    <div id="detallesModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header" style="background: linear-gradient(135deg, #5a7ca8 0%, #6b8dbf 100%); color: white; border: none;">
                    <h5 class="modal-title"><i class="fa fa-user"></i> Detalles del Registro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalContent" style="max-height: 70vh; overflow-y: auto;">
                    <div class="text-center py-4">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Cargando...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e9ecef;" id="modalFooter">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php echo view("admin/footer"); ?>

    <script>
        function abrirModal(id) {
            // Mostrar el modal
            $('#detallesModal').modal('show');
            
            // Cargar el contenido
            fetch('<?= site_url("admin/viveland_registros/view") ?>/' + id)
                .then(response => response.text())
                .then(html => {
                    // Extraer el contenido
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const mainCard = doc.querySelector('.col-md-8 .card');
                    const sideCards = doc.querySelectorAll('.col-md-4 .card');
                    const acciones = doc.querySelector('.col-md-4 .card-block .btn-group-vertical');
                    
                    let contenido = '';
                    
                    // Información principal
                    if (mainCard) {
                        const cardContent = mainCard.querySelector('.card-block');
                        if (cardContent) {
                            contenido += '<div class="card border-0 mb-3"><div class="card-header" style="background: linear-gradient(135deg, #5a7ca8 0%, #6b8dbf 100%); color: white; border: none;"><h5 class="m-0"><i class="fa fa-user"></i> Información del Registro</h5></div><div class="card-block">' + cardContent.innerHTML + '</div></div>';
                        }
                    }
                    
                    // Cards del lado derecho (Estado, Fechas)
                    sideCards.forEach((card, index) => {
                        if (index < 2) { // Solo Estado y Fechas
                            contenido += card.outerHTML;
                        }
                    });
                    
                    document.getElementById('modalContent').innerHTML = contenido;
                    
                    // Actualizar footer con botones de acción
                    let footerButtons = '<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>'
                    
                    if (acciones) {
                        const allButtons = acciones.querySelectorAll('button, a');
                        allButtons.forEach(btn => {
                            if (!btn.classList.contains('btn-outline-secondary')) {
                                footerButtons = btn.outerHTML + ' ' + footerButtons;
                            }
                        });
                    }
                    
                    document.getElementById('modalFooter').innerHTML = footerButtons;
                })
                .catch(error => {
                    document.getElementById('modalContent').innerHTML = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Error al cargar los detalles</div>';
                    console.error('Error:', error);
                });
        }

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
                        $('#detallesModal').modal('hide');
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
                        $('#detallesModal').modal('hide');
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
                        $('#detallesModal').modal('hide');
                        location.reload();
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
