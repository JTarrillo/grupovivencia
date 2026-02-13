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
                              <h5 class="m-b-10">Karex</h5>
                           </div>
                           <ul class="breadcrumb">
                              <li class="breadcrumb-item"><a href="<?php echo site_url() . "dashboard/panel"; ?>">Panel</a></li>
                              <li class="breadcrumb-item"><a>Karex</a></li>
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
                                 <h5>Movimientos</h5>
                              </div>
                              <!-- begin filter -->
                              <div class="card-body">
                                 <form name="form" method="post" action="<?php echo site_url()."dashboard/kardex";?>">
                                    <div class="row">
                                       <div class="col-md-4">
                                          <div class="input-group-append">
                                                <input type="text" name="daterange" class="form-control" value="01/01/2023 - 01/31/2023" />   
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="input-group-append">
                                             <select name="membership_id" class="form-control" style="border-radius: 3px 0px 0px 3px;">
                                                <option value="">Todos los productos</option>
                                                <?php foreach ($obj_membership as $value): ?>
                                                   <option value="<?php echo $value->id;?>" <?php echo $membership_id == $value->id?"selected":"";?>> <?php echo $value->name;?></option>
                                                <?php endforeach; ?>
                                             </select>
                                                <button type="submit" class="btn btn-dark" style="border-radius: 0px 3px 3px 0px;"><i class="fa fa-search"></i></button>
                                                <button <?php echo $style;?> type="submit" formaction="<?php echo site_url()."dashboard/kardex/export";?>" class="btn btn-success"><i class="fa fa-file-excel-o"></i></button>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          
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
                                                               <th>Referencia</th>
                                                               <th>Fecha</th>
                                                               <th>Concepto</th>
                                                               <th>Producto</th>
                                                               <th>Locación</th>
                                                               <th>Cantidad</th>
                                                               <th>Costo Unitario</th>
                                                               <th>Costo Total</th>
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                                            <?php 
                                                            
                                                            foreach ($obj_kardex as $key => $value) : 
                                                               $key += 1;
                                                               ?>
                                                               <tr>
                                                                  <td><?php echo $key; ?></td>
                                                                  <td><?php echo $value->id; ?></td>
                                                                  <th>
                                                                     <?php echo formato_fecha_dia_mes_anio_abrev($value->date)."<br/>".formato_fecha_minutos($value->date); ?>
                                                                  </th>
                                                                  <td>
                                                                     <?php 
                                                                     if($value->concept == 'Salida'){
                                                                        $stilo = "label label-danger";
                                                                     }elseif($value->concept == 'Entrada'){
                                                                        $stilo = "label label-success";
                                                                     }else{
                                                                        $stilo = "label label-warning";
                                                                     }
                                                                     ?>
                                                                     <span style="border-radius: 10px;" class="<?php echo $stilo;?>"><?php echo $value->concept;?></span>
                                                                  </td>
                                                                  <td>
                                                                     <?php echo $value->membership; ?>
                                                                  </td>
                                                                  <td>
                                                                     <?php 
                                                                        if($value->store == 'Almacén general'){
                                                                           $stilo = "label label-info";
                                                                        }elseif($value->store == 'Oficina Los Olivos'){
                                                                           $stilo = "label theme-bg2";
                                                                        }else{
                                                                           $stilo = "label label-warning";
                                                                        }
                                                                     ?>
                                                                     <span style="border-radius: 10px; color:white" class="<?php echo $stilo;?>"><?php echo $value->store;?></span>
                                                                  </td>
                                                                  <td>
                                                                     <span class="label label-info" style="border-radius: 10px;"><?php echo $value->qty; ?></span>
                                                                  </td>
                                                                  <td>
                                                                     s/.<?php echo $value->unit_cost;?>
                                                                  </td>
                                                                  <td>
                                                                     <h6>s/.<?php echo $value->total_cost; ?></h6>
                                                                  </td>
                                                                  
                                                               </tr>
                                                            <?php endforeach; ?>
                                                         </tbody>
                                                         <tfoot>
                                                            <tr>
                                                               <th>ID</th>
                                                               <th>Referencia</th>
                                                               <th>Fecha</th>
                                                               <th>Concepto</th>
                                                               <th>Producto</th>
                                                               <th>Locación</th>
                                                               <th>Cantidad</th>
                                                               <th>Costo Unitario</th>
                                                               <th>Costo Total</th>
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
      function uploadFile() {
         const file = document.getElementById('csvFile').files[0];
         const reader = new FileReader();
         reader.onload = function(e) {
            const contents = e.target.result;
            const lines = contents.split('\n');
            const jsonData = [];

            for (let i = 1; i < lines.length; i++) {
               let record = lines[i].split(',');
               if (record.length > 1) {
                  let jsonObject = {
                     membership: record[0],
                     supplier: record[1],
                     store: record[2],
                     qty: record[3],
                     unit_cost: record[4],
                  }
                  jsonData.push(jsonObject)
               }
            }

            let jsonString = JSON.stringify(jsonData)
            uploadData(jsonString)
         };
         reader.readAsText(file);
      }
   </script>
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
   <script src="<?php echo site_url() . "assets/admin/js/script/incoming.js?1"; ?>"></script>
   <!-- [ Header ] end -->
   <!-- [ Main Content ] end -->
   <?php echo view("admin/footer"); ?>