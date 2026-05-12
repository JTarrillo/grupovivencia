<!doctype html>
<html>
<?php echo view("admin/head"); ?>

<body data-new-gr-c-s-check-loaded="14.1042.0" data-gr-ext-installed="">
    <?php echo view("admin/header"); ?>
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">Tablero</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a>Panel General</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row">
                                <!-- Sell Today-->
                                <div class="col-md-6 col-xl-3">
                                    <div class="card theme-bg bitcoin-wallet" style="border-radius: 15px;">
                                        <div class="card-block">
                                            <h5 class="text-white mb-2">Ventas Hoy</h5>
                                            <?php $sale_today = $obj_pending ? $obj_pending->sale_today : 0; ?>
                                            <h2 class="text-white mb-2 f-w-300">
                                                <?php echo format_number_moneda_soles($sale_today); ?></h2>
                                            <span class="d-block"><a class="text-white"
                                                    href="<?php echo site_url() . "dashboard/ventas"; ?>"><b
                                                        style="color:red">Ver</b></a></span>
                                            <i class="fa fa-credit-card f-70 fa-4x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- Total Sell-->
                                <div class="col-md-6 col-xl-3">
                                    <div class="card theme-bg2 bitcoin-wallet" style="border-radius: 15px;">
                                        <div class="card-block">
                                            <h5 class="text-white mb-2">Importe Total Ventas</h5>
                                            <?php $total_invest = $obj_pending ? $obj_pending->total_invest : 0; ?>
                                            <h2 class="text-white mb-2 f-w-300">
                                                <?php echo format_number_moneda_soles($total_invest); ?></h2>
                                            <span class="text-white d-block">Capitalización</span>
                                            <i class="fa fa-credit-card f-70 fa-4x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- Total 2% utility-->
                                <div class="col-md-6 col-xl-3">
                                    <div class="card theme-bg2 bitcoin-wallet" style="border-radius: 15px;">
                                        <div class="card-block">
                                            <h5 class="text-white mb-2">Club Diamantes 1%</h5>
                                            <?php $club_diamantes = (($total_invest / 2) * 0.02); ?>
                                            <h2 class="text-white mb-2 f-w-300">
                                                <?php echo format_number_moneda_soles($club_diamantes); ?></h2>
                                            <span class="text-white d-block">Utilidad de Todas los puntos</span>
                                            <a onclick="pago_fondo_global()"
                                                style="position: absolute; right: 0%; top: 10%;"
                                                class="btn btn-sm btn-success">Repartir</a>
                                            <i class="fa fa-credit-card f-70 fa-4x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- Total partners-->
                                <div class="col-md-12 col-xl-3">
                                    <div class="card theme-bg2 bitcoin-wallet" style="border-radius: 15px;">
                                        <div class="card-block">
                                            <h5 class="text-white mb-2">Socios</h5>
                                            <?php $total_customer = $obj_pending ? $obj_pending->total_customer : 0; ?>
                                            <h2 class="text-white mb-2 f-w-300">
                                                <?php echo format_number_miles($total_customer); ?></h2>
                                            <span class="text-white d-block">Total de socios registrados</span>
                                            <i class="fa fa-users f-70 fa-4x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- Ticket section-->
                                <div class="col-md-12 col-xl-3">
                                    <div class="card theme-bg2 visitor" style="border-radius: 15px;">
                                        <div class="card-block text-center">
                                            <h5 class="text-white m-0">Ticket</h5>
                                            <?php $total_ticket_pending = $obj_pending ? $obj_pending->total_ticket_pending : 0; ?>
                                            <h3 class="text-white m-t-20 f-w-300">
                                                <?php echo format_number_miles($total_ticket_pending); ?></h3>
                                            <a href="<?= site_url('dashboard/ticket') ?>" class="text-white"><span
                                                    class="text-white">Ticket Pendientes</span></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Pay section -->
                                <div class="col-md-12 col-xl-3">
                                    <div class="card theme-bg2 visitor" style="border-radius: 15px;">
                                        <div class="card-block text-center">
                                            <h5 class="text-white m-0">Pagos</h5>
                                            <?php $total_pay_pending = $obj_pending ? $obj_pending->total_pay_pending : 0; ?>
                                            <h3 class="text-white m-t-20 f-w-300">
                                                <?php echo format_number_miles($total_pay_pending); ?></h3>
                                            <a href="<?= site_url('dashboard/activar_pagos') ?>" class="text-white"><span
                                                    class="text-white">Pagos Pendientes</span></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Ranges section -->
                                <div class="col-md-12 col-xl-3">
                                    <div class="card theme-bg visitor" style="border-radius: 15px;">
                                        <div class="card-block text-center">
                                            <h5 class="text-white m-0">Nuevos Rangos</h5>
                                            <?php $total_new_range = $obj_pending ? $obj_pending->total_new_range : 0; ?>
                                            <h3 class="text-white m-t-20 f-w-300">
                                                <?php echo format_number_miles($total_new_range); ?></h3>
                                            <a href="<?= site_url('dashboard/nuevos_rangos') ?>" class="text-white"><span
                                                    class="text-white">Mes en Curso</span></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Buy Store -->
                                <div class="col-md-12 col-xl-3">
                                    <div class="card theme-bg visitor" style="border-radius: 15px;">
                                        <div class="card-block text-center">
                                            <h5 class="text-white m-0">Compra en Tienda</h5>
                                            <?php $total_invoice_compra_tienda = $obj_pending ? $obj_pending->total_invoice_compra_tienda : 0; ?>
                                            <h3 class="text-white m-t-20 f-w-300">
                                                <?php echo format_number_miles($total_invoice_compra_tienda); ?></h3>
                                            <a href="<?= site_url('dashboard/pago_tienda') ?>" class="text-white"><span
                                                    class="text-white">Ver</span></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Comments section-->
                                <div class="col-md-12 col-xl-3">
                                    <div class="card theme-bg2 visitor" style="border-radius: 15px;">
                                        <div class="card-block text-center">
                                            <h5 class="text-white m-0">Comentarios</h5>
                                            <?php $total_comments_pending = $obj_pending ? $obj_pending->total_comments_pending : 0; ?>
                                            <h3 class="text-white m-t-20 f-w-300">
                                                <?php echo format_number_miles($total_comments_pending); ?></h3>
                                            <a href="<?= site_url('dashboard/comentarios') ?>" class="text-white"><span
                                                    class="text-white">Comentarios sin atender</span></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Suggestions section-->
                                <div class="col-md-12 col-xl-3">
                                    <div class="card theme-bg2 visitor" style="border-radius: 15px;">
                                        <div class="card-block text-center">
                                            <h5 class="text-white m-0">Sugerencias</h5>
                                            <?php $total_suggestions = $obj_pending ? $obj_pending->total_suggestions : 0; ?>
                                            <h3 class="text-white m-t-20 f-w-300">
                                                <?php echo format_number_miles($total_suggestions); ?></h3>
                                            <a href="<?= site_url('dashboard/sugerencias') ?>" class="text-white"><span
                                                    class="text-white">Ver</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Begin Chart -->
                            <div class="col-xl-12 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Ventas por Mes <b>(activos)</b></h5>
                                    </div>
                                    <div class="card-block">
                                        <div>
                                            <canvas id="myChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ End Chart ] -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="<?php echo site_url() . "assets/admin/js/script/panel.js"; ?>"></script>
    <script>
    const ctx = document.getElementById('myChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Set', 'Oct', 'Nov', 'Dic'],
            datasets: [{
                label: 'Ventas S/',
                <?php
               $total_ene = $obj_pending ? $obj_pending->total_ene : 0;
               $total_feb = $obj_pending ? $obj_pending->total_feb : 0;
               $total_mar = $obj_pending ? $obj_pending->total_mar : 0;
               $total_abr = $obj_pending ? $obj_pending->total_abr : 0;
               $total_may = $obj_pending ? $obj_pending->total_may : 0;
               $total_jun = $obj_pending ? $obj_pending->total_jun : 0;
               $total_jul = $obj_pending ? $obj_pending->total_jul : 0;
               $total_ago = $obj_pending ? $obj_pending->total_ago : 0;
               $total_set = $obj_pending ? $obj_pending->total_set : 0;
               $total_oct = $obj_pending ? $obj_pending->total_oct : 0;
               $total_nov = $obj_pending ? $obj_pending->total_nov : 0;
               $total_dic = $obj_pending ? $obj_pending->total_dic : 0;
               ?>
                data: [<?php echo $total_ene; ?>, <?php echo $total_feb; ?>, <?php echo $total_mar; ?>,
                    <?php echo $total_abr; ?>, <?php echo $total_may; ?>, <?php echo $total_jun; ?>,
                    <?php echo $total_jul; ?>, <?php echo $total_ago; ?>, <?php echo $total_set; ?>,
                    <?php echo $total_oct; ?>, <?php echo $total_nov; ?>, <?php echo $total_dic; ?>
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
    <!-- [ Header ] end -->
    <!-- [ Main Content ] end -->
    <?php echo view("admin/footer"); ?>