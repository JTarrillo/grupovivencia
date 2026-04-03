<?php echo view("backoffice_new/head"); ?>

<body data-kt-name="metronic" id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
    <?php echo view("backoffice_new/header"); ?>
    <?php echo view("backoffice_new/toolbar", ['title' => 'Cronograma de Pagos']); ?>
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
                    <div class="content flex-row-fluid" id="kt_content">
                        <!-- Card resumen -->
                        <div class="card mb-8"
                            style="background: linear-gradient(90deg, #7f7fd5 0%, #86a8e7 100%); color: #fff;">
                            <div class="card-body d-flex flex-row justify-content-between align-items-center">
                                <div>
                                    <h3 class="fw-bold mb-1">Cronograma de Pagos</h3>
                                    <div>Contrato: <b><?= esc($contract['code'] ?? '') ?></b></div>
                                    <div class="fs-7">Total: S/ <?= number_format($contract['total'] ?? 0, 2) ?> |
                                        Cuota: S/
                                        <?= number_format($contract['cuota_mensual'] ?? 0, 5) ?>/mes</div>
                                </div>
                                <?php if (!empty($contract) && isset($contract['id'])): ?>
                                <a href="<?= site_url('backoffice_new/contracts/detail/' . esc($contract['id'])) ?>"
                                    class="btn btn-light text-dark"><i class="fa fa-arrow-left"></i> Volver al
                                    Contrato</a>
                                <?php else: ?>
                                <a href="#" class="btn btn-light text-dark disabled"><i class="fa fa-arrow-left"></i>
                                    Volver al Contrato</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4 mb-2">
                                <div class="card bg-success text-white shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="fs-2 fw-bold"><i
                                                class="fa fa-check-circle me-2"></i><?= esc($pagos_realizados ?? 0) ?>
                                        </div>
                                        <div class="fs-6">Pagos Realizados</div>
                                        <div class="fs-7">S/ <?= number_format($monto_realizado ?? 0, 2) ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="card bg-warning text-white shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="fs-2 fw-bold"><i
                                                class="fa fa-clock me-2"></i><?= esc($pagos_pendientes ?? 0) ?></div>
                                        <div class="fs-6">Pagos Pendientes</div>
                                        <div class="fs-7">S/ <?= number_format($monto_pendiente ?? 0, 2) ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="card bg-primary text-white shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="fs-2 fw-bold"><i
                                                class="fa fa-chart-line me-2"></i><?= round(($pagos_realizados / max(1, $total_pagos)) * 100) ?>%
                                        </div>
                                        <div class="fs-6">Progreso Total</div>
                                        <div class="fs-7"><?= esc($pagos_realizados) ?> de <?= esc($total_pagos) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card tabla cronograma -->
                        <div class="card mb-8">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold mb-0">Detalle de Pagos <span class="text-muted fs-7">Cronograma
                                        completo de cuotas</span>
                                </h5>
                                <button class="btn btn-primary" onclick="window.print()"><i class="fa fa-print"></i>
                                    Imprimir</button>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <style>
                                    .table-compact th,
                                    .table-compact td {
                                        padding: 0.35rem 0.5rem !important;
                                        font-size: 0.95rem;
                                        vertical-align: middle !important;
                                    }

                                    .table-compact th {
                                        font-weight: 600;
                                    }

                                    .badge {
                                        font-size: 0.85rem;
                                        padding: 0.25em 0.7em;
                                        border-radius: 0.5em;
                                    }

                                    .btn-sm {
                                        padding: 0.15rem 0.35rem !important;
                                        font-size: 0.85rem !important;
                                        height: 1.7em;
                                        width: 1.7em;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                    }

                                    .table-compact tr {
                                        height: 2.1em;
                                    }
                                    </style>
                                    <table class="table table-hover table-compact mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Tipo</th>
                                                <th>Fecha Vencimiento</th>
                                                <th>Importe</th>
                                                <th>Estado</th>
                                                <th>Fecha Pago</th>
                                                <th>Saldo</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cronograma as $i => $pago): ?>
                                            <tr>
                                                <td><?= $pago['numero'] ?? ($i == 0 ? 'INICIAL' : str_pad($i, 2, '0', STR_PAD_LEFT)) ?>
                                                </td>
                                                <td>
                                                    <?php if ($i == 0): ?>
                                                    <span class="text-primary fw-bold"><i class="fa fa-star"></i>
                                                        Inicial</span>
                                                    <?php else: ?>
                                                    <span class="text-info"><i class="fa fa-calendar"></i>
                                                        Cuota</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    // Map DB field to expected key
                                                    $fecha_vencimiento = $pago['fecha_vencimiento'] ?? $pago['due_date'] ?? null;
                                                    ?>
                                                    <?= $fecha_vencimiento ? date('d/m/Y', strtotime($fecha_vencimiento)) : '-' ?>
                                                    <span class="text-muted fs-7">
                                                        <?= $fecha_vencimiento ? date('l', strtotime($fecha_vencimiento)) : '-' ?></span>
                                                </td>
                                                </td>
                                                <td class="fw-bold"
                                                    style="color:<?= $i == 0 ? '#f59e0b' : '#22c55e' ?>;">
                                                    <?php
                                                    // Map DB field to expected key
                                                    $importe = $pago['importe'] ?? $pago['amount'] ?? 0;
                                                    ?>
                                                    S/ <?= number_format($importe, 2) ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    // Map DB field to expected key
                                                    $estado = $pago['estado'] ?? $pago['status'] ?? '';
                                                    // Normalizar estado a inglés
                                                    $estado = strtolower($estado);
                                                    ?>
                                                    <?php if ($estado == 'paid' || $estado == 'pagado'): ?>
                                                    <span class="badge bg-success">✓ Pagado</span>
                                                    <?php elseif ($estado == 'registered'): ?>
                                                    <span class="badge bg-info">⏳ Registrado</span>
                                                    <?php else: ?>
                                                    <span class="badge bg-warning">Pendiente</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    // Map DB field to expected key
                                                    $fecha_pago = $pago['fecha_pago'] ?? $pago['paid_date'] ?? null;
                                                    ?>
                                                    <?= $fecha_pago ? date('d/m/Y', strtotime($fecha_pago)) : '-' ?>
                                                </td>
                                                </td>
                                                <td>
                                                    <?php
                                                    // Map DB field to expected key
                                                    $saldo = $pago['saldo'] ?? $pago['balance'] ?? 0;
                                                    ?>
                                                    S/ <?= number_format($saldo, 2) ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    // Map DB field to expected key
                                                    $estado_btn = $pago['estado'] ?? $pago['status'] ?? '';
                                                    // Normalizar estado a inglés
                                                    $estado_btn = strtolower($estado_btn);
                                                    ?>
                                                    <?php if ($estado_btn == 'paid' || $estado_btn == 'pagado'): ?>
                                                    <button
                                                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"
                                                        title="Pago validado por admin"><i
                                                            class="fa fa-check"></i></button>
                                                    <?php elseif ($estado_btn == 'registered'): ?>
                                                    <button
                                                        class="btn btn-icon btn-bg-light btn-active-color-warning btn-sm"
                                                        title="Pago registrado, esperando validación"><i
                                                            class="fa fa-hourglass-half"></i></button>
                                                    <?php else: ?>
                                                    <button
                                                        class="btn btn-icon btn-bg-light btn-active-color-success btn-sm"
                                                        onclick="abrirModalPagoCuota('<?= $pago['id'] ?? $i ?>', '<?= number_format($importe, 2) ?>', '<?= date('d/m/Y', strtotime($fecha_vencimiento)) ?>')">
                                                        <i class="fa fa-money-bill"></i>
                                                    </button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
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
    <script src="<?php echo site_url() . 'assets/metronic8/plugins/global/plugins.bundle.js'; ?>"></script>
    <script src="<?php echo site_url() . 'assets/metronic8/js/scripts.bundle.js'; ?>"></script>
    <script src="<?php echo site_url() . 'assets/metronic8/plugins/custom/datatables/datatables.bundle.js?123'; ?>">
    </script>
    <script src="<?php echo site_url() . 'assets/metronic8/plugins/custom/prismjs/prismjs.bundle.js'; ?>"></script>
    <script src="<?php echo site_url() . 'assets/metronic8/js/widgets.bundle.js'; ?>"></script>
    <script src="<?php echo site_url() . 'assets/metronic8/js/custom/widgets.js'; ?>"></script>
</body>

<!-- Modal Pago de Cuota -->
<div id="modal-pago-cuota" class="modal-custom" style="display:none;">
    <div class="modal-content-custom modal-content-compact">
        <div class="modal-header-custom"
            style="background: linear-gradient(90deg, #7f7fd5 0%, #86a8e7 100%); border-radius: 16px 16px 0 0; color: #fff; padding-bottom: 10px;">
            <span class="modal-icon-custom"><i class="fa fa-money-bill-wave fa-2x text-light"></i></span>
            <h3 class="fw-bold mb-1" style="font-size:1.25rem;">Registrar pago de cuota</h3>
        </div>
        <div class="modal-body-custom" style="padding-top: 10px;">
            <div class="mb-2 text-center">
                <img src="<?php echo site_url('assets/front/img/gest.jpg'); ?>" alt="QR"
                    style="max-width:120px; border:2px solid #e3e6ef; border-radius:12px; box-shadow:0 2px 8px #0001;">
                <div class="mt-2"><span class="badge bg-gradient-info px-3 py-2">Escanea el QR desde tu app
                        bancaria</span></div>
            </div>
            <div class="mb-2 text-center">
                <img src="<?php echo site_url('assets/front/img/bbva-logo.png'); ?>" alt="BBVA"
                    style="height:28px;vertical-align:middle;">
                <span class="fw-bold ms-2" style="font-size:1.08rem;">GRUPO VIVENCIA S.A.C</span><br>
                <span class="fw-bold text-primary" style="font-size:1.08rem;">0011 0083 0200310937 34</span>
                <button class="btn btn-xs btn-light ms-1 py-0 px-2" style="font-size:0.98rem;"
                    onclick="copiarCuenta()"><i class="fa fa-copy"></i> Copiar</button>
                <div class="text-muted" style="font-size:0.93rem;">RUC: 20612232998</div>
            </div>
            <div class="mb-2 text-center">
                <span class="fw-bold text-success" style="font-size:1.08rem;">Monto: <span
                        id="modal-cuota-monto"></span></span>
            </div>
            <div class="mb-2 text-center">
                <span class="fw-bold" style="font-size:1.05rem;">Vencimiento: <span
                        id="modal-cuota-vencimiento"></span></span>
            </div>
            <div class="mb-2 text-center">
                <label class="form-label" style="font-size:0.97rem;">Adjunta tu comprobante (opcional):</label>
                <input type="file" class="form-control form-control-sm" id="input-cuota-comprobante"
                    style="max-width:220px;margin:auto;">
            </div>
        </div>
        <div class="modal-footer-custom" style="margin-top:10px;">
            <div class="modal-footer-btns">
                <button type="button" class="btn btn-success btn-lg" id="btn-registrar-pago-cuota">Registrar
                    pago</button>
                <button type="button" class="btn btn-secondary btn-lg"
                    onclick="cerrarModalPagoCuota()">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<style>
.modal-custom {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.18);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.modal-custom.show {
    display: flex !important;
}

.modal-content-custom {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 32px #0002;
    padding: 32px 18px 18px 18px;
    min-width: 260px;
    max-width: 98vw;
    width: 100%;
    position: relative;
    animation: modalIn 0.2s;
}

.modal-content-compact {
    padding: 18px 8px 10px 8px !important;
    max-width: 370px !important;
    min-width: 0 !important;
}
}

@keyframes modalIn {}

.modal-footer-btns {
    display: flex;
    justify-content: center;
    gap: 18px;
    margin-top: 12px;
    margin-bottom: 2px;
}

.modal-footer-btns .btn {
    min-width: 120px;
    font-size: 1.08rem;
    font-weight: 500;
    border-radius: 8px;
    box-shadow: 0 2px 8px #0001;
}

@media (max-width: 575.98px) {
    .modal-footer-btns .btn {
        min-width: 90px;
        font-size: 0.98rem;
        padding: 0.5rem 0.7rem;
    }

    .modal-content-compact {
        max-width: 98vw !important;
    }

    from {
        transform: scale(0.95);
        opacity: 0;
    }

    to {
        transform: scale(1);
        opacity: 1;
    }
}
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let cuotaIdActual = null;

    window.abrirModalPagoCuota = function(idCuota, monto, vencimiento) {
        cuotaIdActual = idCuota;
        document.getElementById('modal-cuota-monto').textContent = 'S/ ' + monto;
        document.getElementById('modal-cuota-vencimiento').textContent = vencimiento;
        document.getElementById('modal-pago-cuota').classList.add('show');
    }

    window.cerrarModalPagoCuota = function() {
        document.getElementById('modal-pago-cuota').classList.remove('show');
    }

    window.copiarCuenta = function() {
        navigator.clipboard.writeText('0011 0083 0200310937 34');
        Swal.fire('Copiado', 'Número de cuenta copiado', 'success');
    }

    document.getElementById('btn-registrar-pago-cuota').onclick = function() {
        var btn = document.getElementById('btn-registrar-pago-cuota');
        btn.disabled = true;
        var comprobanteInput = document.getElementById('input-cuota-comprobante');
        var comprobante = comprobanteInput.files.length > 0 ? comprobanteInput.files[0] : null;
        var formData = new FormData();
        formData.append('id_cuota', cuotaIdActual);
        if (comprobante) formData.append('comprobante', comprobante);
        fetch('<?php echo site_url('backoffice_new/contracts/registrarPagoCuota'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Respuesta pago cuota:', data); // <-- Depuración
                cerrarModalPagoCuota();
                let msg = data.message || (data.success ? 'Tu pago será validado.' :
                    'Intenta nuevamente.');
                if (data.error) {
                    msg += '\nDetalle: ' + data.error;
                }
                Swal.fire({
                    icon: data.success ? 'success' : 'error',
                    title: data.success ? '¡Pago registrado!' : 'Error',
                    text: msg,
                    confirmButtonText: 'Aceptar'
                }).then(function() {
                    if (data.success) location.reload();
                });
            })
            .catch(error => {
                cerrarModalPagoCuota();
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: error ? error.toString() : '',
                    confirmButtonText: 'Aceptar'
                });
            })
            .finally(function() {
                btn.disabled = false;
            });
    };
});
</script>
</body>