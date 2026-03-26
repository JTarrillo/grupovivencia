<!doctype html>
<html lang="es-PE">
<?php echo view("admin/head"); ?>

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
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Listado de Boletas Electrónicas</h5>
                                            <div class="card-header-right">
                                                <button id="btnReload" class="btn btn-primary btn-sm">
                                                    <i class="feather icon-refresh-cw"></i> Actualizar
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
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
                                                            <td colspan="6" class="text-center">
                                                                <div class="spinner-border text-primary" role="status"></div>
                                                                <p>Cargando datos de facturación...</p>
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

    <script>
        $(document).ready(function() {
            fetchBoletas();

            $("#btnReload").click(function() {
                fetchBoletas();
            });
        });

        function fetchBoletas() {
            const tbody = $("#tbodyVentas");
            tbody.html('<tr><td colspan="6" class="text-center"><i class="feather icon-loader rotate"></i> Consultando API...</td></tr>');

            $.ajax({
                url: '<?php echo base_url("dashboard/get_boletas_api"); ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    let html = '';

                    if (response.success && response.data.length > 0) {
                        response.data.forEach(item => {
                            // Formatear fecha (quitar la T y la Z)
                            let fecha = item.fecha_emision.split('T')[0];
                            
                            // Color del badge según estado_sunat
                            let badgeClass = 'badge-light-warning';
                            if(item.estado_sunat === 'ACEPTADO') badgeClass = 'badge-light-success';
                            if(item.estado_sunat === 'RECHAZADO') badgeClass = 'badge-light-danger';

                            html += `
                                <tr>
                                    <td>${fecha}</td>
                                    <td><strong>${item.numero_completo}</strong></td>
                                    <td>
                                        ${item.client.razon_social}<br>
                                        <small class="text-muted">${item.client.numero_documento}</small>
                                    </td>
                                    <td>${item.moneda} ${item.mto_imp_venta}</td>
                                    <td><span class="badge ${badgeClass}">${item.estado_sunat}</span></td>
                                    <td class="text-center">
                                        <button class="btn btn-icon btn-outline-primary" onclick="window.open('${item.pdf_path || '#'}', '_blank')" ${!item.pdf_path ? 'disabled' : ''}>
                                            <i class="feather icon-file-text"></i>
                                        </button>
                                        <button class="btn btn-icon btn-outline-info" onclick="console.log('ID: ${item.id}')">
                                            <i class="feather icon-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                        tbody.html(html);
                    } else {
                        tbody.html('<tr><td colspan="6" class="text-center text-muted">No se encontraron registros.</td></tr>');
                    }
                },
                error: function(xhr) {
                    tbody.html('<tr><td colspan="6" class="text-center text-danger">Error al conectar con la API local.</td></tr>');
                }
            });
        }
    </script>

    <style>
        .rotate {
            animation: rotation 2s infinite linear;
            display: inline-block;
        }
        @keyframes rotation {
            from { transform: rotate(0deg); }
            to { transform: rotate(359deg); }
        }
    </style>
</body>
</html>