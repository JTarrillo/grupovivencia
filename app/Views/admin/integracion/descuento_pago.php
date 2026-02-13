<!doctype html>

<html lang="es-PE">

   <?php echo view("backoffice/admin/head"); ?>

   <body data-new-gr-c-s-check-loaded="14.1042.0" data-gr-ext-installed="">

      <?php echo view("backoffice/admin/header"); ?>

      <section class="pcoded-main-container">

         <div class="pcoded-wrapper">

            <div class="pcoded-content">

               <div class="pcoded-inner-content">

                  <div class="page-header">

                     <div class="page-block">

                        <div class="row align-items-center">

                           <div class="col-md-12">

                              <div class="page-header-title">

                                 <h5 class="m-b-10">Listado de Descuento de Comisiones</h5>

                              </div>

                              <ul class="breadcrumb">

                                 <li class="breadcrumb-item"><a href="/dashboard">Panel</a></li>

                                 <li class="breadcrumb-item"><a>Descuento de Comisiones</a></li>

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

                                    <h5>Listado de Descuento de Comisiones</h5>

                                    <button class="btn btn-secondary" type="button" onclick="new_discount();"><span><span class="pcoded-micon"><i data-feather="plus"></i></span> Nuevo</span></button>

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

                                                            <th class="sorting_asc" rowspan="1" colspan="1" aria-sort="ascending">ID</th>

                                                            <th class="sorting" rowspan="1" colspan="1">Usuario</th>

                                                            <th class="sorting" rowspan="1" colspan="1">Cliente</th>

                                                            <th class="sorting" rowspan="1" colspan="1">Importe</th>

                                                            <th class="sorting" rowspan="1" colspan="1">Fecha</th>

                                                            <th class="sorting" rowspan="1" colspan="1">Acciones</th>

                                                         </tr>

                                                         </thead>

                                                         <tbody>

                                                         <?php foreach ($obj_comissions as $value): ?>

                                                         <td><?php echo $value->commissions_id;?></td>

                                                         <td><b><?php echo $value->username;?></b></td>

                                                         <td><?php echo $value->first_name." ".$value->last_name;?></td>

                                                         <td>

                                                            <span class="text-danger"><?php echo format_number_dolar($value->amount);?></span>

                                                         </td>

                                                         <td><?php echo formato_fecha_barras($value->date);?></td>

                                                         <td>

                                                            <div class="operation">

                                                                  <div class="btn-group">

                                                                     <button type="button" class="btn btn-icon btn-info" onclick="edit_discount('<?php echo $value->commissions_id;?>');"><i class="fa fa-edit"></i></button>

                                                                     <button type="button" class="btn btn-icon btn-danger" onclick="delete_discount('<?php echo $value->commissions_id;?>');"><i class="fa fa-trash"></i></button>

                                                                  </div>

                                                            </div>

                                                         </td>    

                                                      </tr>

                                                      <?php endforeach; ?>

                                                         </tbody>

                                                         <tfoot>

                                                         <tr>

                                                            <th rowspan="1" colspan="1">ID</th>

                                                            <th rowspan="1" colspan="1">Usuario</th>

                                                            <th rowspan="1" colspan="1">Cliente</th>

                                                            <th rowspan="1" colspan="1">Importe</th>                                  

                                                            <th rowspan="1" colspan="1">Fecha</th>

                                                            <th rowspan="1" colspan="1">Acciones</th>

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

      <script src="<?php echo base_url('js/backoffice/admin/integration_discount.js'); ?>"></script> 

      <!-- [ Header ] end -->

      <!-- [ Main Content ] end -->

      <?php echo view("backoffice/admin/footer"); ?>