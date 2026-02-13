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

                                 <h5 class="m-b-10">Formulario de Integración de Pago</h5> 

                              </div>

                              <ul class="breadcrumb">

                                 <li class="breadcrumb-item"><a href="<?php echo site_url()."dashboard/panel";?>">Panel</a></li>

                                 <li class="breadcrumb-item"><a href="<?php echo site_url()."dashboard/integracion_pagos";?>">Listado de Integración</a></li>

                                 <li class="breadcrumb-item"><a>Integración de Pago</a></li>

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

                                 <form name="integration-form" enctype="multipart/form-data" method="post" action="javascript:void(0);" onsubmit="integration_active();">

                                       <div class="form-row">

                                          <?php 

                                          if($obj_comissions){ ?>

                                             <div class="form-group col-md-12">

                                             <div class="form-group">

                                                   <label>ID</label>

                                                   <input class="form-control" type="text" value="<?php echo isset($obj_comissions->id)?$obj_comissions->id:null;?>" class="input-xlarge-fluid" placeholder="ID" readonly>

                                             </div>

                                       </div>

                                       <?php  } ?>

                                       <div class="form-group col-md-6">

                                             <div class="form-group">

                                             <label>Código</label>

                                             <input class="form-control" type="hidden" id="commissions_id" name="commissions_id" value="<?php echo isset($obj_comissions->id)?$obj_comissions->id:"";?>" class="input-xlarge-fluid" placeholder="ID" readonly>

                                             <input class="form-control" onblur="validate_user(this.value);" type="text" id="username" name="username" class="input-xlarge-fluid" placeholder="Ingrese Código" required="" value="<?php echo isset($obj_comissions)?$obj_comissions->code:"";?>">

                                             <input type="hidden" id="customer_id" name="customer_id" value="<?php echo isset($obj_comissions)?$obj_comissions->customer_id:"";?>">

                                             <input type="hidden" id="bonus_id" name="bonus_id" value="<?php echo $bonus_id;?>">

                                             <span class="alert-0"></span>

                                             </div>

                                             <div class="form-group">

                                                <label>Cliente</label>

                                                <input class="form-control" type="text" id="customer" name="customer" class="input-xlarge-fluid" placeholder="Cliente" disabled="" value="<?php echo isset($obj_comissions)?$obj_comissions->name." ".$obj_comissions->lastname:"";?>">

                                             </div>

                                             <div class="form-group">

                                                <label>Documento</label>

                                                   <input class="form-control" type="text" id="dni" name="dni" class="input-xlarge-fluid" placeholder="DNI" disabled="" value="<?php echo isset($obj_comissions)?$obj_comissions->dni:"";?>">

                                             </div>

                                       </div>

                                       <div class="form-group col-md-6">

                                          <div class="form-group">

                                                <label>Importe s/.</label>

                                                   <input class="form-control" type="number" id="amount" name="amount" class="input-xlarge-fluid" placeholder="Importe" required="" step="any" value="<?php echo isset($obj_comissions)?$obj_comissions->amount:"";?>">

                                          </div>

                                       </div>

                                          <button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-cloud" aria-hidden="true"></i>Guardar</button>

                                          <button class="btn btn-danger" type="reset" onclick="cancel();"><i class="fa fa-arrow-left" aria-hidden="true"></i>Cancelar</button>                    

                                       </div>

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

      <script src="<?php echo base_url('assets/admin/js/script/integration.js?123'); ?>"></script> 

      <!-- [ Header ] end -->

      <!-- [ Main Content ] end -->

      <?php echo view("admin/footer"); ?>