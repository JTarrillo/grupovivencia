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
							<div class="card-body">
								<div class="d-flex flex-column flex-xl-row p-5">
									<div class="flex-lg-row-fluid me-xl-15 mb-20 mb-xl-0">
										<div class="modal-content rounded">
											<div class="modal-body scroll-y px-2 px-lg-15 pt-0 pb-15">
												<form name="ticket-form" enctype="multipart/form-data" method="post" action="javascript:void(0);" onsubmit="new_ticket();">
													<div class="mb-13 text-center">
														<h1 class="mb-3">¡Valoramos tus sugerencias!</h1>
														<br />
														<div class="text-gray-400 fw-semibold fs-5">En Mundo Network, siempre estamos buscando formas de mejorar y tu opinión es fundamental. Si tienes alguna sugerencia por favor, compártelo con nosotros.</div>
													</div>
													<div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
														<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
															<span class="required">Asunto</span>
														</label>
														<select name="subject" id="subject" class="form-select form-select-solid" required>
															<option value="" data-select2-id="select2-data-12-icnj"><?php echo lang('Global.seleccionar_asunto'); ?></option>
															<?php
															foreach ($obj_concepto_ticket as $value) { ?>
																<option value="<?php echo $value->id; ?>"><?php echo $value->title; ?></option>
															<?php }  ?>
														</select>
													</div>
													<div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
														<label class="fs-6 fw-semibold mb-2">Sugerencia</label>
														<textarea class="form-control form-control-solid" rows="4" name="content" id="content" placeholder="Ingresar sugerencia" required=""></textarea>
													</div>
													<div class="text-center">
														<button type="submit" id="submit" class="btn btn-primary">
															<span class="indicator-label">Enviar</span>
														</button>
													</div>
												</form>
											</div>
										</div>
									</div>
									<div class="flex-column flex-lg-row-auto w-100 mw-lg-300px mw-xxl-350px">
										<div class="card-rounded-2 bg-primary bg-opacity-5 p-10 mb-15">
											<h2 class="text-dark fw-bold mb-11"><?php echo lang('Global.canales_apoyo'); ?></h2>
											<div class="d-flex align-items-center mb-10">
												<i class="bi bi-headphones text-primary-2 fs-1 me-5"></i>
												<div class="d-flex flex-column">
													<h5 class="text-gray-800 fw-bold"><?php echo lang('Global.servicio_cliente'); ?></h5>
													<div class="fw-semibold">
														<span class="text-muted">contacto@alelifeglobal.com</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src='<?php echo site_url() . 'assets/backoffice/js/suggestions.js?123'; ?>'></script>
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

<style>
	.modal-content {
		background-color: var(--kt-bg-light);
	}
</style>