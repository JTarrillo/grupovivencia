<!DOCTYPE html>

<html lang="en">

<?php echo view("backoffice_new/head"); ?>



<body data-kt-name="metronic" id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">

    <script>

        if (document.documentElement) {

            const defaultThemeMode = "system";

            const name = document.body.getAttribute("data-kt-name");

            let themeMode = localStorage.getItem("kt_" + (name !== null ? name + "_" : "") + "theme_mode_value");

            if (themeMode === null) {

                if (defaultThemeMode === "system") {

                    themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";

                } else {

                    themeMode = defaultThemeMode;

                }

            }

            document.documentElement.setAttribute("data-theme", themeMode);

        }

    </script>

    <div class="d-flex flex-column flex-root">

        <div class="page d-flex flex-row flex-column-fluid">

            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

                <?php echo view("backoffice_new/header"); ?>

                <?php echo view("backoffice_new/toolbar"); ?>

                <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">

                    <div class="content flex-row-fluid" id="kt_content">

                        <div class="card">

                            <div class="card-body p-lg-20">

                                <form name="form" method="post" enctype="multipart/form-data" action="<?php echo site_url() . "backoffice_new/kit/checkout"; ?>">

                                    <div class="d-flex flex-column flex-xl-row">

                                        <div class="flex-lg-row-fluid me-xl-10 mb-10 mb-xl-0">

                                            <div class="mt-n1">

                                                <div class="d-flex flex-stack pb-10">

                                                    <a>

                                                        <img alt="Logo" src="<?php echo site_url() . "assets/front/img/logo/logo.png"; ?>" width="50" />

                                                    </a>

                                                </div>

                                                <div class="m-0">

                                                    

                                                        <input type="hidden" name="membership_id" value="<?php echo $membership_id; ?>">

                                                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                                                        <input type="hidden" name="point" value="<?php echo $point;?>">

                                                        <div class="row mb-11">

                                                            <div class="col-sm-3 p-3">

                                                                <div class="fw-semibold fs-7 text-gray-600 mb-1">Kit de Afiliación</div>

                                                                <div class="fw-bold fs-6 text-gray-800"><?php echo $name; ?></div>

                                                            </div>

                                                            <div class="col-sm-3 p-3">

                                                                <div class="fw-semibold fs-7 text-gray-600 mb-1">Valor Punto</div>

                                                                <div class="fw-bold fs-6 text-gray-800"><?php echo format_number_miles($point);?></div>
                                                                Productos: <?php echo $qty_product;?>

                                                            </div>

                                                            <div class="col-sm-3 p-3">

                                                                <div class="fw-semibold fs-7 text-gray-600 mb-1">Teléfono de contacto</div>

                                                                <input type="text" name="phone" id="phone" min="5" value="<?php echo $obj_customer->phone; ?>" class="form-control" required autofocus />

                                                            </div>

                                                            <div class="col-sm-3 p-3">

                                                                <div class="fw-semibold fs-7 text-gray-600 mb-1">Recojo de productos</div>

                                                                <select name="store_id" class="form-control" required>

                                                                    <option value="">Seleccionar</option>

                                                                    <?php

                                                                    foreach ($obj_store as $key => $value) { ?>

                                                                        <option value="<?php echo $value->id; ?>" selected><?php echo $value->name; ?></option>

                                                                    <?php } ?>

                                                                </select>

                                                            </div>

                                                        </div>

                                                        <div class="row">

                                                            <div class="col-12">

                                                                <h4 class="card-title-kit">Seleccionar Productos</h4>

                                                                <div class="row g-10">

                                                                    <?php foreach ($obj_products as $key => $value) { ?>

                                                                        <div class="col-xl-4" style="padding-left:6px;">

                                                                            <div class="d-flex h-100 align-items-center">

                                                                                <div class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 px-5" style="height: 600px !important;">

                                                                                    <div class="text-center">

                                                                                        <img src="<?= site_url() . 'membresias/' . $value->id . '/' . $value->img; ?>" alt="<?= esc($value->name); ?>" style="width: 100px; border-radius:10px;margin-bottom: 10px;">

                                                                                    </div>

                                                                                    <div class="text-center">

                                                                                        <div class="text-center">

                                                                                            <h3 class="fw-bold text-primary"><?php echo $value->name; ?></h3>

                                                                                        </div>

                                                                                    </div>

                                                                                    <div class="mb-7 text-center">

                                                                                        <div class="fw-semibold mb-5 text-primary">Beneficios</div>

                                                                                    </div>

                                                                                    <div class="w-100 mb-10 h-25 overflow-auto">

                                                                                        <?php echo $value->description; ?>

                                                                                    </div>

                                                                                    <div>

                                                                                        <div class="row">

                                                                                            <div class="col-lg-12 fv-row flex-fill">

                                                                                                <input type="number" id="qty_<?php echo $value->id; ?>" class="form-control form-control-lg mb-3 mb-lg-0 qty text" name="quantity" value="1" title="Qty" size="4" max="<?php echo $qty_product;?>" step="1" placeholder="" inputmode="Cantidad" autocomplete="off">

                                                                                                <br />

                                                                                                <button type="button" id="<?php echo $value->id; ?>" onclick="add_cart_kit_afiliacion('<?= $value->id; ?>', '<?= $value->name; ?>', '<?= $value->price; ?>', '<?= $value->contable; ?>', '<?= $value->point; ?>')" class="btn-success btn fw-bold fs-8 fs-lg-base w-100 btn_add_cart"><i class="fa fa-shopping-cart"></i> <span id="txt_6">Agregar</span></button>

                                                                                            </div>

                                                                                        </div>

                                                                                    </div>

                                                                                </div>

                                                                            </div>

                                                                        </div>

                                                                    <?php } ?>

                                                                </div>

                                                            </div>

                                                        </div>


                                                </div>

                                            </div>

                                        </div>

                                        
                                        <style>
                                                           
                                        ul {
                                            list-style: none;
                                            padding: 0;
                                            margin: 0;
                                        }

                                        .contenedor {
                                            display: flex;
                                            justify-content: space-between;
                                        }

                                        .parte1{
                                            width: 50%;
                                            padding: 10px;
                                            border-top: 1px solid #ccc;
                                            text-align: center;
                                            align-content: center;
                                        }
                                        .parte2 {
                                            width: 30%;
                                            border-top: 1px solid #ccc;
                                            padding: 10px;
                                            text-align: center;
                                            align-content: center;
                                        }
                                        .parte3 {
                                            width: 20%;
                                            border-top: 1px solid #ccc;
                                            padding: 10px;
                                            text-align: center;
                                            align-content: center;
                                        }
                                        </style>
                                        <!-- begin site bar -->

                                        <div class="m-0">

                                            <div class="d-print-none border border-dashed border-gray-300 card-rounded h-lg-100 min-w-md-350px p-9 bg-lighten">

                                                <h6 class="mb-8 fw-bolder text-white-mn">Lista de productos seleccionados <span style="font-weight: normal;font-size: 13px;">Seleccionar: <?php echo $qty_product;?> productos</span></h6>

                                                <div class="col-12">

                                                    <h4 class="card-title-kit"></h4>

                                                    <ul class="list-products-added " style="list-style: none; padding-left: 0rem;"></ul>

                                                        <li style="list-style: none;text-align: center;">

                                                            <ul style="list-style: none;">
                                                                <li>
                                                                <?php
                                                                    foreach ($content as $key => $row) { ?>   
                                                                    <div class="contenedor">
                                                                        <div class="parte1">
                                                                            <?php echo $row->name; ?>
                                                                        </div>
                                                                        <div class="parte2">
                                                                            <input id="<?php echo $key; ?>" type="text" class="form-control form-control-lg form-control-solid" name="qty_<?php echo $row->rowId; ?>" value="<?php echo $row->qty; ?>" min="1" />
                                                                        </div>
                                                                        <div class="parte3">
                                                                            <span style="cursor:pointer;" id="edit_<?php echo $row->rowId; ?>" onclick="edit('<?php echo $row->rowId; ?>', '<?php echo $key; ?>');" class="card-text-kit text-end"><i class="fa fa-pencil" aria-hidden="true"></i></span>
                                                                            <span style="cursor:pointer;" onclick="deleted('<?php echo $row->rowId?>')" class="card-text-kit text-end"><i class="fa fa-trash" aria-hidden="true"></i></span>
                                                                        </div>
                                                                    </div>
                                                                    <?php } ?>
                                                                </li>
                                                            </ul>

                                                        </li>

                                                    <hr />

                                                    <p class="card-price-kit" style="text-align: right; font-size: 1.3rem;">Total: <?php echo $cart_total; ?></p>

                                                </div>

                                                    <div class="col-12" style="text-align: center !important;margin-top: 10px !important;">

                                                        <!-- verificar cantidad de producto es >= al requerido -->
                                                        <?php if($cart_total == $qty_product){

                                                                $style = "";
                                                                $alert = "alert-success";
                                                                $text = "Cantidad de productos correcta";
                                                            }elseif($cart_total > $qty_product){
                                                                $style = "disabled";
                                                                $alert = "alert-danger";
                                                                $text = "<strong>¡Atención!</strong> Reduzca productos o seleccione un kit mayor";
                                                            }else{
                                                                $style = "disabled";
                                                                $alert = "alert-danger";
                                                                $text = "<strong>¡Atención!</strong> Seleccione más productos";
                                                            }  ?>


                                                        <button type="submit" class="btn btn-sm btn-success btn-active-light-primary" <?php echo $style;?>><i class="fa fa-check"></i> Finalizar Compra</button>

                                                        <a href="<?php echo site_url()."backoffice_new/kit";?>" class="btn btn-sm btn-light btn-active-light-primary" style="margin-top:5px;"><i class="fa fa-chevron-left"></i> &nbsp; Regresar &nbsp;</a>
                                                        <br/><br/>
                                                        <div class="alert <?php echo $alert;?> alert-dismissible fade show" role="alert">
                                                             <?php echo $text;?>
                                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        </div>

                                                    </div>

                                            </div>

                                        </div>

                                        <!-- end site bar -->
                                                    
                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>


                <?php echo view("backoffice_new/footer"); ?>

            </div>

        </div>

    </div>

    <script src='<?php echo site_url() . 'assets/backoffice/js/plan_new.js?2024145'; ?>'></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <span class="svg-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
                <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
            </svg>
        </span>
    </div>

    <script src="<?php echo site_url() . "assets/metronic8/plugins/global/plugins.bundle.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/js/scripts.bundle.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/js/link_nav.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/plugins/custom/datatables/datatables.bundle.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/plugins/custom/prismjs/prismjs.bundle.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/js/widgets.bundle.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/js/custom/widgets.js"; ?>"></script>
</body>

</html>