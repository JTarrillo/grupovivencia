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
                              <h5 class="m-b-10">Salidas</h5>
                           </div>
                           <ul class="breadcrumb">
                              <li class="breadcrumb-item"><a href="<?php echo site_url() . "dashboard/panel"; ?>">Panel</a></li>
                              <li class="breadcrumb-item"><a>Salidas</a></li>
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
                                 <h5>Listado de Salidas</h5>
                                 <button class="btn btn-secondary" type="button" onclick="new_outgoing();"><span><span class="pcoded-micon"><i class="fa fa-plus" aria-hidden="true"></i></span> Nueva Salida</span></button>
                              </div>
                              <!-- begin filter -->
                              <div class="card-body">
                                 <form name="form" method="post" action="<?php echo site_url()."dashboard/salidas";?>">
                                    <div class="row">
                                       <div class="col-md-4"></div>
                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <input type="text" name="daterange" class="form-control" value="01/01/2023 - 01/31/2023" />
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="input-group-append">
                                             <select name="store_id" class="form-control" style="border-radius: 3px 0px 0px 3px;">
                                                <option value="">Todos las Locaciones</option>
                                                <?php foreach ($obj_store as $value): ?>
                                                   <option value="<?php echo $value->id;?>" <?php echo $store_id == $value->id?"selected":"";?>> <?php echo $value->name;?></option>
                                                <?php endforeach; ?>
                                             </select>
                                             <button type="submit" class="btn btn-dark" style="border-radius: 0px 3px 3px 0px;"><i class="fa fa-search"></i></button>
                                             <button <?php echo $style;?> type="submit" formaction="<?php echo site_url()."dashboard/salidas/export";?>" class="btn btn-success"><i class="fa fa-file-excel-o"></i></button>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                              </form>
                                 <!-- end filter -->
                              <div class="card-block" style="padding: 0px 25px;">
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
                                                               <th>Concepto</th>
                                                               <th>Factura ID</th>
                                                               <th>Producto</th>
                                                               <th>Cantidad</th>
                                                               <th>De Almacen</th>
                                                               <th>Fecha</th>
                                                               <th>Vía</th>
                                                               <th>Ingresado por</th>
                                                               <th>Acciones</th>
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                                            <?php foreach ($obj_outgoing as $value) : ?>
                                                               <tr>
                                                                  <th><?php echo $value->id; ?></th>
                                                                  <td>
                                                                     <span style="border-radius: 10px;" class="label label-danger">Salida</span>
                                                                  </td>
                                                                  <td>
                                                                     <?php echo $value->invoice_id; ?>
                                                                  </td>
                                                                  <td>
                                                                     <h6><?php echo $value->membership; ?></h6>
                                                                  </td>
                                                                  <td>
                                                                     <span class="label label-info" style="border-radius: 10px;"><?php echo $value->qty; ?></span>
                                                                  </td>
                                                                  <td>
                                                                     <?php echo $value->store; ?>
                                                                  </td>
                                                                  <td>
                                                                     <h6><?php echo formato_fecha_dia_mes_anio_abrev($value->date)." ".formato_fecha_minutos($value->date); ?></h6>
                                                                  </td>
                                                                  <td>
                                                                        <?php if ($value->active == '1') {
                                                                           $stilo = "label label-success";
                                                                           $val = "Venta";
                                                                        }elseif($value->active == '2'){
                                                                           $stilo = "label label-primary";
                                                                           $val = "Salida Interna";
                                                                        } ?>
                                                                        <span style="border-radius: 10px;" class="<?php echo $stilo;?>"><?php echo $val;?></span>
                                                                  </td>
                                                                  <td>
                                                                     <?php 
                                                                     if(is_null($value->user)){ 
                                                                        echo "-";

                                                                     }else{
                                                                        echo $value->user;
                                                                     } 
                                                                     ?>
                                                                  </td>
                                                                  <td>
                                                                     <div class="operation">
                                                                        <div class="btn-group">
                                                                           <button type="button" class="btn btn-icon btn-info" onclick="edit_outgoing('<?php echo $value->id; ?>');"><i class="fa fa-edit"></i></button>
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
                                                               <th>Concepto</th>
                                                               <th>Factura ID</th>
                                                               <th>Producto</th>
                                                               <th>Cantidad</th>
                                                               <th>De Almacen</th>
                                                               <th>Fecha</th>
                                                               <th>Vía</th>
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
   <script src="<?php echo site_url() . "assets/admin/js/script/outgoing.js?1"; ?>"></script>
   <!-- [ Header ] end -->
   <!-- [ Main Content ] end -->
   <?php echo view("admin/footer"); ?>