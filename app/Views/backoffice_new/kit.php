<!DOCTYPE html>

<html lang="en">

<!--begin::Head-->

<?php echo view("backoffice_new/head"); ?>

<!--end::Head-->

<!--begin::Body-->



<body data-kt-name="metronic" id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">

	<!--begin::Theme mode setup on page load-->

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

				<!--Begin Toolbar-->

				<?php echo view("backoffice_new/toolbar"); ?>

				<!--End Toolbar-->

				<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">

					<div class="content flex-row-fluid" id="kt_content">

						<div class="card" id="kt_pricing">

							<div class="card-body p-lg-17">

								<div class="d-flex flex-column">

									<div class="mb-13 text-center">

										<h1 class="fs-2hx fw-bold mb-5"><?php echo lang('Global.elige_tu_producto'); ?></h1>

									</div>

									<div class="row g-10">

										<?php foreach ($obj_membership as $key => $value) { ?>

											<div class="col-xl-4">

												<div class="d-flex h-100 align-items-center">

													<div class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10" style="height: 700px !important;">

														<div class="text-center">

															<img src="<?php echo site_url() . "membresias/" . $value->id . "/" . $value->img; ?>" altl="<?php echo $value->name; ?>" width="130" class="mb-10">

															<div class="text-center">

																<span class="fw-bold text-primary" style="font-size: 16px;"><?php echo  $value->name; ?></span>

															</div>

														</div>

														<div class="mb-7 text-center">

															<div class="text-center">

																<span class="mb-2 text-primary">S/</span>

																<span class="fs-3x fw-bold text-primary"><?php echo  format_number_miles($value->price); ?></span>

															</div>

															<div class="text-gray-400 fw-semibold mb-5"><?php echo lang('Global.detalle_beneficios'); ?></div>

														</div>

														<div class="w-100 mb-10 h-25 overflow-auto">

															<?php echo $value->description; ?>

														</div>

														<div>

															<div class="row d-flex">

																<div class="col-lg-12 fv-row flex-fill">

																	<button type="button" id="a_<?php echo $value->id; ?>" onclick="add_cart('<?php echo $value->id; ?>', '<?php echo $value->name; ?>', '<?php echo $value->price; ?>', '<?php echo $value->contable; ?>', '<?php echo $value->point;?>',);" class="btn-success btn fw-bold fs-8 fs-lg-base w-100 btn_add_cart"><i class="fa fa-check"></i> <span id="txt_<?php echo $value->id; ?>">Seleccionar</span></button>

																	<a style="display:none;" href="<?php echo site_url() . "backoffice_new/kit/carrito"; ?>" id="aa_<?php echo $value->id; ?>" class="btn-warning btn fw-bold fs-8 fs-lg-base"><i class="fa fa-shopping-cart"></i>Seleccionar productos</a>

																</div>

															</div>

														</div>

													</div>

												</div>

											</div>

										<?php } ?>

									</div>

								</div>

							</div>

						</div>

					</div>

				</div>

				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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

	<script src="<?php echo site_url() . "assets/backoffice/js/kit_plan_new.js?202467"; ?>"></script>

	<script src="<?php echo site_url() . "assets/metronic8/plugins/global/plugins.bundle.js"; ?>"></script>

	<script src="<?php echo site_url() . "assets/metronic8/js/scripts.bundle.js"; ?>"></script>

	<script src="<?php echo site_url() . "assets/metronic8/js/link_nav.js"; ?>"></script>

	<script src="<?php echo site_url() . "assets/metronic8/plugins/custom/datatables/datatables.bundle.js"; ?>"></script>

	<script src="<?php echo site_url() . "assets/metronic8/plugins/custom/prismjs/prismjs.bundle.js"; ?>"></script>

	<script src="<?php echo site_url() . "assets/metronic8/js/widgets.bundle.js"; ?>"></script>

	<script src="<?php echo site_url() . "assets/metronic8/js/custom/widgets.js"; ?>"></script>

	<script src="<?php echo site_url() . "assets/front/js/quantity.min.js?ver=2.0.4"; ?>" id="smartic-input-quantity-js"></script>

</body>



</html>