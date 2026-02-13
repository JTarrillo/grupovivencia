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
                              <h5 class="m-b-10">Pago en Tienda</h5>
                           </div>
                           <ul class="breadcrumb">
                              <li class="breadcrumb-item"><a href="/dashboard">Panel</a></li>
                              <li class="breadcrumb-item"><a>Pago en Tienda</a></li>
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
                                    <h5>Listado de Activaciones</h5>
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
                                                               <th>Periodo</th>
                                                               <th>Concepto</th>
                                                               <th>Cliente</th>
                                                               <th>Código</th>
                                                               <th>Tipo de Pago</th>
                                                               <th>Tel. Contacto</th>
                                                               <th>Recojo</th>
                                                               <th>Importe</th>
                                                               <th>Estado</th>
                                                               <th>Fecha</th>
                                                               <th>Acciones</th>
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                                            <?php foreach ($obj_invoices as $key => $value) : ?>
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
                                                                  <?php echo $value->name . "<br/> " . $value->lastname; ?></h6>
                                                               </td>
                                                               <td>
                                                                  <b><?php echo $value->user_code; ?></b>
                                                               </td>
                                                               <td>
                                                                  <?php if ($value->payment == '3') {
                                                                     $valor = "En tienda";
                                                                     $stilo = "label label-info";
                                                                  } else {
                                                                     $valor = "-";
                                                                     $stilo = "";
                                                                  } ?>
                                                                  <span class="<?php echo $stilo ?>"><?php echo $valor; ?></span>
                                                               </td>
                                                               <td><?php echo $value->phone; ?></td>
                                                               <td>
                                                                  <h6><?php echo $value->store_name; ?></h6>
                                                               </td>
                                                               <td>
                                                                  <h6><?php echo format_number_moneda_soles($value->amount); ?></h6>
                                                               </td>
                                                               <td>
                                                                  <?php if ($value->active == '1') {
                                                                     $valor = "Pendiente";
                                                                     $stilo = "label label-warning";
                                                                  } else {
                                                                     $valor = "-";
                                                                     $stilo = "";
                                                                  } ?>
                                                                  <span class="<?php echo $stilo ?>"><?php echo $valor; ?></span>
                                                               </td>
                                                               <td><?php echo formato_fecha_dia_mes_anio_abrev($value->date)." ".formato_fecha_minutos($value->date); ?></td>
                                                               <td>
                                                                  <div class="operation">
                                                                     <div class="btn-group">
                                                                        <button type="button" class="btn btn-icon btn-info" onclick="view('<?php echo $value->id; ?>');"><i class="fa fa-eye"></i></button>
                                                                     </div>
                                                                  </div>
                                                               </td>
                                                               </tr>
                                                            <?php endforeach; ?>
                                                         </tbody>
                                                         <tfoot>
                                                            <tr>
                                                               <th>ID</th>
                                                               <th>Periodo</th>
                                                               <th>Concepto</th>
                                                               <th>Cliente</th>
                                                               <th>Código</th>
                                                               <th>Tipo de Pago</th>
                                                               <th>Tel. Contacto</th>
                                                               <th>Recojo</th>
                                                               <th>Importe</th>
                                                               <th>Estado</th>
                                                               <th>Fecha</th>
                                                               <th>Acciones</th>
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
   <script src="<?php echo site_url() . "assets/admin/js/script/pago_tienda.js?123456"; ?>"></script>
   <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js"></script>
   <!-- [ Header ] end -->
   <!-- [ Main Content ] end -->
   <?php echo view("admin/footer"); ?>