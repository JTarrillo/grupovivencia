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
                              <h5 class="m-b-10">Proveedores</h5>
                           </div>
                           <ul class="breadcrumb">
                              <li class="breadcrumb-item"><a href="<?php echo site_url() . "dashboard/panel"; ?>">Panel</a></li>
                              <li class="breadcrumb-item"><a>Proveedores</a></li>
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
                                 <h5>Listado de Proveedores</h5>
                                 <button class="btn btn-secondary" type="button" onclick="new_supplier();"><span><span class="pcoded-micon"><i class="fa fa-plus" aria-hidden="true"></i></span> Nuevo Proveedor</span></button>
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
                                                               <th>Razón Social</th>
                                                               <th>RUC</th>
                                                               <th>Teléfono</th>
                                                               <th>Dirección</th>
                                                               <th>Fecha</th>
                                                               <th>Estado</th>
                                                               <th>Acciones</th>
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                                            <?php foreach ($obj_supplier as $value) : ?>
                                                               <tr>
                                                                  <th><?php echo $value->id; ?></th>
                                                                  <td>
                                                                     <h6><?php echo $value->name; ?></h6>
                                                                  </td>
                                                                  <td>
                                                                     <?php echo $value->ruc; ?>
                                                                  </td>
                                                                  <td>
                                                                     <h6><?php echo $value->phone; ?></h6>
                                                                  </td>
                                                                  <td>
                                                                     <h6><?php echo $value->address; ?></h6>
                                                                  </td>
                                                                  <td>
                                                                     <h6><?php echo formato_fecha_dia_mes_anio_abrev($value->date);?></h6>
                                                                  </td>
                                                                  <td>
                                                                        <?php if ($value->active == '0') {
                                                                              $valor = "Inactivo";
                                                                              $stilo = "label label-danger";
                                                                        }else{
                                                                              $valor = "Activo";
                                                                              $stilo = "label label-success";
                                                                        } ?>
                                                                        <span class="<?php echo $stilo;?>"><?php echo $valor;?></span>
                                                                     </td>
                                                                  <td>
                                                                     <div class="operation">
                                                                        <div class="btn-group">
                                                                           <button type="button" class="btn btn-icon btn-info" onclick="edit_supplier('<?php echo $value->id; ?>');"><i class="fa fa-edit"></i></button>
                                                                           <button type="button" class="btn btn-icon btn-danger" onclick="eliminar(this, '<?php echo $value->id; ?>');"><i class="fa fa-trash"></i></button>
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
                                                               <th>Razón Social</th>
                                                               <th>Teléfono</th>
                                                               <th>Dirección</th>
                                                               <th>Fecha</th>
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

   <div class="modal fade" id="modalNuevoProveedor" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">Nuevo Proveedor</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form id="formSupplierModal" name="formSupplierModal" method="post" action="javascript:void(0);" onsubmit="return validate_modal();">
               <div class="modal-body">
                  <input type="hidden" id="modal_supplier_id" name="supplier_id" value="">
                  <div class="form-group">
                     <label>Razón Social <span class="text-danger">*</span></label>
                     <input class="form-control" type="text" id="modal_name" name="name" placeholder="Ingrese Nombre" required>
                  </div>
                  <div class="form-group">
                     <label>RUC</label>
                     <input class="form-control" type="text" id="modal_ruc" name="ruc" placeholder="Ingrese RUC">
                  </div>
                  <div class="form-group">
                     <label>Teléfono</label>
                     <input class="form-control" type="text" id="modal_phone" name="phone" placeholder="Ingrese Teléfono">
                  </div>
                  <div class="form-group">
                     <label>Dirección</label>
                     <input class="form-control" type="text" id="modal_address" name="address" placeholder="Ingrese Dirección">
                  </div>
                  <div class="form-group mb-0">
                     <label>Estado</label>
                     <select class="form-control" name="active" id="modal_active" required>
                        <option value="1" selected>Activo</option>
                        <option value="0">Inactivo</option>
                     </select>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
                  <button id="submit_modal" type="submit" class="btn btn-primary"><i class="fa fa-cloud" aria-hidden="true"></i> Guardar</button>
               </div>
            </form>
         </div>
      </div>
   </div>

   <script src="<?php echo base_url('assets/admin/js/script/supplier.js'); ?>"></script>
   <!-- [ Header ] end -->
   <!-- [ Main Content ] end -->
   <?php echo view("admin/footer"); ?>