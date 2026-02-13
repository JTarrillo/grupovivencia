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
								<div class="d-flex flex-column flex-xl-row">
									<div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
										<div class="card mb-5 mb-xl-8">
											<div class="card-body pt-15">
												<div class="d-flex flex-center flex-column mb-5">
													<div class="symbol symbol-150px symbol-circle mb-7">
														<?php 
															if($obj_customer->avatar != ""){ ?>
																	<img src="<?php echo site_url()."avatar/".$obj_customer->id."/".$obj_customer->avatar;?>" alt="avatar">
																<?php }else{ ?>
																	<img src="<?php echo site_url()."assets/metronic8/media/avatars/300-1.jpg";?>" alt="Avatar">
															<?php } ?>
													</div>
													<a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1"><?php echo $obj_customer->name . " " . $obj_customer->lastname;?></a>
													<a href="#" class="fs-5 fw-semibold text-muted text-hover-primary mb-6"><?php echo $obj_customer->code;?></a>
												</div>
												<div class="d-flex flex-stack fs-4 py-3">
													<div class="fw-bold">Estado</div>
													<?php
													// $obj_customer->active = 0;
													if ($obj_customer->active == 1) {
														echo ("<div class='badge badge-light-success d-inline'>Activo</div>");
													} else {
														echo ("<div class='badge badge-light-danger d-inline'>Inactivo</div>");
													}
													?>
												</div>
												<div class="separator separator-dashed my-3"></div>
												<div class="pb-5 fs-6">
													<div class="fw-bold mt-5">Email</div>
													<div class="text-gray-600">
														<a class="text-gray-600 text-hover-primary"><?php echo $obj_customer->email; ?></a>
													</div>
													<div class="fw-bold mt-5"><?php echo lang('Global.dni');?></div>
													<div class="text-gray-600">
														<?php echo $obj_customer->dni; ?>
													</div>
													<div class="fw-bold mt-5"><?php echo lang('Global.telefono');?></div>
													<div class="text-gray-600">
														<?php echo $obj_customer->phone; ?>
													</div>
													<div class="fw-bold mt-5"><?php echo lang('Global.pais');?></div>
													<div class="text-gray-600">
														<img src="<?php echo site_url() . 'assets/metronic8/media/flags/' . $obj_customer->img; ?>" width="20" alt="<?php echo $obj_customer->pais; ?>"  style="border-radius:5px;">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="flex-lg-row-fluid ms-lg-15">
										<div class="tab-content" id="myTabContent">
											<div class="tab-pane fade show active" id="kt_ecommerce_customer_overview" role="tabpanel">
												<div class="card pt-4 mb-6 mb-xl-9">
													<div class="card-header border-0">
														<div class="card-title">
															<h2><?php echo lang('Global.compras');?></h2>
														</div>
													</div>
													<div class="card-body pt-0 pb-5">
														<div id="kt_table_customers_payment_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
																	<div class="table-responsive">
																	<?php 
																	if(count($obj_invoices) > 0){ ?>
																		<table id="table" class="table align-middle table-row-dashed gy-5 dataTable no-footer">
																			<thead class="border-bottom border-gray-200 fs-7 fw-bold">
																				<tr class="text-start text-muted text-uppercase gs-0">
																					<th class="min-w-100px sorting" tabindex="0" style="width: 144.9px;">ID</th>
																					<th class="min-w-150px">Concepto</th>
																					<th class="min-w-150px"><?php echo lang('Global.fecha');?></th>
																					<th class="min-w-100px"><?php echo lang('Global.importe');?></th>
																					<th class="min-w-100px"><?php echo lang('Global.estado');?></th>
																					<th class="min-w-200px"><?php echo lang('Global.acciones');?></th>
																				</tr>
																			</thead>
																			<tbody class="fs-6 fw-semibold text-gray-600">
																				<?php 
																				foreach ($obj_invoices as $key => $value) { ?>
																					<tr class="odd">
																						<td>
																							<a class="text-gray-600 text-hover-primary mb-1">
																								<?php echo $value->id; ?>
																							</a>
																						</td>
																						<td>
																						<?php 
																						if($value->membership){ 
																							echo $value->membership;
																						}else{ ?>
																							Recompra
																						<?php  } ?>
																						
																						</td>
																						<td><?php echo formato_fecha_dia_mes_anio_abrev($value->date)." ".formato_fecha_minutos($value->date);?></td>
																						<td><?php echo format_number_moneda_soles($value->amount);?></td>
																						<td>
																							<?php 
																								if ($value->active == 1) { ?>
																									<div class='badge badge-light-warning'>
																										<?php echo lang('Global.en_espera');?>
																									</div>
																							<?php } elseif($value->active == 2) { ?>
																									<div class='badge badge-light-success'>
																										<?php echo lang('Global.procesado');?>
																									</div>
																							<?php }else{ ?>
																									<div class='badge badge-light-danger'>
																										<?php echo lang('Global.rechazado');?>
																									</div>
																							<?php } ?>
																						</td>
																						<td>
																						<a href="<?php echo site_url().BACKOFFICE."/facturas/$value->id" ?>" class="btn btn-sm btn-light btn-active-light-primary"><?php echo lang('Global.ver');?></a>
																						<!--delete option when in pending-->			
																						<?php if($value->active == 1){ ?>
																							<a href="javascript:void(0);" onclick="delete_invoice('<?php echo $value->id;?>');" class="btn btn-sm btn-light btn-active-light-primary" title="Eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>
																						<?php } ?>
																						</td>
																					</tr>
																				<?php } ?>
																			</tbody>
																		</table>
																		<?php }else{ ?>
																	<img src="<?php echo site_url()."assets/metronic8/media/illustrations/sketchy-1/20.png"?>" alt="Imagen" class="mw-200 mh-200px mh-lg-375px mb-lg-n12">
																<?php } ?>
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
		<!--customer js-->
		<script src='<?php echo site_url() . 'assets/backoffice/js/invoices.js'; ?>'></script>

		<script src="<?php echo site_url()."assets/metronic8/plugins/global/plugins.bundle.js";?>"></script>
		<script src="<?php echo site_url()."assets/metronic8/js/scripts.bundle.js";?>"></script>
		<script src="<?php echo site_url()."assets/metronic8/js/link_nav.js";?>"></script>
		<script src="<?php echo site_url()."assets/metronic8/plugins/custom/datatables/datatables.bundle.js?123";?>"></script>
		<script src="<?php echo site_url()."assets/metronic8/plugins/custom/prismjs/prismjs.bundle.js";?>"></script>
		<script src="<?php echo site_url()."assets/metronic8/js/widgets.bundle.js";?>"></script>
		<script src="<?php echo site_url()."assets/metronic8/js/custom/widgets.js";?>"></script>
	</body>
</html>






