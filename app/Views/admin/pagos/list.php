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

                                 <h5 class="m-b-10">Usuarios</h5>

                              </div>

                              <ul class="breadcrumb">

                                 <li class="breadcrumb-item"><a href="/dashboard">Panel</a></li>

                                 <li class="breadcrumb-item"><a>Usuarios</a></li>

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

                                    <h5>Listado de Usuarios</h5>

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

                                                                    <th>Banco</th>

                                                                    <th>N° Cuenta</th>

                                                                    <th>CCI</th>

                                                                    <th>Importe</th>
                                                                    
                                                                    <th>Factura</th>

                                                                    <th>Estado</th>

                                                                    <th>Acciones</th>

                                                                </tr>

                                                            </thead>

                                                            <tbody>

                                                                <?php foreach ($obj_pay as $value): ?>

                                                                <tr>

                                                                        <td><?php echo $value->id;?></td>

                                                                        <td><?php echo formato_fecha_dia_mes_anio_abrev($value->date)." - ".formato_fecha_minutos($value->date);?></td>

                                                                        <td><?php echo $value->name." ".$value->lastname;?><br/><b><?php echo "#".$value->code;?></b></td>

                                                                        <td><?php echo $value->bank;?></td>

                                                                        <td><?php echo $value->number;?></td>

                                                                        <td><?php echo $value->cci;?></td>

                                                                        <td><b><?php echo format_number_moneda_soles($value->amount);?></b></td>
                                                                        
                                                                        <td>
                                                                            <?php if (!empty($value->factura)): ?>
                                                                                <a href="<?php echo site_url('public/facturas/' . $value->factura); ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-download"></i> Ver</a>
                                                                            <?php else: ?>
                                                                                <span class="text-muted">No adjunta</span>
                                                                            <?php endif; ?>
                                                                        </td>

                                                                        <td>

                                                                            <?php if ($value->active == 1) {

                                                                                $valor = "Es espera";

                                                                                $stilo = "label label-warning";

                                                                            }elseif($value->active == 2){

                                                                                $valor = "Pagado";

                                                                                $stilo = "label label-success";

                                                                            }elseif($value->active == 3){

                                                                                $valor = "Cancelado";

                                                                                $stilo = "label label-danger";

                                                                            } ?>

                                                                            <span class="<?php echo $stilo ?>"><?php echo $valor; ?></span>

                                                                        </td>

                                                                        <td>

                                                                            <div class="operation">

                                                                                <div class="btn-group">

                                                                                    <button type="button" class="btn btn-icon btn-info" onclick="edit_pay('<?php echo $value->id;?>');"><i class="fa fa-edit"></i></button>
                                                                                    
                                                                                    <button type="button" class="btn btn-icon btn-danger" onclick="delete_pay('<?php echo $value->id;?>');" title="Eliminar"><i class="fa fa-trash"></i></button>

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
                                                                    
                                                                    <th>Factura</th>

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

      <!-- Modal para Editar Pago -->
      <div class="modal fade" id="modal_pay" tabindex="-1" role="dialog" aria-labelledby="modalPayLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
               <div class="modal-header bg-primary">
                  <h5 class="modal-title text-white" id="modalPayLabel"><i class="fa fa-money-bill-alt"></i> Gestión de Solicitud de Retiro</h5>
                  <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body" id="body_pay">
                  <div class="text-center">
                     <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Cargando...</span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <script src="<?php echo base_url('assets/admin/js/script/cobros.js'); ?>"></script> 

      <script>
            function edit_pay(id){
                $('#modal_pay').modal('show');
                $.ajax({
                    type: "GET",
                    url: "<?php echo site_url('dashboard/pagos/load');?>/"+id,
                    success: function(data) {
                        $('#body_pay').html(data);
                    }
                });
            }

            function delete_pay(id){
                Swal.fire({
                    title: '\u00bfEst\u00e1s seguro?',
                    text: "Se eliminar\u00e1 esta solicitud de cobro permanentemente.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'S\u00ed, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo site_url('dashboard/pagos/eliminar');?>",
                            data: { id: id },
                            dataType: "json",
                            success: function(response) {
                                if(response.status) {
                                    Swal.fire(
                                        'Eliminado!',
                                        'La solicitud ha sido eliminada.',
                                        'success'
                                    ).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire('Error', 'No se pudo eliminar la solicitud.', 'error');
                                }
                            }
                        });
                    }
                });
            }
      </script>

      <?php echo view("admin/footer"); ?>