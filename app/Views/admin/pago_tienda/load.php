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
                                        <li class="breadcrumb-item"><a>Pago por Tienda</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container" id="printTable">
                        <div>
                            <div class="card">
                                <div class="row invoice-contact">
                                    <div class="col-md-12">
                                        <div class="invoice-box row">
                                            <div class="col-sm-6">
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
                                                            <td>ALELIFE GLOBAL S.A.C.</td>
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
                                            <div class="col-sm-6">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                                <form name="form" enctype="multipart/form-data" method="post"
                                    action="javascript:void(0);" ; onsubmit="procesadas();">
                                    <input type="hidden" name="invoice_id" value="<?php echo $obj_invoices->id; ?>">
                                    <input type="hidden" name="customer_id"
                                        value="<?php echo $obj_invoices->customer_id; ?>">
                                    <input type="hidden" name="sub_total" value="<?php echo $obj_invoices->amount; ?>">
                                    <input type="hidden" name="point" value="<?php echo $obj_invoices->points; ?>">
                                    <input type="hidden" name="range_id" value="<?php echo $obj_customer->range_id; ?>">
                                    <input type="hidden" name="temporal_membership"
                                        value="<?php echo $obj_invoices->temporal_membership; ?>">
                                    <input type="hidden" name="store_id" value="<?php echo $obj_invoices->store_id; ?>">
                                    <input type="hidden" name="membership_id" value="<?php echo $membership_id; ?>">
                                    <input type="hidden" name="phone" value="<?php echo $obj_invoices->phone; ?>">
                                    <div class="card-body">
                                        <div class="row invoive-info">
                                            <div class="col-md-4 col-xs-12 invoice-client-info">
                                                <h6>Información del Cliente :</h6>
                                                <h6 class="m-0">
                                                    <?php echo $obj_invoices->name . " " . $obj_invoices->lastname; ?>
                                                </h6>
                                                <p class="m-0"><?php echo $obj_invoices->code ?></p>
                                                <p><a class="text-secondary"><?php echo $obj_invoices->email ?></a></p>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <h6>Información de pedido :</h6>
                                                <table
                                                    class="table table-responsive invoice-table invoice-order table-borderless">
                                                    <tbody>
                                                        <tr>
                                                            <th>Id :</th>
                                                            <td>#<?php echo $obj_invoices->id; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Fecha :</th>
                                                            <td><?php echo formato_fecha_dia_mes_anio_abrev($obj_invoices->date); ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Estado :</th>
                                                            <td>
                                                                <?php
                                                if ($obj_invoices->active == '1') {
                                                   $val = "label-warning";
                                                } else {
                                                   $val = "label-success";
                                                }
                                                ?>
                                                                <span
                                                                    class="label <?php echo $val; ?>"><?php echo $obj_invoices->active == '1' ? "Pendiente" : "Procesado"; ?></span>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <h6 class="m-b-20">Número de Factura
                                                    <span>#<?php echo $obj_invoices->id; ?></span>
                                                </h6>
                                                <h6 class="m-b-20">Concepto:
                                                   <span><?php echo $obj_invoices->membership??"Recompra";?></span>
                                                </h6>
                                                <h6 class="text-uppercase text-primary">Total a pagar
                                                    :<span><?php echo format_number_moneda_soles($obj_invoices->amount); ?></span>
                                                </h6>
                                                <span>Periodo: <?php echo $obj_invoices->code; ?></span>
                                                <div hidden>
                                                    <span id="subtotal_max"><?php echo $obj_invoices->amount; ?></span>
                                                </div>
                                                <a href="<?php echo site_url() . "dashboard/pago_tienda/export_pdf/$obj_invoices->id"; ?>"
                                                    type="button" class="btn waves-effect waves-light"><i
                                                        class="fa fa-print" aria-hidden="true"></i></a>
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
                                             foreach ($obj_invoice_detail as $key => $value) {
                                                $slug = $value->slug;
                                                $name = $value->name;
                                                if ($slug == "membresia") {
                                                   if (isset($obj_membership)) {
                                                      $name = $obj_membership->name;
                                                   }
                                                }
                                             ?>
                                                            <tr>
                                                                <td>
                                                                    <h6><?php echo $name; ?></h6>
                                                                    <p class="m-0"><?php echo $value->detail; ?></p>
                                                                </td>
                                                                <td><?php echo $value->qty; ?></td>
                                                                <td><?php echo $value->price == 0 ? "-" : $value->price; ?>
                                                                </td>
                                                                <td><?php echo isset($obj_invoices->temporal_membership) &&  $obj_invoices->temporal_membership != 1 ? "-" : $value->sub_total; ?>
                                                                </td>
                                                            </tr>
                                                            <?php } ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table class="table table-responsive invoice-table invoice-total">
                                                    <tbody>
                                                        <tr class="text-info">
                                                            <td>
                                                                <h5 class="text-primary m-r-10">Total :</h5>
                                                            </td>
                                                            <td>
                                                                <h5 class="text-primary">
                                                                    <?php echo format_number_moneda_soles($obj_invoices->amount); ?>
                                                                </h5>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="row invoive-info">
                                                <?php
                                    if ($obj_invoices->payment_options != "") { ?>
                                                <a class="text-secondary">Forma de pago:
                                                    <?php echo $obj_invoices->payment_options; ?></a>
                                                <?php } else { ?>
                                                <div class="col-md-3 col-xs-12 invoice-client-info">
                                                    <h6>Forma de pago :</h6>
                                                    <?php
                                          foreach ($obj_payment as $key => $value) { ?>
                                                    <input type="number" class="form-control input-pay" name="payment[]"
                                                        placeholder="<?php echo $value->name; ?>" min="0"
                                                        onpaste="return false" step="any">
                                                    <br>
                                                    <?php } ?>
                                                </div>
                                                <?php } ?>
                                                <div class="col-md-4 col-sm-6">
                                                </div>
                                                <div class="col-md-5 col-sm-6">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <?php
                           if ($obj_invoices->active != '2') { ?>
                                    <div class="row" id="content_alert">
                                        <div class="col-12">
                                            <div class="alert alert-danger" role="alert">
                                                <span id="error_total"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>

                                    <div class="row text-center btn-page" id="content_actions">
                                        <div class="col-sm-12 invoice-btn-group text-center">
                                            <button type="button" onclick="back();"
                                                class="btn waves-effect waves-light btn-light"><i
                                                    class="fa fa-angle-left" aria-hidden="true"></i> Regresar</button>
                                            <?php
                                 if ($obj_invoices->active == '1') { ?>
                                            <button type="submit"
                                                class="btn btn-success btn-print-invoice">Procesar</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
    const alert = document.getElementById("content_alert")
    alert.style.display = "none"
    document.addEventListener("DOMContentLoaded", () => {
        validate_pays()
    })
    </script>
    <script>
    const obj = <?php echo json_encode($obj_membership); ?>;
    const kitName = document.querySelector("span.name_membresia")
    if (kitName) {
        kitName.textContent = obj.name
    }
    </script>
    <script src="<?php echo site_url() . "assets/admin/js/script/pago_tienda.js?1234567890"; ?>"></script>
    <script>
    const card_block = document.getElementById("card-block");

    function show() {
        var text = document.getElementById("payment_name");
        var form = document.getElementById("div_form");
        form.style.display = "block";
        card_block.style.backgroundColor = "#3f4d67";
        text.focus();
    }

    function hide() {
        var form = document.getElementById("div_form");
        form.style.display = "none";
        card_block.style.backgroundColor = "#fff";
    }
    </script>
    <!-- [ Header ] end -->
    <!-- [ Main Content ] end -->
    <?php echo view("admin/footer"); ?>