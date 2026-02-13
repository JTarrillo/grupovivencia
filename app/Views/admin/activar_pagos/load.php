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
                                 <h5 class="m-b-10">Formulario de Activación de Pagos</h5> 
                              </div>
                              <ul class="breadcrumb">
                                 <li class="breadcrumb-item"><a href="<?php echo site_url()."dashboard/panel";?>">Panel</a></li>
                                 <li class="breadcrumb-item"><a href="<?php echo site_url()."dashboard/activar_pagos";?>">Listado Activación de Pagos</a></li>
                                 <li class="breadcrumb-item"><a>Activación de Pagos</a></li>
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
                                    <form name="form-pay" enctype="multipart/form-data" method="post" action="javascript:void(0);"; onsubmit="validate();">
                                          <div class="form-row">
                                          <?php 
                                          if(isset($obj_pay)){ ?>
                                          <div class="form-group col-md-12">
                                                <div class="form-group">
                                                      <label>ID</label>
                                                      <input class="form-control" type="text" value="<?php echo isset($obj_pay->id)?$obj_pay->id:null;?>" class="input-xlarge-fluid" placeholder="ID" disabled="">
                                                      <input type="hidden" id="id" name="id" value="<?php echo isset($obj_pay->id)?$obj_pay->id:null;?>">
                                                </div>
                                          </div>
                                       <?php } ?>
                                          <div class="form-group col-md-6">
                                                <div class="form-group">
                                                <label>Cliente</label>
                                                <input class="form-control" type="text" value="<?php echo isset($obj_pay)?$obj_pay->name." ".$obj_pay->lastname:"";?>" class="input-xlarge-fluid" disabled>
                                                </div>
                                                <div class="form-group">
                                                <label>Usuario</label>
                                                <input class="form-control" type="text" value="<?php echo isset($obj_pay)?$obj_pay->username:"";?>" class="input-xlarge-fluid" disabled>
                                                </div>
                                          </div>
                                          <div class="form-group col-md-6">
                                                <div class="form-group">
                                                <label>Importe</label>
                                                <input class="form-control" type="text" name="amount" id="amount" value="<?php echo isset($obj_pay)?$obj_pay->amount:"";?>" class="input-xlarge-fluid" required="">
                                                </div>
                                                <div class="form-group">
                                                <label>Descuento</label>
                                                <input class="form-control" type="text" name="discount" id="discount" value="<?php echo isset($obj_pay)?$obj_pay->discount:"";?>" class="input-xlarge-fluid" required="">
                                                </div>
                                                <div class="form-group">
                                                <label>Importe Total</label>
                                                <input class="form-control" type="text" name="total" id="total" value="<?php echo isset($obj_pay)?$obj_pay->total:"";?>" class="input-xlarge-fluid" required="">
                                                </div>
                                                <div class="form-group">
                                                <label>Hash ID</label>
                                                <textarea class="form-control" name="hash_id" id="hash_id" placeholder="Ingrese Hash ID"><?php echo isset($obj_pay->hash_id)?$obj_pay->hash_id:"";?></textarea>
                                                </div>
                                                <div class="form-row">
                                                <div class="form-group col-md-12">
                                                      <label for="inputState">Estado</label>
                                                         <select name="active" id="active" class="form-control" required="">
                                                         <option value="">[ Seleccionar ]</option>
                                                            <option value="1" <?php if(isset($obj_pay)){
                                                               if($obj_pay->active == '1'){ echo "selected";}
                                                            }else{echo "";} ?>>En Espera</option>
                                                            <option value="2" <?php if(isset($obj_pay)){
                                                               if($obj_pay->active == '2'){ echo "selected";}
                                                            }else{echo "";} ?>>Pagado</option>
                                                            <option value="3" <?php if(isset($obj_pay)){
                                                               if($obj_pay->active == '3'){ echo "selected";}
                                                            }else{echo "";} ?>>Cancelado</option>
                                                      </select>

                                                </div>
                                             </div>
                                          </div>
                                          </div>
                                          <button id="submit" type="submit" class="btn btn-primary"><i class="fa fa-cloud" aria-hidden="true"></i>Guardar</button>
                                          <button class="btn btn-danger" type="reset" onclick="cancelar_pay();"><i class="fa fa-arrow-left" aria-hidden="true"></i>Cancelar</button>                    
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
      <script src="<?php echo base_url('assets/admin/js/script/activar_pagos.js'); ?>"></script> 
      <!-- [ Header ] end -->
      <!-- [ Main Content ] end -->
      <?php echo view("admin/footer"); ?>