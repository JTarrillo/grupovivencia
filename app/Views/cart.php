<!-- Modal Pago QR y Cuenta BBVA -->
<div id="modal-pago-qr" class="modal-custom" style="display:none;">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <span class="modal-icon-custom"><i class="fa fa-credit-card fa-3x text-info"></i></span>
            <h3 class="fw-bold mb-2">Realiza el pago</h3>
        </div>
        <div class="modal-body-custom">
            <div class="mb-3 text-center">
                <img src="<?php echo site_url('assets/front/img/gest.jpg'); ?>" alt="QR" style="max-width:180px;">
                <div class="mt-2"><span class="badge bg-gradient-info px-3 py-2">Escanea
                        el QR desde tu app bancaria</span></div>
            </div>
            <div class="mb-3 text-center">
                <img src="<?php echo site_url('assets/front/img/bbva-logo.png'); ?>" alt="BBVA"
                    style="height:32px;vertical-align:middle;"> <span class="fw-bold ms-2">GRUPO VIVENCIA
                    S.A.C</span><br>
                <span class="fs-5 fw-bold text-primary">0011 0083
                    0200310937 34</span>
                <button class="btn btn-sm btn-light ms-2" onclick="copiarCuenta()"><i class="fa fa-copy"></i>
                    Copiar</button>
                <div class="mt-1 text-muted">RUC: 20612232998</div>
            </div>
            <div class="mb-3 text-center">
                <span class="fs-4 fw-bold text-success">Monto: <span id="modal-monto-pago"></span></span>
            </div>
            <div class="mb-3 text-center">
                <label class="form-label">Adjunta tu comprobante
                    (opcional):</label>
                <input type="file" class="form-control" id="input-comprobante"
                    accept=".pdf,image/png,image/jpeg,image/jpg,image/webp">
            </div>
        </div>
        <div class="modal-footer-custom">
            <button class="btn btn-success" id="btn-registrar-pago">Registrar pago</button>
            <button class="btn btn-secondary" onclick="cerrarModal('modal-pago-qr')">Cancelar</button>
        </div>
    </div>
</div>
<script>
// Loader overlay moderno
var loaderOverlay = document.createElement('div');
loaderOverlay.id = 'loader-overlay';
loaderOverlay.innerHTML = `
    <div class="loader-spinner">
        <div class="spinner"></div>
        <div class="loader-text">Procesando...</div>
    </div>
`;
loaderOverlay.style.cssText = `
    position: fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(255,255,255,0.7); z-index:10000; display:none; align-items:center; justify-content:center;
`;
document.body.appendChild(loaderOverlay);

// Estilos spinner
var style = document.createElement('style');
style.innerHTML = `
    #loader-overlay { display: flex; }
    .loader-spinner { text-align:center; }
    .spinner {
        border: 6px solid #e3e6ef;
        border-top: 6px solid #1a4e9b;
        border-radius: 50%;
        width: 54px;
        height: 54px;
        animation: spin 1s linear infinite;
        margin:auto;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .loader-text {
        margin-top: 18px;
        font-size: 1.15rem;
        color: #1a4e9b;
        font-weight: 500;
    }
`;
document.head.appendChild(style);

function mostrarLoader() {
    loaderOverlay.style.display = 'flex';
}

function ocultarLoader() {
    loaderOverlay.style.display = 'none';
}
// Mostrar modal QR y cuenta al reservar, inicial o contado
function mostrarModalQR(monto) {
    document.getElementById('modal-monto-pago').textContent = monto;
    document.getElementById('modal-pago-qr').style.display = 'flex';
}
// Copiar número de cuenta
function copiarCuenta() {
    navigator.clipboard.writeText('0011 0083 0200310937 34');
    alert('Número de cuenta copiado');
}
// Abrir modal QR desde los botones principales
var btnReservar = document.getElementById('btn-reservar-lote');
if (btnReservar) {
    btnReservar.onclick = function() {
        var monto = document.getElementById('lote_precio').textContent || '-';
        mostrarModalQR(monto);
    };
}
var btnInicial = document.getElementById('btn-inicial-lote');
if (btnInicial) {
    btnInicial.onclick = function() {
        mostrarModalQR('S/ 10,000.00');
    };
}
var btnContado = document.getElementById('btn-contado-lote');
if (btnContado) {
    btnContado.onclick = function() {
        var monto = document.getElementById('lote_precio').textContent || '-';
        mostrarModalQR(monto);
    };
}
// Inicializar DataTables solo si existe la tabla y jQuery/DataTables están disponibles
document.addEventListener('DOMContentLoaded', function() {
    if (window.jQuery && typeof $.fn.DataTable === 'function' && $('.datatable').length) {
        $('.datatable').DataTable();
    }
});
</script>
<?php

use App\Models\CustomerModel;
// Obtener datos completos del usuario logueado
$nombre = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$apellido_paterno = isset($_SESSION['lastname']) ? $_SESSION['lastname'] : '';
$apellido_materno = isset($_SESSION['mother_last']) ? $_SESSION['mother_last'] : '';
$dni = isset($_SESSION['dni']) ? $_SESSION['dni'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

// Si falta algún dato, obtener del modelo
if (empty($nombre) || empty($apellido_paterno) || empty($apellido_materno)) {
    $customerModel = new CustomerModel();
    if (!empty($dni)) {
        $customer = $customerModel->where('dni', $dni)->first();
        if ($customer) {
            $nombre = $customer['name'] ?? $nombre;
            $apellido_paterno = $customer['lastname'] ?? $apellido_paterno;
            $apellido_materno = $customer['mother_last'] ?? $apellido_materno;
            $email = $customer['email'] ?? $email;
        }
    }
}
$usuario = [
    'nombre_completo' => trim($nombre . ' ' . $apellido_paterno . ' ' . $apellido_materno),
    'dni'    => $dni,
    'email'  => $email,
    'nombre' => trim($nombre . ' ' . $apellido_paterno), // Para compatibilidad con otros modales
];
?>
<?php echo view('backoffice_new/head'); ?>

<body data-kt-name="metronic" id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php echo view('backoffice_new/header'); ?>
                <?php echo view('backoffice_new/toolbar'); ?>
                <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
                    <div class="content flex-row-fluid" id="kt_content">
                        <div class="card">
                            <div class="card-body p-lg-20">
                                <div class="d-flex flex-column flex-xl-row">
                                    <div class="flex-lg-row-fluid me-xl-18 mb-10 mb-xl-0 col-12 col-xl-8">
                                        <div class="mt-n1">
                                            <div class="d-flex flex-stack pb-10">
                                                <a href="#">
                                                    <img alt="Logo"
                                                        src="<?php echo site_url() . 'assets/front/img/logo/Recursovivencia.png'; ?>"
                                                        width="50" />
                                                </a>
                                            </div>
                                            <?php
                                            // Asegurarse de que $lotes_db esté definido correctamente antes del resumen
                                            $LotModel = new \App\Models\LotModel();
                                            $project_id = isset($_GET['project_id']) ? $_GET['project_id'] : null;
                                            $ProjectModel = new \App\Models\ProjectModel();
                                            $project_name = '';
                                            if ($project_id) {
                                                $project = $ProjectModel->find($project_id);
                                                $project_name = $project ? $project['name'] : '';
                                                $lotes_db = $LotModel->where('project_id', $project_id)->findAll();
                                            } else {
                                                $lotes_db = $LotModel->findAll();
                                            }
                                            // Calcular resumen de lotes
                                            if (!isset($lotes_db) || !is_array($lotes_db)) {
                                                $lotes_db = [];
                                            }
                                            $total_lotes = count($lotes_db);
                                            $vendidos = 0;
                                            $libres = 0;
                                            $reservados = 0;
                                            $bloqueados = 0;
                                            foreach ($lotes_db as $lote) {
                                                $estado = strtolower($lote['status']);
                                                if ($estado === 'vendido' || $estado === 'sold') {
                                                    $vendidos++;
                                                } elseif ($estado === 'disponible' || $estado === 'available') {
                                                    $libres++;
                                                } elseif ($estado === 'reservado' || $estado === 'reserved') {
                                                    $reservados++;
                                                } elseif ($estado === 'bloqueado' || $estado === 'blocked') {
                                                    $bloqueados++;
                                                }
                                            }
                                            ?>
                                            <div class="row mb-4">
                                                <div class="col">
                                                    <div class="card card-bordered text-center">
                                                        <div class="card-body py-2 px-1">
                                                            <span class="fw-bold">Total lotes</span><br>
                                                            <span
                                                                class="fs-4 text-dark"><?php echo $total_lotes; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="card card-bordered text-center">
                                                        <div class="card-body py-2 px-1">
                                                            <span class="fw-bold">Vendidos</span><br>
                                                            <span class="fs-4 text-dark"><?php echo $vendidos; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="card card-bordered text-center">
                                                        <div class="card-body py-2 px-1">
                                                            <span class="fw-bold">Libres</span><br>
                                                            <span
                                                                class="fs-4 text-success"><?php echo $libres; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="card card-bordered text-center">
                                                        <div class="card-body py-2 px-1">
                                                            <span class="fw-bold">Reservados</span><br>
                                                            <span
                                                                class="fs-4 text-warning"><?php echo $reservados; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="card card-bordered text-center">
                                                        <div class="card-body py-2 px-1">
                                                            <span class="fw-bold">Bloqueados</span><br>
                                                            <span
                                                                class="fs-4 text-danger"><?php echo $bloqueados; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Mapa de lotes usando lotes_db directamente -->
                                            <div class="card mb-5">
                                                <div class="p-0">
                                                    <div class="d-flex align-items-center px-2 py-3 rounded-top bg-white shadow-sm barra-estados-lotes"
                                                        style="border-bottom:1.5px solid #e3e6ef;">
                                                        <div
                                                            class="d-flex gap-2 flex-wrap flex-md-nowrap estados-lotes-scroll">
                                                            <span
                                                                class="badge badge-light-success px-4 py-2 fs-6 fw-bold shadow-sm"><i
                                                                    class="fa fa-circle me-2 text-success"></i>Disponible</span>
                                                            <span
                                                                class="badge badge-light-primary px-4 py-2 fs-6 fw-bold shadow-sm"><i
                                                                    class="fa fa-check-circle me-2 text-primary"></i>Seleccionado</span>
                                                            <span
                                                                class="badge badge-light-warning px-4 py-2 fs-6 fw-bold shadow-sm"><i
                                                                    class="fa fa-clock me-2 text-warning"></i>Reservado</span>
                                                            <span
                                                                class="badge badge-light-danger px-4 py-2 fs-6 fw-bold shadow-sm"><i
                                                                    class="fa fa-ban me-2 text-danger"></i>Bloqueado</span>
                                                            <span
                                                                class="badge badge-light-dark px-4 py-2 fs-6 fw-bold shadow-sm"><i
                                                                    class="fa fa-times-circle me-2 text-dark"></i>Vendido</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <?php 
                                                    $LotModel = new \App\Models\LotModel();
                                                    $project_id = isset($_GET['project_id']) ? $_GET['project_id'] : null;
                                                    $ProjectModel = new \App\Models\ProjectModel();
                                                    $project_name = '';
                                                    if ($project_id) {
                                                        $project = $ProjectModel->find($project_id);
                                                        $project_name = $project ? $project['name'] : '';
                                                        $lotes_db = $LotModel->where('project_id', $project_id)->findAll();
                                                    } else {
                                                        $lotes_db = $LotModel->findAll();
                                                    }
                                                    if (!empty($lotes_db)):
                                                        $manzanas = [];
                                                        foreach ($lotes_db as $lote) {
                                                            $block = $lote['block'] ?? 'Sin Manzana';
                                                            $manzanas[$block][] = $lote;
                                                        }
                                                        foreach ($manzanas as $manzana => $lotes): ?>
                                                    <h6 class="mb-2">
                                                        Manzana
                                                        <?php echo htmlspecialchars($manzana); ?>
                                                    </h6>
                                                    <div class="d-flex flex-wrap mb-4">
                                                        <?php foreach ($lotes as $lote):
                                                            $estado = strtolower($lote['status']);
                                                            $btnClass = 'btn btn-secondary m-1 btn-lote';
                                                            if ($estado === 'disponible' || $estado === 'available') {
                                                                $btnClass = 'btn btn-success m-1 btn-lote';
                                                            } elseif ($estado === 'reservado' || $estado === 'reserved') {
                                                                $btnClass = 'btn btn-warning m-1 btn-lote';
                                                            } elseif ($estado === 'bloqueado' || $estado === 'blocked') {
                                                                $btnClass = 'btn btn-danger m-1 btn-lote';
                                                            } elseif ($estado === 'vendido' || $estado === 'sold') {
                                                                $btnClass = 'btn btn-dark m-1 btn-lote';
                                                            } elseif ($estado === 'seleccionado' || $estado === 'selected') {
                                                                $btnClass = 'btn btn-primary m-1 btn-lote';
                                                            }
                                                            $jsonLote = htmlspecialchars(json_encode($lote), ENT_QUOTES, 'UTF-8');
                                                        ?>
                                                        <button class="<?php echo $btnClass; ?>"
                                                            data-lote='<?php echo $jsonLote; ?>'
                                                            onclick="seleccionarLote(this, JSON.parse('<?php echo $jsonLote; ?>'))"
                                                            onmouseenter="mostrarTooltipLote(this)"
                                                            onmouseleave="ocultarTooltipLote()">
                                                            <?php echo htmlspecialchars($lote['lot_number']); ?>
                                                        </button>
                                                        <?php endforeach; ?>
                                                    </div>
                                                    <?php endforeach;
                                                    else: ?>
                                                    <div class="alert alert-info">
                                                        No hay lotes
                                                        disponibles.
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Panel de selección -->
                                    <div class="col-12 col-xl-4 mb-4 mb-xl-0">
                                        <div class="card">
                                            <div class="card-header bg-light">
                                                <h4 class="card-title">
                                                    Tu selección</h4>
                                                <?php if ($project_name): ?>
                                                <div class="mb-2">
                                                    <span class="badge badge-info">Proyecto:
                                                        <?php echo htmlspecialchars($project_name); ?></span>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="card-body">
                                                <div class="alert alert-success mb-3">
                                                    <i class="fa fa-user"></i>
                                                    Logueado como:
                                                    <b><?php echo htmlspecialchars($usuario['nombre_completo'] ?? ''); ?></b>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="input_nombre"
                                                        value="<?php echo htmlspecialchars($usuario['nombre_completo'] ?? ''); ?>"
                                                        readonly>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">DNI</label>
                                                    <input type="text" class="form-control" id="input_dni"
                                                        value="<?php echo htmlspecialchars($usuario['dni'] ?? ''); ?>"
                                                        readonly>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Correo</label>
                                                    <input type="text" class="form-control" id="input_email"
                                                        value="<?php echo htmlspecialchars($usuario['email'] ?? ''); ?>"
                                                        readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <span class="badge badge-light-success fs-5"
                                                        id="tiempo-restante">Tiempo restante: 08:08</span>
                                                </div>
                                                <div class="border p-3 rounded mb-2" style="min-width:0;">
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="radio" checked>
                                                        <label class="form-check-label">Proyecto</label>
                                                    </div>
                                                    <div><b id="lote_nombre"></b>
                                                    </div>
                                                    <div>Manzana: <b id="lote_manzana"></b>
                                                    </div>
                                                    <div>Área: <b id="lote_area"></b>
                                                    </div>
                                                    <div>Precio: <span class="text-success" id="lote_precio"></span>
                                                    </div>
                                                    <div>Estado: <span class="badge badge-success"
                                                            id="lote_estado"></span>
                                                    </div>
                                                </div>
                                                <!-- Botones de acción para el cliente -->
                                                <div class="d-grid gap-2 mb-3">
                                                    <button class="btn btn-warning btn-lg" id="btn-reservar-lote">
                                                        <i class="fa fa-clock"></i>
                                                        Reservar lote
                                                    </button>
                                                    <button class="btn btn-info btn-lg" id="btn-inicial-lote">
                                                        <i class="fa fa-money-bill-wave"></i>
                                                        Dar inicial
                                                    </button>
                                                    <button class="btn btn-success btn-lg" id="btn-contado-lote">
                                                        <i class="fa fa-credit-card"></i>
                                                        Pagar al contado
                                                    </button>
                                                </div>
                                                <!-- Modal Reservar Lote (compacto y UX mejorada) -->
                                                <div id="modal-reservar-lote" class="modal-custom"
                                                    style="display:none;">
                                                    <div class="modal-content-custom modal-content-compact">
                                                        <div class="modal-header-custom">
                                                            <span class="modal-icon-custom"><i
                                                                    class="fa fa-clock fa-2x text-warning"></i></span>
                                                            <h3 class="fw-bold mb-1" style="font-size:1.15rem;">
                                                                Reservar
                                                                lote
                                                            </h3>
                                                        </div>
                                                        <div class="modal-body-custom">
                                                            <div class="mb-1 text-center">
                                                                <span
                                                                    class="badge bg-gradient-warning text-white px-2 py-1"
                                                                    style="font-size:0.95rem;"><i
                                                                        class="fa fa-user"></i>
                                                                    <?php echo htmlspecialchars($usuario['nombre_completo'] ?? ''); ?></span>
                                                            </div>
                                                            <div class="mb-1 text-center" style="font-size:0.98rem;">
                                                                <b>Lote:</b>
                                                                <span id="modal-reserva-lote"></span>
                                                                &nbsp;
                                                                <b>Manzana:</b>
                                                                <span id="modal-reserva-manzana"></span>
                                                            </div>
                                                            <div class="mb-1 text-center" style="font-size:1.05rem;">
                                                                <b>Precio:</b>
                                                                <span class="text-success"
                                                                    id="modal-reserva-precio"></span>
                                                            </div>
                                                            <div class="mb-2 text-center">
                                                                <label class="form-label"
                                                                    style="font-size:0.97rem;">Monto de reserva:</label>
                                                                <select class="form-select form-select-sm"
                                                                    id="select-monto-reserva"
                                                                    style="max-width:180px;display:inline-block;margin:auto;"></select>
                                                            </div>
                                                            <!-- Nueva sección: Plan de cuotas -->
                                                            <div class="mb-2 text-center">
                                                                <label class="form-label"
                                                                    style="font-size:0.97rem;">Plan de cuotas:</label>
                                                                <select class="form-select form-select-sm"
                                                                    id="select-plan-cuotas"
                                                                    style="max-width:180px;display:inline-block;margin:auto;">
                                                                    <option value="12">12 cuotas</option>
                                                                    <option value="24">24 cuotas</option>
                                                                    <option value="36">36 cuotas</option>
                                                                    <option value="48">48 cuotas</option>
                                                                </select>
                                                            </div>
                                                            <!-- QR grande arriba -->
                                                            <div class="mb-2 text-center">
                                                                <img src="<?php echo site_url('assets/front/img/gest.jpg'); ?>"
                                                                    alt="QR"
                                                                    style="max-width:160px;border:2.5px solid #e3e6ef;border-radius:16px;box-shadow:0 4px 18px #0002;">
                                                                <div
                                                                    style="font-size:1.05rem;color:#1a4e9b;margin-top:6px;font-weight:500;">
                                                                    Escanea
                                                                    el
                                                                    QR
                                                                </div>
                                                            </div>
                                                            <div class="mb-2 text-center">
                                                                <img src="<?php echo site_url('assets/front/img/bbva-logo.png'); ?>"
                                                                    alt="BBVA"
                                                                    style="height:22px;vertical-align:middle;">
                                                                <span class="fw-bold ms-1"
                                                                    style="font-size:1.05rem;">GRUPO
                                                                    VIVENCIA
                                                                    S.A.C</span><br>
                                                                <span class="fw-bold text-primary"
                                                                    style="font-size:1.08rem;">0011
                                                                    0083
                                                                    0200310937
                                                                    34</span>
                                                                <button class="btn btn-xs btn-light ms-1 py-0 px-2"
                                                                    style="font-size:0.98rem;"
                                                                    onclick="copiarCuenta()"><i class="fa fa-copy"></i>
                                                                    Copiar</button>
                                                                <div class="text-muted" style="font-size:0.93rem;">
                                                                    RUC:
                                                                    20612232998
                                                                </div>
                                                            </div>
                                                            <div class="mb-2 text-center">
                                                                <span class="fw-bold text-success"
                                                                    style="font-size:1.08rem;">Monto total:
                                                                    <span id="modal-reserva-monto"></span></span>
                                                            </div>
                                                            <div class="mb-2 text-center">
                                                                <label class="form-label"
                                                                    style="font-size:0.97rem;">Adjunta
                                                                    tu
                                                                    voucher
                                                                    de
                                                                    reserva:</label>
                                                                <input type="file" class="form-control form-control-sm"
                                                                    id="input-reserva-comprobante"
                                                                    style="max-width:220px;margin:auto;"
                                                                    accept=".pdf,image/png,image/jpeg,image/jpg,image/webp">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer-custom" style="margin-top:10px;">
                                                            <button class="btn btn-warning btn-sm px-3"
                                                                id="btn-registrar-reserva">Reservar</button>
                                                            <button class="btn btn-secondary btn-sm px-3"
                                                                onclick="cerrarModal('modal-reservar-lote')">Cancelar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal Inicial Lote (con QR grande y cuenta) -->
                                                <div id="modal-inicial-lote" class="modal-custom" style="display:none;">
                                                    <div class="modal-content-custom modal-content-compact">
                                                        <div class="modal-header-custom">
                                                            <span class="modal-icon-custom"><i
                                                                    class="fa fa-money-bill-wave fa-2x text-info"></i></span>
                                                            <h3 class="fw-bold mb-1" style="font-size:1.15rem;">Dar
                                                                inicial</h3>
                                                        </div>
                                                        <div class="modal-body-custom">
                                                            <div class="mb-1 text-center">
                                                                <span
                                                                    class="badge bg-gradient-info text-white px-2 py-1"
                                                                    style="font-size:0.95rem;">
                                                                    <i class="fa fa-user"></i>
                                                                    <?php echo htmlspecialchars($usuario['nombre_completo'] ?? ''); ?>
                                                                </span>
                                                            </div>
                                                            <div class="mb-1 text-center" style="font-size:0.98rem;">
                                                                <b>Lote:</b> <span
                                                                    id="modal-inicial-lote-nombre"></span> &nbsp;
                                                                <b>Manzana:</b> <span id="modal-inicial-manzana"></span>
                                                            </div>
                                                            <div class="mb-1 text-center" style="font-size:1.05rem;">
                                                                <b>Monto total:</b> <span class="text-info"
                                                                    id="modal-inicial-precio">S/ 10,000.00</span>
                                                            </div>
                                                            <!-- Select monto inicial -->
                                                            <div class="mb-2 text-center">
                                                                <label class="form-label"
                                                                    style="font-size:0.97rem;">Monto de inicial:</label>
                                                                <select class="form-select form-select-sm"
                                                                    id="select-monto-inicial"
                                                                    style="max-width:180px;display:inline-block;margin:auto;"></select>
                                                            </div>
                                                            <!-- Select plan de cuotas -->
                                                            <div class="mb-2 text-center">
                                                                <label class="form-label"
                                                                    style="font-size:0.97rem;">Plan de cuotas:</label>
                                                                <select class="form-select form-select-sm"
                                                                    id="select-plan-cuotas-inicial"
                                                                    style="max-width:180px;display:inline-block;margin:auto;">
                                                                    <option value="12">12 cuotas</option>
                                                                    <option value="24">24 cuotas</option>
                                                                    <option value="36">36 cuotas</option>
                                                                    <option value="48">48 cuotas</option>
                                                                </select>
                                                            </div>
                                                            <!-- QR grande arriba -->
                                                            <div class="mb-2 text-center">
                                                                <img src="<?php echo site_url('assets/front/img/gest.jpg'); ?>"
                                                                    alt="QR"
                                                                    style="max-width:160px;border:2.5px solid #e3e6ef;border-radius:16px;box-shadow:0 4px 18px #0002;">
                                                                <div
                                                                    style="font-size:1.05rem;color:#1a4e9b;margin-top:6px;font-weight:500;">
                                                                    Escanea el QR</div>
                                                            </div>
                                                            <div class="mb-2 text-center">
                                                                <img src="<?php echo site_url('assets/front/img/bbva-logo.png'); ?>"
                                                                    alt="BBVA"
                                                                    style="height:22px;vertical-align:middle;">
                                                                <span class="fw-bold ms-1"
                                                                    style="font-size:1.05rem;">GRUPO VIVENCIA
                                                                    S.A.C</span><br>
                                                                <span class="fw-bold text-primary"
                                                                    style="font-size:1.08rem;">0011 0083 0200310937
                                                                    34</span>
                                                                <button class="btn btn-xs btn-light ms-1 py-0 px-2"
                                                                    style="font-size:0.98rem;"
                                                                    onclick="copiarCuenta()"><i class="fa fa-copy"></i>
                                                                    Copiar</button>
                                                                <div class="text-muted" style="font-size:0.93rem;">RUC:
                                                                    20612232998</div>
                                                            </div>
                                                            <div class="mb-2 text-center">
                                                                <span class="fw-bold text-info"
                                                                    style="font-size:1.08rem;">Monto total: <span
                                                                        id="modal-inicial-precio">S/
                                                                        10,000.00</span></span>
                                                            </div>
                                                            <div class="mb-2 text-center">
                                                                <label class="form-label"
                                                                    style="font-size:0.97rem;">Adjunta tu voucher de
                                                                    inicial:</label>
                                                                <input type="file" class="form-control form-control-sm"
                                                                    id="input-inicial-comprobante"
                                                                    style="max-width:220px;margin:auto;"
                                                                    accept=".pdf,image/png,image/jpeg,image/jpg,image/webp">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer-custom" style="margin-top:10px;">
                                                            <button class="btn btn-info btn-sm px-3"
                                                                id="btn-registrar-inicial">Registrar inicial</button>
                                                            <button class="btn btn-secondary btn-sm px-3"
                                                                onclick="cerrarModal('modal-inicial-lote')">Cancelar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal Contado Lote (con QR grande y cuenta) -->
                                                <div id="modal-contado-lote" class="modal-custom" style="display:none;">
                                                    <div class="modal-content-custom modal-content-compact">
                                                        <div class="modal-header-custom">
                                                            <span class="modal-icon-custom"><i
                                                                    class="fa fa-credit-card fa-2x text-success"></i></span>
                                                            <h3 class="fw-bold mb-1" style="font-size:1.15rem;">Pagar al
                                                                contado</h3>
                                                        </div>
                                                        <div class="modal-body-custom">
                                                            <div class="mb-1 text-center">
                                                                <span
                                                                    class="badge bg-gradient-success text-white px-2 py-1"
                                                                    style="font-size:0.95rem;"><i
                                                                        class="fa fa-user"></i>
                                                                    <?php echo htmlspecialchars($usuario['nombre_completo'] ?? ''); ?></span>
                                                            </div>
                                                            <div class="mb-1 text-center" style="font-size:0.98rem;">
                                                                <b>Lote:</b> <span
                                                                    id="modal-contado-lote-nombre"></span> &nbsp;
                                                                <b>Manzana:</b> <span id="modal-contado-manzana"></span>
                                                            </div>
                                                            <div class="mb-1 text-center" style="font-size:1.05rem;">
                                                                <b>Total:</b> <span class="text-success"
                                                                    id="modal-contado-precio"></span>
                                                            </div>
                                                            <!-- Línea de 'Monto total' eliminada por solicitud -->
                                                            <!-- QR grande arriba -->
                                                            <div class="mb-2 text-center">
                                                                <img src="<?php echo site_url('assets/front/img/gest.jpg'); ?>"
                                                                    alt="QR"
                                                                    style="max-width:160px;border:2.5px solid #e3e6ef;border-radius:16px;box-shadow:0 4px 18px #0002;">
                                                                <div
                                                                    style="font-size:1.05rem;color:#1a4e9b;margin-top:6px;font-weight:500;">
                                                                    Escanea el QR</div>
                                                            </div>
                                                            <div class="mb-2 text-center">
                                                                <img src="<?php echo site_url('assets/front/img/bbva-logo.png'); ?>"
                                                                    alt="BBVA"
                                                                    style="height:22px;vertical-align:middle;">
                                                                <span class="fw-bold ms-1"
                                                                    style="font-size:1.05rem;">GRUPO VIVENCIA
                                                                    S.A.C</span><br>
                                                                <span class="fw-bold text-primary"
                                                                    style="font-size:1.08rem;">0011 0083 0200310937
                                                                    34</span>
                                                                <button class="btn btn-xs btn-light ms-1 py-0 px-2"
                                                                    style="font-size:0.98rem;"
                                                                    onclick="copiarCuenta()"><i class="fa fa-copy"></i>
                                                                    Copiar</button>
                                                                <div class="text-muted" style="font-size:0.93rem;">RUC:
                                                                    20612232998</div>
                                                            </div>

                                                            <div class="mb-2 text-center">
                                                                <label class="form-label"
                                                                    style="font-size:0.97rem;">Adjunta tu voucher de
                                                                    pago total:</label>
                                                                <input type="file" class="form-control form-control-sm"
                                                                    id="input-contado-comprobante"
                                                                    style="max-width:220px;margin:auto;"
                                                                    accept=".pdf,image/png,image/jpeg,image/jpg,image/webp">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer-custom" style="margin-top:10px;">
                                                            <button class="btn btn-success btn-sm px-3"
                                                                id="btn-registrar-contado">Registrar pago</button>
                                                            <button class="btn btn-secondary btn-sm px-3"
                                                                onclick="cerrarModal('modal-contado-lote')">Cancelar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal Pago QR y Cuenta BBVA -->
                                                <div id="modal-pago-qr" class="modal-custom" style="display:none;">
                                                    <div class="modal-content-custom">
                                                        <div class="modal-header-custom">
                                                            <span class="modal-icon-custom"><i
                                                                    class="fa fa-credit-card fa-3x text-info"></i></span>
                                                            <h3 class="fw-bold mb-2">
                                                                Realiza
                                                                el pago
                                                            </h3>
                                                        </div>
                                                        <div class="modal-body-custom">
                                                            <div class="mb-3 text-center">
                                                                <img src="<?php echo site_url('assets/front/img/gest.jpg'); ?>"
                                                                    alt="QR" style="max-width:180px;">
                                                                <div class="mt-2">
                                                                    <span
                                                                        class="badge bg-gradient-info px-3 py-2">Escanea
                                                                        el
                                                                        QR
                                                                        desde
                                                                        tu
                                                                        app
                                                                        bancaria</span>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 text-center">
                                                                <img src="<?php echo site_url('assets/front/img/bbva-logo.png'); ?>"
                                                                    alt="BBVA"
                                                                    style="height:32px;vertical-align:middle;">
                                                                <span class="fw-bold ms-2">GRUPO
                                                                    VIVENCIA
                                                                    S.A.C</span><br>
                                                                <span class="fw-bold text-primary">0011
                                                                    0083
                                                                    0200310937
                                                                    34</span>
                                                                <button class="btn btn-sm btn-light ms-2"
                                                                    onclick="copiarCuenta()"><i class="fa fa-copy"></i>
                                                                    Copiar</button>
                                                                <div class="mt-1 text-muted">
                                                                    RUC:
                                                                    20612232998
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 text-center">
                                                                <span class="fs-4 fw-bold text-success">Monto:
                                                                    <span id="modal-monto-pago"></span></span>
                                                            </div>
                                                            <div class="mb-3 text-center">
                                                                <label class="form-label">¿Cuántas
                                                                    cuotas
                                                                    deseas?</label>
                                                                <select class="form-select" id="select-cuotas"
                                                                    style="max-width:180px;display:inline-block;">
                                                                    <option value="12">
                                                                        12
                                                                        cuotas
                                                                    </option>
                                                                    <option value="24">
                                                                        24
                                                                        cuotas
                                                                    </option>
                                                                    <option value="36">
                                                                        36
                                                                        cuotas
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 text-center">
                                                                <label class="form-label">Adjunta
                                                                    tu
                                                                    comprobante
                                                                    (opcional):</label>
                                                                <input type="file" class="form-control"
                                                                    id="input-comprobante">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer-custom">
                                                            <button class="btn btn-success"
                                                                id="btn-registrar-pago">Registrar
                                                                pago</button>
                                                            <button class="btn btn-secondary"
                                                                onclick="cerrarModal('modal-pago-qr')">Cancelar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Estilos modales y extras -->
                                                <style>
                                                .modal-custom {
                                                    position: fixed;
                                                    top: 0;
                                                    left: 0;
                                                    width: 100vw;
                                                    height: 100vh;
                                                    background: rgba(0, 0, 0, 0.18);
                                                    display: flex;
                                                    align-items: center;
                                                    justify-content: center;
                                                    z-index: 9999;
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

                                                @media (max-width: 575.98px) {
                                                    .modal-content-custom {
                                                        min-width: 0;
                                                        max-width: 98vw;
                                                        padding: 18px 8px 12px 8px;
                                                    }

                                                    .card-title,
                                                    .modal-header-custom h3 {
                                                        font-size: 1.1rem;
                                                    }

                                                    .modal-custom {
                                                        align-items: flex-start;
                                                    }
                                                }

                                                .modal-header-custom {
                                                    text-align: center;
                                                    margin-bottom: 18px;
                                                }

                                                .modal-icon-custom {
                                                    display: block;
                                                    margin-bottom: 8px;
                                                }

                                                .modal-footer-custom {
                                                    display: flex;
                                                    gap: 12px;
                                                    justify-content: center;
                                                    margin-top: 18px;
                                                    flex-wrap: wrap;
                                                }

                                                @keyframes modalIn {
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
                                                <script>
                                                // Temporizador funcional para "Tiempo restante" en el panel lateral
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    var tiempoRestante = 8 * 60 + 8; // 8 minutos y 8 segundos
                                                    var badge = document.getElementById('tiempo-restante');

                                                    function actualizarTiempo() {
                                                        if (!badge) return;
                                                        var minutos = Math.floor(tiempoRestante / 60);
                                                        var segundos = tiempoRestante % 60;
                                                        badge.textContent = 'Tiempo restante: ' +
                                                            (minutos < 10 ? '0' : '') + minutos + ':' +
                                                            (segundos < 10 ? '0' : '') + segundos;
                                                        if (tiempoRestante > 0) {
                                                            tiempoRestante--;
                                                            setTimeout(actualizarTiempo, 1000);
                                                        } else {
                                                            badge.textContent = 'Tiempo agotado';
                                                            // Deshabilitar botones al agotar el tiempo
                                                            var btns = [
                                                                document.getElementById(
                                                                    'btn-reservar-lote'),
                                                                document.getElementById('btn-inicial-lote'),
                                                                document.getElementById('btn-contado-lote')
                                                            ];
                                                            btns.forEach(function(btn) {
                                                                if (btn) btn.disabled = true;
                                                            });
                                                        }
                                                    }
                                                    actualizarTiempo();
                                                });
                                                </script>
                                                <script>
                                                // Botones de acción para el cliente
                                                document.getElementById(
                                                        'btn-reservar-lote'
                                                    ).onclick =
                                                    function() {
                                                        // Set lot info
                                                        document
                                                            .getElementById(
                                                                'modal-reserva-lote'
                                                            )
                                                            .textContent =
                                                            document
                                                            .getElementById(
                                                                'lote_nombre'
                                                            )
                                                            .textContent ||
                                                            '-';
                                                        document
                                                            .getElementById(
                                                                'modal-reserva-manzana'
                                                            )
                                                            .textContent =
                                                            document
                                                            .getElementById(
                                                                'lote_manzana'
                                                            )
                                                            .textContent ||
                                                            '-';
                                                        var precio =
                                                            document
                                                            .getElementById(
                                                                'lote_precio'
                                                            )
                                                            .textContent ||
                                                            '-';
                                                        document
                                                            .getElementById(
                                                                'modal-reserva-precio'
                                                            )
                                                            .textContent =
                                                            precio;
                                                        document
                                                            .getElementById(
                                                                'modal-reserva-monto'
                                                            )
                                                            .textContent =
                                                            precio;
                                                        // Solo opción de S/ 1,000 para monto de reserva
                                                        var select = document.getElementById('select-monto-reserva');
                                                        select.innerHTML = '';
                                                        var opt = document.createElement('option');
                                                        opt.value = 1000;
                                                        opt.textContent = 'S/ 1,000.00';
                                                        select.appendChild(opt);
                                                        select.value = 1000;
                                                        document.getElementById('modal-reservar-lote').style.display =
                                                            'flex';
                                                    };
                                                document.getElementById(
                                                        'btn-inicial-lote'
                                                    ).onclick =
                                                    function() {
                                                        document
                                                            .getElementById(
                                                                'modal-inicial-lote-nombre'
                                                            )
                                                            .textContent =
                                                            document
                                                            .getElementById(
                                                                'lote_nombre'
                                                            )
                                                            .textContent ||
                                                            '-';
                                                        document
                                                            .getElementById(
                                                                'modal-inicial-manzana'
                                                            )
                                                            .textContent =
                                                            document
                                                            .getElementById(
                                                                'lote_manzana'
                                                            )
                                                            .textContent ||
                                                            '-';
                                                        document
                                                            .getElementById(
                                                                'modal-inicial-precio'
                                                            )
                                                            .textContent =
                                                            'S/ 10,000.00';
                                                        document
                                                            .getElementById(
                                                                'modal-inicial-lote'
                                                            ).style
                                                            .display =
                                                            'flex';
                                                    };
                                                document.getElementById(
                                                        'btn-contado-lote'
                                                    ).onclick =
                                                    function() {
                                                        document
                                                            .getElementById(
                                                                'modal-contado-lote-nombre'
                                                            )
                                                            .textContent =
                                                            document
                                                            .getElementById(
                                                                'lote_nombre'
                                                            )
                                                            .textContent ||
                                                            '-';
                                                        document
                                                            .getElementById(
                                                                'modal-contado-manzana'
                                                            )
                                                            .textContent =
                                                            document
                                                            .getElementById(
                                                                'lote_manzana'
                                                            )
                                                            .textContent ||
                                                            '-';
                                                        document
                                                            .getElementById(
                                                                'modal-contado-precio'
                                                            )
                                                            .textContent =
                                                            document
                                                            .getElementById(
                                                                'lote_precio'
                                                            )
                                                            .textContent ||
                                                            '-';
                                                        document
                                                            .getElementById(
                                                                'modal-contado-lote'
                                                            ).style
                                                            .display =
                                                            'flex';
                                                    };

                                                // Registrar reserva
                                                document.getElementById('btn-registrar-reserva').onclick = function() {
                                                    var btn = document.getElementById('btn-registrar-reserva');
                                                    btn.disabled = true;
                                                    mostrarLoader();
                                                    var lote = document.getElementById('lote_nombre').textContent;
                                                    var manzana = document.getElementById('lote_manzana')
                                                        .textContent;
                                                    var precio = document.getElementById('lote_precio').textContent
                                                        .replace('S/', '').replace(/,/g, '').trim();
                                                    var monto_reserva = document.getElementById(
                                                        'select-monto-reserva').value;
                                                    var plan_cuotas = document.getElementById('select-plan-cuotas')
                                                        .value;
                                                    var nombre = document.getElementById('input_nombre').value;
                                                    var dni = document.getElementById('input_dni').value;
                                                    var email = document.getElementById('input_email').value;
                                                    var comprobante = document.getElementById(
                                                        'input-reserva-comprobante').files[0];
                                                    var formData = new FormData();
                                                    formData.append('accion', 'reservar');
                                                    formData.append('lote', lote);
                                                    formData.append('manzana', manzana);
                                                    formData.append('precio', precio);
                                                    formData.append('monto_reserva', monto_reserva);
                                                    formData.append('plan_cuotas', plan_cuotas);
                                                    formData.append('nombre', nombre);
                                                    formData.append('dni', dni);
                                                    formData.append('email', email);
                                                    if (comprobante) formData.append('comprobante', comprobante);
                                                    fetch('<?php echo site_url('cart/accionLote'); ?>', {
                                                            method: 'POST',
                                                            body: formData
                                                        })
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            document.getElementById('modal-reservar-lote').style
                                                                .display = 'none';
                                                            Swal.fire({
                                                                icon: data.success ? 'success' :
                                                                    'error',
                                                                title: data.success ?
                                                                    '¡Reserva registrada!' : 'Error',
                                                                text: data.message || (data.success ?
                                                                    'Tu reserva será validada.' :
                                                                    'Intenta nuevamente.'),
                                                                confirmButtonText: 'Aceptar'
                                                            }).then(function() {
                                                                location.reload();
                                                            });
                                                        })
                                                        .catch(error => {
                                                            document.getElementById('modal-reservar-lote').style
                                                                .display = 'none';
                                                            Swal.fire({
                                                                icon: 'error',
                                                                title: 'Error de conexión',
                                                                confirmButtonText: 'Aceptar'
                                                            });
                                                        })
                                                        .finally(function() {
                                                            btn.disabled = false;
                                                            ocultarLoader();
                                                        });
                                                };
                                                // Registrar inicial
                                                document.getElementById('btn-inicial-lote').onclick = function() {
                                                    document.getElementById('modal-inicial-lote-nombre')
                                                        .textContent = document.getElementById('lote_nombre')
                                                        .textContent || '-';
                                                    document.getElementById('modal-inicial-manzana').textContent =
                                                        document.getElementById('lote_manzana').textContent || '-';
                                                    var precio = document.getElementById('lote_precio')
                                                        .textContent || 'S/ 10,000.00';
                                                    document.getElementById('modal-inicial-precio').textContent =
                                                        precio;
                                                    // Populate select-monto-inicial
                                                    var precioNum = Number(precio.replace('S/', '').replace(/,/g,
                                                        '').trim());
                                                    var select = document.getElementById('select-monto-inicial');
                                                    select.innerHTML = '';
                                                    var minInicial = 1000;
                                                    var step = 500;
                                                    for (var monto = minInicial; monto <= precioNum; monto +=
                                                        step) {
                                                        var opt = document.createElement('option');
                                                        opt.value = monto;
                                                        opt.textContent = 'S/ ' + monto.toLocaleString('es-PE', {
                                                            minimumFractionDigits: 2
                                                        });
                                                        select.appendChild(opt);
                                                    }
                                                    if (precioNum % step !== 0) {
                                                        var opt = document.createElement('option');
                                                        opt.value = precioNum;
                                                        opt.textContent = 'S/ ' + precioNum.toLocaleString(
                                                            'es-PE', {
                                                                minimumFractionDigits: 2
                                                            });
                                                        select.appendChild(opt);
                                                    }
                                                    select.value = minInicial;
                                                    document.getElementById('modal-inicial-lote').style.display =
                                                        'flex';
                                                };

                                                document.getElementById('btn-registrar-inicial').onclick = function() {
                                                    var btn = document.getElementById('btn-registrar-inicial');
                                                    btn.disabled = true;
                                                    mostrarLoader();
                                                    var lote = document.getElementById('lote_nombre').textContent;
                                                    var manzana = document.getElementById('lote_manzana')
                                                        .textContent;
                                                    var inicial = document.getElementById('select-monto-inicial')
                                                        .value;
                                                    var plan_cuotas = document.getElementById(
                                                        'select-plan-cuotas-inicial').value;
                                                    var nombre = document.getElementById('input_nombre').value;
                                                    var dni = document.getElementById('input_dni').value;
                                                    var email = document.getElementById('input_email').value;
                                                    var comprobante = document.getElementById(
                                                        'input-inicial-comprobante').files[0];
                                                    var formData = new FormData();
                                                    formData.append('accion', 'inicial');
                                                    formData.append('lote', lote);
                                                    formData.append('manzana', manzana);
                                                    formData.append('inicial', inicial);
                                                    formData.append('plan_cuotas', plan_cuotas);
                                                    formData.append('nombre', nombre);
                                                    formData.append('dni', dni);
                                                    formData.append('email', email);
                                                    if (comprobante) formData.append('comprobante', comprobante);
                                                    fetch('<?php echo site_url('cart/accionLote'); ?>', {
                                                            method: 'POST',
                                                            body: formData
                                                        })
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            document.getElementById('modal-inicial-lote').style
                                                                .display = 'none';
                                                            Swal.fire({
                                                                icon: data.success ? 'success' :
                                                                    'error',
                                                                title: data.success ?
                                                                    '¡Inicial registrada!' : 'Error',
                                                                text: data.message || (data.success ?
                                                                    'Tu pago será validado.' :
                                                                    'Intenta nuevamente.'),
                                                                confirmButtonText: 'Aceptar'
                                                            }).then(function() {
                                                                location.reload();
                                                            });
                                                        })
                                                        .catch(error => {
                                                            document.getElementById('modal-inicial-lote').style
                                                                .display = 'none';
                                                            Swal.fire({
                                                                icon: 'error',
                                                                title: 'Error de conexión',
                                                                confirmButtonText: 'Aceptar'
                                                            });
                                                        })
                                                        .finally(function() {
                                                            btn.disabled = false;
                                                            ocultarLoader();
                                                        });
                                                };
                                                // Registrar pago contado
                                                document.getElementById('btn-contado-lote').onclick = function() {
                                                    document.getElementById('modal-contado-lote-nombre')
                                                        .textContent = document.getElementById('lote_nombre')
                                                        .textContent || '-';
                                                    document.getElementById('modal-contado-manzana').textContent =
                                                        document.getElementById('lote_manzana').textContent || '-';
                                                    var precio = document.getElementById('lote_precio')
                                                        .textContent || '-';
                                                    document.getElementById('modal-contado-precio').textContent =
                                                        precio;
                                                    document.getElementById('modal-contado-lote').style.display =
                                                        'flex';
                                                };

                                                document.getElementById('btn-registrar-contado').onclick = function() {
                                                    var btn = document.getElementById('btn-registrar-contado');
                                                    btn.disabled = true;
                                                    mostrarLoader();
                                                    var lote = document.getElementById('lote_nombre').textContent;
                                                    var manzana = document.getElementById('lote_manzana')
                                                        .textContent;
                                                    var precio = document.getElementById('lote_precio').textContent
                                                        .replace('S/', '').replace(/,/g, '').trim();
                                                    var nombre = document.getElementById('input_nombre').value;
                                                    var dni = document.getElementById('input_dni').value;
                                                    var email = document.getElementById('input_email').value;
                                                    var comprobante = document.getElementById(
                                                        'input-contado-comprobante').files[0];
                                                    var formData = new FormData();
                                                    formData.append('accion', 'contado');
                                                    formData.append('lote', lote);
                                                    formData.append('manzana', manzana);
                                                    formData.append('precio', precio);
                                                    formData.append('nombre', nombre);
                                                    formData.append('dni', dni);
                                                    formData.append('email', email);
                                                    if (comprobante) formData.append('comprobante', comprobante);
                                                    fetch('<?php echo site_url('cart/accionLote'); ?>', {
                                                            method: 'POST',
                                                            body: formData
                                                        })
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            document.getElementById('modal-contado-lote').style
                                                                .display = 'none';
                                                            Swal.fire({
                                                                icon: data.success ? 'success' :
                                                                    'error',
                                                                title: data.success ?
                                                                    '¡Pago registrado!' : 'Error',
                                                                text: data.message || (data.success ?
                                                                    'Tu pago será validado.' :
                                                                    'Intenta nuevamente.'),
                                                                confirmButtonText: 'Aceptar'
                                                            }).then(function() {
                                                                location.reload();
                                                            });
                                                        })
                                                        .catch(error => {
                                                            document.getElementById('modal-contado-lote').style
                                                                .display = 'none';
                                                            Swal.fire({
                                                                icon: 'error',
                                                                title: 'Error de conexión',
                                                                confirmButtonText: 'Aceptar'
                                                            });
                                                        })
                                                        .finally(function() {
                                                            btn.disabled = false;
                                                            ocultarLoader();
                                                        });
                                                };

                                                function cerrarModal(
                                                    id) {
                                                    document
                                                        .getElementById(
                                                            id).style
                                                        .display =
                                                        'none';
                                                }

                                                function copiarCuenta() {
                                                    navigator.clipboard
                                                        .writeText(
                                                            '0011 0083 0200310937 34'
                                                        );
                                                    alert(
                                                        'Número de cuenta copiado'
                                                    );
                                                }
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo view('backoffice_new/footer'); ?>
            </div>
        </div>
    </div>
</body>
<!-- Scripts Metronic y FontAwesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js">
</script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo site_url() . 'assets/metronic8/plugins/global/plugins.bundle.js'; ?>">
</script>
<script src="<?php echo site_url() . 'assets/metronic8/js/scripts.bundle.js'; ?>">
</script>
<script src="<?php echo site_url() . 'assets/metronic8/js/link_nav.js'; ?>">
</script>
</body>
<!-- Debug removido por solicitud -->
<style>
.barra-estados-lotes {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.estados-lotes-scroll {
    min-width: 340px;
    width: 100%;
    overflow-x: auto;
    flex-wrap: nowrap !important;
}

@media (max-width: 575.98px) {
    .estados-lotes-scroll {
        min-width: 340px;
        width: 100%;
        overflow-x: auto;
        flex-wrap: nowrap !important;
    }

    .barra-estados-lotes {
        padding-left: 0.5rem !important;
        padding-right: 0.5rem !important;
    }

    .estados-lotes-scroll span {
        font-size: 0.95rem !important;
        padding: 0.5rem 0.7rem !important;
    }
}

.lote-tooltip {
    position: absolute;
    z-index: 9999;
    background: #fff;
    color: #222;
    border: 1.5px solid #1a4e9b;
    border-radius: 12px;
    box-shadow: 0 4px 24px 0 #00000022;
    padding: 18px 24px;
    font-size: 15px;
    min-width: 220px;
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.18s;
    max-width: 95vw;
    word-break: break-word;
}

.lote-tooltip.show {
    opacity: 1;
}

@media (max-width: 575.98px) {
    .lote-tooltip {
        font-size: 13px;
        min-width: 140px;
        padding: 10px 8px;
    }
}
</style>
<script>
// Selección de lote y actualización del panel lateral
function actualizarPanelSeleccion(lote) {
    document.getElementById('lote_nombre').textContent = lote.lot_number;
    document.getElementById('lote_manzana').textContent = lote.block || '';
    document.getElementById('lote_area').textContent = lote.area_sqm + ' m²';
    document.getElementById('lote_precio').textContent = 'S/ ' + Number(lote.current_price).toLocaleString('es-PE', {
        minimumFractionDigits: 2
    });
    // Traducción de estado
    var estadoMap = {
        'sold': 'Vendido',
        'vendido': 'Vendido',
        'available': 'Disponible',
        'disponible': 'Disponible',
        'reserved': 'Reservado',
        'reservado': 'Reservado',
        'blocked': 'Bloqueado',
        'bloqueado': 'Bloqueado',
        'selected': 'Seleccionado',
        'seleccionado': 'Seleccionado'
    };
    var estadoEsp = estadoMap[lote.status.toLowerCase()] || lote.status;
    document.getElementById('lote_estado').textContent = estadoEsp;
}


// Tooltip moderno para lotes al pasar el mouse
let loteTooltip = null;

function mostrarTooltipLote(btn) {
    var lote = btn.getAttribute('data-lote');
    if (!lote) return;
    lote = JSON.parse(lote);
    if (!loteTooltip) {
        loteTooltip = document.createElement('div');
        loteTooltip.className = 'lote-tooltip';
        document.body.appendChild(loteTooltip);
    }
    // Traducción de estado
    var estadoMap = {
        'sold': 'Vendido',
        'vendido': 'Vendido',
        'available': 'Disponible',
        'disponible': 'Disponible',
        'reserved': 'Reservado',
        'reservado': 'Reservado',
        'blocked': 'Bloqueado',
        'bloqueado': 'Bloqueado',
        'selected': 'Seleccionado',
        'seleccionado': 'Seleccionado'
    };
    var estadoEsp = estadoMap[lote.status.toLowerCase()] || lote.status;
    var badgeClass = 'badge badge-success';
    switch (estadoEsp) {
        case 'Vendido':
            badgeClass = 'badge badge-dark';
            break;
        case 'Disponible':
            badgeClass = 'badge badge-success';
            break;
        case 'Reservado':
            badgeClass = 'badge badge-warning';
            break;
        case 'Bloqueado':
            badgeClass = 'badge badge-danger';
            break;
        case 'Seleccionado':
            badgeClass = 'badge badge-primary';
            break;
    }
    loteTooltip.innerHTML = `
        <div style='font-weight:700;color:#1a4e9b;font-size:17px;'>Lote ${lote.lot_number}</div>
        <div><b>Manzana:</b> ${lote.block || '-'}</div>
        <div><b>Área:</b> ${lote.area_sqm} m²</div>
        <div><b>Precio:</b> <span style='color:#1bc47d;'>S/ ${Number(lote.current_price).toLocaleString('es-PE', {minimumFractionDigits:2})}</span></div>
        <div><b>Estado:</b> <span class='${badgeClass}'>${estadoEsp}</span></div>
    `;
    loteTooltip.classList.add('show');
    // Posicionar el tooltip cerca del botón
    const rect = btn.getBoundingClientRect();
    loteTooltip.style.top = (window.scrollY + rect.bottom + 10) + 'px';
    loteTooltip.style.left = (window.scrollX + rect.left + rect.width / 2 - loteTooltip.offsetWidth / 2) + 'px';
}

function ocultarTooltipLote() {
    if (loteTooltip) loteTooltip.classList.remove('show');
}

function seleccionarLote(btn, loteData) {
    var estado = loteData.status.toLowerCase();
    if (estado === 'vendido' || estado === 'sold') {
        Swal.fire({
            icon: 'error',
            title: 'Lote vendido',
            text: 'Este lote ya está vendido. Por favor, selecciona otro.'
        });
        return;
    }
    if (estado === 'reservado' || estado === 'reserved') {
        Swal.fire({
            icon: 'warning',
            title: 'Lote reservado',
            text: 'Este lote ya está reservado. Por favor, selecciona otro.'
        });
        return;
    }
    // Quitar selección previa
    document.querySelectorAll('.btn-lote').forEach(function(b) {
        b.classList.remove('btn-outline-info');
    });
    btn.classList.add('btn-outline-info');
    actualizarPanelSeleccion(loteData);
}
// Ocultar tooltip si se hace click fuera
document.addEventListener('click', function(e) {
    if (loteTooltip && !e.target.classList.contains('btn-lote')) {
        ocultarTooltipLote();
    }
});
</script>