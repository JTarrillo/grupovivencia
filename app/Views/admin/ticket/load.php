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

                                 <h5 class="m-b-10">Formulario de Ticket</h5> 

                              </div>

                              <ul class="breadcrumb">

                                 <li class="breadcrumb-item"><a href="<?php echo site_url()."dashboard/panel";?>">Panel</a></li>

                                 <li class="breadcrumb-item"><a href="<?php echo site_url()."dashboard/ticket";?>">Listado de Ticket</a></li>

                                 <li class="breadcrumb-item"><a>Ticket</a></li>

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

                                 <form name="form-ticket" enctype="multipart/form-data" method="post" action="javascript:void(0);"; onsubmit="validate();">

                                       <div class="form-row">

                                       <?php 

                                       if(isset($obj_ticket)){ ?>

                                       <div class="form-group col-md-12">

                                             <div class="form-group">

                                                   <label>ID</label>

                                                   <input class="form-control" type="text" value="<?php echo isset($obj_ticket->id)?$obj_ticket->id:null;?>" class="input-xlarge-fluid" placeholder="ID" disabled="">

                                             </div>

                                       </div>

                                    <?php } ?>

                                    <input type="hidden" id="id" name="id" value="<?php echo isset($obj_ticket->id)?$obj_ticket->id:null;?>">

                                       <div class="form-group col-md-6">

                                             <div class="form-group">

                                             <label>Título</label>

                                             <input class="form-control" type="text" value="<?php echo isset($obj_ticket->title)?$obj_ticket->title:"";?>" class="input-xlarge-fluid" disabled>

                                             </div>  

                                             <div class="form-group">

                                             <label>Cliente</label>

                                             <input class="form-control" type="text" value="<?php echo isset($obj_ticket)?$obj_ticket->name." ".$obj_ticket->lastname:"";?>" class="input-xlarge-fluid" disabled>

                                             </div>

                                             <div class="form-group">

                                             <label>Código</label>

                                             <input class="form-control" type="text" value="<?php echo isset($obj_ticket)?$obj_ticket->code:"";?>" class="input-xlarge-fluid" disabled>

                                             </div>

                                             <div class="form-group">

                                                   <label for="inputState">Estado</label>

                                                      <select name="active" id="active" class="form-control" required="">

                                                      <option value="">[ Seleccionar ]</option>

                                                         <option value="1" <?php if(isset($obj_ticket)){

                                                            if($obj_ticket->active == '1'){ echo "selected";}

                                                         }else{echo "";} ?>>En Espera</option>

                                                         <option value="2" <?php if(isset($obj_ticket)){

                                                            if($obj_ticket->active == '2'){ echo "selected";}

                                                         }else{echo "";} ?>>En Proceso</option>

                                                         <option value="3" <?php if(isset($obj_ticket)){

                                                            if($obj_ticket->active == '3'){ echo "selected";}

                                                         }else{echo "";} ?>>Terminado</option>

                                                      </select>

                                             </div>  

                                       </div>

                                       <div class="form-group col-md-6">

                                             <div class="form-group">

                                             <label>Contenido</label>

                                             <textarea class="form-control" name="content" id="content" rows="6" cols="50" placeholder="Ingrese Contenido"><?php echo isset($obj_ticket->content)?$obj_ticket->content:"";?></textarea>

                                             </div>

                                             <div class="form-group">

                                             <label>Respuesta</label>

                                             <textarea class="form-control" name="response" id="response" rows="6" cols="50" placeholder="Ingrese Respuesta"><?php echo isset($obj_ticket->response)?$obj_ticket->response:"";?></textarea>

                                             </div>

                                       </div>

                                       </div>

                                       <button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-cloud" aria-hidden="true"></i>Guardar</button>

                                       <button class="btn btn-danger" type="reset" onclick="cancelar_ticket();"><i class="fa fa-arrow-left" aria-hidden="true"></i>Cancelar</button>                    

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

      <script src="<?php echo base_url('assets/admin/js/script/ticket.js'); ?>"></script> 

      <!-- [ Header ] end -->

      <!-- [ Main Content ] end -->

      <?php echo view("admin/footer"); ?>