<?php echo view("admin/head"); ?>

<body data-new-gr-c-s-check-loaded="14.1042.0" data-gr-ext-installed="">
    <?php echo view("admin/header"); ?>
    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="page-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 2.5rem; border-radius: 14px; margin-bottom: 2rem; box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="page-header-title">
                                        <h3 style="color: white; font-weight: 700; margin: 0; font-size: 1.8rem;">
                                            <i class="feather icon-calendar" style="margin-right: 14px;"></i>Validación de Pagos - Cronograma
                                        </h3>
                                        <p style="color: rgba(255,255,255,0.95); margin: 8px 0 0 0; font-size: 0.95rem;">Gestiona y valida los pagos de tu contrato</p>
                                    </div>
                                    <ul class="breadcrumb" style="margin: 12px 0 0 0;">
                                        <li class="breadcrumb-item"><a href="/dashboard/panel" style="color: rgba(255,255,255,0.95);">Panel</a></li>
                                        <li class="breadcrumb-item"><a href="/dashboard/inmueble" style="color: rgba(255,255,255,0.95);">Gestión Inmobiliaria</a></li>
                                        <li class="breadcrumb-item"><a href="/dashboard/inmueble/contracts" style="color: rgba(255,255,255,0.95);">Contratos</a></li>
                                        <li class="breadcrumb-item"><a style="color: rgba(255,255,255,0.8);">Cronograma de Pagos</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <div style="background: rgba(255,255,255,0.15); border-radius: 10px; padding: 1rem; backdrop-filter: blur(10px);">
                                        <div style="text-align: right; color: white;">
                                            <div style="font-size: 0.85rem; opacity: 0.9;">Contrato</div>
                                            <div style="font-size: 1.3rem; font-weight: 700;"><?= esc($contract['contract_number'] ?? '-') ?></div>
                                            <div style="font-size: 0.8rem; margin-top: 8px; opacity: 0.85;"><?= esc($contract['customer_name'] ?? '-') ?></div>
                                            <div style="font-size: 0.75rem; opacity: 0.8;">DNI: <?= esc($contract['customer_dni'] ?? '-') ?></div>
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

                                    <!-- Card de Resumen de Pagos -->
                                    <div class="row mb-4">
                                        <div class="col-md-3 mb-3">
                                            <div class="card" style="border: none; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 16px rgba(45, 206, 137, 0.2); transition: transform 0.3s ease, box-shadow 0.3s ease; background: linear-gradient(135deg, #2dce89 0%, #10b981 100%);" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 8px 24px rgba(45, 206, 137, 0.35)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(45, 206, 137, 0.2)'">
                                                <div class="card-body text-center text-white p-4">
                                                    <div style="font-size: 2.5rem; margin-bottom: 12px;">
                                                        <i class="fa fa-check-circle"></i>
                                                    </div>
                                                    <h2 style="font-size: 2.5rem; font-weight: 700; margin: 0;"><?= $stats['pagados_count'] ?? 0 ?></h2>
                                                    <p class="mb-0" style="font-weight: 600; margin-top: 8px;">Pagos Validados</p>
                                                    <small style="opacity: 0.95;">S/ <?= number_format($stats['pagados_monto'] ?? 0, 2) ?></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="card" style="border: none; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 16px rgba(255, 184, 28, 0.2); transition: transform 0.3s ease, box-shadow 0.3s ease; background: linear-gradient(135deg, #ffb71d 0%, #ffa500 100%);" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 8px 24px rgba(255, 184, 28, 0.35)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(255, 184, 28, 0.2)'">
                                                <div class="card-body text-center text-dark p-4">
                                                    <div style="font-size: 2.5rem; margin-bottom: 12px; color: #333;">
                                                        <i class="fa fa-clock"></i>
                                                    </div>
                                                    <h2 style="font-size: 2.5rem; font-weight: 700; margin: 0; color: #333;"><?= $stats['pendientes_count'] ?? 0 ?></h2>
                                                    <p class="mb-0" style="font-weight: 600; margin-top: 8px; color: #555;">Pendientes de Validar</p>
                                                    <small style="color: #666;">S/ <?= number_format($stats['pendientes_monto'] ?? 0, 2) ?></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="card" style="border: none; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 16px rgba(17, 205, 239, 0.2); transition: transform 0.3s ease, box-shadow 0.3s ease; background: linear-gradient(135deg, #11cdef 0%, #00bcd4 100%);" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 8px 24px rgba(17, 205, 239, 0.35)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(17, 205, 239, 0.2)'">
                                                <div class="card-body text-center text-white p-4">
                                                    <div style="font-size: 2.5rem; margin-bottom: 12px;">
                                                        <i class="fa fa-file-alt"></i>
                                                    </div>
                                                    <h2 style="font-size: 2.5rem; font-weight: 700; margin: 0;"><?= $stats['registrados_count'] ?? 0 ?></h2>
                                                    <p class="mb-0" style="font-weight: 600; margin-top: 8px;">Registrados (Sin Validar)</p>
                                                    <small style="opacity: 0.95;">S/ <?= number_format($stats['registrados_monto'] ?? 0, 2) ?></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="card" style="border: none; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 16px rgba(141, 92, 230, 0.2); transition: transform 0.3s ease, box-shadow 0.3s ease; background: linear-gradient(135deg, #8d5ce6 0%, #6c63ff 100%);" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 8px 24px rgba(141, 92, 230, 0.35)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(141, 92, 230, 0.2)'">
                                                <div class="card-body text-center text-white p-4">
                                                    <div style="font-size: 2.5rem; margin-bottom: 12px;">
                                                        <i class="fa fa-list"></i>
                                                    </div>
                                                    <h2 style="font-size: 2.5rem; font-weight: 700; margin: 0;"><?= $stats['total_count'] ?? 0 ?></h2>
                                                    <p class="mb-0" style="font-weight: 600; margin-top: 8px;">Total de Cuotas</p>
                                                    <small style="opacity: 0.95;">S/ <?= number_format($stats['total_monto'] ?? 0, 2) ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tabla de Cronograma -->
                                        <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.1); overflow: hidden;">
                                        <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 1.5rem;">
                                            <h5 style="color: white; margin: 0; font-weight: 700; font-size: 1.1rem;">
                                                <i class="feather icon-check-square" style="margin-right: 10px;"></i>Cronograma de Pagos - Validación de Comprobantes
                                            </h5>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0" style="border-collapse: collapse;">
                                                    <thead style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                                                        <tr>
                                                            <th style="padding: 1rem; font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">#</th>
                                                            <th style="padding: 1rem; font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Tipo</th>
                                                            <th style="padding: 1rem; font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Fecha Vencimiento</th>
                                                            <th style="padding: 1rem; font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Monto</th>
                                                            <th style="padding: 1rem; font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Estado de Pago</th>
                                                            <th style="padding: 1rem; font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Registrado</th>
                                                            <th style="padding: 1rem; font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Fecha Pago</th>
                                                            <th style="padding: 1rem; font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Comprobante</th>
                                                            <th style="padding: 1rem; font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Acciones</th>
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
                                                        <tr style="border-bottom: 1px solid #e9ecef; transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='white'">
                                                            <td style="padding: 1rem; vertical-align: middle;">
                                                                <strong style="color: #667eea; font-size: 1.1rem;"><?= ($i + 1) ?></strong>
                                                            </td>
                                                            <td style="padding: 1rem; vertical-align: middle;">
                                                                <?php if ($installment_number == 0): ?>
                                                                <span class="badge" style="background: linear-gradient(135deg, #ffb71d 0%, #ffa500 100%); color: #333; padding: 8px 12px; font-weight: 600; border-radius: 8px; font-size: 0.8rem;">INICIAL</span>
                                                                <?php else: ?>
                                                                <span class="badge" style="background: linear-gradient(135deg, #11cdef 0%, #00bcd4 100%); color: white; padding: 8px 12px; font-weight: 600; border-radius: 8px; font-size: 0.8rem;">CUOTA <?= $installment_number ?></span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td style="padding: 1rem; vertical-align: middle; color: #555; font-weight: 500;">
                                                                <?php 
                                                                    $fecha_vencimiento = $pago['due_date'] ?? null;
                                                                    echo $fecha_vencimiento ? date('d/m/Y', strtotime($fecha_vencimiento)) : '-';
                                                                    ?>
                                                            </td>
                                                            <td style="padding: 1rem; vertical-align: middle;">
                                                                <strong style="color: #2dce89; font-size: 1rem;">S/ <?= number_format($pago['amount'] ?? 0, 2) ?></strong>
                                                            </td>
                                                            <td style="padding: 1rem; vertical-align: middle;">
                                                                <?php if ($validado): ?>
                                                                <span class="badge" style="background: linear-gradient(135deg, #2dce89 0%, #10b981 100%); color: white; padding: 8px 12px; font-weight: 600; border-radius: 8px; font-size: 0.8rem;">✓ VALIDADO</span>
                                                                <?php elseif ($registrado): ?>
                                                                <span class="badge" style="background: linear-gradient(135deg, #11cdef 0%, #00bcd4 100%); color: white; padding: 8px 12px; font-weight: 600; border-radius: 8px; font-size: 0.8rem;">⏳ REGISTRADO</span>
                                                                <?php else: ?>
                                                                <span class="badge" style="background: linear-gradient(135deg, #ff5252 0%, #ff1744 100%); color: white; padding: 8px 12px; font-weight: 600; border-radius: 8px; font-size: 0.8rem;">✗ PENDIENTE</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td style="padding: 1rem; vertical-align: middle; text-align: center; font-weight: 600; color: #667eea;">
                                                                <?php 
                                                                    echo $registrado ? '<i class="fa fa-check" style="color: #2dce89; font-size: 1.2rem;"></i>' : '<i class="fa fa-times" style="color: #ff5252; font-size: 1.2rem;"></i>';
                                                                    ?>
                                                            </td>
                                                            <td style="padding: 1rem; vertical-align: middle; color: #555; font-size: 0.95rem;">
                                                                <?php 
                                                                    $fecha_pago = $pago['paid_date'] ?? null;
                                                                    echo $fecha_pago ? date('d/m/Y H:i', strtotime($fecha_pago)) : '-';
                                                                    ?>
                                                            </td>
                                                            <td style="padding: 1rem; vertical-align: middle;">
                                                                <?php if (!empty($pago['voucher_url'])): ?>
                                                                <a href="<?= base_url($pago['voucher_url']) ?>"
                                                                    target="_blank" class="btn btn-sm" style="background: linear-gradient(135deg, #11cdef 0%, #00bcd4 100%); color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; transition: transform 0.2s ease;">
                                                                    <i class="fa fa-file-pdf"></i> Ver
                                                                </a>
                                                                <?php else: ?>
                                                                <span class="text-muted">—</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td style="padding: 1rem; vertical-align: middle;">
                                                                <div class="btn-group" role="group" style="display: flex; gap: 8px;">
                                                                    <?php 
                                                                    // Mostrar Validar si: tiene voucher O está registrado, y NO está validado
                                                                    $tieneVoucher = !empty($pago['voucher_url']);
                                                                    $puedeValidar = ($registrado || $tieneVoucher) && !$validado;
                                                                    ?>
                                                                    <?php if ($puedeValidar): ?>
                                                                    <button class="btn btn-sm" style="background: linear-gradient(135deg, #2dce89 0%, #10b981 100%); color: white; border: none; padding: 8px 14px; border-radius: 6px; font-weight: 600; font-size: 0.85rem; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(45, 206, 137, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'" 
                                                                        onclick="abrirModalValidacion(<?= $pago['id'] ?>, '<?= number_format($pago['amount'], 2) ?>', '<?= !empty($pago['voucher_url']) ? base_url($pago['voucher_url']) : '' ?>')">
                                                                        <i class="fa fa-check-circle"></i> Validar
                                                                    </button>
                                                                    <?php elseif ($validado): ?>
                                                                    <button class="btn btn-sm" style="background: linear-gradient(135deg, #2dce89 0%, #10b981 100%); color: white; border: none; padding: 8px 14px; border-radius: 6px; font-weight: 600; font-size: 0.85rem;" disabled>
                                                                        <i class="fa fa-check"></i> Validado
                                                                    </button>
                                                                    <button class="btn btn-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 8px 14px; border-radius: 6px; font-weight: 600; font-size: 0.85rem; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'"
                                                                        onclick="generarFacturaCuota(<?= $pago['id'] ?>, <?= $contract['id'] ?>, '<?= number_format($pago['amount'], 2) ?>')">
                                                                        <i class="fa fa-file-invoice"></i> Factura
                                                                    </button>
                                                                    <?php else: ?>
                                                                    <span class="text-muted" style="padding: 8px 14px; font-size: 0.85rem; font-weight: 600;">
                                                                        <i class="fa fa-hourglass-half"></i> Esperando pago
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
                                        <a href="/dashboard/inmueble/contracts" class="btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 32px; border-radius: 8px; font-weight: 600; border: none; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(102, 126, 234, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)'">
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