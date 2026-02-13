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
                              <h5 class="m-b-10">Pagos</h5>
                           </div>
                           <ul class="breadcrumb">
                              <li class="breadcrumb-item"><a href="<?php echo site_url() . "dashboard/panel"; ?>">Panel</a></li>
                              <li class="breadcrumb-item"><a>Pagos</a></li>
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
                                    <h5>Listado de Pagos</h5>
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
                                          <!-- begin total amount invoices-->
                                          <div class="col-md-6 col-xl-3">
                                             <div class="card theme-bg bitcoin-wallet">
                                                <div class="card-block">
                                                   <h5 class="text-white mb-2">Importe a Pagar</h5>
                                                   <h2 class="text-white mb-2 f-w-300"><?php echo format_number_moneda_soles($obj_total[0]->pending_total_pay); ?></h2>
                                                   <span class="text-white d-block">Listado de todo los Payout</span>
                                                   <i class="fa fa-credit-card f-70 fa-4x text-white"></i>
                                                </div>
                                             </div>
                                          </div>
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
                                                               <th>Acciones</th>
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                                            <?php foreach ($obj_pay as $value) : ?>
                                                               <tr>
                                                                  <td><?php echo $value->id; ?></td>
                                                                  <td><?php echo formato_fecha_dia_mes_anio_abrev($value->date) . " - " . formato_fecha_minutos($value->date); ?></td>
                                                                  <td>
                                                                     <h6><?php echo $value->name . " " . $value->lastname; ?><br /><?php echo $value->code; ?><h6>
                                                                  </td>
                                                                  <td><?php echo $value->bank; ?></td>
                                                                  <td><?php echo $value->number; ?></td>
                                                                  <td><?php echo $value->cci; ?></td>
                                                                  <td>
                                                                     <h6><?php echo "s/." . format_number_miles_decimal($value->amount); ?></h6>
                                                                  </td>
                                                                  <td><img src="<?php echo site_url() . "assets/metronic8/media/flags/" . $value->img; ?>" width="20" /></td>
                                                                  <td>
                                                                     <?php if ($value->active == '1') {
                                                                        $valor = "Es espera";
                                                                        $stilo = "label label-warning";
                                                                     } elseif ($value->active == '2') {
                                                                        $valor = "Pagado";
                                                                        $stilo = "label label-success";
                                                                     } elseif ($value->active == '3') {
                                                                        $valor = "Cancelado";
                                                                        $stilo = "label label-danger";
                                                                     } ?>
                                                                     <span class="<?php echo $stilo ?>"><?php echo $valor; ?></span>
                                                                  </td>
                                                                  <td>
                                                                     <div class="operation">
                                                                        <div class="btn-group">
                                                                           <?php if ($value->active == 1) { ?>
                                                                              <button class="btn btn-success" type="button" onclick="pagado('<?php echo $value->id; ?>','<?php echo $value->amount; ?>','<?php echo $value->discount; ?>','<?php echo $value->total; ?>','<?php echo $value->email; ?>','<?php echo $value->name; ?>','<?php echo $value->hash_id; ?>');"><span class="pcoded-micon"><i data-feather="dollar-sign"></i></span> Pagado</button>
                                                                              <button class="btn btn-danger" type="button" onclick="devolver('<?php echo $value->id; ?>');"><span class="pcoded-micon"><i data-feather="x-circle"></i></span> Devolver</button>
                                                                           <?php } ?>
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
                                                               <th>Banco</th>
                                                               <th>N° Cuenta</th>
                                                               <th>CCI</th>
                                                               <th>Importe</th>
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
      const data = <?php echo json_encode($obj_pay); ?>;
      btnExport.addEventListener("click", () => {
         exportToExcel(data)
      })
   </script>
   <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js"></script>
   <script src="<?php echo base_url('assets/admin/js/script/activar_pagos.js?1'); ?>"></script>
   <!-- [ Header ] end -->
   <!-- [ Main Content ] end -->
   <?php echo view("admin/footer"); ?>