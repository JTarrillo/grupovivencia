<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="ltr" lang="en" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="ltr" lang="en" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="ltr" lang="en">
<!--<![endif]-->

<!-- begin head -->
<?php echo view("head"); ?>
<!-- end head -->

<body>
   <!-- begin header -->
   <?php echo view("header"); ?>
   <!-- end header -->

   <div id="product-manufacturer" class="container cleft">
      <div class="row">
         <div id="content" class="col-xs-12">
            <div class="head-t mt60 mb60 text-center">
               <h4 class="heading">
                  <!-- Productos -->
                  <span><?php echo lang('Global.productos'); ?></span>
               </h4>
            </div>
            <div class="brand">
               <div class="row ">
                  <div class="col-md-2 col-sm-3 col-xs-4 lgrid">
                     <div class="btn-group-sm">
                        <button type="button" id="grid-view" class="btn listgridbtn" data-toggle="tooltip" title="Grid" style="display:none;"></button>
                     </div>
                  </div>
               </div>
               <?php
               if ($obj_products) { ?>
                  <div class="row cpagerow rless">
                     <?php foreach ($obj_products as $key => $value) { ?>
                        <div class="product-layout product-list col-xs-12 cless">
                           <div class="product-thumb transition">
                              <div class="zi">
                                 <div class="image">
                                    <a href="<?php echo site_url() . "productos/$value->slug"; ?>">
                                       <img src="<?php echo site_url() . "membresias/$value->id" . "/" . $value->img; ?>" alt="<?php echo $value->name; ?>" title="<?php echo $value->name; ?>" class="img-responsive center-block" />
                                    </a>
                                    <!-- Nuevo -->
                                    <h1 class="product-flag newpros"><span><?php echo lang('Global.nuevo'); ?></span></h1>
                                 </div>
                                 <div class="caption text-center">
                                    <div class="cap">
                                       <h4 class="protitle">
                                          <a href="<?php echo site_url('productos/' . $value->id); ?>"><?php echo $value->name; ?></a>
                                       </h4>
                                       <p class="catlist-des"></p>
                                       <div class="price">
                                          <span class="price-new"><?php echo format_number_moneda_soles($value->price); ?></span> <span class="price-old"><?php echo format_number_moneda_soles($value->public_price); ?></span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     <?php } ?>
                  </div>

               <?php } else { ?>
                  <div class="col-xs-12 text-center">
                     <!-- No hay registros encontrados, -->
                     <p class=""><?php echo lang('Global.no_hay_registros'); ?><a href="<?php echo site_url() . "productos"; ?>"><?php echo lang('Global.ver_todos_productos'); ?><a></p>
                     <!-- ver todos los productos -->
                  </div>
               <?php } ?>


            </div>
         </div>
      </div>
   </div>
   <!-- begin footer -->
   <?php echo view("footer"); ?>
   <!-- end footer -->
   </a>
</body>

</html>