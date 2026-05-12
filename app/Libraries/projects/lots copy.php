<!doctype html>
<html lang="es-PE">
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
                                        <h5 class="m-b-10"><?= $title ?></h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard/panel') ?>">Panel</a></li>
                                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard/inmueble') ?>">Inmueble</a></li>
                                        <li class="breadcrumb-item"><a>Lotes</a></li>
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
                                            <h5>Gestión de Lotes</h5>
                                            <div class="card-header-right">
                                                <a href="<?= site_url('dashboard/inmueble/create_lot') ?>" class="btn btn-primary btn-sm">
                                                    <i class="feather icon-plus"></i> Nuevo Lote
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <!-- Filter by Project -->
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <select class="form-control" id="project-filter"
                                                        onchange="filterByProject()">
                                                        <option value="">Todos los Proyectos</option>
                                                        <?php foreach ($projects as $project): ?>
                                                        <option value="<?= $project['id'] ?>"
                                                            <?= $selected_project == $project['id'] ? 'selected' : '' ?>>
                                                            <?= $project['name'] ?> (<?= $project['code'] ?>)
                                                        </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="table-responsive">
                                                <table id="zero-configuration"
                                                    class="display table nowrap table-striped table-hover dataTable"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Proyecto</th>
                                                            <th>Lote</th>
                                                            <th>Manzana</th>
                                                            <th>Área (m²)</th>
                                                            <th>Precio Base</th>
                                                            <th>Precio Actual</th>
                                                            <th>Estado</th>
                                                            <th>Cliente</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if ($lots): ?>
                                                        <?php foreach ($lots as $lot): ?>
                                                        <tr>
                                                            <td><?= $lot['id'] ?></td>
                                                            <td>
                                                                <?php 
                                                         $project = array_filter($projects, function($p) use ($lot) {
                                                            return $p['id'] == $lot['project_id'];
                                                         });
                                                         $project = reset($project);
                                                         echo $project ? $project['name'] : 'N/A';
                                                         ?>
                                                            </td>
                                                            <td><strong><?= $lot['lot_number'] ?></strong></td>
                                                            <td><?= $lot['block'] ?? 'N/A' ?></td>
                                                            <td><?= number_format($lot['area_sqm'], 2) ?></td>
                                                            <td>S/ <?= number_format($lot['base_price'], 2) ?></td>
                                                            <td>S/ <?= number_format($lot['current_price'], 2) ?></td>
                                                            <td>
                                                                <?php 
                                                         $status_class = '';
                                                         $status_text = '';
                                                         switch($lot['status']) {
                                                            case 'available':
                                                               $status_class = 'badge-success';
                                                               $status_text = 'Disponible';
                                                               break;
                                                            case 'reserved':
                                                               $status_class = 'badge-warning';
                                                               $status_text = 'Reservado';
                                                               break;
                                                            case 'sold':
                                                               $status_class = 'badge-danger';
                                                               $status_text = 'Vendido';
                                                               break;
                                                            case 'blocked':
                                                               $status_class = 'badge-secondary';
                                                               $status_text = 'Bloqueado';
                                                               break;
                                                         }
                                                         ?>
                                                                <span
                                                                    class="badge <?= $status_class ?>"><?= $status_text ?></span>
                                                            </td>
                                                            <td><?= $lot['customer_id'] ? 'Cliente #' . $lot['customer_id'] : '-' ?>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <button type="button"
                                                                        class="btn btn-icon btn-info btn-sm"
                                                                        title="Ver Detalles"
                                                                        onclick="view_lot('<?= $lot['id'] ?>');">
                                                                        <i class="fa fa-eye"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-icon btn-warning btn-sm"
                                                                        title="Editar"
                                                                        onclick="editLot('<?= $lot['id'] ?>');">
                                                                        <i class="fa fa-edit"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-icon btn-danger btn-sm"
                                                                        title="Eliminar"
                                                                        onclick="eliminar_lot('<?= $lot['id'] ?>');">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </div>
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
        </div>
    </section>

    <!-- Modal para Editar Lote -->
    <div class="modal fade" id="editLotModal" tabindex="-1" role="dialog" aria-labelledby="editLotModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="edit-lot-form" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editLotModalLabel">Editar Lote</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_project_id">Proyecto <span class="text-danger">*</span></label>
                                    <select class="form-control" id="edit_project_id" name="project_id" required
                                        onchange="updateLotPricePerSqm()">
                                        <option value="">Seleccionar proyecto</option>
                                        <?php foreach ($projects as $project): ?>
                                        <option value="<?= $project['id'] ?>"
                                            data-price="<?= $project['base_price_per_sqm'] ?>"
                                            data-location="<?= $project['location'] ?>"
                                            data-down-payment-type="<?= $project['down_payment_type'] ?>"
                                            data-min-down-payment-percentage="<?= $project['min_down_payment_percentage'] ?>"
                                            data-min-down-payment-fixed="<?= $project['min_down_payment_fixed'] ?>">
                                            <?= $project['name'] ?> (<?= $project['code'] ?>)
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="edit_lot_number">Número de Lote <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_lot_number" name="lot_number"
                                        required readonly>
                                    <small class="form-text text-muted">No se puede modificar</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="edit_block">Manzana</label>
                                    <input type="text" class="form-control" id="edit_block" name="block">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit_area_sqm">Área (m²) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="edit_area_sqm" name="area_sqm"
                                        step="0.01" min="50" required onchange="calculateLotPrice()">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit_price_per_sqm">Precio por m²</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/</span>
                                        </div>
                                        <input type="number" class="form-control" id="edit_price_per_sqm" step="0.01"
                                            readonly>
                                    </div>
                                    <small class="form-text text-muted">Basado en el proyecto</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit_base_price">Precio del Lote <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/</span>
                                        </div>
                                        <input type="number" class="form-control" id="edit_base_price" name="base_price"
                                            step="0.01" min="0" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_current_price">Precio Actual</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/</span>
                                        </div>
                                        <input type="number" class="form-control" id="edit_current_price"
                                            name="current_price" step="0.01" min="0">
                                    </div>
                                    <small class="form-text text-muted">Precio actualizado automáticamente</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_status">Estado</label>
                                    <select class="form-control" id="edit_status" name="status">
                                        <option value="available">Disponible</option>
                                        <option value="reserved">Reservado</option>
                                        <option value="sold">Vendido</option>
                                        <option value="blocked">Bloqueado</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Información del cliente si está vendido/reservado -->
                        <div id="customer-info" class="row" style="display: none;">
                            <div class="col-md-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6>Información del Cliente</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <small class="text-muted">Cliente ID:</small><br>
                                                <strong id="customer_id_display">-</strong>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted">Estado del Contrato:</small><br>
                                                <span id="contract_status_display" class="badge">-</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cálculo automático -->
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Cálculo Automático</h6>
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <small class="text-muted">Área Total</small>
                                        <div class="h6 text-primary" id="calc_area">0 m²</div>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <small class="text-muted">Precio Calculado</small>
                                        <div class="h6 text-success" id="calc_price">S/ 0</div>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <small class="text-muted">Cuota Inicial (15%)</small>
                                        <div class="h6 text-warning" id="calc_initial">S/ 0</div>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <small class="text-muted">Diferencia Precio</small>
                                        <div class="h6" id="calc_difference">S/ 0</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="feather icon-x"></i> Cancelar
                        </button>
                        <button type="button" class="btn btn-info" onclick="viewLotHistory()">
                            <i class="feather icon-clock"></i> Historial
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="feather icon-save"></i> Actualizar Lote
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Ver Detalles del Lote -->
    <div class="modal fade" id="viewLotModal" tabindex="-1" role="dialog" aria-labelledby="viewLotModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewLotModalLabel">Detalles del Lote</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Información Principal -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Información del Lote</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>Proyecto:</strong><br>
                                            <span id="view_project_name" class="text-primary">-</span><br>
                                            <small class="text-muted" id="view_project_location">-</small>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Lote:</strong><br>
                                            <span id="view_lot_number" class="h5">-</span><br>
                                            <small class="text-muted">Manzana: <span id="view_block">-</span></small>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Estado:</strong><br>
                                            <span id="view_status_badge" class="badge">-</span><br>
                                            <small class="text-muted" id="view_last_updated">-</small>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong>Área Total:</strong><br>
                                            <span id="view_area" class="h6 text-info">-</span> m²
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Precio Base:</strong><br>
                                            <span id="view_base_price" class="h6 text-success">-</span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Precio Actual:</strong><br>
                                            <span id="view_current_price" class="h6 text-warning">-</span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Precio por m²:</strong><br>
                                            <span id="view_price_per_sqm" class="h6 text-primary">-</span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Precio Total del Lote:</strong><br>
                                            <span id="view_total_lot_price" class="h6 text-info">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Información Financiera</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="mb-3">
                                            <small class="text-muted">Cuota Inicial (15%)</small><br>
                                            <span id="view_initial_payment" class="h5 text-success">-</span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted">Monto a Financiar</small><br>
                                            <span id="view_finance_amount" class="h6 text-info">-</span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted" id="monthly_payment_label">Cuota Mensual
                                                Aprox.</small><br>
                                            <span id="view_monthly_payment" class="h6 text-warning">-</span>
                                        </div>
                                        <div>
                                            <small class="text-muted">Valorización</small><br>
                                            <span id="view_appreciation" class="h6">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Cliente (si aplica) -->
                    <div id="view_customer_section" class="row mt-3" style="display: none;">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Información del Cliente</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>Cliente:</strong><br>
                                            <span id="view_customer_name">-</span><br>
                                            <small class="text-muted">ID: <span id="view_customer_id">-</span></small>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Contrato:</strong><br>
                                            <span id="view_contract_number">-</span><br>
                                            <small class="text-muted">Estado: <span
                                                    id="view_contract_status">-</span></small>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Fecha de Venta:</strong><br>
                                            <span id="view_sale_date">-</span><br>
                                            <small class="text-muted">Reservado hasta: <span
                                                    id="view_reserved_until">-</span></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Historial de Precios -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Historial de Precios</h6>
                                </div>
                                <div class="card-body">
                                    <div id="price_history">
                                        <div class="timeline">
                                            <div class="timeline-item">
                                                <div class="timeline-marker bg-success"></div>
                                                <div class="timeline-content">
                                                    <h6 class="timeline-title">Precio Actual</h6>
                                                    <p>S/ <span id="view_current_price_history">-</span></p>
                                                    <small class="text-muted" id="view_price_update_date">-</small>
                                                </div>
                                            </div>
                                            <div class="timeline-item">
                                                <div class="timeline-marker bg-info"></div>
                                                <div class="timeline-content">
                                                    <h6 class="timeline-title">Precio Base</h6>
                                                    <p>S/ <span id="view_base_price_history">-</span></p>
                                                    <small class="text-muted">Precio inicial del lote</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Mapa de Ubicación</h6>
                                </div>
                                <div class="card-body text-center">
                                    <div id="lot_map"
                                        style="height: 200px; background: #f8f9fa; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                        <div>
                                            <i class="feather icon-map-pin f-48 text-muted"></i><br>
                                            <span class="text-muted">Mapa del Lote</span><br>
                                            <small class="text-muted">Manzana <span id="view_map_block">-</span>, Lote
                                                <span id="view_map_lot">-</span></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Métricas del Lote -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Métricas y Análisis</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2 text-center">
                                            <small class="text-muted">Días en el Mercado</small>
                                            <div class="h6 text-primary" id="view_days_market">-</div>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <small class="text-muted">Valorización %</small>
                                            <div class="h6 text-success" id="view_appreciation_percent">-</div>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <small class="text-muted">ROI Anual</small>
                                            <div class="h6 text-info" id="view_roi_annual">-</div>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <small class="text-muted">Precio vs Mercado</small>
                                            <div class="h6 text-warning" id="view_market_comparison">-</div>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <small class="text-muted">Score del Lote</small>
                                            <div class="h6 text-danger" id="view_lot_score">-</div>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <small class="text-muted">Demanda</small>
                                            <div class="h6" id="view_demand_level">-</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="feather icon-x"></i> Cerrar
                    </button>
                    <button type="button" class="btn btn-info" onclick="printLotDetails()">
                        <i class="feather icon-printer"></i> Imprimir
                    </button>
                    <button type="button" class="btn btn-warning" onclick="editLotFromView()">
                        <i class="feather icon-edit"></i> Editar
                    </button>
                    <button type="button" class="btn btn-success" onclick="createContract()">
                        <i class="feather icon-file-plus"></i> Crear Contrato
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }

    .timeline-marker {
        position: absolute;
        left: -34px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .timeline-content {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        border-left: 3px solid #007bff;
    }

    .timeline-title {
        margin-bottom: 5px;
        font-size: 14px;
    }
    </style>


    <!-- Migrated JS files for lot management -->
    <script src="/assets/js/lot/lot-edit.js"></script>
    <script src="/assets/js/lot/lot-detail.js"></script>
    <script src="/assets/js/lot/lot-delete.js"></script>

    <?php echo view("admin/footer"); ?>
</body>

</html>