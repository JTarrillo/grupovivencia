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
                              <h5 class="m-b-10">Comisiones</h5>
                           </div>
                           <ul class="breadcrumb">
                              <li class="breadcrumb-item"><a href="<?php echo site_url() . "dashboard/panel"; ?>">Panel</a></li>
                              <li class="breadcrumb-item"><a>Comisiones</a></li>
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
                                 <h5>Listado de Comisiones</h5>
                                 <button class="btn btn-primary" id="btn-export">
                                    Exportar
                                 </button>
                              </div>
                              <form id="form-comisions" name="form" method="post" action="<?php echo site_url() . "dashboard/comisiones"; ?>">
                                 <div class="card-body">
                                    <div class="row">
                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <input type="text" name="daterange" id="dateRangePicker" class="form-control" value="01/01/2023 - 01/31/2023" />
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </form>
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
                                                               <th>Fecha</th>
                                                               <th>Cliente</th>
                                                               <th>Factura</th>
                                                               <th>Bono</th>
                                                               <th>Importe</th>
                                                               <th>De</th>
                                                               <th>Estado</th>
                                                               <th>Acciones</th>
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                                            <?php foreach ($obj_comission as $value) : ?>
                                                               <tr>
                                                                  <th><?php echo $value->id; ?></th>
                                                                  <td><?php echo formato_fecha_dia_mes_anio_abrev($value->date) . " - " . formato_fecha_minutos($value->date); ?></td>
                                                                  <td>
                                                                     <?php echo $value->name . " " . $value->lastname; ?><br /><b>#<?php echo $value->code; ?></b>
                                                                  </td>
                                                                  <td>
                                                                     <?php echo $value->invoice_id; ?>
                                                                  </td>
                                                                  <td>
                                                                     <?php echo str_to_first_capital($value->bonus); ?><br />
                                                                     <?php
                                                                     if ($value->level) { ?>
                                                                        <span class="label label-success" style="border-radius:10px;font-size:11px">Nivel:<?php echo $value->level; ?></span>
                                                                     <?php } ?>
                                                                  </td>
                                                                  <td>
                                                                     <h6><?php echo format_number_moneda_soles($value->amount); ?></h6>
                                                                  </td>
                                                                  <td>
                                                                  <?php 
                                                                     if($value->name_arrive){
                                                                        echo $value->name_arrive . " " . $value->lastname_arrive."<br /><b>#".$value->code_arrive."</b>";
                                                                     }else{

                                                                     }
                                                                     ?>
                                                                     
                                                                  </td>
                                                                  <td>
                                                                     <?php if (($value->active == 1) || ($value->active == 2)) {
                                                                        $valor = "Abonado";
                                                                        $stilo = "label label-success";
                                                                     } else {
                                                                        $valor = "No Abonado";
                                                                        $stilo = "label label-danger";
                                                                     } ?>
                                                                     <span class="<?php echo $stilo ?>"><?php echo $valor; ?></span>
                                                                  </td>
                                                                  <td>
                                                                     <div class="operation">
                                                                        <div class="btn-group">
                                                                           <button type="button" class="btn btn-icon btn-info" onclick="edit_comissions('<?php echo $value->id; ?>');"><i class="fa fa-edit"></i></button>
                                                                           <button type="button" class="btn btn-icon btn-danger" onclick="delete_comissions('<?php echo $value->id; ?>');"><i class="fa fa-trash"></i></button>
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
                                                               <th>Cliente</th>
                                                               <th>Factura</th>
                                                               <th>Bono</th>
                                                               <th>Importe</th>
                                                               <th>De</th>
                                                               <th>Estado</th>
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
      const data = <?php echo json_encode($obj_comission); ?>;
      btnExport.addEventListener("click", () => {
         exportToExcel(data)
      })
   </script>
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
            document.getElementById("form-comisions").submit();
         });
      });
   </script>
   <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.11.10/sorting/daterange.js"></script>
   <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js"></script>
   <script src="<?php echo base_url('assets/admin/js/script/comission.js?12345'); ?>"></script>
   <!-- [ Header ] end -->
   <!-- [ Main Content ] end -->
   <?php echo view("admin/footer"); ?>