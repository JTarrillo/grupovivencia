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
                                 <h5 class="m-b-10">Formulario de Productos</h5>  
                              </div>
                              <ul class="breadcrumb">
                                 <li class="breadcrumb-item"><a href="/dashboard">Panel</a></li>
                                 <li class="breadcrumb-item"><a>Productos</a></li>
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
                                             <?php 
                                             if(isset($obj_membership->img)){ ?>
                                                <a href="<?php echo site_url() . "membresias/$obj_membership->id/$obj_membership->img"; ?>" data-lightbox="<?php echo $obj_membership->name;?>" data-title="<?php echo $obj_membership->name;?>">
                                                   <i class="fa fa-eye fa-2x"></i>
                                                </a>
                                             <?php  } ?>
                                             <div class="form-group">
                                                   <label for="floatingInput">Imagen (1500 x 1125)</label>
                                                   <input class="form-control" type="file" name="img" id="img">
                                             </div>
                                          </div>
                                       <div class="form-group col-md-6">
                                             <div class="form-group">
                                                   <label>Precio de Markting S/</label>
                                                   <input class="form-control" type="text" id="public_price" name="public_price" value="<?php echo isset($obj_membership->public_price)?$obj_membership->public_price:"";?>" class="input-xlarge-fluid" placeholder="Ingrese Precio de Marketing">
                                             </div>
                                             <div class="form-group">
                                                   <label>Precio de venta S/</label>
                                                   <input class="form-control" type="text" id="price" name="price" value="<?php echo isset($obj_membership->price)?$obj_membership->price:"";?>" class="input-xlarge-fluid" placeholder="Ingrese Precio">
                                             </div>
                                                <div class="form-group">
                                                      <label>Costo Unitario S/</label>
                                                      <input class="form-control" type="text" id="unit_cost" name="unit_cost" value="<?php echo isset($obj_membership)?format_number_miles_decimal($obj_membership->unit_cost):"";?>" class="input-xlarge-fluid" placeholder="Ingrese Costo Unitario">
                                                </div>
                                                <div class="form-group">
                                                      <label>Valor Punto</label>
                                                      <input class="form-control" type="text" id="point" name="point" value="<?php echo isset($obj_membership->point)?format_number_miles($obj_membership->point):"";?>" class="input-xlarge-fluid" placeholder="Ingrese valor punto">
                                                </div>
                                                <div class="form-group">
                                                   <label for="inputState">Tipo de Venta</label>
                                                   <select class="form-control" name="sale" id="sale" required="">
                                                           <option value="">Seleccionar</option>
                                                            <option value="1" <?php if(isset($obj_membership)){
                                                               if($obj_membership->sale == '1'){ echo "selected";}
                                                            }else{echo "";} ?>>Libre</option>
                                                            <option value="2" <?php if(isset($obj_membership)){
                                                               if($obj_membership->sale == '2'){ echo "selected";}
                                                            }else{echo "";} ?>>Stock</option>  
                                                   </select>
                                             </div>
                                                <div class="form-group">
                                                   <label for="inputState">Contable</label>
                                                   <select class="form-control" name="contable" id="contable" required="" readonly>
                                                            <option value="1" selected>Si</option>
                                                   </select>
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
      <script src="<?php echo base_url('assets/admin/js/script/membership.js'); ?>"></script> 
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