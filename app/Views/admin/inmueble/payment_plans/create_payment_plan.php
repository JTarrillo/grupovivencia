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
                                        <h5 class="m-b-10">Nuevo Plan de Pago</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard/panel">Panel</a></li>
                                        <li class="breadcrumb-item"><a href="/dashboard/inmueble">Gestión
                                                Inmobiliaria</a></li>
                                        <li class="breadcrumb-item"><a
                                                href="/dashboard/inmueble/payment_plans/payment_plans">Planes
                                                de Pago</a></li>
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
                                            <h5>Crear Plan de Pago</h5>
                                        </div>
                                        <div class="card-block">
                                            <form id="payment-plan-form"
                                                action="/dashboard/inmueble/payment_plans/create_payment_plan"
                                                method="POST">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="name">Nombre del Plan <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="name"
                                                                name="name" required
                                                                placeholder="Ej: Plan Estándar 36 meses">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="code">Código <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="code"
                                                                name="code" required placeholder="Ej: STD36">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="location">Ubicación <span
                                                                    class="text-danger">*</span></label>
                                                            <select class="form-control" id="location" name="location"
                                                                required onchange="updatePlanDefaults()">
                                                                <option value="">Seleccionar ubicación</option>
                                                                <option value="General">General</option>
                                                                <option value="Cusco">Cusco</option>
                                                                <option value="Lima">Lima</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="duration_months">Duración (meses) <span
                                                                    class="text-danger">*</span></label>
                                                            <select class="form-control" id="duration_months"
                                                                name="duration_months" required
                                                                onchange="calculateMonthlyPayment()">
                                                                <option value="">Seleccionar duración</option>
                                                                <option value="12">12 meses (Rápido)</option>
                                                                <option value="24">24 meses (Cusco)</option>
                                                                <option value="36">36 meses (Estándar)</option>
                                                                <option value="48">48 meses (Personalizado)</option>
                                                            </select>
                                                            <small class="form-text text-muted">12-24 meses para pagos rápidos, 36 meses estándar</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="base_interest_rate">Tasa de Interés (%) <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="number" class="form-control"
                                                                id="base_interest_rate" name="base_interest_rate"
                                                                step="0.01" min="0" max="6" value="3.5" required
                                                                onchange="calculateMonthlyPayment()">
                                                            <small class="form-text text-muted">Rango: 0% - 6%. (0% = sin interés)</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="down_payment_type">Tipo de Cuota Inicial <span
                                                                    class="text-danger">*</span></label>
                                                            <select class="form-control" id="down_payment_type"
                                                                name="down_payment_type" required
                                                                onchange="toggleDownPaymentType()">
                                                                <option value="percentage">Porcentaje (%)</option>
                                                                <option value="fixed">Monto Fijo (S/)</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group" id="percentageGroup">
                                                            <label for="min_down_payment_percentage">Cuota Inicial
                                                                Mínima (%)</label>
                                                            <input type="number" class="form-control"
                                                                id="min_down_payment_percentage"
                                                                name="min_down_payment_percentage" step="0.01" min="1"
                                                                max="100" value="15"
                                                                onchange="calculatePaymentExample()">
                                                        </div>
                                                        <div class="form-group d-none" id="fixedGroup">
                                                            <label for="min_amount">Cuota Inicial Mínima (S/)</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">S/</span>
                                                                </div>
                                                                <input type="number" class="form-control" id="min_amount"
                                                                    name="min_amount" step="0.01" min="0" value="5000"
                                                                    onchange="calculatePaymentExample()">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <input type="checkbox" id="is_default" name="is_default"
                                                                    value="1">
                                                                Plan por defecto para esta ubicación
                                                            </label>
                                                            <small class="form-text text-muted">Solo puede haber un plan
                                                                por defecto por ubicación</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                <input type="checkbox" id="active" name="active"
                                                                    value="1" checked>
                                                                Plan activo
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Simulador de Cálculo -->
                                                <div class="card bg-light mt-4">
                                                    <div class="card-header">
                                                        <h6>Simulador de Cálculo</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="example_lot_price">Precio del Lote
                                                                    (Ejemplo)</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">S/</span>
                                                                    </div>
                                                                    <input type="number" class="form-control"
                                                                        id="example_lot_price" value="160000"
                                                                        onchange="calculatePaymentExample()">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row" id="calculation-results">
                                                                    <div class="col-md-3">
                                                                        <label>Cuota Inicial:</label>
                                                                        <div class="alert alert-info mb-1">
                                                                            <strong>S/ <span
                                                                                    id="result-initial">24,000</span></strong>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label>Monto Financiado:</label>
                                                                        <div class="alert alert-warning mb-1">
                                                                            <strong>S/ <span
                                                                                    id="result-financed">136,000</span></strong>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label>Cuota Mensual:</label>
                                                                        <div class="alert alert-success mb-1">
                                                                            <strong>S/ <span
                                                                                    id="result-monthly">4,100</span></strong>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label>Total a Pagar:</label>
                                                                        <div class="alert alert-danger mb-1">
                                                                            <strong>S/ <span
                                                                                    id="result-total">171,600</span></strong>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <small class="text-muted">
                                                            <strong>Fórmula:</strong> Precio Lote - Inicial + Intereses
                                                            = Cronograma automático
                                                        </small>
                                                    </div>
                                                </div>

                                                <div class="form-group mt-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="feather icon-save"></i> Crear Plan de Pago
                                                    </button>
                                                    <a href="/dashboard/inmueble/payment_plans/payment_plans"
                                                        class="btn btn-secondary">
                                                        <i class="feather icon-arrow-left"></i> Cancelar
                                                    </a>
                                                    <button type="button" class="btn btn-info"
                                                        onclick="previewSchedule()">
                                                        <i class="feather icon-eye"></i> Vista Previa Cronograma
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
    function toggleDownPaymentType() {
        const type = document.getElementById('down_payment_type').value;
        const percentageGroup = document.getElementById('percentageGroup');
        const fixedGroup = document.getElementById('fixedGroup');

        if (type === 'percentage') {
            percentageGroup.classList.remove('d-none');
            fixedGroup.classList.add('d-none');
        } else {
            percentageGroup.classList.add('d-none');
            fixedGroup.classList.remove('d-none');
        }
        calculatePaymentExample();
    }

    function updatePlanDefaults() {
        const location = document.getElementById('location').value;
        const durationSelect = document.getElementById('duration_months');
        const interestRate = document.getElementById('base_interest_rate');

        // Reset
        durationSelect.value = '';

        if (location === 'Cusco') {
            durationSelect.value = '24';
            interestRate.value = '3.0';
            document.getElementById('name').value = 'Plan Cusco 24 meses';
            document.getElementById('code').value = 'CSC24';
        } else if (location === 'General') {
            durationSelect.value = '36';
            interestRate.value = '3.5';
            document.getElementById('name').value = 'Plan Estándar 36 meses';
            document.getElementById('code').value = 'STD36';
        } else if (location === 'Lima') {
            durationSelect.value = '36';
            interestRate.value = '4.0';
            document.getElementById('name').value = 'Plan Lima 36 meses';
            document.getElementById('code').value = 'LIM36';
        }

        calculatePaymentExample();
    }

    function calculatePaymentExample() {
        const lotPrice = parseFloat(document.getElementById('example_lot_price').value) || 160000;
        const downPaymentType = document.getElementById('down_payment_type').value;
        const interestRate = parseFloat(document.getElementById('base_interest_rate').value) || 3.5;
        const duration = parseInt(document.getElementById('duration_months').value) || 36;

        let initialPayment = 0;

        // Calcular cuota inicial según tipo
        if (downPaymentType === 'percentage') {
            const downPaymentPercentage = parseFloat(document.getElementById('min_down_payment_percentage').value) || 15;
            initialPayment = lotPrice * (downPaymentPercentage / 100);
        } else {
            initialPayment = parseFloat(document.getElementById('min_amount').value) || 5000;
        }

        // Monto financiado
        const financedAmount = lotPrice - initialPayment;

        // Calcular cuota mensual con interés compuesto
        const monthlyRate = (interestRate / 100) / 12;
        const monthlyPayment = financedAmount * (monthlyRate * Math.pow(1 + monthlyRate, duration)) / (Math.pow(1 +
            monthlyRate, duration) - 1);

        // Total a pagar
        const totalToPay = initialPayment + (monthlyPayment * duration);

        // Actualizar resultados
        document.getElementById('result-initial').textContent = initialPayment.toLocaleString('es-PE', {
            minimumFractionDigits: 0
        });
        document.getElementById('result-financed').textContent = financedAmount.toLocaleString('es-PE', {
            minimumFractionDigits: 0
        });
        document.getElementById('result-monthly').textContent = monthlyPayment.toLocaleString('es-PE', {
            minimumFractionDigits: 0
        });
        document.getElementById('result-total').textContent = totalToPay.toLocaleString('es-PE', {
            minimumFractionDigits: 0
        });
    }

    function previewSchedule() {
        const duration = parseInt(document.getElementById('duration_months').value);
        const monthlyPayment = parseFloat(document.getElementById('result-monthly').textContent.replace(/,/g, ''));

        if (!duration || !monthlyPayment) {
            alert('Complete los datos del plan para generar la vista previa');
            return;
        }

        // Crear ventana con cronograma de ejemplo
        const scheduleWindow = window.open('', '_blank', 'width=800,height=600');
        let scheduleHtml = `
               <html>
                  <head>
                     <title>Vista Previa - Cronograma de Pagos</title>
                     <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        table { width: 100%; border-collapse: collapse; }
                        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
                        th { background-color: #f2f2f2; }
                     </style>
                  </head>
                  <body>
                     <h3>Cronograma de Pagos - Vista Previa</h3>
                     <table>
                        <tr>
                           <th>Cuota</th>
                           <th>Fecha Vencimiento</th>
                           <th>Cuota Mensual</th>
                           <th>Capital</th>
                           <th>Interés</th>
                           <th>Saldo</th>
                        </tr>
            `;

        // Generar cronograma de ejemplo
        let balance = parseFloat(document.getElementById('result-financed').textContent.replace(/,/g, ''));
        const rate = parseFloat(document.getElementById('base_interest_rate').value) / 100 / 12;

        for (let i = 1; i <= duration; i++) {
            const interestPayment = balance * rate;
            const principalPayment = monthlyPayment - interestPayment;
            balance -= principalPayment;

            const dueDate = new Date();
            dueDate.setMonth(dueDate.getMonth() + i);

            scheduleHtml += `
                  <tr>
                     <td>${i}</td>
                     <td>${dueDate.toLocaleDateString('es-PE')}</td>
                     <td>S/ ${monthlyPayment.toFixed(2)}</td>
                     <td>S/ ${principalPayment.toFixed(2)}</td>
                     <td>S/ ${interestPayment.toFixed(2)}</td>
                     <td>S/ ${Math.max(0, balance).toFixed(2)}</td>
                  </tr>
               `;
        }

        scheduleHtml += `
                     </table>
                     <br>
                     <button onclick="window.close()">Cerrar</button>
                  </body>
               </html>
            `;

        scheduleWindow.document.write(scheduleHtml);
        scheduleWindow.document.close();
    }

    // Calcular al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        calculatePaymentExample();

        // Interceptar el envío del formulario para usar AJAX y mostrar Swal
        const form = document.getElementById('payment-plan-form');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="feather icon-loader"></i> Creando...';

            const formData = new FormData(form);
            fetch('/dashboard/inmueble/payment_plans/create_payment_plan', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Creado!',
                            text: 'Plan de pago creado exitosamente',
                            timer: 1800,
                            showConfirmButton: false
                        });
                        setTimeout(() => {
                            window.location.href =
                                '/dashboard/inmueble/payment_plans/payment_plans';
                        }, 1800);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Error al crear el plan de pago',
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
                    submitBtn.innerHTML = '<i class="feather icon-save"></i> Crear Plan de Pago';
                });
        });
    });
    </script>

    <?php echo view("admin/footer"); ?>
</body>

</html>