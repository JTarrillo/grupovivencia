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
                                        <li class="breadcrumb-item"><a href="/dashboard/panel">Panel</a></li>
                                        <li class="breadcrumb-item"><a href="/dashboard/inmueble">Inmueble</a></li>
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
                                                <button type="button" class="btn btn-warning btn-sm"
                                                    style="margin-left:10px;" onclick="enviarRecordatorioVencimiento()">
                                                    <i class="fa fa-envelope"></i> Enviar recordatorios de vencimiento
                                                </button>
                                            </div>
                                            <!-- Modal para Crear Proyecto -->
                                            <div class="modal fade" id="createProjectModal" tabindex="-1" role="dialog"
                                                aria-labelledby="createProjectModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <form id="create-project-form" method="POST"
                                                            enctype="multipart/form-data">
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
                                                                <div class="row mb-2">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group mb-2">
                                                                            <label for="create_name">Nombre del Proyecto
                                                                                <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                id="create_name" name="name" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-2">
                                                                            <label
                                                                                for="create_department_id">Departamento
                                                                                <span
                                                                                    class="text-danger">*</span></label>
                                                                            <select class="form-control"
                                                                                id="create_department_id"
                                                                                name="department_id" required>
                                                                                <option value="">Seleccionar
                                                                                    departamento</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-2">
                                                                            <label for="create_province_id">Provincia
                                                                                <span
                                                                                    class="text-danger">*</span></label>
                                                                            <select class="form-control"
                                                                                id="create_province_id"
                                                                                name="province_id" required>
                                                                                <option value="">Seleccionar provincia
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-2">
                                                                            <label for="create_district_id">Distrito
                                                                                <span
                                                                                    class="text-danger">*</span></label>
                                                                            <select class="form-control"
                                                                                id="create_district_id"
                                                                                name="district_id" required>
                                                                                <option value="">Seleccionar distrito
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-2">
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
                                                                    <div class="col-md-6"></div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-2">
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
                                                                        <div class="form-group mb-2">
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
                                                                <div class="row mb-2">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-2">
                                                                            <label for="create_down_payment_type">Tipo
                                                                                de Cuota Inicial</label>
                                                                            <select class="form-control"
                                                                                id="create_down_payment_type"
                                                                                name="down_payment_type"
                                                                                onchange="toggleDownPaymentField()">
                                                                                <option value="fixed">Monto fijo (S/)
                                                                                </option>
                                                                                <option value="percentage">Porcentaje
                                                                                    (%)</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group mb-2"
                                                                            id="downPaymentPercentageGroup">
                                                                            <label
                                                                                for="create_min_down_payment_percentage">Cuota
                                                                                Inicial Mínima (%)</label>
                                                                            <input type="number" class="form-control"
                                                                                id="create_min_down_payment_percentage"
                                                                                name="min_down_payment_percentage"
                                                                                step="0.01" min="1" max="100">
                                                                        </div>
                                                                        <div class="form-group mb-2 d-none"
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
                                                                        <div class="form-group mb-2">
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
                                                                <div class="form-group mb-2">
                                                                    <label for="create_description">Descripción</label>
                                                                    <textarea class="form-control"
                                                                        id="create_description" name="description"
                                                                        rows="3"></textarea>
                                                                </div>
                                                                <div class="form-group mb-2">
                                                                    <label for="create_image">Imagen del
                                                                        Proyecto</label>
                                                                    <input type="file" class="form-control"
                                                                        id="create_image" name="image" accept="image/*">
                                                                    <small class="form-text text-muted">Formatos
                                                                        permitidos: jpg, png, jpeg, webp.</small>
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
                                            // Función para editar proyecto y cargar datos en el modal
                                            function editProject(id) {
                                                fetch(`/dashboard/inmueble/api/get_project/${id}`)
                                                    .then(res => res.json())
                                                    .then(data => {
                                                        if (data.success && data.project) {
                                                            window.currentProject = data.project;
                                                            // Llenar campos del formulario de edición
                                                            document.getElementById('edit_name').value = data
                                                                .project.name || '';
                                                            document.getElementById('edit_code').value = data
                                                                .project.code || '';
                                                            // Eliminado campo location
                                                            document.getElementById('edit_description').value = data
                                                                .project.description || '';
                                                            document.getElementById('edit_base_price_per_sqm')
                                                                .value = data.project.base_price_per_sqm || '';
                                                            document.getElementById('edit_base_interest_rate')
                                                                .value = data.project.base_interest_rate || '';
                                                            document.getElementById('edit_status').value = data
                                                                .project.status || 'planning';
                                                            document.getElementById('edit_down_payment_type')
                                                                .value = data.project.down_payment_type ||
                                                                'percentage';
                                                            document.getElementById(
                                                                    'edit_min_down_payment_percentage').value = data
                                                                .project.min_down_payment_percentage || '';
                                                            document.getElementById('edit_min_down_payment_fixed')
                                                                .value = data.project.min_down_payment_fixed || '';
                                                            document.getElementById('edit_max_financing_months')
                                                                .value = data.project.max_financing_months || '36';

                                                            // Cargar selects de departamento, provincia y distrito con los valores actuales
                                                            cargarDepartamentosEdit(data.project.department_id, data
                                                                .project.province_id, data.project.district_id);

                                                            // Mostrar el modal
                                                            $('#editProjectModal').modal('show');
                                                        } else {
                                                            Swal.fire('Error', data.message ||
                                                                'No se pudo cargar el proyecto', 'error');
                                                        }
                                                    })
                                                    .catch(err => {
                                                        Swal.fire('Error', 'No se pudo conectar con el servidor',
                                                            'error');
                                                    });
                                            }
                                            // Carga dinámica de departamentos, provincias y distritos
                                            document.addEventListener('DOMContentLoaded', function() {
                                                cargarDepartamentos();

                                                document.getElementById('create_department_id')
                                                    .addEventListener('change', function() {
                                                        let deptId = parseInt(this.value);
                                                        cargarProvincias(deptId);
                                                        document.getElementById('create_district_id')
                                                            .innerHTML =
                                                            '<option value="">Seleccionar distrito</option>';
                                                        actualizarOpcionesFinanciamiento(
                                                            'create_department_id',
                                                            'create_max_financing_months');
                                                        // Si es Cusco, poner tasa de interés en 0
                                                        if (deptId === 8) {
                                                            document.getElementById(
                                                                'create_base_interest_rate').value = 0;
                                                            document.getElementById(
                                                                    'create_base_interest_rate')
                                                                .setAttribute('readonly', 'readonly');
                                                        } else {
                                                            document.getElementById(
                                                                'create_base_interest_rate').value = '';
                                                            document.getElementById(
                                                                    'create_base_interest_rate')
                                                                .removeAttribute('readonly');
                                                        }
                                                    });
                                                document.getElementById('edit_department_id').addEventListener(
                                                    'change',
                                                    function() {
                                                        let deptId = this.value;
                                                        cargarProvinciasEdit(deptId);
                                                        document.getElementById('edit_district_id')
                                                            .innerHTML =
                                                            '<option value="">Seleccionar distrito</option>';
                                                        actualizarOpcionesFinanciamiento(
                                                            'edit_department_id',
                                                            'edit_max_financing_months');
                                                        // Si es Cusco, poner tasa de interés en 0
                                                        if (parseInt(deptId) === 8) {
                                                            document.getElementById(
                                                                'edit_base_interest_rate').value = 0;
                                                            document.getElementById(
                                                                'edit_base_interest_rate').setAttribute(
                                                                'readonly', 'readonly');
                                                        } else {
                                                            document.getElementById(
                                                                'edit_base_interest_rate').value = '';
                                                            document.getElementById(
                                                                    'edit_base_interest_rate')
                                                                .removeAttribute('readonly');
                                                        }
                                                    });
                                                $('#editProjectModal').on('shown.bs.modal', function() {
                                                    let project = window.currentProject || {};
                                                    document.getElementById('edit_department_id')
                                                        .value = project.department_id || '';
                                                    document.getElementById('edit_province_id').value =
                                                        project.province_id || '';
                                                    document.getElementById('edit_district_id').value =
                                                        project.district_id || '';
                                                    actualizarOpcionesFinanciamiento(
                                                        'edit_department_id',
                                                        'edit_max_financing_months');
                                                    cargarDepartamentosEdit(project.department_id,
                                                        project.province_id, project.district_id);
                                                    // Si es Cusco, poner tasa de interés en 0
                                                    if (parseInt(project.department_id) === 8) {
                                                        document.getElementById(
                                                            'edit_base_interest_rate').value = 0;
                                                        document.getElementById(
                                                            'edit_base_interest_rate').setAttribute(
                                                            'readonly', 'readonly');
                                                    } else {
                                                        document.getElementById(
                                                                'edit_base_interest_rate')
                                                            .removeAttribute('readonly');
                                                    }
                                                });

                                                document.getElementById('create_province_id').addEventListener(
                                                    'change',
                                                    function() {
                                                        let provId = this.value;
                                                        cargarDistritos(provId);
                                                    });
                                            });

                                            function cargarDepartamentos() {
                                                fetch('/dashboard/inmueble/getDepartments')
                                                    .then(res => res.json())
                                                    .then(data => {
                                                        let select = document.getElementById(
                                                            'create_department_id');
                                                        select.innerHTML =
                                                            '<option value="">Seleccionar departamento</option>';
                                                        data.forEach(dep => {
                                                            select.innerHTML +=
                                                                `<option value="${dep.id}">${dep.name}</option>`;
                                                        });
                                                    });
                                            }

                                            function cargarProvincias(departmentId) {
                                                let select = document.getElementById('create_province_id');
                                                select.innerHTML = '<option value="">Seleccionar provincia</option>';
                                                if (!departmentId) return;
                                                fetch(`/dashboard/inmueble/getProvinces/${departmentId}`)
                                                    .then(res => res.json())
                                                    .then(data => {
                                                        data.forEach(prov => {
                                                            select.innerHTML +=
                                                                `<option value="${prov.id}">${prov.name}</option>`;
                                                        });
                                                    });
                                            }

                                            function cargarDistritos(provinceId) {
                                                let select = document.getElementById('create_district_id');
                                                select.innerHTML = '<option value="">Seleccionar distrito</option>';
                                                if (!provinceId) return;
                                                fetch(`/dashboard/inmueble/getDistricts/${provinceId}`)
                                                    .then(res => res.json())
                                                    .then(data => {
                                                        data.forEach(dist => {
                                                            select.innerHTML +=
                                                                `<option value="${dist.id}">${dist.name}</option>`;
                                                        });
                                                    });
                                            }

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
                                                // Limpiar opciones de meses de financiamiento
                                                let selectMonths = document.getElementById(
                                                    'create_max_financing_months');
                                                selectMonths.innerHTML =
                                                    '<option value="36">36 meses (Estándar)</option><option value="48">48 meses</option>';
                                                // Seleccionar "Monto fijo" y mostrar el campo correspondiente
                                                document.getElementById('create_down_payment_type').value = 'fixed';
                                                toggleDownPaymentField();
                                                $('#createProjectModal').modal('show');
                                            }

                                            document.getElementById('create-project-form').addEventListener('submit',
                                                function(e) {
                                                    // Prevent double submission if external script also attached a handler
                                                    if (this.dataset.submitting) {
                                                        e.preventDefault();
                                                        return false;
                                                    }
                                                    this.dataset.submitting = '1';
                                                    // Disable submit buttons to avoid duplicate posts
                                                    const submitButtons = this.querySelectorAll(
                                                        'button[type="submit"]');
                                                    submitButtons.forEach(b => b.setAttribute('disabled',
                                                        'disabled'));
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
                                                    const deptId = parseInt(formData.get('department_id'));
                                                    if (deptId === 8) {
                                                        // Cusco permite 0%
                                                        if (interestRate < 0 || interestRate > 6) {
                                                            alert(
                                                                'La tasa de interés para Cusco debe estar entre 0% y 6%'
                                                            );
                                                            return false;
                                                        }
                                                    } else {
                                                        if (interestRate < 2 || interestRate > 6) {
                                                            alert('La tasa de interés debe estar entre 2% y 6%');
                                                            return false;
                                                        }
                                                    }
                                                    if (pricePerSqm <= 0) {
                                                        alert('El precio por m² debe ser mayor a 0');
                                                        return false;
                                                    }
                                                    if (!formData.get('name')) {
                                                        alert('Completa los campos obligatorios (nombre)');
                                                        return false;
                                                    }
                                                    if (!downPaymentValid) {
                                                        return false;
                                                    }
                                                    // Habilitar el campo si está readonly antes de enviar
                                                    document.getElementById('create_base_interest_rate')
                                                        .removeAttribute('readonly');
                                                    fetch('/dashboard/inmueble/create_project', {
                                                            method: 'POST',
                                                            body: formData,
                                                            headers: {
                                                                'X-Requested-With': 'XMLHttpRequest'
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
                                                                // If server generated a code, show it briefly before reloading
                                                                if (data.generated_code) {
                                                                    setTimeout(() => {
                                                                        Swal.fire('Código generado',
                                                                            `Código: ${data.code}`,
                                                                            'info');
                                                                    }, 1800);
                                                                    setTimeout(() => location.reload(),
                                                                        3600);
                                                                } else {
                                                                    setTimeout(() => location.reload(),
                                                                        1800);
                                                                }
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
                                                        })
                                                        .finally(() => {
                                                            // Re-enable buttons after request completes
                                                            delete this.dataset.submitting;
                                                            const submitButtons = this.querySelectorAll(
                                                                'button[type="submit"]');
                                                            submitButtons.forEach(b => b.removeAttribute(
                                                                'disabled'));
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
                                                            <th>Imagen</th>
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
                                                        <?php
                                                        if ($projects) {
                                                            foreach ($projects as $project) {
                                                        ?>
                                                        <tr>
                                                            <td><?= $project['id'] ?></td>
                                                            <td>
                                                                <?php
                                                                $imgPath = !empty($project['image']) ? $project['image'] : '';
                                                                $imgFullPath = FCPATH . $imgPath;
                                                                if (!empty($imgPath) && file_exists($imgFullPath)) {
                                                                    echo '<img src="/' . $imgPath . '" alt="Imagen" style="max-width:60px;max-height:60px;border-radius:6px;object-fit:cover;">';
                                                                } else {
                                                                    echo '<img src="/assets/project_images/no-image.png" alt="Sin imagen" style="max-width:60px;max-height:60px;border-radius:6px;object-fit:cover;">';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><strong><?= $project['code'] ?></strong></td>
                                                            <td>
                                                                <?= $project['name'] ?><br>
                                                                <small
                                                                    class="text-muted"><?= substr($project['description'], 0, 50) ?>...</small>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $dep = isset($project['department_id']) && isset($departamentos[$project['department_id']]) ? $departamentos[$project['department_id']] : '<span style="color:#bbb">(Sin departamento)</span>';
                                                                $prov = isset($project['province_id']) && isset($provincias[$project['province_id']]) ? $provincias[$project['province_id']] : '<span style="color:#bbb">(Sin provincia)</span>';
                                                                $dist = isset($project['district_id']) && isset($distritos[$project['district_id']]) ? $distritos[$project['district_id']] : '<span style="color:#bbb">(Sin distrito)</span>';
                                                                ?>
                                                                <?= $dep ?> / <?= $prov ?> / <?= $dist ?>
                                                            </td>
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
                                                                        onclick="showProjectDetail(<?= $project['id'] ?>)"><i
                                                                            class="fa fa-search"></i></button>
                                                                    <button type="button"
                                                                        class="btn btn-icon btn-warning btn-sm"
                                                                        title="Editar"
                                                                        onclick="editProject(<?= $project['id'] ?>)"><i
                                                                            class="fa fa-edit"></i></button>
                                                                    <button type="button"
                                                                        class="btn btn-icon btn-danger btn-sm"
                                                                        title="Eliminar"
                                                                        onclick="eliminar('<?= $project['id'] ?>');"><i
                                                                            class="fa fa-trash"></i></button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
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
                <form id="edit-project-form" method="POST" enctype="multipart/form-data">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit_department_id">Departamento <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="edit_department_id" name="department_id" required>
                                        <option value="">Seleccionar departamento</option>
                                        <!-- Opciones dinámicas -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit_province_id">Provincia <span class="text-danger">*</span></label>
                                    <select class="form-control" id="edit_province_id" name="province_id" required>
                                        <option value="">Seleccionar provincia</option>
                                        <!-- Opciones dinámicas -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit_district_id">Distrito <span class="text-danger">*</span></label>
                                    <select class="form-control" id="edit_district_id" name="district_id" required>
                                        <option value="">Seleccionar distrito</option>
                                        <!-- Opciones dinámicas -->
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
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
                                        <option value="fixed">Monto fijo (S/)</option>
                                        <option value="percentage">Porcentaje (%)</option>

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
                        <div class="form-group">
                            <label for="edit_image">Imagen del Proyecto</label>
                            <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                            <small class="form-text text-muted">Formatos permitidos: jpg, png, jpeg, webp.</small>
                            <div id="edit_image_preview" style="margin-top:10px;"></div>
                            <script>
                            // Preview selected image in edit modal
                            document.getElementById('edit_image').addEventListener('change', function(e) {
                                const preview = document.getElementById('edit_image_preview');
                                preview.innerHTML = '';
                                if (this.files && this.files[0]) {
                                    const reader = new FileReader();
                                    reader.onload = function(ev) {
                                        preview.innerHTML =
                                            `<img src='${ev.target.result}' style='max-width:120px;max-height:120px;border-radius:8px;object-fit:cover;'>`;
                                    };
                                    reader.readAsDataURL(this.files[0]);
                                }
                            });
                            </script>
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
                <script>
                document.getElementById('edit-project-form').addEventListener('submit', function(e) {
                    e.preventDefault();
                    const url = '/dashboard/inmueble/edit_project/' + (window.currentProject?.id || '');
                    const formData = new FormData(this);
                    // Validaciones básicas
                    const interestRate = parseFloat(formData.get('base_interest_rate'));
                    const pricePerSqm = parseFloat(formData.get('base_price_per_sqm'));
                    const downPaymentType = formData.get('down_payment_type');
                    let downPaymentValid = true;
                    if (downPaymentType === 'percentage') {
                        const percent = parseFloat(formData.get('min_down_payment_percentage'));
                        if (isNaN(percent) || percent < 1 || percent > 100) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Validación',
                                text: 'La cuota inicial en porcentaje debe estar entre 1% y 100%'
                            });
                            downPaymentValid = false;
                        }
                    } else {
                        const fixed = parseFloat(formData.get('min_down_payment_fixed'));
                        if (isNaN(fixed) || fixed < 0) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Validación',
                                text: 'La cuota inicial en soles debe ser mayor o igual a 0'
                            });
                            downPaymentValid = false;
                        }
                    }
                    const deptId = parseInt(formData.get('department_id'));
                    if (deptId === 8) {
                        // Cusco permite 0%
                        if (interestRate < 0 || interestRate > 6) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Validación',
                                text: 'La tasa de interés para Cusco debe estar entre 0% y 6%'
                            });
                            return false;
                        }
                    } else {
                        if (interestRate < 2 || interestRate > 6) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Validación',
                                text: 'La tasa de interés debe estar entre 2% y 6%'
                            });
                            return false;
                        }
                    }
                    if (pricePerSqm <= 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Validación',
                            text: 'El precio por m² debe ser mayor a 0'
                        });
                        return false;
                    }
                    if (!formData.get('name') || !formData.get('code')) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Validación',
                            text: 'Completa los campos obligatorios'
                        });
                        return false;
                    }
                    if (!downPaymentValid) {
                        return false;
                    }
                    document.getElementById('edit_base_interest_rate').removeAttribute('readonly');
                    fetch(url, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(async response => {
                            let text = await response.text();
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
                            const errorDiv = document.getElementById('editProjectErrorMsg');
                            if (data.success) {
                                $('#editProjectModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Éxito!',
                                    text: data.message || 'Proyecto actualizado exitosamente',
                                    timer: 1800,
                                    showConfirmButton: false
                                });
                                // Actualizar la imagen en la tabla sin recargar
                                if (data.image_url && window.currentProject?.id) {
                                    const row = document.querySelector(
                                        `tr td:first-child:contains('${window.currentProject.id}')`);
                                    if (row) {
                                        const imgCell = row.nextElementSibling;
                                        if (imgCell) {
                                            imgCell.innerHTML =
                                                `<img src='/${data.image_url}' alt='Imagen' style='max-width:60px;max-height:60px;border-radius:6px;object-fit:cover;'>`;
                                        }
                                    }
                                }
                                setTimeout(() => location.reload(), 1800);
                            } else {
                                errorDiv.textContent = data.message || 'Error desconocido';
                                errorDiv.classList.remove('d-none');
                            }
                        })
                        .catch(error => {
                            console.error('Error en fetch:', error);
                            const errorDiv = document.getElementById('editProjectErrorMsg');
                            errorDiv.textContent = 'Error al procesar la solicitud';
                            errorDiv.classList.remove('d-none');
                        });
                });
                </script>
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
    // Asegura que el Swal salga sobre el modal Bootstrap
    window.addEventListener('DOMContentLoaded', function() {
        // Ajusta el z-index del contenedor de SweetAlert si existe
        const observer = new MutationObserver(() => {
            const swalContainer = document.querySelector('.swal2-container');
            if (swalContainer) {
                swalContainer.style.zIndex = '20000'; // mayor que el modal Bootstrap
            }
        });
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    });

    function enviarRecordatorioVencimiento() {
        Swal.fire({
            title: '¿Desea enviar recordatorios de vencimiento?',
            text: '¿Desea enviar recordatorios de vencimiento por email a todos los clientes con cuotas próximas a vencer?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#7a6a00',
            cancelButtonColor: '#e6e09c'
        }).then((result) => {
            if (result.isConfirmed) {
                // Aquí tu lógica para enviar el recordatorio (AJAX, fetch, etc.)
                // Por ejemplo:
                fetch('/dashboard/inmueble/enviar_recordatorios_vencimiento', {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (Array.isArray(data.resultados)) {
                            let html = '<ul style="text-align:left;">';
                            data.resultados.forEach(r => {
                                html += `<li>${r}</li>`;
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
                                icon: data.success ? 'success' : 'info',
                                title: 'Resultado',
                                text: data.message || 'Operación realizada.'
                            });
                        }
                    })
                    .catch(() => {
                        Swal.fire('Error', 'No se pudo conectar con el servidor', 'error');
                    });
            }
        });
    }
    </script>
    <script>
    // Carga dinámica de departamentos, provincias y distritos para editar
    document.addEventListener('DOMContentLoaded', function() {
        // Cuando se abre el modal de editar, cargar departamentos y setear valores
        $('#editProjectModal').on('shown.bs.modal', function() {
            // Obtener el proyecto actual (debe estar en window.currentProject)
            let project = window.currentProject || {};
            // Setear los valores en los selects antes de cargar opciones
            document.getElementById('edit_department_id').value = project.department_id || '';
            document.getElementById('edit_province_id').value = project.province_id || '';
            document.getElementById('edit_district_id').value = project.district_id || '';
            cargarDepartamentosEdit(project.department_id, project.province_id, project.district_id);
        });

        document.getElementById('edit_department_id').addEventListener('change', function() {
            let deptId = this.value;
            cargarProvinciasEdit(deptId);
            document.getElementById('edit_district_id').innerHTML =
                '<option value="">Seleccionar distrito</option>';
        });
        document.getElementById('edit_province_id').addEventListener('change', function() {
            let provId = this.value;
            cargarDistritosEdit(provId);
        });
    });

    // Actualiza las opciones de meses de financiamiento según el departamento seleccionado
    function actualizarOpcionesFinanciamiento(selectDeptId, selectMonthsId) {
        const deptId = parseInt(document.getElementById(selectDeptId).value);
        const selectMonths = document.getElementById(selectMonthsId);
        selectMonths.innerHTML = '';
        if (deptId === 8) {
            selectMonths.innerHTML += '<option value="24">24 meses (Cusco)</option>';
        }
        selectMonths.innerHTML += '<option value="36">36 meses (Estándar)</option>';
        selectMonths.innerHTML += '<option value="48">48 meses</option>';
    }

    function cargarDepartamentosEdit(selectedDept, selectedProv, selectedDist) {
        fetch('/dashboard/inmueble/getDepartments')
            .then(res => res.json())
            .then(data => {
                let select = document.getElementById('edit_department_id');
                select.innerHTML = '<option value="">Seleccionar departamento</option>';
                data.forEach(dep => {
                    select.innerHTML +=
                        `<option value="${dep.id}"${dep.id == selectedDept ? ' selected' : ''}>${dep.name}</option>`;
                });
                if (selectedDept) cargarProvinciasEdit(selectedDept, selectedProv, selectedDist);
            });
    }

    function cargarProvinciasEdit(departmentId, selectedProv, selectedDist) {
        let select = document.getElementById('edit_province_id');
        select.innerHTML = '<option value="">Seleccionar provincia</option>';
        if (!departmentId) return;
        fetch(`/dashboard/inmueble/getProvinces/${departmentId}`)
            .then(res => res.json())
            .then(data => {
                data.forEach(prov => {
                    select.innerHTML +=
                        `<option value="${prov.id}"${prov.id == selectedProv ? ' selected' : ''}>${prov.name}</option>`;
                });
                if (selectedProv) cargarDistritosEdit(selectedProv, selectedDist);
            });
    }

    function cargarDistritosEdit(provinceId, selectedDist) {
        let select = document.getElementById('edit_district_id');
        select.innerHTML = '<option value="">Seleccionar distrito</option>';
        if (!provinceId) return;
        fetch(`/dashboard/inmueble/getDistricts/${provinceId}`)
            .then(res => res.json())
            .then(data => {
                data.forEach(dist => {
                    select.innerHTML +=
                        `<option value="${dist.id}"${dist.id == selectedDist ? ' selected' : ''}>${dist.name}</option>`;
                });
            });
    }
    // Al abrir el modal de edición, debes asignar el proyecto actual a window.currentProject
    // Ejemplo: window.currentProject = { department_id: ..., province_id: ..., district_id: ... }
    </script>

    <?php echo view("admin/footer"); ?>
</body>

</html>