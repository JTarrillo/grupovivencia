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
                                        <h5>Validación de Pagos - Cronograma</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard/panel">Panel</a></li>
                                        <li class="breadcrumb-item"><a href="/dashboard/inmueble">Gestión
                                                Inmobiliaria</a></li>
                                        <li class="breadcrumb-item"><a
                                                href="/dashboard/inmueble/contracts">Contratos</a>
                                        </li>
                                        <li class="breadcrumb-item"><a>Cronograma de Pagos</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- Card de Información del Contrato -->
                                    <div class="card mb-3">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="mb-0"><i class="feather icon-file-text"></i> Información del
                                                Contrato</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <strong>Contrato:</strong><br>
                                                    <h6><?= esc($contract['contract_number'] ?? '-') ?></h6>
                                                </div>
                                                <div class="col-md-3">
                                                    <strong>Cliente:</strong><br>
                                                    <h6><?= esc($contract['customer_name'] ?? '-') ?></h6>
                                                    <small class="text-muted">DNI:
                                                        <?= esc($contract['customer_dni'] ?? '-') ?></small>
                                                </div>
                                                <div class="col-md-3">
                                                    <strong>Lote:</strong><br>
                                                    <h6><?= esc($contract['lot_number'] ?? '-') ?></h6>
                                                    <small
                                                        class="text-muted"><?= esc($contract['project_name'] ?? '-') ?></small>
                                                </div>
                                                <div class="col-md-3">
                                                    <strong>Monto Total:</strong><br>
                                                    <h6 class="text-success">S/
                                                        <?= number_format($contract['total_amount'] ?? 0, 2) ?></h6>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <strong>Cuota Inicial:</strong><br>
                                                    S/ <?= number_format($contract['down_payment'] ?? 0, 2) ?>
                                                </div>
                                                <div class="col-md-3">
                                                    <strong>Cuota Mensual:</strong><br>
                                                    S/ <?= number_format($contract['monthly_payment'] ?? 0, 2) ?>
                                                </div>
                                                <div class="col-md-3">
                                                    <strong>Duración:</strong><br>
                                                    <?= $contract['financing_months'] ?? 0 ?> meses
                                                </div>
                                                <div class="col-md-3">
                                                    <strong>Estado:</strong><br>
                                                    <span
                                                        class="badge badge-success"><?= ucfirst($contract['status'] ?? 'Activo') ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card de Resumen de Pagos -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <div class="card bg-success text-white">
                                                <div class="card-body text-center">
                                                    <h2><?= $stats['pagados_count'] ?? 0 ?></h2>
                                                    <p class="mb-0">Pagos Validados</p>
                                                    <small>S/
                                                        <?= number_format($stats['pagados_monto'] ?? 0, 2) ?></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card bg-warning text-white">
                                                <div class="card-body text-center">
                                                    <h2><?= $stats['pendientes_count'] ?? 0 ?></h2>
                                                    <p class="mb-0">Pendientes de Validar</p>
                                                    <small>S/
                                                        <?= number_format($stats['pendientes_monto'] ?? 0, 2) ?></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card bg-info text-white">
                                                <div class="card-body text-center">
                                                    <h2><?= $stats['registrados_count'] ?? 0 ?></h2>
                                                    <p class="mb-0">Registrados (Sin Validar)</p>
                                                    <small>S/
                                                        <?= number_format($stats['registrados_monto'] ?? 0, 2) ?></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card bg-secondary text-white">
                                                <div class="card-body text-center">
                                                    <h2><?= $stats['total_count'] ?? 0 ?></h2>
                                                    <p class="mb-0">Total de Cuotas</p>
                                                    <small>S/
                                                        <?= number_format($stats['total_monto'] ?? 0, 2) ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tabla de Cronograma -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Cronograma de Pagos - Validación de Comprobantes</h5>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-striped mb-0">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Tipo</th>
                                                            <th>Fecha Vencimiento</th>
                                                            <th>Monto</th>
                                                            <th>Estado de Pago</th>
                                                            <th>Registrado</th>
                                                            <th>Fecha Pago</th>
                                                            <th>Comprobante</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($payments)): ?>
                                                        <?php foreach ($payments as $i => $pago): 
                                                                $estado = strtolower($pago['status'] ?? 'pending');
                                                                $registrado = !empty($pago['paid_date']);
                                                                $validado = ($estado === 'paid' || $estado === 'pagado');
                                                                $installment_number = $pago['installment_number'] ?? ($i + 1);
                                                            ?>
                                                        <tr
                                                            class="<?= $validado ? 'table-success' : ($registrado ? 'table-info' : '') ?>">
                                                            <td>
                                                                <strong><?= ($i + 1) ?></strong>
                                                            </td>
                                                            <td>
                                                                <?php if ($installment_number == 0): ?>
                                                                <span class="badge badge-warning">INICIAL</span>
                                                                <?php else: ?>
                                                                <span class="badge badge-primary">CUOTA
                                                                    <?= $installment_number ?></span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                    $fecha_vencimiento = $pago['due_date'] ?? null;
                                                                    echo $fecha_vencimiento ? date('d/m/Y', strtotime($fecha_vencimiento)) : '-';
                                                                    ?>
                                                            </td>
                                                            <td>
                                                                <strong>S/
                                                                    <?= number_format($pago['amount'] ?? 0, 2) ?></strong>
                                                            </td>
                                                            <td>
                                                                <?php if ($validado): ?>
                                                                <span class="badge badge-success">✓ VALIDADO</span>
                                                                <?php elseif ($registrado): ?>
                                                                <span class="badge badge-info">⏳ REGISTRADO</span>
                                                                <?php else: ?>
                                                                <span class="badge badge-danger">✗ PENDIENTE</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                    echo $registrado ? '✓' : '✗';
                                                                    ?>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                    $fecha_pago = $pago['paid_date'] ?? null;
                                                                    echo $fecha_pago ? date('d/m/Y H:i', strtotime($fecha_pago)) : '-';
                                                                    ?>
                                                            </td>
                                                            <td>
                                                                <?php if (!empty($pago['voucher_url'])): ?>
                                                                <a href="<?= base_url($pago['voucher_url']) ?>"
                                                                    target="_blank" class="btn btn-sm btn-outline-info">
                                                                    <i class="fa fa-file-pdf"></i> Ver
                                                                </a>
                                                                <?php else: ?>
                                                                <span class="text-muted">—</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group" role="group">
                                                                    <?php 
                                                                    // Mostrar Validar si: tiene voucher O está registrado, y NO está validado
                                                                    $tieneVoucher = !empty($pago['voucher_url']);
                                                                    $puedeValidar = ($registrado || $tieneVoucher) && !$validado;
                                                                    ?>
                                                                    <?php if ($puedeValidar): ?>
                                                                    <button class="btn btn-sm btn-success"
                                                                        onclick="abrirModalValidacion(<?= $pago['id'] ?>, '<?= number_format($pago['amount'], 2) ?>', '<?= !empty($pago['voucher_url']) ? base_url($pago['voucher_url']) : '' ?>')">
                                                                        <i class="fa fa-check-circle"></i> Validar
                                                                    </button>
                                                                    <?php elseif ($validado): ?>
                                                                    <button class="btn btn-sm btn-success" disabled>
                                                                        <i class="fa fa-check"></i> Validado
                                                                    </button>
                                                                    <button class="btn btn-sm btn-primary"
                                                                        onclick="generarFacturaCuota(<?= $pago['id'] ?>, <?= $contract['id'] ?>, '<?= number_format($pago['amount'], 2) ?>')">
                                                                        <i class="fa fa-file-invoice"></i> Factura
                                                                    </button>
                                                                    <?php else: ?>
                                                                    <span class="text-muted text-center"
                                                                        style="display: block;">
                                                                        <small>Esperando pago</small>
                                                                    </span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                        <?php else: ?>
                                                        <tr>
                                                            <td colspan="9" class="text-center text-muted">
                                                                No hay cuotas registradas
                                                            </td>
                                                        </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3 text-center">
                                        <a href="/dashboard/inmueble/contracts" class="btn btn-secondary">
                                            <i class="fa fa-arrow-left"></i> Volver a Contratos
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal para Validar Pago -->
    <div class="modal fade" id="validarPagoModal" tabindex="-1" role="dialog" aria-labelledby="validarPagoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="validarPagoModalLabel">
                        <i class="fa fa-check-circle"></i> Validar Pago
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="validar-pago-body">
                        <div class="text-center mb-3">
                            <h6>Monto a Validar:</h6>
                            <h3 class="text-success" id="modal-monto-pago">S/ 0.00</h3>
                        </div>

                        <!-- Mostrar comprobante del cliente si existe -->
                        <div id="comprobante-cliente-section" style="display: none;">
                            <div class="alert alert-info">
                                <strong><i class="fa fa-check"></i> Comprobante del Cliente:</strong>
                                <div id="comprobante-cliente-preview" style="margin-top: 10px;"></div>
                            </div>
                        </div>

                        <!-- Sección para subir comprobante si no existe -->
                        <div id="subir-comprobante-section" style="display: none;">
                            <div class="form-group">
                                <label for="validar-comprobante"><strong>Subir Comprobante (PDF, JPG,
                                        PNG)</strong></label>
                                <input type="file" class="form-control" id="validar-comprobante"
                                    accept=".pdf,.jpg,.jpeg,.png">
                                <small class="form-text text-muted">Máximo 5MB</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="validar-notas"><strong>Notas (Opcional)</strong></label>
                            <textarea class="form-control" id="validar-notas" rows="3"
                                placeholder="Ej: Boleta #12345, transferencia bancaria, etc."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btn-confirmar-validacion">
                        <i class="fa fa-check"></i> Validar Pago
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    let pagoIdActual = null;
    let comprobanteUrlActual = null;

    function abrirModalValidacion(pagoId, monto, comprobanteUrl = null) {
        pagoIdActual = pagoId;
        comprobanteUrlActual = comprobanteUrl;

        // DEBUG: Registrar en consola
        console.log('=== MODAL VALIDACION DEBUG ===');
        console.log('Pago ID:', pagoId);
        console.log('Monto:', monto);
        console.log('Comprobante URL recibida:', comprobanteUrl);
        console.log('Tipo:', typeof comprobanteUrl);
        console.log('Vacía?:', comprobanteUrl === '' || comprobanteUrl === null);

        document.getElementById('modal-monto-pago').textContent = 'S/ ' + monto;
        document.getElementById('validar-notas').value = '';

        // Mostrar/ocultar secciones según si existe comprobante
        const comprobanteClienteSection = document.getElementById('comprobante-cliente-section');
        const subirComprobanteSection = document.getElementById('subir-comprobante-section');
        const comprobanteClientePreview = document.getElementById('comprobante-cliente-preview');

        if (comprobanteUrl) {
            console.log('Mostrando comprobante del cliente...');
            // Mostrar comprobante del cliente
            comprobanteClienteSection.style.display = 'block';
            subirComprobanteSection.style.display = 'none';

            // Detectar tipo de archivo
            const ext = comprobanteUrl.toLowerCase().split('.').pop();
            console.log('Extensión detectada:', ext);
            console.log('URL completa a cargar:', comprobanteUrl);

            if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) {
                // Imagen
                comprobanteClientePreview.innerHTML = `
                        <img src="${comprobanteUrl}" style="max-width: 100%; max-height: 300px; border-radius: 8px;" alt="Comprobante" onerror="console.log('Error cargando imagen desde:', '${comprobanteUrl}')">
                    `;
            } else if (ext === 'pdf') {
                // PDF
                comprobanteClientePreview.innerHTML = `
                        <div style="text-align: center;">
                            <i class="fa fa-file-pdf" style="font-size: 48px; color: #dc3545;"></i>
                            <br>
                            <a href="${comprobanteUrl}" target="_blank" class="btn btn-sm btn-danger mt-2">
                                <i class="fa fa-download"></i> Descargar PDF
                            </a>
                        </div>
                    `;
            } else {
                // Archivo genérico
                comprobanteClientePreview.innerHTML = `
                        <div style="text-align: center;">
                            <i class="fa fa-file" style="font-size: 48px; color: #999;"></i>
                            <br>
                            <a href="${comprobanteUrl}" target="_blank" class="btn btn-sm btn-primary mt-2">
                                <i class="fa fa-download"></i> Descargar
                            </a>
                        </div>
                    `;
            }
        } else {
            console.log('No hay comprobante, mostrando formulario para subir...');
            // No hay comprobante, permitir subir
            comprobanteClienteSection.style.display = 'none';
            subirComprobanteSection.style.display = 'block';
            document.getElementById('validar-comprobante').value = '';
        }

        $('#validarPagoModal').modal('show');
    }

    document.getElementById('btn-confirmar-validacion').addEventListener('click', function() {
        if (!pagoIdActual) {
            Swal.fire('Error', 'No se especificó el pago a validar', 'error');
            return;
        }

        const comprobanteInput = document.getElementById('validar-comprobante');
        const notas = document.getElementById('validar-notas').value;
        let comprobante = null;

        // Si no existe comprobante del cliente, validar que el admin lo suba
        if (!comprobanteUrlActual) {
            if (comprobanteInput.files.length === 0) {
                Swal.fire('Error', 'Debe subir un comprobante', 'error');
                return;
            }
            comprobante = comprobanteInput.files[0];

            // Validar tamaño
            if (comprobante.size > 5 * 1024 * 1024) {
                Swal.fire('Error', 'El archivo no debe exceder 5MB', 'error');
                return;
            }
        }

        const formData = new FormData();
        formData.append('id_pago', pagoIdActual);
        formData.append('notas', notas);
        if (comprobante) {
            formData.append('comprobante', comprobante);
        }

        const btn = document.getElementById('btn-confirmar-validacion');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Validando...';

        fetch('<?= site_url("/dashboard/inmueble/validar_pago") ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                $('#validarPagoModal').modal('hide');

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Pago Validado!',
                        text: data.message || 'El pago ha sido validado correctamente',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', data.message || 'No se pudo validar el pago', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Error en la conexión', 'error');
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa fa-check"></i> Validar Pago';
            });
    });

    // Función para generar factura de una cuota específica
    function generarFacturaCuota(pagoId, contractId, monto) {
        Swal.fire({
            title: '¿Generar Factura?',
            text: 'Se generará una factura por S/ ' + monto,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Generar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Llamar a la función generarFacturaContrato del archivo contracts.php
                // o enviar una petición al servidor
                fetch('<?= site_url("/dashboard/inmueble/generar_factura_cuota") ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            pago_id: pagoId,
                            contract_id: contractId,
                            monto: monto
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Factura Generada!',
                                text: 'La factura se ha generado correctamente',
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                if (data.download_url) {
                                    window.open(data.download_url, '_blank');
                                }
                            });
                        } else {
                            Swal.fire('Error', data.message || 'No se pudo generar la factura', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'Error en la conexión', 'error');
                    });
            }
        });
    }
    </script>
</body>

</html>