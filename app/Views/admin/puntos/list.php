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

                                 <h5 class="m-b-10">Puntos</h5>

                              </div>

                              <ul class="breadcrumb">

                                 <li class="breadcrumb-item"><a href="/dashboard">Panel</a></li>

                                 <li class="breadcrumb-item"><a>Puntos de Rangos</a></li>

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

                                    <h5>Listado de Puntos</h5>

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

                                                                  <th class="sorting_asc">ID</th>

                                                                  <th class="sorting">Fecha</th>

                                                                  <th class="sorting">Periodo</th>

                                                                  <th class="sorting">Usuario</th>

                                                                  <th class="sorting">Cliente</th>

                                                                  <th class="sorting">Puntos</th>

                                                                  <th class="sorting">Estado</th>

                                                                  <th class="sorting">Factura</th>

                                                                  <th class="sorting">Acciones</th>

                                                               </tr>

                                                            </thead>

                                                            <tbody>

                                                               <?php foreach ($pointsData as $value): ?>

                                                                  <td><?php echo $value->id;?></td>

                                                                  <td><?php echo formato_fecha_barras($value->date);?></td>

                                                                  <td>
                                                                     <span style="border-radius:10px" class="label label label-info"><?php echo $value->period;?></span>
                                                                  </td>

                                                                  <td>

                                                                     <?php echo $value->code;?>

                                                                  </td>
                                                                  <td><?php echo $value->name." ".$value->lastname;?></td>

                                                                  <td>

                                                                     <span style="border-radius:10px" class="label label label-success"><?php echo $value->points;?></span>

                                                                  </td>
                                                                  <td>

                                                                        <span class="label label-success">Abonado</span>

                                                                  </td>

                                                                  <td>

                                                                     <a href="#"><?php echo $value->invoice_id;?></a>

                                                                  </td>

                                                                  <td>

                                                                        <div class="operation">

                                                                              <div class="btn-group">

                                                                                    <button type="button" class="btn btn-icon btn-info" onclick="edit_points('<?php echo $value->id;?>');"><i class="fa fa-edit"></i></button>

                                                                                    <button type="button" class="btn btn-icon btn-danger" onclick="delete_points('<?php echo $value->id;?>');"><i class="fa fa-trash"></i></button>

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

                                                                  <th class="sorting">Periodo</th>

                                                                  <th>Cliente</th>

                                                                  <th>Puntos</th>

                                                                  <th>Estado</th>

                                                                  <th>Factura</th>

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

      <script src="<?php echo base_url('assets/admin/js/script/point_list.js?2024'); ?>"></script>

      <!-- [ Header ] end -->

      <!-- [ Main Content ] end -->

      <?php echo view("admin/footer"); ?>