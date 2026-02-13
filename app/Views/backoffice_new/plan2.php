<!DOCTYPE html>
<html lang="en">
<?php echo view("backoffice_new/head"); ?>
<body data-kt-name="metronic" id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php echo view("backoffice_new/header"); ?>
                <?php echo view("backoffice_new/toolbar"); ?>
                <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
                    <div class="content flex-row-fluid" id="kt_content">
                        <div class="card" id="kt_pricing">
                            <div class="card-header text-center d-flex justify-content-center align-items-center">
                                <h4>Compra personalizada (Prueba)</h4>
                            </div>
                            <div class="card-body d-flex justify-content-center">
                                <div class="row">
                                    <div class="col text-center">
                                        <a href="<?php echo site_url() . 'backoffice_new/kit'; ?>" class="btn btn-lg text-white btn-kit-option btn-kit-option-custom" style="width: 200px;background-color: var(--kt-header-menu-link-active-bg-color)">Kit de afiliación</a>
                                        <a href="<?php echo site_url() . 'backoffice_new/planes'; ?>" class="btn btn-lg text-white btn-kit-option btn-kit-option-custom" style="width: 200px; background-color: #009ef7; margin-left: 1rem;">Compras</a>
                                    </div>
                                    <span class="mt-10 legend-option" style="color: #888;">
                                        <b>Kit de afiliación:</b> Selecciona tu kit y prueba el flujo.<br />
                                    </span>
                                    <span class="mt-2" style="color: #888;">
                                        <b>Arma tu compra:</b> Selecciona productos y prueba la lógica de comisiones y validaciones.<br />
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo view("backoffice_new/footer"); ?>
            </div>
        </div>
    </div>
    <script src="<?php echo site_url() . 'assets/backoffice/js/plan_new.js?2024'; ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>
</html>
