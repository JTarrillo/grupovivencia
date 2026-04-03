<!doctype html>
<html lang="es-PE">
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
                                        <h5 class="m-b-10">Facturas de Contratos Inmobiliarios</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard">Panel</a></li>
                                        <li class="breadcrumb-item"><a href="/dashboard/facturas/contratos">Facturas
                                                Contratos</a></li>
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
                                            <h5>Listado de Facturas de Contratos</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Contrato</th>
                                                            <th>Cliente</th>
                                                            <th>Inmueble</th>
                                                            <th>Monto</th>
                                                            <th>Estado</th>
                                                            <th>Fecha</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
$contratos_mostrados = [];
if (isset($facturas_contratos) && $facturas_contratos) {
    foreach ($facturas_contratos as $factura) {
        if (in_array($factura->contrato_codigo, $contratos_mostrados)) {
            continue;
        }
        $contratos_mostrados[] = $factura->contrato_codigo;
?>
                                                        <tr>
                                                            <td><?php echo $factura->id; ?></td>
                                                            <td><?php echo $factura->contrato_codigo; ?></td>
                                                            <td><?php echo $factura->cliente_nombre; ?></td>
                                                            <td><?php echo $factura->inmueble; ?></td>
                                                            <td><?php echo format_number_moneda_soles($factura->monto); ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($factura->estado == '1') {
            $valor = "Por Pagar";
            $stilo = "label label-warning";
        } elseif ($factura->estado == '2') {
            $valor = "Pagado";
            $stilo = "label label-success";
        } else {
            $valor = "Cancelado";
            $stilo = "label label-danger";
        } ?>
                                                                <span class="<?php echo $stilo; ?>"
                                                                    style="border-radius:10px"><?php echo $valor; ?></span>
                                                            </td>
                                                            <td><?php echo formato_fecha_dia_mes_anio_abrev($factura->fecha); ?>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-primary btn-sm"
                                                                    onclick="emitirFacturaContrato(<?php echo $factura->contract_id; ?>)">Emitir
                                                                    factura</button>
                                                                <button class="btn btn-info btn-sm"
                                                                    onclick="verFacturaContrato(<?php echo $factura->id; ?>)"><i
                                                                        class="fa fa-eye"></i></button>
                                                                <button class="btn btn-danger btn-sm"
                                                                    onclick="eliminarFacturaContrato(<?php echo $factura->id; ?>)"><i
                                                                        class="fa fa-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                        <?php
    }
} else { ?>
                                                        <tr>
                                                            <td colspan="8" class="text-center">No hay facturas de
                                                                contratos inmobiliarios.</td>
                                                        </tr>
                                                        <?php } ?>
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

    <!-- Modal resultado -->
    <div class="modal fade" id="modalComprobante" tabindex="-1" role="dialog" aria-labelledby="modalComprobanteLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalComprobanteLabel">Resultado de Emisión</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalComprobanteBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    function emitirFacturaContrato(id) {
        $.ajax({
            url: '/dashboard/facturas/emitirFactura',
            type: 'POST',
            data: {
                contract_id: id
            },
            dataType: 'json',
            success: function(resp) {
                var html = '';
                // Mostrar código y URL si existen en la respuesta
                if (resp.data && resp.data.key && resp.data.enlace) {
                    html += '<div class="alert alert-success text-center">' +
                        'Código: <b>' + resp.data.key + '</b><br>' +
                        'URL: <a href="' + resp.data.enlace + '" target="_blank">' + resp.data.enlace +
                        '</a>' +
                        '</div>';
                }
                // Mostrar enlaces PDF/XML si existen
                if (resp.data && resp.data.enlace_del_pdf) {
                    html += '<div class="mt-2 text-center"><a href="' + resp.data.enlace_del_pdf +
                        '" target="_blank" class="btn btn-outline-primary btn-sm">Descargar PDF</a></div>';
                }
                if (resp.data && resp.data.enlace_del_xml) {
                    html += '<div class="mt-2 text-center"><a href="' + resp.data.enlace_del_xml +
                        '" target="_blank" class="btn btn-outline-secondary btn-sm">Descargar XML</a></div>';
                }
                // Mensaje general y JSON
                if (resp.success && resp.urlComprobante) {
                    html +=
                        '<div class="alert alert-success text-center">Comprobante emitido correctamente.</div>' +
                        '<div class="text-center"><a href="' + resp.urlComprobante +
                        '" target="_blank" class="btn btn-primary btn-lg">Ver Comprobante Electrónico</a></div>' +
                        '<div class="text-center mt-3"><button class="btn btn-info" onclick="location.reload()">Refrescar listado</button></div>';
                } else if (resp.error) {
                    html += '<div class="alert alert-danger text-center">' + resp.error + '</div>';
                } else if (!html) {
                    html =
                        '<div class="alert alert-warning text-center">No se pudo emitir el comprobante.</div>';
                }
                if (resp.nubefact_response) {
                    html +=
                        '<hr><pre style="max-height:300px;overflow:auto;background:#f8f9fa;border:1px solid #ddd;padding:10px;">' +
                        JSON.stringify(resp.nubefact_response, null, 2) + '</pre>';
                }
                $('#modalComprobanteBody').html(html);
                $('#modalComprobante').modal('show');
                
                // Auto-reload después de 3 segundos si fue exitoso
                if (resp.success) {
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
            },
            error: function() {
                $('#modalComprobanteBody').html(
                    '<div class="alert alert-danger text-center">Error de conexión o respuesta inesperada.</div>'
                );
                $('#modalComprobante').modal('show');
            }
        });
    }

    function verFacturaContrato(id) {
        window.location.href = '/dashboard/facturas/detalle/' + id;
    }

    function eliminarFacturaContrato(id) {
        if (confirm('¿Seguro que deseas eliminar esta factura?')) {
            // Aquí puedes hacer AJAX para eliminar
            window.location.href = '/dashboard/facturas/eliminar/' + id;
        }
    }
    </script>
    <?php echo view("admin/footer"); ?>
</body>

</html>