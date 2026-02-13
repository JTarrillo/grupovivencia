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
                        <div class="card mb-5 mb-xl-10">
                            <div class="card-body pt-0 pb-0">
                                <ul
                                    class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                                    <li class="nav-item mt-2">
                                        <a class="nav-link text-active-orange ms-0 me-10 py-5"
                                            href="<?php echo site_url() . BACKOFFICE . "/perfil"; ?>"><?php echo lang('Global.resumen'); ?></a>
                                    </li>
                                    <li class="nav-item mt-2">
                                        <a class="nav-link text-active-orange ms-0 me-10 py-5"
                                            href="<?php echo site_url() . BACKOFFICE . "/configuracion"; ?>"><?php echo lang('Global.configuración'); ?></a>
                                    </li>
                                    <li class="nav-item mt-2">
                                        <a class="nav-link text-active-orange ms-0 me-10 py-5"
                                            href="<?php echo site_url() . BACKOFFICE . "/documentos"; ?>"><?php echo lang('Global.documentos'); ?></a>
                                    </li>
                                    <li class="nav-item mt-2">
                                        <a class="nav-link text-active-orange ms-0 me-10 py-5 active"
                                            href="<?php echo site_url() . BACKOFFICE . "/directos"; ?>"><?php echo lang('Global.equipo'); ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card mb-5 mb-xl-10">
                            <div class="card-body py-10">
                                <h2 class="mb-9"><?php echo lang('Global.programa_referido'); ?></h2>
                                <div class="row mb-10">
                                    <div class="col-xl-6 mb-15 mb-xl-0 pe-5">
                                        <h4 class="mb-0">Paso 1: Adquiere una propiedad</h4>
                                        <p class="fs-6 fw-semibold text-gray-600 py-4 m-0">Inicia tu camino hacia la
                                            prosperidad económica adquiriendo uno de nuestros packs de ingreso. Al
                                            hacerlo, podrás participar en nuestro programa de referidos y comenzar a
                                            generar beneficios monetarios diarios.</p>
                                        <h4 class="mb-0">Beneficios del programa</h4>
                                        <p class="fs-6 fw-semibold text-gray-600 py-4 m-0">- Ganancias diarias<br />
                                            - Oportunidades de crecimiento<br />
                                            - Acceso a herramientas y recursos exclusivos<br />
                                            - Comunidad de apoyo y networkng.</p>
                                    </div>
                                    <div class="col-xl-6">
                                        <h4 class="text-gray-800 mb-0"><?php echo lang('Global.enlace_referencia'); ?>
                                        </h4>
                                        <p class="fs-6 fw-semibold text-gray-600 py-4 m-0">
                                            <?php echo lang('Global.gana_10'); ?></p>
                                        <div class="d-flex">
                                            <input id="kt_referral_link_input" type="text"
                                                class="form-control form-control-solid me-3 flex-grow-1" name="search"
                                                value="<?php echo site_url() . "registro/" . $obj_customer->dni; ?>">
                                            <button id="kt_referral_program_link_copy_btn"
                                                onclick='copy("<?php echo site_url() . "registro/" . $obj_customer->dni; ?>")'
                                                class="btn btn-light btn-active-light-primary fw-bold flex-shrink-0"
                                                data-clipboard-target="#kt_referral_link_input"><?php echo lang('Global.copiar_link'); ?></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="card card-dashed flex-center min-w-175px my-3 p-6">
                                            <span class="fs-4 fw-semibold text-info pb-1 px-2">Líneas Directas</span>
                                            <span class="fs-lg-2tx fw-bold d-flex justify-content-center">
                                                <span data-kt-countup="true"
                                                    data-kt-countup-value="<?php echo $obj_total_direct; ?>"
                                                    class="counted"
                                                    data-kt-initialized="0"><?php echo $obj_total_direct;?></span></span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card card-dashed flex-center min-w-175px my-3 p-6">
                                            <span class="fs-4 fw-semibold text-info pb-1 px-2">Líneas Activas</span>
                                            <span class="fs-lg-2tx fw-bold d-flex justify-content-center">
                                                <span data-kt-countup="true"
                                                    data-kt-countup-value="<?php echo $total_active; ?>" class="counted"
                                                    data-kt-initialized="0"><?php echo $total_active; ?></span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <!--end::Nivel 1-->
                            <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                                <div class="card card-flush h-xl-100 mb-10">
                                    <div class="card-header pt-7">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bold text-dark">Referidos Directos</span>
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <table id="table" class="table align-middle table-row-dashed fs-6 gy-3">
                                            <thead>
                                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                    <th class="min-w-100px">ID</th>
                                                    <th class="min-w-100px"><?php echo lang('Global.socio'); ?></th>
                                                    <th class="min-w-100px"><?php echo lang('Global.usuario'); ?></th>
                                                    <th class="min-w-100px">Email</th>
                                                    <th class="pe-3 min-w-150px"><?php echo lang('Global.fecha'); ?>
                                                    </th>
                                                    <th class="pe-3 min-w-50px"><?php echo lang('Global.pais'); ?></th>
                                                    <th class="pe-3 min-w-50px"><?php echo lang('Global.estado'); ?>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-bold text-gray-600">
                                                <?php
												foreach ($obj_customer_n2 as $key => $value) { ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $value->customer_id2; ?>
                                                    </td>
                                                    <td>
                                                        <a
                                                            class="text-dark text-hover-primary"><?php echo $value->name . " " . $value->lastname; ?></a>
                                                    </td>
                                                    <td>
                                                        <?php echo $value->code; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $value->email; ?>
                                                    </td>
                                                    <td><?php echo formato_fecha_dia_mes_anio_abrev($value->created_at); ?>
                                                    </td>
                                                    <td>
                                                        <img src="<?php echo site_url() . 'assets/metronic8/media/flags/' . $value->pais_img; ?>"
                                                            width="20" alt="<?php echo $value->pais_name; ?>"
                                                            style="border-radius:5px;">
                                                    </td>
                                                    <td class="text-end">
                                                        <?php
															if ($value->active == 1) { ?>
                                                        <span
                                                            class="badge py-3 px-4 fs-7 badge-light-success"><?php echo lang('Global.activo'); ?></span>
                                                        <?php } else { ?>
                                                        <span
                                                            class="badge py-3 px-4 fs-7 badge-light-danger"><?php echo lang('Global.inactivo'); ?></span>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end tap-->
                </div>
                <script src='<?php echo site_url() . 'assets/backoffice/js/home_new.js'; ?>'></script>
                <?php echo view("backoffice_new/footer"); ?>
            </div>
        </div>
    </div>
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <span class="svg-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)"
                    fill="currentColor" />
                <path
                    d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                    fill="currentColor" />
            </svg>
        </span>
    </div>
    <script src="<?php echo site_url() . "assets/metronic8/plugins/global/plugins.bundle.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/js/scripts.bundle.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/js/link_nav.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/plugins/custom/datatables/datatables.bundle.js?123"; ?>">
    </script>
    <script src="<?php echo site_url() . "assets/metronic8/plugins/custom/prismjs/prismjs.bundle.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/js/widgets.bundle.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/js/custom/widgets.js"; ?>"></script>
</body>

</html>