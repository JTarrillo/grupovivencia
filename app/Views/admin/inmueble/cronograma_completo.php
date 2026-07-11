<?php echo view("admin/head"); ?>

<body data-new-gr-c-s-check-loaded="14.1042.0" data-gr-ext-installed="">
    <?php echo view("admin/header"); ?>
    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="page-header"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 2.5rem; border-radius: 14px; margin-bottom: 2rem; box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="page-header-title">
                                        <h3 style="color: white; font-weight: 700; margin: 0; font-size: 1.8rem;">
                                            <i class="feather icon-calendar" style="margin-right: 14px;"></i>Validación
                                            de Pagos - Cronograma
                                        </h3>
                                        <p
                                            style="color: rgba(255,255,255,0.95); margin: 8px 0 0 0; font-size: 0.95rem;">
                                            Gestiona y valida los pagos de tu contrato</p>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div
                                        style="background: rgba(255,255,255,0.15); border-radius: 10px; padding: 1rem; backdrop-filter: blur(10px);">
                                        <div style="text-align: right; color: white;">
                                            <div style="font-size: 0.85rem; opacity: 0.9;">Contrato</div>
                                            <div style="font-size: 1.3rem; font-weight: 700;">
                                                <?= esc($contract['contract_number'] ?? '-') ?></div>
                                            <div style="font-size: 0.8rem; margin-top: 8px; opacity: 0.85;">
                                                <?= esc($contract['customer_name'] ?? '-') ?></div>
                                            <div style="font-size: 0.75rem; opacity: 0.8;">DNI:
                                                <?= esc($contract['customer_dni'] ?? '-') ?></div>
                                        </div>
                                    </div>
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

                                    <!-- Card de Acciones del Contrato -->
                                    <div class="card mb-4 border-0 shadow-sm">
                                        <div class="card-header bg-gradient"
                                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 1.2rem;">
                                            <h5 class="mb-0" style="color: white; font-weight: 600;">
                                                <i class="feather icon-settings"></i> Acciones del Contrato
                                            </h5>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="row g-3">
                                                <div class="col-md-3 col-sm-6">
                                                    <button
                                                        class="btn btn-info btn-block btn-lg d-flex align-items-center justify-content-center"
                                                        onclick="abrirDetallesPagos('<?= $contract['id'] ?>')"
                                                        style="height: 60px; font-size: 0.95rem; border-radius: 10px; transition: all 0.3s;">
                                                        <i class="fa fa-list mr-2"></i>
                                                        <span>Detalle de Pagos</span>
                                                    </button>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <button
                                                        class="btn btn-primary btn-block btn-lg d-flex align-items-center justify-content-center"
                                                        onclick="abrirVerContrato('<?= $contract['id'] ?>')"
                                                        style="height: 60px; font-size: 0.95rem; border-radius: 10px; transition: all 0.3s;">
                                                        <i class="fa fa-eye mr-2"></i>
                                                        <span>Ver Contrato</span>
                                                    </button>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <button
                                                        class="btn btn-warning btn-block btn-lg d-flex align-items-center justify-content-center"
                                                        onclick="abrirEditarContrato('<?= $contract['id'] ?>')"
                                                        style="height: 60px; font-size: 0.95rem; border-radius: 10px; transition: all 0.3s;">
                                                        <i class="fa fa-edit mr-2"></i>
                                                        <span>Editar Contrato</span>
                                                    </button>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <button
                                                        class="btn btn-success btn-block btn-lg d-flex align-items-center justify-content-center"
                                                        onclick="printContract('<?= $contract['id'] ?>')"
                                                        style="height: 60px; font-size: 0.95rem; border-radius: 10px; transition: all 0.3s;">
                                                        <i class="fa fa-print mr-2"></i>
                                                        <span>Imprimir</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card de Resumen de Pagos -->
                                    <div class="row mb-4">
                                        <div class="col-md-3 mb-3">
                                            <div class="card"
                                                style="border: none; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 16px rgba(45, 206, 137, 0.2); transition: transform 0.3s ease, box-shadow 0.3s ease; background: linear-gradient(135deg, #2dce89 0%, #10b981 100%);"
                                                onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 8px 24px rgba(45, 206, 137, 0.35)'"
                                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(45, 206, 137, 0.2)'">
                                                <div class="card-body text-center text-white p-4">
                                                    <div style="font-size: 2.5rem; margin-bottom: 12px;">
                                                        <i class="fa fa-check-circle"></i>
                                                    </div>
                                                    <h2 style="font-size: 2.5rem; font-weight: 700; margin: 0;">
                                                        <?= $stats['pagados_count'] ?? 0 ?></h2>
                                                    <p class="mb-0" style="font-weight: 600; margin-top: 8px;">Pagos
                                                        Validados</p>
                                                    <small style="opacity: 0.95;">S/
                                                        <?= number_format($stats['pagados_monto'] ?? 0, 2) ?></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="card"
                                                style="border: none; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 16px rgba(255, 184, 28, 0.2); transition: transform 0.3s ease, box-shadow 0.3s ease; background: linear-gradient(135deg, #ffb71d 0%, #ffa500 100%);"
                                                onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 8px 24px rgba(255, 184, 28, 0.35)'"
                                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(255, 184, 28, 0.2)'">
                                                <div class="card-body text-center text-dark p-4">
                                                    <div style="font-size: 2.5rem; margin-bottom: 12px; color: #333;">
                                                        <i class="fa fa-clock"></i>
                                                    </div>
                                                    <h2
                                                        style="font-size: 2.5rem; font-weight: 700; margin: 0; color: #333;">
                                                        <?= $stats['pendientes_count'] ?? 0 ?></h2>
                                                    <p class="mb-0"
                                                        style="font-weight: 600; margin-top: 8px; color: #555;">
                                                        Pendientes de Validar</p>
                                                    <small style="color: #666;">S/
                                                        <?= number_format($stats['pendientes_monto'] ?? 0, 2) ?></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="card"
                                                style="border: none; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 16px rgba(17, 205, 239, 0.2); transition: transform 0.3s ease, box-shadow 0.3s ease; background: linear-gradient(135deg, #11cdef 0%, #00bcd4 100%);"
                                                onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 8px 24px rgba(17, 205, 239, 0.35)'"
                                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(17, 205, 239, 0.2)'">
                                                <div class="card-body text-center text-white p-4">
                                                    <div style="font-size: 2.5rem; margin-bottom: 12px;">
                                                        <i class="fa fa-file-alt"></i>
                                                    </div>
                                                    <h2 style="font-size: 2.5rem; font-weight: 700; margin: 0;">
                                                        <?= $stats['registrados_count'] ?? 0 ?></h2>
                                                    <p class="mb-0" style="font-weight: 600; margin-top: 8px;">
                                                        Registrados (Sin Validar)</p>
                                                    <small style="opacity: 0.95;">S/
                                                        <?= number_format($stats['registrados_monto'] ?? 0, 2) ?></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="card"
                                                style="border: none; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 16px rgba(141, 92, 230, 0.2); transition: transform 0.3s ease, box-shadow 0.3s ease; background: linear-gradient(135deg, #8d5ce6 0%, #6c63ff 100%);"
                                                onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 8px 24px rgba(141, 92, 230, 0.35)'"
                                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(141, 92, 230, 0.2)'">
                                                <div class="card-body text-center text-white p-4">
                                                    <div style="font-size: 2.5rem; margin-bottom: 12px;">
                                                        <i class="fa fa-list"></i>
                                                    </div>
                                                    <h2 style="font-size: 2.5rem; font-weight: 700; margin: 0;">
                                                        <?= $stats['total_count'] ?? 0 ?></h2>
                                                    <p class="mb-0" style="font-weight: 600; margin-top: 8px;">Total de
                                                        Cuotas</p>
                                                    <small style="opacity: 0.95;">S/
                                                        <?= number_format($stats['total_monto'] ?? 0, 2) ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Resumen de Progreso - Barra Visual -->
                                    <div class="card mb-4"
                                        style="border: none; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); overflow: hidden; background: linear-gradient(135deg, #f5f7fa 0%, #f9fafb 100%);">
                                        <div class="card-body p-4">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <h5 style="margin-bottom: 1.5rem; font-weight: 700; color: #333;">
                                                        <i class="fa fa-chart-bar"
                                                            style="margin-right: 10px; color: #667eea;"></i>Progreso de
                                                        Pago
                                                    </h5>

                                                    <?php 
                                                        $totalContrato = $contract['total_amount'] ?? 0;
                                                        $totalPagado = $stats['pagados_monto'] ?? 0;
                                                        $totalPendiente = $stats['pendientes_monto'] + $stats['registrados_monto'];
                                                        $porcentajePagado = $totalContrato > 0 ? round(($totalPagado / $totalContrato) * 100) : 0;
                                                    ?>

                                                    <div class="mb-3">
                                                        <div
                                                            style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                                            <span style="font-weight: 600; color: #333;">Monto
                                                                Pagado</span>
                                                            <span style="font-weight: 700; color: #2dce89;">S/
                                                                <?= number_format($totalPagado, 2) ?></span>
                                                        </div>
                                                        <div
                                                            style="background: #e9ecef; border-radius: 10px; height: 28px; overflow: hidden; position: relative;">
                                                            <div
                                                                style="background: linear-gradient(90deg, #2dce89 0%, #10b981 100%); height: 100%; width: <?= $porcentajePagado ?>%; transition: width 0.6s ease; display: flex; align-items: center; justify-content: flex-end; padding-right: 10px; border-radius: 10px;">
                                                                <span
                                                                    style="color: white; font-weight: 700; font-size: 0.85rem;"><?= $porcentajePagado ?>%</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <div
                                                            style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                                            <span style="font-weight: 600; color: #333;">Saldo
                                                                Pendiente</span>
                                                            <span style="font-weight: 700; color: #ff5252;">S/
                                                                <?= number_format($totalPendiente, 2) ?></span>
                                                        </div>
                                                        <div
                                                            style="background: #e9ecef; border-radius: 10px; height: 28px; overflow: hidden; position: relative;">
                                                            <div
                                                                style="background: linear-gradient(90deg, #ff5252 0%, #ff1744 100%); height: 100%; width: <?= (100 - $porcentajePagado) ?>%; transition: width 0.6s ease; display: flex; align-items: center; justify-content: flex-end; padding-right: 10px; border-radius: 10px;">
                                                                <span
                                                                    style="color: white; font-weight: 700; font-size: 0.85rem;"><?= (100 - $porcentajePagado) ?>%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div
                                                        style="background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                                                        <div style="text-align: center;">
                                                            <div
                                                                style="font-size: 2.2rem; font-weight: 700; color: #667eea; margin-bottom: 8px;">
                                                                <?= $porcentajePagado ?>%
                                                            </div>
                                                            <div
                                                                style="font-size: 0.9rem; color: #666; margin-bottom: 1rem;">
                                                                Completado
                                                            </div>
                                                            <hr style="margin: 1rem 0;">
                                                            <div style="font-size: 0.85rem; color: #999;">
                                                                Total: <strong
                                                                    style="color: #333; font-size: 0.95rem;">S/
                                                                    <?= number_format($totalContrato, 2) ?></strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tabla de Cronograma -->
                                    <ul class="breadcrumb"
                                        style="margin: 0 0 1.5rem 0; padding: 1rem; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #667eea;">
                                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard/panel') ?>"
                                                style="color: #667eea; font-weight: 500;">Panel</a></li>
                                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard/inmueble') ?>"
                                                style="color: #667eea; font-weight: 500;">Gestión Inmobiliaria</a></li>
                                        <li class="breadcrumb-item"><a
                                                href="<?= site_url('dashboard/inmueble/contracts') ?>"
                                                style="color: #667eea; font-weight: 500;">Contratos</a></li>
                                        <li class="breadcrumb-item active" style="color: #764ba2; font-weight: 600;">
                                            Cronograma de Pagos</li>
                                    </ul>
                                    <div class="card"
                                        style="border: none; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.1); overflow: hidden;">
                                        <div class="card-header"
                                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 1.5rem;">
                                            <h5 style="color: white; margin: 0; font-weight: 700; font-size: 1.1rem;">
                                                <i class="feather icon-check-square"
                                                    style="margin-right: 10px;"></i>Cronograma de Pagos - Validación de
                                                Comprobantes
                                            </h5>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0"
                                                    style="border-collapse: collapse;">
                                                    <thead
                                                        style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                                                        <tr>
                                                            <th
                                                                style="padding: 1rem; font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                                                #</th>
                                                            <th
                                                                style="padding: 1rem; font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                                                Tipo</th>
                                                            <th
                                                                style="padding: 1rem; font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                                                Fecha Vencimiento</th>
                                                            <th
                                                                style="padding: 1rem; font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                                                Monto</th>
                                                            <th
                                                                style="padding: 1rem; font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                                                Saldo</th>
                                                            <th
                                                                style="padding: 1rem; font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                                                Estado de Pago</th>
                                                            <th
                                                                style="padding: 1rem; font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                                                Registrado</th>
                                                            <th
                                                                style="padding: 1rem; font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                                                Fecha Pago</th>
                                                            <th
                                                                style="padding: 1rem; font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                                                Comprobante</th>
                                                            <th
                                                                style="padding: 1rem; font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                                                Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($payments)): ?>
                                                        <?php 
                                                                $totalAmount = $contract['total_amount'] ?? 0;
                                                                $saldoAcumulado = $totalAmount;
                                                                foreach ($payments as $i => $pago):
                                                                    $estado = strtolower($pago['status'] ?? 'pending');
                                                                    $registrado = !empty($pago['paid_date']);
                                                                    $validado = ($estado === 'paid' || $estado === 'pagado');
                                                                    $installment_number = $pago['installment_number'] ?? ($i + 1);
                                                                    
                                                                    // Restar esta cuota del saldo acumulado (así va bajando mes a mes)
                                                                    $saldoAcumulado -= ($pago['amount'] ?? 0);
                                                                    $saldoActual = max(0, $saldoAcumulado);
                                                            ?>
                                                        <tr style="border-bottom: 1px solid #e9ecef; transition: background-color 0.3s ease;"
                                                            onmouseover="this.style.backgroundColor='#f8f9fa'"
                                                            onmouseout="this.style.backgroundColor='white'">
                                                            <td style="padding: 1rem; vertical-align: middle;">
                                                                <strong
                                                                    style="color: #667eea; font-size: 1.1rem;"><?= ($i + 1) ?></strong>
                                                            </td>
                                                            <td style="padding: 1rem; vertical-align: middle;">
                                                                <?php if ($installment_number == 0): ?>
                                                                <span class="badge"
                                                                    style="background: linear-gradient(135deg, #ffb71d 0%, #ffa500 100%); color: #333; padding: 8px 12px; font-weight: 600; border-radius: 8px; font-size: 0.8rem;">INICIAL</span>
                                                                <?php else: ?>
                                                                <span class="badge"
                                                                    style="background: linear-gradient(135deg, #11cdef 0%, #00bcd4 100%); color: white; padding: 8px 12px; font-weight: 600; border-radius: 8px; font-size: 0.8rem;">CUOTA
                                                                    <?= $installment_number ?></span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td
                                                                style="padding: 1rem; vertical-align: middle; color: #555; font-weight: 500;">
                                                                <?php
                                                                        $fecha_vencimiento = $pago['due_date'] ?? null;
                                                                        echo $fecha_vencimiento ? date('d/m/Y', strtotime($fecha_vencimiento)) : '-';
                                                                        ?>
                                                            </td>
                                                            <td style="padding: 1rem; vertical-align: middle;">
                                                                <strong style="color: #2dce89; font-size: 1rem;">S/
                                                                    <?= number_format($pago['amount'] ?? 0, 2) ?></strong>
                                                            </td>
                                                            <td style="padding: 1rem; vertical-align: middle;">
                                                                <strong style="color: #667eea; font-size: 1rem;">S/
                                                                    <?= number_format(max(0, $saldoActual), 2) ?></strong>
                                                            </td>
                                                            <td style="padding: 1rem; vertical-align: middle;">
                                                                <?php if ($validado): ?>
                                                                <span class="badge"
                                                                    style="background: linear-gradient(135deg, #2dce89 0%, #10b981 100%); color: white; padding: 8px 12px; font-weight: 600; border-radius: 8px; font-size: 0.8rem;">✓
                                                                    VALIDADO</span>
                                                                <?php elseif ($registrado): ?>
                                                                <span class="badge"
                                                                    style="background: linear-gradient(135deg, #11cdef 0%, #00bcd4 100%); color: white; padding: 8px 12px; font-weight: 600; border-radius: 8px; font-size: 0.8rem;">⏳
                                                                    REGISTRADO</span>
                                                                <?php else: ?>
                                                                <span class="badge"
                                                                    style="background: linear-gradient(135deg, #ff5252 0%, #ff1744 100%); color: white; padding: 8px 12px; font-weight: 600; border-radius: 8px; font-size: 0.8rem;">✗
                                                                    PENDIENTE</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td
                                                                style="padding: 1rem; vertical-align: middle; text-align: center; font-weight: 600; color: #667eea;">
                                                                <?php
                                                                        echo $registrado ? '<i class="fa fa-check" style="color: #2dce89; font-size: 1.2rem;"></i>' : '<i class="fa fa-times" style="color: #ff5252; font-size: 1.2rem;"></i>';
                                                                        ?>
                                                            </td>
                                                            <td
                                                                style="padding: 1rem; vertical-align: middle; color: #555; font-size: 0.95rem;">
                                                                <?php
                                                                        $fecha_pago = $pago['paid_date'] ?? null;
                                                                        echo $fecha_pago ? date('d/m/Y H:i', strtotime($fecha_pago)) : '-';
                                                                        ?>
                                                            </td>
                                                            <td style="padding: 1rem; vertical-align: middle;">
                                                                <?php if (!empty($pago['voucher_url'])): ?>
                                                                <?php 
                                                                                // La URL ya está guardada completa en la BD
                                                                                // Si no empieza con / o http, agregarle el base URL
                                                                                $comprobanteUrlFull = $pago['voucher_url'];
                                                                                
                                                                                // Si es una ruta relativa, construirla correctamente
                                                                                if (strpos($comprobanteUrlFull, '/') !== 0 && strpos($comprobanteUrlFull, 'http') !== 0) {
                                                                                    $comprobanteUrlFull = site_url($comprobanteUrlFull);
                                                                                } elseif (strpos($comprobanteUrlFull, '/') === 0) {
                                                                                    // Si empieza con /, convertir a URL completa
                                                                                    $comprobanteUrlFull = site_url(ltrim($comprobanteUrlFull, '/'));
                                                                                }
                                                                                
                                                                                echo "<script>console.log('📄 Comprobante URL para pago ID " . $pago['id'] . ":', '" . addslashes($comprobanteUrlFull) . "');</script>";
                                                                            ?>
                                                                <button class="btn btn-sm"
                                                                    style="background: linear-gradient(135deg, #11cdef 0%, #00bcd4 100%); color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; transition: transform 0.2s ease; cursor: pointer;"
                                                                    onclick="abrirModalVoucherAmpliado('<?= addslashes($comprobanteUrlFull) ?>', <?= $pago['id'] ?>, <?= $contract['id'] ?>, '<?= number_format($pago['amount'], 2) ?>')">
                                                                    <i class="fa fa-file-pdf"></i> Ver
                                                                </button>
                                                                <?php else: ?>
                                                                <span class="text-muted">—</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td style="padding: 1rem; vertical-align: middle;">
                                                                <div class="btn-group" role="group"
                                                                    style="display: flex; gap: 8px;">
                                                                    <?php
                                                                            // Mostrar Validar si: tiene voucher O está registrado, y NO está validado
                                                                            $tieneVoucher = !empty($pago['voucher_url']);
                                                                            $puedeValidar = ($registrado || $tieneVoucher) && !$validado;
                                                                            
                                                                            // Construir URL del comprobante si existe
                                                                            $voucherUrlForModal = '';
                                                                            if ($tieneVoucher) {
                                                                                $voucherUrlForModal = $pago['voucher_url'];
                                                                                if (strpos($voucherUrlForModal, '/') !== 0 && strpos($voucherUrlForModal, 'http') !== 0) {
                                                                                    $voucherUrlForModal = site_url($voucherUrlForModal);
                                                                                } elseif (strpos($voucherUrlForModal, '/') === 0) {
                                                                                    $voucherUrlForModal = site_url(ltrim($voucherUrlForModal, '/'));
                                                                                }
                                                                            }
                                                                            ?>
                                                                    <?php if ($puedeValidar): ?>
                                                                    <button class="btn btn-sm"
                                                                        style="background: linear-gradient(135deg, #2dce89 0%, #10b981 100%); color: white; border: none; padding: 8px 14px; border-radius: 6px; font-weight: 600; font-size: 0.85rem; cursor: pointer; transition: all 0.3s ease;"
                                                                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(45, 206, 137, 0.4)'"
                                                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'"
                                                                        onclick="abrirModalValidacion(<?= $pago['id'] ?>, '<?= number_format($pago['amount'], 2) ?>', '<?= addslashes($voucherUrlForModal) ?>')">
                                                                        <i class="fa fa-check-circle"></i> Validar
                                                                    </button>
                                                                    <?php elseif ($validado): ?>
                                                                    <button class="btn btn-sm"
                                                                        style="background: linear-gradient(135deg, #2dce89 0%, #10b981 100%); color: white; border: none; padding: 8px 14px; border-radius: 6px; font-weight: 600; font-size: 0.85rem;"
                                                                        disabled>
                                                                        <i class="fa fa-check"></i> Validado
                                                                    </button>
                                                                    <button class="btn btn-sm"
                                                                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 8px 14px; border-radius: 6px; font-weight: 600; font-size: 0.85rem; cursor: pointer; transition: all 0.3s ease;"
                                                                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.4)'"
                                                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'"
                                                                        onclick="generarFacturaCuota(<?= $pago['id'] ?>, <?= $contract['id'] ?>, '<?= number_format($pago['amount'], 2) ?>', <?= $pago['id'] ?>)">
                                                                        <i class="fa fa-file-invoice"></i> Comprobante
                                                                    </button>
                                                                    <?php else: ?>
                                                                    <span class="text-muted"
                                                                        style="padding: 8px 14px; font-size: 0.85rem; font-weight: 600;">
                                                                        <i class="fa fa-hourglass-half"></i> Esperando
                                                                        pago
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

                                    <div class="mt-4 text-center">
                                        <a href="<?= site_url('dashboard/inmueble/contracts') ?>" class="btn"
                                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 32px; border-radius: 8px; font-weight: 600; border: none; transition: all 0.3s ease; text-decoration: none;"
                                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(102, 126, 234, 0.4)'"
                                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)'">
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

    <!-- Modal para ver imagen del voucher ampliada -->
    <div class="modal fade" id="voucherAmpliadoModal" tabindex="-1" role="dialog"
        aria-labelledby="voucherAmpliadoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="voucherAmpliadoModalLabel">
                        <i class="fa fa-image"></i> Comprobante
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="voucher-ampliado-img" src=""
                        style="max-width: 100%; max-height: 400px; border-radius: 8px;" alt="Comprobante">

                    <!-- Campo para asignar patrocinador -->
                    <div id="sponsor-selection-area"
                        style="margin-top: 20px; padding: 15px; background: #f0f0f0; border-radius: 8px;">
                        <label><strong>👤 Patrocinador de la Comisión (Opcional):</strong></label>
                        <select id="sponsor-select-modal" class="form-control" style="margin-top: 8px;"
                            <?= !empty($contract['sponsor_id']) ? 'disabled' : '' ?>>
                            <option value="">-- Sin patrocinador (comisión sin asignar) --</option>
                            <?php 
                            $customerModel = new \App\Models\CustomerModel();
                            $agents = $customerModel->getActiveSponsors();
                            foreach ($agents as $agent): 
                            ?>
                            <option value="<?= $agent['id'] ?>"
                                <?= ($contract['sponsor_id'] == $agent['id']) ? 'selected' : '' ?>>
                                [<?= $agent['code'] ?>] <?= $agent['name'] ?> <?= $agent['lastname'] ?> (DNI:
                                <?= $agent['dni'] ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (!empty($contract['sponsor_id'])): ?>
                        <small style="display: block; margin-top: 8px; color: #666;">
                            <i class="fa fa-lock"></i> Este patrocinador fue asignado en la edición del contrato
                        </small>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" id="btn-generar-comision" style="display: none;">
                        <i class="fa fa-file-invoice"></i> Generar Comisión
                    </button>
                    <button type="button" class="btn btn-danger" id="btn-desaprobar-comision" style="display: none;">
                        <i class="fa fa-times-circle"></i> Desaprobar Comisión
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Ver Contrato -->
    <div class="modal fade" id="verContratoModal" tabindex="-1" role="dialog" aria-labelledby="verContratoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 95vw;">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="verContratoModalLabel">
                        <i class="fa fa-eye"></i> Vista Previa del Contrato
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="verContratoModalContent" style="max-height: 90vh; overflow-y: auto;">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Cargando...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="printContract('<?= $contract['id'] ?>')">
                        <i class="fa fa-print"></i> Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Contrato -->
    <div class="modal fade" id="editarContratoModal" tabindex="-1" role="dialog"
        aria-labelledby="editarContratoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 95vw;">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="editarContratoModalLabel">
                        <i class="fa fa-edit"></i> Editar Contrato
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="editarContratoModalContent" style="max-height: 90vh; overflow-y: auto;">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Cargando...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnGuardarEdicion">
                        <i class="fa fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Detalle de Pagos -->
    <div class="modal fade" id="detallesPagosModal" tabindex="-1" role="dialog"
        aria-labelledby="detallesPagosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 95vw;">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="detallesPagosModalLabel">
                        <i class="fa fa-list-alt"></i> Detalle de Pagos
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="detallesPagosModalContent" style="max-height: 90vh; overflow-y: auto;">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Cargando...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    // ========== MENU PCODED HANDLER - MEJORADO ==========
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🔧 Inicializando manejador de menú pcoded...');

        // Obtener todos los elementos del menú que tienen submenu
        const menuItems = document.querySelectorAll('.pcoded-navbar .nav-item.pcoded-hasmenu');

        console.log(`📍 Encontrados ${menuItems.length} items de menú con submenu`);

        menuItems.forEach((item, index) => {
            // Obtener el link principal y el submenu
            const link = item.querySelector('> a');
            const submenu = item.querySelector('> .pcoded-submenu');

            if (!link || !submenu) {
                console.warn(`⚠️ Item ${index}: estructura inválida (no tiene link o submenu)`);
                return;
            }

            const itemText = link.textContent.trim();
            console.log(`✓ Item ${index}: "${itemText}"`);

            // Agregar click handler al link
            link.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                console.log(`🔓 Click en: "${itemText}"`);

                // Toggle la clase pcoded-trigger
                const isOpen = item.classList.contains('pcoded-trigger');

                if (isOpen) {
                    // Cerrar
                    item.classList.remove('pcoded-trigger');
                    submenu.style.maxHeight = '0px';
                    submenu.style.opacity = '0';
                    submenu.style.overflow = 'hidden';
                    console.log(`🔐 Cerrado: "${itemText}"`);
                } else {
                    // Abrir
                    item.classList.add('pcoded-trigger');
                    submenu.style.maxHeight = submenu.scrollHeight + 'px';
                    submenu.style.opacity = '1';
                    submenu.style.overflow = 'visible';
                    console.log(`🔓 Abierto: "${itemText}"`);
                }
            });

            // Estilo inicial para transiciones suaves
            submenu.style.transition = 'all 0.3s ease-in-out';
            submenu.style.overflow = 'hidden';

            // Si ya está activo, abrir por defecto
            if (item.classList.contains('active') || item.classList.contains('pcoded-trigger')) {
                submenu.style.maxHeight = submenu.scrollHeight + 'px';
                submenu.style.opacity = '1';
                item.classList.add('pcoded-trigger');
                console.log(`📂 Abierto por defecto: "${itemText}"`);
            } else {
                submenu.style.maxHeight = '0px';
                submenu.style.opacity = '0';
                console.log(`📁 Cerrado por defecto: "${itemText}"`);
            }
        });

        console.log('✅ Manejador de menú pcoded inicializado');
    });

    console.log("=== CRONOGRAMA COMPLETO - DEBUG INICIADO ===");
    console.log("URL Base del Sitio:", "<?= site_url() ?>");

    let pagoIdActual = null;
    let comprobanteUrlActual = null;
    let contractIdGlobal = <?= $contract['id'] ?? 'null' ?>;

    function getBootstrapModalCompat(modalElement) {
        if (!modalElement || !window.bootstrap || !window.bootstrap.Modal) {
            return null;
        }

        if (typeof window.bootstrap.Modal.getOrCreateInstance === 'function') {
            return window.bootstrap.Modal.getOrCreateInstance(modalElement);
        }

        if (typeof window.bootstrap.Modal.getInstance === 'function') {
            const existingInstance = window.bootstrap.Modal.getInstance(modalElement);
            if (existingInstance) {
                return existingInstance;
            }
        }

        try {
            return new window.bootstrap.Modal(modalElement);
        } catch (error) {
            console.warn('No se pudo crear la instancia del modal con Bootstrap:', error);
            return null;
        }
    }

    function abrirModalCompat(modalId) {
        const modalElement = document.getElementById(modalId);
        if (!modalElement) {
            return;
        }

        const instance = getBootstrapModalCompat(modalElement);
        if (instance && typeof instance.show === 'function') {
            instance.show();
            return;
        }

        if (window.jQuery && typeof window.jQuery.fn.modal === 'function') {
            window.jQuery(modalElement).modal('show');
            return;
        }

        // Fallback cuando Bootstrap JS no esta disponible
        modalElement.style.display = 'block';
        modalElement.classList.add('show');
        modalElement.removeAttribute('aria-hidden');
        modalElement.setAttribute('aria-modal', 'true');
        document.body.classList.add('modal-open');

        if (!document.querySelector('.modal-backdrop')) {
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            backdrop.setAttribute('data-modal-fallback', modalId);
            document.body.appendChild(backdrop);
        }
    }

    function cerrarModalCompat(modalId) {
        const modalElement = document.getElementById(modalId);
        if (!modalElement) {
            return;
        }

        const instance = getBootstrapModalCompat(modalElement);
        if (instance && typeof instance.hide === 'function') {
            instance.hide();
            return;
        }

        if (window.jQuery && typeof window.jQuery.fn.modal === 'function') {
            window.jQuery(modalElement).modal('hide');
            return;
        }

        modalElement.classList.remove('show');
        modalElement.style.display = 'none';
        modalElement.setAttribute('aria-hidden', 'true');
        modalElement.removeAttribute('aria-modal');
        document.body.classList.remove('modal-open');

        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
    }

    function fireSwalSobreModal(options) {
        if (typeof Swal === 'undefined' || typeof Swal.fire !== 'function') {
            return Promise.resolve();
        }

        const swalOptions = typeof options === 'object' && options !== null ? {
            ...options
        } : {};
        const originalDidOpen = swalOptions.didOpen;

        swalOptions.didOpen = (popup) => {
            const container = Swal.getContainer();
            if (container) {
                container.style.zIndex = '200000';
            }

            if (typeof originalDidOpen === 'function') {
                originalDidOpen(popup);
            }
        };

        return Swal.fire(swalOptions);
    }

    document.addEventListener('click', function(event) {
        const triggerClose = event.target.closest(
            '[data-dismiss="modal"], [data-bs-dismiss="modal"], .modal .close');
        if (!triggerClose) {
            return;
        }

        const modal = triggerClose.closest('.modal');
        if (modal && modal.id) {
            event.preventDefault();
            cerrarModalCompat(modal.id);
        }
    });

    function mostrarErrorImagen(imgEl, url) {
        imgEl.parentElement.innerHTML = `
            <div style="text-align: center; padding: 30px; background: #ffe6e6; border-radius: 8px; border: 2px dashed #ff5252;">
                <i class="fa fa-exclamation-triangle" style="font-size: 48px; color: #ff5252; margin-bottom: 10px;"></i><br>
                <p style="color: #c62828; font-weight: bold; margin-top: 10px;">Error al cargar imagen</p>
                <p style="font-size: 0.85rem; color: #d32f2f;">URL: ${url}</p>
                <p style="font-size: 0.75rem; color: #666; margin-top: 10px;">Verifica que el archivo existe</p>
            </div>
        `;
    }

    function abrirModalValidacion(pagoId, monto, comprobanteUrl = null) {
        pagoIdActual = pagoId;
        comprobanteUrlActual = comprobanteUrl;

        // DEBUG: Registrar en consola
        console.log('=== MODAL VALIDACION DEBUG ===');
        console.log('Pago ID:', pagoId);
        console.log('Monto:', monto);
        console.log('Comprobante URL recibida:', comprobanteUrl);
        console.log('Tipo:', typeof comprobanteUrl);
        console.log('¿Vacía?:', comprobanteUrl === '' || comprobanteUrl === null || !comprobanteUrl);

        document.getElementById('modal-monto-pago').textContent = 'S/ ' + monto;
        document.getElementById('validar-notas').value = '';

        // Mostrar/ocultar secciones según si existe comprobante
        const comprobanteClienteSection = document.getElementById('comprobante-cliente-section');
        const subirComprobanteSection = document.getElementById('subir-comprobante-section');
        const comprobanteClientePreview = document.getElementById('comprobante-cliente-preview');

        // CORREGIDO: Verificar correctamente si hay comprobante (no solo comprobanteUrl)
        const tieneComprobante = comprobanteUrl && comprobanteUrl.trim() !== '' && comprobanteUrl !==
            '/dashboard/mostrarComprobante/';

        if (tieneComprobante) {
            console.log('✓ Mostrando comprobante del cliente desde URL:', comprobanteUrl);
            // Mostrar comprobante del cliente
            comprobanteClienteSection.style.display = 'block';
            subirComprobanteSection.style.display = 'none';

            // Detectar tipo de archivo
            const ext = comprobanteUrl.toLowerCase().split('.').pop();
            console.log('Extensión detectada:', ext);
            console.log('URL completa a cargar:', comprobanteUrl);

            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                // Imagen
                comprobanteClientePreview.innerHTML = `
                        <div style="text-align: center;">
                            <img id="voucher-preview-image" 
                                 src="${comprobanteUrl}" 
                                 style="max-width: 100%; max-height: 300px; border-radius: 8px; cursor: pointer; transition: transform 0.2s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.2);" 
                                 alt="Comprobante"
                                 loading="lazy"
                                 onerror="mostrarErrorImagen(this, this.src)"
                                 onclick="abrirModalVoucherAmpliado('${comprobanteUrl}', ${pagoIdActual}, ${contractIdGlobal}, '${monto}')" 
                                 onmouseover="this.style.transform='scale(1.05)'" 
                                 onmouseout="this.style.transform='scale(1)'">
                            <p style="text-align: center; margin-top: 12px; color: #666; font-size: 0.85rem;">
                                <i class="fa fa-search-plus"></i> Click para ampliar
                            </p>
                        </div>
                    `;
            } else if (ext === 'pdf') {
                // PDF
                comprobanteClientePreview.innerHTML = `
                        <div style="text-align: center; padding: 30px; background: #f0f0f0; border-radius: 8px;">
                            <i class="fa fa-file-pdf" style="font-size: 64px; color: #dc3545; margin-bottom: 15px;"></i>
                            <p style="margin: 10px 0; color: #333; font-weight: bold;">Comprobante PDF</p>
                            <a href="${comprobanteUrl}" target="_blank" class="btn btn-sm btn-danger">
                                <i class="fa fa-download"></i> Descargar PDF
                            </a>
                        </div>
                    `;
            } else {
                // Archivo genérico
                comprobanteClientePreview.innerHTML = `
                        <div style="text-align: center; padding: 30px; background: #f0f0f0; border-radius: 8px;">
                            <i class="fa fa-file" style="font-size: 64px; color: #999; margin-bottom: 15px;"></i>
                            <p style="margin: 10px 0; color: #333; font-weight: bold;">Comprobante (.${ext})</p>
                            <a href="${comprobanteUrl}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fa fa-download"></i> Descargar
                            </a>
                        </div>
                    `;
            }
        } else {
            console.log('✗ No hay comprobante válido, mostrando formulario para subir...');
            // No hay comprobante, permitir subir
            comprobanteClienteSection.style.display = 'none';
            subirComprobanteSection.style.display = 'block';
            document.getElementById('validar-comprobante').value = '';
        }

        abrirModalCompat('validarPagoModal');
    }

    document.getElementById('btn-confirmar-validacion').addEventListener('click', function() {
        if (!pagoIdActual) {
            fireSwalSobreModal({
                icon: 'error',
                title: 'Error',
                text: 'No se especificó el pago a validar'
            });
            return;
        }

        const comprobanteInput = document.getElementById('validar-comprobante');
        const notas = document.getElementById('validar-notas').value;
        let comprobante = null;

        // Si no existe comprobante del cliente, validar que el admin lo suba
        if (!comprobanteUrlActual) {
            if (comprobanteInput.files.length === 0) {
                fireSwalSobreModal({
                    icon: 'error',
                    title: 'Error',
                    text: 'Debe subir un comprobante'
                });
                return;
            }
            comprobante = comprobanteInput.files[0];

            // Validar tamaño
            if (comprobante.size > 5 * 1024 * 1024) {
                fireSwalSobreModal({
                    icon: 'error',
                    title: 'Error',
                    text: 'El archivo no debe exceder 5MB'
                });
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
                cerrarModalCompat('validarPagoModal');

                if (data.success) {
                    fireSwalSobreModal({
                        icon: 'success',
                        title: '¡Pago Validado!',
                        text: data.message || 'El pago ha sido validado correctamente',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    fireSwalSobreModal({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'No se pudo validar el pago'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                fireSwalSobreModal({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error en la conexión'
                });
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa fa-check"></i> Validar Pago';
            });
    });

    // Función para generar factura de una cuota específica
    // Función para generar factura de una cuota específica
    function generarFacturaCuota(pagoId, contractId, monto, paymentScheduleId) {
        // 1. Limpiar el monto (quitar comas de miles si existen)
        // Ejemplo: "1,500.50" -> "1500.50"
        const montoLimpio = monto.toString().replace(/,/g, '');

        console.log("=== DEBUG GENERAR FACTURA ===");
        console.log("ID Pago:", pagoId);
        console.log("ID Contrato:", contractId);
        console.log("ID Payment Schedule:", paymentScheduleId);
        console.log("Monto Enviado:", montoLimpio);

        Swal.fire({
            title: '¿Generar Comprobante?',
            text: 'Se generará una Comprobante por S/ ' + monto,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Generar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#764ba2',
        }).then((result) => {
            if (result.isConfirmed) {

                // 2. Preparar el JSON con el monto incluido
                const dataEnvio = {
                    pago_id: pagoId,
                    contract_id: contractId,
                    monto: montoLimpio,
                    payment_schedule_id: paymentScheduleId
                };

                Swal.fire({
                    title: 'Procesando...',
                    text: 'Enviando comprobante a SUNAT',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // 3. Petición Fetch
                fetch('<?= site_url("/dashboard/inmueble/generar_factura_cuota") ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify(dataEnvio)
                    })
                    .then(async response => {
                        const text = await response.text();
                        console.log("Respuesta cruda:", text);
                        try {
                            return JSON.parse(text);
                        } catch (e) {
                            throw new Error("Error en el formato de respuesta del servidor");
                        }
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Comprobante  Generado!',
                                text: 'Comprobante: ' + (data.data ? data.data.numero_completo :
                                    ''),
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message || 'No se pudo generar el comprobante',
                                'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'Hubo un fallo en el servidor. Revisa los logs.', 'error');
                    });
            }
        });
    }

    // Función para abrir modal con imagen ampliada del voucher
    let voucherModalData = {
        pagoId: null,
        contractId: null,
        monto: null
    };

    function abrirModalVoucherAmpliado(imagenUrl, pagoId = null, contractId = null, monto = null) {
        console.log("Abriendo modal con imagen:", imagenUrl);
        console.log("Datos del pago:", {
            pagoId,
            contractId,
            monto
        });

        const modal = document.getElementById('voucherAmpliadoModal');
        const imgAmpliada = document.getElementById('voucher-ampliado-img');

        if (!modal || !imgAmpliada) {
            console.error("Modal o imagen no encontrados");
            return;
        }

        // Limpiar manejadores anteriores
        imgAmpliada.onerror = null;
        imgAmpliada.onload = null;

        // Resetear visibilidad y mensaje de error previo
        imgAmpliada.style.display = '';
        const errorMsgPrev = document.getElementById('voucher-error-msg');
        if (errorMsgPrev) errorMsgPrev.remove();

        // Agregar manejadores de error y carga
        imgAmpliada.onerror = function() {
            console.error("❌ Error al cargar imagen:", imagenUrl);
            this.style.display = 'none';
            // Mostrar mensaje de error sin destruir el resto del modal
            const errorDiv = document.createElement('div');
            errorDiv.id = 'voucher-error-msg';
            errorDiv.style.cssText =
                'text-align:center;padding:30px;background:#ffe6e6;border-radius:8px;border:2px dashed #ff5252;margin-bottom:12px;';
            errorDiv.innerHTML =
                '<i class="fa fa-exclamation-triangle" style="font-size:48px;color:#ff5252;"></i><br><p style="color:#c62828;font-weight:bold;margin-top:10px;">Error al cargar la imagen</p><p style="font-size:0.85rem;color:#d32f2f;word-break:break-all;">' +
                imagenUrl + '</p>';
            this.parentNode.insertBefore(errorDiv, this.nextSibling);
        };

        imgAmpliada.onload = function() {
            console.log("✓ Imagen cargada correctamente:", imagenUrl);
            this.style.display = '';
        };

        imgAmpliada.src = imagenUrl;

        // Guardar datos para usar en los botones de acción
        voucherModalData.pagoId = pagoId;
        voucherModalData.contractId = contractId;
        voucherModalData.monto = monto;

        // Mostrar/ocultar botones según si hay datos Y si hay voucher
        const btnGenerar = document.getElementById('btn-generar-comision');
        const btnDesaprobar = document.getElementById('btn-desaprobar-comision');

        // Solo mostrar botones si TODOS los datos están presentes
        const tieneDataCompleta = pagoId && contractId && monto && imagenUrl && imagenUrl.trim() !== '';

        if (tieneDataCompleta) {
            console.log('✓ Datos completos - mostrando botones de comisión');
            btnGenerar.style.display = 'inline-block';
            btnDesaprobar.style.display = 'inline-block';
        } else {
            console.warn('✗ Datos incompletos - ocultando botones. pagoId:', pagoId, 'contractId:', contractId,
                'monto:', monto, 'imagenUrl:', imagenUrl);
            btnGenerar.style.display = 'none';
            btnDesaprobar.style.display = 'none';
        }

        // Mostrar modal (método Bootstrap 4)
        if (typeof jQuery !== 'undefined' && jQuery.fn.modal) {
            jQuery('#voucherAmpliadoModal').modal('show');
        } else {
            const instance = getBootstrapModalCompat(modal);
            if (instance && typeof instance.show === 'function') {
                instance.show();
            } else {
                // Fallback: mostrar el modal manualmente
                modal.style.display = 'block';
                modal.classList.add('show');
                document.body.classList.add('modal-open');
            }
        }
    }

    // Cerrar modal de voucher ampliado
    function cerrarModalVoucherAmpliado() {
        const modal = document.getElementById('voucherAmpliadoModal');

        if (typeof jQuery !== 'undefined' && jQuery.fn.modal) {
            jQuery('#voucherAmpliadoModal').modal('hide');
        } else {
            const instance = getBootstrapModalCompat(modal);
            if (instance && typeof instance.hide === 'function') {
                instance.hide();
            } else {
                // Fallback: ocultar el modal manualmente
                modal.style.display = 'none';
                modal.classList.remove('show');
                document.body.classList.remove('modal-open');
            }
        }
    }

    // Botón: Generar Comisión
    document.getElementById('btn-generar-comision').addEventListener('click', function() {
        const {
            contractId
        } = voucherModalData;

        if (!contractId) {
            Swal.fire('Error', 'Datos incompletos', 'error');
            return;
        }

        generarComision(contractId);
        cerrarModalVoucherAmpliado();
    });

    // Función para generar comisión
    function generarComision(contractId) {
        // Obtener patrocinador seleccionado del modal
        const sponsorSelectModal = document.getElementById('sponsor-select-modal');
        const sponsorId = sponsorSelectModal ? sponsorSelectModal.value : null;

        Swal.fire({
            title: '¿Generar Comisión?',
            text: sponsorId ? 'Se asignará patrocinador ID ' + sponsorId :
                'Se generará comisión sin patrocinador',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Generar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#28a745',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Procesando...',
                    text: 'Generando comisión',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const formData = new FormData();
                formData.append('contract_id', contractId);
                if (sponsorId) {
                    formData.append('sponsor_id', sponsorId); // Enviar patrocinador si está seleccionado
                }

                fetch('<?= site_url("/dashboard/inmueble/generate_commission") ?>', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Respuesta:', data);
                        if (data.success) {
                            const beneficiarioMsg = data.beneficiario_id ? 'Asignado a patrocinador ID: ' +
                                data.beneficiario_id : 'Sin patrocinador asignado';
                            Swal.fire({
                                icon: 'success',
                                title: '¡Comisión Generada!',
                                text: 'Monto: S/ ' + (data.total_comision ? parseFloat(data
                                        .total_comision).toFixed(2) : '0.00') + '\n' +
                                    beneficiarioMsg,
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message || 'No se pudo generar la comisión', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'Error en la conexión: ' + error.message, 'error');
                    });
            }
        });
    }

    // Botón: Desaprobar Comisión
    document.getElementById('btn-desaprobar-comision').addEventListener('click', function() {
        Swal.fire({
            title: '¿Desaprobar Comisión?',
            text: 'Esto marcará la comisión como rechazada',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Desaprobar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#dc3545'
        }).then((result) => {
            if (result.isConfirmed) {
                const {
                    pagoId,
                    contractId
                } = voucherModalData;
                // Aquí irá la lógica para desaprobar
                Swal.fire('Desaprobado', 'La comisión ha sido marcada como rechazada', 'success');
                cerrarModalVoucherAmpliado();
                location.reload();
            }
        });
    });

    // Funciones para abrir modales de Ver Contrato y Editar Contrato
    function abrirVerContrato(contractId) {
        const modal = document.getElementById('verContratoModal');
        const content = document.getElementById('verContratoModalContent');

        // Mostrar spinner
        content.innerHTML =
            '<div class="text-center"><div class="spinner-border" role="status"><span class="sr-only">Cargando...</span></div></div>';

        // Abrir modal
        abrirModalCompat('verContratoModal');

        // Cargar contenido via AJAX
        fetch('/dashboard/inmueble/contracts/view/' + contractId, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Extraer solo el contenido del contrato, sin header/footer
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const contractContent = doc.querySelector('.card, .contract-content, main');

                if (contractContent) {
                    content.innerHTML = contractContent.innerHTML;
                } else {
                    // Si no encuentra contenedor específico, usa el HTML completo
                    content.innerHTML = html;
                }

                // Remover botones de navegación que están demás
                const btnGroups = content.querySelectorAll('.btn-group, .button-group');
                btnGroups.forEach(btn => btn.remove());

                // Remover divs que contengan solo botones de acción
                const actionButtons = content.querySelectorAll('[style*="display:"], div:has(> .btn)');
                actionButtons.forEach(el => {
                    if (el.textContent.includes('Regresar') || el.textContent.includes('Cronograma') ||
                        el.textContent.includes('Editar') || el.textContent.includes('Registrar Pago')) {
                        el.remove();
                    }
                });

                // Remover buttons específicos por su contenido
                const allButtons = content.querySelectorAll('button, a.btn');
                allButtons.forEach(btn => {
                    const text = btn.textContent.toLowerCase();
                    if (text.includes('regresar') || text.includes('cronograma') ||
                        text.includes('editar') || text.includes('registrar pago') ||
                        text.includes('imprimir')) {
                        btn.remove();
                    }
                });
            })
            .catch(error => {
                console.error('Error:', error);
                content.innerHTML =
                    '<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Error al cargar el contrato</div>';
            });
    }

    function abrirEditarContrato(contractId) {
        const modal = document.getElementById('editarContratoModal');
        const content = document.getElementById('editarContratoModalContent');

        // Mostrar spinner
        content.innerHTML =
            '<div class="text-center"><div class="spinner-border" role="status"><span class="sr-only">Cargando...</span></div></div>';

        // Abrir modal
        abrirModalCompat('editarContratoModal');

        // Cargar contenido via AJAX
        fetch('/dashboard/inmueble/edit_contract/' + contractId, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Extraer solo el formulario, sin header/footer
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const formContent = doc.querySelector('form, .card-body, main');

                if (formContent) {
                    content.innerHTML = formContent.innerHTML;
                } else {
                    // Si no encuentra formulario específico, usa el HTML completo
                    content.innerHTML = html;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                content.innerHTML =
                    '<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Error al cargar el formulario de edición</div>';
            });
    }

    function abrirDetallesPagos(contractId) {
        const modal = document.getElementById('detallesPagosModal');
        const content = document.getElementById('detallesPagosModalContent');

        // Mostrar spinner
        content.innerHTML =
            '<div class="text-center"><div class="spinner-border" role="status"><span class="sr-only">Cargando...</span></div></div>';

        // Abrir modal
        abrirModalCompat('detallesPagosModal');

        // Cargar contenido via AJAX
        fetch('/dashboard/inmueble/contracts/view/' + contractId, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Extraer solo el contenido de detalles de pagos
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const detailsContent = doc.querySelector('.card, .payment-details, .details-section, main');

                if (detailsContent) {
                    content.innerHTML = detailsContent.innerHTML;
                } else {
                    // Si no encuentra contenedor específico, usa el HTML completo
                    content.innerHTML = html;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                content.innerHTML =
                    '<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Error al cargar los detalles de pagos</div>';
            });
    }
    </script>
    <?php echo view("admin/footer"); ?>