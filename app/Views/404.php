<!doctype html>
<html class="no-js" lang="en">
<?php echo view("head"); ?>

<body>
   <!-- preloader start here -->
   <div class="preloader">
      <div class="preloader-inner">
         <div class="preloader-icon">
            <span></span>
            <span></span>
         </div>
      </div>
   </div>
   <!-- preloader ending here -->
   <!-- scrollToTop start here -->
   <a href="#" class="scrollToTop"><i class="icofont-rounded-up"></i></a>
   <!-- scrollToTop ending here -->
   <!-- begin header -->
   <?php echo view("header"); ?>
   <!-- end header -->
   <!-- ===========pageheader Section start Here========== -->
   <section class="pageheader-section" style="background-image: url(<?php echo site_url() . "assets/front/img/bg.jpg"; ?>);">
      <div class="container">
         <div class="head-t mt60 mb60 text-center">
            <h4 class="heading font-size3_5">
               <span>404</span>
               <!-- Página no encontrada -->
               <span><?php echo lang('Global.pagina_no_encontrada');?></span>
            </h4>
         </div>
      </div>
   </section>
   <!-- ===========pageheader Section Ends Here========== -->
   <!-- ============ shop Section start Here========== -->
   <div class="shop padding-top padding-bottom">
      <div class="container">
         <div class="shop__wrapper">
            <div class="product__single">
               <div class="row gx-4 gy-5">
                  <div class="col-md-2"></div>
                  <div class="col-md-8">
                     <p class="text-center"><?php echo lang('Global.enlace_desconocido');?> <a href="<?php echo site_url();?>"><?php echo lang('Global.inicio');?></a>.</p>
                  </div>
                  <div class="col-md-2"></div>
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
   <!-- ============ Related product Section Ends Here========== -->
   <!-- ================ footer Section start Here =============== -->
   <?php echo view("footer"); ?>
   <!-- ================ footer Section end Here =============== -->
   <!-- All Needed JS -->
</body>