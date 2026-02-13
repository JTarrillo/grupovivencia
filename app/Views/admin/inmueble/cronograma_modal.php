<!-- Vista para mostrar el cronograma de pagos de un contrato usando la tabla payment_schedules -->
<!-- Modal Bootstrap para el cronograma de pagos -->
<div class="modal fade" id="cronogramaModal" tabindex="-1" role="dialog" aria-labelledby="cronogramaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="cronogramaModalLabel">Cronograma de Pagos</h5>
                <div>
                    <button type="button" class="btn btn-sm btn-light" id="btn-reload-cronograma" 
                        title="Recargar cronograma" style="margin-right: 10px;">
                        <i class="fa fa-refresh"></i>
                    </button>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body" style="max-height: 600px; overflow-y: auto;">
                <!-- Resumen rápido -->
                <?php 
                    $totalPagado = 0;
                    $totalPendiente = 0;
                    $countPagados = 0;
                    $countPendientes = 0;
                    foreach ($payments as $p) {
                        $estado = strtolower($p['status'] ?? '');
                        $monto = $p['amount'] ?? 0;
                        if ($estado === 'paid' || $estado === 'pagado') {
                            $totalPagado += $monto;
                            $countPagados++;
                        } else {
                            $totalPendiente += $monto;
                            $countPendientes++;
                        }
                    }
                ?>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="alert alert-success mb-0" style="border-radius: 8px;">
                            <strong><i class="fa fa-check-circle"></i> Pagados</strong><br>
                            S/ <?= number_format($totalPagado, 2) ?><br>
                            <small><?= $countPagados ?> cuota(s)</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-warning mb-0" style="border-radius: 8px;">
                            <strong><i class="fa fa-clock-o"></i> Pendientes</strong><br>
                            S/ <?= number_format($totalPendiente, 2) ?><br>
                            <small><?= $countPendientes ?> cuota(s)</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-info mb-0" style="border-radius: 8px;">
                            <strong><i class="fa fa-calculator"></i> Total</strong><br>
                            S/ <?= number_format($totalPagado + $totalPendiente, 2) ?><br>
                            <small><?= count($payments) ?> cuota(s) total</small>
                        </div>
                    </div>
                </div>

                <table class="table table-bordered table-hover table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Cuota</th>
                            <th>Fecha Vencimiento</th>
                            <th>Monto</th>
                            <th>Capital</th>
                            <th>Interés</th>
                            <th>Interés Devengado</th>
                            <th>Fecha Devengo</th>
                            <th>Saldo</th>
                            <th>Estado</th>
                            <th>Fecha Pago</th>
                            <th>Monto Pagado</th>
                            <th>PDF</th>
                            <th>XML</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payments as $i => $p): 
                            // Determinar si el pago fue realizado
                            $estado = strtolower($p['status'] ?? '');
                            $isPaid = ($estado === 'paid' || $estado === 'pagado');
                            $rowClass = $isPaid ? 'table-success' : '';
                        ?>
                        <tr class="<?= $rowClass ?>"
                            <td><?= $i + 1 ?></td>
                            <td><?= $p['installment_number'] ?? '-' ?></td>
                            <td><?= date('d/m/Y', strtotime($p['due_date'])) ?></td>
                            <td>S/ <?= number_format($p['amount'], 2) ?></td>
                            <td>S/ <?= number_format($p['capital'], 2) ?></td>
                            <td>S/ <?= number_format($p['interest'], 2) ?></td>
                            <td>
                                <?php if (isset($p['interest_accrued'])): ?>
                                S/ <?= number_format($p['interest_accrued'], 2) ?>
                                <?php else: ?>
                                <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($p['interest_accrued_date']) && $p['interest_accrued_date'] != '0000-00-00'): ?>
                                <?= date('d/m/Y', strtotime($p['interest_accrued_date'])) ?>
                                <?php else: ?>
                                <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>S/ <?= number_format($p['balance'], 2) ?></td>
                            <td>
                                <?php
                                $estado = $p['status'];
                                $class = $estado == 'paid' ? 'badge-success' : ($estado == 'pending' ? 'badge-warning' : ($estado == 'overdue' ? 'badge-danger' : 'badge-secondary'));
                                $estado_text = $estado == 'paid' ? 'Pagado' : ($estado == 'pending' ? 'Pendiente' : ($estado == 'overdue' ? 'Vencido' : 'Cancelado'));
                                ?>
                                <span class="badge <?= $class ?>"><?= $estado_text ?></span>
                            </td>
                            <td><?= !empty($p['paid_date']) && $p['paid_date'] != '0000-00-00 00:00:00' ? date('d/m/Y', strtotime($p['paid_date'])) : '-' ?>
                            </td>
                            <td>S/ <?= !empty($p['paid_amount']) ? number_format($p['paid_amount'], 2) : '-' ?></td>
                            <td>
                                <?php if (!empty($p['pdf_url'])): ?>
                                <a href="<?= $p['pdf_url'] ?>" target="_blank"
                                    class="btn btn-sm btn-outline-danger">PDF</a>
                                <?php else: ?>
                                <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($p['xml_url'])): ?>
                                <a href="<?= $p['xml_url'] ?>" target="_blank"
                                    class="btn btn-sm btn-outline-info">XML</a>
                                <?php else: ?>
                                <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin del modal cronograma -->
<script>
console.log('VISTA: cronograma_modal.php cargada');

// Global para guardar el contract ID actual
let currentContractIdInModal = null;

// Función para recargar el cronograma
function reloadCronograma() {
    const reloadBtn = document.getElementById('btn-reload-cronograma');
    if (reloadBtn) {
        reloadBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
        reloadBtn.disabled = true;
    }
    
    if (currentContractIdInModal) {
        fetch('/dashboard/inmueble/contracts/get_schedule/' + currentContractIdInModal)
            .then(response => response.text())
            .then(html => {
                const modalBody = document.querySelector('#cronogramaModal .modal-body');
                if (modalBody) {
                    modalBody.innerHTML = html.replace(/<div class="modal fade"[\s\S]*?<\/div>\s*<!-- Fin del modal cronograma -->/, '');
                }
                
                if (reloadBtn) {
                    reloadBtn.innerHTML = '<i class="fa fa-refresh"></i>';
                    reloadBtn.disabled = false;
                }
                
                // Mostrar notificación de éxito
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cronograma actualizado',
                        text: 'Los datos se han recargado correctamente',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            })
            .catch(error => {
                console.error('Error recargando cronograma:', error);
                if (reloadBtn) {
                    reloadBtn.innerHTML = '<i class="fa fa-refresh"></i>';
                    reloadBtn.disabled = false;
                }
            });
    }
}

// Attach listener al botón de recarga
document.addEventListener('DOMContentLoaded', function() {
    const reloadBtn = document.getElementById('btn-reload-cronograma');
    if (reloadBtn) {
        reloadBtn.addEventListener('click', reloadCronograma);
    }
});
</script>