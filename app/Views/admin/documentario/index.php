<!doctype html>
<html lang="es-PE">
<?php echo view("admin/head"); ?>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

<style>
    * { box-sizing: border-box; }

    body { font-family: 'DM Sans', sans-serif; }

    /* ── Card contenedor ── */
    .doc-card {
        background: var(--color-background-primary, #fff);
        border: 0.5px solid #e2e5e8;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,.04);
    }

    .doc-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 0.5px solid #e2e5e8;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        background: #fff;
    }

    .doc-card-header h5 {
        font-size: 15px;
        font-weight: 600;
        color: #1a1d23;
        margin: 0;
    }

    .doc-card-header p {
        font-size: 12px;
        color: #7a8190;
        margin: 3px 0 0;
    }

    .badge-total {
        background: #e8f0fe;
        color: #1a56db;
        font-size: 12px;
        font-weight: 500;
        padding: 4px 12px;
        border-radius: 99px;
        white-space: nowrap;
    }

    /* ── Tabla ── */
    .doc-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .doc-table thead tr {
        background: #f8f9fb;
    }

    .doc-table thead th {
        font-size: 10.5px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: #8a93a2;
        padding: 10px 1.25rem;
        text-align: left;
        border-bottom: 0.5px solid #e2e5e8;
    }

    .doc-table thead th:nth-child(1) { width: 28%; }
    .doc-table thead th:nth-child(2) { width: 18%; }
    .doc-table thead th:nth-child(3) { width: 24%; text-align: center; }
    .doc-table thead th:nth-child(4) { width: 30%; text-align: center; }

    .doc-table tbody tr {
        border-bottom: 0.5px solid #f0f2f5;
        transition: background .15s ease;
    }

    .doc-table tbody tr:last-child {
        border-bottom: none;
    }

    .doc-table tbody tr:hover {
        background: #f8f9fb;
    }

    .doc-table td {
        padding: 10px 1rem;
        vertical-align: middle;
    }

    /* ── Celda contrato ── */
    .contract-number {
        font-family: 'JetBrains Mono', monospace;
        font-size: 13px;
        font-weight: 500;
        color: #1a1d23;
        line-height: 1;
    }

    .customer-row {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 4px;
    }

    .avatar-initials {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: #e8f0fe;
        color: #1a56db;
        font-size: 9px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        letter-spacing: 0;
    }

    .customer-name {
        font-size: 12px;
        color: #5a6374;
        font-weight: 400;
    }

    /* ── Celda comprobante ── */
    .serie-badge {
        font-family: 'JetBrains Mono', monospace;
        font-size: 12px;
        font-weight: 500;
        background: #f4f5f7;
        color: #2d3344;
        border: 0.5px solid #dde1e8;
        padding: 4px 10px;
        border-radius: 6px;
        display: inline-block;
    }

    .doc-date {
        font-size: 11.5px;
        color: #8a93a2;
        margin-top: 6px;
        display: block;
    }

    /* ── Etiqueta de sección ── */
    .col-section-label {
        display: none;
    }

    /* ── Botones ── */
    .btn-doc {
        font-family: 'DM Sans', sans-serif;
        font-size: 11.5px;
        font-weight: 500;
        padding: 5px 10px;
        border-radius: 6px;
        border: 0.5px solid #dde1e8;
        background: #fff;
        color: #2d3344;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-decoration: none;
        transition: background .14s ease, border-color .14s ease;
        line-height: 1;
        white-space: nowrap;
    }

    .btn-doc:hover { text-decoration: none; }

    .btn-doc svg {
        width: 13px;
        height: 13px;
        flex-shrink: 0;
    }

    /* PDF */
    .btn-pdf  { color: #c0392b; border-color: #f5c4b3; }
    .btn-pdf:hover  { background: #FAECE7; color: #c0392b; }

    /* Word */
    .btn-word { color: #185FA5; border-color: #b5d4f4; }
    .btn-word:hover { background: #E6F1FB; color: #185FA5; }

    /* Factura (impresión) */
    .btn-print { color: #854F0B; border-color: #FAC775; }
    .btn-print:hover { background: #FAEEDA; color: #854F0B; }

    /* XML */
    .btn-xml  { color: #0F6E56; border-color: #9FE1CB; }
    .btn-xml:hover  { background: #E1F5EE; color: #0F6E56; }

    /* CDR */
    .btn-cdr  { color: #3B6D11; border-color: #C0DD97; }
    .btn-cdr:hover  { background: #EAF3DE; color: #3B6D11; }

    .btn-group-doc {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .no-archivo {
        font-size: 11.5px;
        color: #bdc3cc;
    }

    /* ── Forzar fila única, sin colapso de DataTables ── */
    #table-documentario td,
    #table-documentario th {
        white-space: nowrap;
    }

    #table-documentario.dataTable {
        width: 100% !important;
    }

    /* ── Responsive scroll ── */
    .doc-table-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
</style>

<body class="">
    <?php echo view("admin/header"); ?>

    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">

                    <!-- Breadcrumb -->
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">
                                            <i class="feather icon-folder m-r-10"></i>Módulo Documentario
                                        </h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="<?= site_url('dashboard/panel'); ?>">
                                                <i class="feather icon-home"></i>
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">Repositorio Central</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contenido principal -->
                    <div class="main-body">
                        <div class="page-wrapper">

                            <div class="doc-card">

                                <!-- Header de la card -->
                                <div class="doc-card-header">
                                    <div>
                                        <h5>Expedientes de Contratos y Facturación</h5>
                                        <p>Acceso rápido a Contratos (Word / PDF) y Comprobantes SUNAT (XML / CDR)</p>
                                    </div>
                                    <span class="badge-total">
                                        <?= count($contratos) ?> expediente<?= count($contratos) !== 1 ? 's' : '' ?>
                                    </span>
                                </div>

                                <!-- Tabla -->
                                <div class="doc-table-wrap">
                                    <table id="table-documentario" class="doc-table">
                                        <thead>
                                            <tr>
                                                <th>Contrato / Cliente</th>
                                                <th>Comprobante</th>
                                                <th>Documentos legales</th>
                                                <th>Archivos SUNAT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($contratos as $con):
                                                // Generar iniciales del cliente
                                                $iniciales = strtoupper(
                                                    substr($con['customer_name'], 0, 1) .
                                                    substr($con['customer_lastname'], 0, 1)
                                                );
                                                $nombre_completo = strtoupper(
                                                    $con['customer_name'] . ' ' . $con['customer_lastname']
                                                );
                                            ?>
                                            <tr>

                                                <!-- Contrato / Cliente -->
                                                <td>
                                                    <div class="contract-number"><?= esc($con['contract_number']) ?></div>
                                                    <div class="customer-row">
                                                        <span class="avatar-initials"><?= $iniciales ?></span>
                                                        <span class="customer-name"><?= $nombre_completo ?></span>
                                                    </div>
                                                </td>

                                                <!-- Serie / Fecha -->
                                                <td>
                                                    <span class="serie-badge">
                                                        <?= esc($con['factura_serie_correlativo']) ?>
                                                    </span>
                                                    <span class="doc-date">
                                                        <?= date('d/m/Y', strtotime($con['contract_date'])) ?>
                                                    </span>
                                                </td>

                                                <!-- Documentos legales: PDF y Word -->
                                                <td>
                                                    <span class="col-section-label">Contrato</span>
                                                    <div class="btn-group-doc">

                                                        <button type="button"
                                                            class="btn-doc btn-pdf"
                                                            title="Descargar Contrato PDF"
                                                            onclick="window.open('<?= site_url('admin/contrato_pdf/' . $con['id']) ?>', '_blank')">
                                                            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                                                                <path d="M4 1h6l4 4v10H4V1z"/>
                                                                <path d="M10 1v4h4"/>
                                                                <path d="M6 9h4M6 11.5h4M6 6.5h2"/>
                                                            </svg>
                                                            PDF
                                                        </button>

                                                        <a href="<?= site_url('admin/contrato_word/' . $con['id']) ?>"
                                                           class="btn-doc btn-word"
                                                           title="Descargar Contrato Word"
                                                           target="_blank">
                                                            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                                                                <path d="M4 1h6l4 4v10H4V1z"/>
                                                                <path d="M10 1v4h4"/>
                                                                <path d="M5.5 8l1.5 4 1.5-4 1.5 4L11.5 8"/>
                                                            </svg>
                                                            Word
                                                        </a>

                                                    </div>
                                                </td>

                                                <!-- Archivos SUNAT -->
                                                <td>
                                                    <span class="col-section-label">SUNAT / API</span>
                                                    <div class="btn-group-doc">

                                                        <?php if ($con['archivos']['pdf']): ?>
                                                            <a href="<?= $con['archivos']['pdf'] ?>"
                                                               target="_blank"
                                                               class="btn-doc btn-print"
                                                               title="Factura Electrónica">
                                                                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                                                                    <rect x="2" y="2" width="12" height="12" rx="1"/>
                                                                    <path d="M5 5.5h6M5 8h6M5 10.5h3.5"/>
                                                                </svg>
                                                                Factura
                                                            </a>
                                                        <?php endif; ?>

                                                        <?php if ($con['archivos']['xml']): ?>
                                                            <a href="<?= $con['archivos']['xml'] ?>"
                                                               download
                                                               class="btn-doc btn-xml"
                                                               title="XML Comprobante">
                                                                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                                                                    <path d="M3 5l-2 3 2 3M13 5l2 3-2 3M9 3l-2 10"/>
                                                                </svg>
                                                                XML
                                                            </a>
                                                        <?php endif; ?>

                                                        <?php if ($con['archivos']['cdr']): ?>
                                                            <a href="<?= site_url('d_documentario/descargarCdrZip/' . $con['factura_serie_correlativo']) ?>"
                                                               class="btn-doc btn-cdr"
                                                               title="Descargar CDR ZIP">
                                                                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                                                                    <path d="M8 2v8M5 7l3 3 3-3"/>
                                                                    <path d="M3 12h10"/>
                                                                </svg>
                                                                CDR
                                                            </a>
                                                        <?php endif; ?>

                                                        <?php if (!$con['archivos']['pdf'] && !$con['archivos']['xml'] && !$con['archivos']['cdr']): ?>
                                                            <span class="no-archivo">Sin archivos</span>
                                                        <?php endif; ?>

                                                    </div>
                                                </td>

                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div><!-- /doc-table-wrap -->

                            </div><!-- /doc-card -->

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <?php echo view("admin/footer"); ?>

    <script>
        $(document).ready(function () {
            $('#table-documentario').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
                },
                order: [[1, 'desc']],
                responsive: false,
                autoWidth: false,
                // Quita el estilo de DataTables en thead para mantener el nuestro
                initComplete: function () {
                    if (typeof feather !== 'undefined') { feather.replace(); }
                }
            });
        });
    </script>
</body>
</html>