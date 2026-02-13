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
                              <li class="breadcrumb-item"><a>Listado de recojos verificados</a></li>
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
                                 <div class="col-12 mb-3">
                                    <h5>Recojos verificados</h5>
                                 </div>
                                 <div class="col-12">
                                    <button class="btn btn-primary" id="btn-export">
                                       Exportar
                                    </button>
                                 </div>
                              </div>
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
                                                               <th>Cliente</th>
                                                               <th>Tipo de Pago</th>
                                                               <th>Recojo</th>
                                                               <th>Importe</th>
                                                               <th>Fecha Recojo</th>
                                                               <th>Estado</th>
                                                               <th>Delivery</th>
                                                               <th>Accion</th>
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                                            <?php
                                                            if ($obj_invoices) {
                                                               foreach ($obj_invoices as $value) : ?>
                                                                  <tr>
                                                                     <td><?php echo $value->id; ?></td>
                                                                     <td>
                                                                        <?php echo $value->name . " " . $value->lastname; ?><br>
                                                                        <b><?php echo "@" . $value->code; ?></b>
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
                                                                        <?php
                                                                        if ($value->store_name == "Almacén general") { ?>
                                                                           <span style="border-radius:10px" class="label label-info"><?php echo $value->store_name; ?></span>
                                                                        <?php } else { ?>
                                                                           <span style="border-radius:10px;color:white" class="label theme-bg2"><?php echo $value->store_name; ?></span>
                                                                        <?php } ?>
                                                                     </td>
                                                                     <td>
                                                                        <h6><?php echo format_number_moneda_soles($value->amount); ?></h6>
                                                                     </td>
                                                                     <td>
                                                                        <?php 
                                                                        if($value->delivery_date){
                                                                           echo formato_fecha_dia_mes_anio_abrev($value->delivery_date)." ".formato_fecha_minutos($value->delivery_date);    
                                                                        }else{
                                                                           echo "";
                                                                        }
                                                                        ?>
                                                                     </td>
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
                                                                        <?php if ($value->delivery == '1') {
                                                                           $valor = "Pendiente";
                                                                           $stilo = "label label-warning";
                                                                        } else {
                                                                           $valor = "Entregado";
                                                                           $stilo = "label label-success";
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
                                                               <th>Cliente</th>
                                                               <th>Tipo de Pago</th>
                                                               <th>Recojo</th>
                                                               <th>Importe</th>
                                                               <th>Fecha Recojo</th>
                                                               <th>Estado</th>
                                                               <th>Delivery</th>
                                                               <th>Accion</th>
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
   <script>
      const btnExport = document.getElementById("btn-export");
      const data = <?php echo json_encode($obj_invoices); ?>;
      btnExport.addEventListener("click", () => {
         exportToExcel(data)
      })
   </script>
   <script src="<?php echo base_url('assets/admin/js/script/recojo.js'); ?>"></script>
   <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js"></script>
   <?php echo view("admin/footer"); ?>