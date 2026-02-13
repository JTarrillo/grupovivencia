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
                                        <h5 class="m-b-10">Detalle de Contrato</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard/panel">Panel</a></li>
                                        <li class="breadcrumb-item"><a href="/dashboard/inmueble">Gestión
                                                Inmobiliaria</a></li>
                                        <li class="breadcrumb-item"><a
                                                href="/dashboard/inmueble/contracts">Contratos</a></li>
                                        <li class="breadcrumb-item"><a>Detalle</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container" id="printTable">
                        <div>
                            <div class="card">
                                <div class="row invoice-contact">
                                    <div class="row align-items-center w-100" style="margin-bottom: 20px;">
                                        <div class="col-md-8">
                                            <table class="table table-responsive invoice-table table-borderless p-l-20">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <a class="b-brand">
                                                                <img class="img-fluid"
                                                                    src="<?php echo site_url() . "assets/front/img/logo/logo_2025__.png"; ?>"
                                                                    alt="Logo" width="50">
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>GRUPO VIVENCIA S.A.C.</td>
                                                    </tr>
                                                    <tr>
                                                        <td>RUC: 20XXXXXXXXX</td>
                                                    </tr>
                                                    <tr>
                                                        <td><a class="text-secondary">ventas@grupovivencia.com</a></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-4 text-right" style="padding-right: 30px;">
                                            <h4 style="margin-bottom: 5px;">CONTRATO DE VENTA</h4>
                                            <h6 style="word-break: break-all;">N°
                                                <?= $contract['contract_number'] ?? 'N/A' ?></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row invoive-info">
                                        <div class="col-md-4 col-xs-12 invoice-client-info">
                                            <h6>Información del Cliente:</h6>
                                            <h6 class="m-0">Cliente: <?= $customer['name'] ?? 'N/A' ?>
                                                <?= $customer['lastname'] ?? '' ?></h6>
                                            <p class="m-0">DNI: <?= $customer['dni'] ?? 'N/A' ?></p>
                                            <p class="m-0">Teléfono: <?= $customer['phone'] ?? 'N/A' ?></p>
                                            <p class="m-0">Dirección: <?= $customer['address'] ?? 'N/A' ?></p>
                                            <p><a class="text-secondary">Email: <?= $customer['email'] ?? 'N/A' ?></a>
                                            </p>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <h6>Información del Lote y Proyecto:</h6>
                                            <table
                                                class="table table-responsive invoice-table invoice-order table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <th>Lote:</th>
                                                        <td>#<?= $contract['lot_id'] ?? 'N/A' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Proyecto:</th>
                                                        <td><?= $project['name'] ?? 'N/A' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Área del lote:</th>
                                                        <td><?= $lot['area_sqm'] ?? 'N/A' ?> m²</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Ubicación del lote:</th>
                                                        <td><?= trim(($lot['block'] ?? '') . ' ' . ($lot['lot_number'] ?? '')) ?: 'N/A' ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Ubicación del proyecto:</th>
                                                        <td><?= $project['location'] ?? 'N/A' ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <h6>Información del Contrato:</h6>
                                            <table
                                                class="table table-responsive invoice-table invoice-order table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <th>Fecha:</th>
                                                        <td><?= date('d/m/Y', strtotime($contract['contract_date'] ?? 'now')) ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Estado:</th>
                                                        <td>
                                                            <?php
                                                            $status_class = '';
                                                            $status_text = '';
                                                            switch($contract['status'] ?? 'active') {
                                                                case 'active':
                                                                    $status_class = 'label-success';
                                                                    $status_text = 'Activo';
                                                                    break;
                                                                case 'completed':
                                                                    $status_class = 'label-primary';
                                                                    $status_text = 'Completado';
                                                                    break;
                                                                case 'cancelled':
                                                                    $status_class = 'label-danger';
                                                                    $status_text = 'Cancelado';
                                                                    break;
                                                                case 'suspended':
                                                                    $status_class = 'label-warning';
                                                                    $status_text = 'Suspendido';
                                                                    break;
                                                            }
                                                            ?>
                                                            <span
                                                                class="label <?= $status_class ?>"><?= $status_text ?></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Plan de Pago:</th>
                                                        <td><?= $paymentPlan['name'] ?? 'N/A' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Duración:</th>
                                                        <td><?= $paymentPlan['duration_months'] ?? 'N/A' ?> meses</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tasa de Interés:</th>
                                                        <td><?= $paymentPlan['base_interest_rate'] ?? ($contract['interest_rate'] ?? 'N/A') ?>%
                                                            anual</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Cuota Inicial (%):</th>
                                                        <td><?= $paymentPlan['min_down_payment_percentage'] ?? 'N/A' ?>%
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Detalles Financieros -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h6>Detalles Financieros:</h6>
                                            <div class="table-responsive">
                                                <table class="table invoice-detail-table">
                                                    <thead>
                                                        <tr class="thead-default">
                                                            <th>Concepto</th>
                                                            <th>Descripción</th>
                                                            <th class="text-right">Monto</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><strong>Precio del Lote</strong></td>
                                                            <td>Valor total del terreno</td>
                                                            <td class="text-right">S/
                                                                <?= number_format($contract['total_amount'] ?? 0, 2) ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Cuota Inicial</strong></td>
                                                            <td>Pago inicial requerido</td>
                                                            <td class="text-right">S/
                                                                <?= number_format($contract['down_payment'] ?? 0, 2) ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Monto Financiado</strong></td>
                                                            <td>Saldo a financiar</td>
                                                            <td class="text-right">S/
                                                                <?= number_format($contract['financed_amount'] ?? 0, 2) ?>
                                                            </td>
                                                        </tr>
                                                        <tr class="table-primary">
                                                            <td><strong>Cuota Mensual</strong></td>
                                                            <td>Pago mensual durante
                                                                <?= $paymentPlan['duration_months'] ?? 'N/A' ?> meses
                                                            </td>
                                                            <td class="text-right"><strong>S/
                                                                    <?= number_format($contract['monthly_payment'] ?? 0, 2) ?></strong>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Cronograma de Pagos Resumen -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h6>Resumen de Pagos:</h6>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="card bg-success text-white">
                                                        <div class="card-body text-center">
                                                            <h4>12</h4>
                                                            <p class="mb-0">Cuotas Pagadas</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card bg-warning text-white">
                                                        <div class="card-body text-center">
                                                            <h4>24</h4>
                                                            <p class="mb-0">Cuotas Pendientes</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card bg-danger text-white">
                                                        <div class="card-body text-center">
                                                            <h4>0</h4>
                                                            <p class="mb-0">Cuotas Vencidas</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card bg-info text-white">
                                                        <div class="card-body text-center">
                                                            <h4>33%</h4>
                                                            <p class="mb-0">Avance</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row text-center btn-page p-2" id="content_actions">
                                    <div class="col-sm-12 invoice-btn-group text-center">
                                        <button type="button" onclick="window.history.back();"
                                            class="btn waves-effect waves-light btn-light">
                                            <i class="fa fa-angle-left" aria-hidden="true"></i> Regresar
                                        </button>
                                        <a href="/dashboard/inmueble/contracts/payments/<?= $contract['id'] ?? 1 ?>"
                                            class="btn waves-effect waves-light btn-info">
                                            <i class="fa fa-calendar" aria-hidden="true"></i> Ver Cronograma
                                        </a>
                                        <button type="button" onclick="printContract()"
                                            class="btn waves-effect waves-light btn-success">
                                            <i class="fa fa-print" aria-hidden="true"></i> Imprimir
                                        </button>
                                        <a href="/dashboard/inmueble/contracts/edit/<?= $contract['id'] ?? 1 ?>"
                                            class="btn waves-effect waves-light btn-warning">
                                            <i class="fa fa-edit" aria-hidden="true"></i> Editar
                                        </a>
                                        <button type="button" class="btn waves-effect waves-light btn-primary"
                                            data-toggle="modal" data-target="#modalPagoCuota">
                                            <i class="fa fa-money" aria-hidden="true"></i> Registrar Pago de Cuota
                                        </button>
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
    function printContract() {
        const printContent = document.getElementById('printTable');
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
                <html>
                    <head>
                        <title>Contrato <?= $contract['contract_number'] ?? 'N/A' ?></title>
                        <style>
                            body { font-family: Arial, sans-serif; }
                            .table { width: 100%; border-collapse: collapse; }
                            .table th, .table td { padding: 8px; text-align: left; }
                            .card { margin: 20px 0; }
                            @media print { .btn-page { display: none; } }
                        </style>
                    </head>
                    <body>
                        ${printContent.innerHTML}
                    </body>
                </html>
            `);
        printWindow.document.close();
        printWindow.print();
    }
    </script>

    <?php echo view("admin/footer"); ?>
</body>

</html>

<!-- Modal para registrar pago de cuota -->
<div class="modal fade" id="modalPagoCuota" tabindex="-1" role="dialog" aria-labelledby="modalPagoCuotaLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPagoCuotaLabel">Registrar Pago de Cuota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formPagoCuota">
                    <div class="form-group">
                        <label for="cuota_id">ID de Cuota</label>
                        <input type="number" class="form-control" id="cuota_id" name="cuota_id" required>
                    </div>
                    <div class="form-group">
                        <label for="monto">Monto</label>
                        <input type="number" step="0.01" class="form-control" id="monto" name="monto" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar y Emitir Comprobante</button>
                </form>
                <div id="resultadoPagoCuota" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('formPagoCuota').addEventListener('submit', function(e) {
    e.preventDefault();
    var cuota_id = document.getElementById('cuota_id').value;
    var monto = document.getElementById('monto').value;
    var resultado = document.getElementById('resultadoPagoCuota');
    resultado.innerHTML = 'Procesando...';
    fetch('/dashboard/inmueble/registrar_pago_cuota', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                cuota_id: cuota_id,
                monto: monto
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                resultado.innerHTML =
                    '<span class="text-success">Pago registrado y comprobante emitido correctamente.<br>PDF: <a href="' +
                    data.pdf_url + '" target="_blank">Ver PDF</a><br>XML: <a href="' + data.xml_url +
                    '" target="_blank">Ver XML</a></span>';
            } else {
                resultado.innerHTML = '<span class="text-danger">' + (data.message ||
                    'Error al registrar el pago.') + '</span>';
            }
        })
        .catch(error => {
            resultado.innerHTML = '<span class="text-danger">Error de conexión o servidor.</span>';
        });
});
</script>