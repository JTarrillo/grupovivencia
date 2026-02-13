<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
  <table style="width: 100%;">
    <tr>
      <td style="width: 55%;">
        <table style="width: 100%;">
          <tr style="padding-bottom: 20px;">
            <td colspan="3">
              <h2 style="font-weight: bold;">ID #<?php echo $obj_invoices->id; ?></h2>
            </td>
          </tr>
          <tr style="padding-bottom: 20px;">
            <td>
              <label style="font-size: 16px; color: #1c1c1c;">Fecha de emisión:</label>
              <br>
              <label style="font-size: 17px; font-weight: bold; color: #1c1c1c"><?php echo formato_fecha_dia_mes_anio_abrev($obj_invoices->date) . " " . formato_fecha_minutos($obj_invoices->date) . "hrs"; ?></label>
            </td>
            <td>
              <label style="font-size: 16px; color: #1c1c1c;">Recojo de productos</label>
              <br>
              <label style="font-size: 17px; font-weight: bold; color: #1c1c1c"><?php echo $obj_invoices->store_name; ?></label>
            </td>
            <td></td>
          </tr>
          <br>
          <tr style="padding-bottom: 20px; border-bottom: 1px solid black;">
            <td style="font-size: 17px; color: #1c1c1c; font-weight: bold;">Descripción</td>
            <td style="font-size: 17px; color: #1c1c1c; font-weight: bold; text-align: right;">Cantidad</td>
            <td style="font-size: 17px; color: #1c1c1c; font-weight: bold; text-align: right;">Precio</td>
          </tr>
          <?php
            foreach ($obj_product_detail as $key => $value) { ?>
          <tr>
            <td style="padding: 10px 0px; font-size: 17px; color: #1c1c1c;"><?php echo $value->name ?></td>
            <td style="padding: 10px 0px; font-size: 17px; color: #1c1c1c; text-align: right;"><?php echo $value->qty; ?></td>
            <td style="padding: 10px 0px; font-size: 17px; color: #1c1c1c; text-align: right;"><?php echo isset($obj_invoices->temporal_membership) &&  $obj_invoices->temporal_membership != 1 ? "-" : $value->price; ?></td>
          </tr>
          <?php } ?>
          <tr>
            <td colspan="2" style="padding: 10px 0px; font-size: 17px; color: #1c1c1c; text-align: right; font-weight: bold;">Subtotal</td>
            <td style="padding: 10px 0px; font-size: 17px; color: #1c1c1c; text-align: right;"><?php echo format_number_moneda_soles($obj_invoices->sub_total); ?></td>
          </tr>
          <tr>
            <td colspan="2" style="padding: 10px 0px; font-size: 17px; color: #1c1c1c; text-align: right;">IGV</td>
            <td style="padding: 10px 0px; font-size: 17px; color: #1c1c1c; text-align: right;"><?php echo format_number_moneda_soles($obj_invoices->igv); ?></td>
          </tr>
          <tr>
            <td colspan="2" style="padding: 10px 0px; font-size: 17px; color: #1c1c1c; text-align: right; font-weight: bold;">Total</td>
            <td style="padding: 10px 0px; font-size: 17px; color: #1c1c1c; text-align: right;"><?php echo format_number_moneda_soles($obj_invoices->amount); ?></td>
          </tr>
          <tr>
            <td colspan="3" style="font-size: 17px; color: #1c1c1c;">Puntos: <?php echo format_number_miles($obj_invoices->points);?></td>
          </tr>
        </table>
      </td>
      <td style="width: 5%;"></td>
      <td style="width: 40%;">
        <table style="width: 100%;">
          <div style="border: 1px dashed #E4E6EF; border-radius: 10px; padding: 10px 30px">
            <?php
              if ($obj_invoices->active == 2) { ?>
              <span style="padding: 5px 5px; background-color: #2cab42; color: white; border-radius: 5px; font-size: 15px;">Procesado</span>
            <?php } else { ?>
              <span style="padding: 5px 5px; background-color: #FFF8DD; color: #FFC300; border-radius: 5px; font-size: 15px;">En espera</span>
            <?php } ?>
            <p style="font-size: 16px; font-weight: bold; color: #1c1c1c; padding-bottom: 8px; padding-top: 6px;">Detalle de la compra</p>
            <label style="font-size: 15px; color: #1c1c1c;">Nombre</label>
            <br>
            <label style="font-size: 16px; color: #1c1c1c; font-weight: bold;"><?php echo $obj_customer->name . " " . $obj_customer->lastname; ?></label>
            <br><br>
            <label style="font-size: 15px; color: #1c1c1c;">Celular/DNI</label>
            <br>
            <label style="font-size: 16px; color: #1c1c1c; font-weight: bold;"><?php echo $obj_customer->dni; ?></label>
            <br><br>
            <label style="font-size: 15px; color: #1c1c1c;">Email</label>
            <br>
            <label style="font-size: 16px; color: #1c1c1c; font-weight: bold;"><?php echo $obj_customer->email; ?></label>
            <br><br>
            <label style="font-size: 15px; color: #1c1c1c;">Pais</label>
            <br>
            <label style="font-size: 16px; color: #1c1c1c; font-weight: bold;">Perú</label>
          </div>
        </table>
      </td>
    </tr>
  </table>
</body>

</html>