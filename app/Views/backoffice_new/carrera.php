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
						<div class="row g-5">
							<div class="col-xl-3 mb-xl-10">
								<div class="card bgi-no-repeat h-xl-100" style="background-position: right top; background-size: 30% auto; background-image: url(<?php echo site_url() . "assets/metronic8/media/svg/shapes/abstract-1.svg"; ?>">
									<div class="card-body">
										<a href="#" class="card-title fw-bold text-muted text-hover-primary fs-4"><?php echo lang('Global.rango_actual'); ?></a>
										<div class="fs-2 fw-bold counted"><?php echo $obj_customer->range_name; ?></div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 mb-xl-10">
								<div class="card bgi-no-repeat h-xl-100">
									<div class="card-body" style="text-align: center;">
										<a class="card-title fw-bold text-muted text-hover-primary fs-4">L&iacute;neas directas activas</a>
										<div class="fs-2 fw-bold counted"><?php echo format_number_miles($total_active); ?></div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 mb-xl-10">
								<div class="card bgi-no-repeat h-xl-100">
									<div class="card-body" style="text-align: center;">
										<a class="card-title fw-bold text-muted text-hover-primary fs-4">Puntos Personales</a>
										<div class="fs-2 fw-bold counted"><?php echo format_number_miles($personal_point); ?></div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 mb-xl-10">
								<div class="card bgi-no-repeat h-xl-100">
									<div class="card-body" style="text-align: center;">
										<a class="card-title fw-bold text-muted text-hover-primary fs-4">Puntos Grupales</a>
										<div class="fs-2 fw-bold counted"><?php echo format_number_miles($point); ?></div>
									</div>
								</div>
							</div>
							</p>
						</div>
						<form class="form">
							<div class="card" style="margin-top: 1rem;">
								<div class="card-header">
									<div class="card-title fs-3 fw-bold"><?php echo lang('Global.plan_carrera'); ?><br></div>
								</div>
								<div class="card-body">
									<?php
									$key = 1;
									foreach ($obj_range as $key => $value) {  ?>
										<div class="row mb-12">
											<div class="col-xl-3">
												<div class="d-flex justify-content-between w-100 fs-4 mb-3">
													<img src="<?php echo site_url() . "rangos/$value->id" . "/" . $value->img; ?>" alt="<?php echo $value->name; ?>" width="80" style="border-radius: 5px;">
												</div>
											</div>
											<div class="col-xl-9">
												<div class="d-flex flex-column">
													<div class="d-flex justify-content-between w-100 mb-3">
														<span class="fs-4"><?php echo $value->name; ?></span>
														<span>
															<?php
															$total = $value->points;
															if ($point > $value->points) {
																echo format_number_miles($value->points) . " | ";
															} else {
																echo format_number_miles($point) . " | ";
															}
															?>
															<span class="fs-4"><b><?php echo format_number_miles($total); ?></b></span>
														</span>
													</div>
													<?php
													$range_points = $value->points == 0 ? 1 : $value->points;
													if (($point / $range_points) * 100 > 100) {
														$valor = 100;
													} else {
														$valor = ($point / $range_points) * 100;
													}
													?>
													<?php
													if ($obj_ranges_now->point <= $value->points) { ?>
														<div class="h-8px bg-bar rounded mb-3">
															<div class="bg-success rounded h-8px" role="progressbar" style="width: 
																				<?php echo $valor; ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
															</div>
														</div>
													<?php } ?>
													<div>
														<?php
														$missing = $range_points - $point;
														if ($obj_ranges_now->id >= $value->id) {
															echo lang('Global.felicidades_alcanzo');
														} else {
															if ($point >= $range_points) {
																echo lang('Global.felicidades_tiene');
															} else {
																echo lang('Global.te_faltan') . " " . $missing . " " . lang('Global.socios_calificacion');
															}
														}
														?>
														- <a onclick="show('<?php echo $value->id; ?>')" href="javascript:void(0);" style="color: var(--kt-success) !important">Condiciones</a>
													</div>
													<div class="text-gray-600">
														<span id="<?php echo $value->id; ?>" style="display:none"><?php echo $value->description; ?> <span>
														&nbsp;&nbsp;<a onclick="hide('<?php echo $value->id; ?>')" href="javascript:void(0);"><i class="fa fa-chevron-up"></i></a>
													</div>
												</div>
											</div>
										</div>

									<?php } ?>
								</div>
							</div>
						</form>
					</div>
				</div>
				<?php echo view("backoffice_new/footer"); ?>
			</div>
		</div>
	</div>
	<script>
		function show(id) {
			element = document.getElementById(id);
			element.style.display = "block";
		}

		function hide(id) {
			element = document.getElementById(id);
			element.style.display = "none";
		}
	</script>
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
	.bg-bar {
		background-color: var(--kt-text-muted);
	}
</style>