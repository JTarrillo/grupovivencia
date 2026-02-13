<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="ltr" lang="en" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="ltr" lang="en" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="ltr" lang="en">
<!--<![endif]-->


<!-- begin head -->
<?php echo view("head"); ?>
<!-- begin head -->

<body>
   <!-- begin head -->
   <?php echo view("header"); ?>
   <!-- begin head -->

   <div id="information-information" class="container">

      <div class="row">
         <div id="content" class="col-sm-12">
            <div class="head-t mt60 mb60 text-center">
               <h4 class="heading">
                  <!-- NOSOTROS -->
                  <span><?php echo lang('Global.nosotros');?></span>
               </h4>
            </div>
            <div class="row">
               <div class="">
                  <div class="info">
                     <div class="row">
                        <div class="top">
                           <div class="card">
                              <!-- ¿PORQUE MUNDO NETWORK? -->
                              <h3><?php echo lang('Global.porque_mn');?></h3>
                              <div class="">
                                 <!-- Porque hoy en día somos la mejor oportunidad -->
                                 <p><?php echo lang('Global.somos_mejor_oportunidad');?></p>
                              </div>
                           </div>
                           <div class="card">
                              <!-- HISTORIA -->
                              <h3><?php echo lang('Global.historia');?></h3>
                              <div class="">
                                 <!-- Somos una familia -->
                                 <p><?php echo lang('Global.somos_familia');?></p>
                              </div>
                           </div>

                           <div class="card">
                              <!-- ¿QUIENES SOMOS? -->
                              <h3><?php echo lang('Global.quienes_somos');?></h3>
                              <div class="">
                                 <!-- <img src="image/catalog/icon/clipboard-paste-button.png" style="width: 35px; height: 35px; float: left;"> -->
                              </div>
                              <div class="">
                                 <!-- Somos una compañía peruana -->
                                 <p><?php echo lang('Global.compania_peruana');?></p>
                              </div>
                           </div>
                        </div>
                        <div class="center">
                           <div class="center-left">
                              <div class="card">
                                 <!-- MISION -->
                                 <h3><?php echo lang('Global.mision');?></h3>
                                 <div class="">
                                    <!-- Formar empresarios exitosos -->
                                    <p><?php echo lang('Global.formar_empresarios_exitosos');?></p>
                                 </div>
                              </div>
                              <div class="card">
                                 <!-- VISION -->
                                 <h3><?php echo lang('Global.vision');?></h3>
                                 <div class="">
                                    <!-- Contribuir a más de 1 millón de familias -->
                                    <p><?php echo lang('Global.contribuir_1millón');?></p>
                                 </div>
                              </div>
                              <div class="card">
                                 <!-- VALORES -->
                                 <h3><?php echo lang('Global.valores');?></h3>
                                 <div class="">
                                    <!-- Trabajamos con valores íntegros -->
                                    <p><?php echo lang('Global.valores_integros');?></p>
                                 </div>
                              </div>
                           </div>
                           <div class="center-abs">
                              <img alt="Logo" src="<?php echo site_url() . "assets/front/img/logo/mn_negro01.png"; ?>" alt="logo" />
                           </div>
                           <div class="center-right">
                              <div class="card">
                                 <!-- ¿HACIA DONDE VAMOS? -->
                                 <h3><?php echo lang('Global.donde_vamos');?></h3>
                                 <div class="">
                                    <!-- Rumbo a la libertad y el éxito. -->
                                    <p><?php echo lang('Global.rumbo_libertad');?></p>
                                 </div>
                              </div>
                              <div class="card">
                                 <h3><?php echo lang('Global.clientes_prefieren');?></h3>
                                 <div class="">
                                    <p><?php echo lang('Global.alta_efectividad_producto');?></p>
                                 </div>
                              </div>
                              <div class="card">
                                 <!-- TECNOLOGIA -->
                                 <h3><?php echo lang('Global.tecnologia');?></h3>
                                 <div class="">
                                    <!-- Atomización, es la extracción -->
                                    <p><?php echo lang('Global.atomizacion');?></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="bottom">
                           <div class="card">
                              <!-- INGREDIENTES -->
                              <h3><?php echo lang('Global.ingredientes');?></h3>
                              <div class="">
                                 <!-- Ganoderma, moringa -->
                                 <p><?php echo lang('Global.ganoderma_moringa');?></p>
                              </div>
                           </div>

                           <div class="card">
                              <!-- ¿PORQUE LOS NETWORKERS PREFIEREN -->
                              <h3><?php echo lang('Global.porque_networkers');?></h3>
                              <div class="">
                                 <!-- Por nuestro plan de recompensa -->
                                 <p><?php echo lang('Global.plan_recompensaporque_networkers');?></p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <!-- begin footer -->
      <?php echo view("footer"); ?>
      <!-- end footer -->
</body>

</html>