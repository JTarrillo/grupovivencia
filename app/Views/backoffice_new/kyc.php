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
								<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
									<li class="nav-item mt-2">
										<a class="nav-link text-active-orange ms-0 me-10 py-5" href="<?php echo site_url() . BACKOFFICE . "/perfil"; ?>"><?php echo lang('Global.resumen'); ?></a>
									</li>
									<li class="nav-item mt-2">
										<a class="nav-link text-active-orange ms-0 me-10 py-5" href="<?php echo site_url() . BACKOFFICE . "/configuracion"; ?>"><?php echo lang('Global.configuración'); ?></a>
									</li>
									<li class="nav-item mt-2">
										<a class="nav-link text-active-orange ms-0 me-10 py-5 active" href="<?php echo site_url() . BACKOFFICE . "/kyc"; ?>">KYC</a>
									</li>
									<li class="nav-item mt-2">
										<a class="nav-link text-active-orange ms-0 me-10 py-5" href="<?php echo site_url() . BACKOFFICE . "/documentos"; ?>"><?php echo lang('Global.documentos'); ?></a>
									</li>
									<li class="nav-item mt-2">
										<a class="nav-link text-active-orange ms-0 me-10 py-5" href="<?php echo site_url() . BACKOFFICE . "/directos"; ?>"><?php echo lang('Global.equipo'); ?></a>
									</li>
								</ul>
							</div>
						</div>
						<div class="card mb-5 mb-xl-10">
							<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_connected_accounts" aria-expanded="true" aria-controls="kt_account_connected_accounts">
								<div class="card-title m-0">
									<h3 class="fw-bold m-0">KYC (<?php echo lang('Global.conozca_a_cliente'); ?>)</h3>
								</div>
							</div>
							<?php
							if ($obj_customer->kyc == "" || $obj_customer->kyc == 3 || $obj_customer->kyc == 0) { ?>
								<div id="kt_account_settings_connected_accounts" class="collapse show">
									<div class="card-body border-top p-9">
										<div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
											<span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
												<svg class="text-orange-mn" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path opacity="0.3" d="M22 19V17C22 16.4 21.6 16 21 16H8V3C8 2.4 7.6 2 7 2H5C4.4 2 4 2.4 4 3V19C4 19.6 4.4 20 5 20H21C21.6 20 22 19.6 22 19Z" fill="currentColor" />
													<path d="M20 5V21C20 21.6 19.6 22 19 22H17C16.4 22 16 21.6 16 21V8H8V4H19C19.6 4 20 4.4 20 5ZM3 8H4V4H3C2.4 4 2 4.4 2 5V7C2 7.6 2.4 8 3 8Z" fill="currentColor" />
												</svg>
											</span>
											<div class="d-flex flex-stack flex-grow-1">
												<div class="fw-semibold">
													<div class="fs-6 text-gray-700"><?php echo lang('Global.el_procedimiento_kyc'); ?></div>
												</div>
											</div>
										</div>
										<div class="border-top">
											<div class="notice d-flex rounded mb-9 p-6">
												<div class="d-flex flex-stack flex-grow-1">
													<div class="fw-semibold">
														<div class="fs-6 text-gray-700"><?php echo lang('Global.usa_documento_valido'); ?></div>
														<div class="fs-6 text-gray-700 pt-3"><b><?php echo lang('Global.recomendaciones'); ?></b><br /><br />
															- <?php echo lang('Global.documentos_originales'); ?><br />
															- <?php echo lang('Global.coloca_documentos'); ?><br />
															- <?php echo lang('Global.imagenes_legible'); ?><br />
															- <?php echo lang('Global.no_uses'); ?><br />
															- <?php echo lang('Global.no_uses_documentos'); ?></div>
													</div>
												</div>
											</div>
											<!--begin::Step 1-->
											<div class="current" data-kt-stepper-element="content">
												<div class="w-100">
													<div class="pb-10 pb-lg-15">
														<div class="text-muted fw-semibold fs-6"><?php echo lang('Global.solo_se_aceptaran'); ?></div>
													</div>
													<div class="fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
														<div class="row">
															<div class="col-lg-4">
																<input type="radio" class="btn-check" name="account_type" value="personal" id="kt_create_account_form_account_type_personal">
																<label class="btn btn-outline p-7 d-flex align-items-center mb-2" for="kt_create_account_form_account_type_personal">
																	<span class="svg-icon svg-icon-3x me-5">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<path d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z" fill="currentColor"></path>
																			<path opacity="0.3" d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z" fill="currentColor"></path>
																		</svg>
																	</span>
																	<span class="d-block fw-semibold text-start">
																		<span class="text-dark fw-bold d-block fs-4 mb-2"><?php echo lang('Global.documento_identidad'); ?></span>
																	</span>
																</label>
																<div class="fv-plugins-message-container invalid-feedback"></div>
															</div>
															<div class="col-lg-4 mb-2">
																<input type="radio" class="btn-check" name="account_type" value="corporate" id="kt_create_account_form_account_type_corporate">
																<label class="btn btn-outline p-7 d-flex align-items-center" for="kt_create_account_form_account_type_corporate">
																	<span class="svg-icon svg-icon-3x me-5">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<path d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z" fill="currentColor"></path>
																			<path opacity="0.3" d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z" fill="currentColor"></path>
																		</svg>
																	</span>
																	<span class="d-block fw-semibold text-start">
																		<span class="text-dark fw-bold d-block fs-4 mb-2"><?php echo lang('Global.pasaporte'); ?></span>
																	</span>
																</label>
															</div>
															<div class="col-lg-4">
																<input type="radio" class="btn-check" name="account_type" value="corporate" id="kt_create_account_form_account_type_corporate">
																<label class="btn btn-outline p-7 d-flex align-items-center" for="kt_create_account_form_account_type_corporate">
																	<span class="svg-icon svg-icon-3x me-5">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<path opacity="0.3" d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z" fill="currentColor"></path>
																			<path d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z" fill="currentColor"></path>
																		</svg>
																	</span>
																	<span class="d-block fw-semibold text-start">
																		<span class="text-dark fw-bold d-block fs-4 mb-2"><?php echo lang('Global.licencia_conducir'); ?></span>
																	</span>
																</label>
															</div>
															<form name="form-kyc" enctype="multipart/form-data" method="post" action="javascript:void(0);" onsubmit="validate_kyc();">
																<div class="row mb-6">
																	<label class="col-lg-2 col-form-label fw-semibold fs-6"><?php echo lang('Global.anverso'); ?></label>
																	<div class="col-lg-4">
																		<div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('<?php echo site_url() . "assets/metronic8/media/svg/avatars/blank.svg" ?>')">
																			<div class="image-input-wrapper w-125px h-125px" style="background-image: url(<?php echo site_url() . "assets/metronic8/media/svg/avatars/blank.svg" ?>)"></div>
																			<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Select Image">
																				<i class="bi bi-pencil-fill fs-7"></i>
																				<input type="file" name="img" accept=".png, .jpg, .jpeg, .gif" required />
																			</label>
																		</div>
																		<div class="form-text"><?php echo lang('Global.tipo_archivos_permitidos'); ?> png, jpg, jpeg.</div>
																	</div>
																	<label class="col-lg-2 col-form-label fw-semibold fs-6"><?php echo lang('Global.reverso'); ?></label>
																	<div class="col-lg-4">
																		<div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('<?php echo site_url() . "assets/metronic8/media/svg/avatars/blank.svg" ?>')">
																			<div class="image-input-wrapper w-125px h-125px" style="background-image: url(<?php echo site_url() . "assets/metronic8/media/svg/avatars/blank.svg" ?>)"></div>
																			<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
																				<i class="bi bi-pencil-fill fs-7"></i>
																				<input type="file" name="img2" accept=".png, .jpg, .jpeg, .gif" required />
																			</label>
																		</div>
																		<div class="form-text"><?php echo lang('Global.tipo_archivos_permitidos'); ?> png, jpg, jpeg.</div>
																	</div>
																</div>
																<div class="card-footer d-flex justify-content-end py-6 px-9">
																	<button id="submit_kyc" type="submit" class="btn btn-primary"><?php echo lang('Global.guardar'); ?></button>
																</div>
															</form>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php } else { ?>
								<div class="card-body border-top p-9">
									<?php
									if ($obj_customer->kyc == '1') { ?>
										<div class="col-sm-12">
											<div class="notice d-flex bg-light-warning rounded border-warning border mb-9 p-6">
												<span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path opacity="0.3" d="M22 19V17C22 16.4 21.6 16 21 16H8V3C8 2.4 7.6 2 7 2H5C4.4 2 4 2.4 4 3V19C4 19.6 4.4 20 5 20H21C21.6 20 22 19.6 22 19Z" fill="currentColor" />
														<path d="M20 5V21C20 21.6 19.6 22 19 22H17C16.4 22 16 21.6 16 21V8H8V4H19C19.6 4 20 4.4 20 5ZM3 8H4V4H3C2.4 4 2 4.4 2 5V7C2 7.6 2.4 8 3 8Z" fill="currentColor" />
													</svg>
												</span>
												<div class="d-flex flex-stack flex-grow-1">
													<div class="fw-semibold">
														<div class="fs-6 text-gray-700"><?php echo lang('Global.el_kyc_fue_enviado'); ?></div>
													</div>
												</div>
											</div>
										</div>
									<?php } elseif ($obj_customer->kyc == '2') { ?>
										<div class="col-sm-12">
											<div class="notice d-flex bg-light-success rounded border-success border mb-9 p-6">
												<span class="svg-icon svg-icon-2tx svg-icon-success me-4">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path opacity="0.3" d="M22 19V17C22 16.4 21.6 16 21 16H8V3C8 2.4 7.6 2 7 2H5C4.4 2 4 2.4 4 3V19C4 19.6 4.4 20 5 20H21C21.6 20 22 19.6 22 19Z" fill="currentColor" />
														<path d="M20 5V21C20 21.6 19.6 22 19 22H17C16.4 22 16 21.6 16 21V8H8V4H19C19.6 4 20 4.4 20 5ZM3 8H4V4H3C2.4 4 2 4.4 2 5V7C2 7.6 2.4 8 3 8Z" fill="currentColor" />
													</svg>
												</span>
												<div class="d-flex flex-stack flex-grow-1">
													<div class="fw-semibold">
														<div class="fs-6 text-gray-700"><?php echo lang('Global.kyc_validado'); ?></div>
													</div>
												</div>
											</div>
										</div>
									<?php } else { ?>
										<div class="col-sm-12">
											<div class="notice d-flex bg-light-danger rounded border-danger border mb-9 p-6">
												<span class="svg-icon svg-icon-2tx svg-icon-danger me-4">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path opacity="0.3" d="M22 19V17C22 16.4 21.6 16 21 16H8V3C8 2.4 7.6 2 7 2H5C4.4 2 4 2.4 4 3V19C4 19.6 4.4 20 5 20H21C21.6 20 22 19.6 22 19Z" fill="currentColor" />
														<path d="M20 5V21C20 21.6 19.6 22 19 22H17C16.4 22 16 21.6 16 21V8H8V4H19C19.6 4 20 4.4 20 5ZM3 8H4V4H3C2.4 4 2 4.4 2 5V7C2 7.6 2.4 8 3 8Z" fill="currentColor" />
													</svg>
												</span>
												<div class="d-flex flex-stack flex-grow-1">
													<div class="fw-semibold">
														<div class="fs-6 text-gray-700"><?php echo lang('Global.kyc_rechazado'); ?></div>
													</div>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
							<?php }
							?>
						</div>
					</div>
				</div>
				<script src='<?php echo site_url() . 'assets/js/script/backoffice/kyc_new.js?122'; ?>'></script>
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