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
                                 <h5 class="m-b-10">Formulario de Puntos de Binario</h5> 
                              </div>
                              <ul class="breadcrumb">
                                 <li class="breadcrumb-item"><a href="/dashboard">Panel</a></li> 
                                 <li class="breadcrumb-item"><a href="<?php echo site_url().'dashboard/puntos';?>">Listado de Puntos de Binario</a></li>
                                 <li class="breadcrumb-item"><a>Puntos de Binario</a></li>
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
                                 <form name="form-points" id="form-points" enctype="multipart/form-data" method="post" action="javascript:void(0);" onsubmit="validate();">
                                          <div class="form-row">
                                             <div class="form-group col-md-12">
                                                   <div class="form-group">
                                                         <label>ID</label>
                                                         <input class="form-control" type="text" value="<?php echo isset($obj_points_binary[0]->id)?$obj_points_binary[0]->id:"";?>" class="input-xlarge-fluid" placeholder="ID" disabled="">
                                                         <input type="hidden" id="idid" name="id" value="<?php echo isset($obj_points_binary[0]->id)?$obj_points_binary[0]->id:"";?>">
                                                   </div>
                                             </div>
                                             <div class="form-group col-md-6">
                                                   <div class="form-group">
                                                         <label>ID Cliente</label>
                                                         <input class="form-control" type="text" id="customer_id" name="customer_id" value="<?php echo isset($obj_points_binary[0]->customer_id)?$obj_points_binary[0]->customer_id:"";?>" class="input-xlarge-fluid" placeholder="Cliente" disabled="">
                                                   </div>
                                                   <div class="form-group">
                                                         <label>Usuario</label>
                                                         <input class="form-control" type="text" id="username" name="username" value="<?php echo isset($obj_points_binary[0]->username)?$obj_points_binary[0]->username:"";?>" class="input-xlarge-fluid" placeholder="Username" disabled="">
                                                   </div>
                                                   <div class="form-group">
                                                         <label>Nombre</label>
                                                         <input class="form-control" type="text" id="name" name="name" value="<?php echo isset($obj_points_binary[0]->first_name)?$obj_points_binary[0]->first_name." ".$obj_points_binary[0]->last_name:"";?>" class="input-xlarge-fluid" placeholder="Nombre" disabled="">
                                                   </div>
                                                   <div class="form-group">
                                                            <label>Fecha</label>
                                                            <input class="form-control" type="text" id="date" name="date" value="<?php echo isset($obj_points_binary[0]->date)?formato_fecha_barras($obj_points_binary[0]->date):"";?>" class="input-xlarge-fluid" placeholder="Nombre" disabled="">
                                                   </div>
                                                   </div>
                                                   <div class="form-group col-md-6">
                                                   <div class="form-group">
                                                         <label>Puntos Izquierda</label>
                                                         <input class="form-control" type="text" id="left" name="left" value="<?php echo isset($obj_points_binary[0]->left)?$obj_points_binary[0]->left:0;?>" class="input-xlarge-fluid" placeholder="Puntos">
                                                   </div>
                                                   <div class="form-group">
                                                         <label>Puntos Derecha</label>
                                                         <input class="form-control" type="text" id="right" name="right" value="<?php echo isset($obj_points_binary[0]->right)?$obj_points_binary[0]->right:0;?>" class="input-xlarge-fluid" placeholder="Puntos">
                                                   </div>
                                                   <div class="form-group">
                                                   <label for="inputState">Estado</label>
                                                         <select name="status" id="status" class="form-control">
                                                         <option value="">[ Seleccionar ]</option>
                                                         <option value="1" <?php if(isset($obj_points_binary)){
                                                               if($obj_points_binary[0]->status == 1){ echo "selected";}
                                                         }else{echo "";} ?>>Abonado</option>
                                                         <option value="0" <?php if(isset($obj_points_binary)){
                                                               if($obj_points_binary[0]->status == 2){ echo "selected";}
                                                         }else{echo "";} ?>>Pagado</option>
                                                   </select>
                                                </div>
                                             </div>
                                          </div>
                                          <button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-cloud" aria-hidden="true"></i>Guardar</button>
                                          <button class="btn btn-danger" type="reset" onclick="cancel_points();"><i class="fa fa-arrow-left" aria-hidden="true"></i>Cancelar</button>                    
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
      <script src="<?php echo base_url('js/backoffice/admin/point_list.js'); ?>"></script> 
      <!-- [ Header ] end -->
      <!-- [ Main Content ] end -->
      <?php echo view("backoffice/admin/footer"); ?>