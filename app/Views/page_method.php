<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="ltr" lang="en" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="ltr" lang="en" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="ltr" lang="en">
<!--<![endif]-->

<!-- begin head -->
<?php echo view("head"); ?>
<!-- begin head -->

<body>

    <!-- begin head -->
    <?php echo view("header"); ?>
    <!-- begin head -->

    <div id="checkout-checkout" class="container">

        <div class="row">
            <div id="content" class="col-sm-12">
                <div class="head-t mt60 mb60 text-center">
                    <h4><span>Metodo de Pago</span></h4>
                </div>
                <br><br>
                <form id="form_pasarela" method="post" action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/">
                    <div class="payments" style="text-align: center;">
                        <button type="submit" href="/page-method" onclick="pagado(event);">
                            Pagar con Tarjeta 
                            <!-- <img src="<?php echo site_url() . "assets/front/img/payment/pay-u.webp" ?>" alt="PAY-U" style="width: 200px;"> -->
                        </button>
                    </div>
                    <input name="merchantId"      type="hidden"  value="<?php echo $merchand_id ?>"   >
                    <input name="accountId"       type="hidden"  value="512323" >
                    <input name="description"     type="hidden"  value="Pago Mundo Network"  >
                    <input name="referenceCode"   type="hidden"  value="<?php echo $reference_code ?>" >
                    <input name="amount"          type="hidden"  value="<?php echo $total ?>"   >
                    <input name="tax"             type="hidden"  value="<?php echo $igv ?>"  >
                    <input name="taxReturnBase"   type="hidden"  value="<?php echo $sub_total ?>" >
                    <input name="currency"        type="hidden"  value="<?php echo $currency_code ?>" >
                    <input name="signature"       type="hidden"  value="<?php echo $signature ?>"  >
                    <input name="test"            type="hidden"  value="true" >
                    <input name="buyerEmail"      type="hidden"  value="<?php echo $obj_customer->email ?>" >
                    <input name="responseUrl"     type="hidden"  value="<?php echo site_url() . "backoffice_new/success" ?>" >
                    <input name="confirmationUrl" type="hidden"  value="<?php echo site_url() . "backoffice_new/facturas" ?>" >
                </form>
            </div>
        </div>
    </div>

    <!-- begin head -->
    <?php echo view("footer"); ?>
    <!-- begin head -->

    <script>
        function pagado(event) {
            event.preventDefault();
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Pago confirmado',
                showConfirmButton: false,
                timer: 1500
            });
            window.localStorage.clear();
            sessionStorage.clear();
            $('#form_pasarela').submit();
        }
    </script>
</body>

</html>