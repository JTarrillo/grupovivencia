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
                        <div class="col-xl-12">
                            <div class="d-flex justify-content-between flex-column-fluid flex-column w-100">
                                <div class="py-2">
                                    <div class="mb-10">
                                        <?php
										if (is_null($obj_customer_bank)) { ?>
                                        <div
                                            class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                                            <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10"
                                                        fill="currentColor"></rect>
                                                    <rect x="11" y="14" width="7" height="2" rx="1"
                                                        transform="rotate(-90 11 14)" fill="currentColor"></rect>
                                                    <rect x="11" y="17" width="2" height="2" rx="1"
                                                        transform="rotate(-90 11 17)" fill="currentColor"></rect>
                                                </svg>
                                            </span>
                                            <div class="d-flex flex-stack flex-grow-1">
                                                <div class="fw-semibold">
                                                    <h4 class="text-gray-900 fw-bold">
                                                        <?php echo lang('Global.su_atencion'); ?></h4>
                                                    <div class="fs-6 text-gray-700">
                                                        <?php echo lang('Global.vincular_billetera'); ?>
                                                        <a class="fw-bold item-white"
                                                            href="<?php echo site_url() . BACKOFFICE . "/configuracion"; ?>"><?php echo lang('Global.agregar_informacion'); ?></a>.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                        <?php } ?>
                                        <div class="alert alert-success d-flex align-items-center p-5 mb-10">
                                            <span class="svg-icon svg-icon-2hx svg-icon-success me-4">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3"
                                                        d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z"
                                                        fill="currentColor"></path>
                                                    <path
                                                        d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </span>
                                            <div class="d-flex flex-column">
                                                <h4 class="mb-1 text-success">
                                                    <?php echo lang('Global.reglas_retiro'); ?></h4>
                                                <span>Las solicitudes de retiro se realizan <b>solo los días 1 y 2 de
                                                        cada mes</b>.</span>
                                                <span>El importe mínimo de retiro es de S/100.</span>
                                                <span>Si el monto es <b>mayor o igual a S/700</b>, se aplica una <b>detracción del 10%</b>.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-5 g-lg-10">
                                <div class="col-xl-6 mb-xl-10">
                                    <div class="card bgi-no-repeat h-xl-100"
                                        style="background-position: right top; background-size: 30% auto; background-image: url(<?php echo site_url() . "assets/metronic8/media/svg/shapes/abstract-4.svg"; ?>">
                                        <div class="card-body">
                                            <a href="#"
                                                class="card-title fw-bold text-muted text-hover-primary fs-4"><?php echo lang('Global.ganancia_total'); ?></a>
                                            <div class="fs-2 fw-bold counted">
                                                s/.<?php echo format_number_miles_decimal($obj_earn_total); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 mb-xl-10">
                                    <div class="card bgi-no-repeat h-xl-100"
                                        style="background-position: right top; background-size: 30% auto; background-image: url(<?php echo site_url() . "assets/metronic8/media/svg/shapes/abstract-2.svg"; ?>">
                                        <div class="card-body">
                                            <a
                                                class="card-title fw-bold text-muted text-hover-primary fs-4"><?php echo lang('Global.balance'); ?></a>
                                            <div class="fs-2 fw-bold counted">
                                                s/.<?php echo format_number_miles_decimal($obj_earn_disponible); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <div class="card card-flush h-xl-100">
                                <div class="card-header cursor-pointer">
                                    <div class="card-title m-0">
                                    </div>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_new_ticket"
                                        class="btn btn-primary align-self-center"><?php echo lang('Global.solicitar_cobro'); ?></a>
                                </div>
                                <div class="card-header pt-7">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span
                                            class="card-label fw-bold text-dark"><?php echo lang('Global.historial_pagos'); ?></span>
                                    </h3>
                                </div>
                                <div class="card-header pt-3">
                                    <div id="table_filter" class="dataTables_filter">
                                        <label>Buscar:<input type="search" id="customSearch"
                                                class="form-control form-control-sm" placeholder="">
                                        </label>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                                        <div class="table-responsive">
                                            <table id="table" class="table align-middle table-row-dashed fs-6 gy-3">
                                                <thead>
                                                    <tr
                                                        class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                        <th class="min-w-100px sorting" tabindex="0"
                                                            style="width: 130.817px;">ID</th>
                                                        <th class="min-w-100px sorting_disabled" rowspan="1" colspan="1"
                                                            style="width: 136.833px;">Código</th>
                                                        <th class="pe-3 min-w-150px sorting" tabindex="0" rowspan="1"
                                                            colspan="1" style="width: 202.233px;">
                                                            <?php echo lang('Global.fecha'); ?></th>
                                                        <th class="pe-3 min-w-100px sorting" tabindex="0" rowspan="1"
                                                            colspan="1" style="width: 136.817px;">
                                                            <?php echo lang('Global.importe'); ?></th>
                                                        <th class="pe-3 min-w-100px sorting" tabindex="0" rowspan="1"
                                                            colspan="1" style="width: 136.817px;">Comisión</th>
                                                        <th class="pe-3 min-w-100px sorting" tabindex="0" rowspan="1"
                                                            colspan="1" style="width: 136.817px;">Detracción</th>
                                                        <th class="pe-3 min-w-100px sorting" tabindex="0" rowspan="1"
                                                            colspan="1" style="width: 136.817px;">Factura</th>
                                                        <th class="pe-3 min-w-100px sorting" tabindex="0" rowspan="1"
                                                            colspan="1" style="width: 136.817px;">Voucher de Pago</th>
                                                        <th class="pe-3 min-w-50px sorting" tabindex="0" rowspan="1"
                                                            colspan="1" style="width: 85.9667px;">
                                                            <?php echo lang('Global.estado'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="fw-bold text-gray-600">
                                                    <?php foreach ($obj_pay as $value) { ?>
                                                    <tr class="odd">
                                                        <td>
                                                            <?php echo $value->id; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $value->name . " " . $value->lastname; ?>
                                                            <a class="text-dark text-hover-primary">
                                                                <br /><?php echo $value->code; ?>
                                                            </a>
                                                        </td>
                                                        <td><?php echo formato_fecha_dia_mes_anio_abrev($value->date) . " - " . formato_fecha_minutos($value->created_at); ?>
                                                        </td>
                                                        <td><?php echo format_number_moneda_soles($value->amount); ?>
                                                        </td>
                                                        <td><?php echo format_number_moneda_soles($value->discount); ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            // Detracción 10% si amount >= 700
                                                            $detraccion = 0;
                                                            if ($value->amount >= 700) {
                                                                $detraccion = round($value->amount * 0.10, 2);
                                                            }
                                                            echo format_number_moneda_soles($detraccion);
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php if (!empty($value->factura)) {
                                                                $factura_url = site_url('public/facturas/' . $value->factura);
                                                            ?>
                                                            <a href="<?php echo $factura_url; ?>" target="_blank"
                                                                class="btn btn-sm btn-light-primary">Ver factura</a>
                                                            <?php } else { ?>
                                                            <span class="text-muted">No adjunta</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if (!empty($value->voucher_pago)) {
                                                                $voucher_url = site_url('public/vouchers/' . $value->voucher_pago);
                                                            ?>
                                                            <a href="<?php echo $voucher_url; ?>" target="_blank"
                                                                class="btn btn-sm btn-light-success">Ver Voucher</a>
                                                            <?php } else { ?>
                                                            <span class="text-muted">Pendiente</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($value->active == "1") { ?>
                                                            <a
                                                                class="badge py-3 px-4 fs-7 badge-light-warning"><?php echo lang('Global.en_espera'); ?></a>
                                                            <?php } elseif ($value->active == "2") { ?>
                                                            <a
                                                                class="badge py-3 px-4 fs-7 badge-light-success"><?php echo lang('Global.procesado'); ?></a>
                                                            <?php } else { ?>
                                                            <a
                                                                class="badge py-3 px-4 fs-7 badge-light-danger"><?php echo lang('Global.rechazado'); ?></a>
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
                    </div>
                </div>
                <div class="modal fade" id="kt_modal_new_ticket" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered mw-750px">
                        <div class="modal-content rounded">
                            <div class="modal-header pb-0 border-0 justify-content-end">
                                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                    <span class="svg-icon svg-icon-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                                transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                                <form name="form-wallet" onsubmit="make_pay();" enctype="multipart/form-data"
                                    action="javascript:void(0);" method="post" class="form">
                                    <input type="hidden" name="total_disponible" id="total_disponible"
                                        value="<?php echo $obj_earn_disponible; ?>">
                                    <input type="hidden" id="bank_name"
                                        value="<?php echo is_null($obj_customer_bank) ? "" : $obj_customer_bank->name; ?>"
                                        class="form-control form-control-solid">
                                    <input type="hidden" id="number"
                                        value="<?php echo is_null($obj_customer_bank) ? "" : $obj_customer_bank->number; ?>"
                                        class="form-control form-control-solid">
                                    <input type="hidden" id="cci"
                                        value="<?php echo is_null($obj_customer_bank) ? "" : $obj_customer_bank->cci; ?>"
                                        class="form-control form-control-solid">
                                    <div class="mb-13 text-center">
                                        <h1 class="text-custom fw-semibold">
                                            <?php echo lang('Global.solicitar_cobro'); ?></h1>
                                        <div class="text-custom fw-semibold fs-5"><?php echo lang('Global.balance'); ?>
                                            <a class="fw-bold link-primary">S/<?php echo format_number_miles_decimal($obj_earn_disponible); ?></a>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span
                                                class="required text-custom pt-1"><?php echo lang('Global.importe'); ?></span>
                                        </label>
                                        <input type="number" name="amount" id="amount"
                                            class="form-control form-control-solid"
                                            placeholder="<?php echo lang('Global.ingresar_importe'); ?>" min="20"
                                            max="50000" step=".01" autofocus="autofocus" value="<?php echo $obj_earn_disponible; ?>" required>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                    </div>
                                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required text-custom pt-1">PIN</span>&nbsp; <span id="text_pin"
                                                style="cursor:pointer; color:#33C7FF;"
                                                onclick="send_pin('<?php echo $obj_customer->id; ?>','<?php echo $obj_customer->name; ?>','<?php echo $obj_customer->email; ?>');">Clic
                                                Aquí para solicitar PIN</span>
                                        </label>
                                        <input type="text" class="form-control form-control-lg form-control-solid"
                                            name="pin_retiro" id="pin" autocomplete="off" required />
                                    </div>
                                    <?php
									if (is_null($obj_customer_bank)) { ?>
                                    <div
                                        class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                                        <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10"
                                                    fill="currentColor"></rect>
                                                <rect x="11" y="14" width="7" height="2" rx="1"
                                                    transform="rotate(-90 11 14)" fill="currentColor"></rect>
                                                <rect x="11" y="17" width="2" height="2" rx="1"
                                                    transform="rotate(-90 11 17)" fill="currentColor"></rect>
                                            </svg>
                                        </span>
                                        <div class="d-flex flex-stack flex-grow-1">
                                            <div class="fw-semibold">
                                                <h4 class="text-gray-900 fw-bold">
                                                    <?php echo lang('Global.su_atencion'); ?></h4>
                                                <div class="fs-6 text-gray-700">
                                                    <?php echo lang('Global.vincular_billetera'); ?>
                                                    <a class="fw-bold"
                                                        href="<?php echo site_url() . BACKOFFICE . "/configuracion"; ?>"><?php echo lang('Global.agregar_informacion'); ?></a>.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br />
                                    <?php } else { ?>
                                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Banco</span>
                                        </label>
                                        <input type="text" name="bank_nams"
                                            value="<?php echo $obj_customer_bank->name; ?>"
                                            class="form-control form-control-solid" readonly>
                                    </div>
                                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">N° Cuenta Soles</span>
                                        </label>
                                        <input type="text" value="<?php echo $obj_customer_bank->number; ?>"
                                            class="form-control form-control-solid" readonly>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" id="submit" class="btn btn-primary">
                                            <span class="indicator-label"><?php echo lang('Global.enviar'); ?></span>
                                        </button>
                                    </div>
                                    <?php } ?>
                                    <div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                $(document).ready(function() {
                    var table = $('#table').DataTable();
                    $('#customSearch').on('keyup', function() {
                        table.search(this.value).draw();
                    });
                });
                </script>
                <script src='<?php echo site_url() . 'assets/backoffice/js/pay_new.js?2023'; ?>'></script>
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