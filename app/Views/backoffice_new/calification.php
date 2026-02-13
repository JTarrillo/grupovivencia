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
					<div class="content flex-row-fluid" id="kt_content" data-select2-id="select2-data-kt_content">
						<div class="row g-xxl-9" data-select2-id="select2-data-217-k03t">
							<div class="col-xl-3 mb-xl-10 mb-5">
								<div class="card bgi-no-repeat h-xl-100" style="background-position: right top; background-size: 30% auto; background-image: url(<?php echo site_url() . "assets/metronic8/media/svg/shapes/abstract-1.svg"; ?>">
									<div class="card-body">
										<a class="card-title fw-bold text-muted text-hover-primary fs-4">Viaje Nacional</a>
										<div class="d-flex align-items-senter mt-2">
											<div class="ratings">
												<?php
												$total_travel = $num_period_calification['num_period_travel'];
												if ($total_travel > 5) {
													$total_travel = 5;
												} else {
													$total_travel = $total_travel;
												}
												$total_balance = 5 - $total_travel;
												//show star color
												for ($i = 1; $i <= $total_travel; $i++) { ?>
													<i class="fa fa-star rating-color"></i>
												<?php    }
												//show star
												for ($i = 1; $i <= $total_balance; $i++) { ?>
													<i class="fa fa-star"></i>
												<?php    } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 mb-xl-10 mb-5">
								<div class="card bgi-no-repeat h-xl-100" style="background-position: right top; background-size: 30% auto; background-image: url(<?php echo site_url() . "assets/metronic8/media/svg/shapes/abstract-1.svg"; ?>">
									<div class="card-body">
										<a class="card-title fw-bold text-muted text-hover-primary fs-4">Viaje Internacional</a>
										<div class="d-flex align-items-senter mt-2">
											<div class="ratings">
												<?php
												$total_travel = $num_period_calification['num_period_int_travel'];
												if ($total_travel > 5) {
													$total_travel = 5;
												}

												$total_balance = 5 - $total_travel;
												//show star color
												for ($i = 1; $i <= $total_travel; $i++) { ?>
													<i class="fa fa-star rating-color"></i>
												<?php    }
												//show star
												for ($i = 1; $i <= $total_balance; $i++) { ?>
													<i class="fa fa-star"></i>
												<?php    } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card">
							<div class="card-body flex-column p-5">
								<div class="card-rounded bg-light d-flex flex-stack flex-wrap p-5">
									<ul class="nav flex-wrap border-transparent fw-bold">
										<li class="nav-item my-1">
											<a class="btn btn-color-gray-600 fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase active"><?php echo lang('Global.detalle'); ?></a>
										</li>
									</ul>
									<form method="get" action="<?php echo site_url() . BACKOFFICE . "/calificacion"; ?>">
										<div class="menu">
											<div class="menu-item">
												<input name="search" class="form-control form-control-solid" placeholder="Pick date rage" id="kt_daterangepicker_1" />
											</div>
											<div class="m-0">
												<button type="submit" class="btn btn-primary fw-bold fs-8 fs-lg-base"><i class="fa fa-search"></i></button>
											</div>
										</div>
										<form>
								</div>
							</div>
							<div class="card-header mt-3 mb-3">
								<div id="table_filter" class="dataTables_filter">
									<label>Buscar:<input type="search" id="customSearch" class="form-control form-control-sm" placeholder="">
									</label>
								</div>
							</div>
							<div class="card-body">
								<table id="table" class="table align-middle table-row-dashed fs-6 gy-3">
									<thead role="row">
										<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
											<th class="min-w-90px">ID</th>
											<th class="min-w-90px"></th>
											<th class="min-w-100px">Cliente</th>
											<th class="min-w-150px pe-3">Usuario</th>
											<th class="min-w-100px pe-3">Rango</th>
											<th class="pe-3 min-w-100px">Pts. personales</th>
											<th class="pe-3 min-w-100px">Pts. Grupales</th>
											<th class="pe-3 min-w-100px">Fecha</th>
										</tr>
									</thead>
									<tbody class="fw-bold text-gray-600">
										<?php
										foreach ($obj_calification as $key => $value) { ?>
											<tr>
												<td>
													<?php echo $value->id; ?>
												</td>
												<td>
													<img src="<?php echo site_url() . "rangos/$value->range_id/$value->img"; ?>" alt="<?php echo $value->range_name; ?>" width="50" />
												</td>
												<td><?php echo $value->name . " " . $value->lastname; ?></td>
												<td><?php echo $value->username; ?></td>
												<td>
													<?php echo $value->range_name; ?>
												</td>
												<td><?php echo format_number_miles_decimal($value->personal_point); ?></td>
												<td><?php echo format_number_miles_decimal($value->group_point); ?></td>
												<td><?php echo formato_fecha_dia_mes_anio_abrev($value->date) . "<br/>" . formato_fecha_minutos($value->date); ?> hrs</td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<script>
					$(document).ready(function() {
						var table = $('#table').DataTable();
						$('#customSearch').on('keyup', function() {
							table.search(this.value).draw();
						});
					});
				</script>
				<?php echo view("backoffice_new/footer"); ?>
			</div>
		</div>
	</div>
	<style>
		.ratings {
			margin-right: 10px;
		}

		.ratings i {

			color: #cecece;
			font-size: 26px;
		}

		.rating-color {
			color: #fbc634 !important;
		}

		.review-count {
			font-weight: 400;
			margin-bottom: 2px;
			font-size: 24px !important;
		}

		.small-ratings i {
			color: #cecece;
		}

		.review-stat {
			font-weight: 300;
			font-size: 18px;
			margin-bottom: 2px;
		}
	</style>
	<script>
		$(document).ready(function() {
			$("#kt_daterangepicker_1").daterangepicker();
		});
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
	<script src="<?php echo site_url() . "assets/metronic8/plugins/custom/datatables/datatables.bundle.js?123"; ?>"></script>
	<script src="<?php echo site_url() . "assets/metronic8/plugins/custom/prismjs/prismjs.bundle.js"; ?>"></script>
	<script src="<?php echo site_url() . "assets/metronic8/js/widgets.bundle.js"; ?>"></script>
	<script src="<?php echo site_url() . "assets/metronic8/js/custom/widgets.js"; ?>"></script>
</body>

</html>