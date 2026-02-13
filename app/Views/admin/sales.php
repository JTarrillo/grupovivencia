<!DOCTYPE html>
<html lang="en-US">
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
                              <h5 class="m-b-10">Reportes</h5>
                           </div>
                           <ul class="breadcrumb">
                              <li class="breadcrumb-item"><a href="/dashboard/">Panel</a></li>
                              <li class="breadcrumb-item"><a>Reporte de Ventas</a></li>
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
                                 <h5>Listado de Ventas</h5>
                                 <h6>Hoy</h6>
                              </div>
                              <!-- begin filter -->
                              <form id="form-sales" name="form" method="post" action="<?php echo site_url() . "dashboard/ventas"; ?>">
                                 <div class="card-body">
                                    <div class="row">
                                       <div class="col-md-3">
                                          <div class="form-group">
                                             <input type="text" name="daterange" id="dateRangePicker" class="form-control" value="<?php echo $date_start . ' - ' . $date_end; ?>" />
                                          </div>
                                       </div>
                                       <div class="col-md-3">
                                          <div class="form-group">
                                             <select name="date" class="form-control">
                                                <option value="1" <?php echo $date_id == '1' ? "selected" : ""; ?>>Hoy</option>
                                                <option value="2" <?php echo $date_id == '2' ? "selected" : ""; ?>>Ayer</option>
                                                <option value="3" <?php echo $date_id == '3' ? "selected" : ""; ?>>Semana actual</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-md-3">
                                          <div class="form-group">
                                             <select name="store_id" class="form-control">
                                                <option value="" <?php echo $store_id == null ? "selected" : ""; ?>>Todos las locaciones</option>
                                                <?php foreach ($obj_store as $value) : ?>
                                                   <option value="<?php echo $value->id; ?>" <?php echo $store_id == $value->id ? "selected" : ""; ?>><?php echo $value->name; ?></option>
                                                <?php endforeach; ?>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-md-3">
                                          <div class="mb-3 input-group">
                                             <div class="input-group-append">
                                                <select name="payment" class="form-control">
                                                   <option value='' <?php echo $payment == null ? "selected" : ""; ?>>Todos los tipo de pago</option>
                                                   <option value='1' <?php echo $payment == '1' ? "selected" : ""; ?>>Monedero</option>
                                                   <option value='2' <?php echo $payment == '2' ? "selected" : ""; ?>>Tarjeta</option>
                                                   <option value='3' <?php echo $payment == '3' ? "selected" : ""; ?>>En Tienda</option>
                                                </select>
                                                <button type="submit" class="btn btn-dark"><i class="fa fa-search"></i></button>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </form>
                              <!-- end filter -->
                              <div class="card-block">
                                 <div class="table-responsive">
                                    <div id="zero-configuration_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                       <div class="row">
                                          <div class="col-sm-12">
                                             <div id="zero-configuration_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                                <div class="row">
                                                   <div class="col-sm-12">
                                                      <table id="zero-configuration" class="display table nowrap table-striped table-hover dataTable" style="width: 100%;" role="grid" aria-describedby="zero-configuration_info">
                                                         <thead>
                                                            <tr role="row">
                                                               <th>ID</th>
                                                               <th>Periodo</th>
                                                               <th>Concepto</th>
                                                               <th>Cliente</th>
                                                               <th>Tipo de Pago</th>
                                                               <th>Importe</th>
                                                               <th>Puntos</th>
                                                               <th>Recojo</th>
                                                               <th>Fecha</th>
                                                               <th>Estado</th>
                                                               <th>Acción</th>
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                                            <?php
                                                            if ($obj_invoices) {
                                                               foreach ($obj_invoices as $value) : ?>
                                                                  <tr>
                                                                     <td><?php echo $value->id; ?></td>
                                                                     <td><?php echo $value->code; ?></td>
                                                                     <td>
                                                                        <?php 
                                                                        
                                                                        if($value->membership == "Consumidor"){
                                                                           $stilo = "label label-success";
                                                                           $val =  "Recompra";
                                                                           
                                                                        }else{
                                                                           $val =  $value->membership;
                                                                           $stilo = "label label-warning";
                                                                        }
                                                                        ?>
                                                                        <span style="border-radius:10px" class="label <?php echo $stilo;?>"><?php echo $val;?></span>
                                                                     </td>
                                                                     <td>
                                                                        <?php echo $value->name . " " . $value->lastname; ?><br>
                                                                        <b><?php echo "@" . $value->user_code; ?></b>
                                                                     </td>
                                                                     <td>
                                                                        <?php if ($value->payment == '1') {
                                                                           $valor = "Monedero";
                                                                           $stilo = "label label-info";
                                                                        } elseif ($value->payment == '2') {
                                                                           $valor = "Tarjeta";
                                                                           $stilo = "label label-success";
                                                                        } else {
                                                                           $valor = "En Tienda";
                                                                           $stilo = "label label-warning";
                                                                        } ?>
                                                                        <span style="border-radius:10px" class="<?php echo $stilo ?>"><?php echo $valor; ?></span>
                                                                     </td>
                                                                     <td>
                                                                        <h6><?php echo format_number_moneda_soles($value->amount); ?></h6>
                                                                     </td>
                                                                     <td>
                                                                        <?php echo format_number_miles($value->points);?>
                                                                     </td>
                                                                     <td>
                                                                        <?php
                                                                        if ($value->store_name == "Almacén general") { ?>
                                                                           <span style="border-radius:10px" class="label label-info"><?php echo $value->store_name; ?></span>
                                                                        <?php } else { ?>
                                                                           <span style="border-radius:10px;color:white" class="label theme-bg2"><?php echo $value->store_name; ?></span>
                                                                        <?php } ?>
                                                                     </td>
                                                                     <td><?php echo formato_fecha_dia_mes_anio_abrev($value->date) . "<br/>" . formato_fecha_minutos($value->date); ?></td>
                                                                     <td>
                                                                        <?php if ($value->active == '1') {
                                                                           $valor = "Por Pagar";
                                                                           $stilo = "label label-warning";
                                                                        } elseif ($value->active == '2') {
                                                                           $valor = "Pagado";
                                                                           $stilo = "label label-success";
                                                                        } else {
                                                                           $valor = "Cancelado";
                                                                           $stilo = "label label-danger";
                                                                        }
                                                                        ?>
                                                                        <span style="border-radius:10px" class="<?php echo $stilo ?>"><?php echo $valor; ?></span>
                                                                     </td>
                                                                     <td>
                                                                        <div class="operation">
                                                                           <div class="btn-group">
                                                                              <button type="button" class="btn btn-icon btn-info" title="Ver Detalle" onclick="view('<?php echo $value->id; ?>');"><i class="fa fa-eye"></i></button>
                                                                           </div>
                                                                        </div>
                                                                     </td>
                                                                  </tr>
                                                            <?php endforeach;
                                                            }
                                                            ?>
                                                         </tbody>
                                                         <tfoot>
                                                            <tr>
                                                               <th>ID</th>
                                                               <th>Periodo</th>
                                                               <th>Concepto</th>
                                                               <th>Cliente</th>
                                                               <th>Tipo de Pago</th>
                                                               <th>Importe</th>
                                                               <th>Puntos</th>
                                                               <th>Recojo</th>
                                                               <th>Fecha</th>
                                                               <th>Estado</th>
                                                               <th>Acción</th>
                                                            </tr>
                                                         </tfoot>
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
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <script src="<?php echo base_url('assets/admin/js/script/customer.js?1'); ?>"></script>

   <script type="text/javascript">
      $(function() {
         $('#dateRangePicker').daterangepicker({
            locale: {
               format: 'YYYY-MM-DD'
            },
            startDate: '<?php echo $date_start; ?>',
            endDate: '<?php echo $date_end; ?>'
         });

         $('#dateRangePicker').on('apply.daterangepicker', function(ev, picker) {
            document.getElementById("form-sales").submit();
         });
      });
   </script>
   <?php echo view("admin/footer"); ?>