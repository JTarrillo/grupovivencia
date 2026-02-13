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
    // Mostrar el ID del usuario logueado en la consola del navegador
    console.log('ID usuario logueado:', <?php echo json_encode($obj_customer->id); ?>);
    // Mostrar el array completo de comisiones en la consola
    console.log('Array de comisiones:', <?php echo json_encode($obj_commissions); ?>);
    </script>
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php echo view("backoffice_new/header"); ?>
                <?php echo view("backoffice_new/toolbar"); ?>
                <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
                    <div class="content flex-row-fluid" id="kt_content">
                        <div class="row g-5 g-xl-10">
                            <?php
							if ($obj_customer->active == '0') { ?>
                            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                                <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10"
                                            fill="currentColor"></rect>
                                        <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)"
                                            fill="currentColor"></rect>
                                        <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)"
                                            fill="currentColor"></rect>
                                    </svg>
                                </span>
                                <div class="d-flex flex-stack flex-grow-1">
                                    <div class="fw-semibold">
                                        <h4 class="text-gray-900"><?php echo lang('Global.su_atencion'); ?></h4>
                                        <div class="fs-6 text-gray-700">Para obtener todos los beneficios primero deberá
                                            de hacer una compra.</b>
                                            <a class="fw-bold text-black-mn"
                                                href="<?php echo site_url() . BACKOFFICE . "/planes"; ?>">Comprar
                                                Ahora!</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-4 mb-md-5 mb-xl-10">
                                <!--begin balance (comisiones)-->
                                <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                                    <div class="card-header pt-5">
                                        <div class="card-title d-flex flex-column">
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="fs-4 fw-semibold text-gray-400 me-1 align-self-start">S/</span>
                                                <span
                                                    class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2"><?php echo format_number_miles_decimal($total_periodo); ?></span>
                                            </div>
                                            <span class="text-gray-400 pt-1 fw-semibold fs-6">Balance de Comisiones
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-body pt-2 pb-4 d-flex align-items-center">
                                        <div class="d-flex flex-column content-justify-center w-100">
                                            <div class="d-flex fs-6 fw-semibold align-items-center">
                                                <div class="text-gray-500 flex-grow-1 me-4">Disponible</div>
                                                <div class="fw-bolder text-gray-700 text-xxl-end">
                                                    S/<?php echo format_number_miles_decimal($total_disponible); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end balance-->
                                <!--begin proyectos/lotes inmobiliarios-->
                                <div class="card card-flush h-md-50 mb-xl-10">
                                    <div class="card-header pt-5">
                                        <div class="card-title d-flex flex-column">
                                            <div class="d-flex align-items-center">
                                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">
                                                    <?php echo isset($total_lotes_contrato) ? $total_lotes_contrato : 0; ?>
                                                </span>
                                            </div>
                                            <span class="card-label fw-bold text-dark">Proyectos en Gestión</span>
                                            <span class="text-gray-400 pt-1 fw-semibold fs-6">Lotes con contrato:
                                                <?php echo isset($total_lotes_contrato) ? $total_lotes_contrato : 0; ?></span>
                                            <!-- Botón o mensaje según contratos -->
                                            <div class="mt-3">
                                                <?php if (isset($total_lotes_contrato) && $total_lotes_contrato > 0) { ?>
                                                <a href="<?php echo site_url() . BACKOFFICE . "/contratos"; ?>"
                                                    class="btn btn-primary">
                                                    Ver Mis Contratos
                                                </a>
                                                <?php } else { ?>
                                                <div class="alert alert-warning mb-0">No tiene contratos asignados.
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end proyectos/lotes-->
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-4 mb-md-5 mb-xl-10">
                                <!--begin referido-->
                                <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                                    <div class="card-header pt-5">
                                        <div class="card-title d-flex flex-column">
                                            <div class="d-flex align-items-center">
                                                <div class="col-xl-12">
                                                    <h4 class="text-gray-800 mb-0">
                                                        <?php echo lang('Global.link_referidos'); ?></h4>
                                                    <p class="fs-6 fw-semibold text-gray-600 py-4 m-0">
                                                        <?php echo lang('Global.gana_comisiones'); ?></p>
                                                    <div class="d-grid gap-2">
                                                        <input id="kt_referral_link_input" type="text"
                                                            class="form-control form-control-solid me-3 flex-grow-1"
                                                            value="<?php echo site_url() . "registro/" . (!empty($obj_customer->dni) ? $obj_customer->dni : ''); ?>">
                                                    </div>
                                                    <div class="d-grid gap-2 py-5">
                                                        <button id="kt_referral_program_link_copy_btn"
                                                            class="btn btn-block fw-bold flex-shrink-0"
                                                            onclick='copy("<?php echo site_url() . "registro/" . (!empty($obj_customer->dni) ? $obj_customer->dni : ''); ?>")'
                                                            style="background-color: var(--kt-header-menu-link-active-bg-color);color:white">Copiar
                                                            Enlace</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end referido-->
                                <!--begin equipo -->
                                <div class="card card-flush h-lg-50">
                                    <div class="card-header pt-5">
                                        <h3 class="card-title text-gray-800"><?php echo lang('Global.red'); ?></h3>
                                        <div class="card-toolbar d-none">
                                            <div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left"
                                                class="btn btn-sm btn-light d-flex align-items-center px-4"
                                                data-kt-initialized="1">
                                                <span class="svg-icon svg-icon-1 ms-2 me-0">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3"
                                                            d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z"
                                                            fill="currentColor"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-5">
                                        <div class="d-flex flex-stack">
                                            <div class="text-gray-700 fw-semibold fs-6 me-2">
                                                <?php echo lang('Global.red'); ?></div>
                                            <div class="d-flex align-items-senter">
                                                <span class="svg-icon svg-icon-2 svg-icon-success me-2">
                                                    <svg class="text-orange-mn" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.5" x="16.9497" y="8.46448" width="13"
                                                            height="2" rx="1" transform="rotate(135 16.9497 8.46448)"
                                                            fill="currentColor"></rect>
                                                        <path
                                                            d="M14.8284 9.97157L14.8284 15.8891C14.8284 16.4749 15.3033 16.9497 15.8891 16.9497C16.4749 16.9497 16.9497 16.4749 16.9497 15.8891L16.9497 8.05025C16.9497 7.49797 16.502 7.05025 15.9497 7.05025L8.11091 7.05025C7.52512 7.05025 7.05025 7.52513 7.05025 8.11091C7.05025 8.6967 7.52512 9.17157 8.11091 9.17157L14.0284 9.17157C14.4703 9.17157 14.8284 9.52975 14.8284 9.97157Z"
                                                            fill="currentColor"></path>
                                                    </svg>
                                                </span>
                                                <span
                                                    class="text-gray-900 fw-bolder fs-6 text-white-mn"><?php echo format_number_miles($obj_customer->total_team); ?></span>
                                            </div>
                                        </div>
                                        <div class="separator separator-dashed my-3"></div>
                                        <div class="d-flex flex-stack">
                                            <div class="text-gray-700 fw-semibold fs-6 me-2">
                                                <?php echo lang('Global.activos'); ?></div>
                                            <div class="d-flex align-items-senter">
                                                <span class="svg-icon svg-icon-2 svg-icon-success me-2">
                                                    <svg class="text-orange-mn" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.5" x="16.9497" y="8.46448" width="13"
                                                            height="2" rx="1" transform="rotate(135 16.9497 8.46448)"
                                                            fill="currentColor"></rect>
                                                        <path
                                                            d="M14.8284 9.97157L14.8284 15.8891C14.8284 16.4749 15.3033 16.9497 15.8891 16.9497C16.4749 16.9497 16.9497 16.4749 16.9497 15.8891L16.9497 8.05025C16.9497 7.49797 16.502 7.05025 15.9497 7.05025L8.11091 7.05025C7.52512 7.05025 7.05025 7.52513 7.05025 8.11091C7.05025 8.6967 7.52512 9.17157 8.11091 9.17157L14.0284 9.17157C14.4703 9.17157 14.8284 9.52975 14.8284 9.97157Z"
                                                            fill="currentColor"></path>
                                                    </svg>
                                                </span>
                                                <span
                                                    class="text-gray-900 fw-bolder fs-6 text-white-mn"><?php echo format_number_miles($total_team_active); ?></span>
                                            </div>
                                        </div>
                                        <div class="separator separator-dashed my-3"></div>
                                        <div class="d-flex flex-stack">
                                            <div class="text-gray-700 fw-semibold fs-6">
                                                <?php echo lang('Global.directos'); ?></div>
                                            <div class="d-flex align-items-senter">
                                                <span class="svg-icon svg-icon-2 svg-icon-success me-2">
                                                    <svg class="text-orange-mn" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.5" x="16.9497" y="8.46448" width="13"
                                                            height="2" rx="1" transform="rotate(135 16.9497 8.46448)"
                                                            fill="currentColor"></rect>
                                                        <path
                                                            d="M14.8284 9.97157L14.8284 15.8891C14.8284 16.4749 15.3033 16.9497 15.8891 16.9497C16.4749 16.9497 16.9497 16.4749 16.9497 15.8891L16.9497 8.05025C16.9497 7.49797 16.502 7.05025 15.9497 7.05025L8.11091 7.05025C7.52512 7.05025 7.05025 7.52513 7.05025 8.11091C7.05025 8.6967 7.52512 9.17157 8.11091 9.17157L14.0284 9.17157C14.4703 9.17157 14.8284 9.52975 14.8284 9.97157Z"
                                                            fill="currentColor"></path>
                                                    </svg>
                                                </span>
                                                <span
                                                    class="text-gray-900 fw-bolder fs-6 text-white-mn"><?php echo format_number_miles($obj_customer->total_referred); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end equipo -->
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-4 mb-md-5 mb-xl-10">
                                <!--begin ventas/reservas inmobiliarias-->
                                <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                                    <div class="card-header pt-5">
                                        <div class="card-title d-flex flex-column">
                                            <div class="d-flex align-items-center">
                                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">
                                                    <?php echo isset($total_ventas) ? $total_ventas : 0; ?>
                                                </span>
                                            </div>
                                            <span class="card-label fw-bold text-dark">Ventas Realizadas</span>
                                            <span class="text-gray-400 pt-1 fw-semibold fs-6">Reservas Activas:
                                                <?php echo isset($total_reservas) ? $total_reservas : 0; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <!--end ventas/reservas-->
                            </div>
                            <!--begin historial de operaciones inmobiliarias -->
                            <div class="col-xl-12">
                                <div class="card card-flush h-xl-100">
                                    <div class="card-header pt-7">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bold text-dark">Historial de Operaciones
                                                Inmobiliarias</span>
                                            <span
                                                class="text-gray-400 mt-1 fw-semibold fs-6"><?php echo formato_fecha_dia_mes_anio_abrev($dataPeriod->begin) . " - " . formato_fecha_dia_mes_anio_abrev($dataPeriod->end); ?></span>
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 mb-4">
                                                <div id="table_filter" class="dataTables_filter">
                                                    <label>Buscar:<input type="search" id="customSearch"
                                                            class="form-control form-control-sm" placeholder="">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <table id="table" class="table align-middle table-row-dashed fs-6 gy-3">
                                            <thead>
                                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                    <th class="min-w-80px">ID</th>
                                                    <th class="min-w-100px">Tipo</th>
                                                    <th class="pe-3 min-w-150px">Fecha</th>
                                                    <th class="pe-3 min-w-100px">Importe</th>
                                                    <th class="pe-3 min-w-100px">Venta ID</th>
                                                    <th class="pe-3 min-w-50px">Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-bold text-gray-600">
                                                <?php
                                                foreach ($obj_commissions as $key => $value) {
                                                    ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $value->id; ?>
                                                    </td>
                                                    <td>
                                                        <a class="text-dark text-hover-primary">
                                                            <?php
                                                            if (isset($value->tipo_comision)) {
                                                                echo ($value->tipo_comision == 'venta_base') ? 'Venta de lote' : str_to_first_capital($value->tipo_comision);
                                                            } else {
                                                                echo '-';
                                                            }
                                                            ?>
                                                        </a>
                                                    </td>
                                                    <td class="">
                                                        <?php
                                                        echo isset($value->fecha_generada) ? formato_fecha_dia_mes_anio_abrev($value->fecha_generada) . " - " . formato_fecha_minutos($value->fecha_generada) : "-";
                                                        ?>
                                                    </td>
                                                    <td class="">
                                                        S/<?php echo format_number_miles_decimal($value->monto); ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        echo isset($value->venta_id) ? $value->venta_id : "-";
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if (isset($value->estado)) {
                                                            if ($value->estado == 'aprobada' || $value->estado == 'pagada') {
                                                                echo '<span class="badge py-3 px-4 fs-7 badge-light-success">Ingreso</span>';
                                                            } elseif ($value->estado == 'pendiente') {
                                                                echo '<span class="badge py-3 px-4 fs-7 badge-light-warning">Pendiente</span>';
                                                            } else {
                                                                echo '<span class="badge py-3 px-4 fs-7 badge-light-danger">Salida</span>';
                                                            }
                                                        } else {
                                                            echo "-";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end historial -->
                    </div>
                </div>
                <script>
                // Console log para verificar si llegan las comisiones
                console.log('Total comisiones recibidas:',
                    <?php echo isset($obj_commissions) ? count($obj_commissions) : 0; ?>);
                $(document).ready(function() {
                    var table = $('#table').DataTable();
                    $('#customSearch').on('keyup', function() {
                        table.search(this.value).draw();
                    });
                });
                </script>
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
    <script src="<?php echo site_url() . "assets/metronic8/plugins/custom/datatables/datatables.bundle.js?123"; ?>">
    </script>
    <script src="<?php echo site_url() . "assets/metronic8/plugins/custom/prismjs/prismjs.bundle.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/js/widgets.bundle.js"; ?>"></script>
    <script src="<?php echo site_url() . "assets/metronic8/js/custom/widgets.js"; ?>"></script>
</body>

</html>