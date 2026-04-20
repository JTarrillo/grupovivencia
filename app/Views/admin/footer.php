<script src="<?php echo site_url()."assets/admin/js/vendor-all.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/js/bootstrap.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/js/pcoded.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/js/amcharts.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/js/serial.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/js/pie.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/js/datatables.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/js/bl-datatable-custom.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/lightbox/lightbox.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/js/inputmask.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/js/jquery.inputmask.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/js/autoNumeric.js";?>"></script>
<script src="<?php echo site_url()."assets/admin/js/form-masking-custom.js";?>"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script>
// Compatibilidad global: asegura que la X/cerrar funcione en modales aunque falte data-dismiss
$(document).on('click', '.modal .close, .modal [data-dismiss="modal"], .modal [data-bs-dismiss="modal"]', function (e) {
	var $modal = $(this).closest('.modal');
	if (!$modal.length) {
		return;
	}

	e.preventDefault();

	// Bootstrap 4 (jQuery plugin)
	if (typeof $modal.modal === 'function') {
		$modal.modal('hide');
		return;
	}

	// Fallback seguro
	$modal.removeClass('show').hide();
	$('body').removeClass('modal-open').css('padding-right', '');
	$('.modal-backdrop').remove();
});
</script>
</body>
</html>