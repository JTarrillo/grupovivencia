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

                                 <h5 class="m-b-10">Venta de productos al distribuidor</h5>

                              </div>

                              <ul class="breadcrumb">

                                 <li class="breadcrumb-item"><a href="<?php echo site_url()."dashboard/panel";?>">Panel</a></li>

                                 <li class="breadcrumb-item"><a>Nueva Venta</a></li>

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

                                    <h5>Productos</h5> 

                                    <?php 

                                    if($cart_count > 0){ ?>

                                          <a href="<?php echo site_url() . "dashboard/nueva_venta/carrito"; ?>" class="btn btn-sm btn-light btn-active-light-primary"><i class="fa fa-shopping-bag"></i> Ver Carrito</a>

                                    <?php } ?>

                                 </div>

                                 <div class="card-block">

                                    <div class="table-responsive">

                                       <div id="zero-configuration_wrapper" class="dataTables_wrapper dt-bootstrap4">

                                          <div class="row">

                                             <div class="col-sm-12">

                                                <div id="zero-configuration_wrapper" class="dataTables_wrapper dt-bootstrap4">

                                                   <div class="row">

                                                      <div class="col-sm-12">

                                                         <table id="zero-configuration" class="display table nowrap table-striped table-hover dataTable" style="width: 100%;" role="grid" aria-describedby="zero-configuration_info">

                                                            <thead>

                                                               <tr role="row">

                                                                  <th>ID</th>

                                                                  <th></th>

                                                                  <th>Nombre</th>

                                                                  <th>Precio</th>

                                                                  <th>Cantidad</th>

                                                                  <th>Acciones</th>

                                                               </tr>

                                                            </thead>

                                                            <tbody>

                                                            <?php foreach ($obj_membership as $value): ?>

                                                            <tr>

                                                               <td><?php echo $value->id_2;?></td>

                                                               <td>

                                                                  <img src="<?php echo site_url()."membresias/$value->id_2/$value->img";?>" alt="<?php echo $value->name;?>" width="50">

                                                               </td>

                                                               <td><?php echo $value->name;?></td>

                                                               <td><?php echo format_number_moneda_soles($value->price);?></td>

                                                               <td>

                                                                  <input onchange="validationMax(event, '<?php echo $value->id_2; ?>')" type="number" id="qty_<?php echo $value->id_2; ?>" class="form-control form-control-lg mb-3 mb-lg-0 qty text" name="quantity" value="1" title="Qty" size="4" max="<?php echo $value->sale=='2'?$value->balance:"";?>" step="1" placeholder inputmode="Cantidad" autocomplete="off" />

                                                               </td>

                                                               <td>

                                                                     <div class="operation">

                                                                        <div class="btn-group">

                                                                        <?php 

                                                                           // sale free	

                                                                           if($value->sale == '1'){ ?>

                                                                              <button type="button" id="a_<?php echo $value->id_2; ?>" onclick="add_cart('<?php echo $value->id_2; ?>', '<?php echo $value->name; ?>', '<?php echo $value->price; ?>', '<?php echo $value->contable; ?>', '<?php echo $value->point; ?>');" class="btn-success btn fw-bold fs-8 fs-lg-base w-100 btn_add_cart" style="border-radius: 10px;"><i class="fa fa-shopping-cart"></i> <span id="txt_<?php echo $value->id_2; ?>">Agregar al carro</span></button>	

                                                                        <?php }else{

                                                                              if($value->balance <= 0){ ?>

                                                                                 <button type="button" style="border-radius: 10px;" class="btn-success btn fw-bold fs-8 fs-lg-base w-100 btn_add_cart btn-danger" disabled=""><i class="fa fa-shopping-cart"></i> <span id="txt_7">No stock</span></button>

                                                                              <?php }else{ ?>

                                                                                 <button type="button" id="a_<?php echo $value->id_2; ?>" style="border-radius: 10px;" onclick="add_cart('<?php echo $value->id_2; ?>', '<?php echo $value->name; ?>', '<?php echo $value->price; ?>', '<?php echo $value->contable; ?>', '<?php echo $value->point; ?>');" class="br-10 btn-success btn fw-bold fs-8 fs-lg-base w-100 btn_add_cart" style="border-radius: 10px;"><i class="fa fa-shopping-cart"></i> <span id="txt_<?php echo $value->id_2; ?>">Agregar al carro</span></button>	

                                                                              <?php } 

                                                                           } ?>

																		                     <a style="display:none;border-radius: 10px;" href="<?php echo site_url() . "dashboard/nueva_venta/carrito"; ?>" id="aa_<?php echo $value->id_2; ?>" style="border-radius: 10px;" class="btn-warning btn fw-bold fs-8 fs-lg-base"><i class="fa fa-shopping-basket"></i> Ver Carrito</a>

                                                                        </div>

                                                                     </div>

                                                               </td> 

                                                            </tr>

                                                            <?php endforeach; ?>

                                                            </tbody>

                                                            <tfoot>

                                                               <tr>

                                                                  <th>ID</th>

                                                                  <th></th>

                                                                  <th>Nombre</th>

                                                                  <th>Precio</th>

                                                                  <th>Estado</th>

                                                                  <th>Acciones</th>

                                                               </tr>

                                                            </tfoot>

                                                         </table>

                                                      </div>

                                                   </div>

                                                </div>

                                             </div>

                                          </div>

                                       </div>

                                    </div>

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

      <script src='<?php echo site_url() . 'assets/backoffice/js/plan_new.js?20231255'; ?>'></script>

      <!-- [ Header ] end -->

      <!-- [ Main Content ] end -->

      <?php echo view("admin/footer"); ?>