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
                                        <a class="nav-link text-active-orange ms-0 me-10 py-5 active"
                                            href="<?php echo site_url() . BACKOFFICE . "/configuracion"; ?>"><?php echo lang('Global.configuración'); ?></a>
                                    </li>
                                    <li class="nav-item mt-2">
                                        <a class="nav-link text-active-orange ms-0 me-10 py-5"
                                            href="<?php echo site_url() . BACKOFFICE . "/documentos"; ?>"><?php echo lang('Global.documentos'); ?></a>
                                    </li>
                                    <li class="nav-item mt-2">
                                        <a class="nav-link text-active-orange ms-0 me-10 py-5"
                                            href="<?php echo site_url() . BACKOFFICE . "/directos"; ?>"><?php echo lang('Global.equipo'); ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card mb-5 mb-xl-10">
                            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                                data-bs-target="#kt_account_profile_details" aria-expanded="true"
                                aria-controls="kt_account_profile_details">
                                <div class="card-title m-0">
                                    <h3 class="fw-bold m-0">Datos Bancarios</h3>
                                </div>
                            </div>
                            <div id="kt_account_settings_profile_details" class="collapse show">
                                <form name="form-bank" enctype="multipart/form-data" action="javascript:void(0);"
                                    method="post" class="form" onsubmit="save_bank();">
                                    <input type="hidden" name="id"
                                        value="<?php echo isset($obj_customer_bank) ? $obj_customer_bank->id : ""; ?>">
                                    <div class="card-body border-top p-9">
                                        <div class="row mb-6">
                                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                <span class="required">Banco</span>
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                                    title="Ingrese el banco de su preferencia"></i>
                                            </label>
                                            <div class="col-lg-8 fv-row">
                                                <select name="bank_id" id="bank_id" data-control="select2"
                                                    class="form-select form-select-solid form-select-lg fw-semibold"
                                                    required>
                                                    <option value="">Seleccionar Banco</option>
                                                    <?php foreach ($obj_bank as $value) : ?>
                                                    <?php if ($value->active == '1') : ?>
                                                    <option value="<?php echo $value->id; ?>" <?php
																if (isset($obj_customer_bank)) {
																	if ($obj_customer_bank->bank_id == $value->id) {
																		echo "selected";
																	}
																} else {
																	echo "";
																}
															?>><?php echo $value->name; ?></option>
                                                    <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-6">
                                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                <span class="required">Número de Cuenta Soles</span>
                                            </label>
                                            <div class="col-lg-8 fv-row">
                                                <input type="text" name="number" id="number"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Ingrese número de cuenta Soles"
                                                    value="<?php echo isset($obj_customer_bank) ? $obj_customer_bank->number : ""; ?>"
                                                    required />
                                            </div>
                                        </div>
                                        <div class="row mb-6">
                                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                <span class="required">Número de Cuenta Interbancario</span>
                                            </label>
                                            <div class="col-lg-8 fv-row">
                                                <input type="text" name="cci" id="cci"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Ingrese CCI Soles"
                                                    value="<?php echo isset($obj_customer_bank) ? $obj_customer_bank->cci : ""; ?>"
                                                    required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <button type="submit" id="button_bank"
                                            class="btn btn-primary"><?php echo lang('Global.guardar'); ?></button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                                data-bs-target="#kt_account_profile_details" aria-expanded="true"
                                aria-controls="kt_account_profile_details">
                                <div class="card-title m-0">
                                    <h3 class="fw-bold m-0">Datos de Facturación</h3>
                                </div>
                            </div>
                            <div id="kt_account_settings_profile_details" class="collapse show">
                                <form name="form-billing" enctype="multipart/form-data" action="javascript:void(0);"
                                    method="post" class="form" onsubmit="save_billing();">
                                    <div class="card-body border-top p-9">
                                        <div class="row mb-6">
                                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                <span class="required">RUC</span>
                                            </label>
                                            <div class="col-lg-8 fv-row">
                                                <input type="text" name="ruc" id="ruc"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                    placeholder="Ingrese número de RUC"
                                                    value="<?php echo isset($obj_customer) ? $obj_customer->ruc : ""; ?>"
                                                    minlength="11" maxlength="11" required />
                                            </div>
                                        </div>
                                        <div class="row mb-6">
                                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                <span class="required">Tipo de comprobante</span>
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                                    title="Seleccione el tipo de comprobante de su preferencia"></i>
                                            </label>
                                            <div class="col-lg-8 fv-row">
                                                <select name="type_payment" id="type_payment" data-control="select3"
                                                    class="form-select form-select-solid form-select-lg fw-semibold"
                                                    required>
                                                    <option value="">Seleccionar comprobante</option>
                                                    <option class="type_payment" value="boleta">Boleta</option>
                                                    <option class="type_payment" value="factura">Factura</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <button type="submit" id="button_billing"
                                            class="btn btn-primary"><?php echo lang('Global.guardar'); ?></button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                                data-bs-target="#kt_account_profile_details" aria-expanded="true"
                                aria-controls="kt_account_profile_details">
                                <div class="card-title m-0">
                                    <h3 class="fw-bold m-0"><?php echo lang('Global.detalle_perfil'); ?></h3>
                                </div>
                            </div>
                            <div id="kt_account_settings_profile_details" class="collapse show">
                                <form name="form-perfil" onsubmit="save_profile();" enctype="multipart/form-data"
                                    action="javascript:void(0);" id="kt_account_profile_details_form" method="post"
                                    class="form">
                                    <input name="avatar" type="hidden" value="<?php echo $obj_customer->avatar; ?>" />
                                    <div class="card-body border-top p-9">
                                        <div class="row mb-6">
                                            <label
                                                class="col-lg-4 col-form-label fw-semibold fs-6"><?php echo lang('Global.avatar'); ?></label>
                                            <div class="col-lg-8">
                                                <div class="image-input image-input-outline" data-kt-image-input="true"
                                                    style="background-image: url('<?php echo site_url() . "assets/metronic8/media/svg/avatars/blank.svg" ?>')">
                                                    <?php
													if ($obj_customer->avatar != "") { ?>
                                                    <div class="image-input-wrapper w-125px h-125px"
                                                        style="background-image: url(<?php echo site_url() . "avatar/" . $obj_customer->id . "/" . $obj_customer->avatar; ?>)">
                                                    </div>
                                                    <?php } else { ?>
                                                    <div class="image-input-wrapper w-125px h-125px"
                                                        style="background-image: url(<?php echo site_url() . "assets/metronic8/media/avatars/300-1.jpg" ?>)">
                                                    </div>
                                                    <?php } ?>
                                                    <label
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                        title="Change avatar">
                                                        <i class="bi bi-pencil-fill fs-7"></i>
                                                        <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                                        <input type="hidden" name="avatar_remove" />
                                                    </label>
                                                    <span
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                        title="Cancel avatar">
                                                        <i class="bi bi-x fs-2"></i>
                                                    </span>
                                                    <span
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                        title="Remove avatar">
                                                        <i class="bi bi-x fs-2"></i>
                                                    </span>
                                                </div>
                                                <div class="form-text">
                                                    <?php echo lang('Global.tipo_archivos_permitidos'); ?> png, jpg,
                                                    jpeg.</div>
                                            </div>
                                        </div>
                                        <div class="row mb-6">
                                            <label
                                                class="col-lg-4 col-form-label required fw-semibold fs-6"><?php echo lang('Global.nombre_completo'); ?></label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-lg-6 fv-row">
                                                        <input type="text" name="name" id="name"
                                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                            placeholder="Nombres"
                                                            value="<?php echo $obj_customer->name; ?>" />
                                                    </div>
                                                    <div class="col-lg-6 fv-row">
                                                        <input type="text" name="last_name" id="last_name"
                                                            class="form-control form-control-lg form-control-solid"
                                                            placeholder="Apellidos"
                                                            value="<?php echo $obj_customer->lastname; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-6">
                                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                <span class="required">Co distribuidor</span>
                                            </label>
                                            <div class="col-lg-8 fv-row">
                                                <input type="text" name="co_name"
                                                    class="form-control form-control-lg form-control-solid"
                                                    placeholder="Opcional"
                                                    value="<?php echo $obj_customer->co_name; ?>" />
                                            </div>
                                        </div>
                                        <div class="row mb-6">
                                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                <span class="required">Email</span>
                                            </label>
                                            <div class="col-lg-8 fv-row">
                                                <input type="text"
                                                    class="form-control form-control-lg form-control-solid"
                                                    placeholder="Email" value="<?php echo $obj_customer->email; ?>"
                                                    readonly />
                                            </div>
                                        </div>
                                        <div class="row mb-6">
                                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                <span class="required"><?php echo lang('Global.telefono'); ?></span>
                                            </label>
                                            <div class="col-lg-8 fv-row">
                                                <input type="tel" name="phone" id="phone"
                                                    class="form-control form-control-lg form-control-solid"
                                                    placeholder="Teléfono"
                                                    value="<?php echo $obj_customer->phone; ?>" />
                                            </div>
                                        </div>
                                        <div class="row mb-6">
                                            <label
                                                class="col-lg-4 col-form-label fw-semibold fs-6"><?php echo lang('Global.dni'); ?></label>
                                            <div class="col-lg-8 fv-row">
                                                <input type="text" name="dni" id="dni"
                                                    class="form-control form-control-lg form-control-solid"
                                                    placeholder="Ingrese Cedula"
                                                    value="<?php echo $obj_customer->dni; ?>" readonly />
                                            </div>
                                        </div>
                                        <div class="row mb-6">
                                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Dirección</label>
                                            <div class="col-lg-8 fv-row">
                                                <input type="text" name="address" id="address"
                                                    class="form-control form-control-lg form-control-solid"
                                                    placeholder="Ingrese Cedula"
                                                    value="<?php echo $obj_customer->address; ?>" />
                                            </div>
                                        </div>


                                        <div class="row mb-6">
                                            <label
                                                class="col-lg-4 col-form-label fw-semibold fs-6"><?php echo lang('Global.pais'); ?></label>
                                            <div class="col-lg-8 fv-row">
                                                <input type="text"
                                                    class="form-control form-control-lg form-control-solid"
                                                    value="<?php echo $obj_customer->pais; ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <button type="submit" id="profile"
                                            class="btn btn-primary"><?php echo lang('Global.guardar'); ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card mb-5 mb-xl-10">
                            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                                data-bs-target="#kt_account_signin_method">
                                <div class="card-title m-0">
                                    <h3 class="fw-bold m-0"><?php echo lang('Global.metodos_acceso'); ?></h3>
                                </div>
                            </div>
                            <div id="kt_account_settings_signin_method" class="collapse show">
                                <div class="card-body border-top p-9">
                                    <div class="d-flex flex-wrap align-items-center mb-10">
                                        <div id="kt_signin_password">
                                            <div class="fs-6 fw-bold mb-1"><?php echo lang('Global.contrasena'); ?>
                                            </div>
                                            <div class="fw-semibold text-gray-600">************</div>
                                        </div>
                                        <div id="kt_signin_password_edit" class="flex-row-fluid" style="display:none">
                                            <form name="form-pass" onsubmit="save_pass();" enctype="multipart/form-data"
                                                action="javascript:void(0);" method="post" class="form">
                                                <div class="row mb-1">
                                                    <div class="col-lg-4">
                                                        <div class="fv-row mb-0">
                                                            <label for="currentpassword"
                                                                class="form-label fs-6 fw-bold mb-3"><?php echo lang('Global.actual_contrasena'); ?></label>
                                                            <input type="password"
                                                                class="form-control form-control-lg form-control-solid"
                                                                name="currentpass" id="currentpass" required />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="fv-row mb-0">
                                                            <label for="newpassword"
                                                                class="form-label fs-6 fw-bold mb-3"><?php echo lang('Global.nueva_contrasena'); ?></label>
                                                            <input type="password"
                                                                class="form-control form-control-lg form-control-solid"
                                                                name="newpass" id="newpass" minlength="6" required />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="fv-row mb-0">
                                                            <label for="confirmpassword"
                                                                class="form-label fs-6 fw-bold mb-3"><?php echo lang('Global.confirmar_nueva_contrasena'); ?></label>
                                                            <input type="password"
                                                                class="form-control form-control-lg form-control-solid"
                                                                name="confirmpass" id="confirmpass" minlength="6"
                                                                required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-text mb-5">
                                                    <?php echo lang('Global.la_contrasenas_debe_tener'); ?></div>
                                                <div class="d-flex">
                                                    <button id="kt_password_submit" type="submit"
                                                        class="btn btn-primary me-2 px-6"><?php echo lang('Global.actualizar_contrasena'); ?></button>
                                                    <button onclick="hide_pass();" id="kt_password_cancel" type="button"
                                                        class="btn btn-color-gray-400 btn-active-light-primary px-6"><?php echo lang('Global.cancelar'); ?></button>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="kt_signin_password_button" class="ms-auto">
                                            <button onclick="show_pass();"
                                                class="btn btn-light btn-active-light-primary"><?php echo lang('Global.cambiar_contrasena'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                const data = <?php echo json_encode($obj_customer); ?>;
                const options = document.getElementsByClassName("type_payment")

                for (const option of options) {
                    if (option.value === data.tipo_comprobante) {
                        option.setAttribute("selected", "selected")
                    }
                }
                </script>
                <script src='<?php echo site_url() . 'assets/backoffice/js/profile_new.js?1234'; ?>'></script>
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
    <script src="<?php echo site_url() . "assets/metronic8/plugins/custom/datatables/datatables.bundle.js"; ?>">
    </script>
    <script src="<?php echo site_url() . "assets/metronic8/plugins/custom/prismjs/prismjs.bundle.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/js/widgets.bundle.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/js/custom/widgets.js"; ?>"></script>
</body>

</html>