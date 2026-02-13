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

                                 <h5 class="m-b-10">Listado de Integración por Sistema</h5>

                              </div>

                              <ul class="breadcrumb">

                                 <li class="breadcrumb-item"><a href="/dashboard">Panel</a></li>

                                 <li class="breadcrumb-item"><a>Integración por Sistema</a></li>

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

                                    <h5>Listado de Integración por Sistema</h5>

                                    <button class="btn btn-secondary" type="button" onclick="new_integrate();"><span><span class="pcoded-micon"><i data-feather="plus"></i></span> Nuevo</span></button>

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

                                                               <th>Fecha</th>

                                                               <th>Usuario</th>

                                                               <th>Importe s/.</th>

                                                               <th>Estado</th>

                                                               <th>Acciones</th>

                                                            </tr>

                                                            </thead>

                                                            <tbody>

                                                            <?php foreach ($obj_comissions as $value): ?>

                                                            <td><?php echo $value->id;?></td>

                                                            <td class="text-end"><?php echo formato_fecha_dia_mes_anio_abrev($value->date)." - ".formato_fecha_minutos($value->created_at);?></td>

                                                            <td><h6><?php echo $value->name." ".$value->lastname;?></h6><?php echo $value->code;?></td>

                                                            <td><h6><?php echo format_number_moneda_soles($value->amount);?></h6></td>

                                                            <td>

                                                                  <?php if ($value->active == 1) {

                                                                     $valor = "Activo";

                                                                     $stilo = "label label-success";

                                                                  }else{

                                                                     $valor = "Inactivo";

                                                                     $stilo = "label label-danger";

                                                                  }?>

                                                                  <span class="<?php echo $stilo ?>"><?php echo $valor;?></span>

                                                            </td>

                                                            <td>

                                                            <div class="operation">

                                                               <div class="btn-group">

                                                                  <button type="button" class="btn btn-icon btn-info" onclick="edit_integrate('<?php echo $value->id;?>');"><i class="fa fa-edit"></i></button>

                                                                  <button type="button" class="btn btn-icon btn-danger" onclick="delete_integrate('<?php echo $value->id;?>');"><i class="fa fa-trash"></i></button>

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

                                                               <th>Usuario</th>

                                                               <th>Importe</th>                                  

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

      <script src="<?php echo base_url('assets/admin/js/script/integration.js?123'); ?>"></script> 

      <!-- [ Header ] end -->

      <!-- [ Main Content ] end -->

      <?php echo view("admin/footer"); ?>