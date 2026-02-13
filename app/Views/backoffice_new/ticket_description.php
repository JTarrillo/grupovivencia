<!DOCTYPE html>
<html lang="en">
   <?php echo view("backoffice_new/head"); ?>
	<body data-kt-name="metronic" id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
		<script>if ( document.documentElement ) { const defaultThemeMode = "system"; const name = document.body.getAttribute("data-kt-name"); let themeMode = localStorage.getItem("kt_" + ( name !== null ? name + "_" : "" ) + "theme_mode_value"); if ( themeMode === null ) { if ( defaultThemeMode === "system" ) { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } else { themeMode = defaultThemeMode; } } document.documentElement.setAttribute("data-theme", themeMode); }</script>
		<div class="d-flex flex-column flex-root">
			<div class="page d-flex flex-row flex-column-fluid">
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
               		<?php echo view("backoffice_new/header"); ?>
					<?php echo view("backoffice_new/toolbar"); ?>
					  <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
						<div class="content flex-row-fluid" id="kt_content">
							<div class="card-rounded bg-light d-flex flex-stack flex-wrap p-5">
								<ul class="nav flex-wrap border-transparent fw-bold">
									<li class="nav-item my-1">
										<a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase active" href="<?php echo site_url().BACKOFFICE."/ticket";?>">tickets</a>
									</li>
								</ul>
								<a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_new_ticket" class="btn btn-primary fw-bold fs-8 fs-lg-base"><?php echo lang('Global.crear_ticket');?></a>
							</div>
							<div class="card">
								<div class="card-body">
									<div class="d-flex flex-column flex-xl-row p-7">
										<div class="flex-lg-row-fluid me-xl-15 mb-20 mb-xl-0">
											<div class="mb-0">
												<div class="d-flex align-items-center mb-12">
													<?php 
													if($obj_ticket->active == 1){ ?>
														<span class="svg-icon svg-icon-4qx svg-icon-warning ms-n2 me-3">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM16 13.5L12.5 13V10C12.5 9.4 12.6 9.5 12 9.5C11.4 9.5 11.5 9.4 11.5 10L11 13L8 13.5C7.4 13.5 7 13.4 7 14C7 14.6 7.4 14.5 8 14.5H11V18C11 18.6 11.4 19 12 19C12.6 19 12.5 18.6 12.5 18V14.5L16 14C16.6 14 17 14.6 17 14C17 13.4 16.6 13.5 16 13.5Z" fill="currentColor"></path>
																<rect x="11" y="19" width="10" height="2" rx="1" transform="rotate(-90 11 19)" fill="currentColor"></rect>
																<rect x="7" y="13" width="10" height="2" rx="1" fill="currentColor"></rect>
																<path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor"></path>
															</svg>
														</span>
													<?php }else{ ?>
														<span class="svg-icon svg-icon-4qx svg-icon-success ms-n2 me-3">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM11.7 17.7L16 14C16.4 13.6 16.4 12.9 16 12.5C15.6 12.1 15.4 12.6 15 13L11 16L9 15C8.6 14.6 8.4 14.1 8 14.5C7.6 14.9 8.1 15.6 8.5 16L10.3 17.7C10.5 17.9 10.8 18 11 18C11.2 18 11.5 17.9 11.7 17.7Z" fill="currentColor"></path>
																<path d="M10.4343 15.4343L9.25 14.25C8.83579 13.8358 8.16421 13.8358 7.75 14.25C7.33579 14.6642 7.33579 15.3358 7.75 15.75L10.2929 18.2929C10.6834 18.6834 11.3166 18.6834 11.7071 18.2929L16.25 13.75C16.6642 13.3358 16.6642 12.6642 16.25 12.25C15.8358 11.8358 15.1642 11.8358 14.75 12.25L11.5657 15.4343C11.2533 15.7467 10.7467 15.7467 10.4343 15.4343Z" fill="currentColor"></path>
																<path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor"></path>
															</svg>
														</span>
													<?php } ?>
													<div class="d-flex flex-column">
														<h1 class="text-gray-800 fw-semibold"><?php echo $obj_ticket->title;?></h1>
														<div class="">
															<span class="fw-semibold text-muted me-6"><?php echo lang('Global.estado');?>
																<a class="text-muted text-hover-primary">
																	<?php 
																	if($obj_ticket->active == 1){
																		echo lang('Global.en_espera');
																	}else{
																		echo lang('Global.procesado');
																	}
																	?>
																</a>
															</span>
															<span class="fw-semibold text-muted"><?php echo lang('Global.fecha');?>
															<span class="fw-bold text-gray-600 me-1"><?php echo formato_fecha_dia_mes_anio_abrev($obj_ticket->date);?></span></span>
														</div>
													</div>
												</div>
												<div class="mb-15">
													<div class="mb-15 fs-5 fw-normal text-gray-800">
														<div class="mb-10"><?php echo $obj_ticket->content;?></div>
													</div>
												</div>
												<div class="mb-15">
													<div class="mb-9">
														<div class="card card-bordered w-100">
															<div class="card-body">
																<div class="w-100 d-flex flex-stack mb-8">
																	<div class="d-flex align-items-center f">
																		<div class="symbol symbol-50px me-5">
																			<div class="symbol-label fs-1 fw-bold bg-light-success text-success">S</div>
																		</div>
																		<div class="d-flex flex-column fw-semibold fs-5 text-gray-600 text-dark">
																			<div class="d-flex align-items-center">
																				<a class="text-gray-800 fw-bold text-hover-primary fs-5 me-3">Soporte</a>
																				<span class="m-0"></span>
																			</div>
																		</div>
																	</div>
																	<div class="m-0">
																		<button class="btn btn-color-gray-400 btn-active-color-primary p-0 fw-bold"><?php echo lang('Global.respuesta');?></button>
																	</div>
																</div>
																<p class="fw-normal fs-5 text-gray-700 m-0"><?php echo $obj_ticket->response;?></p>
															</div>
														</div>
													</div>
													<a href="<?php echo site_url().BACKOFFICE."/ticket";?>" class="btn btn-sm btn-light btn-active-light-primary"><?php echo lang('Global.regresar');?></a>
												</div>
											</div>
										</div>
										<div class="flex-column flex-lg-row-auto w-100 mw-lg-300px mw-xxl-350px">
											<div class="card-rounded bg-primary bg-opacity-5 p-10 mb-15">
												<h2 class="text-dark fw-bold mb-11"><?php echo lang('Global.canales_apoyo');?></h2>
												<div class="d-flex align-items-center mb-10">
													<i class="bi bi-headphones text-primary fs-1 me-5"></i>
													<div class="d-flex flex-column">
														<h5 class="text-gray-800 fw-bold"><?php echo lang('Global.servicio_cliente');?></h5>
														<div class="fw-semibold">
															<span class="text-muted">atencionalempresario@mundo-network.com</span>
														</div>
													</div>
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
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
														<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
													</svg>
												</span>
											</div>
										</div>
										<div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
											<form name="ticket-form" enctype="multipart/form-data" method="post" action="javascript:void(0);" onsubmit="new_ticket();">
												<div class="mb-13 text-center">
													<h1 class="mb-3"><?php echo lang('Global.crear_ticket');?></h1>
												</div>
												<div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
													<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
														<span class="required"><?php echo lang('Global.asunto');?></span>
													</label>
													<select name="subject" id="subject" class="form-select form-select-solid" required>
														<option value="" data-select2-id="select2-data-12-icnj"><?php echo lang('Global.seleccionar_asunto');?></option>
														<?php 
															foreach ($obj_concepto_ticket as $value) { ?>
															<option value="<?php echo $value->id;?>"><?php echo $value->title;?></option>
														<?php }  ?>
													</select>
												<div class="fv-plugins-message-container invalid-feedback"></div></div>
												<div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
													<label class="fs-6 fw-semibold mb-2"><?php echo lang('Global.descripcion');?></label>
													<textarea class="form-control form-control-solid" rows="4" name="content" id="content" placeholder="<?php echo lang('Global.escribala_descripcion');?>" required></textarea>
												<div class="fv-plugins-message-container invalid-feedback"></div></div>
											<div class="row mb-6">
												<label class="col-lg-4 col-form-label fw-semibold fs-6"><?php echo lang('Global.seleccionar_imagen');?></label>
												<div class="col-lg-12">
													<div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('<?php echo site_url()."assets/metronic8/media/svg/avatars/blank.svg"?>')">
															<div class="image-input-wrapper w-125px h-125px" style="background-image: url('<?php echo site_url()."assets/metronic8/media/svg/files/doc.svg";?>')"></div>
														<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="<?php echo lang('Global.seleccionar_imagen');?>">
															<i class="bi bi-pencil-fill fs-7"></i>
															<input type="file" name="image_file" accept="*" required/>
														</label>
														<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
															<i class="bi bi-x fs-2"></i>
														</span>
													</div>
													<div class="form-text"><?php echo lang('Global.tipo_archivos_permitidos');?> png, jpg, jpeg. gif.</div>
												</div>
											</div>
												<div class="text-center">
													<button type="submit" id="submit" class="btn btn-primary">
														<span class="indicator-label"><?php echo lang('Global.enviar');?></span>
													</button>
												</div>
											<div></div></form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<script src='<?php echo site_url().'assets/js/script/backoffice/ticket_new.js?123';?>'></script>
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
		<script src="<?php echo site_url()."assets/metronic8/plugins/global/plugins.bundle.js";?>"></script>
		<script src="<?php echo site_url()."assets/metronic8/js/scripts.bundle.js";?>"></script>
		<script src="<?php echo site_url()."assets/metronic8/js/link_nav.js";?>"></script>
		<script src="<?php echo site_url()."assets/metronic8/plugins/custom/datatables/datatables.bundle.js";?>"></script>
		<script src="<?php echo site_url()."assets/metronic8/plugins/custom/prismjs/prismjs.bundle.js";?>"></script>
		<script src="<?php echo site_url()."assets/metronic8/js/widgets.bundle.js";?>"></script>
		<script src="<?php echo site_url()."assets/metronic8/js/custom/widgets.js";?>"></script>
	</body>
</html>






