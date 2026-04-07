<!doctype html>
<html lang="es-PE">
<?php echo view("admin/head"); ?>

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
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
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
        from { transform: rotate(0deg); }
        to { transform: rotate(359deg); }
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
                                        <li class="breadcrumb-item"><a href="<?php echo site_url("dashboard/panel"); ?>"><i class="feather icon-home"></i></a></li>
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
                                                                <div class="spinner-border text-primary" role="status"></div>
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
            tbody.html('<tr><td colspan="6" class="text-center py-5"><i data-feather="loader" class="rotate text-primary"></i><p class="mt-2">Consultando API...</p></td></tr>');
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
            $.ajax({
                url: '<?php echo base_url("dashboard/operacion-facturacion"); ?>',
                type: 'POST',
                data: {
                    id: id,
                    tipo: accion,
                    nombre: nombreComprobante
                },
                dataType: 'json',
                beforeSend: function() {
                    console.log("Procesando " + accion + "...");
                },
                success: function(res) {
                    if (accion === 'send') {
                        if (res.success) {
                            alert("Enviado a SUNAT: " + res.message);
                            fetchBoletas();
                        } else {
                            alert("Error SUNAT: " + (res.message || "Respuesta vacía"));
                        }
                    } else {
                        if (res.status) {
                            alert(res.message);
                            window.open(res.file_url, '_blank');
                        } else {
                            alert("Error en descarga: " + res.message);
                        }
                    }
                },
                error: function(xhr) {
                    alert("Error en el servidor local.");
                }
            });
        }
    </script>
</body>
</html>