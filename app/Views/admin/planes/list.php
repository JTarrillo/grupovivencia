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
                              <h5 class="m-b-10">Productos</h5>
                           </div>
                           <ul class="breadcrumb">
                              <li class="breadcrumb-item"><a href="<?php echo site_url() . "dashboard/panel"; ?>">Panel</a></li>
                              <li class="breadcrumb-item"><a>Productos</a></li>
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
                                    <h5>Listado de Productos</h5>
                                    <button class="btn btn-secondary" type="button" onclick="new_membership();"><span><span class="pcoded-micon"><i class="fa fa-plus" aria-hidden="true"></i></span> Agregar Producto</span></button>
                                    <button class="btn btn-success" id="btn-export">Exportar</button>
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
                                                               <th>Imagen</th>
                                                               <th>Precio Venta</th>
                                                               <th>Valor Punto</th>
                                                               <th>Stock</th>
                                                               <th>Costo Unitario</th>
                                                               <th>Tipo Venta</th>
                                                               <th>Estado</th>
                                                               <th>Acciones</th>
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                                            <?php foreach ($obj_membership as $value) : ?>
                                                               <tr>
                                                                  <th><?php echo $value->id_2; ?></th>
                                                                  <td><?php echo $value->name; ?></td>
                                                                  <td>
                                                                     <a href="<?php echo site_url() . "membresias/$value->id_2/$value->img"; ?>" data-lightbox="<?php echo $value->name; ?>" data-title="<?php echo $value->name; ?>">
                                                                        <i class="fa fa-eye fa-2x"></i>
                                                                     </a>
                                                                  </td>
                                                                  <td>
                                                                     <h6><?php echo format_number_moneda_soles($value->price); ?></h6>
                                                                  </td>
                                                                  <td>
                                                                     <?php echo format_number_miles($value->point); ?>
                                                                  </td>
                                                                  <td>
                                                                     <?php
                                                                     if ($value->balance < 5) {
                                                                        $style = "label  label-danger";
                                                                        $val = $value->balance;
                                                                     } else {
                                                                        $style = "label  label-success";
                                                                        $val = $value->balance;
                                                                     }
                                                                     ?>
                                                                     <span class="<?php echo $style; ?>" style="border-radius: 10px;"><?php echo $val; ?></span>
                                                                  </td>
                                                                  <td>
                                                                     <h6><?php echo format_number_moneda_soles($value->unit_cost); ?></h6>
                                                                  </td>
                                                                  <td>
                                                                     <?php if ($value->sale == '1') {
                                                                        $valor = "Libre";
                                                                        $stilo = "label label-info";
                                                                     } else {
                                                                        $valor = "Stock";
                                                                        $stilo = "label label-warning";
                                                                     } ?>
                                                                     <span style="border-radius:10px;" class="<?php echo $stilo; ?>"><?php echo $valor; ?></span>
                                                                  </td>
                                                                  <td>
                                                                     <?php if ($value->active == '0') {
                                                                        $valor = "Inactivo";
                                                                        $stilo = "label label-danger";
                                                                     } else {
                                                                        $valor = "Activo";
                                                                        $stilo = "label label-success";
                                                                     } ?>
                                                                     <span style="border-radius:10px;" class="<?php echo $stilo; ?>"><?php echo $valor; ?></span>
                                                                  </td>
                                                                  <td>
                                                                     <div class="operation">
                                                                        <div class="btn-group">
                                                                           <button type="button" class="btn btn-icon btn-info" onclick="edit_kit('<?php echo $value->id_2; ?>');"><i class="fa fa-edit"></i></button>
                                                                           <button type="button" class="btn btn-icon btn-danger" onclick="eliminar('<?php echo $value->id_2; ?>');"><i class="fa fa-trash"></i></button>
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
                                                               <th>Imagen</th>
                                                               <th>Precio Venta</th>
                                                               <th>Valor Punto</th>
                                                               <th>Stock</th>
                                                               <th>Costo Unitario</th>
                                                               <th>Tipo Venta</th>
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
   <script>
      const btnExport = document.getElementById("btn-export");
      const data = <?php echo json_encode($obj_membership); ?>;
      btnExport.addEventListener("click", () => {
         exportToExcel(data)
      })
   </script>
   <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js"></script>
   <script src="<?php echo base_url('assets/admin/js/script/membership.js?2024'); ?>"></script>
   <script>
      $('#zero-configuration').dataTable({
         order: [
            [0, 'desc']
         ],
      });
   </script>
   <!-- [ Header ] end -->
   <!-- [ Main Content ] end -->
   <?php echo view("admin/footer"); ?>