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
                              <h5 class="m-b-10">Inventario</h5>
                           </div>
                           <ul class="breadcrumb">
                              <li class="breadcrumb-item"><a href="<?php echo site_url() . "dashboard/panel"; ?>">Panel</a></li>
                              <li class="breadcrumb-item"><a>Inventario</a></li>
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
                                 <h5>Inventario & Stock</h5>
                              </div>
                              <!-- begin filter -->
                              <div class="card-body">
                                 <form name="form" method="post" action="<?php echo site_url()."dashboard/inventario";?>">
                                    <div class="row">
                                       <div class="col-md-4">
                                          <div class="input-group-append">
                                             <select name="store_id" class="form-control" style="border-radius: 3px 0px 0px 3px;">
                                                <option value="">Todos los almacenes</option>
                                                <?php foreach ($obj_store as $value): ?>
                                                   <option value="<?php echo $value->id;?>" <?php echo $store_id == $value->id?"selected":"";?>> <?php echo $value->name;?></option>
                                                <?php endforeach; ?>
                                             </select>
                                                <button type="submit" class="btn btn-dark" style="border-radius: 0px 3px 3px 0px;"><i class="fa fa-search"></i></button>
                                                <button <?php echo $style;?> type="submit" formaction="<?php echo site_url()."dashboard/inventario/export";?>" class="btn btn-success"><i class="fa fa-file-excel-o"></i></button>
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
                                                               <th>Descripción</th>
                                                               <th>Ingresos</th>
                                                               <th>Salidas</th>
                                                               <th>Disponible</th>
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                                            <?php 
                                                            
                                                            foreach ($obj_stock as $key => $value) :?>
                                                               <tr>
                                                                  <td><?php echo $value->id_2;?></td>
                                                                  <td>
                                                                     <?php echo $value->name;?>
                                                                  </td>
                                                                  <td>
                                                                     <?php 
                                                                     if($value->total_incoming == 0){
                                                                        echo "";
                                                                     }else{
                                                                        echo $value->total_incoming;
                                                                     }
                                                                     ?>
                                                                  </td>
                                                                  <td>
                                                                  <?php 
                                                                     if($value->total_outgoing == 0){
                                                                        echo "";
                                                                     }else{
                                                                        echo $value->total_outgoing;
                                                                     }
                                                                     ?>
                                                                  </td>
                                                                  <td>
                                                                     <?php 
                                                                     if($value->balance == 0){
                                                                        $style = "";
                                                                        $val = "";
                                                                     }elseif($value->balance < 0){
                                                                        $style ="label  label-danger";
                                                                        $val = $value->balance;
                                                                     }else{
                                                                        $style="label  label-info";
                                                                        $val = $value->balance;
                                                                     }
                                                                     ?>
                                                                     <span class="<?php echo $style;?>" style="border-radius: 10px;"><?php echo $val;?></span>
                                                                  </td>
                                                               </tr>
                                                            <?php endforeach; ?>
                                                         </tbody>
                                                         <tfoot>
                                                            <tr>
                                                               <th>ID</th>
                                                               <th>Descripción</th>
                                                               <th>Ingresos</th>
                                                               <th>Salidas</th>
                                                               <th>Disponible</th>
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