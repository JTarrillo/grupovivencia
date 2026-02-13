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

                                 <h5 class="m-b-10">Formulario de Puntos</h5> 

                              </div>

                              <ul class="breadcrumb">

                                 <li class="breadcrumb-item"><a href="<?php echo site_url()."dashboard/panel";?>">Panel</a></li>

                                 <li class="breadcrumb-item"><a href="<?php echo site_url()."dashboard/puntos";?>">Listado de Pagos</a></li>

                                 <li class="breadcrumb-item"><a>Puntos</a></li>

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

                                    <form name="form-points" enctype="multipart/form-data" method="post" action="javascript:void(0);"; onsubmit="validate();">

                                       <div class="form-row">

                                          <div class="form-group col-md-12">

                                                <div class="form-group">

                                                      <label>ID</label>

                                                      <input class="form-control" type="text" value="<?php echo isset($pointsData)?$pointsData->id:"";?>" class="input-xlarge-fluid" placeholder="ID" disabled="">

                                                      <input type="hidden" id="id" name="id" value="<?php echo isset($pointsData)?$pointsData->id:"";?>">

                                                </div>

                                          </div>

                                       <div class="form-group col-md-6">

                                             <div class="form-group">

                                                   <label>Código</label>

                                                   <input class="form-control" type="text" id="username" name="username" value="<?php echo isset($pointsData)?$pointsData->code:"";?>" class="input-xlarge-fluid" disabled="">

                                             </div>

                                             <div class="form-group">

                                                   <label>Nombre</label>

                                                   <input class="form-control" stype="text" id="name" name="name" value="<?php echo isset($pointsData)?$pointsData->name." ".$pointsData->lastname:"";?>" class="input-xlarge-fluid" placeholder="Nombre" disabled="">

                                             </div>

                                          </div>

                                          <div class="form-group col-md-6">

                                             <div class="form-group">

                                                      <label>Puntos</label>

                                                      <input class="form-control" stype="text" id="points" name="points" value="<?php echo isset($pointsData)?$pointsData->points:0;?>" class="input-xlarge-fluid">

                                             </div>

                                             <div class="form-group">

                                                   <label>Fecha</label>

                                                   <input class="form-control" type="text" id="date" name="date" value="<?php echo isset($pointsData)?formato_fecha_db_time($pointsData->date):"";?>" class="input-xlarge-fluid" disabled="">

                                             </div>

                                          </div>

                                       </div>

                                       <button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-cloud" aria-hidden="true"></i>Guardar</button>

                                       <button class="btn waves-effect waves-light btn-light" type="reset" onclick="cancel_points();"><i class="fa fa-arrow-left" aria-hidden="true"></i>Regresar</button>                    
                                       

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

      <script src="<?php echo base_url('assets/admin/js/script/point_list.js'); ?>"></script> 

      <?php echo view("admin/footer"); ?>