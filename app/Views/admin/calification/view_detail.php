<!doctype html>
<html lang="es-PE">
<?php echo view("admin/head"); ?>

<body data-new-gr-c-s-check-loaded="14.1042.0" data-gr-ext-installed="">
    <?php echo view("admin/header"); ?>
    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">Calificados</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a
                                                href="<?php echo site_url()."dashboard/panel";?>">Panel</a></li>
                                        <li class="breadcrumb-item"><a></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Listado de </h5>
                                            <button class="btn btn-info" type="reset" onclick="cancel();"><i
                                                    class="fa fa-arrow-left" aria-hidden="true"></i>Regresar</button>
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
                                        <!-- begin total amount invoices pending-->
                                        <div class="row">
                                            <div class="col-md-6 col-xl-3">
                                                <div class="card theme-bg bitcoin-wallet" style="border-radius: 15px;">
                                                    <div class="card-block">
                                                        <h5 class="text-white mb-2">Viaje Nacional</h5>
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
                                            <div class="col-md-6 col-xl-3">
                                                <div class="card theme-bg bitcoin-wallet" style="border-radius: 15px;">
                                                    <div class="card-block">
                                                        <h5 class="text-white mb-2">Viaje Internacional</h5>
                                                    </div>
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
                                            <div class="col-md-6 col-xl-3">
                                                <div class="card theme-bg bitcoin-wallet" style="border-radius: 15px;">
                                                    <div class="card-block">
                                                        <h5 class="text-white mb-2">Bono Auto</h5>
                                                        <h3 class="text-white mb-2 f-w-300">
                                                            <?php echo format_number_moneda_soles($num_period_calification['num_period_car_cash']); ?>
                                                        </h3>
                                                        <i class="fa fa-car f-70 fa-4x text-white"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3">
                                                <div class="card theme-bg bitcoin-wallet" style="border-radius: 15px;">
                                                    <div class="card-block">
                                                        <h5 class="text-white mb-2">Bono Casa</h5>
                                                        <h3 class="text-white mb-2 f-w-300">
                                                            <?php echo format_number_moneda_soles($num_period_calification['num_period_house']); ?>
                                                        </h3>
                                                        <i class="fa fa-home f-70 fa-4x text-white"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end total amount invoices-->
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <div id="zero-configuration_wrapper"
                                                    class="dataTables_wrapper dt-bootstrap4">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div id="zero-configuration_wrapper"
                                                                class="dataTables_wrapper dt-bootstrap4">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <table id="zero-configuration"
                                                                            class="display table nowrap table-striped table-hover dataTable"
                                                                            style="width: 100%;" role="grid"
                                                                            aria-describedby="zero-configuration_info">
                                                                            <thead>
                                                                                <tr role="row">
                                                                                    <th>ID</th>
                                                                                    <th></th>
                                                                                    <th>Nombres</th>
                                                                                    <th>Usuario</th>
                                                                                    <th>Rango</th>
                                                                                    <th>Puntos Personales</th>
                                                                                    <th>Puntos Grupales</th>
                                                                                    <th>Fecha</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php foreach ($obj_calification as $value): ?>
                                                                                <tr>
                                                                                    <th><?php echo $value->id;?></th>
                                                                                    <td>
                                                                                        <img src="<?php echo site_url()."rangos/$value->range_id/$value->img";?>"
                                                                                            alt="<?php echo $value->range_name;?>"
                                                                                            width="50" />
                                                                                    </td>
                                                                                    <td><?php echo $value->name." ".$value->lastname;?>
                                                                                    </td>
                                                                                    <td><?php echo $value->username;?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <span class="label  label-info"
                                                                                            style="border-radius: 10px;"><?php echo $value->range_name;?></span>
                                                                                    </td>
                                                                                    <td><?php echo format_number_miles_decimal($value->personal_point);?>
                                                                                    </td>
                                                                                    <td><?php echo format_number_miles_decimal($value->group_point);?>
                                                                                    </td>
                                                                                    <td><?php echo formato_fecha_dia_mes_anio_abrev($value->date)."<br/>".formato_fecha_minutos($value->date);?>
                                                                                        hrs</td>
                                                                                </tr>
                                                                                <?php endforeach; ?>
                                                                            </tbody>
                                                                            <tfoot>
                                                                                <tr>
                                                                                    <th>ID</th>
                                                                                    <th></th>
                                                                                    <th>Nombres</th>
                                                                                    <th>Usuario</th>
                                                                                    <th>Rango</th>
                                                                                    <th>Puntos Personales</th>
                                                                                    <th>Puntos Grupales</th>
                                                                                    <th>Fecha</th>
                                                                                </tr>
                                                                            </tfoot>
                                                                        </table>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="<?php echo base_url('assets/admin/js/script/calification.js'); ?>"></script>
    <!-- [ Header ] end -->
    <!-- [ Main Content ] end -->
    <?php echo view("admin/footer"); ?>