<!doctype html>
<html lang="es-PE">
<?php echo view("admin/head"); ?>
<!-- JS modularizados para gestión de proyectos -->
<script src="/assets/js/project/project-add.js"></script>
<script src="/assets/js/project/project-edit.js"></script>
<script src="/assets/js/project/project-delete.js"></script>
<script src="/assets/js/project/project-detail.js"></script>

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
                                        <li class="breadcrumb-item"><a>Proyectos</a></li>
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
                                            <h5>Listado de Proyectos Inmobiliarios</h5>
                                            <div class="card-header-right">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="showCreateProjectModal()">
                                                    <i class="feather icon-plus"></i> Nuevo Proyecto
                                                </button>
                                            </div>
                                            <!-- Modal para Crear Proyecto -->
                                            <div class="modal fade" id="createProjectModal" tabindex="-1" role="dialog"
                                                aria-labelledby="createProjectModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <form id="create-project-form" method="POST">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="createProjectModalLabel">
                                                                    Nuevo Proyecto</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div id="createProjectErrorMsg"
                                                                    class="alert alert-danger d-none"></div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="create_name">Nombre del Proyecto
                                                                                <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                id="create_name" name="name" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="create_code">Código <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                id="create_code" name="code" required
                                                                                maxlength="50">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="create_location">Ubicación <span
                                                                                    class="text-danger">*</span></label>
                                                                            <select class="form-control"
                                                                                id="create_location" name="location"
                                                                                required>
                                                                                <option value="">Seleccionar ubicación
                                                                                </option>
                                                                                <option value="Lima">Lima</option>
                                                                                <option value="Cusco">Cusco</option>
                                                                                <option value="Arequipa">Arequipa
                                                                                </option>
                                                                                <option value="Trujillo">Trujillo
                                                                                </option>
                                                                                <option value="Otro">Otro</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="create_status">Estado</label>
                                                                            <select class="form-control"
                                                                                id="create_status" name="status">
                                                                                <option value="planning">En
                                                                                    Planificación</option>
                                                                                <option value="active">Activo</option>
                                                                                <option value="sold_out">Agotado
                                                                                </option>
                                                                                <option value="suspended">Suspendido
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="create_base_price_per_sqm">Precio
                                                                                Base por m² <span
                                                                                    class="text-danger">*</span></label>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span
                                                                                        class="input-group-text">S/</span>
                                                                                </div>
                                                                                <input type="number"
                                                                                    class="form-control"
                                                                                    id="create_base_price_per_sqm"
                                                                                    name="base_price_per_sqm"
                                                                                    step="0.01" min="0" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="create_base_interest_rate">Tasa
                                                                                de Interés Base (%) <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="number" class="form-control"
                                                                                id="create_base_interest_rate"
                                                                                name="base_interest_rate" step="0.01"
                                                                                min="2" max="6" required>
                                                                            <small class="form-text text-muted">Rango
                                                                                permitido: 2% - 6%</small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="create_down_payment_type">Tipo
                                                                                de Cuota Inicial</label>
                                                                            <select class="form-control"
                                                                                id="create_down_payment_type"
                                                                                name="down_payment_type"
                                                                                onchange="toggleDownPaymentField()">
                                                                                <option value="percentage">Porcentaje
                                                                                    (%)</option>
                                                                                <option value="fixed">Monto fijo (S/)
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group"
                                                                            id="downPaymentPercentageGroup">
                                                                            <label
                                                                                for="create_min_down_payment_percentage">Cuota
                                                                                Inicial Mínima (%)</label>
                                                                            <input type="number" class="form-control"
                                                                                id="create_min_down_payment_percentage"
                                                                                name="min_down_payment_percentage"
                                                                                step="0.01" min="1" max="100">
                                                                        </div>
                                                                        <div class="form-group d-none"
                                                                            id="downPaymentFixedGroup">
                                                                            <label
                                                                                for="create_min_down_payment_fixed">Cuota
                                                                                Inicial Mínima (S/)</label>
                                                                            <input type="number" class="form-control"
                                                                                id="create_min_down_payment_fixed"
                                                                                name="min_down_payment_fixed"
                                                                                step="0.01" min="0">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="create_max_financing_months">Máximo
                                                                                Meses de Financiamiento</label>
                                                                            <select class="form-control"
                                                                                id="create_max_financing_months"
                                                                                name="max_financing_months">
                                                                                <option value="24">24 meses (Cusco)
                                                                                </option>
                                                                                <option value="36">36 meses (Estándar)
                                                                                </option>
                                                                                <option value="48">48 meses</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="create_description">Descripción</label>
                                                                    <textarea class="form-control"
                                                                        id="create_description" name="description"
                                                                        rows="3"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">
                                                                    <i class="feather icon-x"></i> Cancelar
                                                                </button>
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="feather icon-save"></i> Crear Proyecto
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                            function toggleDownPaymentField() {
                                                var type = document.getElementById('create_down_payment_type').value;
                                                var percentGroup = document.getElementById(
                                                    'downPaymentPercentageGroup');
                                                var fixedGroup = document.getElementById('downPaymentFixedGroup');
                                                if (type === 'percentage') {
                                                    percentGroup.classList.remove('d-none');
                                                    fixedGroup.classList.add('d-none');
                                                } else {
                                                    percentGroup.classList.add('d-none');
                                                    fixedGroup.classList.remove('d-none');
                                                }
                                            }
                                            // Inicializar al abrir el modal
                                            document.getElementById('createProjectModal').addEventListener(
                                                'shown.bs.modal',
                                                function() {
                                                    toggleDownPaymentField();
                                                });

                                            function showCreateProjectModal() {
                                                document.getElementById('create-project-form').reset();
                                                document.getElementById('createProjectErrorMsg').classList.add(
                                                    'd-none');
                                                $('#createProjectModal').modal('show');
                                            }

                                            document.getElementById('create-project-form').addEventListener('submit',
                                                function(e) {
                                                    e.preventDefault();
                                                    const formData = new FormData(this);
                                                    const interestRate = parseFloat(formData.get(
                                                        'base_interest_rate'));
                                                    const pricePerSqm = parseFloat(formData.get(
                                                        'base_price_per_sqm'));
                                                    const downPaymentType = formData.get('down_payment_type');
                                                    let downPaymentValid = true;
                                                    if (downPaymentType === 'percentage') {
                                                        const percent = parseFloat(formData.get(
                                                            'min_down_payment_percentage'));
                                                        if (isNaN(percent) || percent < 1 || percent > 100) {
                                                            alert(
                                                                'La cuota inicial en porcentaje debe estar entre 1% y 100%'
                                                            );
                                                            downPaymentValid = false;
                                                        }
                                                    } else {
                                                        const fixed = parseFloat(formData.get(
                                                            'min_down_payment_fixed'));
                                                        if (isNaN(fixed) || fixed < 0) {
                                                            alert(
                                                                'La cuota inicial en soles debe ser mayor o igual a 0'
                                                            );
                                                            downPaymentValid = false;
                                                        }
                                                    }
                                                    // Validaciones generales
                                                    if (interestRate < 2 || interestRate > 6) {
                                                        alert('La tasa de interés debe estar entre 2% y 6%');
                                                        return false;
                                                    }
                                                    if (pricePerSqm <= 0) {
                                                        alert('El precio por m² debe ser mayor a 0');
                                                        return false;
                                                    }
                                                    if (!formData.get('name') || !formData.get('code') || !formData
                                                        .get('location')) {
                                                        alert('Completa los campos obligatorios');
                                                        return false;
                                                    }
                                                    if (!downPaymentValid) {
                                                        return false;
                                                    }
                                                    // Convertir FormData a URLSearchParams para enviar como x-www-form-urlencoded
                                                    const params = new URLSearchParams();
                                                    for (const pair of formData) {
                                                        params.append(pair[0], pair[1]);
                                                    }
                                                    fetch('/dashboard/inmueble/create_project', {
                                                            method: 'POST',
                                                            body: params,
                                                            headers: {
                                                                'X-Requested-With': 'XMLHttpRequest',
                                                                'Content-Type': 'application/x-www-form-urlencoded'
                                                            }
                                                        })
                                                        .then(async response => {
                                                            // Log completo de la respuesta HTTP
                                                            console.log('HTTP status:', response.status);
                                                            console.log('HTTP headers:', [...response
                                                                .headers
                                                            ]);
                                                            let text = await response.text();
                                                            console.log('HTTP body:', text);
                                                            let data;
                                                            try {
                                                                data = JSON.parse(text);
                                                            } catch (e) {
                                                                data = {
                                                                    success: false,
                                                                    message: 'Respuesta no es JSON',
                                                                    raw: text
                                                                };
                                                            }
                                                            const errorDiv = document.getElementById(
                                                                'createProjectErrorMsg');
                                                            if (data.success) {
                                                                $('#createProjectModal').modal('hide');
                                                                Swal.fire({
                                                                    icon: 'success',
                                                                    title: '¡Éxito!',
                                                                    text: data.message ||
                                                                        'Proyecto creado exitosamente',
                                                                    timer: 1800,
                                                                    showConfirmButton: false
                                                                });
                                                                setTimeout(() => location.reload(), 1800);
                                                            } else {
                                                                errorDiv.textContent = data.message ||
                                                                    'Error desconocido';
                                                                errorDiv.classList.remove('d-none');
                                                            }
                                                        })
                                                        .catch(error => {
                                                            console.error('Error en fetch:', error);
                                                            const errorDiv = document.getElementById(
                                                                'createProjectErrorMsg');
                                                            errorDiv.textContent =
                                                                'Error al procesar la solicitud';
                                                            errorDiv.classList.remove('d-none');
                                                        });
                                                });
                                            </script>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table id="zero-configuration"
                                                    class="display table nowrap table-striped table-hover dataTable"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Código</th>
                                                            <th>Nombre</th>
                                                            <th>Ubicación</th>
                                                            <th>Total Lotes</th>
                                                            <th>Disponibles</th>
                                                            <th>Precio m²</th>
                                                            <th>Estado</th>
                                                            <th>Fecha</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if ($projects): ?>
                                                        <?php foreach ($projects as $project): ?>
                                                        <tr>
                                                            <td><?= $project['id'] ?></td>
                                                            <td><strong><?= $project['code'] ?></strong></td>
                                                            <td>
                                                                <?= $project['name'] ?><br>
                                                                <small
                                                                    class="text-muted"><?= substr($project['description'], 0, 50) ?>...</small>
                                                            </td>
                                                            <td><?= $project['location'] ?></td>
                                                            <td><span
                                                                    class="badge badge-info"><?= $project['total_lots'] ?></span>
                                                            </td>
                                                            <td><span
                                                                    class="badge badge-success"><?= $project['available_lots'] ?></span>
                                                            </td>
                                                            <td>S/
                                                                <?= number_format($project['base_price_per_sqm'], 2) ?>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                         $status_class = '';
                                                         $status_text = '';
                                                         switch($project['status']) {
                                                            case 'active':
                                                               $status_class = 'badge-success';
                                                               $status_text = 'Activo';
                                                               break;
                                                            case 'planning':
                                                               $status_class = 'badge-warning';
                                                               $status_text = 'En Planificación';
                                                               break;
                                                            case 'sold_out':
                                                               $status_class = 'badge-danger';
                                                               $status_text = 'Agotado';
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
                                                            <td><?= date('d/m/Y', strtotime($project['created_at'])) ?>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <button type="button"
                                                                        class="btn btn-icon btn-info btn-sm"
                                                                        title="Detalle"
                                                                        onclick="showProjectDetail(<?= $project['id'] ?>)">
                                                                        <i class="fa fa-search"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-icon btn-warning btn-sm"
                                                                        title="Editar"
                                                                        onclick="editProject(<?= $project['id'] ?>)">
                                                                        <i class="fa fa-edit"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-icon btn-danger btn-sm"
                                                                        title="Eliminar"
                                                                        onclick="eliminar('<?= $project['id'] ?>');">
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

    <!-- Modal para Editar Proyecto -->
    <div class="modal fade" id="editProjectModal" tabindex="-1" role="dialog" aria-labelledby="editProjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="edit-project-form" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProjectModalLabel">Editar Proyecto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="editProjectErrorMsg" class="alert alert-danger d-none"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_name">Nombre del Proyecto <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_code">Código</label>
                                    <input type="text" class="form-control" id="edit_code" name="code" readonly>
                                    <small class="form-text text-muted">El código no se puede modificar</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_location">Ubicación <span class="text-danger">*</span></label>
                                    <select class="form-control" id="edit_location" name="location" required>
                                        <option value="">Seleccionar ubicación</option>
                                        <option value="Lima">Lima</option>
                                        <option value="Cusco">Cusco</option>
                                        <option value="Arequipa">Arequipa</option>
                                        <option value="Trujillo">Trujillo</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_status">Estado</label>
                                    <select class="form-control" id="edit_status" name="status">
                                        <option value="planning">En Planificación</option>
                                        <option value="active">Activo</option>
                                        <option value="sold_out">Agotado</option>
                                        <option value="suspended">Suspendido</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_base_price_per_sqm">Precio Base por m² <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/</span>
                                        </div>
                                        <input type="number" class="form-control" id="edit_base_price_per_sqm"
                                            name="base_price_per_sqm" step="0.01" min="0" required>
                                    </div>
                                    <small class="form-text text-warning">⚠️ Cambiar este precio afectará los nuevos
                                        lotes</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_base_interest_rate">Tasa de Interés Base (%) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="edit_base_interest_rate"
                                        name="base_interest_rate" step="0.01" min="2" max="6" required>
                                    <small class="form-text text-muted">Rango permitido: 2% - 6%</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_down_payment_type">Tipo de Cuota Inicial</label>
                                    <select class="form-control" id="edit_down_payment_type" name="down_payment_type"
                                        onchange="toggleEditDownPaymentField()">
                                        <option value="percentage">Porcentaje (%)</option>
                                        <option value="fixed">Monto fijo (S/)</option>
                                    </select>
                                </div>
                                <div class="form-group" id="editDownPaymentPercentageGroup">
                                    <label for="edit_min_down_payment_percentage">Cuota Inicial Mínima (%)</label>
                                    <input type="number" class="form-control" id="edit_min_down_payment_percentage"
                                        name="min_down_payment_percentage" step="0.01" min="1" max="100">
                                </div>
                                <div class="form-group d-none" id="editDownPaymentFixedGroup">
                                    <label for="edit_min_down_payment_fixed">Cuota Inicial Mínima (S/)</label>
                                    <input type="number" class="form-control" id="edit_min_down_payment_fixed"
                                        name="min_down_payment_fixed" step="0.01" min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_max_financing_months">Máximo Meses de Financiamiento</label>
                                    <select class="form-control" id="edit_max_financing_months"
                                        name="max_financing_months">
                                        <option value="24">24 meses (Cusco)</option>
                                        <option value="36">36 meses (Estándar)</option>
                                        <option value="48">48 meses</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_description">Descripción</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                        </div>

                        <!-- Estadísticas del proyecto -->
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Estadísticas del Proyecto</h6>
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <small class="text-muted">Total Lotes</small>
                                        <div class="h5 text-primary" id="project_total_lots">0</div>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <small class="text-muted">Disponibles</small>
                                        <div class="h5 text-success" id="project_available_lots">0</div>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <small class="text-muted">Vendidos</small>
                                        <div class="h5 text-info" id="project_sold_lots">0</div>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <small class="text-muted">% Vendido</small>
                                        <div class="h5 text-warning" id="project_sold_percentage">0%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="feather icon-x"></i> Cancelar
                        </button>
                        <a id="viewLotsBtn" href="#" class="btn btn-info">
                            <i class="feather icon-map"></i> Ver Lotes
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="feather icon-save"></i> Actualizar Proyecto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detalle Proyecto -->
    <div class="modal fade" id="projectDetailModal" tabindex="-1" role="dialog"
        aria-labelledby="projectDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="projectDetailModalLabel">Detalle del Proyecto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="projectDetailBody">
                    <!-- Aquí se carga el detalle dinámicamente -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="feather icon-x"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    </script>

    <?php echo view("admin/footer"); ?>
</body>

</html>