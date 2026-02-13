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
                            <div class="col-xl-12 mb-xl-10 mb-5">
                                <div class="card bgi-no-repeat h-xl-100">
                                    <div class="card-body" style="border-radius:10px;">
                                        <div class="fs-2 fw-bold counted">
                                            <?php 
                                                $total = 0;
                                                if (!empty($obj_commissions)) {
                                                    foreach ($obj_commissions as $c) {
                                                        $total += isset($c['monto']) ? $c['monto'] : 0;
                                                    }
                                                }
                                                echo 'S/ ' . number_format($total, 2);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-5">
                                <div class="card-header pt-7">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label text-dark">Historial de Comisiones</span>
                                    </h3>
                                </div>
                                <div class="card-header mt-3 mb-3">
                                    <div id="table_filter" class="dataTables_filter">
                                        <label>Buscar:<input type="search" id="customSearch"
                                                class="form-control form-control-sm" placeholder="">
                                        </label>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="table" class="table align-middle table-row-dashed fs-6 gy-3">
                                        <thead>
                                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                <th class="min-w-90px">ID</th>
                                                <th class="min-w-100px">Tipo</th>
                                                <th class="min-w-150px">Fecha</th>
                                                <th class="min-w-100px">Monto</th>
                                                
                                                <th class="min-w-100px">Estado</th>
                                            </tr>

                                        </thead>
                                        <tbody class="fw-bold text-gray-600">
                                            <?php if (!empty($obj_commissions)): ?>
                                            <?php foreach ($obj_commissions as $i => $comision): ?>
                                            <tr>
                                                <td><?= isset($comision['id']) ? $comision['id'] : ($i + 1) ?></td>
                                                <td>
                                                    <?php
                                                    if (isset($comision['tipo_comision'])) {
                                                        echo ($comision['tipo_comision'] === 'venta_base') ? 'Venta de Lote' : ucfirst($comision['tipo_comision']);
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?= isset($comision['fecha_generada']) ? date('d/m/Y H:i', strtotime($comision['fecha_generada'])) : '-' ?>
                                                </td>
                                                <td>
                                                    <?php if (isset($comision['monto'])): ?>
                                                    <span class="text-success">S/
                                                        <?= number_format($comision['monto'], 2) ?></span>
                                                    <?php else: ?>
                                                    -
                                                    <?php endif; ?>
                                                </td>
                                                
                                                <td>
                                                    <?php if (isset($comision['estado'])): ?>
                                                    <?php if ($comision['estado'] === 'aprobada'): ?>
                                                    <span
                                                        class="badge py-3 px-4 fs-7 badge-light-warning">Aprobada</span>
                                                    <?php elseif ($comision['estado'] === 'pagada'): ?>
                                                    <span class="badge py-3 px-4 fs-7 badge-light-success">Pagada</span>
                                                    <?php else: ?>
                                                    <span class="badge py-3 px-4 fs-7 badge-light-secondary">Otro</span>
                                                    <?php endif; ?>
                                                    <?php else: ?>
                                                    <span class="badge py-3 px-4 fs-7 badge-light-secondary">-</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center">No hay comisiones registradas.</td>
                                            </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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
    <script src="<?php echo site_url() . 'assets/metronic8/plugins/global/plugins.bundle.js'; ?>"></script>
    <script src="<?php echo site_url() . 'assets/metronic8/js/scripts.bundle.js'; ?>"></script>
    <script src="<?php echo site_url() . 'assets/metronic8/js/link_nav.js'; ?>"></script>
    <script src="<?php echo site_url() . 'assets/metronic8/plugins/custom/datatables/datatables.bundle.js'; ?>">
    </script>
    <script src="<?php echo site_url() . 'assets/metronic8/plugins/custom/prismjs/prismjs.bundle.js'; ?>"></script>
    <script src="<?php echo site_url() . 'assets/metronic8/js/widgets.bundle.js'; ?>"></script>
    <script src="<?php echo site_url() . 'assets/metronic8/js/custom/widgets.js'; ?>"></script>
    <script src="<?php echo site_url() . 'assets/front/js/quantity.min.js?ver=2.0.4'; ?>"
        id="smartic-input-quantity-js"></script>
</body>

</html>