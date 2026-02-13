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
                                 <li class="breadcrumb-item"><a>Reporte de Clientes</a></li>
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
                                    <h5>Listado de Clientes</h5>
                                 </div>
                                 <!-- begin filter -->
                                 <form name="form" method="post" action="<?php echo site_url()."dashboard/reportes_clientes";?>">
                                    <div class="card-body">
                                       <div class="row">
                                          <div class="col-md-4">
                                             <div class="form-group">
                                                <input type="text" name="daterange" class="form-control" value="01/01/2023 - 01/31/2023" />
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-group">
                                                <select name="range_id" class="form-control">
                                                   <option value="" <?php echo $range_id == null ? "selected":"";?>>Todos los Rangos</option>
                                                   <?php foreach ($obj_ranges as $value): ?>
                                                      <option value="<?php echo $value->id;?>" <?php echo $range_id == $value->id ? "selected":"";?>><?php echo $value->name;?></option>
                                                   <?php endforeach; ?>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="mb-3 input-group">
                                                <select name="active" class="form-control">
                                                   <option value='' <?php echo $active == null ? "selected":"";?>>Todos los Estado</option>
                                                   <option value='1' <?php echo $active == '1' ? "selected":"";?>>Activos</option>
                                                   <option value='0' <?php echo $active == '0' ? "selected":"";?>>Inactivos</option>
                                                </select>
                                                <div class="input-group-append">
                                                   <button type="submit" class="btn btn-dark"><i class="fa fa-search"></i></button>
                                                </div>
                                                <div class="input-group-append">
                                                   <button <?php echo $style;?> type="submit" formaction="<?php echo site_url()."dashboard/reportes/export_clientes";?>" class="btn btn-success"><i class="fa fa-file-excel-o"></i></button>
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
                                                                  <th>Usuario</th>
                                                                  <th>Cliente</th>
                                                                  <th>DNI</th>
                                                                  <th>E-mail</th>
                                                                  <th>Rango</th>
                                                                  <th>País</th>
                                                                  <th>Patrocinador</th>
                                                                  <th>Estado</th>
                                                               </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php 
                                                            if($obj_customer){
                                                               foreach ($obj_customer as $value): ?>
                                                                  <tr>
                                                                    <th><?php echo $value->id_customer;?></th>
                                                                    <td>
                                                                      <h6><?php echo $value->code;?></h6>
                                                                    </td>
                                                                    <td><?php echo $value->name." ".$value->lastname;?></td>
                                                                    <td><?php echo $value->dni;?></td>
                                                                    <td><?php echo $value->email;?></td>
                                                                    <td>
                                                                      <?php echo $value->range_name;?>
                                                                    </td>
                                                                    <td><img src="<?php echo site_url()."assets/images/paises/".$value->img;?>" width="20"/></td>
                                                                    <td>
                                                                      <h6><?php echo $value->sponsor_name;?></h6>
                                                                    </td>
                                                                    <td>
                                                                        <?php if ($value->active == 0) {
                                                                            $valor = "No Activo";
                                                                            $stilo = "label label-danger";
                                                                        }else{
                                                                            $valor = "Activo";
                                                                            $stilo = "label label-success";
                                                                        } ?>
                                                                        <span class="<?php echo $stilo;?>"><?php echo $valor;?></span>
                                                                    </td>
                                                                </tr>
                                                              <?php endforeach;
                                                            }
                                                            ?>
                                                            </tbody>
                                                            <tfoot>
                                                               <tr>
                                                                  <th>ID</th>
                                                                  <th>Usuario</th>
                                                                  <th>Cliente</th>
                                                                  <th>DNI</th>
                                                                  <th>E-mail</th>
                                                                  <th>Rango</th>
                                                                  <th>País</th>
                                                                  <th>Patrocinador</th>
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
      <script src="<?php echo base_url('assets/admin/js/script/customer.js'); ?>"></script> 
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