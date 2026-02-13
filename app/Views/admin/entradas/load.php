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
                              <h5 class="m-b-10">Formulario de entrada de productos</h5>
                           </div>
                           <ul class="breadcrumb">
                              <li class="breadcrumb-item"><a href="<?php echo site_url() . "dashboard/panel"; ?>">Panel</a></li>
                              <li class="breadcrumb-item"><a href="<?php echo site_url() . "dashboard/entradas"; ?>">Listado de Entradas</a></li>
                              <li class="breadcrumb-item"><a>Entradas de productos</a></li>
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
                                 <h5>Datos</h5>
                              </div>
                              <div class="card-body">
                                 <form name="form" enctype="multipart/form-data" method="post" action="javascript:void(0);" ; onsubmit="validate();">
                                    <div class="form-row">
                                       <?php
                                       if (isset($obj_incoming)) { ?>
                                          <div class="form-group col-md-12">
                                             <div class="form-group">
                                                <label>ID</label>
                                                <input class="form-control" type="text" value="<?php echo isset($obj_incoming->id) ? $obj_incoming->id : null; ?>" class="input-xlarge-fluid" placeholder="ID" disabled="">
                                             </div>
                                          </div>
                                       <?php } ?>
                                       <input type="hidden" id="incoming_id" name="incoming_id" value="<?php echo isset($obj_incoming->id) ? $obj_incoming->id : null; ?>">
                                       <div class="form-group col-md-6">
                                          <div class="form-group">
                                             <label>Producto</label>
                                             <select name="membership_id" id="membership_id" class="form-control" required>
                                                <option value="">[ Seleccionar ]</option>
                                                   <?php foreach ($obj_memberships as $value ): ?>
                                                   <option value="<?php echo $value->id;?>"
                                                      <?php 
                                                            if(isset($obj_incoming)){
                                                                  if($obj_incoming->membership_id==$value->id){
                                                                        echo "selected";
                                                                  }
                                                            }else{
                                                                     echo "";
                                                            }
                                                      ?>><?php echo $value->name;?>
                                                </option>
                                                <?php endforeach; ?>
                                             </select>
                                          </div>
                                          <div class="form-group">
                                             <label>Costo Unitario s/.</label>
                                             <input class="form-control" type="text" id="unit_cost" name="unit_cost" value="<?php echo isset($obj_incoming->unit_cost) ? $obj_incoming->unit_cost : ""; ?>" class="input-xlarge-fluid" placeholder="Ingrese Costo">
                                          </div>
                                          <div class="form-group">
                                             <label>Cantidad</label>
                                             <input class="form-control" type="number" id="qty" name="qty" value="<?php echo isset($obj_incoming->qty) ? $obj_incoming->qty : ""; ?>" class="input-xlarge-fluid" placeholder="Ingrese cantidad" required>
                                          </div>
                                       </div>
                                       <div class="form-group col-md-6">
                                          <div class="form-group">
                                             <label>Almacen</label>
                                             <select name="store_id" id="store_id" class="form-control" required>
                                                <option value="">[ Seleccionar ]</option>
                                                   <?php foreach ($obj_store as $value ): ?>
                                                   <option value="<?php echo $value->id;?>"
                                                      <?php 
                                                            if(isset($obj_incoming)){
                                                                  if($obj_incoming->store_id==$value->id){
                                                                        echo "selected";
                                                                  }
                                                            }else{
                                                                     echo "";
                                                            }
                                                      ?>><?php echo $value->name;?>
                                                </option>
                                                <?php endforeach; ?>
                                             </select>
                                          </div>
                                          <div class="form-group">
                                             <label>Proveedor</label>
                                             <select name="supplier_id" id="supplier_id" class="form-control" required>
                                             <option value="">[ Seleccionar ]</option>
                                                   <?php foreach ($obj_supplier as $value ): ?>
                                                   <option value="<?php echo $value->id;?>"
                                                      <?php 
                                                            if(isset($obj_incoming)){
                                                                  if($obj_incoming->supplier_id==$value->id){
                                                                        echo "selected";
                                                                  }
                                                            }else{
                                                                     echo "";
                                                            }
                                                      ?>><?php echo $value->name;?>
                                                </option>
                                                <?php endforeach; ?>
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                    <button id="submit" type="submit" class="btn btn-primary"><i class="fa fa-cloud" aria-hidden="true"></i>Guardar</button>
                                    <button class="btn btn-danger" type="reset" onclick="cancel_incoming();"><i class="fa fa-arrow-left" aria-hidden="true"></i>Cancelar</button>
                                 </form>
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
   <script src="<?php echo site_url()."assets/admin/js/script/incoming.js";?>"></script>
   <!-- [ Header ] end -->
   <!-- [ Main Content ] end -->
   <?php echo view("admin/footer"); ?>
   <script>
      const selectProduct = document.getElementById("membership_id");
      const inputUnit_cost = document.getElementById("unit_cost");
      selectProduct.addEventListener("change", () => {
         const selectedOption = selectProduct.value
         $.ajax({
                 url: site + "dashboard/entradas/get_unit_cost",
                 method: "POST",
                 data: {selectedOption : selectedOption
                      },
                 success: function (data) {
                     var data = JSON.parse(data);
                     if (data.status == true) {
                        inputUnit_cost.value = data.unit_cost;
                     }else{
                        inputUnit_cost.value = 0;
                     }
                 }
             });
      })
   </script>