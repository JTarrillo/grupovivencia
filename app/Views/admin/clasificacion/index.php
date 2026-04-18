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
                                        <h5 class="m-b-10">Clasificación de Gastos</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item"><a>Clasificación</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- Cards resumen -->
                            <div class="row">
                                <div class="col-md-6 col-xl-3">
                                    <div class="card theme-bg bitcoin-wallet" style="border-radius: 15px;">
                                        <div class="card-block">
                                            <h5 class="text-white mb-2">Pendientes de Clasificar</h5>
                                            <h2 class="text-white mb-2 f-w-300"><?= $total_sin_clasificar ?></h2>
                                            <span class="d-block"><a class="text-white" href="#"><b
                                                        style="color:yellow">Compras</b></a></span>
                                            <i class="fa fa-inbox f-70 fa-4x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card theme-bg2 bitcoin-wallet" style="border-radius: 15px;">
                                        <div class="card-block">
                                            <h5 class="text-white mb-2">Ya Clasificadas</h5>
                                            <h2 class="text-white mb-2 f-w-300"><?= $total_clasificadas ?></h2>
                                            <span class="text-white d-block">Procesadas</span>
                                            <i class="fa fa-check-circle f-70 fa-4x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card theme-bg2 bitcoin-wallet" style="border-radius: 15px;">
                                        <div class="card-block">
                                            <h5 class="text-white mb-2">Total de Compras</h5>
                                            <h2 class="text-white mb-2 f-w-300"><?= count($compras) ?></h2>
                                            <span class="text-white d-block">En sistema</span>
                                            <i class="fa fa-shopping-cart f-70 fa-4x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-3">
                                    <div class="card theme-bg2 visitor" style="border-radius: 15px;">
                                        <div class="card-block text-center">
                                            <h5 class="text-white m-0">Porcentaje</h5>
                                            <?php $porcentaje = count($compras) > 0 ? round(($total_clasificadas / count($compras)) * 100, 1) : 0; ?>
                                            <h3 class="text-white m-t-20 f-w-300"><?= $porcentaje ?>%</h3>
                                            <span class="text-white">Clasificación</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-3">
                                    <div class="card theme-bg3 visitor" style="border-radius: 15px; background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);">
                                        <div class="card-block text-center">
                                            <h5 class="text-white m-0">Total del Período</h5>
                                            <h3 class="text-white m-t-20 f-w-300">S/. <?= number_format($total_mes, 2) ?></h3>
                                            <span class="text-white">
                                                <?php
                                                    $fecha_obj = DateTime::createFromFormat('Y-m-d', $periodo_fecha);
                                                    echo $fecha_obj->format('d/m/Y');
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabla de compras -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5><i class="fa fa-list"></i> Compras para Clasificar</h5>
                                                <a href="<?php echo site_url('dashboard/clasificacion/informe'); ?>" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fa fa-chart-bar"></i> Ver Informe por Período
                                                </a>
                                            </div>
                                            <span class="text-muted d-block m-t-5">Gestione la clasificación de compras
                                                y gastos</span>
                                            
                                            <!-- Filtro de Período con Date Picker Moderno -->
                                            <form method="get" class="form-inline" id="formPeriodo" style="margin-top: 12px;">
                                                <div class="form-group mr-3" style="display: flex; align-items: center;">
                                                    <label for="periodo_fecha" class="mr-2" style="margin-bottom: 0;"><strong>Período:</strong></label>
                                                    <input 
                                                        type="date" 
                                                        id="periodo_fecha" 
                                                        name="periodo_fecha" 
                                                        class="form-control" 
                                                        value="<?php echo $periodo_fecha ?? date('Y-m-d'); ?>"
                                                        onchange="document.getElementById('formPeriodo').submit();"
                                                        style="max-width: 150px; border-radius: 5px; border: 1px solid #ddd; padding: 8px 12px; font-size: 14px;">
                                                </div>
                                                <a href="<?php echo site_url('dashboard/clasificacion'); ?>" class="btn btn-sm btn-secondary">
                                                    <i class="fa fa-redo"></i> Limpiar
                                                </a>
                                            </form>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-striped">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th>Comprobante</th>
                                                            <th>Proveedor</th>
                                                            <th>Fecha</th>
                                                            <th>Total</th>
                                                            <th>Estado</th>
                                                            <th>Clasificación</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (empty($compras)): ?>
                                                        <tr>
                                                            <td colspan="7" class="text-center text-muted">
                                                                <i class="fa fa-inbox"></i> No hay compras para
                                                                clasificar
                                                            </td>
                                                        </tr>
                                                        <?php else: ?>
                                                        <?php foreach ($compras as $compra): ?>
                                                        <tr>
                                                            <td>
                                                                <strong><?= $compra['numero_comprobante'] ?></strong>
                                                                <small
                                                                    class="text-muted d-block"><?= $compra['tipo_comprobante'] ?></small>
                                                            </td>
                                                            <td><?= $compra['proveedor_nombre'] ?? 'Sin proveedor' ?>
                                                            </td>
                                                            <td><?= date('d/m/Y', strtotime($compra['fecha_compra'])) ?>
                                                            </td>
                                                            <td class="text-end">
                                                                <strong>S/
                                                                    <?= number_format($compra['total'], 2) ?></strong>
                                                            </td>
                                                            <td>
                                                                <?php if ($compra['estado'] == 'registrado'): ?>
                                                                <span class="badge bg-warning">Registrado</span>
                                                                <?php elseif ($compra['estado'] == 'clasificado'): ?>
                                                                <span class="badge bg-success">Clasificado</span>
                                                                <?php else: ?>
                                                                <span
                                                                    class="badge bg-secondary"><?= $compra['estado'] ?></span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($compra['tiene_clasificacion'] > 0): ?>
                                                                <span class="badge bg-info"><i class="fa fa-check"></i>
                                                                    Sí</span>
                                                                <?php else: ?>
                                                                <span class="badge bg-secondary">No</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-sm btn-primary" onclick="abrirModalClasificar(<?= $compra['id'] ?>)" title="Clasificar">
                                                                    <i class="fa fa-tag"></i> Clasificar
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
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
    </section>

    <!-- MODAL CLASIFICACIÓN -->
    <div class="modal fade" id="modalClasificar" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Clasificar Compra: <span id="modalNumeroComprobante"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Detalles de la compra -->
                    <div class="alert alert-light mb-3">
                        <div class="row small">
                            <div class="col-md-6">
                                <strong>Tipo:</strong> <span id="modalTipoComprobante"></span>
                            </div>
                            <div class="col-md-6">
                                <strong>Fecha:</strong> <span id="modalFechaCompra"></span>
                            </div>
                            <div class="col-md-6">
                                <strong>Total:</strong> <span id="modalTotal" style="color: #28a745;"></span>
                            </div>
                            <div class="col-md-6">
                                <strong>Descripción:</strong> <span id="modalDescripcion"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario -->
                    <form id="formClasificacionModal">
                        <input type="hidden" name="compra_id" id="modalCompraId">

                        <div class="form-group">
                            <label>Tipo de Gasto <span class="text-danger">*</span></label>
                            <select name="gasto_tipo_id" id="modalGastoTipo" class="form-control" required>
                                <option value="">-- Seleccionar tipo --</option>
                                <?php foreach ($gastoTipos as $tipo): ?>
                                    <option value="<?= $tipo['id'] ?>">
                                        <?= $tipo['nombre'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Subcategoría <span class="text-danger">*</span></label>
                            <select name="gasto_subcategoria_id" id="modalGastoSubcategoria" class="form-control" required>
                                <option value="">-- Seleccionar tipo de gasto primero --</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Observaciones</label>
                            <textarea name="observaciones" id="modalObservaciones" class="form-control" rows="3" placeholder="Notas adicionales..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-success" onclick="guardarClasificacionModal()">
                        <i class="fa fa-save"></i> Guardar Clasificación
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php echo view("admin/footer"); ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Variables globales para el modal
        let gastosSubcategorias = <?php echo json_encode($gastoSubcategorias); ?>;
        
        // Abrir modal con datos de la compra
        function abrirModalClasificar(compraId) {
            // Obtener datos de la compra por AJAX
            fetch('<?= site_url('dashboard/clasificacion/detalles/'); ?>' + compraId, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(compra => {
                // Llenar datos en el modal
                document.getElementById('modalNumeroComprobante').textContent = compra.numero_comprobante;
                document.getElementById('modalTipoComprobante').textContent = compra.tipo_comprobante;
                document.getElementById('modalFechaCompra').textContent = new Date(compra.fecha_compra).toLocaleDateString('es-PE');
                document.getElementById('modalTotal').textContent = 'S/ ' + parseFloat(compra.total).toFixed(2);
                document.getElementById('modalDescripcion').textContent = compra.descripcion || '-';
                document.getElementById('modalCompraId').value = compraId;

                // Limpiar selects
                document.getElementById('modalGastoTipo').value = '';
                document.getElementById('modalGastoSubcategoria').innerHTML = '<option value="">-- Seleccionar tipo de gasto primero --</option>';
                document.getElementById('modalObservaciones').value = '';

                // Mostrar modal
                $('#modalClasificar').modal('show');
            })
            .catch(err => {
                alert('Error al cargar datos de la compra');
                console.error(err);
            });
        }

        // Al cambiar tipo de gasto, filtrar subcategorías
        document.getElementById('modalGastoTipo').addEventListener('change', function() {
            const tipoId = this.value;
            const selectSubcategoria = document.getElementById('modalGastoSubcategoria');
            
            if (!tipoId) {
                selectSubcategoria.innerHTML = '<option value="">-- Seleccionar tipo de gasto primero --</option>';
                return;
            }

            const subcategorias = gastosSubcategorias.filter(s => s.gasto_tipo_id == tipoId);
            
            let html = '<option value="">-- Seleccionar subcategoría --</option>';
            subcategorias.forEach(sub => {
                html += `<option value="${sub.id}">${sub.nombre}</option>`;
            });
            selectSubcategoria.innerHTML = html;
        });

        // Guardar clasificación desde el modal
        function guardarClasificacionModal() {
            const formData = new FormData(document.getElementById('formClasificacionModal'));
            
            if (!formData.get('gasto_tipo_id') || !formData.get('gasto_subcategoria_id')) {
                alert('Por favor completa los campos requeridos');
                return;
            }

            fetch('<?= site_url('dashboard/clasificacion/guardarClasificacion'); ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $('#modalClasificar').modal('hide');
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(err => {
                Swal.fire('Error', 'Error al guardar clasificación', 'error');
                console.error(err);
            });
        }
    </script>
</body>

</html>