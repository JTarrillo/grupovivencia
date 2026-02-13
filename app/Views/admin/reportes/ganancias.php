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
                              <li class="breadcrumb-item"><a>Reporte de Ganancias</a></li>
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
                              <form name="form" method="post" action="<?php echo site_url() . "dashboard/reportes_ganancias"; ?>">
                                 <div class="card-body">
                                    <div class="row">
                                       <!-- <div class="col-md-3">
                                          <div class="form-group">
                                                <select name="period_id"  id="period_id" class="form-control" required>
                                                   <option value="">Seleccionar Periodo ...</option>
                                                   <?php 
                                                   foreach ($periodData as $key => $value) { ?>
                                                      <option value="<?php echo $value->id;?>" <?php echo $period_id == $value->id ? "selected":"";?>><?php echo $value->code?> | <?php echo formato_fecha_dia_mes_v2($value->begin) ?> - <?php echo formato_fecha_dia_mes_v2($value->end)?></option>   
                                                   <?php } ?>
                                                </select>
                                          </div>
                                       </div> -->
                                       <div class="col-md-3">
                                          <div class="form-group">
                                             <select name="search_type" class="form-control" required>
                                                <option value="dni" <?php echo $search_type == "dni" ? "selected":"";?>>DNI</option>
                                                <option value="code" <?php echo $search_type == "code" ? "selected":"";?>>Código</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="input-group">
                                             <input type="search" name="search_term" class="form-control" placeholder="Ingrese término de búsqueda" value="<?php echo $search_term;?>" required/>
                                             <button type="submit" class="btn btn-dark"><i class="fa fa-search"></i> Buscar</button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </form>
                              <!-- end filter -->
                              <div class="card-block">
                                 <div class="table-responsive">
                                    <table class="table">
                                       <thead>
                                          <tr>
                                             <th>ID</th>
                                             <th>Código</th>
                                             <th>Cliente</th>
                                             <th>DNI</th>
                                             <th>Celular</th>
                                             <th>Correo</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php if ($obj_customer): ?>
                                             <tr>
                                                <td><?php echo $obj_customer->id; ?></td>
                                                <td><?php echo $obj_customer->code; ?></td>
                                                <td><?php echo $obj_customer->name." ".$obj_customer->lastname; ?></td>
                                                <td><?php echo $obj_customer->dni; ?></td>
                                                <td><?php echo $obj_customer->phone; ?></td>
                                                <td><?php echo $obj_customer->email; ?></td>
                                             </tr>
                                          <?php endif; ?>
                                       </tbody>
                                    </table>
                                 </div>
                                 <div class="card-footer">
                                    <div class="row">
                                       <div class="col-md-2"></div>
                                       <div class="col-md-4">
                                          <h6>Comisiones Globales: <span style="font-size: 18px;font-weight: bold;"><?php echo format_number_moneda_soles($total_commissions); ?></span></h6>
                                       </div>
                                       <div class="col-md-4">
                                          <h6>
                                             Total Disponible: <span style="font-size: 18px;color: green;font-weight: bold;"><?php echo format_number_moneda_soles($total_disponible); ?></span>
                                             &nbsp;&nbsp;
                                             <button <?php echo $buttonStyle; ?> type="button" id="submit" class="btn btn-icon btn-warning" title="Descontar" onclick="descontar('<?php echo $obj_customer->id ?? null;?>', '<?php echo $total_disponible;?>');" style="background-color: #dc3545; border-color: #dc3545;border-radius: 50%;">
                                                <i class="fa fa-minus-circle"></i>
                                             </button>
                                          </h6>
                                       </div>
                                       <div class="col-md-2"></div>
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
   <script src="<?php echo base_url('assets/admin/js/script/ganancias.js'); ?>"></script> 
   <script type="text/javascript">
      $(function() {
         $('input[name="daterange"]').daterangepicker({
            locale: {
               format: 'YYYY-MM-DD'
            },
            startDate: '<?php echo $first_day; ?>',
            endDate: '<?php echo $last_day; ?>'
         });
      });
   </script>
   <?php echo view("admin/footer"); ?>
</body>

</html>