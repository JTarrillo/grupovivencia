<!DOCTYPE html>
<html lang="en">
<?php echo view("backoffice_new/head"); ?>

<body data-kt-name="metronic" id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
    <?php echo view("backoffice_new/header"); ?>
    <?php echo view("backoffice_new/toolbar"); ?>
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
                    <div class="content flex-row-fluid" id="kt_content">
                        <div class="card" id="kt_pricing">
                            <div class="card-header text-center d-flex justify-content-center align-items-center">
                                <h4>Proyectos Inmobiliarios</h4>
                            </div>
                            <div class="card-body">
                                <div class="row g-10">
                                    <?php if(isset($projects) && count($projects) > 0) {
                                        foreach($projects as $project) {
                                    ?>
                                    <div class="col-xl-4 col-md-6 mb-5">
                                        <div class="card shadow-sm h-100">
                                            <div
                                                class="card-body d-flex flex-column align-items-center justify-content-center">
                                                <img src="<?php echo site_url() . (!empty($project['image']) ? $project['image'] : 'assets/project_images/default.png'); ?>"
                                                    alt="<?php echo $project['name']; ?>" width="100" class="mb-4"
                                                    style="border-radius:10px;object-fit:cover;">
                                                <h5 class="fw-bold text-primary text-center mb-2">
                                                    <?php echo $project['name']; ?></h5>
                                                <div class="mb-2 text-center">
                                                    <span class="fw-semibold">Ubicación:</span>
                                                    <?php echo $project['location']; ?><br>
                                                    <span class="fw-semibold">Tasa de Interés:</span>
                                                    <?php echo $project['base_interest_rate']; ?>%
                                                </div>
                                                <div class="mb-2 text-center">
                                                    <span class="fw-semibold">Estado:</span>
                                                    <?php echo $project['status']; ?>
                                                </div>
                                                <a href="<?php echo site_url('projects/view/'.$project['id']); ?>"
                                                    class="btn btn-primary mt-auto mb-2">Ver Detalles</a>

                                                <button type="button"
                                                    onclick="add_cart_project('<?php echo $project['id']; ?>', '<?php echo $project['name']; ?>', '<?php echo $project['base_interest_rate']; ?>');"
                                                    class="btn btn-success w-100 mb-2">
                                                    <i class="fa fa-shopping-cart"></i> Agregar
                                                </button>
                                                <a id="finalizar_<?php echo $project['id']; ?>"
                                                    href="<?php echo site_url() . 'backoffice_new/planes/carrito'; ?>"
                                                    style="display:none;" class="btn btn-warning w-100">
                                                    <i class="fa fa-credit-card-alt" aria-hidden="true"></i> Finalizar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }
                                    } else {
                                    ?>
                                    <div class="col-12 text-center">
                                        <div class="alert alert-info">No hay proyectos inmobiliarios registrados.</div>
                                    </div>
                                    <?php }
                                    ?>
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

    <script>
    function add_cart_project(id, name, price) {
        console.log('add_cart_project:', {
            id,
            name,
            price
        });
        $.ajax({
            url: '<?php echo site_url('backoffice_new/planes/add_cart_product'); ?>',
            type: 'POST',
            data: {
                id: id,
                name: name,
                price: price,
                qty: 1,
                point: 0,
                img: '',
                project_id: id // <-- Se envía el id como project_id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $("#finalizar_" + id).show();
                } else {
                    alert('No se pudo agregar al carrito');
                }
            },
            error: function() {
                alert('Error de conexión');
            }
        });
    }
    </script>
</body>

</html>
</div>
</div>
</div>


</div>

</div>

</div>

</div>

</div>

<script src='<?php echo site_url() . 'assets/backoffice/js/plan_new.js?2024145678'; ?>'>
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js">
</script>
</div>

</div>

</div>

</div>

<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">

    <span class="svg-icon">

        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">

            <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)"
                fill="currentColor" />

            <path
                d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                fill="currentColor" />

        </svg>

    </span>

</div>

<script src="<?php echo site_url() . "assets/metronic8/plugins/global/plugins.bundle.js"; ?>">
</script>
<script src="<?php echo site_url() . "assets/metronic8/js/scripts.bundle.js"; ?>">
</script>
<script src="<?php echo site_url() . "assets/metronic8/js/link_nav.js"; ?>">
</script>
<script src="<?php echo site_url() . "assets/metronic8/plugins/custom/datatables/datatables.bundle.js"; ?>">
</script>
<script src="<?php echo site_url() . "assets/metronic8/plugins/custom/prismjs/prismjs.bundle.js"; ?>">
</script>
<script src="<?php echo site_url() . "assets/metronic8/js/widgets.bundle.js"; ?>">
</script>
<script src="<?php echo site_url() . "assets/metronic8/js/custom/widgets.js"; ?>">
</script>
<script src="<?php echo site_url() . "assets/front/js/quantity.min.js?ver=2.0.4"; ?>" id="smartic-input-quantity-js">
</script>
<script>
// Stepper lement
var element =
    document
    .querySelector(
        "#kt_stepper_example_vertical"
    );
// Initialize Stepper
var stepper =
    new KTStepper(
        element
    );
// Handle next step
stepper
    .on("kt.stepper.next",
        function(
            stepper
        ) {
            stepper
                .goNext(); // go next step
        }
    );
// Handle previous step
stepper
    .on("kt.stepper.previous",
        function(
            stepper
        ) {
            stepper
                .goPrevious(); // go previous step
        }
    );
</script>


</body>

</html>