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
                              <h5 class="m-b-10">Formulario de Traspaso</h5>
                           </div>
                           <ul class="breadcrumb">
                              <li class="breadcrumb-item"><a href="<?php echo site_url() . "dashboard/panel"; ?>">Panel</a></li>
                              <li class="breadcrumb-item"><a href="<?php echo site_url() . "dashboard/traspaso"; ?>">Listado de Transpaso</a></li>
                              <li class="breadcrumb-item"><a>Entradas de traspaso</a></li>
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
                                       if (isset($obj_transfer)) { ?>
                                          <div class="form-group col-md-12">
                                             <div class="form-group">
                                                <label>ID</label>
                                                <input class="form-control" type="text" value="<?php echo isset($obj_transfer->id) ? $obj_incoming->id : null; ?>" class="input-xlarge-fluid" placeholder="ID" disabled="">
                                             </div>
                                          </div>
                                       <?php } ?>
                                       <input type="hidden" id="incoming_id" name="incoming_id" value="<?php echo isset($obj_transfer->id) ? $obj_incoming->id : null; ?>">
                                       <input type="hidden" name="unit_cost" id="unit_cost">
                                       <div class="form-group col-md-6">
                                          <div class="form-group">
                                             <label>Sale de Almacen</label>
                                             <select name="leave_store_id" id="leave_store_id" class="form-control" required>
                                                <option value="">[ Seleccionar ]</option>
                                                   <?php foreach ($obj_store as $value ): ?>
                                                   <option value="<?php echo $value->id;?>"
                                                      <?php 
                                                            if(isset($obj_tranfer)){
                                                                  if($obj_tranfer->incoming_id==$value->id){
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
                                             <label>Llega a Almacen</label>
                                             <select name="arrive_store_id" id="arrive_store_id" class="form-control" required>
                                                <option value="">[ Seleccionar ]</option>
                                                   <?php foreach ($obj_store as $value ): ?>
                                                   <option value="<?php echo $value->id;?>"
                                                      <?php 
                                                            if(isset($obj_tranfer)){
                                                                  if($obj_tranfer->store_id==$value->outgoing_id){
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
                                             <div class="form-group">
                                                <label>Cantidad</label>
                                                <input class="form-control" type="number" id="qty" name="qty" value="<?php echo isset($obj_incoming->qty) ? $obj_incoming->qty : ""; ?>" class="input-xlarge-fluid" placeholder="Ingrese cantidad" min="0" required>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <button id="submit" type="submit" class="btn btn-primary"><i class="fa fa-cloud" aria-hidden="true"></i>Guardar</button>
                                    <button class="btn btn-danger" type="reset" onclick="cancel_transfer();"><i class="fa fa-arrow-left" aria-hidden="true"></i>Cancelar</button>
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
   <script>
      const selectLeave = document.getElementById("leave_store_id");
      const selectArrive = document.getElementById("arrive_store_id");
      const selectProduct = document.getElementById("membership_id");
      const inputQty = document.getElementById("qty");
      const inputUnit_cost = document.getElementById("unit_cost");
      selectLeave.addEventListener("change", () => {
         const selectedOption = selectLeave.value
         const options = selectArrive.options

         let newOption = null
         for (let i = 1; i < options.length; i++) {
            const option = options[i];
            if (option.value !== selectedOption) {
               newOption = option.value
               break
            }            
         }
         selectArrive.value = newOption
      })

      selectProduct.addEventListener("change", () => {
         const selectedOption = selectProduct.value
         const selectLeave_id = selectLeave.value
         //inputQty.setAttribute("max", 5)
         $.ajax({
                url: site + "dashboard/traspaso/get_max_product",
                method: "POST",
                data: {selectedOption : selectedOption,
                       selectLeave_id : selectLeave_id,
                     },
                success: function (data) {
                     var data = JSON.parse(data);
                    if (data.status == true) {
                        inputQty.setAttribute("max", data.balance)
                        inputQty.setAttribute("placeholder", "Cantidad máxima " + data.balance)
                        inputUnit_cost.setAttribute("value", data.unit_cost)
                    } else {
                        inputQty.setAttribute("max", 0)           
                        inputQty.setAttribute("placeholder", "Cantidad máxima " + data.balance)
                        inputUnit_cost.setAttribute("value", data.unit_cost)
                    }
                }
            });
      })
   </script>
   <script src="<?php echo site_url()."assets/admin/js/script/transfer.js";?>"></script>
   <!-- [ Header ] end -->
   <!-- [ Main Content ] end -->
   <?php echo view("admin/footer"); ?>