<!doctype html>
<html lang="es-PE">
<?php echo view("admin/head"); ?>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Scripts de contratos modularizados -->
<script src="/assets/js/contracts-add.js"></script>
<script src="/assets/js/contracts-edit.js"></script>
<script src="/assets/js/contracts-suspend.js"></script>
<script src="/assets/js/contracts-delete.js"></script>
<script src="/assets/js/contracts.js"></script>

<body data-new-gr-c-s-check-loaded="14.1042.0" data-gr-ext-installed="">
    <?php echo view("admin/header"); ?>
    <section class="pcoded-main-container">
        <!-- Modal Vista Previa Contrato -->
        <div class="modal fade" id="contractPreviewModal" tabindex="-1" role="dialog"
            aria-labelledby="contractPreviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header border-0">
                        <div class="mx-auto w-100 text-center">
                            <i class="feather icon-info f-48 text-info mb-2"></i>
                            <h4 class="modal-title" id="contractPreviewModalLabel">Vista Previa del Contrato</h4>
                        </div>
                    </div>
                    <div class="modal-body" id="contractPreviewContent">
                        <!-- El contenido se inserta dinámicamente -->
                    </div>
                    <div class="modal-footer border-0 justify-content-center">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Editar Contrato -->
        <div class="modal fade" id="editContractModal" tabindex="-1" role="dialog"
            aria-labelledby="editContractModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="editContractModalLabel">Editar Contrato</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="editContractContent">
                        <!-- El contenido se inserta dinámicamente -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
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
                                        <li class="breadcrumb-item"><a href="/dashboard/inmueble">Gestión
                                                Inmobiliaria</a></li>
                                        <li class="breadcrumb-item"><a>Contratos</a></li>
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
                                            <h5>Gestión de Contratos de Venta</h5>
                                            <div class="card-header-right">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="openNewContractModal()">
                                                    <i class="feather icon-plus"></i> Nuevo Contrato
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <!-- Filtros -->
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <select class="form-control" id="status-filter"
                                                        onchange="filterContracts()">
                                                        <option value="">Todos los Estados</option>
                                                        <option value="active">Activo</option>
                                                        <option value="completed">Completado</option>
                                                        <option value="cancelled">Cancelado</option>
                                                        <option value="suspended">Suspendido</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="date" class="form-control" id="date-from"
                                                        onchange="filterContracts()" placeholder="Fecha desde">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="date" class="form-control" id="date-to"
                                                        onchange="filterContracts()" placeholder="Fecha hasta">
                                                </div>
                                                <div class="col-md-3">
                                                    <button class="btn btn-secondary" onclick="clearFilters()">
                                                        <i class="feather icon-x"></i> Limpiar
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="table-responsive">
                                                <table id="contracts-table"
                                                    class="display table nowrap table-striped table-hover dataTable"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Contrato</th>
                                                            <th>Cliente</th>
                                                            <th>Lote</th>
                                                            <th>Proyecto</th>
                                                            <th>Monto Total</th>
                                                            <th>Cuota Inicial</th>
                                                            <th>Financiado</th>
                                                            <th>Cuota Mensual</th>
                                                            <th>Meses</th>
                                                            <th>Estado</th>
                                                            <th>Fecha</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if ($contracts): ?>
                                                        <?php foreach ($contracts as $contract): ?>
                                                        <tr>
                                                            <td>
                                                                <strong><?= $contract['contract_number'] ?></strong><br>
                                                                <small class="text-muted">ID:
                                                                    <?= $contract['id'] ?></small>
                                                            </td>
                                                            <td>
                                                                <strong>Cliente
                                                                    #<?= $contract['customer_id'] ?></strong><br>
                                                                <small class="text-muted">Ver perfil</small>
                                                            </td>
                                                            <td>
                                                                <strong>Lote #<?= $contract['lot_id'] ?></strong><br>
                                                                <small class="text-muted">Ver detalles</small>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-info">Proyecto</span>
                                                            </td>
                                                            <td>
                                                                <h6 class="text-primary">S/
                                                                    <?= number_format($contract['total_amount'], 2) ?>
                                                                </h6>
                                                            </td>
                                                            <td>
                                                                <strong>S/
                                                                    <?= number_format($contract['down_payment'], 2) ?></strong>
                                                            </td>
                                                            <td>
                                                                S/ <?= number_format($contract['financed_amount'], 2) ?>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-warning">S/
                                                                    <?= number_format($contract['monthly_payment'], 2) ?></span>
                                                            </td>
                                                            <td>
                                                                <?= $contract['financing_months'] ?>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                         $status_class = '';
                                                         $status_text = '';
                                                         switch($contract['status']) {
                                                            case 'active':
                                                               $status_class = 'badge-success';
                                                               $status_text = 'Activo';
                                                               break;
                                                            case 'completed':
                                                               $status_class = 'badge-primary';
                                                               $status_text = 'Completado';
                                                               break;
                                                            case 'cancelled':
                                                               $status_class = 'badge-danger';
                                                               $status_text = 'Cancelado';
                                                               break;
                                                            case 'suspended':
                                                               $status_class = 'badge-secondary';
                                                               $status_text = 'Suspendido';
                                                               break;
                                                         }
                                                         ?>
                                                                <span
                                                                    class="badge <?= $status_class ?>"><?= $status_text ?></span>
                                                            </td>
                                                            <td>
                                                                <?= date('d/m/Y', strtotime($contract['contract_date'])) ?><br>
                                                                <small class="text-muted">
                                                                    Inicio:
                                                                    <?= date('d/m/Y', strtotime($contract['start_date'])) ?>
                                                                </small>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <button type="button"
                                                                        class="btn btn-icon btn-info btn-sm dropdown-toggle"
                                                                        data-toggle="dropdown" title="Acciones">
                                                                        <i class="fa fa-cog"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item" href="#"
                                                                            onclick="viewContract('<?= $contract['id'] ?>')">
                                                                            <i class="fa fa-eye"></i> Ver Contrato
                                                                        </a>
                                                                        <a class="dropdown-item"
                                                                            href="<?= base_url('dashboard/inmueble/edit_contract/' . $contract['id']) ?>">
                                                                            <i class="fa fa-edit"></i> Editar
                                                                        </a>
                                                                        <a class="dropdown-item" href="#"
                                                                            onclick="viewPayments('<?= $contract['id'] ?>')">
                                                                            <i class="fa fa-calendar"></i> Cronograma
                                                                        </a>
                                                                        <a class="dropdown-item" href="#"
                                                                            onclick="printContract('<?= $contract['id'] ?>')">
                                                                            <i class="fa fa-print"></i> Imprimir
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <button type="button"
                                                                    class="btn btn-sm ml-1 <?= $contract['status'] == 'suspended' ? 'btn-success' : 'btn-warning' ?>"
                                                                    title="<?= $contract['status'] == 'suspended' ? 'Activar' : 'Suspender' ?>"
                                                                    onclick="toggleContractStatus('<?= $contract['id'] ?>', '<?= $contract['status'] ?>')">
                                                                    <i
                                                                        class="fa <?= $contract['status'] == 'suspended' ? 'fa-play' : 'fa-pause' ?>"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-danger btn-sm ml-1"
                                                                    title="Eliminar"
                                                                    onclick="deleteContract('<?= $contract['id'] ?>')">
                                                                    <i class="fa fa-trash"></i>
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

                            <!-- Summary Cards -->
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-8">
                                                    <h4 class="text-c-green" id="total-active">
                                                        <?= count(array_filter($contracts, function($c) { return $c['status'] == 'active'; })) ?>
                                                    </h4>
                                                    <h6 class="text-muted m-b-0">Contratos Activos</h6>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <i class="feather icon-file-text f-28"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-8">
                                                    <h4 class="text-c-blue">
                                                        S/
                                                        <?= number_format(array_sum(array_column($contracts, 'total_amount')), 0) ?>
                                                    </h4>
                                                    <h6 class="text-muted m-b-0">Valor Total</h6>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <i class="feather icon-dollar-sign f-28"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-8">
                                                    <h4 class="text-c-purple">
                                                        <?= count(array_filter($contracts, function($c) { return $c['status'] == 'completed'; })) ?>
                                                    </h4>
                                                    <h6 class="text-muted m-b-0">Completados</h6>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <i class="feather icon-check f-28"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-8">
                                                    <h4 class="text-c-red">
                                                        S/
                                                        <?= number_format(array_sum(array_column($contracts, 'monthly_payment')), 0) ?>
                                                    </h4>
                                                    <h6 class="text-muted m-b-0">Cuotas Mensuales</h6>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <i class="feather icon-calendar f-28"></i>
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
        </div>
    </section>

    <!-- Modal para Nuevo Contrato -->
    <div class="modal fade" id="newContractModal" tabindex="-1" role="dialog" aria-labelledby="newContractModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form id="new-contract-form" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newContractModalLabel">
                            <i class="feather icon-file-plus"></i> Nuevo Contrato de Venta
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Navegación de Tabs -->
                        <ul class="nav nav-tabs" id="contractTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="customer-tab" data-toggle="tab" href="#customer-section"
                                    role="tab" aria-controls="customer-section" aria-selected="true">
                                    <i class="feather icon-user"></i> 1. Cliente
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" id="lot-tab" data-toggle="tab" href="#lot-section"
                                    role="tab" aria-controls="lot-section" aria-selected="false">
                                    <i class="feather icon-map"></i> 2. Lote
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" id="payment-tab" data-toggle="tab" href="#payment-section"
                                    role="tab" aria-controls="payment-section" aria-selected="false">
                                    <i class="feather icon-credit-card"></i> 3. Plan de Pago
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" id="summary-tab" data-toggle="tab" href="#summary-section"
                                    role="tab" aria-controls="summary-section" aria-selected="false">
                                    <i class="feather icon-check-circle"></i> 4. Resumen
                                </a>
                            </li>
                        </ul>

                        <!-- Contenido de Tabs -->
                        <div class="tab-content" id="contractTabContent">

                            <!-- TAB 1: CLIENTE -->
                            <div class="tab-pane fade show active" id="customer-section" role="tabpanel"
                                aria-labelledby="customer-tab">
                                <div class="py-4">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h5><i class="feather icon-search"></i> Buscar Cliente</h5>
                                            <div class="form-group">
                                                <label for="customer_search">Buscar por DNI, Nombre o Email <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="customer_search"
                                                        placeholder="Ingrese DNI, nombre o email del cliente..."
                                                        onkeyup="searchCustomers()" autocomplete="off">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="searchCustomers()">
                                                            <i class="feather icon-search"></i> Buscar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="customer_results" class="list-group"
                                                style="max-height: 250px; overflow-y: auto; border-radius: 8px;"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card border-primary">
                                                <div class="card-header bg-primary text-white">
                                                    <h6 class="mb-0"><i class="feather icon-user-check"></i> Cliente
                                                        Seleccionado</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div id="selected_customer" style="display: none;">
                                                        <input type="hidden" id="customer_id" name="customer_id">
                                                        <div class="text-center mb-3">
                                                            <div class="avatar-lg mx-auto">
                                                                <i class="feather icon-user f-36 text-primary"></i>
                                                            </div>
                                                        </div>
                                                        <div class="text-center">
                                                            <h5 id="customer_name_display" class="mb-1">-</h5>
                                                            <p class="text-muted mb-1">DNI: <span
                                                                    id="customer_dni_display">-</span></p>
                                                            <p class="text-muted mb-1">Email: <span
                                                                    id="customer_email_display">-</span></p>
                                                            <p class="text-muted mb-0">Teléfono: <span
                                                                    id="customer_phone_display">-</span></p>
                                                        </div>
                                                    </div>
                                                    <div id="no_customer_selected" class="text-center text-muted">
                                                        <i class="feather icon-user-plus f-48 text-muted mb-3"></i>
                                                        <p>Busque y seleccione un cliente</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 2: LOTE -->
                            <div class="tab-pane fade" id="lot-section" role="tabpanel" aria-labelledby="lot-tab">
                                <div class="py-4">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="project_filter"><i class="feather icon-filter"></i> Filtrar
                                                    por Proyecto</label>
                                                <select class="form-control" id="project_filter"
                                                    onchange="filterAvailableLots()">
                                                    <option value="">Todos los proyectos</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5><i class="feather icon-map"></i> Lotes Disponibles</h5>
                                                <span class="badge badge-info" id="lots_count">0 lotes</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="available_lots" class="row"
                                        style="max-height: 400px; overflow-y: auto; padding: 10px;">
                                        <!-- Lotes se cargan dinámicamente -->
                                    </div>

                                    <div id="selected_lot_info" style="display: none;" class="mt-4">
                                        <div class="card border-success">
                                            <div class="card-header bg-success text-white">
                                                <h6 class="mb-0"><i class="feather icon-check-circle"></i> Lote
                                                    Seleccionado</h6>
                                            </div>
                                            <div class="card-body">
                                                <input type="hidden" id="lot_id" name="lot_id">
                                                <div class="row text-center">
                                                    <div class="col-md-3">
                                                        <h6 class="text-muted">Proyecto</h6>
                                                        <h5 id="selected_project_name" class="text-success">-</h5>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6 class="text-muted">Lote</h6>
                                                        <h5 id="selected_lot_number" class="text-success">-</h5>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6 class="text-muted">Área</h6>
                                                        <h5 id="selected_lot_area" class="text-success">- m²</h5>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6 class="text-muted">Precio</h6>
                                                        <h5 id="selected_lot_price" class="text-success">S/ -</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 3: PLAN DE PAGO -->
                            <div class="tab-pane fade" id="payment-section" role="tabpanel"
                                aria-labelledby="payment-tab">
                                <div class="py-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h6><i class="feather icon-settings"></i> Configuración del Plan
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="payment_plan_id">Plan de Pago <span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-control" id="payment_plan_id"
                                                            name="payment_plan_id" onchange="updatePaymentPlan()">
                                                            <option value="">Seleccionar plan</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="down_payment">Cuota Inicial <span
                                                                class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">S/</span>
                                                            </div>
                                                            <input type="number" class="form-control" id="down_payment"
                                                                name="down_payment" step="0.01"
                                                                onchange="calculateContract()">
                                                        </div>
                                                        <small class="form-text text-muted">Mínimo: S/ <span
                                                                id="min_down_payment">-</span></small>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="financing_months">Meses</label>
                                                                <select class="form-control" id="financing_months"
                                                                    name="financing_months"
                                                                    onchange="calculateContract()">
                                                                    <option value="24">24 meses</option>
                                                                    <option value="36" selected>36 meses</option>
                                                                    <option value="48">48 meses</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="interest_rate">Tasa (%)</label>
                                                                <input type="number" class="form-control"
                                                                    id="interest_rate" name="interest_rate" step="0.01"
                                                                    min="2" max="6" value="3.5"
                                                                    onchange="calculateContract()">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="contract_date">Fecha del Contrato</label>
                                                        <input type="date" class="form-control" id="contract_date"
                                                            name="contract_date" value="<?= date('Y-m-d') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header bg-info text-white">
                                                    <h6><i class="feather icon-calculator"></i> Simulador Financiero
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-3 p-3 bg-light rounded">
                                                        <div class="row">
                                                            <div class="col-6"><strong>Precio del Lote:</strong></div>
                                                            <div class="col-6 text-right">S/ <span
                                                                    id="sim_lot_price">0</span></div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6"><strong>Cuota Inicial:</strong></div>
                                                            <div class="col-6 text-right text-warning">S/ <span
                                                                    id="sim_down_payment">0</span></div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6"><strong>A Financiar:</strong></div>
                                                            <div class="col-6 text-right">S/ <span
                                                                    id="sim_financed_amount">0</span></div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-6"><strong>Cuota Mensual:</strong></div>
                                                            <div class="col-6 text-right">
                                                                <h5 class="text-success mb-0">S/ <span
                                                                        id="sim_monthly_payment">0</span></h5>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6"><strong>Total a Pagar:</strong></div>
                                                            <div class="col-6 text-right">
                                                                <h6 class="text-primary mb-0">S/ <span
                                                                        id="sim_total_payment">0</span></h6>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row text-center">
                                                        <div class="col-6">
                                                            <h4 id="sim_total_installments" class="text-info">0</h4>
                                                            <small>Cuotas Totales</small>
                                                        </div>
                                                        <div class="col-6">
                                                            <h4 id="sim_contract_duration" class="text-info">0</h4>
                                                            <small>Años</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 4: RESUMEN -->
                            <div class="tab-pane fade" id="summary-section" role="tabpanel"
                                aria-labelledby="summary-tab">
                                <div class="py-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card border-primary">
                                                <div class="card-header bg-primary text-white">
                                                    <h5 class="mb-0"><i class="feather icon-file-text"></i> Resumen del
                                                        Contrato</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <!-- Cliente -->
                                                        <div class="col-md-4">
                                                            <h6 class="text-muted"><i class="feather icon-user"></i>
                                                                CLIENTE</h6>
                                                            <div class="mb-3">
                                                                <strong id="summary_customer_name">-</strong><br>
                                                                <small>DNI: <span
                                                                        id="summary_customer_dni">-</span></small><br>
                                                                <small>Email: <span
                                                                        id="summary_customer_email">-</span></small>
                                                            </div>
                                                        </div>

                                                        <!-- Lote -->
                                                        <div class="col-md-4">
                                                            <h6 class="text-muted"><i class="feather icon-map"></i> LOTE
                                                            </h6>
                                                            <div class="mb-3">
                                                                <strong id="summary_lot_info">-</strong><br>
                                                                <small>Proyecto: <span
                                                                        id="summary_project_name">-</span></small><br>
                                                                <small>Área: <span id="summary_lot_area_final">-</span>
                                                                    m²</small>
                                                            </div>
                                                        </div>

                                                        <!-- Financiero -->
                                                        <div class="col-md-4">
                                                            <h6 class="text-muted"><i
                                                                    class="feather icon-dollar-sign"></i> FINANCIERO
                                                            </h6>
                                                            <div class="mb-3">
                                                                <strong>S/ <span
                                                                        id="summary_lot_price_final">-</span></strong><br>
                                                                <small>Inicial: S/ <span
                                                                        id="summary_down_payment_final">-</span></small><br>
                                                                <small>Cuota: S/ <span
                                                                        id="summary_monthly_payment_final">-</span></small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6 class="text-muted">CRONOGRAMA DE PAGOS</h6>
                                                            <table class="table table-sm">
                                                                <tr>
                                                                    <td>Duración:</td>
                                                                    <td><strong><span id="summary_duration">-</span>
                                                                            meses</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Fecha Inicio:</td>
                                                                    <td><span id="summary_start_date">-</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Fecha Fin:</td>
                                                                    <td><span id="summary_end_date">-</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Tasa Interés:</td>
                                                                    <td><span id="summary_interest_rate">-</span>% anual
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6 class="text-muted">TOTALES</h6>
                                                            <div class="bg-light p-3 rounded">
                                                                <div class="row">
                                                                    <div class="col-6">Total Contrato:</div>
                                                                    <div class="col-6 text-right"><strong>S/ <span
                                                                                id="summary_total_final">-</span></strong>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-6">Total Intereses:</div>
                                                                    <div class="col-6 text-right">S/ <span
                                                                            id="summary_total_interest">-</span></div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-6">Ahorro vs. Contado:</div>
                                                                    <div class="col-6 text-right text-success">S/ <span
                                                                            id="summary_savings">-</span></div>
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
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="feather icon-x"></i> Cancelar
                        </button>

                        <!-- Botones de Navegación -->
                        <button type="button" class="btn btn-outline-primary" id="prev-btn" onclick="previousTab()"
                            style="display: none;">
                            <i class="feather icon-chevron-left"></i> Anterior
                        </button>
                        <button type="button" class="btn btn-primary" id="next-btn" onclick="nextTab()">
                            Siguiente <i class="feather icon-chevron-right"></i>
                        </button>

                        <!-- Botones de Acción -->
                        <button type="button" class="btn btn-info" id="preview-btn" onclick="previewContract()"
                            style="display: none;">
                            <i class="feather icon-eye"></i> Vista Previa
                        </button>
                        <button type="button" class="btn btn-success" id="create_contract_btn" style="display: none;"
                            disabled>
                            <i class="feather icon-file-plus"></i> Crear Contrato
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    // Clase modular para mostrar la vista previa del contrato
    class ContractPreviewModal {
        // Todas las funciones JS han sido migradas a archivos externos.
        // Solo se mantienen los estilos dinámicos y la variable contractsList para el modal editar.
        const style = document.createElement('style');
        style.textContent = `
          .lot-card {
              cursor: pointer;
              transition: all 0.3s ease;
              border: 2px solid transparent;
          }
          .lot-card:hover {
              transform: translateY(-2px);
              box-shadow: 0 4px 8px rgba(0,0,0,0.1);
          }
          .border-success {
              border: 2px solid #28a745 !important;
          }
          .nav-tabs .nav-link.disabled {
              color: #6c757d;
              pointer-events: none;
          }
          /* Scroll en el menú de acciones */
          .dropdown-menu {
              max-height: 350px;
              overflow-y: auto;
          }
     `;
        document.head.appendChild(style);
        window.contractsList = <?php echo json_encode($contracts ?? [], JSON_UNESCAPED_UNICODE); ?>;
    </script>

    <?php echo view("admin/footer"); ?>
</body>

</html>