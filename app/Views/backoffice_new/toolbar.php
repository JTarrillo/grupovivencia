					<div class="toolbar py-5" id="kt_toolbar">
					    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
					        <div class="page-title d-flex flex-column me-3">
					            <h1 class="d-flex text-custom fw-bold my-1 fs-3"><?php echo $title; ?></h1>
					        </div>
					        <div class="page-title d-flex flex-column me-3" style="text-align: right;">
					            <span class="text-gray-900 pt-1 fw-semibold fs-6">
					                <?php
									if (isset($cart_count) && $cart_count) { ?>
					                <div class="btn btn-icon btn-custom w-md-40px h-md-40px btn-color-warning"
					                    data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
					                    <a href="<?php echo site_url() . "backoffice_new/planes/carrito"; ?>">
					                        <span class="svg-icon svg-icon-1">
					                            <i class="fa fa-shopping-bag  fa-2x" aria-hidden="true" style="font-size: 2rem;"></i>
					                        </span>
					                    </a>
					                </div>
					                <?php } ?>


					            </span>
					            <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?><br><?php echo isset($_SESSION['dni']) ? $_SESSION['dni'] : ''; ?>
					        </div>
					    </div>
					</div>