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

                              <h5 class="m-b-10">Formulario de Periodo</h5>

                           </div>

                           <ul class="breadcrumb">

                              <li class="breadcrumb-item"><a href="<?php echo site_url() . "dashboard/panel"; ?>">Panel</a></li>

                              <li class="breadcrumb-item"><a href="<?php echo site_url() . "dashboard/periodos"; ?>">Listado de Periodos</a></li>

                              <li class="breadcrumb-item"><a>Periodos</a></li>

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

                                 <form name="form" enctype="multipart/form-data" method="post" action="javascript:void(0);" ; onsubmit="validate();">

                                    <input type="hidden" id="id" name="id" value="<?php echo isset($obj_period) ? $obj_period->id : null; ?>">

                                    <div class="form-row">

                                       <input type="hidden" id="id" name="id" value="<?php echo isset($obj_period) ? $obj_period->id : null; ?>">

                                       <div class="form-group col-md-6">
                                          <?php

                                          if (isset($obj_period)) { ?>

                                             <div class="form-group">

                                                <label>ID</label>

                                                <input class="form-control" type="text" value="<?php echo isset($obj_period) ? $obj_period->id : null; ?>" class="input-xlarge-fluid" placeholder="ID" disabled="">

                                             </div>
                                          <?php } ?>


                                          <div class="form-group">

                                             <label>Código</label>

                                             <input class="form-control" name="code" id="code" type="text" value="<?php echo isset($obj_period) ? $obj_period->code : ""; ?>" class="input-xlarge-fluid" placeholder="Ingresa código">

                                          </div>

                                       </div>

                                       <div class="form-group col-md-6">

                                          <div class="form-group">

                                             <label>Fecha de Inicio</label>

                                             <input class="form-control" name="dateBegin" id="dateBegin" type="text" value="<?php echo isset($obj_period) ? $obj_period->begin : ""; ?>" class="input-xlarge-fluid" placeholder="AAAA-mm-dd">

                                          </div>

                                          <div class="form-group">

                                             <label>Fecha de Inicio</label>

                                             <input class="form-control" name="dateEnd" id="dateEnd" type="text" value="<?php echo isset($obj_period) ? $obj_period->end : ""; ?>" class="input-xlarge-fluid" placeholder="AAA-mm-dd">

                                          </div>

                                       </div>

                                    </div>

                                    <button id="submit" type="submit" class="btn btn-primary"><i class="fa fa-cloud" aria-hidden="true"></i>Guardar</button>

                                    <button class="btn btn-danger" type="reset" onclick="cancel();"><i class="fa fa-arrow-left" aria-hidden="true"></i>Regresar</button>

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

   <script src="<?php echo base_url('assets/admin/js/script/periodo.js'); ?>"></script>

   <!-- [ Header ] end -->

   <!-- [ Main Content ] end -->

   <?php echo view("admin/footer"); ?>