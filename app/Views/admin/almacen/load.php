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
                                 <h5 class="m-b-10">Formulario de Almacenes</h5> 
                              </div>
                              <ul class="breadcrumb">
                                 <li class="breadcrumb-item"><a href="<?php echo site_url()."dashboard/panel";?>">Panel</a></li>
                                 <li class="breadcrumb-item"><a href="<?php echo site_url()."dashboard/almacenes";?>">Listado de Almacenes</a></li>
                                 <li class="breadcrumb-item"><a>Almacenes</a></li>
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
                                 <form name="form" enctype="multipart/form-data" method="post" action="javascript:void(0);"; onsubmit="validate();">
                                       <div class="form-row">
                                       <?php 
                                       if(isset($obj_store)){ ?>
                                       <div class="form-group col-md-12">
                                             <div class="form-group">
                                                   <label>ID</label>
                                                   <input class="form-control" type="text" value="<?php echo isset($obj_store)?$obj_store->id:null;?>" class="input-xlarge-fluid" placeholder="ID" disabled="">
                                             </div>
                                       </div>
                                    <?php } ?>
                                    <input type="hidden" id="id" name="id" value="<?php echo isset($obj_store)?$obj_store->id:null;?>">
                                       <div class="form-group col-md-6">
                                             <div class="form-group">
                                             <label>Nombre Almacen</label>
                                                <input class="form-control" type="text" id="name" name="name" value="<?php echo isset($obj_store)?$obj_store->name:"";?>" class="input-xlarge-fluid" placeholder="Ingrese Nombre" required="">
                                             </div>
                                       </div>
                                       <div class="form-group col-md-6">
                                             <div class="form-row">
                                             <div class="form-group col-md-12">
                                                   <label for="inputState">Estado</label>
                                                      <select name="active" id="active" class="form-control">
                                                      <option value="">[ Seleccionar ]</option>
                                                         <option value="1" <?php if(isset($obj_store)){
                                                            if($obj_store->active == '1'){ echo "selected";}
                                                         }else{echo "";} ?>>Activo</option>
                                                         <option value="0" <?php if(isset($obj_store)){
                                                            if($obj_store->active == '0'){ echo "selected";}
                                                         }else{echo "";} ?>>Inactivo</option>
                                                   </select>

                                             </div>
                                          </div>
                                       </div>
                                       </div>
                                       <button id="submit" type="submit" class="btn btn-primary"><i class="fa fa-cloud" aria-hidden="true"></i>Guardar</button>
                                       <button class="btn btn-danger" type="reset" onclick="cancel();"><i class="fa fa-arrow-left" aria-hidden="true"></i>Cancelar</button>                    
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
      <script src="<?php echo base_url('assets/admin/js/script/almacen.js'); ?>"></script> 
      <!-- [ Header ] end -->
      <!-- [ Main Content ] end -->
      <?php echo view("admin/footer"); ?>