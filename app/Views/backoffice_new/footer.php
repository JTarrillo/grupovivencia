<script src="<?php echo site_url() . "assets/admin/lightbox/lightbox.js"; ?>"></script>
<!--begin::Footer-->
<div class="footer flex-lg-column" id="kt_footer">
    <!--begin::Container-->
    <div class="container-xxl d-flex flex-column flex-md-row align-items-center justify-content-between">
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1">
            <span class="item-black fw-semibold me-1"><?php echo date("Y"); ?>©</span>
            <a href="https://evox-lab.com/" target="_blank" class="text-gray-800 text-hover-primary">por Evox Lab</a>
        </div>
        <!--end::Copyright-->
        <!--begin::Menu-->
        <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
            <li class="menu-item">
                <a href="<?php echo site_url() . BACKOFFICE; ?>" class="menu-link px-2">Panel</a>
            </li>
            <li class="menu-item">
                <a href="<?php echo site_url() . BACKOFFICE . "/plan"; ?>" class="menu-link px-2"><?php echo lang('Global.productos'); ?></a>
            </li>
            <li class="menu-item">
                <a href="<?php echo site_url() . BACKOFFICE . "/cobros"; ?>" class="menu-link px-2"><?php echo lang('Global.cobros'); ?></a>
            </li>
            <li class="menu-item">
                <a href="<?php echo site_url() . BACKOFFICE . "/perfil"; ?>" class="menu-link px-2"><?php echo lang('Global.mi_perfil'); ?></a>
            </li>
            <li class="menu-item">
                <a href="<?php echo site_url() . BACKOFFICE . "/carrera"; ?>" class="menu-link px-2"><?php echo lang('Global.carrera'); ?></a>
            </li>
        </ul>
        <!--end::Menu-->
    </div>
    <!--end::Container-->
</div>
<!--end::Footer-->
<script>
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>