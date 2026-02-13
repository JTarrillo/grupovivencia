<!doctype html>

<html lang="es-PE">

   <?php echo view("backoffice/admin/head"); ?>

   <body data-new-gr-c-s-check-loaded="14.1042.0" data-gr-ext-installed="">

      <?php echo view("backoffice/admin/header"); ?>

      <section class="pcoded-main-container">

         <div class="pcoded-wrapper">

            <div class="pcoded-content">

               <div class="pcoded-inner-content">

                  <div class="page-header">

                     <div class="page-block">

                        <div class="row align-items-center">

                           <div class="col-md-12">

                              <div class="page-header-title">

                                 <h5 class="m-b-10">Formulario de Descuento de Pago</h5> 

                              </div>

                              <ul class="breadcrumb">

                                 <li class="breadcrumb-item"><a href="/dashboard">Panel</a></li>

                                 <li class="breadcrumb-item"><a href="<?php echo site_url().'dashboard/descuentos_pagos';?>">Listado de Descuentos de Pagos</a></li>

                                 <li class="breadcrumb-item"><a>Descuento de Pago</a></li>

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

                                 <form name="discount-form" enctype="multipart/form-data" method="post" action="javascript:void(0);" onsubmit="discount_active();">

                                       <div class="form-row">

                                          <?php 

                                          if($obj_comissions){ ?>

                                             <div class="form-group col-md-12">

                                             <div class="form-group">

                                                   <label>ID</label>

                                                   <input class="form-control" type="text" value="<?php echo isset($obj_comissions[0]->commissions_id)?$obj_comissions[0]->commissions_id:null;?>" class="input-xlarge-fluid" placeholder="ID" readonly>

                                             </div>

                                       </div>

                                       <?php  } ?>

                                       <div class="form-group col-md-6">

                                             <div class="form-group">

                                             <label>Usuario</label>

                                             <input class="form-control" type="hidden" id="commissions_id" name="commissions_id" value="<?php echo isset($obj_comissions[0]->commissions_id)?$obj_comissions[0]->commissions_id:"";?>" class="input-xlarge-fluid" placeholder="ID" readonly>

                                             <input class="form-control" onblur="validate_user(this.value);" type="text" id="username" name="username" class="input-xlarge-fluid" placeholder="Ingrese Usuario" required="" value="<?php echo isset($obj_comissions)?$obj_comissions[0]->username:"";?>">

                                             <input type="hidden" id="customer_id" name="customer_id" value="<?php echo isset($obj_comissions)?$obj_comissions[0]->customer_id:"";?>">

                                             <input type="hidden" id="bonus_id" name="bonus_id" value="<?php echo $bonus_id;?>">

                                             <span class="alert-0"></span>

                                             </div>

                                             <div class="form-group">

                                                <label>Cliente</label>

                                                <input class="form-control" type="text" id="customer" name="customer" class="input-xlarge-fluid" placeholder="Cliente" disabled="" value="<?php echo isset($obj_comissions)?$obj_comissions[0]->first_name." ".$obj_comissions[0]->last_name:"";?>">

                                             </div>

                                             <div class="form-group">

                                                <label>Documento</label>

                                                   <input class="form-control" type="text" id="dni" name="dni" class="input-xlarge-fluid" placeholder="DNI" disabled="" value="<?php echo isset($obj_comissions)?$obj_comissions[0]->dni:"";?>">

                                             </div>

                                       </div>

                                       <div class="form-group col-md-6">

                                          <div class="form-group">

                                                <label>Importe <span class="text-danger">(agregar importe en negativo)</span></label>

                                                   <input class="form-control" type="number" id="amount" name="amount" class="input-xlarge-fluid" placeholder="Importe" required="" step="any" value="<?php echo isset($obj_comissions)?$obj_comissions[0]->amount:"";?>">

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

      <script src="<?php echo base_url('js/backoffice/admin/integration_discount.js'); ?>"></script> 

      <!-- [ Header ] end -->

      <!-- [ Main Content ] end -->

      <?php echo view("backoffice/admin/footer"); ?>