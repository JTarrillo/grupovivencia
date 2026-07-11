<html>
<?php echo view("admin/head"); ?>

<body>
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
                                        <h5 class="m-b-10">Lector de Estados de Cuenta</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard/">Panel</a></li>
                                        <li class="breadcrumb-item">Ventas & Compras</li>
                                        <li class="breadcrumb-item">Documentos</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="main-body">
                        <div class="page-wrapper">

                            <!-- Subir PDF -->
                            <div class="card mb-4">
                                <div class="card-header"><h5 class="mb-0"><i class="fa fa-upload mr-2"></i>Subir Estado de Cuenta PDF</h5></div>
                                <div class="card-body">
                                    <form id="formSubirPdf">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Archivo PDF <span class="text-danger">*</span></label>
                                                    <input type="file" id="archivo" name="archivo" class="form-control" accept=".pdf" required>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Descripción (opcional)</label>
                                                    <input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Ej: Estado Interbank Abril 2026">
                                                </div>
                                            </div>
                                            <div class="col-md-2 d-flex align-items-end">
                                                <button type="submit" class="btn btn-primary btn-block" id="btnSubir">
                                                    <i class="fa fa-upload mr-1"></i> Subir
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <div id="alertaUpload" class="mt-2" style="display:none;"></div>
                                </div>
                            </div>

                            <!-- Listado de documentos subidos -->
                            <div class="card mb-4">
                                <div class="card-header"><h5 class="mb-0"><i class="fa fa-folder-open mr-2"></i>PDFs Subidos</h5></div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nombre</th>
                                                    <th>Descripción</th>
                                                    <th>Tamaño</th>
                                                    <th>Subido por</th>
                                                    <th>Fecha</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (empty($documentos)): ?>
                                                    <tr><td colspan="7" class="text-center text-muted py-4"><i class="fa fa-inbox fa-2x d-block mb-2"></i>No hay documentos aún.</td></tr>
                                                <?php else: ?>
                                                    <?php foreach ($documentos as $i => $doc): ?>
                                                    <tr>
                                                        <td><?= $i + 1 ?></td>
                                                        <td><i class="fa fa-file-pdf text-danger mr-1"></i><?= esc($doc['nombre']) ?></td>
                                                        <td><?= esc($doc['descripcion'] ?: '—') ?></td>
                                                        <td><?= number_format($doc['tamanio'] / 1024, 1) ?> KB</td>
                                                        <td><?= esc($doc['created_by']) ?></td>
                                                        <td>
                                                            <?= !empty($doc['created_at']) ? date('d/m/Y H:i', strtotime($doc['created_at'])) : '-' ?>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-success btn-procesar" data-id="<?= $doc['id'] ?>" data-nombre="<?= esc($doc['nombre']) ?>" title="Leer con IA">
                                                                <i class="fa fa-magic mr-1"></i>Leer
                                                            </button>
                                                            <a href="<?= site_url('dashboard/documentos/ver/' . $doc['id']) ?>" target="_blank" class="btn btn-sm btn-info" title="Ver PDF">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <button class="btn btn-sm btn-danger btn-eliminar" data-id="<?= $doc['id'] ?>" title="Eliminar">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Panel de resultados (oculto hasta procesar) -->
                            <div id="panelResultados" style="display:none;">

                                <!-- Resumen del estado de cuenta -->
                                <div class="card mb-3" id="cardResumen">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0"><i class="fa fa-university mr-2"></i><span id="resumenBanco">—</span> — <span id="resumenPeriodo">—</span></h5>
                                        <div>
                                            <button class="btn btn-sm btn-outline-secondary mr-1" id="btnExportar"><i class="fa fa-file-excel mr-1"></i>Exportar CSV</button>
                                            <button class="btn btn-sm btn-primary" id="btnCargarConciliacion"><i class="fa fa-table mr-1"></i>Cargar a Conciliación</button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row text-center">
                                            <div class="col-md-3">
                                                <small class="text-muted d-block">Titular</small>
                                                <strong id="resumenTitular">—</strong>
                                            </div>
                                            <div class="col-md-2">
                                                <small class="text-muted d-block">Saldo Inicial</small>
                                                <strong class="text-secondary" id="resumenSaldoInicial">—</strong>
                                            </div>
                                            <div class="col-md-2">
                                                <small class="text-muted d-block">Total Abonos</small>
                                                <strong class="text-success" id="resumenAbonos">—</strong>
                                            </div>
                                            <div class="col-md-2">
                                                <small class="text-muted d-block">Total Cargos</small>
                                                <strong class="text-danger" id="resumenCargos">—</strong>
                                            </div>
                                            <div class="col-md-3">
                                                <small class="text-muted d-block">Saldo Final</small>
                                                <strong class="text-primary" id="resumenSaldoFinal">—</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Filtros -->
                                <div class="card mb-3">
                                    <div class="card-body py-2">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <input type="text" id="filtroTexto" class="form-control form-control-sm" placeholder="Buscar por detalle o movimiento...">
                                            </div>
                                            <div class="col-md-2">
                                                <select id="filtroTipo" class="form-control form-control-sm">
                                                    <option value="">Todos los tipos</option>
                                                    <option value="abono">Solo Abonos</option>
                                                    <option value="cargo">Solo Cargos</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="date" id="filtroFechaDesde" class="form-control form-control-sm" placeholder="Desde">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="date" id="filtroFechaHasta" class="form-control form-control-sm" placeholder="Hasta">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" id="filtroMontoMin" class="form-control form-control-sm" placeholder="Monto mínimo">
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-sm btn-secondary btn-block" id="btnLimpiarFiltros">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tabla de transacciones -->
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0"><i class="fa fa-list mr-2"></i>Transacciones</h5>
                                        <div>
                                            <span class="badge badge-success mr-1" id="contadorClasificadas">0 de 0 gastos clasificados</span>
                                            <span class="badge badge-secondary" id="contadorFilas">0 registros</span>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped mb-0" id="tablaTransacciones">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th class="sortable" data-col="fecha">Fecha <i class="fa fa-sort ml-1"></i></th>
                                                        <th>Movimiento</th>
                                                        <th>Detalle</th>
                                                        <th class="text-right sortable" data-col="monto">Monto <i class="fa fa-sort ml-1"></i></th>
                                                        <th class="text-right sortable" data-col="saldo">Saldo <i class="fa fa-sort ml-1"></i></th>
                                                        <th style="min-width:200px;">Desc. del Movimiento</th>
                                                        <th style="min-width:220px;">Desc. de la Operación</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbodyTransacciones"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- /panelResultados -->

                            <!-- Loading overlay -->
                            <div id="loadingIA" style="display:none;" class="text-center py-5">
                                <i class="fa fa-spinner fa-spin fa-3x text-primary mb-3"></i>
                                <p class="text-muted">Leyendo PDF con IA... esto puede tardar unos segundos.</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php echo view("admin/footer"); ?>

<style>
.sortable { cursor: pointer; user-select: none; }
.sortable:hover { background: #3d4a5c; }
#tablaTransacciones .abono { color: #28a745; font-weight: 600; }
#tablaTransacciones .cargo { color: #dc3545; font-weight: 600; }
</style>

<script>
// ─── Variables globales ────────────────────────────────────────────────────
let todasLasTransacciones = [];
let sortCol = 'fecha', sortDir = 1;
const DESCRIPCIONES = <?= json_encode($descripciones ?? []) ?>;

// Construir el <select> de "Desc. del Movimiento"
function buildSelectDescripcion(selectedId) {
    let html = '<select class="form-control form-control-sm select-descripcion">';
    html += '<option value="">— Sin clasificar —</option>';
    DESCRIPCIONES.forEach(d => {
        const sel = (String(d.id) === String(selectedId)) ? ' selected' : '';
        html += '<option value="' + d.id + '"' + sel + '>' + esc(d.nombre) + '</option>';
    });
    html += '</select>';
    return html;
}

// ─── Subir PDF ─────────────────────────────────────────────────────────────
$('#formSubirPdf').on('submit', function(e) {
    e.preventDefault();
    const fd = new FormData();
    fd.append('archivo',     $('#archivo')[0].files[0]);
    fd.append('descripcion', $('#descripcion').val());

    $('#btnSubir').prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i>Subiendo...');

    $.ajax({
        url: '<?= site_url('dashboard/documentos/upload') ?>',
        method: 'POST', data: fd, processData: false, contentType: false,
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        success(res) {
            if (res.success) {
                $('#alertaUpload').html('<div class="alert alert-success">' + res.message + '</div>').show();
                setTimeout(() => location.reload(), 1200);
            } else {
                $('#alertaUpload').html('<div class="alert alert-danger">' + (res.error || 'Error') + '</div>').show();
            }
        },
        error() {
            $('#alertaUpload').html('<div class="alert alert-danger">Error al subir el archivo.</div>').show();
        },
        complete() {
            $('#btnSubir').prop('disabled', false).html('<i class="fa fa-upload mr-1"></i>Subir');
        }
    });
});

// ─── Eliminar ──────────────────────────────────────────────────────────────
$(document).on('click', '.btn-eliminar', function() {
    if (!confirm('¿Eliminar este documento?')) return;
    const id = $(this).data('id');
    $.post('<?= site_url('dashboard/documentos/delete/') ?>' + id,
        {}, res => { if (res.success) location.reload(); else alert('Error al eliminar.'); }
    ).fail(() => alert('Error de conexión.'));
});

// ─── Procesar con IA ───────────────────────────────────────────────────────
let documentoActualId = null;
let metaActual = {};

$(document).on('click', '.btn-procesar', function() {
    const id     = $(this).data('id');
    const nombre = $(this).data('nombre');
    documentoActualId = id;

    $('#panelResultados').hide();
    $('#loadingIA').show();
    $('html, body').animate({ scrollTop: $('#loadingIA').offset().top - 80 }, 400);

    $.ajax({
        url: '<?= site_url('dashboard/documentos/procesar/') ?>' + id,
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        success(res) {
            $('#loadingIA').hide();
            if (!res.success) {
                alert('Error: ' + (res.error || 'No se pudo procesar'));
                return;
            }
            renderResultados(res.data);
        },
        error() {
            $('#loadingIA').hide();
            alert('Error de conexión con la IA.');
        }
    });
});

// ─── Renderizar resultados ─────────────────────────────────────────────────
function renderResultados(data) {
    const moneda = data.moneda || 'PEN';

    metaActual = {
        banco:   data.banco   || '',
        cuenta:  data.cuenta  || '',
        periodo: data.periodo || '',
        moneda:  moneda,
    };

    $('#resumenBanco').text(data.banco || '—');
    $('#resumenPeriodo').text(data.periodo || '—');
    $('#resumenTitular').text(data.titular || '—');
    $('#resumenSaldoInicial').text(formatMonto(data.saldo_inicial, moneda));
    $('#resumenAbonos').text('+' + formatMonto(data.total_abonos, moneda));
    $('#resumenCargos').text('-' + formatMonto(data.total_cargos, moneda));
    $('#resumenSaldoFinal').text(formatMonto(data.saldo_final, moneda));

    todasLasTransacciones = (data.transacciones || []).map((t, idx) => ({
        ...t,
        _idx:   idx,
        _fecha: parseFecha(t.fecha),
        _monto: parseFloat(t.monto) || 0,
        _saldo: parseFloat(t.saldo) || 0,
        mov_descripcion_id: t.mov_descripcion_id || '',
        desc_operacion:     t.desc_operacion || '',
    }));

    aplicarFiltros();
    $('#panelResultados').show();
    $('html, body').animate({ scrollTop: $('#panelResultados').offset().top - 80 }, 400);
}

function formatMonto(val, moneda) {
    if (val === null || val === undefined) return '—';
    return (moneda || 'S/') + ' ' + parseFloat(val).toLocaleString('es-PE', { minimumFractionDigits: 2 });
}

function parseFecha(str) {
    if (!str) return null;
    const p = str.split('/');
    if (p.length === 3) return new Date(p[2], p[1] - 1, p[0]);
    return new Date(str);
}

// ─── Filtros ───────────────────────────────────────────────────────────────
function aplicarFiltros() {
    const texto    = $('#filtroTexto').val().toLowerCase();
    const tipo     = $('#filtroTipo').val();
    const desde    = $('#filtroFechaDesde').val() ? new Date($('#filtroFechaDesde').val()) : null;
    const hasta    = $('#filtroFechaHasta').val() ? new Date($('#filtroFechaHasta').val()) : null;
    const montoMin = parseFloat($('#filtroMontoMin').val()) || 0;

    let filas = todasLasTransacciones.filter(t => {
        if (texto && !(t.detalle || '').toLowerCase().includes(texto) && !(t.movimiento || '').toLowerCase().includes(texto)) return false;
        if (tipo && t.tipo !== tipo) return false;
        if (desde && t._fecha && t._fecha < desde) return false;
        if (hasta && t._fecha && t._fecha > hasta) return false;
        if (montoMin && t._monto < montoMin) return false;
        return true;
    });

    // Ordenar
    filas.sort((a, b) => {
        let va = sortCol === 'fecha' ? (a._fecha || 0) : (sortCol === 'monto' ? a._monto : a._saldo);
        let vb = sortCol === 'fecha' ? (b._fecha || 0) : (sortCol === 'monto' ? b._monto : b._saldo);
        if (va < vb) return -sortDir;
        if (va > vb) return sortDir;
        return 0;
    });

    const tbody = $('#tbodyTransacciones').empty();
    filas.forEach(t => {
        const esAbono = t.tipo === 'abono';
        const signo   = esAbono ? '+' : '-';
        const cls     = esAbono ? 'abono' : 'cargo';
        // El select de descripción aplica a TODOS los movimientos (abonos y cargos)
        const celdaDescripcion = buildSelectDescripcion(t.mov_descripcion_id);
        const inputOperacion = '<input type="text" class="form-control form-control-sm input-operacion" '
            + 'placeholder="Motivo / justificación..." value="' + esc(t.desc_operacion || '') + '">';
        tbody.append(`
            <tr data-idx="${t._idx}">
                <td>${t.fecha || '—'}</td>
                <td><span class="badge badge-light">${esc(t.movimiento || '—')}</span></td>
                <td>${esc(t.detalle || '—')}</td>
                <td class="text-right ${cls}">${signo} ${t._monto.toLocaleString('es-PE', {minimumFractionDigits: 2})}</td>
                <td class="text-right">${t._saldo ? t._saldo.toLocaleString('es-PE', {minimumFractionDigits: 2}) : '—'}</td>
                <td>${celdaDescripcion}</td>
                <td>${inputOperacion}</td>
            </tr>
        `);
    });

    $('#contadorFilas').text(filas.length + ' registros');
    actualizarContadorClasificadas();
}

// Guardar la descripción seleccionada en el objeto de la transacción
$(document).on('change', '.select-descripcion', function() {
    const idx = $(this).closest('tr').data('idx');
    const t = todasLasTransacciones.find(x => x._idx === idx);
    if (t) t.mov_descripcion_id = $(this).val();
    actualizarContadorClasificadas();
});

// Guardar el texto de "Desc. de la Operación"
$(document).on('input', '.input-operacion', function() {
    const idx = $(this).closest('tr').data('idx');
    const t = todasLasTransacciones.find(x => x._idx === idx);
    if (t) t.desc_operacion = $(this).val();
});

function actualizarContadorClasificadas() {
    const total  = todasLasTransacciones.length;
    const clasif = todasLasTransacciones.filter(t => t.mov_descripcion_id).length;
    $('#contadorClasificadas').text(clasif + ' de ' + total + ' clasificados');
}

function esc(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

$('#filtroTexto, #filtroTipo, #filtroFechaDesde, #filtroFechaHasta, #filtroMontoMin').on('input change', aplicarFiltros);

$('#btnLimpiarFiltros').on('click', function() {
    $('#filtroTexto, #filtroFechaDesde, #filtroFechaHasta, #filtroMontoMin').val('');
    $('#filtroTipo').val('');
    aplicarFiltros();
});

// ─── Ordenar columnas ──────────────────────────────────────────────────────
$(document).on('click', '.sortable', function() {
    const col = $(this).data('col');
    if (sortCol === col) sortDir *= -1;
    else { sortCol = col; sortDir = 1; }
    $('.sortable i').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort');
    $(this).find('i').removeClass('fa-sort').addClass(sortDir === 1 ? 'fa-sort-up' : 'fa-sort-down');
    aplicarFiltros();
});

// ─── Exportar CSV ──────────────────────────────────────────────────────────
$('#btnExportar').on('click', function() {
    const banco   = $('#resumenBanco').text();
    const periodo = $('#resumenPeriodo').text();
    let csv = 'Fecha,Movimiento,Detalle,Tipo,Monto,Saldo\n';

    todasLasTransacciones.forEach(t => {
        csv += [t.fecha, t.movimiento, '"' + (t.detalle||'').replace(/"/g,'""') + '"',
                t.tipo, t._monto, t._saldo].join(',') + '\n';
    });

    const blob = new Blob(['﻿' + csv], { type: 'text/csv;charset=utf-8;' });
    const url  = URL.createObjectURL(blob);
    const a    = document.createElement('a');
    a.href     = url;
    a.download = banco + '_' + periodo + '.csv';
    a.click();
    URL.revokeObjectURL(url);
});

// ─── Cargar a Conciliación ─────────────────────────────────────────────────
$('#btnCargarConciliacion').on('click', function() {
    if (!todasLasTransacciones.length) {
        alert('No hay transacciones para cargar.');
        return;
    }

    const sinClasif = todasLasTransacciones.filter(t => !t.mov_descripcion_id).length;

    let msg = 'Se cargarán ' + todasLasTransacciones.length + ' movimientos a Conciliación.';
    if (sinClasif > 0) msg += '\n\nHay ' + sinClasif + ' movimientos SIN descripción. ¿Continuar de todos modos?';
    if (!confirm(msg)) return;

    const $btn = $(this);
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i>Cargando...');

    const transacciones = todasLasTransacciones.map(t => ({
        fecha:              t.fecha,
        movimiento:         t.movimiento,
        detalle:            t.detalle,
        monto:              t._monto,
        tipo:               t.tipo,
        saldo:              t._saldo,
        mov_descripcion_id: t.mov_descripcion_id || null,
        desc_operacion:     t.desc_operacion || null,
    }));

    $.ajax({
        url: '<?= site_url('dashboard/documentos/cargarConciliacion') ?>',
        method: 'POST',
        contentType: 'application/json',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        data: JSON.stringify({
            documento_id:  documentoActualId,
            meta:          metaActual,
            transacciones: transacciones,
        }),
        success(res) {
            if (res.success) {
                alert('✓ ' + res.message);
            } else {
                alert('Error: ' + (res.error || 'No se pudo cargar'));
            }
        },
        error() {
            alert('Error de conexión al cargar a Conciliación.');
        },
        complete() {
            $btn.prop('disabled', false).html('<i class="fa fa-table mr-1"></i>Cargar a Conciliación');
        }
    });
});
</script>
</body>
</html>
