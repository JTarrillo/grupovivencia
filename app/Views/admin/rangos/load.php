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
                                 <h5 class="m-b-10">Formulario de Rangos</h5> 
                              </div>
                              <ul class="breadcrumb">
                                 <li class="breadcrumb-item"><a href="<?php echo site_url()."dashboard/panel";?>">Panel</a></li> 
                                 <li class="breadcrumb-item"><a href="<?php echo site_url().'dashboard/rangos';?>">Listado de Rangos</a></li>
                                 <li class="breadcrumb-item"><a>Rangos</a></li>
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
                                 <form enctype="multipart/form-data" name="form-rangos" method="post" action="javascript:void(0);" onsubmit="validate();">
                                    <input type="hidden" id="img_temp" name="img_temp" value="<?php echo isset($obj_ranges)?$obj_ranges->img:"";?>">
                                       <div class="form-row">
                                       <?php 
                                       if(isset($obj_ranges)){ ?> 
                                          <div class="form-group col-md-12">
                                                <div class="form-group">
                                                      <label>ID</label>
                                                      <input class="form-control" type="text" value="<?php echo isset($obj_ranges->id)?$obj_ranges->id:"";?>" class="input-xlarge-fluid" placeholder="ID" disabled="">
                                                </div>
                                          </div>
                                          <?php } ?>
                                          <input type="hidden" id="range_id" name="range_id" value="<?php echo isset($obj_ranges->id)?$obj_ranges->id:"";?>">
                                       <div class="form-group col-md-6">
                                             <div class="form-group">
                                                   <label>Nombre</label>
                                                   <input class="form-control" type="text" id="name" name="name" value="<?php echo isset($obj_ranges->name)?$obj_ranges->name:"";?>" class="input-xlarge-fluid" placeholder="Nombre" require>
                                             </div>
                                             <div class="form-group">
                                                   <label>Descripción</label>
                                                   <textarea class="form-control" name="description" placeholder="Ingresar Descripción" style="height: 100px;width: 100% !important" placeholder="Descripcion"><?php echo isset($obj_ranges)?$obj_ranges->description:"";?></textarea>
                                             </div>
                                          </div>
                                       <div class="form-group col-md-6">
                                          <?php 
                                             if(isset($obj_ranges->img)){ ?>
                                                <a href="<?php echo site_url() . "rangos/$obj_ranges->id/$obj_ranges->img"; ?>" data-lightbox="<?php echo $obj_ranges->name;?>" data-title="<?php echo $obj_ranges->name;?>">
                                                   <i class="fa fa-eye fa-2x"></i>
                                                </a>
                                             <?php  } ?>
                                             <div class="form-group">
                                                   <label for="floatingInput">PIN Rangos (200 x 200)</label>
                                                   <input class="form-control" type="file" name="img" id="img">
                                             </div>
                                          <div class="form-group">
                                                   <label>Puntos</label>
                                                   <input class="form-control" type="text" id="points" name="points" value="<?php echo isset($obj_ranges->points)?$obj_ranges->points:"";?>" class="input-xlarge-fluid" placeholder="Puntos" require>
                                             </div>
                                             <div class="form-group">
                                                   <label for="inputState">Estado</label>
                                                   <select name="active" id="active" class="form-control">
                                                      <option value="">[ Seleccionar ]</option>
                                                         <option value="1" <?php if(isset($obj_ranges)){
                                                            if($obj_ranges->active == 1){ echo "selected";}
                                                         }else{echo "";} ?>>Activo</option>
                                                         <option value="0" <?php if(isset($obj_ranges)){
                                                            if($obj_ranges->active == 0){ echo "selected";}
                                                         }else{echo "";} ?>>Inactivo</option>
                                                   </select>
                                             </div>
                                       </div>
                                       </div>
                                       <button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-cloud" aria-hidden="true"></i>Guardar</button>
                                       <button class="btn btn-danger" type="reset" onclick="cancel_ranges();"><i class="fa fa-arrow-left" aria-hidden="true"></i>Cancelar</button>                    
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
      <script src="<?php echo base_url('assets/admin/js/script/ranges.js'); ?>"></script> 
      <!-- [ Header ] end -->
      <!-- [ Main Content ] end -->
      <?php echo view("admin/footer"); ?>