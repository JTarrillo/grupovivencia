<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GRUPO VIVENCIA</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container" style="margin-top:-20px;">
        <div class="container text-center">
            <h2 class="text-center">ALELIFE GLOBAL S.A.C.</h2>
            <h4 class="text-center">RUC: 20613043889</h4>
            <div class="d-flex flex-row-reverse bd-highlight">
                <p>
                    <b>Cliente:</b> <?php echo $obj_invoices->name. " ".$obj_invoices->lastname;?><br /><b>Código:</b>
                    <?php echo $obj_invoices->code; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Venta:</b>
                    000<?php echo $obj_invoices->id; ?><br />
                    <b>Fecha:</b> <?php echo formato_fecha_dia_mes_anio_abrev($obj_invoices->date); ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <b>Hora:</b><?php echo formato_fecha_minutos($obj_invoices->date); ?>
                </p>
                <p>Despacho: [<?php echo $obj_invoices->store_id; ?>] <?php echo $obj_invoices->store_name; ?></p>
            </div>
            <table class="table table-striped table-hover mt-4">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>----------</td>
                        <td>----------</td>
                        <td>----------</td>
                        <td>----------</td>
                    </tr>
                    <?php
              foreach ($obj_product_detail as $key => $value) { ?>
                    <tr>
                        <td><?php echo $value->name; ?></td>
                        <td><?php echo $value->qty; ?></td>
                        <td><?php echo $value->price; ?></td>
                        <td> <?php echo isset($obj_invoices->temporal_membership) &&  $obj_invoices->temporal_membership != 1 ? "-" : $value->sub_total; ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><b>Sub total</b></td>
                        <td><?php echo format_number_moneda_soles($obj_invoices->sub_total); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><b>Igv</b></td>
                        <td><?php echo format_number_moneda_soles($obj_invoices->igv); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><b>Total</b></td>
                        <td><?php echo format_number_moneda_soles($obj_invoices->amount); ?></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <?php
          if ($obj_invoices->payment == '1') {
            $value = "Monedero";
          } elseif ($obj_invoices->payment == '2') {
            $value = "Tarjeta";
          } else {
            $value = "En Tienda";
          }

          ?>
            <p>
                Puntos:&nbsp;<?php echo format_number_miles($obj_invoices->points); ?><br />
                Forma de Pago:&nbsp;<?php echo $value; ?></p>
            <p style="margin-left:20%;"><b>¡Gracias por su compra!</b></p>
        </div>
    </div>
</body>

</html>