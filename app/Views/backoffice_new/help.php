<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic - Bootstrap 5 HTML, VueJS, React, Angular, Asp.Net Core, Blazor, Django, Flask & Laravel Admin Dashboard Theme
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
	<!--begin::Head-->
   <?php echo view("backoffice_new/head"); ?>
	<!--end::Head-->
	<!--begin::Body-->
	<body data-kt-name="metronic" id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
		<!--begin::Theme mode setup on page load-->
		<script>if ( document.documentElement ) { const defaultThemeMode = "system"; const name = document.body.getAttribute("data-kt-name"); let themeMode = localStorage.getItem("kt_" + ( name !== null ? name + "_" : "" ) + "theme_mode_value"); if ( themeMode === null ) { if ( defaultThemeMode === "system" ) { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } else { themeMode = defaultThemeMode; } } document.documentElement.setAttribute("data-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
               <?php echo view("backoffice_new/header"); ?>
					<!--end::Header-->
					<!--begin::Toolbar-->
					<div class="toolbar py-5" id="kt_toolbar">
						<!--begin::Container-->
						<div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
							<!--begin::Page title-->
							<div class="page-title d-flex flex-column me-3">
								<!--begin::Title-->
								<h1 class="d-flex text-dark fw-bold my-1 fs-3"><?php echo $title;?></h1>
								<!--end::Title-->
							</div>
							<!--end::Page title-->
							<!--begin::Actions-->
							<div class="d-flex align-items-center py-1">
								<!--begin::Daterange-->
								<a href="#" class="btn btn-flex bg-body h-40px me-3 px-5" id="kt_dashboard_daterangepicker" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-trigger="hover" title="Select dashboard daterange">
									<span class="me-4">
										<span class="text-muted fw-semibold me-1">Hoy</span>
										<span class="text-primary fw-bold"><?php echo formato_fecha_dia_mes_v2(date("Y-m-d"));?></span>
									</span>
								</a>
								<!--end::Daterange-->
								<!--begin::Menu wrapper-->
								<div class="m-0">
									<!--begin1::Toggle-->
									<a href="#" class="btn btn-icon btn-primary w-40px h-40px" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
										<!--begin::Svg Icon | path: icons/duotune/coding/cod001.svg-->
										<span class="svg-icon svg-icon-1">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path opacity="0.3" d="M22.1 11.5V12.6C22.1 13.2 21.7 13.6 21.2 13.7L19.9 13.9C19.7 14.7 19.4 15.5 18.9 16.2L19.7 17.2999C20 17.6999 20 18.3999 19.6 18.7999L18.8 19.6C18.4 20 17.8 20 17.3 19.7L16.2 18.9C15.5 19.3 14.7 19.7 13.9 19.9L13.7 21.2C13.6 21.7 13.1 22.1 12.6 22.1H11.5C10.9 22.1 10.5 21.7 10.4 21.2L10.2 19.9C9.4 19.7 8.6 19.4 7.9 18.9L6.8 19.7C6.4 20 5.7 20 5.3 19.6L4.5 18.7999C4.1 18.3999 4.1 17.7999 4.4 17.2999L5.2 16.2C4.8 15.5 4.4 14.7 4.2 13.9L2.9 13.7C2.4 13.6 2 13.1 2 12.6V11.5C2 10.9 2.4 10.5 2.9 10.4L4.2 10.2C4.4 9.39995 4.7 8.60002 5.2 7.90002L4.4 6.79993C4.1 6.39993 4.1 5.69993 4.5 5.29993L5.3 4.5C5.7 4.1 6.3 4.10002 6.8 4.40002L7.9 5.19995C8.6 4.79995 9.4 4.39995 10.2 4.19995L10.4 2.90002C10.5 2.40002 11 2 11.5 2H12.6C13.2 2 13.6 2.40002 13.7 2.90002L13.9 4.19995C14.7 4.39995 15.5 4.69995 16.2 5.19995L17.3 4.40002C17.7 4.10002 18.4 4.1 18.8 4.5L19.6 5.29993C20 5.69993 20 6.29993 19.7 6.79993L18.9 7.90002C19.3 8.60002 19.7 9.39995 19.9 10.2L21.2 10.4C21.7 10.5 22.1 11 22.1 11.5ZM12.1 8.59998C10.2 8.59998 8.6 10.2 8.6 12.1C8.6 14 10.2 15.6 12.1 15.6C14 15.6 15.6 14 15.6 12.1C15.6 10.2 14 8.59998 12.1 8.59998Z" fill="currentColor" />
												<path d="M17.1 12.1C17.1 14.9 14.9 17.1 12.1 17.1C9.30001 17.1 7.10001 14.9 7.10001 12.1C7.10001 9.29998 9.30001 7.09998 12.1 7.09998C14.9 7.09998 17.1 9.29998 17.1 12.1ZM12.1 10.1C11 10.1 10.1 11 10.1 12.1C10.1 13.2 11 14.1 12.1 14.1C13.2 14.1 14.1 13.2 14.1 12.1C14.1 11 13.2 10.1 12.1 10.1Z" fill="currentColor" />
											</svg>
										</span>
										<!--end::Svg Icon-->
									</a>
									<!--end::Toggle-->
									<!--begin::Menu 2-->
									<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
										<!--begin::Menu item-->
										<div class="menu-item px-3">
											<div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Acciones Rápidas</div>
										</div>
										<!--end::Menu item-->
										<!--begin::Menu separator-->
										<div class="separator mb-3 opacity-75"></div>
										<!--end::Menu separator-->
										<!--begin::Menu item-->
										<div class="menu-item px-3">
											<a href="<?php echo site_url().BACKOFFICE."/ticket";?>" class="menu-link px-3">Nuevo Ticket</a>
										</div>
										<!--end::Menu item-->
										<!--begin::Menu item-->
										<div class="menu-item px-3">
											<a target="_blank" href="<?php echo site_url()."registro/".$obj_customer[0]->username;?>" class="menu-link px-3">Nuevo Socio</a>
										</div>
										<!--end::Menu item-->
										<!--begin::Menu item-->
										<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
											<!--begin::Menu item-->
											<a href="#" class="menu-link px-3">
												<span class="menu-title">Red</span>
												<span class="menu-arrow"></span>
											</a>
											<!--end::Menu item-->
											<!--begin::Menu sub-->
											<div class="menu-sub menu-sub-dropdown w-175px py-4">
												<!--begin::Menu item-->
												<div class="menu-item px-3">
													<a href="<?php echo site_url().BACKOFFICE."/binario";?>" class="menu-link px-3">Arbol Binario</a>
												</div>
												<!--end::Menu item-->
												<!--begin::Menu item-->
												<div class="menu-item px-3">
													<a href="<?php echo site_url().BACKOFFICE."/unilevel";?>" class="menu-link px-3">Arbol Unilevel</a>
												</div>
												<!--end::Menu item-->
												<!--begin::Menu item-->
												<div class="menu-item px-3">
													<a href="<?php echo site_url().BACKOFFICE."/directos";?>" class="menu-link px-3">Ventas Directas</a>
												</div>
												<!--end::Menu item-->
											</div>
											<!--end::Menu sub-->
										</div>
										<!--end::Menu item-->
										<!--begin::Menu item-->
										<div class="menu-item px-3">
											<a href="<?php echo site_url().BACKOFFICE."/centro-ayuda";?>" class="menu-link px-3">Centro de Ayuda</a>
										</div>
										<!--end::Menu item-->
										<!--begin::Menu separator-->
										<div class="separator mt-3 opacity-75"></div>
										<!--end::Menu separator-->
									</div>
									<!--end::Menu 2-->
								</div>
								<!--end::Menu wrapper-->
							</div>
							<!--end::Actions-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Toolbar-->
          			<!--------------->
					<!--begin::BODY-->
          			<!--------------->





					  <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
						<!--begin::Post-->
						<div class="content flex-row-fluid" id="kt_content">
							<!--begin::Hero card-->
							<div class="card mb-12">
								<!--begin::Hero body-->
								<div class="card-body flex-column p-5">
									<!--begin::Hero nav-->
									<div class="card-rounded bg-light d-flex flex-stack flex-wrap p-5">
										<!--begin::Nav-->
										<ul class="nav flex-wrap border-transparent fw-bold">
											<!--begin::Nav item-->
											<li class="nav-item my-1">
												<a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase active" href="<?php echo site_url().BACKOFFICE."/centro-ayuda";?>">Centro de Ayuda</a>
											</li>
											<!--end::Nav item-->
											<!--begin::Nav item-->
											<li class="nav-item my-1">
												<a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase" href="<?php echo site_url().BACKOFFICE."/ticket";?>">tickets</a>
											</li>
											<!--end::Nav item-->
											<!--begin::Nav item-->
											<li class="nav-item my-1">
												<a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase" href="<?php echo site_url().BACKOFFICE."/tutoriales";?>">Tutoriales</a>
											</li>
											<!--end::Nav item-->
										</ul>
										<!--end::Nav-->
										<!--begin::Action-->
										<a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_new_ticket" class="btn btn-primary fw-bold fs-8 fs-lg-base">Crear Ticket</a>
										<!--end::Action-->
									</div>
									<!--end::Hero nav-->
								</div>
								<!--end::Hero body-->
							</div>
							<!--end::Hero card-->
							<!--begin::Row-->
							<div class="row gy-0 mb-6 mb-xl-12">
								<!--begin::Col-->
								<div class="col-md-6">
									<!--begin::Card-->
									<div class="card card-md-stretch me-xl-3 mb-md-0 mb-6">
										<!--begin::Body-->
										<div class="card-body p-10 p-lg-15">
											<!--begin::Header-->
											<div class="d-flex flex-stack mb-7">
												<!--begin::Title-->
												<h1 class="fw-bold text-dark">Tickets Populares</h1>
												<!--end::Title-->
											</div>
											<!--end::Header-->
											<!--begin::Accordion-->
											<!--begin::Section-->
											<div class="m-0">
												<!--begin::Heading-->
												<div class="d-flex align-items-center collapsible py-3 toggle mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_1_1">
													<!--begin::Icon-->
													<div class="ms-n1 me-5">
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
														<span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
														<span class="svg-icon toggle-off svg-icon-2">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Icon-->
													<!--begin::Section-->
													<div class="d-flex align-items-center flex-wrap">
														<!--begin::Title-->
														<h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">¿Cómo hacer un traspaso de cuenta?</h3>
														<!--end::Title-->
													</div>
													<!--end::Section-->
												</div>
												<!--end::Heading-->
												<!--begin::Body-->
												<div id="kt_support_1_1" class="collapse show fs-6 ms-10">
													<!--begin::Block-->
													<div class="mb-4">
														<!--begin::Text-->
														<span class="text-muted fw-semibold fs-5">Primero debes enviar un ticket a soporte o comunicarte por nuestros canales de contacto, con el título “Traspaso de cuenta”, detallando el motivo y adjuntado tu DNI o cedula.</span>
														<!--end::Text-->
													</div>
													<!--end::Block-->
												</div>
												<!--end::Content-->
											</div>
											<!--end::Body-->
											<!--begin::Section-->
											<div class="m-0">
												<!--begin::Heading-->
												<div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_1_2">
													<!--begin::Icon-->
													<div class="ms-n1 me-5">
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
														<span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
														<span class="svg-icon toggle-off svg-icon-2">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Icon-->
													<!--begin::Section-->
													<div class="d-flex align-items-center flex-wrap">
														<!--begin::Title-->
														<h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">¿No tengo acceso a mi correo electrónico registrado?</h3>
														<!--end::Title-->
													</div>
													<!--end::Section-->
												</div>
												<!--end::Heading-->
												<!--begin::Body-->
												<div id="kt_support_1_2" class="collapse fs-6 ms-10">
													<!--begin::Block-->
													<div class="mb-4">
														<!--begin::Text-->
														<span class="text-muted fw-semibold fs-5">En la sección de Configuración puedes hacer el cambio del correo directamente sin la necesidad de contactar a soporte, debes de tener tu PIN configurado para dicha acción.</span>
														<!--end::Text-->
													</div>
													<!--end::Block-->
												</div>
												<!--end::Content-->
											</div>
											<!--end::Body-->
											<!--begin::Section-->
											<div class="m-0">
												<!--begin::Heading-->
												<div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_1_3">
													<!--begin::Icon-->
													<div class="ms-n1 me-5">
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
														<span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
														<span class="svg-icon toggle-off svg-icon-2">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Icon-->
													<!--begin::Section-->
													<div class="d-flex align-items-center flex-wrap">
														<!--begin::Title-->
														<h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">¿Me equivoque en configurar mi wallet de USDT?</h3>
														<!--end::Title-->
													</div>
													<!--end::Section-->
												</div>
												<!--end::Heading-->
												<!--begin::Body-->
												<div id="kt_support_1_3" class="collapse fs-6 ms-10">
													<!--begin::Block-->
													<div class="mb-4">
														<!--begin::Text-->
														<span class="text-muted fw-semibold fs-5">Puedes actualizar tu wallet nuevamente en la sección de configuración, sin embargo, una vez realizado la transacción de pago no hay opción a recuperar. </span>
														<!--end::Text-->
													</div>
													<!--end::Block-->
												</div>
												<!--end::Content-->
											</div>
											<!--end::Body-->
											<!--begin::Section-->
											<div class="m-0">
												<!--begin::Heading-->
												<div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_1_4">
													<!--begin::Icon-->
													<div class="ms-n1 me-5">
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
														<span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
														<span class="svg-icon toggle-off svg-icon-2">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Icon-->
													<!--begin::Section-->
													<div class="d-flex align-items-center flex-wrap">
														<!--begin::Title-->
														<h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">¿Aun no me ha llegado mis comisiones?</h3>
														<!--end::Title-->
													</div>
													<!--end::Section-->
												</div>
												<!--end::Heading-->
												<!--begin::Body-->
												<div id="kt_support_1_4" class="collapse fs-6 ms-10">
													<!--begin::Block-->
													<div class="mb-4">
														<!--begin::Text-->
														<span class="text-muted fw-semibold fs-5">El plazo máximo de transferencia de comisiones es de 48 horas hábiles, si aun así no ha llegado recomendamos verificar la wallet registrada en el sistema o sino enviar un ticket a soporte informando el caso mencionado.</span>
														<!--end::Text-->
													</div>
													<!--end::Block-->
												</div>
												<!--end::Content-->
											</div>
											<!--end::Body-->
											<!--begin::Section-->
											<div class="m-0">
												<!--begin::Heading-->
												<div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_1_5">
													<!--begin::Icon-->
													<div class="ms-n1 me-5">
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
														<span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
														<span class="svg-icon toggle-off svg-icon-2">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Icon-->
													<!--begin::Section-->
													<div class="d-flex align-items-center flex-wrap">
														<!--begin::Title-->
														<h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">¿No me acuerdo mi PIN?</h3>
														<!--end::Title-->
													</div>
													<!--end::Section-->
												</div>
												<!--end::Heading-->
												<!--begin::Body-->
												<div id="kt_support_1_5" class="collapse fs-6 ms-10">
													<!--begin::Block-->
													<div class="mb-4">
														<!--begin::Text-->
														<span class="text-muted fw-semibold fs-5">Para configurar nuevamente el PIN de seguridad, en la sección de configuración tienes un enlace para restablecerlo. Te llegará un mensaje al correo electrónico registrado y podrás cambiarlo.</span>
														<!--end::Text-->
													</div>
													<!--end::Block-->
												</div>
												<!--end::Content-->
											</div>
											<!--end::Body-->
											<!--begin::Section-->
											<div class="m-0">
												<!--begin::Heading-->
												<div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_1_6">
													<!--begin::Icon-->
													<div class="ms-n1 me-5">
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
														<span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
														<span class="svg-icon toggle-off svg-icon-2">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Icon-->
													<!--begin::Section-->
													<div class="d-flex align-items-center flex-wrap">
														<!--begin::Title-->
														<h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">¿Envié mi KYC nuevamente, pero me lo han rechazado?</h3>
														<!--end::Title-->
													</div>
													<!--end::Section-->
												</div>
												<!--end::Heading-->
												<!--begin::Body-->
												<div id="kt_support_1_6" class="collapse fs-6 ms-10">
													<!--begin::Block-->
													<div class="mb-4">
														<!--begin::Text-->
														<span class="text-muted fw-semibold fs-5">Enviar documentos validos por el sistema (DNI o cédula, pasaporte o licencia de conducir) verificar que el documento este vigente y legible, con esas recomendaciones podrá validar correctamente el KYC.</span>
														<!--end::Text-->
													</div>
													<!--end::Block-->
												</div>
												<!--end::Content-->
											</div>
											<!--end::Body-->
											<!--end::Accordion-->
										</div>
										<!--end::Body-->
									</div>
									<!--end::Card-->
								</div>
								<!--end::Col-->
								<!--begin::Col-->
								<div class="col-md-6">
									<!--begin::Card-->
									<div class="card card-md-stretch me-xl-3 mb-md-0 mb-6">
										<!--begin::Body-->
										<div class="card-body p-10 p-lg-15">
											<!--begin::Header-->
											<div class="d-flex flex-stack mb-7">
												<!--begin::Title-->
												<h1 class="fw-bold text-dark">Tutoriales</h1>
												<!--end::Title-->
												<!--begin::Section-->
												<div class="d-flex align-items-center">
													<!--begin::Link-->
													<a href="<?php echo site_url().BACKOFFICE."/tutoriales";?>" class="text-primary fw-bold me-1">Ver todo</a>
													<!--begin::Link-->
													<!--begin::Arrow-->
													<!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
													<span class="svg-icon svg-icon-2 svg-icon-primary">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor"></rect>
															<path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor"></path>
														</svg>
													</span>
													<!--end::Svg Icon-->
													<!--end::Arrow-->
												</div>
												<!--end::Section-->
											</div>
											<!--end::Header-->
											<!--begin::Accordion-->
											<!--begin::Section-->
											<div class="m-0">
												<!--begin::Heading-->
												<div class="d-flex align-items-center collapsible py-3 toggle mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_3_1">
													<!--begin::Icon-->
													<div class="ms-n1 me-5">
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
														<span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
														<span class="svg-icon toggle-off svg-icon-2">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Icon-->
													<!--begin::Section-->
													<div class="d-flex align-items-center flex-wrap">
														<!--begin::Title-->
														<h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">Vista Global</h3>
														<!--end::Title-->
													</div>
													<!--end::Section-->
												</div>
												<!--end::Heading-->
												<!--begin::Body-->
												<div id="kt_support_3_1" class="collapse show fs-6 ms-10">
													<!--begin::Block-->
													<div class="mb-4">
														<!--begin::Text-->
														<span class="text-muted fw-semibold fs-5">Aprende el uso correcto de todas las funcionalidades de tu oficina virtual y sácale el máximo provecho.</span>
														<!--end::Text-->
														<!--begin::Link-->
														<!a href="https://www.youtube.com/watch?v=DC8imNvPWb4" target="_blank" class="fs-5 link-primary fw-semibold">Ver Vídeo</a-->
														<!--end::Link-->
													</div>
													<!--end::Block-->
												</div>
												<!--end::Content-->
											</div>
											<!--end::Body-->
											<!--begin::Section-->
											<div class="m-0">
												<!--begin::Heading-->
												<div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_3_2">
													<!--begin::Icon-->
													<div class="ms-n1 me-5">
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
														<span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
														<span class="svg-icon toggle-off svg-icon-2">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Icon-->
													<!--begin::Section-->
													<div class="d-flex align-items-center flex-wrap">
														<!--begin::Title-->
														<h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">¿Cómo crear un nuevo socio?</h3>
														<!--end::Title-->
													</div>
													<!--end::Section-->
												</div>
												<!--end::Heading-->
												<!--begin::Body-->
												<div id="kt_support_3_2" class="collapse fs-6 ms-10">
													<!--begin::Block-->
													<div class="mb-4">
														<!--begin::Text-->
														<span class="text-muted fw-semibold fs-5">No sabes como asociar nuevos clientes a tu red de negocio, ve el siguiente vídeo.</span>
														<!--end::Text-->
														<!--begin::Link-->
														<!--a href="https://www.youtube.com/watch?v=MvDY6NoJz5w" target="_blank" class="fs-5 link-primary fw-semibold">Ver Vídeo</a-->
														<!--end::Link-->
													</div>
													<!--end::Block-->
												</div>
												<!--end::Content-->
											</div>
											<!--end::Body-->
											<!--begin::Section-->
											<div class="m-0">
												<!--begin::Heading-->
												<div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_3_3">
													<!--begin::Icon-->
													<div class="ms-n1 me-5">
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
														<span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
														<span class="svg-icon toggle-off svg-icon-2">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Icon-->
													<!--begin::Section-->
													<div class="d-flex align-items-center flex-wrap">
														<!--begin::Title-->
														<h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">¿Cómo configurar el KYC?</h3>
														<!--end::Title-->
													</div>
													<!--end::Section-->
												</div>
												<!--end::Heading-->
												<!--begin::Body-->
												<div id="kt_support_3_3" class="collapse fs-6 ms-10">
													<!--begin::Block-->
													<div class="mb-4">
														<!--begin::Text-->
														<span class="text-muted fw-semibold fs-5"><b>Know your customer</b>, es el proceso fundamental que define y permite las relaciones entre empresas y usuarios. El procedimiento KYC es el primer paso para que una persona pueda convertirse en cliente o usuario registrado de una organización o empresa con seguridad, garantías y cumpliendo con las normas que regulan este hecho.</span>
														<!--end::Text-->
														<!--begin::Link-->
														<!--a href="https://www.youtube.com/watch?v=PFyTIivAF6c" target="_blank" class="fs-5 link-primary fw-semibold">Ver Vídeo</a-->
														<!--end::Link-->
													</div>
													<!--end::Block-->
												</div>
												<!--end::Content-->
											</div>
											<!--end::Body-->
											<!--begin::Section-->
											<div class="m-0">
												<!--begin::Heading-->
												<div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_3_4">
													<!--begin::Icon-->
													<div class="ms-n1 me-5">
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
														<span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
														<span class="svg-icon toggle-off svg-icon-2">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Icon-->
													<!--begin::Section-->
													<div class="d-flex align-items-center flex-wrap">
														<!--begin::Title-->
														<h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">¿Cómo configurar el PIN de seguridad?</h3>
														<!--end::Title-->
													</div>
													<!--end::Section-->
												</div>
												<!--end::Heading-->
												<!--begin::Body-->
												<div id="kt_support_3_4" class="collapse fs-6 ms-10">
													<!--begin::Block-->
													<div class="mb-4">
														<!--begin::Text-->
														<span class="text-muted fw-semibold fs-5">Una capa seguridad adicional es el PIN de seguridad, al momento de realizar operaciones importantes se pedirá el PIN de seguridad.</span>
														<!--end::Text-->
														<!--begin::Link-->
														<!--a href="https://www.youtube.com/watch?v=5uNo4lkSZdY" target="_blank" class="fs-5 link-primary fw-semibold">Ver Vídeo</a-->
														<!--end::Link-->
													</div>
													<!--end::Block-->
												</div>
												<!--end::Content-->
											</div>
											<!--end::Body-->
											<!--begin::Section-->
											<div class="m-0">
												<!--begin::Heading-->
												<div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_3_5">
													<!--begin::Icon-->
													<div class="ms-n1 me-5">
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
														<span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
														<span class="svg-icon toggle-off svg-icon-2">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Icon-->
													<!--begin::Section-->
													<div class="d-flex align-items-center flex-wrap">
														<!--begin::Title-->
														<h3 class="text-gray-800 fw-semibold cursor-pointer me-3 mb-0">¿Cómo realizar un cobro?</h3>
														<!--end::Title-->
													</div>
													<!--end::Section-->
												</div>
												<!--end::Heading-->
												<!--begin::Body-->
												<div id="kt_support_3_5" class="collapse fs-6 ms-10">
													<!--begin::Block-->
													<div class="mb-4">
														<!--begin::Text-->
														<span class="text-muted fw-semibold fs-5">Luego de tener configurado el KYC y el PIN de seguridad cada jueves podrás solicitar tus comisiones, ver el siguiente vídeo.</span>
														<!--end::Text-->
														<!--begin::Link-->
														<!--a href="https://www.youtube.com/watch?v=Fu0XLgv_IoQ" target="_blank" class="fs-5 link-primary fw-semibold">Ver Vídeo</a-->
														<!--end::Link-->
													</div>
													<!--end::Block-->
												</div>
												<!--end::Content-->
											</div>
											<!--end::Body-->
											<!--end::Accordion-->
										</div>
										<!--end::Body-->
									</div>
									<!--end::Card-->
								</div>
								<!--end::Col-->
							</div>
							<!--end::Row-->
							<!--begin::Modal - Support Center - Create Ticket-->
							<div class="modal fade" id="kt_modal_new_ticket" tabindex="-1" aria-hidden="true">
								<!--begin::Modal dialog-->
								<div class="modal-dialog modal-dialog-centered mw-750px">
									<!--begin::Modal content-->
									<div class="modal-content rounded">
										<!--begin::Modal header-->
										<div class="modal-header pb-0 border-0 justify-content-end">
											<!--begin::Close-->
											<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
												<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
												<span class="svg-icon svg-icon-1">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
														<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
													</svg>
												</span>
												<!--end::Svg Icon-->
											</div>
											<!--end::Close-->
										</div>
										<!--begin::Modal header-->
										<!--begin::Modal body-->
										<div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
											<!--begin:Form-->
											<form name="ticket-form" enctype="multipart/form-data" method="post" action="javascript:void(0);" onsubmit="new_ticket();">
												<!--begin::Heading-->
												<div class="mb-13 text-center">
													<!--begin::Title-->
													<h1 class="mb-3">Crear Ticket</h1>
													<!--end::Title-->
													<!--begin::Description-->
													<div class="text-gray-400 fw-semibold fs-5">Si necesita más información, consulte
													<a href="<?php echo site_url().BACKOFFICE."/centro-ayuda"?>" class="fw-bold link-primary">Centro de Ayuda</a>.</div>
													<!--end::Description-->
												</div>
												<!--end::Heading-->
												<!--begin::Input group-->
												<div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
													<!--begin::Label-->
													<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
														<span class="required">Asunto</span>
													</label>
													<!--end::Label-->
													<select name="subject" id="subject" class="form-select form-select-solid" required>
														<option value="" data-select2-id="select2-data-12-icnj">Seleccionar asunto...</option>
														<?php 
															foreach ($obj_concepto_ticket as $value) { ?>
															<option value="<?php echo $value->id;?>"><?php echo $value->title;?></option>
														<?php }  ?>
													</select>
												<div class="fv-plugins-message-container invalid-feedback"></div></div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
													<label class="fs-6 fw-semibold mb-2">Descripción</label>
													<textarea class="form-control form-control-solid" rows="4" name="content" id="content" placeholder="Escriba la descripción de su Ticket" required></textarea>
												<div class="fv-plugins-message-container invalid-feedback"></div></div>
												<!--end::Input group-->
												<!--begin::Input group-->
											<div class="row mb-6">
												<!--begin::Label-->
												<label class="col-lg-4 col-form-label fw-semibold fs-6">Seleccion Imagen</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-12">
													<!--begin::Image input-->
													<div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('<?php echo site_url()."assets/metronic8/media/svg/avatars/blank.svg"?>')">
														<!--begin::Preview existing avatar-->
															<div class="image-input-wrapper w-125px h-125px" style="background-image: url('<?php echo site_url()."assets/metronic8/media/svg/files/doc.svg";?>')"></div>
														<!--end::Preview existing avatar-->
														<!--begin::Label-->
														<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Seleccionar Imagen">
															<i class="bi bi-pencil-fill fs-7"></i>
															<!--begin::Inputs-->
															<input type="file" name="image_file" accept="*" required/>
															<!--end::Inputs-->
														</label>
														<!--end::Label-->
														<!--begin::Cancel-->
														<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
															<i class="bi bi-x fs-2"></i>
														</span>
														<!--end::Cancel-->
													</div>
													<!--end::Image input-->
													<!--begin::Hint-->
													<div class="form-text">Tipo de archivos permitidos: png, jpg, jpeg. gif.</div>
													<!--end::Hint-->
												</div>
												<!--end::Col-->
											</div>
											<!--end::Input group-->
												<!--begin::Actions-->
												<div class="text-center">
													<button type="submit" id="submit" class="btn btn-primary">
														<span class="indicator-label">Enviar</span>
													</button>
												</div>
												<!--end::Actions-->
											<div></div></form>
											<!--end:Form-->
										</div>
										<!--end::Modal body-->
									</div>
									<!--end::Modal content-->
								</div>
								<!--end::Modal dialog-->
							</div>
							<!--end::Modal - Support Center - Create Ticket-->
						</div>
						<!--end::Post-->
					</div>
					<script src='<?php echo site_url().'assets/js/script/backoffice/ticket_new.js?123';?>'></script>
					<!--------------->
					<!--end::BODY-->
          			<!--------------->
					<!--begin::Footer-->
          			<?php echo view("backoffice_new/footer"); ?>
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Root-->
		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
			<span class="svg-icon">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
					<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
				</svg>
			</span>
			<!--end::Svg Icon-->
		</div>
		<!--end::Scrolltop-->
		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="<?php echo site_url()."assets/metronic8/plugins/global/plugins.bundle.js";?>"></script>
		<script src="<?php echo site_url()."assets/metronic8/js/scripts.bundle.js";?>"></script>
		<script src="<?php echo site_url()."assets/metronic8/js/link_nav.js";?>"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Vendors Javascript(used by this page)-->
		<script src="<?php echo site_url()."assets/metronic8/plugins/custom/datatables/datatables.bundle.js";?>"></script>
		<script src="<?php echo site_url()."assets/metronic8/plugins/custom/prismjs/prismjs.bundle.js";?>"></script>
		<!--end::Vendors Javascript-->
		<!--begin::Custom Javascript(used by this page)-->
		<script src="<?php echo site_url()."assets/metronic8/js/widgets.bundle.js";?>"></script>
		<script src="<?php echo site_url()."assets/metronic8/js/custom/widgets.js";?>"></script>
		<!--end::Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>






