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
               <h4 class="heading font-size3_5">
                  <!-- Contacto -->
                  <span><?php echo lang('Global.contacto'); ?></span>
               </h4>
            </div>

            <div class="row">
               <div class="col-lg-4 col-xs-12 infocnt">
                  <!-- ¿Dónde estamos? -->
                  <legend><?php echo lang('Global.donde_estamos'); ?></legend>
                  <div class="">
                     <div class="pull-left"><i class="fa fa-home"></i></div>
                     <div class="contsp">Av. Los Ruiseñores #840, Santa Anita</div>
                     <div class="pull-left"><i class="fa fa-phone"></i></div>
                     <div class="contsp">(+51) 927 318 326</div>
                     <div class="pull-left"><i class="fa fa-clock-o"></i></div>
                     <div class="contsp"> 9:00 AM To 6:00 PM</div>
                  </div>
               </div>
               <div class="col-lg-8 col-xs-12">
                  <form name="form-contact" action="javascript:void(0);" method="post" enctype="multipart/form-data" onsubmit="validate_captcha();">
                     <fieldset class="spacing-div-mn">
                        <!-- Déjenos un mensaje -->
                        <legend><?php echo lang('Global.dejenos_mensaje'); ?></legend>
                        <div class="form-group required">
                           <!-- Nombre Completo -->
                           <label class="col-sm-3 control-label" for="input-name"><?php echo lang('Global.nombre_completo'); ?></label>
                           <div class="col-sm-9">
                              <input type="text" name="name" size="40" value="" placeholder="<?php echo lang('Global.ingrese_nombre'); ?>" class="form-control" required autofocus />
                           </div>
                        </div>
                        <div class="form-group required">
                           <!-- Correo electrónico -->
                           <label class="col-sm-3 control-label" for="input-email"><?php echo lang('Global.correo'); ?></label>
                           <div class="col-sm-9">
                              <input type="text" name="email" value="" class="form-control" placeholder="<?php echo lang('Global.ingrese_email'); ?>" />
                           </div>
                        </div>

                        <div class="form-group required">
                           <!-- Asunto -->
                           <label class="col-sm-3 control-label" for="input-email"><?php echo lang('Global.asunto'); ?></label>
                           <div class="col-sm-9">
                              <input type="text" name="subject" size="40" value="" placeholder="<?php echo lang('Global.ingrese_asunto'); ?>" class="form-control" required />
                           </div>
                        </div>

                        <div class="form-group required">
                           <!-- Mensaje -->
                           <label class="col-sm-3 control-label" for="input-enquiry"><?php echo lang('Global.mensaje'); ?></label>
                           <div class="col-sm-9">
                              <textarea name="comment" rows="10" id="input-enquiry" placeholder="<?php echo lang('Global.ingrese_mensaje'); ?>" class="form-control" required></textarea>
                           </div>
                        </div>

                     </fieldset>
                     <div class="buttons">
                        <div class="pull-right">
                           <button type="submit" id="submit" class="btn btn-primary btn-custom btn-custom-public"><?php echo lang('Global.enviar_mensaje'); ?></button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>

   <script src='<?php echo site_url() . 'assets/front/js/script/contact.js?20232'; ?>'></script>

   <!-- begin footer -->
   <?php echo view("footer"); ?>
   <!-- end footer -->
</body>

</html>