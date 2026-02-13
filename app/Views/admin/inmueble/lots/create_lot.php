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

    <?php echo view("admin/footer"); ?>
</body>

</html>