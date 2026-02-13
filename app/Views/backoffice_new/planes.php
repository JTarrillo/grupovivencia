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
                                        // Ordenar proyectos por id DESC
                                        usort($projects, function($a, $b) {
                                            return $b['id'] <=> $a['id'];
                                        });
                                        foreach($projects as $project) {
                                    ?>
                                    <div class="col-xl-4 col-md-6 mb-5">
                                        <div class="card shadow-sm h-100">
                                            <div
                                                class="card-body d-flex flex-column align-items-center justify-content-center">
                                                <img src="<?php echo site_url() . (!empty($project['image']) ? $project['image'] : 'assets/project_images/default.png'); ?>"
                                                    alt="<?php echo $project['name']; ?>" width="260" height="180"
                                                    class="mb-4 shadow-lg"
                                                    style="border-radius:18px;object-fit:cover;max-width:100%;max-height:180px;box-shadow:0 4px 24px #0002;">
                                                <h4 class="fw-bold text-primary text-center mb-2"
                                                    style="font-size:1.35rem;">
                                                    <?php echo $project['name']; ?>
                                                </h4>
                                                <div class="mb-2 text-center">
                                                    <span class="fw-semibold">Ubicación:</span>
                                                    <?php echo $project['location']; ?><br>
                                                    <span class="fw-semibold">Tasa de Interés:</span>
                                                    <?php echo $project['base_interest_rate']; ?>%
                                                </div>
                                                <?php
                                                // Mostrar resumen de lotes
                                                $LotModel = new \App\Models\LotModel();
                                                $lotes = $LotModel->where('project_id', $project['id'])->findAll();
                                                $total_lotes = count($lotes);
                                                $libres = 0;
                                                $vendidos = 0;
                                                foreach ($lotes as $lote) {
                                                    $estado = strtolower($lote['status']);
                                                    if ($estado === 'disponible' || $estado === 'available') {
                                                        $libres++;
                                                    } elseif ($estado === 'vendido' || $estado === 'sold') {
                                                        $vendidos++;
                                                    }
                                                }
                                                ?>
                                                <div class="mb-2 text-center">
                                                    <span class="badge bg-gradient-info px-3 py-2 me-1">Total lotes:
                                                        <?php echo $total_lotes; ?></span>
                                                    <span class="badge bg-gradient-success px-3 py-2 me-1">Libres:
                                                        <?php echo $libres; ?></span>
                                                    <span class="badge bg-gradient-dark px-3 py-2">Vendidos:
                                                        <?php echo $vendidos; ?></span>
                                                </div>
                                                <?php if ($total_lotes == 0) { ?>
                                                <span class="badge bg-secondary px-4 py-2 mb-2">Sin lotes</span>
                                                <?php } elseif ($libres == 0) { ?>
                                                <span class="badge bg-danger px-4 py-2 mb-2">Agotado</span>
                                                <?php } ?>
                                                <a href="<?php echo site_url() . 'backoffice_new/planes/carrito?project_id=' . $project['id']; ?>"
                                                    class="btn btn-success w-100 mb-2"
                                                    style="font-size:1.1rem;padding:12px 0;"
                                                    <?php if ($libres == 0 || $total_lotes == 0) echo 'disabled'; ?>>
                                                    <i class="fa fa-search"></i> Ver Lotes
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
    <!-- Scripts necesarios para menú y modales -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo site_url() . 'assets/metronic8/plugins/global/plugins.bundle.js'; ?>"></script>
    <script src="<?php echo site_url() . 'assets/metronic8/js/scripts.bundle.js'; ?>"></script>
    <script src="<?php echo site_url() . 'assets/metronic8/js/link_nav.js'; ?>"></script>
    <script src="<?php echo site_url() . 'assets/backoffice/js/plan_new.js?2024'; ?>"></script>
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
    // Inicializar DataTables si existe la tabla y jQuery/DataTables están disponibles
    document.addEventListener('DOMContentLoaded', function() {
        if (window.jQuery && typeof $.fn.DataTable === 'function' && $('.datatable').length) {
            $('.datatable').DataTable();
        }
    });
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

<!-- ...existing code... -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="<?php echo site_url() . 'assets/backoffice/js/plan_new.js?2024'; ?>"></script>
<!-- ...otros scripts necesarios y bien ubicados... -->
</body>

</html>