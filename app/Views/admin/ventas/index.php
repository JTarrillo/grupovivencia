<!doctype html>
<html lang="es-PE">
<?php echo view("admin/head"); ?>
<style>
.contract-table th {
    font-size: 11px; text-transform: uppercase;
    letter-spacing: .05em; color: #6c757d;
    font-weight: 600; border-top: none;
}
.contract-table td { vertical-align: middle; }
.contract-number { font-family: 'Courier New', monospace; font-weight: 700; font-size: 13px; color: #4099ff; }
.customer-name   { font-weight: 600; font-size: 14px; }
.project-sub     { font-size: 11px; color: #aaa; margin-top: 2px; }
.amount-cell     { font-weight: 700; font-size: 14px; color: #2ecc71; }
.comp-header     { background: linear-gradient(135deg, #4099ff 0%, #2e6ecf 100%); color: #fff; padding: 20px 24px; }
.comp-header h5  { margin: 0; font-size: 17px; font-weight: 700; }
.comp-table th   { font-size: 11px; text-transform: uppercase; letter-spacing: .05em; color: #6c757d; background: #f8f9fa; border-top: none; }
.comp-table td   { vertical-align: middle; font-size: 13px; }
.comp-number     { font-family: 'Courier New', monospace; font-weight: 700; }
.comp-footer     { background: #f8f9fa; padding: 12px 20px; border-top: 1px solid #e9ecef; }
.btn-pdf         { background: #e74c3c; color: #fff; border: none; font-size: 11px; }
.btn-pdf:hover   { background: #c0392b; color: #fff; }
.btn-xml         { background: #6c757d; color: #fff; border: none; font-size: 11px; }
.btn-xml:hover   { background: #5a6268; color: #fff; }
.btn-cdr         { background: #27ae60; color: #fff; border: none; font-size: 11px; }
.btn-cdr:hover   { background: #1e8449; color: #fff; }
.btn-anular      { background: #e74c3c; color: #fff; border: none; font-size: 11px; }
.btn-anular:hover{ background: #c0392b; color: #fff; }
tr.anulado td    { opacity: .5; text-decoration: line-through; }
tr.anulado td:last-child { text-decoration: none; opacity: 1; }

/* Modal XML viewer */
.xml-viewer { background: #1e1e1e; color: #d4d4d4; font-family: 'Courier New', monospace; font-size: 12px; padding: 20px; max-height: 500px; overflow-y: auto; white-space: pre-wrap; word-break: break-all; border-radius: 0; }
</style>
<body>
<?php echo view("admin/header"); ?>

<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">

                        <div class="page-header">
                            <div class="row align-items-end">
                                <div class="col-lg-8">
                                    <div class="page-header-title">
                                        <i class="feather icon-file-text bg-c-blue"
                                           style="padding:12px;border-radius:10px;color:#fff;font-size:22px;vertical-align:middle;margin-right:12px;"></i>
                                        <div class="d-inline-block" style="vertical-align:middle;">
                                            <h4 class="d-inline-block mb-0">Contratos</h4>
                                            <span class="d-block text-muted" style="font-size:13px;margin-top:2px;">
                                                Gestión de contratos y comprobantes electrónicos
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-right">
                                    <span class="badge badge-primary" style="font-size:13px;padding:6px 14px;">
                                        <?= count($contratos) ?> contratos
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="page-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card shadow-sm" style="border-radius:12px;overflow:hidden;">
                                        <div class="card-block p-0">
                                            <div class="table-responsive">
                                                <table class="table table-hover contract-table mb-0" id="tablaContratos">
                                                    <thead>
                                                        <tr>
                                                            <th>N° Contrato</th>
                                                            <th>Cliente</th>
                                                            <th>Proyecto / Lote</th>
                                                            <th>Total</th>
                                                            <th>Fecha</th>
                                                            <th>Estado</th>
                                                            <th class="text-center">Comprobantes</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($contratos as $c): ?>
                                                        <tr>
                                                            <td><span class="contract-number"><?= esc($c['contract_number']) ?></span></td>
                                                            <td>
                                                                <span class="customer-name"><?= esc($c['customer_name']) ?></span><br>
                                                                <small class="text-muted"><?= esc($c['dni'] ?: ($c['ruc'] ?? '')) ?></small>
                                                            </td>
                                                            <td>
                                                                <?= esc($c['project_name']) ?>
                                                                <div class="project-sub">Lote <?= esc($c['lot_number']) ?> — Mz. <?= esc($c['block']) ?></div>
                                                            </td>
                                                            <td><span class="amount-cell">S/ <?= number_format($c['total_amount'], 2) ?></span></td>
                                                            <td style="font-size:13px;"><?= date('d/m/Y', strtotime($c['contract_date'])) ?></td>
                                                            <td>
                                                                <?php
                                                                $badgeClass = match(strtolower($c['status'] ?? '')) {
                                                                    'active','activo'       => 'badge-success',
                                                                    'pending','pendiente'   => 'badge-warning',
                                                                    'cancelled','cancelado' => 'badge-danger',
                                                                    default                 => 'badge-secondary'
                                                                };
                                                                ?>
                                                                <span class="badge <?= $badgeClass ?>" style="font-size:11px;padding:5px 10px;">
                                                                    <?= ucfirst(esc($c['status'])) ?>
                                                                </span>
                                                            </td>
                                                            <td class="text-center">
                                                                <button class="btn btn-sm btn-outline-primary"
                                                                    style="border-radius:20px;font-size:12px;padding:4px 14px;"
                                                                    onclick="verComprobantes(<?= $c['id'] ?>, '<?= esc($c['contract_number']) ?>', '<?= esc($c['customer_name']) ?>')">
                                                                    <i class="feather icon-file-text" style="width:13px;height:13px;"></i> Ver
                                                                </button>
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
        </div>
    </div>
</div>

<!-- MODAL COMPROBANTES -->
<div class="modal fade" id="modalComprobantes" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" style="border-radius:12px;overflow:hidden;border:none;">
            <div class="comp-header d-flex justify-content-between align-items-start">
                <div>
                    <h5 id="modalTitulo">Comprobantes</h5>
                    <small id="modalSubtitulo" style="opacity:.85;"></small>
                </div>
                <button type="button" class="close" data-dismiss="modal"
                    style="color:#fff;opacity:.8;font-size:24px;margin-top:-4px;">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body p-0" id="modalBody"></div>
            <div class="comp-footer d-flex justify-content-between align-items-center" id="modalFooter" style="display:none!important;">
                <small class="text-muted" id="modalCount"></small>
                <div>
                    <strong>Total emitido: </strong>
                    <strong class="text-success" style="font-size:16px;" id="modalTotal">S/ 0.00</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL XML/CDR VIEWER -->
<div class="modal fade" id="modalXml" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius:12px;overflow:hidden;border:none;">
            <div class="modal-header" style="background:#1e1e1e;border:none;">
                <h6 class="modal-title mb-0" id="xmlModalTitulo" style="color:#d4d4d4;font-family:'Courier New',monospace;"></h6>
                <div class="d-flex gap-2 align-items-center">
                    <a id="xmlDescargarBtn" href="#" target="_blank"
                       class="btn btn-sm btn-outline-light" style="font-size:11px;margin-right:8px;">
                        <i class="feather icon-download" style="width:12px;height:12px;"></i> Descargar
                    </a>
                    <button type="button" class="close" data-dismiss="modal" style="color:#d4d4d4;opacity:.8;">
                        <span>&times;</span>
                    </button>
                </div>
            </div>
            <div id="xmlContent" class="xml-viewer">Cargando...</div>
        </div>
    </div>
</div>

<!-- MODAL ANULAR -->
<div class="modal fade" id="modalAnular" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="border-radius:12px;overflow:hidden;border:none;">
            <div class="modal-header bg-danger text-white border-0">
                <h6 class="modal-title mb-0"><i class="feather icon-alert-triangle"></i> Anular Comprobante</h6>
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <p class="mb-2" style="font-size:13px;">Comprobante: <strong id="anularNumero"></strong></p>
                <div class="form-group mb-0">
                    <label style="font-size:12px;font-weight:600;">Motivo de anulación</label>
                    <select class="form-control form-control-sm" id="anularMotivo">
                        <option value="Error en emisión">Error en emisión</option>
                        <option value="Error en RUC">Error en RUC</option>
                        <option value="Error en monto">Error en monto</option>
                        <option value="Operación cancelada">Operación cancelada</option>
                        <option value="Duplicado">Duplicado</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-sm btn-danger" id="btnConfirmarAnular" onclick="confirmarAnular()">
                    <i class="feather icon-x-circle" style="width:13px;height:13px;"></i> Anular
                </button>
            </div>
        </div>
    </div>
</div>

<?php echo view("admin/footer"); ?>
<script src="https://unpkg.com/feather-icons"></script>
<script>
const API_URL        = '<?= $api_url ?>';
let   currentContractId = null;
let   anularCompId   = null;

$(document).ready(function() {
    feather.replace();
    $('#tablaContratos').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' },
        order: [[0, 'desc']],
        pageLength: 25,
        columnDefs: [{ orderable: false, targets: [6] }]
    });
});

// ── Ver comprobantes del contrato ──
function verComprobantes(contractId, contractNumber, customerName) {
    currentContractId = contractId;
    document.getElementById('modalTitulo').textContent    = contractNumber;
    document.getElementById('modalSubtitulo').textContent = customerName;
    document.getElementById('modalFooter').style.display  = 'none';
    document.getElementById('modalBody').innerHTML = `
        <div class="text-center py-5 text-muted">
            <div class="spinner-border text-primary mb-3" role="status"></div>
            <p>Cargando comprobantes...</p>
        </div>`;
    $('#modalComprobantes').modal('show');
    cargarComprobantes(contractId);
}

function cargarComprobantes(contractId) {
    $.ajax({
        url: '/dashboard/ventas/contratos/comprobantes/' + contractId,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (!data.success || !data.comprobantes || data.comprobantes.length === 0) {
                document.getElementById('modalBody').innerHTML = `
                    <div class="text-center py-5 text-muted">
                        <i class="feather icon-inbox" style="font-size:52px;opacity:0.15;display:block;margin:0 auto 16px;"></i>
                        <p style="font-size:15px;">No hay comprobantes emitidos para este contrato.</p>
                    </div>`;
                feather.replace();
                return;
            }

            let totalMonto = 0;
            let rows = '';
            let num  = 1;

            data.comprobantes.forEach(function(c) {
                const badgeTipo  = c.tipo_documento === '01' ? 'badge-primary' : 'badge-info';
                const labelTipo  = c.tipo_documento === '01' ? 'Factura' : 'Boleta';
                const estadoCls  = c.estado === 'Aceptado' ? 'badge-success' : (c.estado === 'Anulado' ? 'badge-danger' : 'badge-warning');
                const monto      = parseFloat(c.monto_total) || 0;
                const anulado    = c.estado === 'Anulado';
                if (!anulado) totalMonto += monto;

                const xmlFilename = c.xml_filename ?? '';

                const pdfBtn = c.pdf_url
                    ? `<a href="${c.pdf_url}" target="_blank" class="btn btn-sm btn-pdf" title="PDF">
                           <i class="feather icon-file" style="width:11px;height:11px;"></i> PDF
                       </a>`
                    : '';
                const xmlBtn = xmlFilename
                    ? `<button class="btn btn-sm btn-xml" title="Ver XML"
                           onclick="verXml('${xmlFilename}','xml')">
                           <i class="feather icon-code" style="width:11px;height:11px;"></i> XML
                       </button>`
                    : '';
                const cdrBtn = xmlFilename
                    ? `<button class="btn btn-sm btn-cdr" title="Ver CDR"
                           onclick="verXml('${xmlFilename}','cdr')">
                           <i class="feather icon-shield" style="width:11px;height:11px;"></i> CDR
                       </button>`
                    : '';
                const anularBtn = !anulado
                    ? `<button class="btn btn-sm btn-anular" title="Anular"
                           onclick="abrirAnular(${c.id}, '${c.numero_completo}')">
                           <i class="feather icon-x-circle" style="width:11px;height:11px;"></i> Anular
                       </button>`
                    : '';

                rows += `
                    <tr class="${anulado ? 'anulado' : ''}">
                        <td style="color:#aaa;font-size:12px;">${num++}</td>
                        <td><span class="badge ${badgeTipo}" style="font-size:11px;">${labelTipo}</span></td>
                        <td><span class="comp-number">${c.numero_completo ?? '-'}</span></td>
                        <td>
                            <span style="font-size:13px;">${c.cliente_nombre ?? '-'}</span><br>
                            <small class="text-muted">${c.cliente_num_doc ?? ''}</small>
                        </td>
                        <td>
                            <strong class="${anulado ? 'text-muted' : 'text-success'}" style="font-size:14px;">
                                S/ ${monto.toLocaleString('es-PE', {minimumFractionDigits:2})}
                            </strong>
                        </td>
                        <td style="font-size:13px;">${c.fecha_emision ?? '-'}</td>
                        <td><span class="badge ${estadoCls}" style="font-size:11px;">${c.estado ?? '-'}</span></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                ${pdfBtn}${xmlBtn}${cdrBtn}${anularBtn}
                            </div>
                        </td>
                    </tr>`;
            });

            document.getElementById('modalBody').innerHTML = `
                <div class="table-responsive">
                    <table class="table table-hover comp-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tipo</th>
                                <th>Número</th>
                                <th>Cliente</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>${rows}</tbody>
                    </table>
                </div>`;

            document.getElementById('modalCount').textContent = data.comprobantes.length + ' comprobante(s)';
            document.getElementById('modalTotal').textContent = 'S/ ' + totalMonto.toLocaleString('es-PE', {minimumFractionDigits:2});
            document.getElementById('modalFooter').style.display = 'flex';
            feather.replace();
        },
        error: function(xhr) {
            document.getElementById('modalBody').innerHTML = `
                <div class="text-center py-4 text-danger">
                    <i class="feather icon-alert-circle" style="font-size:36px;display:block;margin:0 auto 12px;"></i>
                    <p>Error ${xhr.status} al cargar comprobantes.</p>
                </div>`;
            feather.replace();
        }
    });
}

// ── Ver XML / CDR ──
function verXml(filename, tipo) {
    // Eliminamos el .pdf del nombre del archivo si existe
    const filenameLimpio = filename.replace(/\.pdf$/i, '');
    
    // Construimos la URL usando el nombre limpio
    const url = `${API_URL}/api/comprobantes/${filenameLimpio}/${tipo}`;
    
    const titulo = tipo === 'xml' ? '📄 XML: ' + filenameLimpio : '🛡️ CDR: ' + filenameLimpio;
    
    document.getElementById('xmlModalTitulo').textContent = titulo;
    document.getElementById('xmlDescargarBtn').href       = url;
    document.getElementById('xmlContent').textContent     = 'Cargando...';
    $('#modalXml').modal('show');

    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            // Si el contenido es XML, a veces es mejor no usar JSON.stringify
            document.getElementById('xmlContent').textContent = data.content ?? JSON.stringify(data, null, 2);
        },
        error: function(xhr) {
            document.getElementById('xmlContent').textContent = 'Error al cargar: ' + xhr.status;
        }
    });
}

// ── Anular ──
function abrirAnular(compId, numero) {
    anularCompId = compId;
    document.getElementById('anularNumero').textContent = numero;
    $('#modalAnular').modal('show');
}

function confirmarAnular() {
    const motivo = document.getElementById('anularMotivo').value;
    const btn    = document.getElementById('btnConfirmarAnular');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Anulando...';

    $.ajax({
        url: '/dashboard/ventas/contratos/anular',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            comp_id:     anularCompId,
            contract_id: currentContractId,
            motivo:      motivo
        }),
        dataType: 'json',
        success: function(data) {
            $('#modalAnular').modal('hide');
            btn.disabled = false;
            btn.innerHTML = '<i class="feather icon-x-circle"></i> Anular';

            if (data.success) {
                // Recargar tabla de comprobantes
                cargarComprobantes(currentContractId);
                // Toast de éxito
                mostrarToast('Comprobante anulado correctamente', 'success');
            } else {
                mostrarToast('Error: ' + (data.message ?? data.error ?? 'Error desconocido'), 'danger');
            }
        },
        error: function(xhr) {
            btn.disabled = false;
            btn.innerHTML = '<i class="feather icon-x-circle"></i> Anular';
            mostrarToast('Error de conexión: ' + xhr.status, 'danger');
        }
    });
}

// ── Toast ──
function mostrarToast(mensaje, tipo) {
    const toast = $(`
        <div class="alert alert-${tipo} alert-dismissible"
             style="position:fixed;top:20px;right:20px;z-index:9999;min-width:300px;
                    border-radius:10px;box-shadow:0 4px 20px rgba(0,0,0,.15);">
            ${mensaje}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>`);
    $('body').append(toast);
    setTimeout(() => toast.fadeOut(400, () => toast.remove()), 4000);
}
</script>
</body>
</html>