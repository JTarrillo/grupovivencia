<!doctype html>
<html lang="es-PE">
<?php echo view("admin/head"); ?>

<body data-new-gr-c-s-check-loaded="14.1042.0" data-gr-ext-installed="">
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
                                        <h5 class="m-b-10">Detalle de Factura</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard">Panel</a></li>
                                        <li class="breadcrumb-item"><a href="/dashboard/ventas">Reporte de ventas</a>
                                        </li>
                                        <li class="breadcrumb-item"><a>Detalle de venta</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container" id="printTable">
                        <div>
                            <div class="card">
                                <div class="row invoice-contact">
                                    <div class="col-md-8">
                                        <div class="invoice-box row">
                                            <div class="col-sm-12">
                                                <table
                                                    class="table table-responsive invoice-table table-borderless p-l-20">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <a class="b-brand">
                                                                    <img class="img-fluid"
                                                                        src="<?php echo site_url() . "assets/front/img/logo/logo.png"; ?>"
                                                                        alt="Logo" width="50">
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>GRUPO VIVENCIA S.A.C.</td>
                                                        </tr>
                                                        <tr>
                                                            <td>RUC: 20613043889</td>
                                                        </tr>
                                                        <tr>
                                                            <td><a class="text-secondary">contacto@alelifeglobal.com</a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                                <div class="card-body">
                                    <div class="row invoive-info">
                                        <div class="col-md-4 col-xs-12 invoice-client-info">
                                            <h6>Información del Cliente :</h6>
                                            <h6 class="m-0">
                                                <?php echo $obj_invoices->name . " " . $obj_invoices->lastname; ?></h6>
                                            <p class="m-0"><?php echo $obj_invoices->code ?></p>
                                            <p><a class="text-secondary"><?php echo $obj_invoices->email ?></a></p>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <h6>Información de pedido :</h6>
                                            <table
                                                class="table table-responsive invoice-table invoice-order table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <th>Fecha :</th>
                                                        <td><?php echo formato_fecha_dia_mes_anio_abrev($obj_invoices->date); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Estado :</th>
                                                        <td>
                                                            <?php
                              if ($obj_invoices->active == '2') {
                                $val = "label-success";
                              } else {
                                $val = "label-warning";
                              }
                              ?>
                                                            <span
                                                                class="label <?php echo $val; ?>"><?php echo $obj_invoices->active == '2' ? "Pagado" : "Pendiente"; ?></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Id :</th>
                                                        <td>#<?php echo $obj_invoices->id; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <h6 class="m-b-20">Número de Factura
                                                <span>#<?php echo $obj_invoices->id; ?></span>
                                            </h6>
                                            <h6 class="text-uppercase text-primary">Total a pagar
                                                :<span><?php echo format_number_moneda_soles($obj_invoices->amount); ?></span>
                                            </h6>
                                            <h6 class="m-b-20">Delivery
                                                <?php
                        if ($obj_invoices->delivery == '1') {
                          $val = "Por recoger";
                          $style = "label label-warning";
                        } else {
                          $val = "Entregado";
                          $style = "label label-success";
                        }
                        ?>
                                                <span class="<?php echo $style; ?>"><?php echo $val; ?></span>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table invoice-detail-table">
                                                    <thead>
                                                        <tr class="thead-default">
                                                            <th>Descripción</th>
                                                            <th>Cantidad</th>
                                                            <th>Precio</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                            foreach ($obj_invoice_detail as $key => $value) { ?>
                                                        <tr>
                                                            <td>
                                                                <h6 class="name_<?php echo $value->slug; ?>">
                                                                    <?php echo $value->name; ?></h6>
                                                                <p class="m-0"><?php echo $value->detail; ?></p>
                                                            </td>
                                                            <td><?php echo $value->qty; ?></td>
                                                            <td><?php echo $value->price; ?></td>
                                                            <td><?php echo isset($obj_invoices->temporal_membership) &&  $obj_invoices->temporal_membership != 1 ? "-" : $value->sub_total; ?>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                        <tr>
                                                            <td>
                                                            </td>
                                                            <td></td>
                                                            <td>sub total</td>
                                                            <td><?php echo format_number_moneda_soles($obj_invoices->sub_total); ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                            </td>
                                                            <td></td>
                                                            <td>igv</td>
                                                            <td><?php echo format_number_moneda_soles($obj_invoices->igv); ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                            </td>
                                                            <td></td>
                                                            <td><b>Total</b></td>
                                                            <td><b><?php echo format_number_moneda_soles($obj_invoices->amount); ?></b>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <a class="text-secondary">Puntos:
                                                    <?php echo format_number_miles($obj_invoices->points, 0); ?></a><br />
                                                <?php
                        if ($obj_invoices->payment_options) { ?>
                                                <a class="text-secondary">Forma de pago:
                                                    <?php echo $obj_invoices->payment_options; ?></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row text-center btn-page p-2" id="content_actions">
                                    <div class="col-sm-12 invoice-btn-group text-center">
                                        <button type="button" onclick="back();"
                                            class="btn waves-effect waves-light btn-light"><i class="fa fa-angle-left"
                                                aria-hidden="true"></i> Regresar</button>
                                        <a href="<?php echo site_url() . "dashboard/ventas/export_pdf/$obj_invoices->id"; ?>"
                                            class="btn waves-effect waves-light btn-success"><i class="fa fa-print"
                                                aria-hidden="true"></i> Imprimir</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
    const data = <?php echo json_encode($obj_membership); ?>;
    if (data) {
        const kitName = document.querySelector("h6.name_membresia")
        if (kitName) {
            kitName.textContent = data.name
        }
    }
    </script>
    <script src="<?php echo base_url('assets/admin/js/script/customer.js?12'); ?>"></script>
    <!-- [ Header ] end -->
    <!-- [ Main Content ] end -->
    <?php echo view("admin/footer"); ?>