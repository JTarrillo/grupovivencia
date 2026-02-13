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
					<!--begin::BODY-->
					<!------------->




					<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
						<!--begin::Post-->
						<div class="content flex-row-fluid" id="kt_content">
							<!--begin::Navbar-->
							<div class="card mb-5 mb-xl-10">
								<div class="card-body pt-9 pb-0">
									<!--begin::Details-->
									<div class="d-flex flex-wrap flex-sm-nowrap mb-3">
										<!--begin: Pic-->
										<div class="me-7 mb-4">
											<div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
												<?php 
												if($obj_customer[0]->avatar != ""){ ?>
														<img src="<?php echo site_url()."avatar/".$obj_customer[0]->customer_id."/".$obj_customer[0]->avatar;?>" alt="avatar">
													<?php }else{ ?>
														<img src="<?php echo site_url()."assets/metronic8/media/avatars/300-1.jpg";?>" alt="image">
												<?php } ?>
												<div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
											</div>
										</div>
										<!--end::Pic-->
										<!--begin::Info-->
										<div class="flex-grow-1">
											<!--begin::Title-->
											<div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
												<!--begin::User-->
												<div class="d-flex flex-column">
													<!--begin::Name-->
													<div class="d-flex align-items-center mb-2">
														<a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">
															<?php echo $obj_customer[0]->first_name." ".$obj_customer[0]->last_name;?>
														</a>
														<!--begin::Svg Icon | path: icons/duotune/general/gen026.svg-->
														<span class="svg-icon svg-icon-1 svg-icon-primary">
															<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
																<path d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z" fill="currentColor"></path>
																<path d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z" fill="white"></path>
															</svg>
														</span>
														</a>
														<a href="<?php echo site_url().BACKOFFICE."/planes";?>" class="btn btn-sm btn-light-success fw-bold ms-2 fs-8 py-1 px-3">Upgrade a Pro</a>
													</div>
													<!--end::Name-->
													<!--begin::Info-->
													<div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
														<a class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
														<!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
														<span class="svg-icon svg-icon-4 me-1">
															<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path opacity="0.3" d="M16.5 9C16.5 13.125 13.125 16.5 9 16.5C4.875 16.5 1.5 13.125 1.5 9C1.5 4.875 4.875 1.5 9 1.5C13.125 1.5 16.5 4.875 16.5 9Z" fill="currentColor"></path>
																<path d="M9 16.5C10.95 16.5 12.75 15.75 14.025 14.55C13.425 12.675 11.4 11.25 9 11.25C6.6 11.25 4.57499 12.675 3.97499 14.55C5.24999 15.75 7.05 16.5 9 16.5Z" fill="currentColor"></path>
																<rect x="7" y="6" width="4" height="4" rx="2" fill="currentColor"></rect>
															</svg>
														</span>
														<?php echo $obj_customer[0]->kit;?>
														</a>
														<a class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
														<!--begin::Svg Icon | path: icons/duotune/general/gen018.svg-->
														<span class="svg-icon svg-icon-4 me-1">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path opacity="0.3" d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z" fill="currentColor"></path>
																<path d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z" fill="currentColor"></path>
															</svg>
														</span>
														<?php echo $obj_customer[0]->pais;?>
														</a>
														<a class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
														<!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
														<span class="svg-icon svg-icon-4 me-1">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z" fill="currentColor"></path>
																<path d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z" fill="currentColor"></path>
															</svg>
														</span>
														<?php echo $obj_customer[0]->email;?>
														</a>
													</div>
													<!--end::Info-->
												</div>
												<!--end::User-->
											</div>
											<!--end::Title-->
											<!--begin::Stats-->
											<div class="d-flex flex-wrap flex-stack">
												<!--begin::Wrapper-->
												<div class="d-flex flex-column flex-grow-1 pe-8">
													<!--begin::Stats-->
													<div class="d-flex flex-wrap">
														<!--begin::Stat-->
														<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
															<!--begin::Number-->
															<div class="d-flex align-items-center">
																<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
																<span class="svg-icon svg-icon-3 svg-icon-success me-2">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor"></rect>
																		<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor"></path>
																	</svg>
																</span>
																<!--end::Svg Icon-->
																<div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="<?php echo $obj_earn_total;?>" data-kt-countup-prefix="$" data-kt-initialized="1">$<?php echo format_number_miles_decimal($obj_earn_total);?></div>
															</div>
															<!--end::Number-->
															<!--begin::Label-->
															<div class="fw-semibold fs-6 text-gray-400">Ganancia Total</div>
															<!--end::Label-->
														</div>
														<!--end::Stat-->
														<!--begin::Stat-->
														<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
															<!--begin::Number-->
															<div class="d-flex align-items-center">
																<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
																<span class="svg-icon svg-icon-3 svg-icon-success me-2">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor"></rect>
																		<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor"></path>
																	</svg>
																</span>
																<!--end::Svg Icon-->
																<div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="<?php echo $obj_earn_disponible;?>" data-kt-countup-prefix="$" data-kt-initialized="1">$<?php echo format_number_miles_decimal($obj_earn_disponible);?></div>
															</div>
															<!--end::Number-->
															<!--begin::Label-->
															<div class="fw-semibold fs-6 text-gray-400">Ganancia Disponible</div>
															<!--end::Label-->
														</div>
														<!--end::Stat-->
													</div>
													<!--end::Stats-->
												</div>
												<!--end::Wrapper-->
												<!--begin::Progress-->
												<div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
													<div class="d-flex justify-content-between w-100 mt-auto mb-2">
														<span class="fw-semibold fs-6 text-gray-400">Completar el perfil</span>
														<span class="fw-bold fs-6">50%</span>
													</div>
													<div class="h-5px mx-3 w-100 bg-light mb-3">
														<div class="bg-success rounded h-5px" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</div>
												<!--end::Progress-->
											</div>
											<!--end::Stats-->
										</div>
										<!--end::Info-->
									</div>
									<!--end::Details-->
								</div>
							</div>
							<!--end::Navbar-->
							<!--begin::details View-->
							<div class="col-xl-12">
								<div class="d-flex justify-content-between flex-column-fluid flex-column w-100">
									<!--begin::Body-->
									<div class="py-2">
											<!--begin::Form-->
												<!--begin::Section-->
												<div class="mb-10">
												<?php 
                  									if($kyc != 2){ ?>		
													<div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
													<!--begin::Icon-->
														<!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
														<span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
																<rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor"></rect>
																<rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"></rect>
															</svg>
														</span>
														<!--end::Svg Icon-->
														<!--end::Icon-->
														<!--begin::Wrapper-->
															<div class="d-flex flex-stack flex-grow-1">
																<!--begin::Content-->
																<div class="fw-semibold">
																	<h4 class="text-gray-900 fw-bold">Necesitamos su atención!</h4>
																	<div class="fs-6 text-gray-700">Para empezar a realizar transferencias es importante validar su KYC.
																	<a class="fw-bold" href="<?php echo site_url().BACKOFFICE."/kyc";?>">Agregar información</a>.</div>
																</div>
																<!--end::Content-->
															</div>
														<!--end::Wrapper-->
													</div>	
													<br/>	
													<?php } ?>
													<div class="alert alert-success d-flex align-items-center p-5 mb-10">
														<!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
														<span class="svg-icon svg-icon-2hx svg-icon-success me-4">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor"></path>
																<path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
														<div class="d-flex flex-column">
															<h4 class="mb-1 text-success">REGLAS DE TRANSFERENCIA</h4>
															<span>Las transferencias entre usuarios son inmediatas.</span>
															<span>El fee de transacción es del <?php echo format_number_miles($info_pay[0]->percent);?>% del importe + 10US$ por envio..</span>
														</div>
													</div>
												</div>
												<!--end::Section-->
										</div>
										<!--end::Body-->
									</div>
									<!--begin::Table Widget 5-->
									<div class="card card-flush h-xl-100">
										<?php 
											if($kyc == 2){ ?>
										<div class="card-header cursor-pointer">
											<!--begin::Card title-->
											<div class="card-title m-0">
											</div>
											<!--end::Card title-->
											<!--begin::Action-->
											<a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_new_ticket" class="btn btn-primary align-self-center">Transferir</a>
											<!--end::Action-->	
										</div>
										<?php } ?>	
										<!--begin::Card header-->
										<div class="card-header pt-7">
											<!--begin::Title-->
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bold text-dark">Historial de Transferencias</span>
												<span class="text-gray-400 mt-1 fw-semibold fs-6">Todas las actividades</span>
											</h3>
											<!--end::Title-->
											<!--begin::Actions-->
											<div class="card-toolbar">
												<!--begin::Filters-->
												<div class="d-flex flex-stack flex-wrap gap-4">
													<!--begin::Status-->
													<div class="d-flex align-items-center fw-bold">
														<!--begin::Label-->
														<div class="text-muted fs-7 me-2">Status</div>
														<!--end::Label-->
														<!--begin::Select-->
														<select class="form-select form-select-transparent text-dark fs-7 lh-1 fw-bold py-0 ps-3 w-auto select2-hidden-accessible" data-control="select2" data-hide-search="true" data-dropdown-css-class="w-150px" data-placeholder="Select an option" data-kt-table-widget-5="filter_status" data-select2-id="select2-data-1-56j2" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
															<option></option>
															<option value="Show All" selected="selected" data-select2-id="select2-data-3-m4yu">Show All</option>
															<option value="In Stock">Ingreso</option>
															<option value="Out of Stock">Salida</option>
                                             				<option value="Low Stock">Binario</option>
														</select>
														<span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-2-8i8s" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-transparent text-dark fs-7 lh-1 fw-bold py-0 ps-3 w-auto" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-agys-container" aria-controls="select2-agys-container"><span class="select2-selection__rendered" id="select2-agys-container" role="textbox" aria-readonly="true" title="Show All">Show All</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
														<!--end::Select-->
													</div>
													<!--end::Status-->
												</div>
												<!--begin::Filters-->
											</div>
											<!--end::Actions-->
										</div>
										<!--end::Card header-->
										<!--begin::Card body-->
										<div class="card-body">
											<!--begin::Table-->
											<div id="kt_table_widget_5_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
												<div class="table-responsive">
													<table class="table table-striped table-row-bordered gy-5 gs-7" id="kt_datatable_fixed_columns">
														<!--begin::Table head-->
														<thead>
															<!--begin::Table row-->
															<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
																<th class="min-w-100px sorting" tabindex="0" style="width: 130.817px;">Transfer ID</th>
																<th class="min-w-100px sorting_disabled" rowspan="1" colspan="1" style="width: 136.833px;">Concepto</th>
																<th class="text-end pe-3 min-w-150px sorting" tabindex="0" rowspan="1" colspan="1" style="width: 202.233px;">Fecha</th>
																<th class="text-end pe-3 min-w-100px sorting" tabindex="0" rowspan="1" colspan="1" style="width: 136.817px;">Emisor / Receptor</th>
																<th class="text-end pe-3 min-w-100px sorting" tabindex="0" rowspan="1" colspan="1" style="width: 136.817px;">Importe</th>
																<th class="text-end pe-3 min-w-50px sorting" tabindex="0" rowspan="1" colspan="1" style="width: 85.9667px;">Estado</th>
															</tr>
															<!--end::Table row-->
														</thead>
														<!--end::Table head-->
														<!--begin::Table body-->
														<tbody class="fw-bold text-gray-600">
															<?php foreach ($obj_commissions as $value) { ?>
															<tr class="odd">
																<!--begin::Item-->
																<td>
																	<?php echo $value->commissions_id;?>
																</td>
																<td>
																	<?php echo $value->bonus;?>
																</td>
																<!--end::Item-->
																<!--begin::Date added-->
																<td class="text-end"><?php echo formato_fecha_dia_mes_anio_abrev($value->date);?></td>
																<!--end::Date added-->
																<td class="text-end">
																	<?php echo str_to_first_capital($value->first_name)." ".str_to_first_capital($value->last_name);?>
																</td>
																<!--begin::Price-->
																<?php 
																if($value->amount < 0){  ?>
																	<td class="text-end"><?php echo format_number_miles_decimal($value->amount);?>$</td>
																<?php }else{ ?>
																	<td class="text-end">$<?php echo format_number_miles_decimal($value->amount);?></td>
																<?php } ?>
																<!--end::Price-->
																<!--begin::Status-->
																<td class="text-end">
																<?php 
																	if($value->amount < 0){ ?>
																		<a class="badge py-3 px-4 fs-7 badge-light-danger">Salida</a>
																	<?php } else{ ?>
																		<a class="badge py-3 px-4 fs-7 badge-light-success">Ingreso</a>
																	<?php } ?>
																</td>
																<!--end::Status-->
															</tr>
															<?php } ?>
														</tbody>
														<!--end::Table body-->
													</table>
												</div>
											</div>	
											<!--end::Table-->
										</div>
										<!--end::Card body-->
									</div>
									<!--end::Table Widget 5-->
								</div>
							<!--end::details View-->
						</div>
						<!--end::Post-->
					</div>
					<!--begin::Modal - Transfer-->
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
											<form onsubmit="send_commissions();" enctype="multipart/form-data" action="javascript:void(0);" method="post" class="form">
												<input type="hidden" name="total_disponible" id="total_disponible" value="<?php echo $obj_earn_disponible;?>">
												<input type="hidden" name="customer_id" id="customer_id" value=""/>
												<!--begin::Heading-->
												<div class="mb-13 text-center">
													<!--begin::Title-->
													<h1 class="mb-3">Transferencia entre socios</h1>
													<!--end::Title-->
													<!--begin::Description-->
													<div class="text-gray-400 fw-semibold fs-5">Saldo Disponible: &nbsp;
													<a class="fw-bold link-primary">$<?php echo format_number_miles_decimal($obj_earn_disponible);?></a></div>
													<!--end::Description-->
												</div>
												<!--end::Heading-->
												<!--begin::Input group-->
												<div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
													<!--begin::Label-->
													<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
														<span class="required">Usuario (receptor)</span>
													</label>
													<!--end::Label-->
													<input type="text"  name="username" id="username" onkeyup="this.value=Numtext(this.value)" onblur="validate_username_transfer(this.value);" class="form-control form-control-solid" placeholder="Ingresar usuario"  required>
													<span class="valid-feedback_username"></span>
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
													<!--begin::Label-->
													<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
														<span class="required">Importe</span>
													</label>
													<!--end::Label-->
													<input type="text"  name="amount" id="amount" class="form-control form-control-solid" placeholder="Ingresar importe"  required>
													<div class="fv-plugins-message-container valid-feedback"></div>
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
													<!--begin::Label-->
													<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
														<span class="required">PIN</span>
													</label>
													<!--end::Label-->
													<input type="password" class="form-control form-control-lg form-control-solid" name="pin" id="pin" minlength="6" maxlength="6" required/>
												</div>
												<!--end::Input group-->
												<!--begin::Actions-->
												<div class="text-center">
													<button type="submit" id="submit" class="btn btn-primary">
														<span class="indicator-label">Enviar</span>
													</button>
												</div>
												<!--end::Actions-->
												<div>
											</div>
											</form>
											<!--end:Form-->
										</div>
										<!--end::Modal body-->
									</div>
									<!--end::Modal content-->
								</div>
								<!--end::Modal dialog-->
							</div>
							<!--end::Modal - Support Center - Create Ticket-->
							<script src='<?php echo site_url().'assets/js/script/backoffice/pay_new.js?244';?>'></script>
							<script src='<?php echo site_url().'assets/js/script/backoffice/envios_new.js?1244';?>'></script>
							<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
					<!------------->
					<!--end::BODY-->
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






