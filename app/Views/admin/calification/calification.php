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
                              <h5 class="m-b-10">Calificados</h5>
                           </div>
                           <ul class="breadcrumb">
                              <li class="breadcrumb-item"><a href="<?php echo site_url() . "dashboard/panel"; ?>">Panel</a></li>
                              <li class="breadcrumb-item"><a>Calificados</a></li>
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
                                    <h5>Listado de Calificados</h5>
                                    <h6>
                                       <?php
                                       $month = date("m");
                                       if ($month >= '1' && $month <= '6') { ?>
                                          Enero - Junio <?php echo date("Y"); ?>
                                       <?php    } else { ?>
                                          Julio - Diciembre <?php echo date("Y"); ?>
                                       <?php    }
                                       ?>
                                    </h6>
                                 </div>
                                 <div class="col-12">
                                    <button class="btn btn-primary" id="btn-export">
                                       Exportar
                                    </button>
                                 </div>
                              </div>
                              <style>
                                 .ratings {
                                    margin-right: 10px;
                                 }

                                 .ratings i {

                                    color: #cecece;
                                    font-size: 26px;
                                 }

                                 .rating-color {
                                    color: #fbc634 !important;
                                 }

                                 .review-count {
                                    font-weight: 400;
                                    margin-bottom: 2px;
                                    font-size: 24px !important;
                                 }

                                 .small-ratings i {
                                    color: #cecece;
                                 }

                                 .review-stat {
                                    font-weight: 300;
                                    font-size: 18px;
                                    margin-bottom: 2px;
                                 }
                              </style>
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
                                                               <th>Nombre</th>
                                                               <th>Usuario</th>
                                                               <th>Viaje</th>
                                                               <th>Auto</th>
                                                               <th>Acciones</th>
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                                            <?php foreach ($obj_calification as $value) : ?>
                                                               <tr>
                                                                  <th><?php echo $value->customer_id2; ?></th>
                                                                  <td><?php echo $value->name . " " . $value->lastname; ?></td>
                                                                  <td><?php echo $value->username; ?></td>
                                                                  <td>
                                                                     <div class="ratings">
                                                                        <?php
                                                                        if ($value->total_travel > 5) {
                                                                           $total_travel = 5;
                                                                        } else {
                                                                           $total_travel = $value->total_travel;
                                                                        }
                                                                        $total_balance = 5 - $total_travel;
                                                                        //show star color
                                                                        for ($i = 1; $i <= $total_travel; $i++) { ?>
                                                                           <i class="fa fa-star rating-color"></i>
                                                                        <?php    }
                                                                        //show star
                                                                        for ($i = 1; $i <= $total_balance; $i++) { ?>
                                                                           <i class="fa fa-star"></i>
                                                                        <?php    } ?>
                                                                     </div>
                                                                  </td>
                                                                  <td>
                                                                     <div class="ratings">
                                                                        <?php
                                                                        if ($value->total_car > 6) {
                                                                           $total_car = 6;
                                                                        } else {
                                                                           $total_car = $value->total_car;
                                                                        }
                                                                        $total_balance = 6 - $total_car;
                                                                        //show star color
                                                                        for ($i = 1; $i <= $total_car; $i++) { ?>
                                                                           <i class="fa fa-star rating-color"></i>
                                                                        <?php    }
                                                                        //show star
                                                                        for ($i = 1; $i <= $total_balance; $i++) { ?>
                                                                           <i class="fa fa-star"></i>
                                                                        <?php    } ?>
                                                                     </div>
                                                                  </td>
                                                                  <td>
                                                                     <div class="operation">
                                                                        <div class="btn-group">
                                                                           <button type="button" class="btn btn-icon btn-info" onclick="view('<?php echo $value->customer_id2; ?>', '<?php echo $begin_period; ?>', '<?php echo $end_period; ?>');"><i class="fa fa-eye"></i></button>
                                                                        </div>
                                                                     </div>
                                                                  </td>
                                                               </tr>
                                                            <?php endforeach; ?>
                                                         </tbody>
                                                         <tfoot>
                                                            <tr>
                                                               <th>ID</th>
                                                               <th>Nombre</th>
                                                               <th>Usuario</th>
                                                               <th>Viaje</th>
                                                               <th>Auto</th>
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
      const data = <?php echo json_encode($obj_calification); ?>;
      btnExport.addEventListener("click", () => {
         exportToExcel(data)
      })
   </script>
   <script src="<?php echo base_url('assets/admin/js/script/calification.js'); ?>"></script>
   <!-- [ Header ] end -->
   <!-- [ Main Content ] end -->
   <?php echo view("admin/footer"); ?>