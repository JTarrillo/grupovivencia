<!doctype html>
<html lang="es-PE">
<?php echo view("admin/head"); ?>

<!-- SweetAlert2 CSS && JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<style>
/* MEJORAS DE DISEÑO */
.table thead th {
    background-color: #f8f9fa;
    text-transform: uppercase;
    font-size: 11px;
    letter-spacing: 1px;
    font-weight: 700;
    color: #727cf5;
    border-bottom: 2px solid #eef2f7;
}

.table td {
    vertical-align: middle !important;
}

.btn-action {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
    margin: 0 2px;
    transition: all 0.2s;
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Badge suave para el estado */
.badge-soft-success {
    background-color: rgba(10, 207, 151, 0.15);
    color: #0acf97;
    border: 1px solid rgba(10, 207, 151, 0.2);
    padding: 6px 10px;
    font-weight: 600;
}

.rotate {
    animation: rotation 1.5s infinite linear;
}

@keyframes rotation {
    from {
        transform: rotate(0deg);
    }

    to {
        transform: rotate(359deg);
    }
}

/* PERSONALIZACIÓN MINIMALISTA DE SWEETALERT2 */
.swal2-popup {
    border-radius: 12px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15) !important;
    background-color: white !important;
}

.swal2-title {
    font-size: 20px;
    font-weight: 600;
    color: #333;
    margin-bottom: 12px;
}

.swal2-html-container {
    font-size: 14px;
    line-height: 1.5;
    color: #666;
}

.swal2-confirm,
.swal2-cancel {
    padding: 10px 25px !important;
    border-radius: 6px !important;
    font-weight: 500 !important;
    font-size: 14px !important;
}

.swal2-confirm {
    background-color: #727cf5 !important;
    color: white !important;
}

.swal2-confirm:hover {
    background-color: #5f66c6 !important;
}

.swal2-cancel {
    background-color: #e9ecef !important;
    color: #495057 !important;
}

.swal2-cancel:hover {
    background-color: #dee2e6 !important;
}
</style>

<body class="">
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
                                        <h5 class="m-b-10">Ventas</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a
                                                href="<?php echo site_url("dashboard/panel"); ?>"><i
                                                    class="feather icon-home"></i></a></li>
                                        <li class="breadcrumb-item"><a href="#!">Ventas</a></li>
                                        <li class="breadcrumb-item"><a href="#!">Listado de Boletas</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card shadow-sm">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Listado de Boletas Electrónicas</h5>
                                            <button id="btnReload" class="btn btn-primary btn-sm rounded-pill">
                                                <i class="feather icon-refresh-cw"></i> Actualizar
                                            </button>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Fecha</th>
                                                            <th>Número</th>
                                                            <th>Cliente</th>
                                                            <th>Total</th>
                                                            <th>Estado Sunat</th>
                                                            <th class="text-center">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyVentas">
                                                        <tr>
                                                            <td colspan="6" class="text-center py-5">
                                                                <div class="spinner-border text-primary" role="status">
                                                                </div>
                                                                <p class="mt-2">Cargando datos de facturación...</p>
                                                            </td>
                                                        </tr>
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
    </section>

    <?php echo view("admin/footer"); ?>

    <script src="https://unpkg.com/feather-icons"></script>

    <script>
    $(document).ready(function() {
        fetchBoletas();

        $("#btnReload").click(function() {
            fetchBoletas();
        });
    });

    function fetchBoletas() {
        const tbody = $("#tbodyVentas");
        tbody.html(
            '<tr><td colspan="6" class="text-center py-5"><i data-feather="loader" class="rotate text-primary"></i><p class="mt-2">Consultando API...</p></td></tr>'
        );
        feather.replace();

        $.ajax({
            url: '<?php echo base_url("dashboard/get_boletas_api"); ?>',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                let html = '';
                if (response.success) {
                    response.data.forEach(item => {
                        html += `
                            <tr>
                                <td>
                                    <span class="text-muted"><i data-feather="calendar" style="width:12px; height:12px"></i> ${item.fecha_emision.split('T')[0]}</span>
                                </td>
                                <td><span class="font-weight-bold text-dark">${item.numero_completo}</span></td>
                                <td>
                                    <h6 class="mb-0 text-dark">${item.client.razon_social}</h6>
                                    <small class="text-muted">${item.client.numero_documento}</small>
                                </td>
                                <td><span class="badge badge-light-dark font-weight-bold" style="font-size:13px">${item.moneda} ${item.mto_imp_venta}</span></td>
                                <td><span class="badge badge-soft-success text-uppercase">${item.estado_sunat}</span></td>
                                <td class="text-center">
        <div class="d-flex justify-content-center">
            
            <button onclick="ejecutarAccion('generate', '${item.id}', '${item.numero_completo}')" class="btn btn-action btn-outline-warning" title="Generar PDF API">
                <i data-feather="printer"></i>
            </button>

            <button onclick="ejecutarAccion('send', '${item.id}', '${item.numero_completo}')" class="btn btn-action btn-outline-danger" title="Enviar a SUNAT">
                <i data-feather="zap"></i>
            </button>
            <button onclick="ejecutarAccion('pdf', '${item.id}', '${item.numero_completo}')" class="btn btn-action btn-outline-primary" title="PDF Local">
                <i data-feather="file-text"></i>
            </button>
            <button onclick="ejecutarAccion('xml', '${item.id}', '${item.numero_completo}')" class="btn btn-action btn-outline-success" title="XML Local">
                <i data-feather="download"></i>
            </button>
            <button onclick="ejecutarAccion('cdr', '${item.id}', '${item.numero_completo}')" class="btn btn-action btn-outline-info" title="CDR Local">
                <i data-feather="mail"></i>
            </button>
            <button onclick="eliminarBoleta('${item.id}', '${item.numero_completo}')" class="btn btn-action btn-outline-secondary" title="Eliminar">
                <i data-feather="trash-2"></i>
            </button>
        </div>
    </td>
                            </tr>`;
                    });
                    tbody.html(html);

                    // FIX DE ICONOS: Se ejecuta después de llenar el tbody
                    feather.replace();
                }
            }
        });
    }

    function ejecutarAccion(accion, id, nombreComprobante) {
        // Mapear títulos para cada acción
        const mapeoAcciones = {
            'generate': {
                titulo: 'Generar PDF',
                icon: 'info'
            },
            'send': {
                titulo: 'Enviar a SUNAT',
                icon: 'question'
            },
            'pdf': {
                titulo: 'Descargar PDF',
                icon: 'info'
            },
            'xml': {
                titulo: 'Descargar XML',
                icon: 'info'
            },
            'cdr': {
                titulo: 'Descargar CDR',
                icon: 'info'
            }
        };

        const config = mapeoAcciones[accion] || {
            titulo: 'Procesando',
            icon: 'info'
        };

        // Mostrar modal de carga
        Swal.fire({
            title: config.titulo,
            html: `<p>${nombreComprobante}</p>`,
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: '<?php echo base_url("dashboard/operacion-facturacion"); ?>',
            type: 'POST',
            data: {
                id,
                tipo: accion,
                nombre: nombreComprobante
            },
            dataType: 'json',
            success: function(res) {
                if (accion === 'send') {
                    Swal.fire({
                        icon: res.success ? 'success' : 'error',
                        title: res.success ? 'Completado' : 'Error',
                        text: res.message,
                        confirmButtonColor: '#727cf5'
                    }).then(() => {
                        if (res.success) fetchBoletas();
                    });
                } else {
                    Swal.fire({
                        icon: res.status ? 'success' : 'error',
                        title: res.status ? 'Completado' : 'Error',
                        text: res.message,
                        confirmButtonColor: '#727cf5',
                        didClose: () => {
                            if (res.status && res.file_url && res.file_url !== '#') {
                                window.open(res.file_url, '_blank');
                            }
                        }
                    }).then(() => {
                        if (res.status) fetchBoletas();
                    });
                }
            },
            error: function(xhr) {
                let errorMsg = 'Error del servidor';
                if (xhr.status === 0) errorMsg = 'Conexión perdida';
                else if (xhr.status === 404) errorMsg = 'Endpoint no encontrado';
                else if (xhr.status === 500) errorMsg = 'Error interno del servidor';

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMsg,
                    confirmButtonColor: '#727cf5'
                });
            }
        });
    }

    function eliminarBoleta(id, nombreComprobante) {
        Swal.fire({
            title: '¿Eliminar boleta?',
            html: `<p>¿Estás seguro de que deseas eliminar <strong>${nombreComprobante}</strong>?</p>
                   <p style="font-size: 12px; color: #999; margin-top: 10px;">Esta acción no se puede deshacer.</p>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#727cf5',
            confirmButtonText: '✓ Eliminar',
            cancelButtonText: '✗ Cancelar',
            allowOutsideClick: false
        }).then(result => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Eliminando...',
                    html: `<p>Eliminando boleta...</p>`,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => Swal.showLoading()
                });

                $.ajax({
                    url: '<?php echo base_url("dashboard/eliminar-boleta"); ?>',
                    type: 'POST',
                    data: { id, nombre: nombreComprobante },
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            icon: res.status ? 'success' : 'error',
                            title: res.status ? 'Eliminada' : 'Error',
                            text: res.message,
                            confirmButtonColor: '#727cf5'
                        }).then(() => {
                            if (res.status) fetchBoletas();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo eliminar la boleta',
                            confirmButtonColor: '#727cf5'
                        });
                    }
                });
            }
        });
    }
    </script>
</body>

</html>