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
                              <h5 class="m-b-10">Rangos</h5>
                           </div>
                           <ul class="breadcrumb">
                              <li class="breadcrumb-item"><a href="<?php echo site_url() . "dashboard/panel"; ?>">Panel</a></li>
                              <li class="breadcrumb-item"><a>Rangos</a></li>
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
                                 <div class="row">
                                    <div class="col-12 mb-3">
                                       <h5>Listado de Nuevos Rangos</h5>
                                    </div>
                                    <div class="col-12">
                                       <button class="btn btn-primary" id="btn-export">
                                          Exportar
                                       </button>
                                    </div>
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
                                                               <th>Nombre</th>
                                                               <th>Código</th>
                                                               <th>Rango</th>
                                                               <th>Imagen</th>
                                                               <th>Puntos</th>
                                                               <th>Fecha</th>
                                                               <th>Estado</th>
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                                            <?php foreach ($obj_ranges as $value) : ?>
                                                               <tr>
                                                                  <td><?php echo $value->id; ?></td>
                                                                  <td><?php echo $value->name." <br/>".$value->lastname;?></td>
                                                                  <td><?php echo $value->code;?></td>
                                                                  <td><?php echo str_to_mayusculas($value->range_name);?></td>
                                                                  <td>
                                                                     <img src="<?php echo site_url() . "rangos/$value->range_id/$value->img"; ?>" alt="<?php echo $value->range_name; ?>" width="40">
                                                                  </td>
                                                                  <td><?php echo format_number_miles($value->points);?></td>
                                                                  <td><?php echo formato_fecha_dia_mes_anio_abrev($value->date)." ".formato_fecha_minutos($value->date); ?></td>
                                                                  <td>
                                                                     <?php if ("$value->date" >= "$date") { ?>
                                                                        <span class="badge badge-danger">Nuevo Rango Obtenido</span>
                                                                     <?php } else {  ?>
                                                                        <span class="badge badge-info">Activo</span>
                                                                     <?php } ?>
                                                                  </td>
                                                               </tr>
                                                            <?php endforeach; ?>
                                                         </tbody>
                                                         <tfoot>
                                                            <tr>
                                                               <th>ID</th>
                                                               <th>Nombre</th>
                                                               <th>Código</th>
                                                               <th>Rango</th>
                                                               <th>Imagen</th>
                                                               <th>Puntos</th>
                                                               <th>Fecha</th>
                                                               <th>Estado</th>
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
      const data = <?php echo json_encode($obj_ranges); ?>;
      btnExport.addEventListener("click", () => {
         exportToExcel(data)
      })
   </script>
   <script src="<?php echo base_url('assets/admin/js/script/ranges.js?1234'); ?>"></script>
   <!-- Export Excel -->
   <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js"></script>
   <!-- [ Header ] end -->
   <!-- [ Main Content ] end -->
   <?php echo view("admin/footer"); ?>