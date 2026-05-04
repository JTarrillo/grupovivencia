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
                                        <li class="breadcrumb-item"><a href="/dashboard/inmueble">Gestión
                                                Inmobiliaria</a></li>
                                        <li class="breadcrumb-item"><a href="/dashboard/inmueble/lots/lots">Lotes</a>
                                        </li>
                                        <li class="breadcrumb-item"><a>Nuevo</a></li>
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
                                            <h5>Crear Nuevo Lote</h5>
                                            <div class="card-header-right">
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                                    data-target="#bulkCreateModal">
                                                    <i class="feather icon-layers"></i> Crear Múltiples Lotes
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <form id="lot-form" action="/dashboard/inmueble/create_lot" method="POST">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="project_id">Proyecto <span
                                                                    class="text-danger">*</span></label>
                                                            <select class="form-control" id="project_id"
                                                                name="project_id" required
                                                                onchange="updatePricePerSqm(); calculatePrice();">
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
                                                            <label for="lot_number">Número de Lote <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="lot_number"
                                                                name="lot_number" required placeholder="Ej: L001">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="block">Manzana</label>
                                                            <input type="text" class="form-control" id="block"
                                                                name="block" placeholder="Ej: A, B, C">
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="cadastral_unit">Unidad Catastral</label>
                                                            <input type="text" class="form-control" id="cadastral_unit"
                                                                name="cadastral_unit" placeholder="Ej: UC-12345">
                                                            <small class="form-text text-muted">Dato oficial del
                                                                catastro, si aplica.</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="registry_number">Partida Electrónica <span
                                                                    class="text-muted">(Electronic Property
                                                                    Record)</span></label>
                                                            <input type="text" class="form-control" id="registry_number"
                                                                name="registry_number" placeholder="Ej: 12345678">
                                                            <small class="form-text text-muted">Número de la Partida
                                                                Electrónica SUNARP, si aplica.</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="area_sqm">Área (m²) <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="number" class="form-control" id="area_sqm"
                                                                name="area_sqm" step="0.01" min="50" required
                                                                onchange="calculatePrice()">
                                                            <small class="form-text text-muted">Área mínima: 50
                                                                m²</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="price_per_sqm">Precio por m²</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">S/</span>
                                                                </div>
                                                                <input type="number" class="form-control"
                                                                    id="price_per_sqm" step="0.01" readonly>
                                                            </div>
                                                            <small class="form-text text-muted">Se toma del proyecto
                                                                seleccionado</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="base_price">Precio Total del Lote <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">S/</span>
                                                                </div>
                                                                <input type="number" class="form-control"
                                                                    id="base_price" name="base_price" step="0.01"
                                                                    min="0" required>
                                                            </div>
                                                            <small class="form-text text-muted">Se calcula
                                                                automáticamente</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="status">Estado Inicial</label>
                                                            <select class="form-control" id="status" name="status">
                                                                <option value="available" selected>Disponible</option>
                                                                <option value="blocked">Bloqueado</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Información del Proyecto</label>
                                                            <div class="alert alert-info" id="project-info"
                                                                style="display: none;">
                                                                <strong>Ubicación:</strong> <span
                                                                    id="project-location">-</span><br>
                                                                <strong>Precio base m²:</strong> S/ <span
                                                                    id="project-price">-</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Preview del cálculo -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card bg-light">
                                                            <div class="card-body">
                                                                <h6>Resumen del Lote</h6>
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <strong>Área:</strong> <span
                                                                            id="summary-area">-</span> m²
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <strong>Precio m²:</strong> S/ <span
                                                                            id="summary-price-sqm">-</span>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <strong>Precio Total:</strong> S/ <span
                                                                            id="summary-total">-</span>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <strong id="summary-initial-label">Cuota
                                                                            Inicial:</strong> S/ <span
                                                                            id="summary-initial">-</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="feather icon-save"></i> Crear Lote
                                                    </button>
                                                    <a href="/dashboard/inmueble/lots/lots" class="btn btn-secondary">
                                                        <i class="feather icon-arrow-left"></i> Cancelar
                                                    </a>
                                                    <button type="button" class="btn btn-info"
                                                        onclick="validateLotNumber()">
                                                        <i class="feather icon-check"></i> Verificar Disponibilidad
                                                    </button>
                                                </div>
                                            </form>
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

    <script>
    function updatePricePerSqm() {
        const projectSelect = document.getElementById('project_id');
        const selectedOption = projectSelect.options[projectSelect.selectedIndex];

        if (selectedOption.value) {
            const price = selectedOption.getAttribute('data-price');
            const location = selectedOption.getAttribute('data-location');

            document.getElementById('price_per_sqm').value = price;
            document.getElementById('project-location').textContent = location;
            document.getElementById('project-price').textContent = price;
            document.getElementById('project-info').style.display = 'block';

            calculatePrice();
        } else {
            document.getElementById('price_per_sqm').value = '';
            document.getElementById('project-info').style.display = 'none';
            clearSummary();
        }
    }

    function calculatePrice() {
        const area = parseFloat(document.getElementById('area_sqm').value) || 0;
        const pricePerSqm = parseFloat(document.getElementById('price_per_sqm').value) || 0;
        const projectSelect = document.getElementById('project_id');
        const selectedOption = projectSelect.options[projectSelect.selectedIndex];
        let downPaymentType = 'percentage';
        let minDownPaymentPercentage = 15;
        let minDownPaymentFixed = 0;
        if (selectedOption) {
            downPaymentType = selectedOption.getAttribute('data-down-payment-type') || 'percentage';
            minDownPaymentPercentage = parseFloat(selectedOption.getAttribute('data-min-down-payment-percentage')) ||
                15;
            minDownPaymentFixed = parseFloat(selectedOption.getAttribute('data-min-down-payment-fixed')) || 0;
        }
        if (area > 0 && pricePerSqm > 0) {
            const totalPrice = area * pricePerSqm;
            let initialPayment = 0;
            let initialLabel = '';
            if (downPaymentType === 'fixed') {
                // Si el monto fijo no está configurado, calcular el equivalente al porcentaje
                if (!minDownPaymentFixed || minDownPaymentFixed === 0) {
                    initialPayment = totalPrice * (minDownPaymentPercentage / 100);
                    initialLabel = `Cuota Inicial (fijo, equivale a ${minDownPaymentPercentage}%)`;
                } else {
                    initialPayment = minDownPaymentFixed;
                    let percentEquivalent = totalPrice > 0 ? (minDownPaymentFixed / totalPrice * 100) : 0;
                    initialLabel = `Cuota Inicial (fijo, equivale a ${percentEquivalent.toFixed(2)}%)`;
                }
            } else {
                initialPayment = totalPrice * (minDownPaymentPercentage / 100);
                initialLabel = `Cuota Inicial (${minDownPaymentPercentage}%)`;
            }
            document.getElementById('base_price').value = totalPrice.toFixed(2);
            // Update summary con formato de miles
            document.getElementById('summary-area').textContent = area.toFixed(2);
            document.getElementById('summary-price-sqm').textContent = pricePerSqm.toLocaleString('es-PE', {
                minimumFractionDigits: 2
            });
            document.getElementById('summary-total').textContent = totalPrice.toLocaleString('es-PE', {
                minimumFractionDigits: 2
            });
            document.getElementById('summary-initial-label').textContent = initialLabel + ':';
            document.getElementById('summary-initial').textContent = initialPayment.toLocaleString('es-PE', {
                minimumFractionDigits: 2
            });
        } else {
            clearSummary();
        }
    }

    function clearSummary() {
        document.getElementById('summary-area').textContent = '-';
        document.getElementById('summary-price-sqm').textContent = '-';
        document.getElementById('summary-total').textContent = '-';
        document.getElementById('summary-initial').textContent = '-';
        document.getElementById('summary-initial-label').textContent = 'Cuota Inicial:';
    }

    function validateLotNumber() {
        const projectId = document.getElementById('project_id').value;
        const lotNumber = document.getElementById('lot_number').value;

        if (!projectId || !lotNumber) {
            alert('Por favor selecciona un proyecto e ingresa el número de lote');
            return;
        }

        // AJAX call to check if lot number exists
        fetch('/dashboard/inmueble/api/validate_lot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    project_id: projectId,
                    lot_number: lotNumber
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    alert('Este número de lote ya existe en el proyecto seleccionado');
                    document.getElementById('lot_number').style.borderColor = 'red';
                } else {
                    alert('Número de lote disponible');
                    document.getElementById('lot_number').style.borderColor = 'green';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al verificar disponibilidad');
            });
    }

    // Form validation
    document.getElementById('lot-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const area = parseFloat(document.getElementById('area_sqm').value);
        const price = parseFloat(document.getElementById('base_price').value);

        if (area < 50) {
            Swal.fire({
                icon: 'warning',
                title: 'Área insuficiente',
                text: 'El área mínima debe ser de 50 m²'
            });
            return false;
        }

        if (price <= 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Precio inválido',
                text: 'El precio del lote debe ser mayor a 0'
            });
            return false;
        }

        // Submit form via AJAX
        const formData = new FormData(this);
        fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message || 'Lote creado exitosamente',
                        timer: 1800,
                        showConfirmButton: false
                    });
                    setTimeout(() => window.location.href = '/dashboard/inmueble/lots', 1800);
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

</html>