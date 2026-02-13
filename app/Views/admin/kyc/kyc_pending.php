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
                              <h5 class="m-b-10">KYC Pendientes</h5>
                           </div>
                           <ul class="breadcrumb">
                              <li class="breadcrumb-item"><a href="/dashboard">Panel</a></li>
                              <li class="breadcrumb-item"><a>KYC</a></li>
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
                                    <h5>Listado de Usuarios</h5>
                                 </div>
                                 <div class="col-12">
                                    <button class="btn btn-primary" id="btn-export">
                                       Exportar
                                    </button>
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
                                                               <th>Fecha</th>
                                                               <th>Usuario</th>
                                                               <th>Nombres</th>
                                                               <th>DNI</th>
                                                               <th>Teléfono</th>
                                                               <th>Anverso</th>
                                                               <th>Reverso</th>
                                                               <th>País</th>
                                                               <th>Estado</th>
                                                               <th>Acciones</th>
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                                            <?php foreach ($obj_customer as $value) : ?>
                                                               <tr>
                                                                  <th><?php echo $value->id; ?></th>
                                                                  <td>
                                                                     <h6><?php echo formato_fecha_dia_mes_anio_abrev($value->date) . " - " . formato_fecha_minutos($value->date); ?></h6>
                                                                  </td>
                                                                  <td>
                                                                     <h6><?php echo $value->username; ?></h6>
                                                                  </td>
                                                                  <td>
                                                                     <h6><?php echo $value->name . "<br/>" . $value->lastname; ?></h6>
                                                                  </td>
                                                                  <td><span class="text-c-purple ml-3"><?php echo $value->dni; ?></span></td>
                                                                  <td><?php echo $value->phone; ?></td>
                                                                  <td>
                                                                     <a href="<?php echo site_url() . "kyc/$value->id" . "/" . $value->anverso; ?>" data-lightbox="roadtrip">
                                                                        <i class="fa fa-eye fa-2x"></i>
                                                                     </a>
                                                                  </td>
                                                                  <td>
                                                                     <a href="<?php echo site_url() . "kyc/$value->id" . "/" . $value->reverso; ?>" data-lightbox="roadtrip">
                                                                        <i class="fa fa-eye fa-2x"></i>
                                                                     </a>
                                                                  </td>
                                                                  <td><img src="<?php echo site_url() . "assets/images/paises/" . $value->img; ?>" width="20" /></td>
                                                                  <td>
                                                                     <?php if ($value->kyc == '1') {
                                                                        $valor = "Pendiente";
                                                                        $stilo = "label label-warning";
                                                                     } else {
                                                                        $valor = "Verificado";
                                                                        $stilo = "label label-success";
                                                                     } ?>
                                                                     <span class="<?php echo $stilo; ?>"><?php echo $valor; ?></span>
                                                                  </td>
                                                                  <td>
                                                                     <div class="operation">
                                                                        <div class="btn-group">
                                                                           <button class="btn btn-success buttons-copy buttons-html5" onclick="verificado('<?php echo $value->id; ?>', '<?php echo $value->kyc_id; ?>', '<?php echo $value->email; ?>', '<?php echo $value->name; ?>');" type="button"><span><i class="fa fa-check" aria-hidden="true"></i></span></button>
                                                                           <button class="btn btn-danger buttons-copy buttons-html5" onclick="rechazado('<?php echo $value->id; ?>', '<?php echo $value->kyc_id; ?>', '<?php echo $value->email; ?>', '<?php echo $value->name; ?>');" type="button"><span><i class="fa fa-ban" aria-hidden="true"></i></span></button>
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
                                                               <th>Nombres</th>
                                                               <th>DNI</th>
                                                               <th>Teléfono</th>
                                                               <th>Anverso</th>
                                                               <th>Reverso</th>
                                                               <th>País</th>
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
      const data = <?php echo json_encode($obj_customer); ?>;
      btnExport.addEventListener("click", () => {
         exportToExcel(data)
      })
   </script>
   <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js"></script>
   <script src="<?php echo base_url('assets/admin/js/script/kyc.js?1'); ?>"></script>
   <!-- [ Header ] end -->
   <!-- [ Main Content ] end -->
   <?php echo view("admin/footer"); ?>