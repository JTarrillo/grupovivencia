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
                                                <button type="button" class="btn btn-primary btn-sm" onclick="showCreateLotModal()">
                                                    <i class="feather icon-plus"></i> Nuevo Lote
                                                </button>
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#bulkCreateModal" style="margin-left: 5px;">
                                                    <i class="feather icon-layers"></i> Crear Múltiples Lotes
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <!-- Filtros Avanzados Mejorados -->
                                            <div class="row mb-4 p-3 bg-light rounded" style="border: 1px solid #e3e6f0;">
                                                <!-- Búsqueda Principal -->
                                                <div class="col-md-3 col-sm-6 mb-2">
                                                    <label class="small mb-2"><strong><i class="fa fa-search"></i> Buscar</strong></label>
                                                    <input type="text" class="form-control form-control-sm" id="search-lotes" 
                                                        placeholder="Lote, Manzana..." onkeyup="filterTable()">
                                                </div>

                                                <!-- Proyecto -->
                                                <div class="col-md-3 col-sm-6 mb-2">
                                                    <label class="small mb-2"><strong><i class="fa fa-building"></i> Proyecto</strong></label>
                                                    <select class="form-control form-control-sm" id="project-filter" onchange="filterTable()">
                                                        <option value="">Todos</option>
                                                        <?php foreach ($projects as $project): ?>
                                                        <option value="<?= $project['id'] ?>"
                                                            <?= $selected_project == $project['id'] ? 'selected' : '' ?>>
                                                            <?= $project['name'] ?>
                                                        </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <!-- Estado -->
                                                <div class="col-md-3 col-sm-6 mb-2">
                                                    <label class="small mb-2"><strong><i class="fa fa-tag"></i> Estado</strong></label>
                                                    <select class="form-control form-control-sm" id="status-filter" onchange="filterTable()">
                                                        <option value="">Todos</option>
                                                        <option value="available">Disponible</option>
                                                        <option value="reserved">Reservado</option>
                                                        <option value="sold">Vendido</option>
                                                        <option value="blocked">Bloqueado</option>
                                                    </select>
                                                </div>

                                                <!-- Rango de Precio -->
                                                <div class="col-md-3 col-sm-6 mb-2">
                                                    <label class="small mb-2"><strong><i class="fa fa-dollar"></i> Precio</strong></label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" class="form-control" id="price-min" 
                                                            placeholder="Mín" onkeyup="filterTable()" min="0">
                                                        <input type="number" class="form-control" id="price-max" 
                                                            placeholder="Máx" onkeyup="filterTable()" min="0">
                                                    </div>
                                                </div>

                                                <!-- Rango de Área -->
                                                <div class="col-md-3 col-sm-6 mb-2">
                                                    <label class="small mb-2"><strong><i class="fa fa-expand"></i> Área (m²)</strong></label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" class="form-control" id="area-min" 
                                                            placeholder="Mín" onkeyup="filterTable()" min="0">
                                                        <input type="number" class="form-control" id="area-max" 
                                                            placeholder="Máx" onkeyup="filterTable()" min="0">
                                                    </div>
                                                </div>

                                                <!-- Botón Limpiar -->
                                                <div class="col-md-3 col-sm-6 d-flex align-items-end mb-2">
                                                    <button type="button" class="btn btn-secondary btn-sm btn-block" onclick="clearFilters()">
                                                        <i class="fa fa-times"></i> Limpiar Filtros
                                                    </button>
                                                </div>

                                                <!-- Contador de Resultados -->
                                                <div class="col-12 mt-2">
                                                    <small class="text-muted">
                                                        <i class="fa fa-info-circle"></i> 
                                                        Mostrando <strong id="result-count">0</strong> lote(s) de <strong id="total-count">0</strong>
                                                    </small>
                                                </div>
                                            </div>

                                            <!-- BARRA DE HERRAMIENTAS PARA OPERACIONES EN MASA -->
                                            <div id="bulk-actions-bar" class="alert alert-info" style="display: none; margin-bottom: 20px;">
                                                <div class="row align-items-center">
                                                    <div class="col-md-4">
                                                        <strong id="selected-count">0 lotes seleccionados</strong>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <button type="button" class="btn btn-sm btn-warning" onclick="bulkChangeStatus()">
                                                            <i class="feather icon-edit-2"></i> Cambiar Estado
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-info" onclick="bulkUpdatePrices()">
                                                            <i class="feather icon-dollar-sign"></i> Actualizar Precios
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-success" onclick="bulkExport()">
                                                            <i class="feather icon-download"></i> Exportar
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger" onclick="bulkDelete()">
                                                            <i class="feather icon-trash-2"></i> Eliminar
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-secondary" onclick="clearSelection()">
                                                            <i class="feather icon-x"></i> Limpiar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="table-responsive">
                                                <table id="zero-configuration"
                                                    class="display table nowrap table-striped table-hover dataTable"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 40px;">
                                                                <input type="checkbox" id="select-all" onchange="toggleSelectAll(this)">
                                                            </th>
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
                                                        <tr class="lot-row" data-lot-id="<?= $lot['id'] ?>">
                                                            <td>
                                                                <input type="checkbox" class="lot-checkbox" value="<?= $lot['id'] ?>" onchange="updateBulkActions()">
                                                            </td>
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
    <!-- Modal para Crear Lote -->
    <div class="modal fade" id="createLotModal" tabindex="-1" role="dialog" aria-labelledby="createLotModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form id="create-lot-form" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createLotModalLabel">Crear Nuevo Lote</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Columna izquierda: Formulario -->
                            <div class="col-md-8">
                                <!-- Primera fila: Proyecto, Número de Lote, Manzana -->
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="create_project_id">Proyecto <span class="text-danger">*</span></label>
                                        <select class="form-control" id="create_project_id" name="project_id" required>
                                            <option value="">Seleccionar proyecto</option>
                                            <?php foreach ($projects as $project): ?>
                                            <option value="<?= $project['id'] ?>"
                                                data-price="<?= $project['base_price_per_sqm'] ?>"
                                                data-location="<?= $project['location'] ?>"
                                                data-min-down-payment-percentage="<?= $project['min_down_payment_percentage'] ?>"
                                                data-min-down-payment-fixed="<?= $project['min_down_payment_fixed'] ?>">
                                                <?= $project['name'] ?> (<?= $project['code'] ?>)
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="create_lot_number">Número de Lote <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="create_lot_number" name="lot_number" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="create_block">Manzana</label>
                                        <input type="text" class="form-control" id="create_block" name="block" placeholder="Ej: A, B, C">
                                    </div>
                                </div>

                                <!-- Segunda fila: Unidad Catastral, Partida Electrónica -->
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="create_cadastral_unit">Unidad Catastral</label>
                                        <input type="text" class="form-control" id="create_cadastral_unit" name="cadastral_unit"
                                            placeholder="Ej: UC-12345">
                                        <small class="form-text text-muted">Dato oficial del catastro, si aplica.</small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="create_registry_number">Partida Electrónica (Electronic Property Record)</label>
                                        <input type="text" class="form-control" id="create_registry_number" name="registry_number"
                                            placeholder="Ej: 12345678">
                                        <small class="form-text text-muted">Número de la Partida Electrónica SUNARP.</small>
                                    </div>
                                </div>

                                <!-- Tercera fila: Área, Precio por m2, Precio Total del Lote -->
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="create_area_sqm">Área (m²) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="create_area_sqm" name="area_sqm" step="0.01"
                                            min="50" required>
                                        <small class="form-text text-muted">Área mínima: 50 m²</small>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="create_price_per_sqm">Precio por m²</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">S/</span>
                                            </div>
                                            <input type="number" class="form-control" id="create_price_per_sqm" step="0.01"
                                                readonly>
                                        </div>
                                        <small class="form-text text-muted">Se toma del proyecto seleccionado</small>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="create_base_price">Precio Total del Lote <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">S/</span>
                                            </div>
                                            <input type="number" class="form-control" id="create_base_price" name="base_price"
                                                step="0.01" min="0" required>
                                        </div>
                                        <small class="form-text text-muted">Se calcula automáticamente</small>
                                    </div>
                                </div>

                                <!-- Cuarta fila: Estado Inicial -->
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="create_status">Estado Inicial</label>
                                        <select class="form-control" id="create_status" name="status">
                                            <option value="available">Disponible</option>
                                            <option value="reserved">Reservado</option>
                                            <option value="sold">Vendido</option>
                                            <option value="blocked">Bloqueado</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="createLotErrorMsg" class="alert alert-danger d-none"></div>
                            </div>

                            <!-- Columna derecha: Información del Proyecto y Resumen -->
                            <div class="col-md-4">
                                <!-- Información del Proyecto -->
                                <div class="card bg-light mb-3">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Información del Proyecto</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <small class="text-muted">Ubicación:</small><br>
                                            <strong id="create_project_location">-</strong>
                                        </div>
                                        <div>
                                            <small class="text-muted">Precio base m²:</small><br>
                                            <strong id="create_project_price">S/ -</strong>
                                        </div>
                                    </div>
                                </div>

                                <!-- Resumen del Lote -->
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Resumen del Lote</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <small class="text-muted">Área: </small>
                                            <strong id="create_calc_area">0 m²</strong>
                                        </div>
                                        <div class="mb-2">
                                            <small class="text-muted">Precio m²: </small>
                                            <strong id="create_calc_price_per_m2">S/ 0</strong>
                                        </div>
                                        <div class="mb-2">
                                            <small class="text-muted">Precio Total: </small>
                                            <strong id="create_calc_price" class="text-success">S/ 0</strong>
                                        </div>
                                        <div>
                                            <small class="text-muted" id="create_down_payment_label">Cuota Inicial: </small>
                                            <strong id="create_calc_initial" class="text-warning">S/ 0</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="feather icon-x"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="feather icon-save"></i> Crear Lote
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Lote -->
    <div class="modal fade" id="editLotModal" tabindex="-1" role="dialog" aria-labelledby="editLotModalLabel" aria-hidden="true">
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

    function editLot(lotId) {
        // Obtener datos del lote vía AJAX
        fetch('/dashboard/inmueble/get_lot/' + lotId)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.lot) {
                    // Cargar datos en el modal
                    loadLotDataToModal(data.lot);
                    
                    // Actualizar el título
                    document.getElementById('editLotModalLabel').textContent = 'Editar Lote: ' + data.lot.lot_number;
                    
                    // Guardar el ID del lote que se está editando
                    document.getElementById('edit-lot-form').dataset.lotId = lotId;
                    
                    // Actualizar la acción del formulario
                    document.getElementById('edit-lot-form').action = '/dashboard/inmueble/edit_lot/' + lotId;
                    
                    // Mostrar el modal
                    $('#editLotModal').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo cargar el lote'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al obtener el lote'
                });
            });
    }

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

    // Funciones de Filtrado Avanzado
    function filterTable() {
        const table = document.getElementById('zero-configuration');
        const tbody = table.getElementsByTagName('tbody')[0];
        const rows = tbody.getElementsByTagName('tr');
        
        // Obtener valores de filtros
        const searchVal = document.getElementById('search-lotes').value.toLowerCase();
        const projectVal = document.getElementById('project-filter').value;
        const statusVal = document.getElementById('status-filter').value;
        const priceMin = parseFloat(document.getElementById('price-min').value) || 0;
        const priceMax = parseFloat(document.getElementById('price-max').value) || Infinity;
        const areaMin = parseFloat(document.getElementById('area-min').value) || 0;
        const areaMax = parseFloat(document.getElementById('area-max').value) || Infinity;
        
        let visibleCount = 0;
        
        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName('td');
            
            // Extraer datos de la fila
            const projectId = cells[1]?.textContent.trim() || '';
            const lotNumber = cells[2]?.textContent.toLowerCase() || '';
            const block = cells[3]?.textContent.toLowerCase() || '';
            const areaText = cells[6]?.textContent.trim() || '0';
            const priceText = cells[8]?.textContent.replace(/[^\d.]/g, '') || '0';
            const statusBadge = cells[9]?.querySelector('.badge');
            const statusText = statusBadge?.textContent.trim().toLowerCase() || '';
            
            let area = parseFloat(areaText) || 0;
            let price = parseFloat(priceText) || 0;
            
            // Aplicar filtros
            let show = true;
            
            // Filtro de búsqueda
            if (searchVal && !(lotNumber.includes(searchVal) || block.includes(searchVal))) {
                show = false;
            }
            
            // Filtro de proyecto (comparar por ID)
            if (projectVal && !projectId.includes(projectVal)) {
                show = false;
            }
            
            // Filtro de estado
            if (statusVal) {
                const estadoMap = {
                    'available': 'disponible',
                    'reserved': 'reservado',
                    'sold': 'vendido',
                    'blocked': 'bloqueado'
                };
                if (!statusText.includes(estadoMap[statusVal] || statusVal)) {
                    show = false;
                }
            }
            
            // Filtro de precio
            if (price < priceMin || price > priceMax) {
                show = false;
            }
            
            // Filtro de área
            if (area < areaMin || area > areaMax) {
                show = false;
            }
            
            row.style.display = show ? '' : 'none';
            if (show) visibleCount++;
        }
        
        // Actualizar contador
        document.getElementById('result-count').textContent = visibleCount;
        document.getElementById('total-count').textContent = rows.length;
    }

    function clearFilters() {
        document.getElementById('search-lotes').value = '';
        document.getElementById('project-filter').value = '';
        document.getElementById('status-filter').value = '';
        document.getElementById('price-min').value = '';
        document.getElementById('price-max').value = '';
        document.getElementById('area-min').value = '';
        document.getElementById('area-max').value = '';
        filterTable();
    }

    // Inicializar contador e desactivar DataTable search al cargar
    // Mostrar modal para crear lote
    function showCreateLotModal() {
        // Limpiar el formulario
        document.getElementById('create-lot-form').reset();
        document.getElementById('createLotErrorMsg').classList.add('d-none');
        document.getElementById('create_project_id').value = '';
        document.getElementById('create_price_per_sqm').value = '';
        $('#createLotModal').modal('show');
    }

    // Manejar envío del formulario de crear lote
    document.addEventListener('DOMContentLoaded', function() {
        const createLotForm = document.getElementById('create-lot-form');
        
        if (createLotForm) {
            // Función para calcular precio automático en crear lote
            function calculateCreateLotSummary() {
                const area = parseFloat(document.getElementById('create_area_sqm').value) || 0;
                const pricePerSqm = parseFloat(document.getElementById('create_price_per_sqm').value) || 0;
                
                const calculatedPrice = area * pricePerSqm;
                
                // Actualizar automáticamente el campo "Precio del Lote" con el precio calculado
                document.getElementById('create_base_price').value = calculatedPrice.toFixed(2);
                
                // Obtener el porcentaje de cuota inicial del proyecto seleccionado
                const projectSelect = document.getElementById('create_project_id');
                const selectedOption = projectSelect.options[projectSelect.selectedIndex];
                const minDownPaymentPercentage = parseFloat(selectedOption?.getAttribute('data-min-down-payment-percentage')) || 0;
                const minDownPaymentFixed = parseFloat(selectedOption?.getAttribute('data-min-down-payment-fixed')) || 0;
                
                let initialPayment = 0;
                if (minDownPaymentPercentage > 0) {
                    initialPayment = (calculatedPrice * minDownPaymentPercentage) / 100;
                } else if (minDownPaymentFixed > 0) {
                    initialPayment = minDownPaymentFixed;
                }
                
                // Actualizar los elementos del resumen
                document.getElementById('create_calc_area').textContent = area.toFixed(2) + ' m²';
                document.getElementById('create_calc_price_per_m2').textContent = 'S/ ' + pricePerSqm.toFixed(2);
                document.getElementById('create_calc_price').textContent = 'S/ ' + calculatedPrice.toFixed(2);
                document.getElementById('create_calc_initial').textContent = 'S/ ' + initialPayment.toFixed(2);
                
                // Actualizar label si es porcentaje
                const downPaymentLabel = document.getElementById('create_down_payment_label');
                if (downPaymentLabel && minDownPaymentPercentage > 0) {
                    downPaymentLabel.textContent = `Cuota Inicial (${minDownPaymentPercentage}%): `;
                } else if (downPaymentLabel) {
                    downPaymentLabel.textContent = 'Cuota Inicial: ';
                }
            }
            
            // Actualizar precio por m² cuando cambia el proyecto
            document.getElementById('create_project_id').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    const price = selectedOption.getAttribute('data-price');
                    const location = selectedOption.getAttribute('data-location');
                    document.getElementById('create_price_per_sqm').value = price;
                    document.getElementById('create_project_location').textContent = location || '-';
                    document.getElementById('create_project_price').textContent = 'S/ ' + price;
                } else {
                    document.getElementById('create_price_per_sqm').value = '';
                    document.getElementById('create_project_location').textContent = '-';
                    document.getElementById('create_project_price').textContent = 'S/ -';
                }
                calculateCreateLotSummary();
            });

            // Calcular cuando cambia el área
            document.getElementById('create_area_sqm').addEventListener('change', calculateCreateLotSummary);
            document.getElementById('create_area_sqm').addEventListener('input', calculateCreateLotSummary);

            // Calcular cuando cambia el precio por m²
            document.getElementById('create_price_per_sqm').addEventListener('change', calculateCreateLotSummary);

            // Calcular cuando cambia el precio base
            document.getElementById('create_base_price').addEventListener('change', calculateCreateLotSummary);
            document.getElementById('create_base_price').addEventListener('input', calculateCreateLotSummary);

            // Disparar cálculo cuando se abre el modal
            $('#createLotModal').on('shown.bs.modal', function() {
                calculateCreateLotSummary();
            });

            // Enviar formulario
            createLotForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm mr-2"></span>Guardando...';
                
                fetch('/dashboard/inmueble/create_lot', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        $('#createLotModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Lote creado exitosamente',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        // Recargar la página para ver el nuevo lote
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        const errorDiv = document.getElementById('createLotErrorMsg');
                        errorDiv.textContent = data.message || 'Error desconocido';
                        errorDiv.classList.remove('d-none');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    const errorDiv = document.getElementById('createLotErrorMsg');
                    errorDiv.textContent = 'Error al procesar la solicitud';
                    errorDiv.classList.remove('d-none');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="feather icon-save"></i> Crear Lote';
                });
            });
        }

        // Inicializar contador de tabla y desactivar buscador por defecto
        const table = document.getElementById('zero-configuration');
        const tbody = table.getElementsByTagName('tbody')[0];
        const totalRows = tbody.getElementsByTagName('tr').length;
        document.getElementById('result-count').textContent = totalRows;
        document.getElementById('total-count').textContent = totalRows;
        
        // Desactivar el buscador por defecto de DataTable si está inicializado
        setTimeout(function() {
            if ($.fn.DataTable.isDataTable('#zero-configuration')) {
                const dtTable = $('#zero-configuration').DataTable();
                dtTable.search('').draw();
                // Ocultar la búsqueda por defecto de DataTable
                $('.dataTables_filter').hide();
            }
        }, 500);
    });

    // ============ FUNCIONES PARA OPERACIONES EN MASA ============
    let selectedLots = [];

    function getSelectedLots() {
        const checkboxes = document.querySelectorAll('.lot-checkbox:checked');
        return Array.from(checkboxes).map(cb => cb.value);
    }

    function updateBulkActions() {
        selectedLots = getSelectedLots();
        const bulkBar = document.getElementById('bulk-actions-bar');
        const selectedCount = document.getElementById('selected-count');
        
        if (selectedLots.length > 0) {
            bulkBar.style.display = 'block';
            selectedCount.textContent = `${selectedLots.length} lote${selectedLots.length !== 1 ? 's' : ''} seleccionado${selectedLots.length !== 1 ? 's' : ''}`;
        } else {
            bulkBar.style.display = 'none';
        }
    }

    function toggleSelectAll(checkbox) {
        const lotCheckboxes = document.querySelectorAll('.lot-checkbox');
        lotCheckboxes.forEach(cb => cb.checked = checkbox.checked);
        updateBulkActions();
    }

    function clearSelection() {
        const allCheckbox = document.getElementById('select-all');
        const lotCheckboxes = document.querySelectorAll('.lot-checkbox');
        lotCheckboxes.forEach(cb => cb.checked = false);
        allCheckbox.checked = false;
        updateBulkActions();
    }

    function bulkChangeStatus() {
        selectedLots = getSelectedLots();
        if (selectedLots.length === 0) {
            Swal.fire('Aviso', 'Por favor selecciona al menos un lote', 'warning');
            return;
        }
        Swal.fire({
            title: 'Cambiar Estado',
            html: `
                <div class="form-group">
                    <label>Nuevo Estado</label>
                    <select id="new_status" class="form-control">
                        <option value="">Seleccionar</option>
                        <option value="available">Disponible</option>
                        <option value="reserved">Reservado</option>
                        <option value="sold">Vendido</option>
                        <option value="blocked">Bloqueado</option>
                    </select>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Cambiar',
            cancelButtonText: 'Cancelar'
        }).then(result => {
            if (result.isConfirmed) {
                const newStatus = document.getElementById('new_status').value;
                if (!newStatus) {
                    Swal.fire('Error', 'Selecciona un estado', 'error');
                    return;
                }
                fetch('/dashboard/inmueble/api/bulk_change_status', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        lot_ids: selectedLots,
                        status: newStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('¡Éxito!', `${data.updated_count} lote(s) actualizado(s)`, 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        Swal.fire('Error', data.message || 'Error desconocido', 'error');
                    }
                })
                .catch(error => Swal.fire('Error', 'Error al procesar la solicitud', 'error'));
            }
        });
    }

    function bulkUpdatePrices() {
        selectedLots = getSelectedLots();
        if (selectedLots.length === 0) {
            Swal.fire('Aviso', 'Por favor selecciona al menos un lote', 'warning');
            return;
        }
        Swal.fire({
            title: 'Actualizar Precios',
            html: `
                <div class="form-group text-left">
                    <label>Tipo de Actualización</label>
                    <select id="update_type" class="form-control" onchange="updatePriceInputLabel()">
                        <option value="percentage">Por Porcentaje (%)</option>
                        <option value="fixed">Monto Fijo (S/)</option>
                        <option value="set">Establecer Precio Exacto</option>
                    </select>
                    <label class="mt-3">Valor</label>
                    <input type="number" id="update_value" class="form-control" step="0.01" placeholder="Ej: 10">
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Actualizar',
            cancelButtonText: 'Cancelar',
            didOpen: () => {
                document.getElementById('update_type').focus();
            }
        }).then(result => {
            if (result.isConfirmed) {
                const updateType = document.getElementById('update_type').value;
                const updateValue = parseFloat(document.getElementById('update_value').value);
                
                if (isNaN(updateValue)) {
                    Swal.fire('Error', 'Ingresa un valor válido', 'error');
                    return;
                }

                fetch('/dashboard/inmueble/api/bulk_update_prices', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        lot_ids: selectedLots,
                        update_type: updateType,
                        value: updateValue
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('¡Éxito!', `Precios actualizados en ${data.updated_count} lote(s)`, 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        Swal.fire('Error', data.message || 'Error desconocido', 'error');
                    }
                })
                .catch(error => Swal.fire('Error', 'Error al procesar la solicitud', 'error'));
            }
        });
    }

    function bulkExport() {
        selectedLots = getSelectedLots();
        if (selectedLots.length === 0) {
            Swal.fire('Aviso', 'Por favor selecciona al menos un lote', 'warning');
            return;
        }
        Swal.fire({
            title: 'Selecciona formato',
            icon: 'question',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Excel',
            denyButtonText: 'PDF',
            cancelButtonText: 'Cancelar'
        }).then(result => {
            if (result.isConfirmed) {
                window.location.href = '/dashboard/inmueble/api/export_lots?format=excel&lot_ids=' + selectedLots.join(',');
            } else if (result.isDenied) {
                window.location.href = '/dashboard/inmueble/api/export_lots?format=pdf&lot_ids=' + selectedLots.join(',');
            }
        });
    }

    function bulkDelete() {
        selectedLots = getSelectedLots();
        if (selectedLots.length === 0) {
            Swal.fire('Aviso', 'Por favor selecciona al menos un lote', 'warning');
            return;
        }
        Swal.fire({
            title: '¡Atención!',
            text: `¿Estás seguro de eliminar ${selectedLots.length} lote(s)? Esta acción es irreversible.`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            confirmButtonColor: '#dc3545',
            cancelButtonText: 'Cancelar'
        }).then(result => {
            if (result.isConfirmed) {
                fetch('/dashboard/inmueble/api/bulk_delete_lots', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        lot_ids: selectedLots
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Eliminado', `${data.deleted_count} lote(s) eliminado(s)`, 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        Swal.fire('Error', data.message || 'Error desconocido', 'error');
                    }
                })
                .catch(error => Swal.fire('Error', 'Error al procesar la solicitud', 'error'));
            }
        });
    }

    function updatePriceInputLabel() {
        const type = document.getElementById('update_type').value;
        const input = document.getElementById('update_value');
        if (type === 'percentage') {
            input.placeholder = 'Ej: 10 (para aumentar 10%)';
        } else if (type === 'fixed') {
            input.placeholder = 'Ej: 5000 (para aumentar S/ 5,000)';
        } else {
            input.placeholder = 'Ej: 50000 (precio exacto)';
        }
    }
    </script>

    <!-- MODAL: CREAR MÚLTIPLES LOTES -->
    <div class="modal fade" id="bulkCreateModal" tabindex="-1" role="dialog" aria-labelledby="bulkCreateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkCreateModalLabel">Crear Múltiples Lotes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="bulk-lot-form">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bulk_project_id">Proyecto <span class="text-danger">*</span></label>
                                    <select class="form-control" id="bulk_project_id" required
                                        onchange="updateBulkProjectInfo()">
                                        <option value="">Seleccionar proyecto</option>
                                        <?php foreach ($projects as $project): ?>
                                        <option value="<?= $project['id'] ?>"
                                            data-price="<?= $project['base_price_per_sqm'] ?>"
                                            data-location="<?= $project['location'] ?>">
                                            <?= $project['name'] ?> (<?= $project['code'] ?>)
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-info" id="bulk-project-info" style="display:none;">
                                    <strong>Ubicación:</strong> <span id="bulk-location">-</span><br>
                                    <strong>Precio m²:</strong> S/ <span id="bulk-price">-</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tabla de Lotes -->
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-bordered table-sm" id="bulk-lots-table">
                                <thead class="bg-light sticky-top">
                                    <tr>
                                        <th style="width:12%">Lote #</th>
                                        <th style="width:12%">Manzana</th>
                                        <th style="width:15%">Área (m²)</th>
                                        <th style="width:18%">Precio Base</th>
                                        <th style="width:18%">Estado</th>
                                        <th style="width:15%">Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="bulk-lots-body">
                                    <!-- Las filas se agregarán aquí -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Botones agregar filas -->
                        <div class="mt-3 mb-3">
                            <button type="button" class="btn btn-sm btn-primary" onclick="addBulkLotRow()">
                                <i class="feather icon-plus"></i> Agregar Lote
                            </button>
                            <button type="button" class="btn btn-sm btn-primary" onclick="addBulkLotRows(5)">
                                <i class="feather icon-plus"></i> Agregar 5 Lotes
                            </button>
                            <button type="button" class="btn btn-sm btn-primary" onclick="addBulkLotRows(10)">
                                <i class="feather icon-plus"></i> Agregar 10 Lotes
                            </button>
                        </div>

                        <!-- Resumen -->
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Resumen</h6>
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <small class="text-muted">Lotes a Crear</small>
                                        <div class="h5 text-primary" id="bulk-summary-count">0</div>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <small class="text-muted">Área Total</small>
                                        <div class="h5 text-info" id="bulk-summary-area">0 m²</div>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <small class="text-muted">Inversión Total</small>
                                        <div class="h5 text-success" id="bulk-summary-investment">S/ 0</div>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <small class="text-muted">Cuota Inicial Prom.</small>
                                        <div class="h5 text-warning" id="bulk-summary-initial">S/ 0</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="feather icon-x"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" onclick="submitBulkLots()">
                        <i class="feather icon-save"></i> Crear <span id="btn-bulk-count">0</span> Lotes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    // ============ FUNCIONES PARA CREAR MÚLTIPLES LOTES ============
    let bulkProjectPrice = 0;

    function updateBulkProjectInfo() {
        const projectSelect = document.getElementById('bulk_project_id');
        const selectedOption = projectSelect.options[projectSelect.selectedIndex];

        if (selectedOption.value) {
            const price = selectedOption.getAttribute('data-price');
            const location = selectedOption.getAttribute('data-location');

            bulkProjectPrice = parseFloat(price) || 0;
            document.getElementById('bulk-location').textContent = location;
            document.getElementById('bulk-price').textContent = price;
            document.getElementById('bulk-project-info').style.display = 'block';
        } else {
            document.getElementById('bulk-project-info').style.display = 'none';
            bulkProjectPrice = 0;
        }
    }

    function addBulkLotRow() {
        const projectId = document.getElementById('bulk_project_id').value;
        if (!projectId) {
            Swal.fire({
                icon: 'warning',
                title: 'Por favor selecciona un proyecto primero',
                toast: true,
                position: 'top-end',
                timer: 2000,
                showConfirmButton: false
            });
            return;
        }

        const tbody = document.getElementById('bulk-lots-body');
        const rowId = 'bulk-lot-row-' + Date.now();

        const row = document.createElement('tr');
        row.id = rowId;
        row.innerHTML = `
            <td>
                <input type="text" class="form-control form-control-sm bulk-lot-number" placeholder="L001" required>
            </td>
            <td>
                <input type="text" class="form-control form-control-sm bulk-lot-block" placeholder="A">
            </td>
            <td>
                <input type="number" class="form-control form-control-sm bulk-lot-area" step="0.01" min="50" placeholder="250" required onchange="calculateBulkPrice(this); updateBulkSummary()">
            </td>
            <td>
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text">S/</span>
                    </div>
                    <input type="number" class="form-control form-control-sm bulk-lot-price" step="0.01" min="0" placeholder="0" required onchange="updateBulkSummary()">
                </div>
            </td>
            <td>
                <select class="form-control form-control-sm bulk-lot-status" onchange="updateBulkSummary()">
                    <option value="available">Disponible</option>
                    <option value="blocked">Bloqueado</option>
                </select>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeBulkLotRow('${rowId}')">
                    <i class="feather icon-trash"></i>
                </button>
            </td>
        `;

        tbody.appendChild(row);
        updateBulkSummary();
    }

    function addBulkLotRows(count) {
        for (let i = 0; i < count; i++) {
            addBulkLotRow();
        }
    }

    function removeBulkLotRow(rowId) {
        const row = document.getElementById(rowId);
        if (row) {
            row.remove();
            updateBulkSummary();
        }
    }

    function calculateBulkPrice(areaInput) {
        if (bulkProjectPrice > 0) {
            const area = parseFloat(areaInput.value) || 0;
            if (area > 0) {
                const row = areaInput.closest('tr');
                const priceInput = row.querySelector('.bulk-lot-price');
                const calculatedPrice = area * bulkProjectPrice;
                priceInput.value = calculatedPrice.toFixed(2);
            }
        }
    }

    function updateBulkSummary() {
        const rows = document.querySelectorAll('#bulk-lots-body tr');
        let totalCount = rows.length;
        let totalArea = 0;
        let totalPrice = 0;
        let validRows = 0;

        rows.forEach(row => {
            const area = parseFloat(row.querySelector('.bulk-lot-area')?.value) || 0;
            const price = parseFloat(row.querySelector('.bulk-lot-price')?.value) || 0;

            if (area >= 50 && price > 0) {
                totalArea += area;
                totalPrice += price;
                validRows++;
            }
        });

        const avgInitial = validRows > 0 ? (totalPrice / validRows) * 0.15 : 0;

        document.getElementById('bulk-summary-count').textContent = validRows;
        document.getElementById('bulk-summary-area').textContent = totalArea.toFixed(2) + ' m²';
        document.getElementById('bulk-summary-investment').textContent = 'S/ ' + totalPrice.toLocaleString('es-PE', {
            minimumFractionDigits: 2
        });
        document.getElementById('bulk-summary-initial').textContent = 'S/ ' + avgInitial.toLocaleString('es-PE', {
            minimumFractionDigits: 2
        });
        document.getElementById('btn-bulk-count').textContent = validRows;
    }

    function submitBulkLots() {
        const projectId = document.getElementById('bulk_project_id').value;
        if (!projectId) {
            Swal.fire({
                icon: 'warning',
                title: 'Error',
                text: 'Por favor selecciona un proyecto'
            });
            return;
        }

        const rows = document.querySelectorAll('#bulk-lots-body tr');
        const lots = [];

        rows.forEach(row => {
            const lotNumber = row.querySelector('.bulk-lot-number')?.value;
            const block = row.querySelector('.bulk-lot-block')?.value || '';
            const area = parseFloat(row.querySelector('.bulk-lot-area')?.value);
            const price = parseFloat(row.querySelector('.bulk-lot-price')?.value);
            const status = row.querySelector('.bulk-lot-status')?.value;

            if (lotNumber && area >= 50 && price > 0) {
                lots.push({
                    lot_number: lotNumber,
                    block: block,
                    area_sqm: area,
                    base_price: price,
                    status: status
                });
            }
        });

        if (lots.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Error',
                text: 'No hay lotes válidos para crear'
            });
            return;
        }

        Swal.fire({
            title: '¿Crear ' + lots.length + ' lote(s)?',
            text: 'Se crearán ' + lots.length + ' lote(s) en el proyecto seleccionado',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, crear',
            cancelButtonText: 'Cancelar'
        }).then(result => {
            if (result.isConfirmed) {
                fetch('/dashboard/inmueble/create_lots_bulk', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            project_id: projectId,
                            lots: lots
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: 'Se crearon ' + (data.created_count || lots.length) +
                                    ' lote(s)',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            setTimeout(() => {
                                $('#bulkCreateModal').modal('hide');
                                location.reload();
                            }, 2000);
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
            }
        });
    }
    </script>

    <style>
    .sticky-top {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .form-control-sm {
        height: calc(1.5em + 0.5rem + 2px);
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }

    .input-group-sm .input-group-text {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }

    .table-sm th,
    .table-sm td {
        padding: 0.5rem;
    }

    #bulk-lots-table {
        margin-bottom: 0;
    }

    .card-header-right {
        display: flex;
        gap: 5px;
    }
    </style>

    <?php echo view("admin/footer"); ?>
</body>

<!-- Scripts de gestión de lotes -->
<script src="/assets/js/lot/lot-add.js"></script>
<script src="/assets/js/lot/lot-delete.js"></script>
<script src="/assets/js/lot/lot-detail.js"></script>
<script src="/assets/js/lot/lot-edit.js"></script>

</html>