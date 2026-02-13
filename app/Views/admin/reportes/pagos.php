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
                                 <li class="breadcrumb-item"><a>Reporte de Pagos</a></li>
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
                                    <h5>Listado de Pagos</h5>
                                 </div>
                                 <!-- begin filter -->
                                 <form name="form" method="post" action="<?php echo site_url()."dashboard/reportes_pagos";?>">
                                    <div class="card-body">
                                       <div class="row">
                                          <div class="col-md-6">
                                          </div>
                                          <div class="col-md-3">
                                             <div class="form-group">
                                                <input type="text" name="daterange" class="form-control"/>
                                             </div>
                                          </div>
                                          <div class="col-md-3">
                                             <div class="mb-3 input-group">
                                                <select name="active" class="form-control">
                                                   <option value='' <?php echo $active == null ? "selected":"";?>>Todos los Estado</option>
                                                   <option value='1' <?php echo $active == '1' ? "selected":"";?>>En espera</option>
                                                   <option value='2' <?php echo $active == '2' ? "selected":"";?>>Procesado</option>
                                                   <option value='3' <?php echo $active == '3' ? "selected":"";?>>Cancelados</option>
                                                </select>
                                                <div class="input-group-append">
                                                   <button type="submit" class="btn btn-dark"><i class="fa fa-search"></i></button>
                                                </div>
                                                <div class="input-group-append">
                                                   <button <?php echo $style;?> type="submit" formaction="<?php echo site_url()."dashboard/reportes/export_pagos";?>" class="btn btn-success"><i class="fa fa-file-excel-o"></i></button>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </form>
                                 <!-- end filter -->
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
                                                                  <th>Banco</th>
                                                                  <th>N° Cuenta</th>
                                                                  <th>CCI</th>
                                                                  <th>Importe</th>
                                                                  <th>País</th>
                                                                  <th>Estado</th>
                                                               </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php 
                                                            if($obj_pagos){
                                                               foreach ($obj_pagos as $value): ?>
                                                                  <tr>
                                                                  <td><?php echo $value->id;?></td>
                                                                     <td><?php echo formato_fecha_dia_mes_anio_abrev($value->date)." - ".formato_fecha_minutos($value->date);?></td>
                                                                     <td><h6><?php echo $value->name." ".$value->lastname;?><br/><?php echo $value->code;?><h6></td>
                                                                     <td><?php echo $value->bank;?></td>
                                                                     <td><?php echo $value->number;?></td>
                                                                     <td><?php echo $value->cci;?></td>
                                                                     <td><h6><?php echo "s/.".format_number_miles($value->amount);?></h6></td>
                                                                     <td><img src="<?php echo site_url()."assets/images/paises/".$value->img;?>" width="20"/></td>
                                                                     <td>
                                                                           <?php if ($value->active == '1') {
                                                                              $valor = "Es espera";
                                                                              $stilo = "label label-warning";
                                                                           }elseif($value->active == '2'){
                                                                              $valor = "Pagado";
                                                                              $stilo = "label label-success";
                                                                           }elseif($value->active == '3'){
                                                                              $valor = "Cancelado";
                                                                              $stilo = "label label-danger";
                                                                           } ?>
                                                                           <span class="<?php echo $stilo ?>"><?php echo $valor; ?></span>
                                                                     </td>
                                                                </tr>
                                                              <?php endforeach;
                                                            }
                                                            ?>
                                                            </tbody>
                                                            <tfoot>
                                                               <tr>
                                                                  <th>ID</th> 
                                                                  <th>Fecha</th>
                                                                  <th>Usuario</th>
                                                                  <th>Banco</th>
                                                                  <th>N° Cuenta</th>
                                                                  <th>CCI</th>
                                                                  <th>Importe</th>
                                                                  <th>País</th>
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
      <script type="text/javascript">
         $(function() {
            $('input[name="daterange"]').daterangepicker(
            {
               locale: {
                  format: 'YYYY-MM-DD'
               },
               startDate: '<?php echo $first_day;?>',
               endDate: '<?php echo $last_day;?>'
            });
         });
         </script>
      <?php echo view("admin/footer"); ?>