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
	<style>
		.boton {
			background-color: #4CAF50;
			color: white;
			font-size: 20px;
			padding: 15px 30px;
			border: none;
			border-radius: 10px;
			cursor: pointer;
			transition: transform 0.2s, box-shadow 0.2s;
		}

		/* Efecto de pulsación */
		.boton:active {
			transform: scale(0.9);
			box-shadow: 0px 0px 15px rgba(255, 255, 255, 0.5);
		}
	</style>

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

														<?php $price = $value->price; ?>

														<div class="text-center">

															<img src="<?php echo site_url() . "membresias/" . $value->id_membership . "/" . $value->img; ?>" altl="<?php echo $value->name; ?>" width="130" class="mb-10" style="border-radius:10px;">

															<div class="text-center">

																<span class="fs-2x fw-bold text-primary"><?php echo  $value->name; ?></span>

															</div>

														</div>

														<div class="mb-7 text-center">

															<div class="text-center">

																<span class="mb-2 ">S/</span>

																<span class="fs-2x fw-bold"><?php echo  format_number_miles_decimal($value->price); ?></span>  <span class="fw-semibold"><?php echo  format_number_miles($value->point);?> pts</span>

															</div>

															

														</div>

														<div class="w-100 mb-10 h-25 overflow-auto">
														

															<?php echo $value->description; ?>

														</div>

														<div>

															<div class="row d-flex">

																<div class="col-lg-4 fv-row flex-fill">

																	<input onchange="validationMax(event, '<?php echo $value->id_membership; ?>')" type="number" id="qty_<?php echo $value->id_membership; ?>" class="form-control form-control-lg mb-3 mb-lg-0 qty text" name="quantity" value="1" title="Qty" size="4" max="<?php echo $value->sale=='2'?$value->balance:"";?>" step="1" placeholder inputmode="Cantidad" autocomplete="off" />

																</div>

																<div class="col-lg-8 fv-row flex-fill">

																<?php 

																// sale free	


																if($value->sale == '1'){ ?>

																	<button type="button" onclick="add_cart_backoffice('<?php echo $value->id_membership; ?>', '<?php echo $value->name; ?>', '<?php echo $value->price; ?>', '<?php echo $value->contable; ?>', '<?php echo $value->point; ?>');" class="btn-primary btn fw-bold fs-8 fs-lg-base w-100 btn_add_cart"><i class="fa fa-shopping-cart"></i> <span id="txt_<?php echo $value->id_membership; ?>">Agregar</span></button>	

															<?php }else{

																	if($value->balance <= 0){ ?>

																		<button type="button" class="btn-success btn fw-bold fs-8 fs-lg-base w-100 btn_add_cart btn-danger" disabled=""><i class="fa fa-shopping-cart"></i> <span id="txt_7">No stock</span></button>

																	<?php }else{ ?>
																		<button type="button" onclick="add_cart_backoffice('<?php echo $value->id_membership; ?>', '<?php echo $value->name; ?>', '<?php echo $value->price; ?>', '<?php echo $value->contable; ?>', '<?php echo $value->point; ?>');" class="btn-primary btn fw-bold fs-8 fs-lg-base w-100 btn_add_cart"><i class="fa fa-shopping-cart"></i> <span id="txt_<?php echo $value->id_membership; ?>">Agregar</span></button>	
																		<br/>
																		<a id="<?php echo $value->id_membership; ?>" href="<?php echo site_url() . "backoffice_new/planes/carrito"; ?>" style="display:none;margin-top:5px;" class="boton btn-success btn fw-bold fs-8 fs-lg-base w-100"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> <span id="txt_<?php echo $value->id_membership; ?>">Finalizar</span></a>
																	<?php } 
																   } ?>

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

				<script src='<?php echo site_url() . 'assets/backoffice/js/plan_new.js?2024145678'; ?>'></script>

				<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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

	<script src="<?php echo site_url() . "assets/front/js/quantity.min.js?ver=2.0.4"; ?>" id="smartic-input-quantity-js"></script>

	<script>

		// Stepper lement

		var element = document.querySelector("#kt_stepper_example_vertical");



		// Initialize Stepper

		var stepper = new KTStepper(element);



		// Handle next step

		stepper.on("kt.stepper.next", function(stepper) {

			stepper.goNext(); // go next step

		});



		// Handle previous step

		stepper.on("kt.stepper.previous", function(stepper) {

			stepper.goPrevious(); // go previous step

		});

	</script>

</body>

</html>