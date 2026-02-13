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
										<a class="nav-link text-active-orange ms-0 me-10 py-5 active" href="<?php echo site_url() . BACKOFFICE . "/documentos"; ?>"><?php echo lang('Global.documentos'); ?></a>
									</li>
									<li class="nav-item mt-2">
										<a class="nav-link text-active-orange ms-0 me-10 py-5" href="<?php echo site_url() . BACKOFFICE . "/directos"; ?>"><?php echo lang('Global.equipo'); ?></a>
									</li>
								</ul>
							</div>
						</div>
						<div class="d-flex flex-wrap flex-stack mb-6">
							<h3 class="fw-bold my-2"><?php echo lang('Global.documentos'); ?>
						</div>
						<div class="row g-6 g-xl-9 mb-6 mb-xl-9">
							<div class="col-md-6 col-lg-4 col-xl-3">
								<div class="card h-100">
									<div class="card-body d-flex justify-content-center text-center flex-column p-8">
										<a href="<?php echo site_url() . BACKOFFICE . "/documentos/presentacion"; ?>" class="text-gray-800 text-hover-primary d-flex flex-column">
											<div class="symbol symbol-75px mb-5">
												<img src="<?php echo site_url() . "assets/metronic8/media/svg/files/folder-document.svg"; ?>" class="theme-light-show" alt="">
												<img src="<?php echo site_url() . "assets/metronic8/media/svg/files/folder-document-dark.svg"; ?>" class="theme-dark-show" alt="">
											</div>
											<div class="fs-5 fw-bold mb-2 item-black-2">Empresa</div>
										</a>
										<div class="fs-7 fw-semibold text-gray-400">2 <?php echo lang('Global.archivos'); ?></div>
									</div>
								</div>
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