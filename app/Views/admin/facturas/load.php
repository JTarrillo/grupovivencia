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
                                 <h5 class="m-b-10">Formulario de Facturas</h5> 
                              </div>
                              <ul class="breadcrumb">
                                 <li class="breadcrumb-item"><a href="/dashboard">Panel</a></li>
                                 <li class="breadcrumb-item"><a>Facturas</a></li>
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
                                 <form name="form-invoices" enctype="multipart/form-data" method="post" action="javascript:void(0);" onsubmit="validate();">
                                    <div class="form-row">
                                       <div class="form-group col-md-12">
                                          <?php 
                                          if(isset($obj_invoices)){ ?>
                                             <div class="form-group">
                                                   <label>ID</label>
                                                   <input class="form-control" type="text" value="<?php echo isset($obj_invoices[0]->id)?$obj_invoices[0]->id:"";?>" class="input-xlarge-fluid" placeholder="ID" disabled="">
                                                   <input type="hidden" id="invoice_id" name="invoice_id" value="<?php echo isset($obj_invoices[0]->id)?$obj_invoices[0]->id:"";?>">
                                             </div>
                                       <?php } ?>
                                       </div>
                                    <div class="form-group col-md-6">
                                          <div class="form-group">
                                          <label>Username</label>
                                          <input class="form-control" type="text" id="username" name="username" value="<?php echo isset($obj_invoices[0]->username)?$obj_invoices[0]->username:"";?>" class="input-xlarge-fluid" placeholder="Username" disabled="">
                                          </div>
                                          <div class="form-group">
                                             <label>Cliente</label>
                                             <input class="form-control" type="text" id="customer" name="customer" value="<?php echo isset($obj_invoices[0]->name)?$obj_invoices[0]->name." ".$obj_invoices[0]->lastname:"";?>" class="input-xlarge-fluid" placeholder="Cliente" disabled="">
                                          </div>
                                          <div class="form-group">
                                             <label>Fecha</label>
                                                <input class="form-control" type="text" id="date" name="date"  placeholder="YYYY-mm-dd" value="<?php echo isset($obj_invoices[0]->date)?formato_fecha_db_time($obj_invoices[0]->date):"";?>" class="input-xlarge-fluid" placeholder="Fecha">
                                          </div>
                                          
                                    </div>
                                    <div class="form-group col-md-6">
                                          <div class="form-group">
                                             <label for="inputState">Plan</label>
                                             <select name="kit" id="kit" class="form-control">
                                                <option value="">[ Seleccionar ]</option>
                                                      <?php foreach ($obj_kit as $value ): ?>
                                                <option value="<?php echo $value->id;?>"
                                                      <?php 
                                                            if(isset($obj_invoices[0]->kit_id)){
                                                                     if($obj_invoices[0]->kit_id==$value->id){
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
                                             <label>Importe</label>
                                                <input class="form-control" type="text" name="price" id="price" value="<?php echo isset($obj_invoices[0]->price)?($obj_invoices[0]->price):"";?>" class="input-xlarge-fluid" placeholder="Precio">
                                          </div>
                                          <div class="form-group">
                                             <label for="inputState">Estado</label>
                                                <select name="active" id="active" class="form-control">
                                                   <option value="">[ Seleccionar ]</option>
                                                   <option value='0' <?php if(isset($obj_invoices)){
                                                      if($obj_invoices[0]->active == '0'){ echo "selected";}
                                                   }else{echo "";} ?>>Sin Acción</option>
                                                   <option value='1' <?php if(isset($obj_invoices)){
                                                      if($obj_invoices[0]->active == '1'){ echo "selected";}
                                                   }else{echo "";} ?>>En Espera</option>
                                                   <option value='2' <?php if(isset($obj_invoices)){
                                                      if($obj_invoices[0]->active == '2'){ echo "selected";}
                                                   }else{echo "";} ?>>Procesado</option>
                                                   <option value='3' <?php if(isset($obj_invoices)){
                                                      if($obj_invoices[0]->active == '3'){ echo "selected";}
                                                   }else{echo "";} ?>>Cancelado</option>
                                          </select>
                                          </div>
                                    </div>
                                    </div>
                                    <button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-cloud" aria-hidden="true"></i>Guardar</button>
                                    <button class="btn btn-danger" type="reset" onclick="cancelar_invoice();"><i class="fa fa-arrow-left" aria-hidden="true"></i>Cancelar</button>                    
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
      <script src="<?php echo base_url('assets/admin/js/script/invoices.js'); ?>"></script> 
      <!-- [ Header ] end -->
      <!-- [ Main Content ] end -->
      <?php echo view("admin/footer"); ?>