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
                                                <a href="#">
                                                    <img alt="Logo" src="<?php echo site_url() . "assets/front/img/logo/logo.png"; ?>" width="80" />
                                                </a>
                                            </div>
                                            <div class="m-0">
                                                <div class="fw-bold fs-3 text-gray-800 mb-8">ID #<?php echo $obj_invoices->id; ?></div>
                                                <div class="row g-5 mb-11">
                                                    <div class="col-sm-4">
                                                        <div class="fw-semibold fs-7 text-gray-600 mb-1"><?php echo lang('Global.fecha_emision'); ?></div>
                                                        <div class="fw-bold fs-6 text-gray-800"><?php echo formato_fecha_dia_mes_anio_abrev($obj_invoices->date) . " " . formato_fecha_minutos($obj_invoices->date) . "hrs"; ?></div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="fw-semibold fs-7 text-gray-600 mb-1">Recojo de productos</div>
                                                        <div class="fw-bold fs-6 text-gray-800"><?php echo $obj_invoices->store_name; ?></div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="fw-semibold fs-7 text-gray-600 mb-1">Concepto</div>
                                                        <div class="fw-bold fs-6 text-gray-800"><?php echo $obj_invoices->membership??"Recompra"; ?></div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="table-responsive border-bottom mb-9">
                                                        <table class="table mb-3">
                                                            <thead>
                                                                <tr class="border-bottom fs-6 fw-bold text-muted">
                                                                    <th class="min-w-175px pb-2"><?php echo lang('Global.descripcion'); ?></th>
                                                                    <th class="min-w-80px text-end pb-2">Cantidad</th>
                                                                    <th class="min-w-80px text-end pb-2">Precio</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                foreach ($obj_product_detail as $key => $value) { ?>
                                                                    <tr class="fw-bold text-gray-700 fs-5 text-end">
                                                                        <td class="d-flex align-items-center">
                                                                            <i class="fa fa-genderless text-primary fs-2 me-2"></i>
                                                                            <span class="name_<?php echo $value->slug; ?>">
                                                                                <?php echo $value->name ?>
                                                                            </span>
                                                                        </td>
                                                                        <td class=""><?php echo $value->qty; ?></td>
                                                                        <td class=""><?php echo isset($obj_invoices->temporal_membership) &&  $obj_invoices->temporal_membership != 1 ? "-" : $value->price; ?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                                
                                                                    <tr class="fw-bold text-gray-700 fs-5 text-end">
                                                                    <td class="d-flex align-items-center"></td>
                                                                    <td class="fs-5 text-dark fw-bolder">Sub total</td>
                                                                    <td class="fs-5 text-dark fw-bolder"><?php echo format_number_moneda_soles($obj_invoices->sub_total); ?></td>
                                                                </tr>
                                                                <tr class="fw-bold text-gray-700 fs-5 text-end">
                                                                    <td class="d-flex align-items-center"></td>
                                                                    <td class="">IGV</td>
                                                                    <td class="fs-5 text-dark fw-bolder"><?php echo format_number_moneda_soles($obj_invoices->igv); ?></td>
                                                                </tr>
                                                                <tr class="fw-bold text-gray-700 fs-5 text-end">
                                                                    <td class="d-flex align-items-center"></td>
                                                                    <td class="fs-5 text-dark fw-bolder">Total</td>
                                                                    
                                                                    <td class="fs-5 text-dark fw-bolder"><?php echo format_number_moneda_soles($obj_invoices->amount); ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="fw-semibold fs-7 text-gray-600 mb-1">Puntos: <?php echo format_number_miles($obj_invoices->points);?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-0">
                                        <div class="d-print-none border border-dashed border-gray-300 card-rounded h-lg-100 min-w-md-350px p-9 bg-lighten">
                                            <div class="mb-8">
                                                <?php
                                                if ($obj_invoices->active == 2) { ?>
                                                    <span class="badge badge-light-success me-2"><?php echo lang('Global.procesado'); ?></span>
                                                <?php } else { ?>
                                                    <span class="badge badge-light-warning"><?php echo lang('Global.en_espera'); ?></span>
                                                <?php } ?>
                                            </div>
                                            <h6 class="mb-8 fw-bolder text-gray-600 text-hover-primary"><?php echo lang('Global.detalle_compra'); ?></h6>
                                            <div class="mb-6">
                                                <div class="fw-semibold text-gray-600 fs-7"><?php echo lang('Global.nombre'); ?></div>
                                                <div class="fw-bold text-gray-800 fs-6"><?php echo $obj_customer->name . " " . $obj_customer->lastname; ?></div>
                                            </div>
                                            <div class="mb-6">
                                                <div class="fw-semibold text-gray-600 fs-7"><?php echo lang('Global.dni'); ?></div>
                                                <div class="fw-bold text-gray-800 fs-6"><?php echo $obj_customer->dni; ?></div>
                                            </div>
                                            <div class="mb-6">
                                                <div class="fw-semibold text-gray-600 fs-7">Email:</div>
                                                <div class="fw-bold text-gray-800 fs-6"><?php echo $obj_customer->email; ?></div>
                                            </div>
                                            <div class="mb-6">
                                                <div class="fw-semibold text-gray-600 fs-7"><?php echo lang('Global.pais'); ?></div>
                                                <div class="fw-bold text-gray-800 fs-6">
                                                    <img src="<?php echo site_url() . 'assets/metronic8/media/flags/' . $obj_customer->img; ?>" width="20" alt="<?php echo $obj_customer->pais; ?>"  style="border-radius:5px;">
                                                </div>
                                            </div>
                                            <a href="<?php echo site_url() . BACKOFFICE . "/facturas/export_pdf/$obj_invoices->id"; ?>" class="btn btn-primary"><i class="fa fa-print" aria-hidden="true"></i></a>
                                            <a href="<?php echo site_url() . BACKOFFICE . "/facturas"; ?>" class="btn btn-light"><i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo lang('Global.regresar'); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script>
        const obj = <?php echo json_encode($obj_membership); ?>;
        const kitName = document.querySelector("span.name_membresia")
        if (kitName) {
            kitName.textContent = obj.name
        }
    </script>
    <script src="<?php echo site_url() . "assets/metronic8/plugins/global/plugins.bundle.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/js/scripts.bundle.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/js/link_nav.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/plugins/custom/datatables/datatables.bundle.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/plugins/custom/prismjs/prismjs.bundle.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/js/widgets.bundle.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/js/custom/widgets.js"; ?>"></script>
</body>

</html>