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

                              <h5 class="m-b-10">Detalle de Compra</h5>

                           </div>

                           <ul class="breadcrumb">

                              <li class="breadcrumb-item"><a href="/dashboard/panel">Panel</a></li>

                              <li class="breadcrumb-item"><a href="/dashboard/nueva_venta">Listado de productos</a></li>

                              <li class="breadcrumb-item"><a>Detalle de Compra</a></li>

                           </ul>

                        </div>

                     </div>

                  </div>

               </div>

               <div class="card">

                  <div class="row invoice-contact">

                     <div class="col-md-12">

                        <div class="invoice-box row">

                           <div class="col-sm-8">

                              <table class="table table-responsive invoice-table table-borderless p-l-20">
                                 <tbody>
                                    <tr>
                                       <td>
                                          <a class="b-brand">
                                             <img class="img-fluid" src="<?php echo site_url() . "assets/front/img/logo/logo.png"; ?>" alt="Logo" width="50">
                                          </a>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>ALELIFE GLOBAL</td>
                                    </tr>
                                    <tr>
                                       <td>RUC:20613043889</td>
                                    </tr>
                                    <tr>
                                       <td><a class="text-secondary">contacto@alelifeglobal.com</a></td>
                                    </tr>
                                 </tbody>
                              </table>

                           </div>

                        </div>

                     </div>

                  </div>

                  <form name="form" id="form" method="post" enctype="multipart/form-data" action="javascript:void(0);" onsubmit="pay_adm();">

                     <input type="hidden" name="total_disponible" id="total_disponible" value="<?php echo $total_disponible; ?>">

                     <input type="hidden" name="sub_total" id="sub_total" value="<?php echo $sub_total; ?>">

                     <input type="hidden" name="store_id" id="store_id" value="<?php echo $store_id; ?>">

                     <input type="hidden" name="phone" id="phone" value="<?php echo $phone; ?>">

                     <input type="hidden" name="total" id="total" value="<?php echo $total; ?>">

                     <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer_id; ?>">

                     <input type="hidden" name="membership_id" id="membership_id" value="<?php echo $membership_id; ?>">

                     <div class="card-body">

                        <div class="row invoive-info">

                           <div class="col-md-3 col-xs-12 invoice-client-info">

                              <label><b>Cliente</b></label>

                              <p><?php echo $obj_customer->name . " " . $obj_customer->lastname; ?><br/>Codigo: <?php echo $obj_customer->code; ?><br/>DNI: <?php echo $obj_customer->dni; ?></p>

                           </div>

                           <div class="col-md-3 col-sm-6">

                              <label><b>Teléfono de contacto</b></label>

                              <p><?php echo $phone; ?></p>

                           </div>

                           <div class="col-md-3 col-sm-6">

                              <label><b>Puntos</b></label>

                              <p><?php echo $point; ?></p>

                           </div>

                           <div class="col-md-3 col-sm-6">

                              <label><b>Recojo de productos</b></label>

                              <p><?php echo $obj_store->name; ?></p>

                           </div>

                        </div>

                        <div class="row">

                           <div class="col-sm-12">

                              <div class="table-responsive">

                                 <table class="table invoice-detail-table">

                                    <thead>

                                       <tr class="border-bottom fs-6 fw-bold text-muted">

                                          <th class="min-w-100px pb-2"><?php echo lang('Global.descripcion'); ?></th>

                                          <th class="min-w-100px pb-2">Cantidad</th>

                                          <th class="min-w-80px pb-2">Precio</th>

                                          <th class="min-w-80px pb-2"><?php echo lang('Global.importe'); ?></th>

                                       </tr>

                                    </thead>

                                    <tbody>

                                       <?php

                                       foreach ($content as $key => $row) { ?>

                                          <tr class="fw-bold text-gray-700 fs-5">

                                             <td class="d-flex align-items-center">

                                                <span class="name_<?php echo $row->options['details']; ?>">

                                                   <?php echo $row->name; ?>

                                                </span>

                                             </td>

                                             <td class="">

                                                <?php echo $row->qty; ?>

                                             </td>

                                             <td class="fs-5 text-dark fw-bolder"><?php echo $row->price; ?></td>

                                             <td class="fs-5 text-dark fw-bolder">
                                                S/.<?php echo isset($row->subtotal) && $row->subtotal !== '' ? format_number_miles_decimal($row->subtotal) : '0'; ?>
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

                                          <h5 class="text-primary m-r-10">Sub total :</h5>

                                       </td>

                                       <td>

                                          <h5 id="subtotal_max" class="text-primary"><?php echo $sub_total; ?></h5>

                                       </td>

                                    </tr>

                                    <tr class="text-info">

                                       <td>

                                          <h5 class="text-primary m-r-10">IGV :</h5>

                                       </td>

                                       <td>

                                          <h5 class="text-primary">
                                             <?php echo isset($igv) && $igv !== '' ? format_number_miles_decimal($igv) : '0'; ?>
                                          </h5>

                                       </td>

                                    </tr>

                                    <tr class="text-info">

                                       <td>

                                          <h5 class="text-primary m-r-10">Total :</h5>

                                       </td>

                                       <td>

                                          <h5 class="text-primary">S/.<?php echo $sub_total; ?></h5>

                                       </td>

                                    </tr>

                                 </tbody>

                              </table>

                           </div>

                        </div>

                     </div>

                     <div class="row" id="content_alert">

                        <div class="col-12">

                           <div class="alert alert-danger" role="alert">

                              <span id="error_total"></span>

                           </div>

                        </div>

                     </div>

                     <div class="col-sm-12 invoice-btn-group text-center">

                        <div class="row g-5 mb-11">

                           <div class="col-sm-6">

                              <?php

                              foreach ($obj_payment as $key => $value) { ?>

                                 <input type="number" class="form-control input-pay" name="payment[]" placeholder="<?php echo $value->name; ?>" min="0" onpaste="return false" value="" step="any">

                                 <br>

                              <?php } ?>

                           </div>

                           <div class="col-sm-6" id="btn-pay">

                              <button type="submit" id="submit_pay" class="btn-success btn fw-bold fs-8 btn-block" style="font-size: 16px !important; width: 100%;"><i class="fa fa-usd" aria-hidden="true"></i>Pagar</button>

                           </div>

                        </div>

                     </div>

                  </form>

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


   <script src='<?php echo site_url() . 'assets/admin/js/script/nueva_venta.js'; ?>'></script>

   <!-- [ Header ] end -->

   <!-- [ Main Content ] end -->

   <?php echo view("admin/footer"); ?>