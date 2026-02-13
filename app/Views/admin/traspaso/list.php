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
                              <h5 class="m-b-10">Traspaso</h5>
                           </div>
                           <ul class="breadcrumb">
                              <li class="breadcrumb-item"><a href="<?php echo site_url() . "dashboard/panel"; ?>">Panel</a></li>
                              <li class="breadcrumb-item"><a>Traspaso</a></li>
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
                                    <h5>Listado de Traspaso</h5>
                                    <button class="btn btn-secondary" type="button" onclick="new_transfer();"><span><span class="pcoded-micon"><i class="fa fa-plus" aria-hidden="true"></i></span> Nuevo Traspaso</span></button>
                                 </div>
                                 <div class="col-12">
                                    <button class="btn btn-primary" id="btn-export">
                                       Exportar
                                    </button>
                                 </div>
                              </div>
                              <hr />
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
                                                            <th>Fecha</th>
                                                            <th>Sale</th>
                                                            <th>Producto</th>
                                                            <th>Cantidad</th>
                                                            <th>Costo Unitario</th>
                                                            <th>Costo Total</th>
                                                            <th>Llega</th>
                                                            <th>Ingresado por</th>
                                                            <th>Acciones</th>
                                                         </tr>
                                                      </thead>
                                                      <tbody>
                                                         <?php foreach ($obj_transfer as $value) : ?>
                                                            <tr>
                                                               <th><?php echo $value->id; ?></th>
                                                               <td>
                                                                  <?php echo formato_fecha_dia_mes_anio_abrev($value->date); ?>
                                                               </td>
                                                               <td>
                                                                  <span class="label label-danger" style="border-radius: 10px;"><?php echo $value->departure; ?></span>
                                                               </td>
                                                               <td>
                                                                  <?php echo $value->name; ?>
                                                               </td>
                                                               <td>
                                                                  <span class="label label-info" style="border-radius: 10px;"><?php echo $value->qty; ?></span>
                                                               </td>
                                                               <td>
                                                                  s/. <?php echo format_number_miles_decimal($value->unit_cost); ?>
                                                               </td>
                                                               <td>
                                                                  s/. <?php echo format_number_miles_decimal($value->total_costo); ?>
                                                               </td>
                                                               <td>
                                                                  <span class="label label-info" style="border-radius: 10px;"><?php echo $value->arrive; ?></span>
                                                               </td>
                                                               <td>
                                                                  <h6><?php echo $value->user; ?></h6>
                                                               </td>
                                                               <td>
                                                                  <div class="operation">
                                                                     <div class="btn-group">
                                                                        <button type="button" class="btn btn-icon btn-info" onclick="edit_transfer('<?php echo $value->id; ?>');"><i class="fa fa-edit"></i></button>
                                                                        <button type="button" class="btn btn-icon btn-danger" onclick="eliminar('<?php echo $value->id; ?>');"><i class="fa fa-trash"></i></button>
                                                                     </div>
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                         <?php endforeach; ?>
                                                      </tbody>
                                                      <tfoot>
                                                         <tr>
                                                            <th>ID</th>
                                                            <th>Fecha</th>
                                                            <th>Sale</th>
                                                            <th>Producto</th>
                                                            <th>Cantidad</th>
                                                            <th>Costo Unitario</th>
                                                            <th>Costo Total</th>
                                                            <th>Llega</th>
                                                            <th>Ingresado por</th>
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
      const data = <?php echo json_encode($obj_transfer); ?>;
      btnExport.addEventListener("click", () => {
         exportToExcel(data)
      })
   </script>
   <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js"></script>
   <script src="<?php echo site_url() . "assets/admin/js/script/transfer.js?"; ?>"></script>
   <!-- [ Header ] end -->
   <!-- [ Main Content ] end -->
   <?php echo view("admin/footer"); ?>