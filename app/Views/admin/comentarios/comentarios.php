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
                              <h5 class="m-b-10">Comentarios</h5>
                           </div>
                           <ul class="breadcrumb">
                              <li class="breadcrumb-item"><a href="/dashboard">Panel</a></li>
                              <li class="breadcrumb-item"><a>Comentarios</a></li>
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
                                 <h5>Listado de Comentarios</h5>
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
                                                               <th>Nombres</th>
                                                               <th>E-mail</th>
                                                               <th>Teléfono</th>
                                                               <th>Estado</th>
                                                               <th>Acciones</th>
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                                            <?php foreach ($obj_comments as $value) : ?>
                                                               <tr>
                                                                  <th><?php echo $value->id; ?></th>
                                                                  <td><?php echo formato_fecha_dia_mes_anio_abrev($value->date)." - ".formato_fecha_minutos($value->date); ?></td>
                                                                  <td>
                                                                     <h6><?php echo str_to_first_capital($value->name); ?></h6>
                                                                  </td>
                                                                  <td><?php echo $value->email; ?></td>
                                                                  <td><?php echo $value->phone; ?></td>
                                                                  <td>
                                                                     <?php if ($value->active == 0) {
                                                                        $valor = "Atendido";
                                                                        $stilo = "label label-success";
                                                                     } else {
                                                                        $valor = "No Atendido";
                                                                        $stilo = "label label-danger";
                                                                     } ?>
                                                                     <span class="<?php echo $stilo; ?>"><?php echo $valor; ?></span>
                                                                  </td>
                                                                  <td>
                                                                     <div class="operation">
                                                                        <div class="btn-group">
                                                                           <?php
                                                                           if ($value->active == 1) { ?>
                                                                              <button class="btn btn-success buttons-html5" onclick="change_state('<?php echo $value->id; ?>');" tabindex="0" aria-controls="key-act-button" type="button"><span><i class="fa fa-check" aria-hidden="true"></i>&nbsp; Atentido</span></button>
                                                                           <?php } ?>
                                                                           <button type="button" class="btn btn-icon btn-info" onclick="view('<?php echo $value->id; ?>');"><i class="fa fa-eye"></i></button>
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
                                                               <th>Nombres</th>
                                                               <th>E-mail</th>
                                                               <th>Comentario</th>
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
   <script src="<?php echo base_url('assets/admin/js/script/comments.js'); ?>"></script>
   <!-- [ Main Content ] end -->
   <?php echo view("admin/footer"); ?>