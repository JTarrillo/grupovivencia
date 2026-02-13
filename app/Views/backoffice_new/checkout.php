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
                                <div class="d-flex flex-column flex-xl-row">
                                    <div class="flex-lg-row-fluid me-xl-18 mb-10 mb-xl-0">
                                        <div class="mt-n1">
                                            <div class="d-flex flex-stack pb-10">
                                                <a>
                                                    <img alt="Logo" src="<?php echo site_url() . "assets/front/img/logo/logo.png"; ?>" width="50" />
                                                </a>
                                            </div>
                                            <div class="m-0">
                                                <form name="form" method="post" enctype="multipart/form-data" action="javascript:void(0);">
                                                    <input type="hidden" name="total_disponible" id="total_disponible" value="<?php echo $total_disponible; ?>">
                                                    <input type="hidden" name="point" id="point" value="<?php echo $points; ?>">
                                                    <input type="hidden" name="store_id" id="store_id" value="<?php echo $store_id; ?>">
                                                    <input type="hidden" name="phone" id="phone" value="<?php echo $phone; ?>">
                                                    <input type="hidden" name="total" id="total" value="<?php echo $total; ?>">
                                                    <input type="hidden" name="membership_id" id="membership_id" value="<?php echo $membership_id; ?>">
                                                    <div class="row g-5 mb-11">
                                                        <div class="col-sm-6">
                                                            <div class="fw-semibold fs-7 text-gray-600 mb-1">Fecha</div>
                                                            <div class="fw-bold fs-6 text-gray-800"><?php echo date("Y-m-d"); ?></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="fw-semibold fs-7 text-gray-600 mb-1">Nombre</div>
                                                            <div class="fw-bold fs-6 text-gray-800"><?php echo $obj_customer->name . " " . $obj_customer->lastname; ?></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="fw-semibold fs-7 text-gray-600 mb-1">DNI</div>
                                                            <div class="fw-bold fs-6 text-gray-800"><?php echo $obj_customer->dni; ?></div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="fw-semibold fs-7 text-gray-600 mb-1">Email</div>
                                                            <div class="fw-bold fs-6 text-gray-800"><?php echo $obj_customer->email; ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="table-responsive border-bottom mb-9">
                                                            <table class="table mb-3">
                                                                <thead>
                                                                    <tr class="border-bottom fs-6 fw-bold text-muted">
                                                                        <th class="min-w-175px pb-2"><?php echo lang('Global.descripcion'); ?></th>
                                                                        <th class="min-w-100px pb-2">Cantidad</th>
                                                                        <th class="min-w-80px pb-2">Precio</th>
                                                                        <th class="min-w-80px pb-2"><?php echo lang('Global.importe'); ?></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    foreach ($content as $key => $row) { ?>
                                                                        <tr class="fw-bold text-gray-700 fs-5">
                                                                            <td class="d-flex align-items-center">
                                                                                <i class="fa fa-genderless text-primary fs-2 me-2"></i>
                                                                                <span class="name_">
                                                                                    <?php echo $row->name; ?>
                                                                                </span>
                                                                            </td>
                                                                            <td class="">
                                                                                <?php echo $row->qty; ?>
                                                                            </td>
                                                                            <td class=""><?php echo $row->price; ?></td>
                                                                            <td class="">
                                                                                S/.<?php echo $row->subtotal; ?>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <tr class="fw-bold text-gray-700 fs-5">
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td class="">
                                                                            Sub Total
                                                                        </td>
                                                                        <td class="">S/<?php echo format_number_miles_decimal($sub_total); ?></td>
                                                                        <td class="fs-5 text-dark"></td>
                                                                    </tr>
                                                                    <tr class="fw-bold text-gray-700 fs-5">
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td class="">
                                                                            IGV
                                                                        </td>
                                                                        <td class="">S/<?php echo format_number_miles_decimal($igv); ?></td>
                                                                        <td class="fs-5 text-dark"></td>
                                                                    </tr>
                                                                    <tr class="fw-bold text-gray-700 fs-5">
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td class="text-dark fw-bolder">
                                                                            Total
                                                                        </td>
                                                                        <td class="fs-5 text-dark fw-bolder">S/<?php echo format_number_miles_decimal($total); ?></td>
                                                                        <td class="fs-5 text-dark fw-bolder"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br />
                                                        <div class="row">
                                                        <div class="col-sm-3">
                                                            <div class="fw-semibold fs-7 text-gray-600 mb-1">Lugar de Recojo</div>
                                                            <div class="fw-bold fs-6 text-gray-800"><?php echo $obj_store->name; ?></div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="fw-semibold fs-7 text-gray-600 mb-1">Puntos</div>
                                                            <div class="fw-bold fs-6 text-gray-800"><?php echo $points; ?></div>
                                                        </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <hr />
                                                    <div class="row g-5 mb-11">
                                                        <div class="col-sm-12">
                                                            <input type="hidden" id="qty_<?php echo $membership_id; ?>" class="form-control form-control-lg mb-3 mb-lg-0 qty text" name="quantity" value="1" />
                                                            <div class="row" style="justify-content: center;">
                                                                <div class="col-sm-4">
                                                                    <button id="submit_tienda" type="button" onclick="stores_pay();" class="btn-primary btn btn-block fw-bold fs-8 fs-lg-base" style="font-family: 'proximaNova';font-size: 16px !important; width: 100%;margin-top: 17px;"><i class="fa fa-shopping-bag"></i> Pagar en Oficina</button>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <button disabled id="submit_monedero" onclick="wallet_pay();" class="btn-primary btn btn-block fw-bold fs-8 fs-lg-base" style="font-family: 'proximaNova';font-size: 16px !important; width: 100%;margin-top: 17px;"><i class="fa fa-usd" aria-hidden="true"></i> Pagar con Monedero - S/<?php echo format_number_miles_decimal($total_disponible); ?></button>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <button type="submit" id="submit_payu" class="btn-primary btn btn-block fw-bold fs-8 fs-lg-base" style="font-family: 'proximaNova';font-size: 16px !important; width: 100%;margin-top: 17px;" disabled><i class="fa fa-usd" aria-hidden="true"></i> Pagar con tarjeta</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script src='<?php echo site_url() . 'assets/backoffice/js/plan_new.js?202567'; ?>'></script>
                <?php echo view("backoffice_new/footer"); ?>
            </div>
        </div>
    </div>
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