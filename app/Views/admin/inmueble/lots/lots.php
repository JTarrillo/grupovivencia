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
                                        <li class="breadcrumb-item"><a href="/dashboard/panel">Panel</a></li>
                                        <li class="breadcrumb-item"><a href="/dashboard/inmueble">Inmueble</a></li>
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
                                                <a href="/dashboard/inmueble/create_lot" class="btn btn-primary btn-sm">
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
                                                            <th>Unidad Catastral</th>
                                                            <th>Partida Electrónica</th>
                                                            <th>Área (m²)</th>
                                                            <th>Precio Base</th>
                                                            <th>Precio Actual</th>
                                                            <th>Estado</th>
                                                            <th>Cliente</th>
                                                            <th>Reservado</th>
                                                            <th>Monto Reserva</th>
                                                            <th>Fecha Reserva</th>
                                                            <th>Estado Contrato</th>
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
                                                            <td><?= isset($lot['cadastral_unit']) && $lot['cadastral_unit'] !== '' ? $lot['cadastral_unit'] : '-' ?>
                                                            </td>
                                                            <td><?= isset($lot['registry_number']) && $lot['registry_number'] !== '' ? $lot['registry_number'] : '-' ?>
                                                            </td>
                                                            <td><?= number_format($lot['area_sqm'], 2) ?></td>
                                                            <td>S/ <?= number_format($lot['base_price'], 2) ?></td>
                                                            <td>S/ <?= number_format($lot['current_price'], 2) ?></td>
                                                            <td>
                                                                <?php 
                                                                // Mostrar el estado SOLO usando el campo 'status'
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
                                                                    default:
                                                                        $status_class = 'badge-secondary';
                                                                        $status_text = $lot['status'];
                                                                        break;
                                                                }
                                                                ?>
                                                                <span
                                                                    class="badge <?= $status_class ?>"><?= $status_text ?></span>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if (!empty($lot['customer_name'])) {
                                                                    echo htmlspecialchars($lot['customer_name']);
                                                                } elseif (!empty($lot['customer_id'])) {
                                                                    echo 'Cliente #' . $lot['customer_id'];
                                                                } else {
                                                                    echo '-';
                                                                }
                                                                ?>
                                                            </td>
                                                            </td>
                                                            <td><?= isset($lot['is_reserved']) ? ($lot['is_reserved'] ? 'Sí' : 'No') : '-' ?>
                                                            </td>
                                                            <td><?= isset($lot['contract_reservation_amount']) && $lot['contract_reservation_amount'] ? 'S/ ' . number_format($lot['contract_reservation_amount'],2) : '-' ?>
                                                            </td>
                                                            <td><?= isset($lot['contract_reservation_date']) && $lot['contract_reservation_date'] ? $lot['contract_reservation_date'] : '-' ?>
                                                            </td>
                                                            <td><?= isset($lot['contract_status']) && $lot['contract_status'] ? $lot['contract_status'] : '-' ?>
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

    <?php
    // // Debug: inspect lots array before modal
    // if (isset($lots)) {
    //     echo '<pre style="background:#fffbe6;border:2px solid #e6a100;padding:8px;">';
    //     var_dump($lots);
    //     echo '</pre>';
    // }
    // ?>

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
                        <!-- Primera fila: Proyecto, Número de Lote, Manzana -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
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
                            <div class="form-group col-md-3">
                                <label for="edit_lot_number">Número de Lote <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_lot_number" name="lot_number" required
                                    readonly>
                                <small class="form-text text-muted">No se puede modificar</small>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="edit_block">Manzana</label>
                                <input type="text" class="form-control" id="edit_block" name="block">
                            </div>
                        </div>

                        <!-- Segunda fila: Unidad Catastral, Partida Electrónica -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit_cadastral_unit">Unidad Catastral</label>
                                <input type="text" class="form-control" id="edit_cadastral_unit" name="cadastral_unit"
                                    placeholder="Ej: UC-12345">
                                <small class="form-text text-muted">Dato oficial del catastro, si aplica.</small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edit_registry_number">Partida Electrónica <span
                                        class="text-muted">(Electronic Property Record)</span></label>
                                <input type="text" class="form-control" id="edit_registry_number" name="registry_number"
                                    placeholder="Ej: 12345678">
                                <small class="form-text text-muted">Número de la Partida Electrónica SUNARP, si
                                    aplica.</small>
                            </div>
                        </div>

                        <!-- Tercera fila: Área, Precio por m2, Precio del Lote -->
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="edit_area_sqm">Área (m²) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_area_sqm" name="area_sqm" step="0.01"
                                    min="50" required onchange="calculateLotPrice()">
                            </div>
                            <div class="form-group col-md-4">
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
                            <div class="form-group col-md-4">
                                <label for="edit_base_price">Precio del Lote <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">S/</span>
                                    </div>
                                    <input type="number" class="form-control" id="edit_base_price" name="base_price"
                                        step="0.01" min="0" required>
                                </div>
                            </div>
                        </div>

                        <!-- Cuarta fila: Precio Actual, Estado -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
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
                            <div class="form-group col-md-6">
                                <label for="edit_status">Estado</label>
                                <select class="form-control" id="edit_status" name="status">
                                    <option value="available">Disponible</option>
                                    <option value="reserved">Reservado</option>
                                    <option value="sold">Vendido</option>
                                    <option value="blocked">Bloqueado</option>
                                </select>
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
                                        <small class="text-muted" id="edit_down_payment_label">Cuota Inicial</small>
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
                                    <!-- Primera fila: Proyecto | Lote | Estado -->
                                    <div class="row align-items-end mb-2">
                                        <div class="col-md-4 text-center">
                                            <div class="lot-label">Proyecto:</div>
                                            <a id="view_project_name" class="lot-value text-primary" href="#"
                                                style="font-size:1.15em;text-decoration:underline;">-</a>
                                            <div class="lot-sub text-muted" id="view_project_location"
                                                style="font-size:0.95em;">-</div>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <div class="lot-label">Lote:</div>
                                            <span id="view_lot_number" class="lot-value"
                                                style="font-size:1.5em;color:#666;font-weight:700;">-</span>
                                            <div class="lot-sub text-muted" style="font-size:0.95em;">Manzana: <span
                                                    id="view_block">-</span></div>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <div class="lot-label">Estado:</div>
                                            <span id="view_status_badge" class="badge"
                                                style="font-size:1em;padding:0.5em 1.2em;">-</span>
                                            <div class="lot-sub text-muted" id="view_last_updated"
                                                style="font-size:0.95em;">-</div>
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- Segunda fila: Área, Precios -->
                                    <div class="row text-center mb-2">
                                        <div class="col-md-3">
                                            <div class="lot-label">Área Total:</div>
                                            <span id="view_area" class="lot-value"
                                                style="color:#0099cc;font-size:1.2em;font-weight:600;">-</span> <span
                                                style="color:#888;font-size:0.95em;">m²</span>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="lot-label">Precio Base:</div>
                                            <span id="view_base_price" class="lot-value"
                                                style="color:#1ca67a;font-size:1.2em;font-weight:600;">-</span>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="lot-label">Precio Actual:</div>
                                            <span id="view_current_price" class="lot-value"
                                                style="color:#e6a100;font-size:1.2em;font-weight:600;">-</span>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="lot-label">Precio por m²:</div>
                                            <span id="view_price_per_sqm" class="lot-value"
                                                style="color:#007bff;font-size:1.2em;font-weight:600;">-</span>
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- Tercera fila: Precio Total del Lote -->
                                    <div class="row text-center">
                                        <div class="col-md-12">
                                            <div class="lot-label">Precio Total del Lote:</div>
                                            <span id="view_total_lot_price" class="lot-value"
                                                style="color:#0099cc;font-size:1.3em;font-weight:700;">-</span>
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
                                            <small class="text-muted" id="view_down_payment_label">Cuota
                                                Inicial</small><br>
                                            <span id="view_initial_payment" class="h5 text-success">-</span>
                                            <span id="view_initial_payment_percent" class="small text-muted"></span>
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
    /* Mejorar la visual del modal de detalles */
    .modal-xl .modal-content {
        background: #f4f6fb;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        border: none;
    }

    .card {
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        border: none;
        margin-bottom: 18px;
    }

    .card-header {
        background: #f8fafc;
        border-bottom: 1px solid #e9ecef;
        border-radius: 12px 12px 0 0;
        padding: 12px 18px;
    }

    .card-body {
        padding: 18px 18px 12px 18px;
    }

    .h5,
    .h6 {
        font-weight: 600;
        margin-bottom: 0;
    }

    .badge {
        font-size: 0.95em;
        padding: 0.45em 1em;
        border-radius: 8px;
        font-weight: 500;
    }

    .badge-success {
        background: #e6f9ec;
        color: #1ca67a;
    }

    .badge-warning {
        background: #fff7e6;
        color: #e6a100;
    }

    .badge-danger {
        background: #ffe6e6;
        color: #d43f3a;
    }

    .badge-secondary {
        background: #e9ecef;
        color: #6c757d;
    }

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
        border-radius: 8px;
        border-left: 3px solid #007bff;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
    }

    .timeline-title {
        margin-bottom: 5px;
        font-size: 15px;
        font-weight: 600;
    }

    /* Mejorar visualización de métricas */
    .metrics-row .col-md-2 {
        background: #fff;
        border-radius: 8px;
        margin: 0 6px 12px 0;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
        padding: 12px 0;
    }

    .metrics-row .h6 {
        font-size: 1.1em;
        margin-top: 4px;
    }

    /* Mejorar visualización de datos financieros */
    #view_initial_payment {
        font-size: 1.5em;
        color: #1ca67a;
        font-weight: 700;
    }

    #view_monthly_payment {
        font-size: 1.2em;
        color: #e6a100;
        font-weight: 700;
    }

    #view_finance_amount {
        font-size: 1.1em;
        color: #007bff;
        font-weight: 600;
    }

    #view_total_lot_price {
        font-size: 1.1em;
        color: #007bff;
        font-weight: 600;
    }

    /* Responsive para mejor visualización */
    @media (max-width: 991px) {
        .modal-xl .modal-content {
            padding: 0 4px;
        }

        .card-body {
            padding: 12px 6px 8px 6px;
        }
    }
    </style>

    <script>
    // Inyectar proyectos al contexto global para JS
    window.projects = <?php echo json_encode($projects); ?>;

    let currentLotData = {};


    function loadLotDataToModal(lot) {
        document.getElementById('edit_project_id').value = lot.project_id || '';
        document.getElementById('edit_lot_number').value = lot.lot_number || '';
        document.getElementById('edit_block').value = lot.block || '';
        document.getElementById('edit_cadastral_unit').value = lot.cadastral_unit || '';
        document.getElementById('edit_area_sqm').value = lot.area_sqm || 0;
        document.getElementById('edit_base_price').value = lot.base_price || 0;
        document.getElementById('edit_current_price').value = lot.current_price || 0;
        // Usar solo el campo status para el estado
        document.getElementById('edit_status').value = lot.status || 'available';

        updateLotPricePerSqm();

        // Actualizar label de cuota inicial en el modal de edición
        const projectSelect = document.getElementById('edit_project_id');
        const selectedOption = projectSelect.options[projectSelect.selectedIndex];
        if (selectedOption) {
            const minDownPaymentPercentage = selectedOption.getAttribute('data-min-down-payment-percentage');
            const editDownPaymentLabel = document.getElementById('edit_down_payment_label');
            if (editDownPaymentLabel && minDownPaymentPercentage) {
                editDownPaymentLabel.textContent = `Cuota Inicial (${minDownPaymentPercentage}%)`;
            }
        }

        // Actualizar label de cuota inicial en el modal de detalles
        let minDownPaymentPercentage = null;
        if (typeof window.projects !== 'undefined' && Array.isArray(window.projects)) {
            const project = window.projects.find(p => p.id == lot.project_id);
            if (project) {
                minDownPaymentPercentage = project.min_down_payment_percentage;
            }
        }
        // Fallback: intentar obtener del select si existe
        if (!minDownPaymentPercentage) {
            const projectSelect = document.getElementById('edit_project_id');
            if (projectSelect) {
                const selectedOption = projectSelect.options[projectSelect.selectedIndex];
                if (selectedOption) {
                    minDownPaymentPercentage = selectedOption.getAttribute('data-min-down-payment-percentage');
                }
            }
        }
        const viewDownPaymentLabel = document.getElementById('view_down_payment_label');
        const percentSpan = document.getElementById('view_initial_payment_percent');
        if (viewDownPaymentLabel && minDownPaymentPercentage) {
            viewDownPaymentLabel.textContent = `Cuota Inicial`;
            if (percentSpan) {
                percentSpan.textContent = ` (${minDownPaymentPercentage}%)`;
            }
        } else {
            if (viewDownPaymentLabel) viewDownPaymentLabel.textContent = 'Cuota Inicial';
            if (percentSpan) percentSpan.textContent = '';
        }

        // Mostrar info de cliente si está vendido/reservado
        if (lot.status === 'sold' || lot.status === 'reserved') {
            document.getElementById('customer-info').style.display = 'block';
            document.getElementById('customer_id_display').textContent = lot.customer_id || 'N/A';
            // Mostrar estado del contrato
            document.getElementById('contract_status_display').textContent = lot.contract_status || '-';
        } else {
            document.getElementById('customer-info').style.display = 'none';
        }

        document.getElementById('edit-lot-form').action = '/dashboard/inmueble/edit_lot/' + lot.id;
        document.getElementById('editLotModalLabel').textContent = 'Editar Lote: ' + lot.lot_number;
        calculateLotPrice();
    }

    function updateLotPricePerSqm() {
        const projectSelect = document.getElementById('edit_project_id');
        const selectedOption = projectSelect.options[projectSelect.selectedIndex];

        if (selectedOption.value) {
            const price = selectedOption.getAttribute('data-price');
            document.getElementById('edit_price_per_sqm').value = price;
            calculateLotPrice();
            // Actualizar label de cuota inicial en el modal de edición
            const minDownPaymentPercentage = selectedOption.getAttribute('data-min-down-payment-percentage');
            const editDownPaymentLabel = document.getElementById('edit_down_payment_label');
            if (editDownPaymentLabel && minDownPaymentPercentage) {
                editDownPaymentLabel.textContent = `Cuota Inicial (${minDownPaymentPercentage}%)`;
            }
        } else {
            document.getElementById('edit_price_per_sqm').value = '';
            // Resetear label si no hay proyecto seleccionado
            const editDownPaymentLabel = document.getElementById('edit_down_payment_label');
            if (editDownPaymentLabel) {
                editDownPaymentLabel.textContent = 'Cuota Inicial';
            }
        }
    }



    // Form submission
    document.getElementById('edit-lot-form').addEventListener('submit', function(e) {
        e.preventDefault();

        // Recopilar datos como objeto plano
        const data = {
            project_id: document.getElementById('edit_project_id').value,
            block: document.getElementById('edit_block').value,
            cadastral_unit: document.getElementById('edit_cadastral_unit').value,
            area_sqm: document.getElementById('edit_area_sqm').value,
            base_price: document.getElementById('edit_base_price').value,
            current_price: document.getElementById('edit_current_price').value,
            status: document.getElementById('edit_status').value
        };
        const area = parseFloat(data.area_sqm);
        const basePrice = parseFloat(data.base_price);

        // Validaciones
        if (area < 50) {
            Swal.fire({
                icon: 'warning',
                title: 'Área insuficiente',
                text: 'El área mínima debe ser de 50 m²'
            });
            return false;
        }

        if (basePrice <= 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Precio inválido',
                text: 'El precio del lote debe ser mayor a 0'
            });
            return false;
        }

        // Enviar como JSON (igual que edit_project)
        fetch(this.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    $('#editLotModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message || 'Lote actualizado exitosamente',
                        timer: 1800,
                        showConfirmButton: false
                    });
                    setTimeout(() => location.reload(), 1800);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Error desconocido'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al procesar la solicitud'
                });
            });
    });




    function editLotFromView() {
        $('#viewLotModal').modal('hide');
        setTimeout(() => {
            editLot(currentLotData.id);
        }, 300);
    }

    function printLotDetails() {
        window.print();
    }

    function createContract() {
        if (currentLotData.status !== 'available') {
            alert('Este lote no está disponible para crear un contrato');
            return;
        }
        window.location.href = '/dashboard/inmueble/create_contract?lot_id=' + currentLotData.id;
    }
    </script>

    <?php echo view("admin/footer"); ?>
</body>

<!-- Scripts de gestión de lotes -->
<script src="/assets/js/lot/lot-add.js"></script>
<script src="/assets/js/lot/lot-delete.js"></script>
<script src="/assets/js/lot/lot-detail.js"></script>
<script src="/assets/js/lot/lot-edit.js"></script>

</html>