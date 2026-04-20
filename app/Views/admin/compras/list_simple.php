<html>
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
                                        <h5 class="m-b-10">Módulo de Compras</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard/">Panel</a></li>
                                        <li class="breadcrumb-item"><a>Compras</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- FORMULARIO INLINE PARA NUEVA COMPRA -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Registrar Nueva Compra</h5>
                                            <span class="d-block m-t-5">Ingrese los datos de la compra
                                                directamente</span>
                                        </div>
                                        <div class="card-block">
                                            <form id="formNuevaCompra" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Proveedor *</label>
                                                            <select class="form-control" name="proveedor_id" required>
                                                                <option value="">-- Seleccionar --</option>
                                                                <?php foreach ($proveedores as $prov): ?>
                                                                <option value="<?php echo $prov['id']; ?>">
                                                                    <?php echo $prov['name'] ?? $prov['nombre']; ?>
                                                                </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Comprobante *</label>
                                                            <input type="text" class="form-control"
                                                                name="numero_comprobante" placeholder="Ej: F-001-0001"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Tipo *</label>
                                                            <select class="form-control" name="tipo_comprobante"
                                                                required>
                                                                <option value="Factura">Factura</option>
                                                                <option value="Boleta">Boleta</option>
                                                                <option value="Recibo">Recibo</option>
                                                                <option value="Nota de Compra">Nota de Compra</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Fecha *</label>
                                                            <input type="date" class="form-control" name="fecha_compra"
                                                                required value="<?php echo date('Y-m-d'); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Total *</label>
                                                            <input type="number" step="0.01" class="form-control"
                                                                name="total" placeholder="0.00" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Subtotal</label>
                                                            <input type="number" step="0.01" class="form-control"
                                                                name="subtotal" placeholder="0.00">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>IGV</label>
                                                            <input type="number" step="0.01" class="form-control"
                                                                name="igv" placeholder="0.00">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Tipo de Gasto *</label>
                                                            <select class="form-control" name="gasto_tipo_id"
                                                                id="formGastoTipo" required>
                                                                <option value="">-- Seleccionar --</option>
                                                                <?php foreach ($gastoTipos as $tipo): ?>
                                                                <option value="<?php echo $tipo['id']; ?>">
                                                                    <?php echo $tipo['nombre']; ?>
                                                                </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Subcategoría *</label>
                                                            <select class="form-control" name="gasto_subcategoria_id"
                                                                id="formGastoSubcategoria" required>
                                                                <option value="">-- Seleccionar tipo de gasto primero --
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label>Descripción</label>
                                                            <textarea class="form-control" name="descripcion" rows="2"
                                                                placeholder="Observaciones sobre la compra"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Adjuntar Comprobante (PDF, JPG, PNG)</label>
                                                            <input type="file" class="form-control-file"
                                                                name="comprobante_archivo" id="comprobante_archivo"
                                                                accept=".pdf,.jpg,.jpeg,.png"
                                                                title="Sube la factura, boleta o comprobante de tu compra">
                                                            <small class="form-text text-muted">Máximo 5MB. Formatos:
                                                                PDF, JPG, PNG</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="fa fa-save"></i> Registrar Compra
                                                        </button>
                                                        <button type="reset" class="btn btn-secondary">
                                                            <i class="fa fa-redo"></i> Limpiar
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- DATATABLE CON COMPRAS Y CLASIFICACION DE GASTOS -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5><i class="fa fa-list"></i> Listado de Compras</h5>
                                                <a href="<?php echo base_url('dashboard/compras/reporte'); ?>"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fa fa-bar-chart"></i> Reporte
                                                </a>
                                            </div>
                                            <span class="text-muted d-block m-t-5">Compras registradas con sus clasificaciones de
                                                gastos</span>

                                            <!-- Filtro de Período con Date Picker Moderno -->
                                            <form method="get" class="form-inline" id="formComprasListPeriodo" style="margin-top: 12px;">
                                                <div class="form-group mr-3" style="display: flex; align-items: center;">
                                                    <label for="periodo_fecha_compras_list" class="mr-2" style="margin-bottom: 0;"><strong>Período:</strong></label>
                                                    <input 
                                                        type="date" 
                                                        id="periodo_fecha_compras_list" 
                                                        name="periodo_fecha" 
                                                        class="form-control" 
                                                        value="<?php echo $periodo_fecha ?? date('Y-m-d'); ?>"
                                                        onchange="document.getElementById('formComprasListPeriodo').submit();"
                                                        style="max-width: 150px; border-radius: 5px; border: 1px solid #ddd; padding: 8px 12px; font-size: 14px;">
                                                </div>
                                                <a href="<?php echo site_url('dashboard/compras'); ?>" class="btn btn-sm btn-secondary">
                                                    <i class="fa fa-redo"></i> Limpiar
                                                </a>
                                            </form>
                                        </div>
                                        <div class="card-block">
                                            <?php if (session()->getFlashdata('success')): ?>
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <?php echo session()->getFlashdata('success'); ?>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <?php endif; ?>

                                            <?php if (session()->getFlashdata('error')): ?>
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <?php echo session()->getFlashdata('error'); ?>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <?php endif; ?>

                                            <div class="table-responsive">
                                                <table class="table table-hover table-sm" id="tablasCompras">
                                                    <thead>
                                                        <tr>
                                                            <th>Comprobante</th>
                                                            <th>Fecha</th>
                                                            <th>Proveedor</th>
                                                            <th>Total</th>
                                                            <th>Tipos de Gastos</th>
                                                            <th>Documento</th>
                                                            <th>Estado</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($compras)): ?>
                                                        <?php foreach ($compras as $compra): ?>
                                                        <tr>
                                                            <td><strong><?php echo $compra['numero_comprobante']; ?></strong>
                                                            </td>
                                                            <td><?php echo date('d/m/Y', strtotime($compra['fecha_compra'] ?? date('Y-m-d'))); ?>
                                                            </td>
                                                            <td><?php echo $compra['proveedor_nombre'] ?? 'N/A'; ?></td>
                                                            <td>
                                                                <strong>S/.
                                                                    <?php echo number_format($compra['total'] ?? 0, 2); ?></strong>
                                                            </td>
                                                            <td>
                                                                <div id="gastos-<?php echo $compra['id']; ?>">
                                                                    <?php if (!empty($compra['gastos'])): ?>
                                                                        <?php foreach ($compra['gastos'] as $gasto): ?>
                                                                            <span class="badge" style="background-color: <?php echo $gasto['color']; ?>; color: white; margin-right: 5px; display: inline-block; margin-bottom: 3px;">
                                                                                <?php echo $gasto['tipo_nombre']; ?>
                                                                            </span>
                                                                        <?php endforeach; ?>
                                                                    <?php else: ?>
                                                                        <span class="badge badge-secondary">Sin clasificar</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <?php if (!empty($compra['comprobante_archivo'])): ?>
                                                                    <a href="<?php echo base_url($compra['comprobante_archivo']); ?>" 
                                                                       target="_blank" 
                                                                       class="btn btn-sm btn-info"
                                                                       title="Ver comprobante">
                                                                        <i class="fa fa-file-pdf-o"></i> Ver
                                                                    </a>
                                                                <?php else: ?>
                                                                    <span class="badge badge-secondary">Sin archivo</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                            $badgeClass = match($compra['estado']) {
                                                                                'registrado' => 'warning',
                                                                                'clasificado' => 'info',
                                                                                'aprobado' => 'success',
                                                                                default => 'secondary'
                                                                            };
                                                                        ?>
                                                                <span class="badge badge-<?php echo $badgeClass; ?>">
                                                                    <?php echo ucfirst($compra['estado']); ?>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-sm btn-primary"
                                                                    onclick="verDetalles(<?php echo $compra['id']; ?>)"
                                                                    title="Ver detalles">
                                                                    <i class="fa fa-eye"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-warning"
                                                                    data-compra-id="<?php echo $compra['id']; ?>"
                                                                    data-compra-numero="<?php echo esc($compra['numero_comprobante'], 'attr'); ?>"
                                                                    data-gasto-tipo-id="<?php echo esc((string)($compra['gasto_tipo_id'] ?? ''), 'attr'); ?>"
                                                                    data-gasto-subcategoria-id="<?php echo esc((string)($compra['gasto_subcategoria_id'] ?? ''), 'attr'); ?>"
                                                                    data-observaciones="<?php echo esc($compra['observaciones'] ?? '', 'attr'); ?>"
                                                                    onclick="clasificarGastos(this)"
                                                                    title="Clasificar gastos">
                                                                    <i class="fa fa-tags"></i>
                                                                </button>
                                                                <form method="POST" action="<?php echo base_url('dashboard/compras/delete/' . $compra['id']); ?>" class="d-inline delete-compra-form">
                                                                    <button type="button" class="btn btn-sm btn-danger delete-compra-btn"
                                                                        title="Eliminar">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                        <?php else: ?>
                                                        <tr>
                                                            <td colspan="8" class="text-center p-4">
                                                                <p class="text-muted">No hay compras registradas</p>
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

    <!-- MODAL PARA CLASIFICAR GASTOS -->
    <div class="modal fade" id="modalClasificarGastos" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Clasificar Gastos - Compra: <span id="compraNumero"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formClasificacionGastos" method="post"
                        action="<?php echo base_url('dashboard/compras/guardarClasificacionGasto'); ?>">
                        <input type="hidden" name="compra_id" id="compraIdGastos">
                        <input type="hidden" name="redirect_to"
                            value="<?php echo current_url() . (!empty($periodo_fecha) ? '?periodo_fecha=' . urlencode($periodo_fecha) : ''); ?>">

                        <div class="form-group">
                            <label>Tipo de Gasto *</label>
                            <select class="form-control" name="gasto_tipo_id" id="gastoTipoSelect" required>
                                <option value="">-- Seleccionar --</option>
                                <?php foreach ($gastoTipos as $tipo): ?>
                                <option value="<?php echo $tipo['id']; ?>"
                                    style="color: <?php echo $tipo['color']; ?>;">
                                    🏷️ <?php echo $tipo['nombre']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Subcategoría *</label>
                            <select class="form-control" name="gasto_subcategoria_id" id="gastoSubcategoriaSelect"
                                required>
                                <option value="">-- Seleccionar tipo de gasto primero --</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Observaciones</label>
                            <textarea class="form-control" name="observaciones" rows="3"
                                placeholder="Notas sobre esta clasificación"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Guardar Clasificación
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <form id="formEliminarCompra" method="post" style="display:none;">
        <input type="hidden" name="redirect_to"
            value="<?php echo current_url() . (!empty($periodo_fecha) ? '?periodo_fecha=' . urlencode($periodo_fecha) : ''); ?>">
    </form>

    <form id="formEliminarGastos" method="post" style="display:none;">
        <input type="hidden" name="redirect_to"
            value="<?php echo current_url() . (!empty($periodo_fecha) ? '?periodo_fecha=' . urlencode($periodo_fecha) : ''); ?>">
    </form>

    <?php echo view("admin/footer"); ?>

    <script>
    // Variables globales
    const gastoTipos = <?php echo json_encode($gastoTipos); ?>;
    const gastoSubcategorias = <?php echo json_encode($gastoSubcategorias); ?>;

    function llenarSubcategorias(selectId, tipoId, subcategoriaSeleccionada = '') {
        const select = document.getElementById(selectId);
        const subcategorias = gastoSubcategorias.filter(s => String(s.gasto_tipo_id) === String(tipoId));

        if (!tipoId) {
            select.innerHTML = '<option value="">-- Seleccionar tipo de gasto primero --</option>';
            return;
        }

        if (subcategorias.length === 0) {
            select.innerHTML = '<option value="">No hay subcategorías para este tipo</option>';
            return;
        }

        select.innerHTML = '<option value="">-- Seleccionar --</option>' +
            subcategorias.map(s => {
                const selected = String(subcategoriaSeleccionada) === String(s.id) ? 'selected' : '';
                return `<option value="${s.id}" ${selected}>${s.nombre}</option>`;
            }).join('');
    }

    function resetFormularioClasificacion() {
        document.getElementById('formClasificacionGastos').reset();
        document.getElementById('gastoTipoSelect').value = '';
        llenarSubcategorias('gastoSubcategoriaSelect', '');
    }

    // FORMULARIO NUEVA COMPRA
    document.getElementById('formNuevaCompra').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);

        try {
            const response = await fetch('<?php echo base_url('dashboard/compras/store'); ?>', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();
            
            // LOG PARA DEBUG
            console.log('=== RESPUESTA DEL SERVIDOR ===');
            console.log('Status:', response.status);
            console.log('JSON completo:', data);
            console.log('================================');

            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: data.message,
                    confirmButtonColor: '#28a745'
                }).then(() => location.reload());
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message,
                    confirmButtonColor: '#dc3545'
                });
            }
        } catch (error) {
            console.error('❌ ERROR AL ENVIAR:', error);
            console.error('Mensaje:', error.message);
            console.error('Stack:', error.stack);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al registrar la compra: ' + error.message,
                confirmButtonColor: '#dc3545'
            });
        }
    });

    // FILTRAR SUBCATEGORIAS EN FORMULARIO
    document.getElementById('formGastoTipo').addEventListener('change', (e) => {
        llenarSubcategorias('formGastoSubcategoria', e.target.value);
    });

    // CARGAR GASTOS POR COMPRA - YA NO NECESARIO
    // Los gastos se cargan directamente desde el controlador
    /*
    function cargarGastosPorCompra(compraId, reintentos = 0) {
        fetch(`<?php echo base_url('api/compras/getGastosByCompra/'); ?>${compraId}`, {
                method: 'GET',
                credentials: 'include',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => {
                console.log(`Response status for compra ${compraId}:`, res.status);
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                const contentType = res.headers.get('content-type');
                console.log(`Content-Type for compra ${compraId}:`, contentType);
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Response is not JSON: ' + contentType);
                }
                return res.text().then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('JSON parse error:', text.substring(0, 100));
                        throw e;
                    }
                });
            })
            .then(data => {
                console.log(`Data for compra ${compraId}:`, data);
                const container = document.getElementById(`gastos-${compraId}`);

                // Si hay error en la respuesta
                if (data.error) {
                    throw new Error(data.message || 'Error desconocido');
                }

                // Si es array vacío
                if (Array.isArray(data) && data.length === 0) {
                    container.innerHTML = '<span class="badge badge-secondary">Sin clasificar</span>';
                }
                // Si tiene gastos
                else if (Array.isArray(data) && data.length > 0) {
                    let html = '';
                    data.forEach(gasto => {
                        // Usar directamente tipo_nombre y color del JSON devuelto
                        const tipoNombre = gasto.tipo_nombre || 'N/A';
                        const tipoColor = gasto.color || '#6c757d';
                        html += `<span class="badge" style="background-color: ${tipoColor}; color: white; margin-right: 5px; display: inline-block; margin-bottom: 3px;">
                                ${tipoNombre}
                            </span>`;
                    });
                    container.innerHTML = html;
                } else {
                    throw new Error('Respuesta inválida del servidor');
                }
            })
            .catch(err => {
                console.error('Error cargando gastos para compra ' + compraId + ':', err);
                const container = document.getElementById(`gastos-${compraId}`);

                // Reintentar solo una vez si es error de red
                if (reintentos < 1 && err instanceof TypeError) {
                    console.log(`Reintentando cargar gastos para compra ${compraId}...`);
                    setTimeout(() => cargarGastosPorCompra(compraId, reintentos + 1), 1500);
                } else {
                    container.innerHTML = '<span class="badge badge-danger">Error: ' + err.message + '</span>';
                }
            });
    }
    */

    // VER DETALLES
    function verDetalles(compraId) {
        window.location.href = `<?php echo base_url('dashboard/compras/view/'); ?>${compraId}`;
    }

    // CLASIFICAR GASTOS - MODAL
    function clasificarGastos(button) {
        const compraId = button.dataset.compraId || '';
        const numeroComprobante = button.dataset.compraNumero || '';
        const gastoTipoId = button.dataset.gastoTipoId || '';
        const gastoSubcategoriaId = button.dataset.gastoSubcategoriaId || '';
        const observaciones = button.dataset.observaciones || '';

        document.getElementById('compraIdGastos').value = compraId;
        document.getElementById('compraNumero').textContent = numeroComprobante;
        resetFormularioClasificacion();
        document.getElementById('gastoTipoSelect').value = gastoTipoId;
        llenarSubcategorias('gastoSubcategoriaSelect', gastoTipoId, gastoSubcategoriaId);
        document.querySelector('#formClasificacionGastos textarea[name="observaciones"]').value = observaciones;
        $('#modalClasificarGastos').modal('show');
    }

    // CAMBIAR SUBCATEGORIAS AL SELECCIONAR TIPO
    document.getElementById('gastoTipoSelect').addEventListener('change', (e) => {
        llenarSubcategorias('gastoSubcategoriaSelect', e.target.value);
    });

    $('#modalClasificarGastos').on('hidden.bs.modal', function() {
        resetFormularioClasificacion();
    });

    // ELIMINAR COMPRA - Form submit con SweetAlert
    document.querySelectorAll('.delete-compra-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = btn.closest('form');
            Swal.fire({
                title: '¿Eliminar esta compra?',
                text: 'Esta acción eliminará la compra de forma permanente.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Cargar gastos al cargar la página - YA NO NECESARIO 
    // Los gastos se cargan directamente desde el controlador en la vista
    /*
    document.addEventListener('DOMContentLoaded', () => {
        const compraElements = document.querySelectorAll('[id^="gastos-"]');
        compraElements.forEach(el => {
            const compraId = el.id.replace('gastos-', '');
            cargarGastosPorCompra(compraId);
        });
    });
    */
    </script>
    <?php if (session('success')): ?>
    <script>
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: '<?= session('success') ?>',
        confirmButtonColor: '#28a745',
    });
    </script>
    <?php endif; ?>
</body>

</html>