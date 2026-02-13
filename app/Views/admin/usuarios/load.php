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
                                 <h5 class="m-b-10">Formulario de Usuarios</h5> 
                              </div>
                              <ul class="breadcrumb">
                                 <li class="breadcrumb-item"><a href="<?php echo site_url()."dashboard/panel";?>">Panel</a></li> 
                                 <li class="breadcrumb-item"><a href="<?php echo site_url().'dashboard/usuarios';?>">Listado de Usuarios</a></li>
                                 <li class="breadcrumb-item"><a>Usuarios</a></li>
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
                                 <form name="form-user" id="form-user" enctype="multipart/form-data" method="post" action="javascript:void(0);" onsubmit="validate();">
                                          <div class="form-row">
                                          <?php 
                                          if(isset($obj_users)){ ?>
                                                <div class="form-group col-md-12">
                                                   <div class="form-group">
                                                         <label>ID</label>
                                                         <input class="form-control" type="text" value="<?php echo isset($obj_users->id)?$obj_users->id:"";?>" placeholder="ID" disabled="">
                                                   </div>
                                                </div>
                                          <?php } ?>
                                          <input type="hidden" name="user_id" id="user_id" value="<?php echo isset($obj_users)?$obj_users->id:"";?>">
                                          <div class="form-group col-md-6">
                                                <div class="form-group">
                                                      <label>E-mail</label>
                                                      <input class="form-control" type="email" id="email" name="email" value="<?php echo isset($obj_users->email)?$obj_users->email:"";?>" placeholder="E-mail" required>
                                                </div>
                                                <div class="form-group">
                                                      <label>Nombres</label>
                                                      <input class="form-control" type="text" id="name" name="name" value="<?php echo isset($obj_users->name)?$obj_users->name:"";?>" placeholder="Nombres" required>
                                                </div>
                                                <div class="form-group">
                                                      <label>Apellidos</label>
                                                      <input class="form-control" type="text" id="lastname" name="lastname" value="<?php echo isset($obj_users->lastname)?$obj_users->lastname:"";?>" placeholder="Apellidos" required>
                                                </div>
                                             </div>
                                             <div class="form-group col-md-6">
                                                <div class="form-group">
                                                   <label>Contraseña</label>
                                                   <div class="input-group">
                                                      <div class="input-group-prepend">
                                                            <span class="input-group-text" style="cursor: pointer;" onclick="show_pass();"><i class="fa fa-eye"></i></span>
                                                      </div>
                                                      <input class="form-control" type="password" id="password" name="password" value="" class="input-xlarge-fluid" placeholder="Password" minlength="8">
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                      <label>Priveligios</label>
                                                         <select class="form-control" name="privilage" id="privilage">
                                                            <option value="1" <?php if(isset($obj_users->privilage) == 1){echo "selected";}else{echo "";}?>>Control Básico</option>
                                                            <option value="2" <?php if(isset($obj_users->privilage) == 2){echo "selected";}else{echo "";}?>>Control Medio</option>
                                                            <option value="3" <?php if(isset($obj_users->privilage) == 3){echo "selected";}else{echo "";}?>>Control Total</option>
                                                         </select>
                                                </div>
                                                <div class="form-group">
                                                   <label for="inputState">Estado</label>
                                                      <select name="active" id="active" class="form-control">
                                                      <option value="">[ Seleccionar ]</option>
                                                         <option value="1" <?php if(isset($obj_users)){
                                                            if($obj_users->active == 1){ echo "selected";}
                                                         }else{echo "";} ?>>Activo</option>
                                                         <option value="0" <?php if(isset($obj_users)){
                                                            if($obj_users->active == 0){ echo "selected";}
                                                         }else{echo "";} ?>>Inactivo</option>
                                                   </select>
                                             </div>
                                          </div>
                                          </div>
                                          <button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-cloud" aria-hidden="true"></i>Guardar</button>
                                          <button class="btn btn-danger" type="reset" onclick="cancelar_users();"><i class="fa fa-arrow-left" aria-hidden="true"></i>Cancelar</button>                    
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
      <script src="<?php echo base_url('assets/admin/js/script/users.js'); ?>"></script> 
      <script>
         function show_pass() {
            var tipo = document.getElementById("password");
            if (tipo.type == "password") {
                  tipo.type = "text";
            } else {
                  tipo.type = "password";
            }
         }
      </script>
      <!-- [ Header ] end -->
      <!-- [ Main Content ] end -->
      <?php echo view("admin/footer"); ?>