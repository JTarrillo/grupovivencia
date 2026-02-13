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
										<a class="nav-link text-active-orange ms-0 me-10 py-5 active" href="<?php echo site_url() . BACKOFFICE . "/perfil"; ?>"><?php echo lang('Global.resumen'); ?></a>
									</li>
									<li class="nav-item mt-2">
										<a class="nav-link text-active-orange ms-0 me-10 py-5" href="<?php echo site_url() . BACKOFFICE . "/configuracion"; ?>"><?php echo lang('Global.configuración'); ?></a>
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
						<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
							<div class="card-header cursor-pointer">
								<div class="card-title m-0">
									<h3 class="fw-bold m-0">Detalles</h3>
								</div>
								<a href="<?php echo site_url() . BACKOFFICE . "/configuracion" ?>" class="btn btn-primary align-self-center"><?php echo lang('Global.editar_perfil'); ?></a>
							</div>
							<div class="card-body p-9">
								<div class="row mb-7">
									<label class="col-lg-4 fw-semibold text-muted"><?php echo lang('Global.nombre_completo'); ?></label>
									<div class="col-lg-8">
										<span class="fw-bold fs-6 text-gray-800"><?php echo $obj_customer->name . " " . $obj_customer->lastname; ?></span>
									</div>
								</div>
								
								<div class="row mb-7">
									<label class="col-lg-4 fw-semibold text-muted">Código</label>
									<div class="col-lg-8 fv-row">
										<span class="fw-semibold text-gray-800 fs-6"><?php echo $obj_customer->code; ?></span>
									</div>
								</div>
								<div class="row mb-7">
									<label class="col-lg-4 fw-semibold text-muted"><?php echo lang('Global.dni'); ?></label>
									<div class="col-lg-8">
										<a class="fw-semibold fs-6 text-gray-800 text-hover-primary"><?php echo $obj_customer->dni; ?></a>
									</div>
								</div>
								<div class="row mb-7">
									<label class="col-lg-4 fw-semibold text-muted">E-mail</label>
									<div class="col-lg-8">
										<a class="fw-semibold fs-6 text-gray-800 text-hover-primary"><?php echo $obj_customer->email; ?></a>
									</div>
								</div>
								<div class="row mb-7">
									<label class="col-lg-4 fw-semibold text-muted"><?php echo lang('Global.telefono'); ?></label>
									<div class="col-lg-8 d-flex align-items-center">
										<span class="fw-bold fs-6 text-gray-800 me-2">(<?php echo "+" . $obj_customer->id_wsp; ?>) <?php echo $obj_customer->phone; ?></span>
									</div>
								</div>
								

								<div class="row mb-7">
									<label class="col-lg-4 fw-semibold text-muted">Co Distribuidor</label>
									<div class="col-lg-8">
										<span class="fw-bold fs-6 text-gray-800"><?php echo $obj_customer->co_name; ?></span>
									</div>
								</div>
								<div class="row mb-7">
									<label class="col-lg-4 fw-semibold text-muted">Dni  Codistribuidor</label>
									<div class="col-lg-8">
										<span class="fw-bold fs-6 text-gray-800"><?php echo $obj_customer->co_dni; ?></span>
									</div>
								</div>


								<div class="row mb-7">
									<label class="col-lg-4 fw-semibold text-muted">Dirección</label>
									<div class="col-lg-8">
										<a class="fw-semibold fs-6 text-gray-800 text-hover-primary"><?php echo $obj_customer->address; ?></a>
									</div>
								</div>
								<div class="row mb-7">
									<label class="col-lg-4 fw-semibold text-muted"><?php echo lang('Global.pais'); ?>
										<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="<?php echo lang('Global.pais_residencia'); ?>"></i>
									</label>
									<div class="col-lg-8">
										<img src="<?php echo site_url() . 'assets/metronic8/media/flags/' . $obj_customer->img; ?>" width="20" alt="<?php echo $obj_customer->pais; ?>" style="border-radius:5px;">
									</div>
								</div>
								<div class="row mb-7">
									<label class="col-lg-4 fw-semibold text-muted"><?php echo lang('Global.fecha_registro'); ?></label>
									<div class="col-lg-8">
										<span class="fw-bold fs-6 text-gray-800"><?php echo formato_fecha_dia_mes_anio_abrev($obj_customer->created_at); ?></span>
									</div>
								</div>
								<div class="row mb-10">
									<label class="col-lg-4 fw-semibold text-muted"><?php echo lang('Global.estado'); ?></label>
									<div class="col-lg-8 d-flex align-items-center">
										<?php
										if ($obj_customer->active == 1) { ?>
											<span class="badge badge-success"><?php echo lang('Global.activo'); ?></span>
										<?php } else { ?>
											<span class="badge badge-danger"><?php echo lang('Global.inactivo'); ?></span>
										<?php } ?>
									</div>
								</div>
								<?php
								if ($obj_customer_bank != 1) { ?>
									<div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
										<span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
												<rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor"></rect>
												<rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"></rect>
											</svg>
										</span>
										<div class="d-flex flex-stack flex-grow-1">
											<div class="fw-semibold">
												<h4 class="text-gray-900 fw-bold"><?php echo lang('Global.su_atencion'); ?></h4>
												<div class="fs-6 text-gray-700"><?php echo lang('Global.para_recibir_comisiones'); ?></b>
													<a class="fw-bold item-white" href="<?php echo site_url() . BACKOFFICE . "/configuracion"; ?>"><?php echo lang('Global.agregar_informacion_cobro'); ?></a>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>
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
	<script src="<?php echo site_url() . "assets/metronic8/plugins/global/plugins.bundle.js"; ?>"></script>
	<script src="<?php echo site_url() . "assets/metronic8/js/scripts.bundle.js"; ?>"></script>
	<script src="<?php echo site_url() . "assets/metronic8/js/link_nav.js"; ?>"></script>
	<script src="<?php echo site_url() . "assets/metronic8/plugins/custom/datatables/datatables.bundle.js"; ?>"></script>
	<script src="<?php echo site_url() . "assets/metronic8/plugins/custom/prismjs/prismjs.bundle.js"; ?>"></script>
	<script src="<?php echo site_url() . "assets/metronic8/js/widgets.bundle.js"; ?>"></script>
	<script src="<?php echo site_url() . "assets/metronic8/js/custom/widgets.js"; ?>"></script>
</body>

</html>