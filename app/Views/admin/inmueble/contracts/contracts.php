<!doctype html>
<html lang="es-PE">


<?php echo view("admin/head"); ?>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- JS modularizados para gestión de contratos, inmuebles y usuarios -->
<script src="/assets/js/contrato/contracts-add.js"></script>
<script src="/assets/js/contrato/contracts-edit.js"></script>
<script src="/assets/js/contrato/contracts-suspend.js"></script>
<script src="/assets/js/contrato/contracts-delete.js"></script>
<script src="/assets/js/properties.js"></script>
<script src="/assets/js/users.js"></script>

<body data-new-gr-c-s-check-loaded="14.1042.0" data-gr-ext-installed="">
    <div id="cronogramaModalContainer"></div>
    <?php echo view("admin/header"); ?>
    <section class="pcoded-main-container">
        <!-- Modal Vista Previa Contrato -->
        <div class="modal fade" id="contractPreviewModal" tabindex="-1" role="dialog"
            aria-labelledby="contractPreviewModalLabel" aria-hidden="true" style="z-index: 1080;">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content bg-white text-dark shadow rounded">
                    <div class="modal-header border-0" style="background: #f8f9fa; border-radius: 0.5rem 0.5rem 0 0;">
                        <div class="mx-auto w-100 text-center">
                            <i class="feather icon-file-text f-48 text-primary mb-2"></i>
                            <h4 class="modal-title font-weight-bold" id="contractPreviewModalLabel">Vista Previa del
                                Contrato</h4>
                        </div>
                    </div>
                    <div class="modal-body p-4" id="contractPreviewContent" style="font-size: 1.08rem;">
                        <!-- El contenido se inserta dinámicamente -->
                    </div>
                    <div class="modal-footer border-0 justify-content-center"
                        style="background: #f8f9fa; border-radius: 0 0 0.5rem 0.5rem;">
                        <button type="button" class="btn btn-outline-primary px-4" data-dismiss="modal">Cerrar</button>
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
                                                <button id="btnEnviarRecordatorios" class="btn btn-warning btn-sm"
                                                    type="button" style="margin-left:10px;">
                                                    <i class="fa fa-envelope"></i> Enviar recordatorios de vencimiento
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
                                                    <script>
                                                    function updateContractSummary() {
                                                        // Cliente
                                                        document.getElementById('summary_customer_name').textContent =
                                                            selectedCustomer?.name || '-';
                                                        document.getElementById('summary_customer_dni').textContent =
                                                            selectedCustomer?.dni || '-';
                                                        document.getElementById('summary_customer_email').textContent =
                                                            selectedCustomer?.email || '-';

                                                        // Lote
                                                        document.getElementById('summary_project_name').textContent =
                                                            selectedLot?.project_name || '-';
                                                        document.getElementById('summary_lot_area_final').textContent =
                                                            selectedLot?.area_sqm || '-';
                                                        document.getElementById('summary_lot_price_final').textContent =
                                                            selectedLot?.current_price || '-';

                                                        // Financiero
                                                        document.getElementById('summary_down_payment_final')
                                                            .textContent = selectedPlan?.initialPayment || '-';
                                                        document.getElementById('summary_monthly_payment_final')
                                                            .textContent = selectedPlan?.monthlyPayment || '-';

                                                        // Cronograma
                                                        document.getElementById('summary_duration').textContent =
                                                            selectedPlan?.months || '-';
                                                        document.getElementById('summary_start_date').textContent =
                                                            selectedPlan?.startDate || '-';
                                                        document.getElementById('summary_end_date').textContent =
                                                            selectedPlan?.endDate || '-';
                                                        document.getElementById('summary_interest_rate').textContent =
                                                            selectedPlan?.rate || '-';

                                                        // Totales
                                                        document.getElementById('summary_total_final').textContent =
                                                            selectedPlan?.total || '-';
                                                        document.getElementById('summary_total_interest').textContent =
                                                            selectedPlan?.totalInterest || '-';
                                                        document.getElementById('summary_savings').textContent =
                                                            selectedPlan?.savings || '-';
                                                    }
                                                    document.getElementById('btnEnviarRecordatorios').addEventListener(
                                                        'click',
                                                        function() {
                                                            Swal.fire({
                                                                title: '¿Desea enviar recordatorios de vencimiento?',
                                                                text: 'Se enviará un email a todos los clientes con cuotas próximas a vencer.',
                                                                icon: 'warning',
                                                                showCancelButton: true,
                                                                confirmButtonText: 'Sí, enviar',
                                                                cancelButtonText: 'Cancelar'
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    fetch('/dashboard/inmueble/enviar_recordatorios_vencimiento', {
                                                                            method: 'POST',
                                                                            headers: {
                                                                                'Content-Type': 'application/json',
                                                                                'X-Requested-With': 'XMLHttpRequest'
                                                                            }
                                                                        })
                                                                        .then(response => response.json())
                                                                        .then(data => {
                                                                            if (Array.isArray(data
                                                                                    .resultados)) {
                                                                                let html =
                                                                                    '<ul style="text-align:left;">';
                                                                                data.resultados.forEach(
                                                                                    r => {
                                                                                        html +=
                                                                                            `<li>${r}</li>`;
                                                                                    });
                                                                                html += '</ul>';
                                                                                Swal.fire({
                                                                                    icon: 'success',
                                                                                    title: '¡Recordatorios enviados!',
                                                                                    html: html,
                                                                                    confirmButtonText: 'Aceptar'
                                                                                });
                                                                            } else {
                                                                                Swal.fire({
                                                                                    icon: 'success',
                                                                                    title: '¡Recordatorio enviado!',
                                                                                    text: data
                                                                                        .message ||
                                                                                        'Operación completada',
                                                                                    confirmButtonText: 'Aceptar'
                                                                                });
                                                                            }
                                                                        })
                                                                        .catch(() => {
                                                                            Swal.fire({
                                                                                icon: 'error',
                                                                                title: 'Error',
                                                                                text: 'Error al enviar los recordatorios',
                                                                                confirmButtonText: 'Aceptar'
                                                                            });
                                                                        });
                                                                }
                                                            });
                                                        });
                                                    </script>
                                                </div>

                                                <div class="table-responsive">
                                                    <table id="contracts-table"
                                                        class="display table nowrap table-striped table-hover dataTable"
                                                        style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">Contrato</th>
                                                                <th class="text-center">Cliente</th>
                                                                <th class="text-center">Lote</th>
                                                                <th class="text-center">Proyecto</th>
                                                                <th class="text-center">Tipo de Contrato</th>
                                                                <th class="text-center">Monto Total</th>
                                                                <th class="text-center">Cuota Inicial</th>
                                                                <th class="text-center">Financiado</th>
                                                                <th class="text-center">Cuota Mensual</th>
                                                                <th class="text-center">Meses</th>
                                                                <th class="text-center">Estado</th>
                                                                <th class="text-center">Fecha</th>
                                                                <th class="text-center">Reserva</th>
                                                                <th class="text-center">Comisión</th>
                                                                <th class="text-center">Validación</th>
                                                                <th class="text-center">Acción</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            if ($contracts) {
                                                                if (!empty($contracts)) {
                                                                    // Ordenar por id descendente (últimos primero)
                                                                    usort($contracts, function($a, $b) {
                                                                        return intval($b['id']) - intval($a['id']);
                                                                    });
                                                                    foreach ($contracts as $contract) {
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <strong><?= $contract['contract_number'] ?></strong><br>
                                                                    <small class="text-muted">ID:
                                                                        <?= $contract['id'] ?></small>
                                                                </td>
                                                                <td>
                                                                    <strong><?= esc($contract['customer_name']) ?></strong><br>
                                                                    <small class="text-muted">
                                                                        <a href="#"
                                                                            onclick="showCustomerProfile('<?= $contract['id'] ?>'); return false;">Ver
                                                                            perfil</a>
                                                                    </small>
                                                                </td>
                                                                <td>
                                                                    <strong>Lote
                                                                        #<?= $contract['lot_id'] ?></strong><br>
                                                                    <small class="text-muted">
                                                                        <a href="#"
                                                                            onclick="showLotDetails('<?= $contract['id'] ?>'); return false;">Ver
                                                                            detalles</a>
                                                                    </small>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="badge badge-info"><?= esc($contract['project_name'] ?? 'Proyecto') ?></span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="badge badge-secondary"><?= esc($contract['contract_type'] ?? 'N/A') ?></span>
                                                                </td>
                                                                <td>
                                                                    <?php if (isset($contract['contract_type']) && $contract['contract_type'] === 'futura'): ?>
                                                                    <span class="text-muted">—</span>
                                                                    <?php else: ?>
                                                                    <strong>S/
                                                                        <?= number_format($contract['total_amount'], 2) ?></strong>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if (isset($contract['contract_type']) && $contract['contract_type'] === 'futura'): ?>
                                                                    <span class="text-muted">—</span>
                                                                    <?php else: ?>
                                                                    <strong>S/
                                                                        <?= number_format($contract['down_payment'], 2) ?></strong>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if (isset($contract['contract_type']) && $contract['contract_type'] === 'futura'): ?>
                                                                    <span class="text-muted">—</span>
                                                                    <?php else: ?>
                                                                    S/
                                                                    <?= number_format($contract['financed_amount'], 2) ?>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if (isset($contract['contract_type']) && $contract['contract_type'] === 'futura'): ?>
                                                                    <span class="badge badge-warning">—</span>
                                                                    <?php else: ?>
                                                                    <span class="badge badge-warning">S/
                                                                        <?= number_format($contract['monthly_payment'], 2) ?></span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?= $contract['financing_months'] ?>
                                                                </td>
                                                                <td>
                                                                    <?php 
        $status_class = '';
        $status_text = '';
        if ($contract['status'] === 'rejected') {
            $status_class = 'badge-dark';
            $status_text = 'Rechazado';
        } elseif ($contract['status'] === 'suspended') {
            $status_class = 'badge-secondary';
            $status_text = 'Suspendido';
        } elseif (!empty($contract['is_reserved']) && $contract['is_reserved'] == 1) {
            $status_class = 'badge-warning';
            $status_text = 'Reservado';
        } else {
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
                // ...otros estados...
            }
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
                                                                    <?php if (!empty($contract['is_reserved']) && $contract['is_reserved'] == 1): ?>
                                                                    <span class="badge badge-info">S/
                                                                        <?= number_format($contract['reservation_amount'], 2) ?></span><br>
                                                                    <small><?= date('d/m/Y', strtotime($contract['reservation_date'])) ?></small>
                                                                    <?php else: ?>
                                                                    <span class="text-muted">---</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php
                                                                    // Mostrar estado de la comisión
                                                                    if (!empty($contract['comision_estado'])) {
                                                                        if ($contract['comision_estado'] === 'aprobada') {
                                                                            echo '<span class="badge badge-success">EN ALTA</span>';
                                                                        } elseif ($contract['comision_estado'] === 'rechazada') {
                                                                            echo '<span class="badge badge-danger">RECHAZADA</span>';
                                                                        } else {
                                                                            echo '<span class="badge badge-warning">' . strtoupper($contract['comision_estado']) . '</span>';
                                                                        }
                                                                    } else {
                                                                        echo '<span class="badge badge-secondary">SIN COMISIÓN</span>';
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php
                                                                    // Mostrar estado de validación basado en la comisión
                                                                    if (!empty($contract['comision_estado'])) {
                                                                        if ($contract['comision_estado'] === 'aprobada') {
                                                                            echo '<i class="fa fa-check-circle text-success"></i> <small>Aprobado</small>';
                                                                        } elseif ($contract['comision_estado'] === 'rechazada') {
                                                                            echo '<i class="fa fa-times-circle text-danger"></i> <small>Rechazado</small>';
                                                                        } else {
                                                                            echo '<i class="fa fa-clock-o text-warning"></i> <small>Pendiente</small>';
                                                                        }
                                                                    } else {
                                                                        echo '<i class="fa fa-clock-o text-muted"></i> <small>Sin comisión</small>';
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <div class="btn-group">
                                                                        <button type="button"
                                                                            class="btn btn-icon btn-info btn-sm dropdown-toggle"
                                                                            data-toggle="dropdown" title="Acciones">
                                                                            <i class="fa fa-cog"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu">
                                                                            <a class="dropdown-item"
                                                                                href="/dashboard/inmueble/contracts/view/<?= $contract['id'] ?>">
                                                                                <i class="fa fa-list"></i> Detalle y
                                                                                Pagos
                                                                            </a>
                                                                            <a class="dropdown-item" href="#"
                                                                                onclick="viewContract('<?= $contract['id'] ?>')">
                                                                                <i class="fa fa-eye"></i> Ver Contrato
                                                                            </a>
                                                                            <a class="dropdown-item"
                                                                                href="<?= base_url('dashboard/inmueble/edit_contract/' . $contract['id']) ?>">
                                                                                <i class="fa fa-edit"></i> Editar
                                                                            </a>
                                                                            <a class="dropdown-item"
                                                                                href="/dashboard/inmueble/cronograma/<?= $contract['id'] ?>">
                                                                                <i class="fa fa-calendar"></i>
                                                                                Cronograma
                                                                            </a>
                                                                            <a class="dropdown-item" href="#"
                                                                                onclick="printContract('<?= $contract['id'] ?>')">
                                                                                <i class="fa fa-print"></i> Imprimir
                                                                            </a>
                                                                            <a class="dropdown-item" href="#"
                                                                                onclick="generarFacturaContrato(<?= $contract['id'] ?>)">
                                                                                <i class="fa fa-file-invoice"></i>
                                                                                Generar Factura
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
                                                                    <!-- Botón PDF aparte -->
                                                                    <button type="button"
                                                                        class="btn btn-outline-danger btn-sm ml-1"
                                                                        title="Descargar PDF"
                                                                        onclick="window.open('<?= site_url('admin/contrato_pdf/' . $contract['id']) ?>', '_blank')">
                                                                        <i class="fa fa-file-pdf"></i>
                                                                    </button>
                                                                    <!-- Botón Word -->
                                                                    <a href="<?= site_url('admin/contrato_word/' . $contract['id']) ?>"
                                                                        class="btn btn-outline-primary btn-sm ml-1"
                                                                        title="Descargar Word" target="_blank">
                                                                        <i class="fa fa-file-word"></i>
                                                                    </a>
                                                                    <button type="button"
                                                                        class="btn btn-success btn-sm ml-1"
                                                                        title="Generar Factura"
                                                                        onclick="generarFacturaContrato(<?= $contract['id'] ?>)">
                                                                        <i class="fa fa-file-invoice"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm ml-1 <?php 
                                                                        if (!empty($contract['is_approved']) && $contract['is_approved'] == 1) {
                                                                            echo 'btn-success';
                                                                        } elseif (!empty($contract['is_rejected']) && $contract['is_rejected'] == 1) {
                                                                            echo 'btn-danger';
                                                                        } else {
                                                                            echo 'btn-primary';
                                                                        }
                                                                        ?>" title="<?php 
                                                                        if (!empty($contract['is_approved']) && $contract['is_approved'] == 1) {
                                                                            echo 'Comisión Generada';
                                                                        } elseif (!empty($contract['is_rejected']) && $contract['is_rejected'] == 1) {
                                                                            echo 'Comisión Rechazada';
                                                                        } else {
                                                                            echo 'Validar Contrato';
                                                                        }
                                                                        ?>" <?php 
                                                                        if (!empty($contract['is_approved']) || !empty($contract['is_rejected'])) {
                                                                            echo 'disabled';
                                                                        } else {
                                                                            echo 'onclick="showValidateModal(' . htmlspecialchars(json_encode($contract), ENT_QUOTES, "UTF-8") . ')"';
                                                                        }
                                                                        ?>>
                                                                        <i class="fa <?php 
                                                                        if (!empty($contract['is_approved']) && $contract['is_approved'] == 1) {
                                                                            echo 'fa-check';
                                                                        } elseif (!empty($contract['is_rejected']) && $contract['is_rejected'] == 1) {
                                                                            echo 'fa-times';
                                                                        } else {
                                                                            echo 'fa-check-circle';
                                                                        }
                                                                        ?>"></i> <?php 
                                                                        if (!empty($contract['is_approved']) && $contract['is_approved'] == 1) {
                                                                            echo 'Comisión: EN ALTA';
                                                                        } elseif (!empty($contract['is_rejected']) && $contract['is_rejected'] == 1) {
                                                                            echo 'Comisión: RECHAZADA';
                                                                        } else {
                                                                            echo 'Validar';
                                                                        }
                                                                        ?>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-sm ml-1"
                                                                        onclick="deleteContract('<?= $contract['id'] ?>')">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <?php 
                                                                    } // end foreach
                                                                } // end !empty
                                                            } // end contracts
                                                            ?>
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
                        <!-- Tipo de Contrato -->
                        <div class="form-group row">
                            <label for="contract_type" class="col-sm-3 col-form-label"><strong>Tipo de Contrato <span
                                        class="text-danger">*</span></strong></label>
                            <div class="col-sm-9">
                                <select class="form-control" id="contract_type" name="contract_type" required>
                                    <option value="arras">Promesa de Compraventa con Arras (Pagos en cuotas)</option>
                                    <option value="futura">Compra Venta Futura (Pago 100%)</option>
                                </select>
                                <small class="form-text text-muted">Seleccione el tipo de contrato según la situación
                                    del cliente.</small>
                                <!-- Mensaje visual para contrato futura -->
                                <div id="futura-info" class="alert alert-info mt-2" style="display:none;">
                                    <strong>Compra Venta Futura:</strong> Este contrato es solo para clientes que ya han
                                    pagado el 100% del valor del inmueble. No requiere cuotas iniciales ni
                                    financiamiento.
                                </div>
                                <script>
                                document.getElementById('contract_type').addEventListener('change', function() {
                                    var isFutura = this.value === 'futura';
                                    // Mostrar/ocultar mensaje
                                    document.getElementById('futura-info').style.display = isFutura ? '' :
                                        'none';
                                    // Ocultar/mostrar campos de financiamiento
                                    var financeFields = document.getElementById('financing-fields');
                                    if (financeFields) financeFields.style.display = isFutura ? 'none' : '';
                                });
                                // Ejecutar al cargar por si el valor viene preseleccionado
                                window.addEventListener('DOMContentLoaded', function() {
                                    var e = document.getElementById('contract_type');
                                    if (e) e.dispatchEvent(new Event('change'));
                                });
                                </script>
                            </div>
                        </div>
                        <?php
                        $session = session();
                        $isSponsor = isset($_SESSION['tipo_agente']) && $_SESSION['tipo_agente'] === 'sponsor';
                        $userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;
                        ?>
                        <?php if ($isSponsor && $userId): ?>
                        <input type="hidden" name="sponsor_id" value="<?= $userId ?>">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><strong>Patrocinador</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control"
                                    value="<?= $_SESSION['name'] . ' ' . $_SESSION['lastname'] ?>" readonly>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="form-group row">
                            <label for="sponsor_id" class="col-sm-3 col-form-label"><strong>Patrocinador <span
                                        class="text-danger">*</span></strong></label>
                            <div class="col-sm-9">
                                <select name="sponsor_id" id="sponsor_id" class="form-control" required>
                                    <option value="">Seleccionar patrocinador</option>
                                    <?php foreach ($agents as $sponsor): ?>
                                    <option value="<?= $sponsor['id'] ?>">[<?= $sponsor['code'] ?>]
                                        <?= $sponsor['name'] ?> <?= $sponsor['lastname'] ?> (DNI:
                                        <?= $sponsor['dni'] ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <?php endif; ?>
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
                                                <div class="card-body" id="financing-fields">
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
                                                                onchange="calculateContract()" readonly>
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

                                                    <hr>
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" id="is_reserved"
                                                            name="is_reserved" onchange="toggleReservationFields()">
                                                        <label class="form-check-label" for="is_reserved">¿Este contrato
                                                            inicia con reserva?</label>
                                                    </div>
                                                    <div id="reservation_fields" style="display:none;">
                                                        <div class="form-group">
                                                            <label for="reservation_amount">Monto de Reserva</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">S/</span>
                                                                </div>
                                                                <input type="number" class="form-control"
                                                                    id="reservation_amount" name="reservation_amount"
                                                                    step="0.01">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="reservation_date">Fecha de Reserva</label>
                                                            <input type="date" class="form-control"
                                                                id="reservation_date" name="reservation_date"
                                                                value="<?= date('Y-m-d') ?>">
                                                        </div>
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
                                                        <div class="col-md-6" id="cronograma-summary-block">
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
                                                    <script>
                                                    function toggleCronogramaSummary() {
                                                        var contractType = document.getElementById('contract_type')
                                                            .value;
                                                        var cronogramaBlock = document.getElementById(
                                                            'cronograma-summary-block');
                                                        if (cronogramaBlock) {
                                                            cronogramaBlock.style.display = (contractType ===
                                                                'futura') ? 'none' : '';
                                                        }
                                                    }
                                                    document.getElementById('contract_type').addEventListener('change',
                                                        toggleCronogramaSummary);
                                                    window.addEventListener('DOMContentLoaded',
                                                        toggleCronogramaSummary);
                                                    </script>
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

    <div class="modal fade" id="modalGenerarFactura" tabindex="-1" role="dialog"
        aria-labelledby="modalGenerarFacturaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalGenerarFacturaLabel">Generar Factura</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalGenerarFacturaBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Validar Contrato -->
    <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">Validar Contrato</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="approveModalBody"></div>
            </div>
        </div>
    </div>

    <script>
    function displayAvailableLots(lots) {
        const container = document.getElementById('available_lots');
        container.innerHTML = '';
        if (!lots || lots.length === 0) {
            container.innerHTML = '<div class="col-12 text-center text-muted py-4">No hay lotes disponibles</div>';
            return;
        }
        lots.forEach(lot => {
            const lotCard = document.createElement('div');
            lotCard.className = 'col-md-4 mb-3';
            lotCard.innerHTML = `
                <div class="card lot-card h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted">${lot.project_name || 'Proyecto'}</h6>
                        <h4 class="text-primary">Lote ${lot.lot_number}</h4>
                        <p class="mb-1">Manzana: ${lot.block || 'N/A'}</p>
                        <p class="mb-2">${lot.area_sqm} m²</p>
                        <h5 class="text-success mb-0">S/ ${parseFloat(lot.current_price || 0).toLocaleString('es-PE')}</h5>
                    </div>
                </div>
            `;
            lotCard.querySelector('.card.lot-card').addEventListener('click', function(e) {
                selectLot(lot);
                document.querySelectorAll('.lot-card').forEach(card => {
                    card.classList.remove('border-success');
                    card.style.backgroundColor = '';
                });
                e.currentTarget.classList.add('border-success');
                e.currentTarget.style.backgroundColor = '#f8f9fa';
            });
            container.appendChild(lotCard);
        });
    }

    function selectLot(lot) {
        selectedLot = lot;
        document.getElementById('lot_id').value = lot.id;
        document.getElementById('selected_project_name').textContent = lot.project_name || 'N/A';
        document.getElementById('selected_lot_number').textContent = lot.lot_number || 'N/A';
        document.getElementById('selected_lot_area').textContent = lot.area_sqm || '0';
        document.getElementById('selected_lot_price').textContent = parseFloat(lot.current_price || 0).toLocaleString(
            'es-PE');
        document.getElementById('selected_lot_info').style.display = 'block';
        // Set minimum down payment
        const lotPrice = parseFloat(lot.current_price || 0);
        const minDownPayment = Math.max(lotPrice * 0.15, 5000);
        document.getElementById('min_down_payment').textContent = minDownPayment.toLocaleString('es-PE');
        document.getElementById('down_payment').setAttribute('min', minDownPayment);
        document.getElementById('down_payment').value = minDownPayment;
        calculateContract();
        updateNavigationButtons();
    }

    function updateNavigationButtons() {
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const previewBtn = document.getElementById('preview-btn');
        const createBtn = document.getElementById('create_contract_btn');

        prevBtn.style.display = currentTab > 0 ? 'inline-block' : 'none';
        previewBtn.style.display = currentTab === tabs.length - 1 ? 'inline-block' : 'none';

        if (currentTab === tabs.length - 1) {
            // Tab 4: ocultar next-btn, mostrar create_contract_btn
            nextBtn.style.display = 'none';
            createBtn.style.display = 'inline-block';
            createBtn.innerHTML = '<i class="feather icon-file-plus"></i> Crear Contrato';
            const contractType = document.getElementById('contract_type').value;
            if (contractType === 'futura') {
                // Solo requiere cliente y lote
                createBtn.disabled = !(selectedCustomer && selectedLot);
            } else {
                // Requiere plan de pago y cuota inicial
                createBtn.disabled = !(selectedCustomer && selectedLot &&
                    document.getElementById('payment_plan_id').value &&
                    parseFloat(document.getElementById('down_payment').value) > 0);
            }
        } else {
            // Otros tabs: mostrar next-btn, ocultar create_contract_btn
            nextBtn.style.display = 'inline-block';
            nextBtn.textContent = 'Siguiente';
            nextBtn.innerHTML = 'Siguiente <i class="feather icon-chevron-right"></i>';
            nextBtn.onclick = function() {
                nextTab();
            };
            nextBtn.disabled = false;
            createBtn.style.display = 'none';
        }
    }
    // Eliminar cualquier otra definición de viewPayments en el archivo
    // Definir solo una vez al final
    window.viewPayments = function(contractId) {
        fetch('/dashboard/inmueble/contracts/get_schedule/' + contractId)
            .then(response => response.text())
            .then(html => {
                document.getElementById('cronogramaModalContainer').innerHTML = html;
                $('#cronogramaModal').modal('show');
                $('#cronogramaModal').on('hidden.bs.modal', function() {
                    document.getElementById('cronogramaModalContainer').innerHTML = '';
                });
            });
    }
    // Clase modular para mostrar la vista previa del contrato
    class ContractPreviewModal {
        constructor(contractData) {
            this.contractData = contractData;
        }
        show() {
            const html = `
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="card border-0 bg-light mb-3 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2"><i class="feather icon-user"></i> Cliente</h6>
                                    <div class="mb-1 font-weight-bold">${this.contractData.customer.name} ${this.contractData.customer.lastname || ''}</div>
                                    <div>DNI: <span class="text-dark">${this.contractData.customer.dni || 'N/A'}</span></div>
                                    <div>Email: <span class="text-dark">${this.contractData.customer.email || 'N/A'}</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 bg-light mb-3 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2"><i class="feather icon-map"></i> Lote</h6>
                                    <div class="mb-1 font-weight-bold">Lote ${this.contractData.lot.lot_number}</div>
                                    <div>Proyecto: <span class="text-dark">${this.contractData.lot.project_name || 'N/A'}</span></div>
                                    <div>Área: <span class="text-dark">${this.contractData.lot.area_sqm} m²</span></div>
                                    <div>Precio: <span class="text-dark">S/ ${parseFloat(this.contractData.lot.current_price || 0).toLocaleString('es-PE')}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="card border-0 bg-light shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2"><i class="feather icon-credit-card"></i> Financiero</h6>
                                    <div>Cuota Inicial: <span class="text-dark">S/ ${this.contractData.downPayment}</span></div>
                                    <div>Cuota Mensual: <span class="text-dark">S/ ${this.contractData.monthlyPayment}</span></div>
                                    <div>Total: <span class="text-dark">S/ ${this.contractData.totalAmount}</span></div>
                                    <div>Duración: <span class="text-dark">${this.contractData.duration} meses</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('contractPreviewContent').innerHTML = html;
            // Cierra el modal principal si está abierto y muestra el de vista previa
            $('#newContractModal').modal('hide');
            setTimeout(() => {
                $('#contractPreviewModal').modal('show');
            }, 300);
        }
    }

    // Función global para abrir el modal de edición de contrato
    // editContract ahora está in contracts-edit.js
    // Asegura que el botón 'Crear Contrato' dispare el submit del formulario
    document.getElementById('create_contract_btn').addEventListener('click', function() {
        // Solo dispara el submit si el botón no está deshabilitado
        if (!this.disabled) {
            document.getElementById('new-contract-form').requestSubmit();
        }
    });
    let selectedCustomer = null;
    let selectedLot = null;
    let paymentPlans = [];
    let availableLots = [];
    // Cargar lotes disponibles desde el backend
    function loadAvailableLots() {
        fetch('/dashboard/inmueble/api/get_available_lots')
            .then(response => response.json())
            .then(data => {
                availableLots = data.lots || [];
                filterAvailableLots();
            })
            .catch(error => {
                console.error('Error cargando lotes disponibles:', error);
                availableLots = [];
                filterAvailableLots();
            });
    }
    let projects = [];
    let currentTab = 0;
    const tabs = ['customer-section', 'lot-section', 'payment-section', 'summary-section'];

    function openNewContractModal() {
        resetModalForm();
        loadAvailableLots();
        loadPaymentPlans();
        loadProjects();
        currentTab = 0;
        showTab(currentTab);
        $('#newContractModal').modal('show');
    }

    function resetModalForm() {
        selectedCustomer = null;
        selectedLot = null;
        document.getElementById('customer_search').value = '';
        document.getElementById('customer_results').innerHTML = '';
        document.getElementById('selected_customer').style.display = 'none';
        document.getElementById('no_customer_selected').style.display = 'block';
        document.getElementById('selected_lot_info').style.display = 'none';
        document.getElementById('available_lots').innerHTML = '';
        document.getElementById('create_contract_btn').disabled = true;
    }

    function loadProjects() {
        fetch('/dashboard/inmueble/api/projects')
            .then(response => response.json())
            .then(data => {
                projects = data.projects || [];
                const select = document.getElementById('project_filter');
                select.innerHTML = '<option value="">Todos los proyectos</option>';

                projects.forEach(project => {
                    const option = document.createElement('option');
                    option.value = project.id;
                    option.textContent = `${project.name} (${project.location})`;
                    select.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading projects:', error);
            });
    }

    // La función loadAvailableLots ahora está in contracts-add.js

    function loadPaymentPlans() {
        fetch('/dashboard/inmueble/api/payment_plans')
            .then(response => response.json())
            .then(data => {
                paymentPlans = data.plans || [];
                const select = document.getElementById('payment_plan_id');
                select.innerHTML = '<option value="">Seleccionar plan</option>';

                paymentPlans.forEach(plan => {
                    const option = document.createElement('option');
                    option.value = plan.id;
                    option.textContent =
                        `${plan.name} (${plan.duration_months} meses - ${plan.base_interest_rate}%)`;
                    option.dataset.rate = plan.base_interest_rate;
                    option.dataset.duration = plan.duration_months;
                    option.dataset.minPercent = plan.min_down_payment_percentage;
                    select.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading payment plans:', error);
            });
    }

    function searchCustomers() {
        const searchTerm = document.getElementById('customer_search').value;
        if (searchTerm.length < 3) {
            document.getElementById('customer_results').innerHTML = '';
            return;
        }

        fetch('/dashboard/inmueble/api/search_customers', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    search: searchTerm
                })
            })
            .then(response => response.json())
            .then(data => {
                displayCustomerResults(data.customers || []);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al buscar clientes');
            });
    }

    function displayCustomerResults(customers) {
        const resultsContainer = document.getElementById('customer_results');
        resultsContainer.innerHTML = '';

        if (customers.length === 0) {
            resultsContainer.innerHTML = '<div class="list-group-item text-muted">No se encontraron clientes</div>';
            return;
        }

        customers.forEach(customer => {
            const customerItem = document.createElement('a');
            customerItem.href = '#';
            customerItem.className = 'list-group-item list-group-item-action';
            customerItem.onclick = (e) => {
                e.preventDefault();
                selectCustomer(customer);
            };
            customerItem.innerHTML = `
                  <div class="d-flex w-100 justify-content-between">
                     <h6 class="mb-1">${customer.name} ${customer.lastname || ''}</h6>
                     <small>ID: ${customer.id}</small>
                  </div>
                  <p class="mb-1">DNI: ${customer.dni || 'N/A'} | Email: ${customer.email || 'N/A'}</p>
                  <small>Teléfono: ${customer.phone || 'N/A'}</small>
               `;
            resultsContainer.appendChild(customerItem);
        });
    }

    function selectCustomer(customer) {
        selectedCustomer = customer;
        document.getElementById('customer_id').value = customer.id;
        document.getElementById('customer_name_display').textContent = `${customer.name} ${customer.lastname || ''}`;
        document.getElementById('customer_dni_display').textContent = customer.dni || 'N/A';
        document.getElementById('customer_email_display').textContent = customer.email || 'N/A';
        document.getElementById('customer_phone_display').textContent = customer.phone || 'N/A';

        document.getElementById('selected_customer').style.display = 'block';
        document.getElementById('no_customer_selected').style.display = 'none';
        document.getElementById('customer_results').innerHTML = '';

        updateNavigationButtons();
    }

    // Si el tab actual es el de resumen, actualiza el resumen
    const resumenTab = document.getElementById('tab-resumen');
    if (resumenTab && resumenTab.classList.contains('active')) {
        updateContractSummary();
    }

    function filterAvailableLots() {
        const projectId = document.getElementById('project_filter').value;

        if (projectId) {
            const filteredLots = availableLots.filter(lot => lot.project_id == projectId);
            displayAvailableLots(filteredLots);
            updateLotsCount(filteredLots.length);
        } else {
            displayAvailableLots(availableLots);
            updateLotsCount(availableLots.length);
        }
    }

    function updatePaymentPlan() {
        const select = document.getElementById('payment_plan_id');
        const selectedOption = select.options[select.selectedIndex];

        if (selectedOption.value) {
            // document.getElementById('interest_rate').value = selectedOption.dataset.rate; // Desactivado para que no cambie la tasa
            document.getElementById('financing_months').value = selectedOption.dataset.duration;
            calculateContract();
        }
    }

    function calculateContract() {
        if (!selectedLot) return;

        const contractType = document.getElementById('contract_type').value;
        const lotPrice = parseFloat(selectedLot.current_price || 0);

        if (contractType === 'futura') {
            // Compra Venta Futura: todo pagado, sin financiamiento
            document.getElementById('sim_lot_price').textContent = lotPrice.toLocaleString('es-PE');
            document.getElementById('sim_down_payment').textContent = lotPrice.toLocaleString('es-PE');
            document.getElementById('sim_financed_amount').textContent = '0';
            document.getElementById('sim_monthly_payment').textContent = '0.00';
            document.getElementById('sim_total_payment').textContent = lotPrice.toLocaleString('es-PE');
            document.getElementById('sim_total_installments').textContent = '0';
            document.getElementById('sim_contract_duration').textContent = '0';

            // Actualizar resumen
            document.getElementById('summary_down_payment_final').textContent = lotPrice.toLocaleString('es-PE');
            document.getElementById('summary_monthly_payment_final').textContent = '0.00';
            document.getElementById('summary_duration').textContent = '0';
            document.getElementById('summary_interest_rate').textContent = '0';
            document.getElementById('summary_total_final').textContent = lotPrice.toLocaleString('es-PE');
            document.getElementById('summary_total_interest').textContent = '0';
            document.getElementById('summary_savings').textContent = '0';
            document.getElementById('summary_start_date').textContent = '-';
            document.getElementById('summary_end_date').textContent = '-';

            updateNavigationButtons();
            return;
        }

        const downPayment = parseFloat(document.getElementById('down_payment').value) || 0;
        const months = parseInt(document.getElementById('financing_months').value) || 36;
        const annualRate = parseFloat(document.getElementById('interest_rate').value) || 3.5;

        const financedAmount = lotPrice - downPayment;
        const monthlyRate = annualRate / 100 / 12;

        let monthlyPayment = 0;
        if (financedAmount > 0 && monthlyRate > 0) {
            monthlyPayment = financedAmount * (monthlyRate * Math.pow(1 + monthlyRate, months)) / (Math.pow(1 +
                monthlyRate, months) - 1);
        }

        const totalPayment = downPayment + (monthlyPayment * months);

        // Actualizar simulador
        document.getElementById('sim_lot_price').textContent = lotPrice.toLocaleString('es-PE');
        document.getElementById('sim_down_payment').textContent = downPayment.toLocaleString('es-PE');
        document.getElementById('sim_financed_amount').textContent = financedAmount.toLocaleString('es-PE');
        document.getElementById('sim_monthly_payment').textContent = monthlyPayment.toLocaleString('es-PE', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        document.getElementById('sim_total_payment').textContent = totalPayment.toLocaleString('es-PE');
        document.getElementById('sim_total_installments').textContent = months;
        document.getElementById('sim_contract_duration').textContent = (months / 12).toFixed(1);

        // Actualizar resumen normal (si tienes lógica para esto, aquí puedes llamarla)
        updateNavigationButtons();
    }

    function showTab(tabIndex) {
        currentTab = tabIndex; // sincroniza el tab actual
        $('.tab-pane').removeClass('show active');
        $('.nav-link').removeClass('active').addClass('disabled');

        $(`#${tabs[tabIndex]}`).addClass('show active');
        $(`[href="#${tabs[tabIndex]}"]`).removeClass('disabled').addClass('active');

        for (let i = 0; i <= tabIndex; i++) {
            $(`[href="#${tabs[i]}"]`).removeClass('disabled');
        }

        updateNavigationButtons();

        // ACTUALIZA EL RESUMEN AL ENTRAR AL TAB 4
        if (tabs[tabIndex] === 'summary-section' && typeof updateSummary === 'function') {
            console.log('Actualizando resumen del contrato...');
            updateSummary();
        }
    }

    function viewPayments(contractId) {
        // Guardar el ID para usarlo en recargas
        currentContractIdInModal = contractId;

        fetch('/dashboard/inmueble/contracts/get_schedule/' + contractId)
            .then(response => response.text())
            .then(html => {
                document.getElementById('cronogramaModalContainer').innerHTML = html;
                $('#cronogramaModal').modal('show');

                // Attach event listener al botón de recarga
                setTimeout(() => {
                    const reloadBtn = document.getElementById('btn-reload-cronograma');
                    if (reloadBtn) {
                        reloadBtn.addEventListener('click', reloadCronograma);
                    }
                }, 100);

                $('#cronogramaModal').on('hidden.bs.modal', function() {
                    document.getElementById('cronogramaModalContainer').innerHTML = '';
                    currentContractIdInModal = null;
                });
            });
    }


    function updateSummary() {
        if (selectedCustomer) {
            document.getElementById('summary_customer_name').textContent =
                `${selectedCustomer.name} ${selectedCustomer.lastname || ''}`;
            document.getElementById('summary_customer_dni').textContent = selectedCustomer.dni || 'N/A';
            document.getElementById('summary_customer_email').textContent = selectedCustomer.email || 'N/A';
        }

        if (selectedLot) {
            document.getElementById('summary_lot_info').textContent = `Lote ${selectedLot.lot_number}`;
            document.getElementById('summary_project_name').textContent = selectedLot.project_name || 'N/A';
            document.getElementById('summary_lot_area_final').textContent = selectedLot.area_sqm || '0';
            document.getElementById('summary_lot_price_final').textContent = parseFloat(selectedLot.current_price || 0)
                .toLocaleString('es-PE');
        }

        const downPayment = parseFloat(document.getElementById('down_payment').value) || 0;
        const monthlyPayment = document.getElementById('sim_monthly_payment').textContent;
        const totalPayment = document.getElementById('sim_total_payment').textContent;
        const months = document.getElementById('financing_months').value;
        const interestRate = document.getElementById('interest_rate').value;

        document.getElementById('summary_down_payment_final').textContent = downPayment.toLocaleString('es-PE');
        document.getElementById('summary_monthly_payment_final').textContent = monthlyPayment;
        document.getElementById('summary_total_final').textContent = totalPayment;
        document.getElementById('summary_duration').textContent = months;
        document.getElementById('summary_interest_rate').textContent = interestRate;

        const contractDate = new Date(document.getElementById('contract_date').value);
        const endDate = new Date(contractDate);
        endDate.setMonth(endDate.getMonth() + parseInt(months));

        document.getElementById('summary_start_date').textContent = contractDate.toLocaleDateString('es-PE');
        document.getElementById('summary_end_date').textContent = endDate.toLocaleDateString('es-PE');

        const lotPrice = parseFloat(selectedLot?.current_price || 0);
        const totalInterest = (parseFloat(totalPayment.replace(/,/g, '')) || 0) - lotPrice;
        document.getElementById('summary_total_interest').textContent = totalInterest.toLocaleString('es-PE');
        document.getElementById('summary_savings').textContent = '0';
    }

    function updateLotsCount(count) {
        document.getElementById('lots_count').textContent = `${count} lote${count !== 1 ? 's' : ''}`;
    }

    function previewContract() {
        if (!selectedCustomer || !selectedLot) {
            Swal.fire({
                icon: 'warning',
                title: 'Faltan datos',
                text: 'Complete la información del cliente y lote',
                confirmButtonText: 'OK'
            });
            return;
        }

        const contractData = {
            customer: selectedCustomer,
            lot: selectedLot,
            downPayment: document.getElementById('down_payment').value,
            monthlyPayment: document.getElementById('sim_monthly_payment').textContent,
            totalAmount: document.getElementById('sim_lot_price').textContent,
            duration: document.getElementById('financing_months').value
        };

        const previewModal = new ContractPreviewModal(contractData);
        previewModal.show();
    }

    // Form submission
    document.getElementById('new-contract-form').addEventListener('submit', function(e) {
        e.preventDefault();

        if (!selectedCustomer || !selectedLot) {
            Swal.fire({
                icon: 'warning',
                title: 'Faltan datos',
                text: 'Complete toda la información requerida',
                confirmButtonText: 'OK'
            });
            return;
        }

        const formData = new FormData();
        formData.append('customer_id', selectedCustomer.id);
        formData.append('lot_id', selectedLot.id);
        formData.append('payment_plan_id', document.getElementById('payment_plan_id').value);
        formData.append('down_payment', document.getElementById('down_payment').value);
        formData.append('financing_months', document.getElementById('financing_months').value);
        formData.append('interest_rate', document.getElementById('interest_rate').value);
        formData.append('contract_date', document.getElementById('contract_date').value);
        // Enviar el tipo de contrato seleccionado
        const contractTypeValue = document.getElementById('contract_type').value;
        console.log('Tipo de contrato seleccionado:', contractTypeValue);
        formData.append('contract_type', contractTypeValue);

        // Añadir ubicación si está disponible en selectedLot o en el proyecto asociado
        if (selectedLot) {
            if (selectedLot.department_id) formData.append('department_id', selectedLot.department_id);
            if (selectedLot.province_id) formData.append('province_id', selectedLot.province_id);
            if (selectedLot.district_id) formData.append('district_id', selectedLot.district_id);
            // si no están en selectedLot, intentar obtener desde projects[]
            if ((!selectedLot.department_id || !selectedLot.province_id || !selectedLot.district_id) &&
                typeof projects !== 'undefined') {
                const proj = projects.find(p => p.id == selectedLot.project_id);
                if (proj) {
                    if (proj.department_id && !selectedLot.department_id) formData.append('department_id', proj
                        .department_id);
                    if (proj.province_id && !selectedLot.province_id) formData.append('province_id', proj
                        .province_id);
                    if (proj.district_id && !selectedLot.district_id) formData.append('district_id', proj
                        .district_id);
                }
            }
        }

        // Agregar datos de reserva si corresponde
        if (document.getElementById('is_reserved').checked) {
            formData.append('is_reserved', 1);
            formData.append('reservation_amount', document.getElementById('reservation_amount').value);
            formData.append('reservation_date', document.getElementById('reservation_date').value);
        } else {
            formData.append('is_reserved', 0);
            formData.append('reservation_amount', '');
            formData.append('reservation_date', '');
        }

        // Agregar sponsor_id seleccionado
        const sponsorIdElement = document.getElementById('sponsor_id');
        if (sponsorIdElement && sponsorIdElement.value) {
            formData.append('sponsor_id', sponsorIdElement.value);
        }

        const submitBtn = document.getElementById('create_contract_btn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="feather icon-loader"></i> Creando...';

        fetch('/dashboard/inmueble/create_contract', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    $('#newContractModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: '¡Contrato creado!',
                        text: 'Contrato creado exitosamente: ' + data.contract_number,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al crear el contrato: ' + (data.message ||
                            'Error desconocido'),
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al procesar la solicitud',
                    confirmButtonText: 'OK'
                });
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="feather icon-file-plus"></i> Crear Contrato';
            });
    });

    // Funciones adicionales para filtros y acciones
    function filterContracts() {
        const status = document.getElementById('status-filter').value;
        const dateFrom = document.getElementById('date-from').value;
        const dateTo = document.getElementById('date-to').value;

        console.log('Filtering contracts:', {
            status,
            dateFrom,
            dateTo
        });
    }

    function clearFilters() {
        document.getElementById('status-filter').value = '';
        document.getElementById('date-from').value = '';
        document.getElementById('date-to').value = '';
    }

    function viewContract(contractId) {
        window.location.href = '/dashboard/inmueble/contracts/view/' + contractId;
    }


    function printContract(contractId) {
        window.open('/dashboard/inmueble/contracts/print/' + contractId, '_blank');
    }

    function editContract(contractId) {
        // Buscar el contrato en la lista
        const contract = (window.contractsList || []).find(c => c.id == contractId);
        if (!contract) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se encontró el contrato.'
            });
            return;
        }
        // Generar HTML del modal
        let html = `<div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Número de Contrato</label>
                            <input type="text" class="form-control" value="${contract.contract_number}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Cliente</label>
                            <input type="text" class="form-control" value="${contract.customer_id}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Lote</label>
                            <input type="text" class="form-control" value="${contract.lot_id}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Meses de Financiamiento</label>
                            <input type="text" class="form-control" value="${contract.financing_months}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Estado</label>
                            <input type="text" class="form-control" value="${contract.status}" readonly>
                        </div>
                    </div>
                </div>
            </div>`;
        document.getElementById('editContractContent').innerHTML = html;
        $('#editContractModal').modal('show');
    }


    function toggleContractStatus(contractId, currentStatus) {
        if (currentStatus === 'suspended') {
            Swal.fire({
                title: '¿Está seguro de activar este contrato?',
                text: 'El contrato volverá a estar activo.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, activar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateContractStatus(contractId, 'active');
                }
            });
        } else {
            Swal.fire({
                title: '¿Está seguro de suspender este contrato?',
                text: 'El contrato pasará a estado suspendido.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, suspender',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateContractStatus(contractId, 'suspended');
                }
            });
        }
    }

    function cancelContract(contractId) {
        if (confirm('¿Está seguro de cancelar este contrato? Esta acción no se puede deshacer.')) {
            updateContractStatus(contractId, 'cancelled');
        }
    }

    function updateContractStatus(contractId, status) {
        fetch('/dashboard/inmueble/api/update_contract_status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    contract_id: contractId,
                    status: status
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Respuesta update_contract_status:', data);
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Estado actualizado',
                        text: 'El contrato fue suspendido correctamente',
                        timer: 1800,
                        showConfirmButton: false
                    });
                    setTimeout(() => location.reload(), 1800);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Error al actualizar el estado',
                        footer: data.debug ? JSON.stringify(data.debug) : ''
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de red',
                    text: 'Error al procesar la solicitud'
                });
            });
    }


    // Eliminar contrato
    function deleteContract(contractId) {
        Swal.fire({
            title: '¿Está seguro de eliminar este contrato?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('/dashboard/inmueble/api/delete_contract', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            contract_id: contractId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Eliminado', 'El contrato ha sido eliminado.', 'success');
                            setTimeout(() => location.reload(), 1200);
                        } else {
                            Swal.fire('Error', data.message || 'No se pudo eliminar el contrato.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'No se pudo procesar la solicitud.', 'error');
                    });
            }
        });
    }
    // Estilos dinámicos
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
    // Guardar contratos en JS para el modal editar
    window.contractsList = <?php echo json_encode($contracts ?? [], JSON_UNESCAPED_UNICODE); ?>;

    function generarFacturaContrato(id) {
        $.ajax({
            url: '/dashboard/facturas/generarFactura',
            type: 'POST',
            data: {
                contract_id: id
            },
            dataType: 'json',
            success: function(resp) {
                var html = '';
                if (resp.success) {
                    html =
                        '<div class="alert alert-success text-center">Factura generada correctamente.</div>';
                } else if (resp.error) {
                    html = '<div class="alert alert-danger text-center">' + resp.error + '</div>';
                } else {
                    html =
                        '<div class="alert alert-warning text-center">No se pudo generar la factura.</div>';
                }
                $('#modalGenerarFacturaBody').html(html);
                $('#modalGenerarFactura').modal('show');
            },
            error: function() {
                $('#modalGenerarFacturaBody').html(
                    '<div class="alert alert-danger text-center">Error de conexión o respuesta inesperada.</div>'
                );
                $('#modalGenerarFactura').modal('show');
            }
        });
    }

    function showValidateModal(contract) {
        let voucherHtml = '';
        if (contract.voucher_url && contract.voucher_url.trim() !== '') {
            let filename = contract.voucher_url.split('/').pop();
            let url = '/dashboard/mostrarComprobante/' + filename;
            voucherHtml =
                `<a href="${url}" target="_blank">Ver voucher</a><br>
            <img src="${url}" alt="Voucher" style="max-width:300px;max-height:300px;" onerror="this.onerror=null;this.src='/assets/img/no-image.png';this.alt='No encontrado';">`;
        } else {
            voucherHtml = `<span class="text-danger">No subido</span>`;
        }
        var body = document.getElementById('approveModalBody');
        body.innerHTML = `
        <p><strong>Contrato N°:</strong> ${contract.contract_number}</p>
        <p><strong>Cliente:</strong> ${contract.customer_name || ''}</p>
        <p><strong>Lote:</strong> #${contract.lot_id}</p>
        <p><strong>Proyecto:</strong> ${contract.project_name || ''}</p>
        <p><strong>Fecha:</strong> ${contract.contract_date}</p>
        <p><strong>Monto:</strong> S/ ${contract.total_amount}</p>
        <p><strong>Voucher:</strong> ${voucherHtml}</p>
        <div class='mt-3 text-center'>
            <form id="approveForm" method="post" action="/dashboard/inmueble/approve_contract" style="display:inline;">
                <input type="hidden" name="contract_id" value="${contract.id}">
                <button type="submit" class="btn btn-success mr-2">Aprobar</button>
            </form>
            <form id="rejectForm" method="post" action="/dashboard/inmueble/reject_contract" style="display:inline;">
                <input type="hidden" name="contract_id" value="${contract.id}">
                <button type="submit" class="btn btn-danger">Desaprobar</button>
            </form>
        </div>
    `;
        $('#approveModal').modal('show');
    }
    </script>

    <?php echo view("admin/footer"); ?>
    <div class="modal fade" id="miniInfoModal" tabindex="-1" role="dialog" aria-labelledby="miniInfoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="miniInfoModalLabel">Información</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="miniInfoModalBody"></div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('submit', function(e) {
            if (e.target && e.target.id === 'approveForm') {
                e.preventDefault();
                const form = e.target;
                const contractId = form.querySelector('input[name="contract_id"]').value;
                const btn = form.querySelector('button[type="submit"]');
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Procesando...';
                fetch('/dashboard/inmueble/approve_contract', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'contract_id=' + encodeURIComponent(contractId)
                    })
                    .then(res => res.json())
                    .then(data => {
                        $('#approveModal').modal('hide');
                        if (data.success) {
                            let htmlMsg = '';
                            if (data.message && (data.message.includes('bonus') || data.message
                                    .includes('Bonus') || data.message.includes('sumados'))) {
                                htmlMsg = '<b>Comisión generada:</b><br>' +
                                    '<span style="color:#2196f3;font-weight:bold;">5% del monto + S/ 300 (bonus reserva)</span><br>' +
                                    '<b style="font-size:1.2em;">Total: ' + (data.total_comision ?
                                        'S/ ' + data.total_comision : 'ver detalle') + '</b>' +
                                    '<br><br><i class="fa fa-check-circle text-success" style="font-size:2em;"></i>';
                            } else {
                                htmlMsg =
                                    '<b>La comisión se generó correctamente.</b><br><br><i class="fa fa-check-circle text-success" style="font-size:2em;"></i>';
                            }
                            Swal.fire({
                                icon: 'success',
                                title: '¡Contrato aprobado!',
                                html: htmlMsg,
                                showConfirmButton: true,
                                confirmButtonText: 'Aceptar',
                                customClass: {
                                    popup: 'swal2-modal-centered'
                                }
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error al aprobar',
                                text: data.message || 'No se pudo aprobar el contrato.',
                                showConfirmButton: true,
                                confirmButtonText: 'Cerrar',
                                customClass: {
                                    popup: 'swal2-modal-centered'
                                }
                            });
                        }
                    })
                    .catch(err => {
                        $('#approveModal').modal('hide');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de conexión',
                            text: err.toString(),
                            showConfirmButton: true,
                            confirmButtonText: 'Cerrar',
                            customClass: {
                                popup: 'swal2-modal-centered'
                            }
                        });
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.innerHTML = 'Aprobar';
                    });
            } else if (e.target && e.target.id === 'rejectForm') {
                e.preventDefault();
                const form = e.target;
                const contractId = form.querySelector('input[name="contract_id"]').value;
                const btn = form.querySelector('button[type="submit"]');
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Procesando...';
                fetch('/dashboard/inmueble/reject_contract', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'contract_id=' + encodeURIComponent(contractId)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Contrato rechazado!',
                                text: data.message || 'Contrato rechazado correctamente.',
                                didOpen: () => {
                                    $('.modal').modal('hide');
                                }
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message || 'No se pudo rechazar el contrato.',
                                'error');
                        }
                        btn.disabled = false;
                        btn.innerHTML = 'Desaprobar';
                    })
                    .catch(() => {
                        Swal.fire('Error', 'No se pudo procesar la solicitud.', 'error');
                        btn.disabled = false;
                        btn.innerHTML = 'Desaprobar';
                    });
            }
        });
    });
    </script>
    <script>
    function showLotDetails(contractId) {
        const contract = (window.contractsList || []).find(c => c.id == contractId);
        if (!contract) return;

        // Mapeo de estado en español
        const estados = {
            'available': 'Disponible',
            'reserved': 'Reservado',
            'sold': 'Vendido',
            'blocked': 'Bloqueado'
        };
        const estadoEsp = estados[contract.lot_status] || contract.lot_status || 'N/A';

        const html = `
        <strong>Lote #${contract.lot_number || contract.lot_id}</strong><br>
        <small>Manzana: ${contract.lot_block || 'N/A'}</small><br>
        <small>Área: ${contract.lot_area || 'N/A'} m²</small><br>
        <small>Precio: S/ ${contract.lot_price ? Number(contract.lot_price).toLocaleString('es-PE', {minimumFractionDigits:2}) : 'N/A'}</small><br>
        <small>Estado: ${estadoEsp}</small>
    `;
        document.getElementById('miniInfoModalLabel').textContent = 'Detalles del Lote';
        document.getElementById('miniInfoModalBody').innerHTML = html;
        $('#miniInfoModal').modal('show');
    }
    </script>
    <!-- Modal pequeño reutilizable para perfil y detalles -->
    <div class="modal fade" id="miniInfoModal" tabindex="-1" role="dialog" aria-labelledby="miniInfoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="miniInfoModalLabel">Información</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="miniInfoModalBody"></div>
            </div>
        </div>
    </div>

    <script>
    function showCustomerProfile(contractId) {
        const contract = (window.contractsList || []).find(c => c.id == contractId);
        if (!contract) return;
        const html = `
        <strong>${contract.customer_name}${contract.customer_lastname ? ' ' + contract.customer_lastname : ''}</strong><br>
        <small>DNI: ${contract.customer_dni || 'N/A'}</small><br>
        <small>Email: ${contract.customer_email || 'N/A'}</small><br>
        <small>Teléfono: ${contract.customer_phone || 'N/A'}</small><br>
        <small>Dirección: ${contract.customer_address || 'N/A'}</small><br>
        <small>Fecha registro: ${contract.customer_created_at || 'N/A'}</small><br>
        <small>KYC: ${contract.customer_kyc || 'N/A'}</small><br>
        ${contract.customer_ruc ? `<small>RUC: ${contract.customer_ruc}</small><br>` : ''}
        ${contract.customer_company_name ? `<small>Empresa: ${contract.customer_company_name}</small><br>` : ''}
        `;
        document.getElementById('miniInfoModalLabel').textContent = 'Perfil del Cliente';
        document.getElementById('miniInfoModalBody').innerHTML = html;
        $('#miniInfoModal').modal('show');
    }
    </script>
    <script>
    $(document).ready(function() {
        // Al cerrar cualquier modal, limpia el backdrop y la clase modal-open si no hay más modals abiertos
        $(document).on('hidden.bs.modal', '.modal', function() {
            if ($('.modal.show').length === 0) {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            }
        });
    });
    </script>
    <script>
    // Forzar cierre del modal al hacer click en Cancelar
    $(document).ready(function() {
        $(document).on('click', '#newContractModal .btn-cancelar, #newContractModal .btn-cancel', function(e) {
            $('#newContractModal').modal('hide');
        });
        $(document).on('hidden.bs.modal', '.modal', function() {
            setTimeout(function() {
                if ($('.modal.show').length === 0) {
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                }
            }, 200);
        });
    });
    </script>
</body>

</html>