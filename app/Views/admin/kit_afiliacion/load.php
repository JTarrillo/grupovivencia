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
                                 <h5 class="m-b-10">Formulario de Kit de Afiliación</h5>  
                              </div>
                              <ul class="breadcrumb">
                                 <li class="breadcrumb-item"><a href="/dashboard">Panel</a></li>
                                 <li class="breadcrumb-item"><a>Kit de Afiliación</a></li>
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
                                 <form name="form-kit" enctype="multipart/form-data" method="post" action="javascript:void(0);" onsubmit="validate_kit();">
                                       <div class="form-row">
                                          <div class="form-group col-md-12">
                                             <?php 
                                             if(isset($obj_membership)){ ?>
                                                <div class="form-group">
                                                      <label>ID</label>
                                                      <input class="form-control" type="text" value="<?php echo isset($obj_membership->id)?$obj_membership->id:"";?>" class="input-xlarge-fluid" placeholder="ID" disabled="">
                                                </div>
                                             <?php } ?>  
                                             <input type="hidden" id="membership_id" name="membership_id" value="<?php echo isset($obj_membership->id)?$obj_membership->id:"";?>">
                                             <input type="hidden" id="img_temp" name="img_temp" value="<?php echo isset($obj_membership)?$obj_membership->img:"";?>">
                                          </div>
                                          <div class="form-group col-md-6">
                                             <div class="form-group">
                                                   <label>Nombre</label>
                                                   <input class="form-control" type="text" id="name" name="name" value="<?php echo isset($obj_membership->name)?$obj_membership->name:"";?>" class="input-xlarge-fluid" placeholder="Nombre">
                                             </div>
                                             <div class="form-group">
                                                   <label>Descripción</label>
                                                   <textarea class="form-control" name="description"  id="mytextarea" placeholder="Descripción" style="height: 300px;width: 100% !important" placeholder="Descripcion"><?php echo isset($obj_membership->description)?$obj_membership->description:"";?></textarea>
                                             </div>
                                             
                                          </div>
                                          <div class="form-group col-md-6">
                                             <?php 
                                             if(isset($obj_membership->img)){ ?>
                                                <a href="<?php echo site_url() . "membresias/$obj_membership->id/$obj_membership->img"; ?>" data-lightbox="<?php echo $obj_membership->name;?>" data-title="<?php echo $obj_membership->name;?>">
                                                   <i class="fa fa-eye fa-2x"></i>
                                                </a>
                                             <?php  } ?>
                                             <div class="form-group">
                                                   <label for="floatingInput">Imagen Slide (500 x 549)</label>
                                                   <input class="form-control" type="file" name="img" id="img">
                                             </div>
                                             <div class="form-group">
                                                   <label>Precio de venta s/.</label>
                                                   <input class="form-control" type="text" id="price" name="price" value="<?php echo isset($obj_membership->price)?$obj_membership->price:"";?>" class="input-xlarge-fluid" placeholder="Ingrese Precio">
                                             </div>
                                             <div class="form-group">
                                                   <label>Valor Punto</label>
                                                   <input class="form-control" type="text" id="point" name="point" value="<?php echo isset($obj_membership->point)?$obj_membership->point:"";?>" class="input-xlarge-fluid" placeholder="Valor Punto">
                                             </div>
                                             <div class="form-group">
                                                   <label for="inputState">Estado</label>
                                                   <select class="form-control" name="active" id="active" required="">
                                                            <option value="">[ Seleccionar ]</option>
                                                            <option value="0" <?php if(isset($obj_membership)){
                                                               if($obj_membership->active == '0'){ echo "selected";}
                                                            }else{echo "";} ?>>Inactivo</option>
                                                            <option value="1" <?php if(isset($obj_membership)){
                                                               if($obj_membership->active == '1'){ echo "selected";}
                                                            }else{echo "";} ?>>Activo</option>
                                                   </select>
                                             </div>
                                          </div>
                                       </div>
                                       <button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-cloud" aria-hidden="true"></i>Guardar</button>
                                       <button class="btn btn-danger" type="reset" onclick="cancel_kit();"><i class="fa fa-arrow-left" aria-hidden="true"></i>Cancelar</button>                    
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
      <script src="<?php echo base_url('assets/admin/js/script/kit_afiliacion.js'); ?>"></script> 
      <script>
      tinymce.init({
         selector: 'textarea#mytextarea',
         height: 300,
         menubar: false,
         plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
         ],
         toolbar: 'undo redo | formatselect | ' +
         'bold italic backcolor | alignleft aligncenter ' +
         'alignright alignjustify | bullist numlist outdent indent | ' +
         'removeformat | help',
         content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
         });

   </script>
      <!-- [ Header ] end -->
      <!-- [ Main Content ] end -->
      <?php echo view("admin/footer"); ?>