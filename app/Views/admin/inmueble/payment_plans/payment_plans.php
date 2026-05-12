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
                                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard/inmueble') ?>">Gestión
                                                Inmobiliaria</a></li>
                                        <li class="breadcrumb-item"><a>Planes de Pago</a></li>
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
                                            <h5>Gestión de Planes de Pago</h5>
                                            <div class="card-header-right">
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#createPaymentPlanModal">
                                                    <i class="feather icon-plus"></i> Nuevo Plan
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive" style="overflow-x: auto; position: relative;">
                                                <table id="payment-plans-table"
                                                    class="display table nowrap table-striped table-hover dataTable"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Plan</th>
                                                            <th>Duración</th>
                                                            <th>Tasa Interés</th>
                                                            <th>Por Defecto</th>
                                                            <th>Estado</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if ($payment_plans): ?>
                                                        <?php foreach ($payment_plans as $plan): ?>
                                                        <tr>
                                                            <td>
                                                                <strong><?= $plan['name'] ?></strong><br>
                                                                <small class="text-muted">Código:
                                                                    <?= $plan['code'] ?></small>
                                                            </td>
                                                            <td>
                                                                <strong><?= $plan['duration_months'] ?>
                                                                    meses</strong><br>
                                                                <small
                                                                    class="text-muted"><?= number_format($plan['duration_months']/12, 1) ?>
                                                                    años</small>
                                                            </td>
                                                            <td>
                                                                <strong><?= $plan['base_interest_rate'] ?>%</strong><br>
                                                                <small class="text-muted">anual</small>
                                                            </td>
                                                            <td>
                                                                <?php if ($plan['is_default']): ?>
                                                                <span class="badge badge-success">Sí</span>
                                                                <?php else: ?>
                                                                <span class="badge badge-secondary">No</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($plan['active']): ?>
                                                                <span class="badge badge-success">Activo</span>
                                                                <?php else: ?>
                                                                <span class="badge badge-danger">Inactivo</span>
                                                                <?php endif; ?>
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
                                                                            onclick="editPaymentPlan('<?= $plan['id'] ?>')">
                                                                            <i class="fa fa-edit"></i> Editar
                                                                        </a>
                                                                        <a class="dropdown-item" href="#"
                                                                            onclick="viewPaymentPlan('<?= $plan['id'] ?>')">
                                                                            <i class="fa fa-eye"></i> Ver Detalles
                                                                        </a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <?php if ($plan['active']): ?>
                                                                        <a class="dropdown-item text-warning" href="#"
                                                                            onclick="deactivatePlan('<?= $plan['id'] ?>')">
                                                                            <i class="fa fa-pause"></i> Desactivar
                                                                        </a>
                                                                        <?php else: ?>
                                                                        <a class="dropdown-item text-success" href="#"
                                                                            onclick="activatePlan('<?= $plan['id'] ?>')">
                                                                            <i class="fa fa-play"></i> Activar
                                                                        </a>
                                                                        <?php endif; ?>
                                                                        <a class="dropdown-item text-danger" href="#"
                                                                            onclick="deletePlan('<?= $plan['id'] ?>')">
                                                                            <i class="fa fa-trash"></i> Eliminar
                                                                        </a>
                                                                    </div>
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

    <style>
        /* Estilos para que el dropdown funcione correctamente en la tabla */
        .btn-group {
            position: relative !important;
        }
        
        .btn-group .dropdown-menu {
            position: absolute !important;
            z-index: 1000 !important;
        }
        
        .table-responsive {
            overflow: visible !important;
        }
        
        table td {
            overflow: visible !important;
        }
    </style>

    <!-- Modal para Editar Plan de Pago -->
    <div class="modal fade" id="editPaymentPlanModal" tabindex="-1" role="dialog"
        aria-labelledby="editPaymentPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="edit-payment-plan-form" method="POST">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title" id="editPaymentPlanModalLabel">
                            <i class="feather icon-edit"></i> Editar Plan de Pago
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_plan_id" name="plan_id">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_name">Nombre del Plan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_code">Código <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_code" name="code" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_duration_months">Duración (Meses) <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="edit_duration_months" name="duration_months"
                                        required>
                                        <option value="">Seleccionar duración</option>
                                        <option value="12">12 meses</option>
                                        <option value="24">24 meses</option>
                                        <option value="36">36 meses</option>
                                        <option value="48">48 meses</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_base_interest_rate">Tasa de Interés Base (%) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="edit_base_interest_rate"
                                        name="base_interest_rate" step="0.01" min="0" max="6" required>
                                    <small class="form-text text-muted">Entre 0% y 6% anual</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="edit_is_default"
                                            name="is_default" value="1">
                                        <label class="form-check-label" for="edit_is_default">
                                            Plan por Defecto
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="edit_active" name="active"
                                            value="1">
                                        <label class="form-check-label" for="edit_active">
                                            Plan Activo
                                        </label>
                                        <small class="form-text text-muted">Los planes inactivos no aparecerán en
                                            contratos</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="feather icon-x"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-warning" id="update_plan_btn">
                            <i class="feather icon-save"></i> Actualizar Plan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Ver Detalles del Plan de Pago -->
    <div class="modal fade" id="viewPaymentPlanModal" tabindex="-1" role="dialog"
        aria-labelledby="viewPaymentPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="viewPaymentPlanModalLabel">
                        <i class="feather icon-eye"></i> Detalles del Plan de Pago
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Información Básica -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card border-info">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="feather icon-info"></i> Información General</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless table-sm">
                                                <tr>
                                                    <td><strong>Nombre del Plan:</strong></td>
                                                    <td id="view_plan_name">-</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Código:</strong></td>
                                                    <td><span id="view_plan_code" class="badge badge-secondary">-</span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Estado:</strong></td>
                                                    <td><span id="view_plan_status" class="badge">-</span></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless table-sm">
                                                <tr>
                                                    <td><strong>Duración:</strong></td>
                                                    <td id="view_plan_duration">-</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Plan por Defecto:</strong></td>
                                                    <td><span id="view_plan_default" class="badge">-</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Fecha Creación:</strong></td>
                                                    <td id="view_plan_created">-</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Última Actualización:</strong></td>
                                                    <td id="view_plan_updated">-</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detalles Financieros -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card border-success">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="feather icon-dollar-sign"></i> Condiciones Financieras
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-4">
                                            <div class="border-right">
                                                <h3 id="view_down_payment_display" class="text-warning">-</h3>
                                                <p class="text-muted mb-0">Cuota Inicial Mínima</p>
                                                <small class="text-muted">Porcentaje requerido</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="border-right">
                                                <h3 id="view_interest_rate_display" class="text-success">-</h3>
                                                <p class="text-muted mb-0">Tasa de Interés</p>
                                                <small class="text-muted">Anual</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <h3 id="view_duration_display" class="text-primary">-</h3>
                                            <p class="text-muted mb-0">Duración Total</p>
                                            <small class="text-muted">Plazo de financiamiento</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Simulación de Ejemplo -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card border-warning">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="feather icon-calculator"></i> Simulación de Ejemplo</h6>
                                    <small class="text-muted">Basado en un lote de S/ 100,000</small>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="bg-light p-3 rounded">
                                                <h6 class="text-muted">Cuotas y Pagos:</h6>
                                                <table class="table table-sm table-borderless">
                                                    <tr>
                                                        <td>Precio del Lote:</td>
                                                        <td class="text-right"><strong>S/ 100,000.00</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Cuota Inicial Mínima:</td>
                                                        <td class="text-right"><strong id="example_down_payment"
                                                                class="text-warning">-</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Monto a Financiar:</td>
                                                        <td class="text-right"><strong
                                                                id="example_financed_amount">-</strong></td>
                                                    </tr>
                                                    <tr class="border-top">
                                                        <td><strong>Cuota Mensual:</strong></td>
                                                        <td class="text-right">
                                                            <h6 id="example_monthly_payment" class="text-success mb-0">-
                                                            </h6>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="bg-light p-3 rounded">
                                                <h6 class="text-muted">Resumen Total:</h6>
                                                <table class="table table-sm table-borderless">
                                                    <tr>
                                                        <td>Total de Cuotas:</td>
                                                        <td class="text-right"><strong
                                                                id="example_total_installments">-</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Duración:</td>
                                                        <td class="text-right"><strong
                                                                id="example_duration_years">-</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total a Pagar:</td>
                                                        <td class="text-right"><strong
                                                                id="example_total_payment">-</strong></td>
                                                    </tr>
                                                    <tr class="border-top">
                                                        <td><strong>Intereses Totales:</strong></td>
                                                        <td class="text-right">
                                                            <h6 id="example_total_interest" class="text-info mb-0">-
                                                            </h6>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contratos Activos (si los hay) -->
                    <div class="row" id="active_contracts_section" style="display: none;">
                        <div class="col-md-12">
                            <div class="card border-primary">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="feather icon-file-text"></i> Contratos Activos con este
                                        Plan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-4">
                                            <h4 id="contracts_count" class="text-primary">0</h4>
                                            <p class="text-muted mb-0">Contratos Activos</p>
                                        </div>
                                        <div class="col-md-4">
                                            <h4 id="contracts_total_amount" class="text-success">S/ 0</h4>
                                            <p class="text-muted mb-0">Valor Total</p>
                                        </div>
                                        <div class="col-md-4">
                                            <h4 id="contracts_monthly_revenue" class="text-info">S/ 0</h4>
                                            <p class="text-muted mb-0">Ingresos Mensuales</p>
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
                    <button type="button" class="btn btn-warning" onclick="editFromView()">
                        <i class="feather icon-edit"></i> Editar Plan
                    </button>
                    <button type="button" class="btn btn-info" onclick="printPlanDetails()">
                        <i class="feather icon-printer"></i> Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    function editPaymentPlan(planId) {
        // Hacer petición para obtener los datos del plan
        fetch(`/dashboard/inmueble/api/get_payment_plan/${planId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const plan = data.plan;

                    // Llenar el formulario con los datos
                    document.getElementById('edit_plan_id').value = plan.id;
                    document.getElementById('edit_name').value = plan.name;
                    document.getElementById('edit_code').value = plan.code;
                    document.getElementById('edit_duration_months').value = plan.duration_months;
                    document.getElementById('edit_base_interest_rate').value = plan.base_interest_rate;
                    document.getElementById('edit_is_default').checked = plan.is_default == 1;
                    document.getElementById('edit_active').checked = plan.active == 1;

                    // Mostrar modal
                    $('#editPaymentPlanModal').modal('show');
                } else {
                    alert('Error al cargar los datos del plan: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar los datos del plan');
            });
    }

    function activatePlan(planId) {
        if (confirm('¿Está seguro de activar este plan de pago?')) {
            updatePlanStatus(planId, 1);
        }
    }

    function deactivatePlan(planId) {
        if (confirm('¿Está seguro de desactivar este plan de pago?')) {
            updatePlanStatus(planId, 0);
        }
    }

    function updatePlanStatus(planId, status) {
        fetch(`/dashboard/inmueble/api/update_plan_status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    plan_id: planId,
                    status: status
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Estado actualizado correctamente',
                        timer: 1800,
                        showConfirmButton: false
                    });
                    setTimeout(() => location.reload(), 1800);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al actualizar el estado',
                        timer: 2200,
                        showConfirmButton: false
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al procesar la solicitud',
                    timer: 2200,
                    showConfirmButton: false
                });
            });
    }

    function deletePlan(planId) {
        Swal.fire({
            title: '¿Está seguro de eliminar este plan de pago?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/dashboard/inmueble/api/delete_payment_plan/${planId}`, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Eliminado!',
                                text: 'Plan eliminado correctamente',
                                timer: 1800,
                                showConfirmButton: false
                            });
                            setTimeout(() => location.reload(), 1800);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error al eliminar el plan: ' + (data.message ||
                                    'Error desconocido'),
                                timer: 2200,
                                showConfirmButton: false
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al procesar la solicitud',
                            timer: 2200,
                            showConfirmButton: false
                        });
                    });
            }
        });
    }

    function viewPaymentPlan(planId) {
        // Hacer petición para obtener los datos del plan
        fetch(`/dashboard/inmueble/api/get_payment_plan/${planId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const plan = data.plan;
                    displayPlanDetails(plan);
                    $('#viewPaymentPlanModal').modal('show');
                } else {
                    alert('Error al cargar los datos del plan: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar los datos del plan');
            });
    }

    function displayPlanDetails(plan) {
        // Información básica
        document.getElementById('view_plan_name').textContent = plan.name || '-';
        document.getElementById('view_plan_code').textContent = plan.code || '-';


        // Estado
        const statusBadge = document.getElementById('view_plan_status');
        if (plan.active == 1) {
            statusBadge.textContent = 'Activo';
            statusBadge.className = 'badge badge-success';
        } else {
            statusBadge.textContent = 'Inactivo';
            statusBadge.className = 'badge badge-danger';
        }

        // Plan por defecto
        const defaultBadge = document.getElementById('view_plan_default');
        if (plan.is_default == 1) {
            defaultBadge.textContent = 'Sí';
            defaultBadge.className = 'badge badge-success';
        } else {
            defaultBadge.textContent = 'No';
            defaultBadge.className = 'badge badge-secondary';
        }

        // Duración
        const months = parseInt(plan.duration_months);
        const years = (months / 12).toFixed(1);
        document.getElementById('view_plan_duration').textContent = `${months} meses (${years} años)`;

        // Fechas (si están disponibles)
        document.getElementById('view_plan_created').textContent = plan.created_at ?
            new Date(plan.created_at).toLocaleDateString('es-PE') : '-';
        document.getElementById('view_plan_updated').textContent = plan.updated_at ?
            new Date(plan.updated_at).toLocaleDateString('es-PE') : '-';

        // Condiciones financieras
        document.getElementById('view_down_payment_display').textContent = plan.min_down_payment_percentage + '%';
        document.getElementById('view_interest_rate_display').textContent = plan.base_interest_rate + '%';
        document.getElementById('view_duration_display').textContent = months + ' meses';

        // Simulación de ejemplo (lote de S/ 100,000)
        calculateExampleSimulation(plan);
    }

    function calculateExampleSimulation(plan) {
        const lotPrice = 100000; // Ejemplo de S/ 100,000
        const downPaymentPercent = parseFloat(plan.min_down_payment_percentage);
        const interestRate = parseFloat(plan.base_interest_rate);
        const months = parseInt(plan.duration_months);

        const downPayment = lotPrice * (downPaymentPercent / 100);
        const financedAmount = lotPrice - downPayment;
        const monthlyRate = interestRate / 100 / 12;

        let monthlyPayment = 0;
        if (financedAmount > 0 && monthlyRate > 0) {
            monthlyPayment = financedAmount * (monthlyRate * Math.pow(1 + monthlyRate, months)) /
                (Math.pow(1 + monthlyRate, months) - 1);
        }

        const totalPayment = downPayment + (monthlyPayment * months);
        const totalInterest = totalPayment - lotPrice;

        // Actualizar displays
        document.getElementById('example_down_payment').textContent = 'S/ ' + downPayment.toLocaleString('es-PE');
        document.getElementById('example_financed_amount').textContent = 'S/ ' + financedAmount.toLocaleString('es-PE');
        document.getElementById('example_monthly_payment').textContent = 'S/ ' + monthlyPayment.toLocaleString(
            'es-PE', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        document.getElementById('example_total_installments').textContent = months + ' cuotas';
        document.getElementById('example_duration_years').textContent = (months / 12).toFixed(1) + ' años';
        document.getElementById('example_total_payment').textContent = 'S/ ' + totalPayment.toLocaleString('es-PE');
        document.getElementById('example_total_interest').textContent = 'S/ ' + totalInterest.toLocaleString('es-PE');
    }

    function activatePlan(planId) {
        if (confirm('¿Está seguro de activar este plan de pago?')) {
            updatePlanStatus(planId, 1);
        }
    }

    function deactivatePlan(planId) {
        if (confirm('¿Está seguro de desactivar este plan de pago?')) {
            updatePlanStatus(planId, 0);
        }
    }

    function updatePlanStatus(planId, status) {
        fetch(`/dashboard/inmueble/api/update_plan_status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    plan_id: planId,
                    status: status
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Estado actualizado correctamente');
                    location.reload();
                } else {
                    alert('Error al actualizar el estado');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al procesar la solicitud');
            });
    }

    function deletePlan(planId) {
        Swal.fire({
            title: '¿Está seguro de eliminar este plan de pago?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/dashboard/inmueble/api/delete_payment_plan/${planId}`, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Eliminado!',
                                text: 'Plan eliminado correctamente',
                                timer: 1800,
                                showConfirmButton: false
                            });
                            setTimeout(() => location.reload(), 1800);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error al eliminar el plan: ' + (data.message ||
                                    'Error desconocido'),
                                timer: 2200,
                                showConfirmButton: false
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al procesar la solicitud',
                            timer: 2200,
                            showConfirmButton: false
                        });
                    });
            }
        });
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('edit-payment-plan-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const planId = document.getElementById('edit_plan_id').value;

            const submitBtn = document.getElementById('update_plan_btn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="feather icon-loader"></i> Actualizando...';

            fetch(`/dashboard/inmueble/update_payment_plan/${planId}`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        $('#editPaymentPlanModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: '¡Actualizado!',
                            text: 'Plan de pago actualizado exitosamente',
                            timer: 1800,
                            showConfirmButton: false
                        });
                        setTimeout(() => location.reload(), 1800);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al actualizar el plan: ' + (data.message ||
                                'Error desconocido'),
                            timer: 2200,
                            showConfirmButton: false
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al procesar la solicitud',
                        timer: 2200,
                        showConfirmButton: false
                    });
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="feather icon-save"></i> Actualizar Plan';
                });
        });
    });
    </script>

    <!-- Modal para Crear Plan de Pago -->
    <div class="modal fade" id="createPaymentPlanModal" tabindex="-1" role="dialog"
        aria-labelledby="createPaymentPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPaymentPlanModalLabel">
                        <i class="feather icon-plus"></i> Nuevo Plan de Pago
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="create-payment-plan-form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="create_name">Nombre del Plan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="create_name" name="name" required
                                        placeholder="Ej: Plan Estándar 36 meses">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="create_code">Código <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="create_code" name="code" required
                                        placeholder="Ej: STD36">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="create_duration_months">Duración (Meses) <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="create_duration_months" name="duration_months"
                                        required>
                                        <option value="">Seleccionar duración</option>
                                        <option value="12">12 meses</option>
                                        <option value="24">24 meses</option>
                                        <option value="36">36 meses</option>
                                        <option value="48">48 meses</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="create_base_interest_rate">Tasa de Interés (%) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="create_base_interest_rate"
                                        name="base_interest_rate" step="0.01" min="0" max="6" value="3.5" required>
                                    <small class="form-text text-muted">Rango: 0% - 6%</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" id="create_is_default" name="is_default" value="1">
                                        Plan por defecto
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" id="create_active" name="active" value="1" checked>
                                        Plan activo
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="feather icon-x"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary" id="create_plan_btn">
                            <i class="feather icon-save"></i> Crear Plan de Pago
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    // Manejo del formulario de creación
    document.getElementById('create-payment-plan-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const submitBtn = document.getElementById('create_plan_btn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="feather icon-loader"></i> Creando...';

        const formData = new FormData(this);
        fetch('/dashboard/inmueble/create_payment_plan', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Cerrar el modal primero
                $('#createPaymentPlanModal').modal('hide');

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Creado!',
                        text: 'Plan de pago creado exitosamente',
                        allowOutsideClick: false,
                        showConfirmButton: true,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Error al crear el plan de pago',
                        allowOutsideClick: false,
                        showConfirmButton: true,
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                // Cerrar el modal primero
                $('#createPaymentPlanModal').modal('hide');

                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al procesar la solicitud',
                    allowOutsideClick: false,
                    showConfirmButton: true,
                    confirmButtonText: 'OK'
                });
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="feather icon-save"></i> Crear Plan de Pago';
            });
    });
    </script>

    <?php echo view("admin/footer"); ?>
</body>

</html>