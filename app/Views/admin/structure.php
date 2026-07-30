<?php
$session = session();
$privilegio = (string) $session->get('privilegio');
$viewerName = trim((string) ($session->get('first_name') . ' ' . $session->get('last_name')));
if ($viewerName === '') {
    $viewerName = (string) ($session->get('name') ?: 'Usuario');
}

$selectedCustomer = $obj_customer ?? null;
$readField = static function ($source, string $field, $default = '') {
    if (is_array($source) && array_key_exists($field, $source)) {
        return $source[$field];
    }

    if (is_object($source) && isset($source->{$field})) {
        return $source->{$field};
    }

    return $default;
};

$selectedCustomerDni = (string) $readField($selectedCustomer, 'dni', '');
$selectedCustomerName = trim((string) $readField($selectedCustomer, 'name', '') . ' ' . (string) $readField($selectedCustomer, 'lastname', ''));
$selectedCustomerType = (string) $readField($selectedCustomer, 'tipo_agente', '');
$selectedCustomerActive = (string) $readField($selectedCustomer, 'active', '');
$selectedCustomerRange = (string) $readField($selectedCustomer, 'range_name', '');
$selectedCustomerPersonalPoints = $readField($selectedCustomer, 'point_personal', 0);
$selectedCustomerGroupPoints = $readField($selectedCustomer, 'point_grupal', 0);
$selectedCustomerInscripcion = (bool) $readField($selectedCustomer, 'inscripcion_vigente', false);
$directCount = is_array($obj_customer_n2 ?? null) ? count($obj_customer_n2) : 0;
?>
<!DOCTYPE html>
<html lang="en-US">
<?php echo view("admin/head"); ?>

<body data-new-gr-c-s-check-loaded="14.1042.0" data-gr-ext-installed="">
    <?php echo view("admin/header"); ?>
    <script>
    // Log para depuración: muestra el array completo de referidos directos en la consola cada vez que se recarga
    <?php
    if (isset($obj_customer_n2)) {
        echo "console.log('Referidos directos:', " . json_encode($obj_customer_n2) . ");";
    }
    ?>
    </script>
    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">Explorador de Red Inmobiliaria</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard/">Panel</a></li>
                                        <li class="breadcrumb-item"><a>Estructura de Agentes</a></li>
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
                                        <div class="card-header border-0 pb-0">
                                            <div class="row align-items-stretch">
                                                <div class="col-lg-5 mb-3">
                                                    <div class="p-3 h-100"
                                                        style="background:#f6f9fc;border:1px solid #e7edf3;border-radius:14px;">
                                                        <div
                                                            class="d-flex justify-content-between align-items-start mb-2">
                                                            <div>
                                                                <div class="text-muted" style="font-size:12px;">Estas
                                                                    navegando como usuario del panel</div>
                                                                <div style="font-weight:700;font-size:18px;">
                                                                    <?php echo esc($viewerName); ?></div>
                                                            </div>
                                                            <span
                                                                class="badge badge-info"><?php echo esc($privilegio !== '' ? $privilegio : 'usuario'); ?></span>
                                                        </div>
                                                        <div class="text-muted mb-2" style="font-size:13px;">
                                                            Desde aqui puedes elegir cualquier cliente o patrocinador de
                                                            la tabla <code>customers</code> y ver su arbol.
                                                        </div>
                                                        <div class="d-flex flex-wrap">
                                                            <span
                                                                class="badge badge-light-primary mr-2 mb-2">Seleccionado:
                                                                <?php echo esc($selectedCustomerDni !== '' ? $selectedCustomerDni : 'sin DNI'); ?></span>
                                                            <span
                                                                class="badge badge-light-info mr-2 mb-2"><?php echo esc($selectedCustomerType === 'externo' ? 'Agente Externo' : 'Agente Interno'); ?></span>
                                                            <span
                                                                class="badge badge-light-<?php echo $selectedCustomerActive === '1' ? 'success' : 'danger'; ?> mr-2 mb-2"><?php echo $selectedCustomerActive === '1' ? 'Activo' : 'Inactivo'; ?></span>
                                                            <span
                                                                class="badge badge-light-secondary mr-2 mb-2">Directos:
                                                                <?php echo $directCount; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 mb-3">
                                                    <div class="p-3 h-100"
                                                        style="background:#ffffff;border:1px solid #e7edf3;border-radius:14px;">
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <div class="text-muted mb-1" style="font-size:12px;">
                                                                    Agente o patrocinador seleccionado</div>
                                                                <div style="font-weight:700;font-size:18px;">
                                                                    <?php echo esc($selectedCustomerName !== '' ? $selectedCustomerName : 'Sin seleccion'); ?>
                                                                </div>
                                                                <div class="text-muted">
                                                                    <?php echo esc($selectedCustomerRange !== '' ? $selectedCustomerRange : 'Sin rango'); ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5 text-md-right mt-2 mt-md-0">
                                                                <div class="text-muted" style="font-size:12px;">Puntos
                                                                </div>
                                                                <div>Personal:
                                                                    <b><?php echo esc(format_number_miles($selectedCustomerPersonalPoints)); ?></b>
                                                                </div>
                                                                <div>Grupal:
                                                                    <b><?php echo esc(format_number_miles($selectedCustomerGroupPoints)); ?></b>
                                                                </div>
                                                                <?php if ($selectedCustomerType === 'externo'): ?>
                                                                <div class="mt-1">
                                                                    <span
                                                                        class="badge badge-<?php echo $selectedCustomerInscripcion ? 'success' : 'danger'; ?>">
                                                                        <?php echo $selectedCustomerInscripcion ? 'Inscripcion vigente' : 'Inscripcion vencida'; ?>
                                                                    </span>
                                                                </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $data = array();
                                                        foreach ($obj_customer_button_search as $value) {
                                                           $data[] = array(
                                                              'label' => $value->dni . " (" . $value->name . " " . $value->lastname . ")",
                                                              'value' => $value->id
                                                           );
                                                        }
                                                        ?>
                                                        <form method="get"
                                                            action="<?php echo site_url() . "dashboard/estructura"; ?>"
                                                            class="mt-3">
                                                            <label class="mb-1" style="font-weight:600;">Buscar
                                                                patrocinador o cliente</label>
                                                            <div class="input-group">
                                                                <input type="search"
                                                                    class="form-control search-customer" id="search"
                                                                    name="search"
                                                                    placeholder="Ej: 29323012 (Fiorela ...)"
                                                                    aria-label="Search">
                                                                <div class="input-group-append">
                                                                    <button type="submit" title="Buscar"
                                                                        class="btn btn-outline-primary">
                                                                        <i class="fa fa-search"></i> Ir
                                                                    </button>
                                                                    <button type="button" class="btn btn-primary"
                                                                        id="openCustomerTreeSelector"
                                                                        onclick="openCustomerTreeSelectorModal();"
                                                                        data-toggle="modal"
                                                                        data-target="#modalCustomerTreeSelector"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#modalCustomerTreeSelector">
                                                                        <i class="fa fa-sitemap"></i> Ver arbol
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <style>
                                        #modal-content-structure {
                                            border-radius: 15px;
                                        }

                                        .img-customer-structure {
                                            border-radius: 5px;
                                        }

                                        .tree * {
                                            margin: 0;
                                            padding: 0;
                                        }

                                        .tree {
                                            margin: 0 auto;
                                        }

                                        .zoomViewport {
                                            width: 100%;
                                        }

                                        .zoomContainer {
                                            margin: 0 auto;
                                        }

                                        .tree ul {
                                            padding-top: 20px !important;
                                            position: relative !important;
                                        }

                                        .tree li {
                                            float: left !important;
                                            text-align: center !important;
                                            list-style-type: none !important;
                                            position: relative !important;
                                            padding: 10px 0px 0px 1px !important;
                                            transition: all 0.5s !important;
                                            -webkit-transition: all 0.5s !important;
                                            -moz-transition: all 0.5s !important;
                                        }

                                        /*We will use ::before and ::after to draw the connectors*/

                                        .tree li::before,
                                        .tree li::after {
                                            content: '';
                                            position: absolute !important;
                                            top: 0 !important;
                                            right: 50% !important;
                                            border-top: 1px solid #a5a5a5 !important;
                                            width: 50% !important;
                                            height: 20px !important;
                                        }

                                        .tree li::after {
                                            right: auto !important;
                                            left: 50% !important;
                                            border-left: 1px solid #a5a5a5 !important;
                                        }

                                        /*We need to remove left-right connectors from elements without
                                 any siblings*/
                                        .tree li:only-child::after,
                                        .tree li:only-child::before {
                                            display: none !important;
                                        }

                                        /*Remove space from the top of single children*/
                                        .tree li:only-child {
                                            padding-top: 0 !important;
                                        }

                                        /*Remove left connector from first child and
                                 right connector from last child*/
                                        .tree li:first-child::before,
                                        .tree li:last-child::after {
                                            border: 0 none !important;
                                        }

                                        /*Adding back the vertical connector to the last nodes*/
                                        .tree li:last-child::before {
                                            border-right: 1px solid #a5a5a5 !important;
                                            border-radius: 0 5px 0 0 !important;
                                            -webkit-border-radius: 0 5px 0 0 !important;
                                            -moz-border-radius: 0 5px 0 0 !important;
                                        }

                                        .tree li:first-child::after {
                                            border-radius: 5px 0 0 0 !important;
                                            -webkit-border-radius: 5px 0 0 0 !important;
                                            -moz-border-radius: 5px 0 0 0 !important;
                                        }

                                        /*Time to add downward connectors from parents*/
                                        .tree ul ul::before {
                                            content: '';
                                            position: absolute !important;
                                            top: 0 !important;
                                            left: 50% !important;
                                            border-left: 1px solid #a5a5a5 !important;
                                            width: 0 !important;
                                            height: 20px !important;
                                        }

                                        .tree li a {
                                            text-decoration: none !important;
                                            color: #000 !important;
                                            font-weight: 600 !important;
                                            display: inline-block !important;
                                            border-radius: 5px !important;
                                            -webkit-border-radius: 5px !important;
                                            -moz-border-radius: 5px !important;

                                            transition: all 0.5s !important;
                                            -webkit-transition: all 0.5s !important;
                                            -moz-transition: all 0.5s !important;
                                        }

                                        .card-structure {
                                            box-shadow: none !important;
                                            border: none !important;
                                        }
                                        </style>
                                        <!-- end filter -->
                                        <div class="card-block">
                                            <div class="card-body">
                                                <div role="toolbar" class="btn-toolbar d-flex">
                                                    <div class="p-1 input-group">
                                                        <div class="input-group-append">
                                                            <a title="inicio"
                                                                href="<?php echo site_url() . "dashboard/estructura"; ?>"
                                                                type="submit" class="btn btn-dark"
                                                                style="color:white;border-radius:5px 0px 0px 5px;"><i
                                                                    class="fa fa-home"></i></a>
                                                            <a title="regresar" href="javascript:history.back()"
                                                                type="submit" class="btn btn-dark"
                                                                style="color:white;"><i class="fa fa-undo"></i></a>
                                                            <a title="subir" id="up" onclick="up('<?php echo $id; ?>');"
                                                                class="btn btn-dark" style="color:white;"><i
                                                                    class="fa fa-chevron-up"></i></a>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="d-flex flex-grow-1 justify-content-end p-1 align-items-center">
                                                        <span class="text-muted" style="font-size:13px;">
                                                            Tip: selecciona un cliente desde el buscador superior para
                                                            navegar su arbol.
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Color personalizado más oscuro que GOLD -->
                                        <div class="row">
                                            <div class="col-md-12 col-xl-12">
                                                <div class="element-box" style="overflow-x: scroll;">
                                                    <div class="tree" style="padding: 0px !important;width:max-content">
                                                        <div class="card card-structure widget">
                                                            <ul class="arvore" style="padding-bottom: 80px">
                                                                <li>
                                                                    <div>
                                                                        <!-- NIVEL 1 (Agente principal) -->
                                                                        <ul class="init"
                                                                            style="padding-top: 0px !important;">
                                                                            <li>
                                                                                <a href="javascript:void(0);">
                                                                                    <div id="level-0">
                                                                                        <?php
                                                                 if ($readField($selectedCustomer, 'range_img', '')) { ?>
                                                                                        <img src='<?php echo site_url() . "rangos/" . $readField($selectedCustomer, 'range_id', '') . "/" . $readField($selectedCustomer, 'range_img', ''); ?>'
                                                                                            alt="Rango"
                                                                                            class="img-responsive symbol symbol-30px symbol-md-40px img-customer-structure"
                                                                                            style="width: 40px;">
                                                                                        <?php } else {
                                                                     if (!$readField($selectedCustomer, 'avatar', null)) { ?>
                                                                                        <img src='<?php echo site_url() . "assets/metronic8/media/avatars/300-1.jpg"; ?>'
                                                                                            alt="avatar"
                                                                                            class="img-responsive symbol symbol-30px symbol-md-40px img-customer-structure"
                                                                                            style="width: 40px;">
                                                                                        <?php } else { ?>
                                                                                        <img src='<?php echo site_url() . "avatar/" . $readField($selectedCustomer, 'id', '') . "/" . $readField($selectedCustomer, 'avatar', ''); ?>'
                                                                                            alt="avatar"
                                                                                            class="img-responsive symbol symbol-30px symbol-md-40px img-customer-structure"
                                                                                            style="width: 40px;">
                                                                                        <?php }
                                                                  }  ?>
                                                                                    </div>
                                                                                </a>
                                                                                <br />
                                                                                <?php
                                                               $active = $readField($selectedCustomer, 'active', '');
                                                               $point_personal = $readField($selectedCustomer, 'point_personal', 0);
                                                               if($active == '1'){
                                                                   if($point_personal >= 500){
                                                                    $color = '#9B00FF';
                                                                    $style = "btn-light-purple";
                                                                   }else{
                                                                    $color = 'green';
                                                                    $style = "btn-light-success";
                                                                   }
                                                               }else{
                                                                   $color = 'red';
                                                                   $style = "btn-light-danger";
                                                               }
                                                            ?>
                                                                                <a style="color:<?php echo $color; ?>!important;font-size: 10px;"
                                                                                    class="btn btn-sm fs-9 py-1 px-1"
                                                                                    href="#"
                                                                                    onclick="show_info('<?php echo esc($readField($selectedCustomer, 'name', '')); ?>', '<?php echo esc($readField($selectedCustomer, 'lastname', '')); ?>', '<?php echo esc($readField($selectedCustomer, 'dni', '')); ?>', '<?php echo esc($readField($selectedCustomer, 'range_name', '')); ?>', '<?php echo esc($readField($selectedCustomer, 'active', '')); ?>', '<?php echo esc($readField($selectedCustomer, 'pais_img', '')); ?>', '<?php echo esc(format_number_miles($readField($selectedCustomer, 'point_personal', 0))); ?>', '<?php echo esc(format_number_miles($readField($selectedCustomer, 'point_grupal', 0))); ?>');"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#kt_modal_info"><?php echo esc($readField($selectedCustomer, 'dni', '')); ?><br /><?php echo esc($readField($selectedCustomer, 'name', '')); ?></a>
                                                                                <!-- NIVEL 2 (Afiliados directos) -->
                                                                                <?php if (count($obj_customer_n2) > 0) { ?>
                                                                                <ul>
                                                                                    <?php foreach ($obj_customer_n2 as $value) { ?>
                                                                                    <li>
                                                                                        <a href="<?php echo site_url('dashboard/estructura/' . $value->customer_id2); ?>"
                                                                                            class="d-inline-block">
                                                                                            <div id="level-1">
                                                                                                <?php
                                                                             if ($value->range_img) { ?>
                                                                                                <img src='<?php echo site_url() . "rangos/$value->range_id/$value->range_img"; ?>'
                                                                                                    alt="Rango"
                                                                                                    class="img-responsive symbol symbol-30px symbol-md-40px"
                                                                                                    style="width: 40px;">
                                                                                                <?php } else {
                                                                                if (is_null($value->avatar)) { ?>
                                                                                                <img src='<?php echo site_url() . "assets/metronic8/media/avatars/300-1.jpg"; ?>'
                                                                                                    alt="avatar"
                                                                                                    class="img-responsive symbol symbol-30px symbol-md-40px"
                                                                                                    style="width: 40px;;">
                                                                                                <?php } else { ?>
                                                                                                <img src='<?php echo site_url() . "avatar/" . $value->customer_id2 . "/" . $value->avatar; ?>'
                                                                                                    alt="avatar"
                                                                                                    class="img-responsive symbol symbol-30px symbol-md-40px"
                                                                                                    style="width: 40px;;">
                                                                                                <?php } ?>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </a>
                                                                                        <?php
                                                                           if($value->active == '1'){
                                                                                 if($value->point_personal >= 500){
                                                                                    $color = '#9B00FF';
                                                                                    $style = "btn-light-purple";
                                                                                 }else{
                                                                                    $color = 'green';
                                                                                    $style = "btn-light-success";
                                                                                 }
                                                                           }else{
                                                                                 $color = 'red';
                                                                                 $style = "btn-light-danger";
                                                                           }
                                                                        ?>
                                                                                        <a href="#"
                                                                                            style="color:<?php echo $color; ?> !important;font-size: 10px;"
                                                                                            class="btn btn-sm fs-9 py-1 px-1"
                                                                                            onclick="show_info('<?php echo $value->name; ?>', '<?php echo $value->lastname; ?>', '<?php echo $value->dni; ?>', '<?php echo $value->range_name; ?>', '<?php echo $value->active; ?>', '<?php echo $value->pais_img; ?>', '<?php echo format_number_miles($value->point_personal); ?>', '<?php echo format_number_miles($value->point_grupal); ?>');"
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-target="#kt_modal_info"><?php echo $value->dni; ?><br /><?php echo $value->name; ?></a>
                                                                                    </li>
                                                                                    <?php } ?>
                                                                                </ul>
                                                                                <?php } ?>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="kt_modal_info" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered mw-750px">
                                                <div class="modal-content" id="modal-content-structure">
                                                    <div class="modal-header pb-0 border-0 justify-content-end">
                                                        <div class="btn btn-sm btn-icon btn-active-color-primary"
                                                            data-bs-dismiss="modal">
                                                            <span class="svg-icon svg-icon-1">
                                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <rect opacity="0.5" x="6" y="17.3137" width="16"
                                                                        height="2" rx="1"
                                                                        transform="rotate(-45 6 17.3137)"
                                                                        fill="currentColor"></rect>
                                                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                                        transform="rotate(45 7.41422 6)"
                                                                        fill="currentColor"></rect>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                                                        <form>
                                                            <div class="mb-20 text-center">
                                                                <h3 class="mb-3">Información de Socio</h3>
                                                                <div id="i_country"></div>
                                                            </div>
                                                            <div
                                                                class="py-2 d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                                                                <label
                                                                    class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                    <span>Nombre Completo</span>
                                                                </label>
                                                                <input type="text" name="i_name" id="i_name"
                                                                    class="form-control form-control-solid" readonly>
                                                            </div>
                                                            <div
                                                                class="py-2 d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                                                                <label
                                                                    class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                    <span>Usuario</span>
                                                                </label>
                                                                <input type="text" name="i_username" id="i_username"
                                                                    class="form-control form-control-solid" readonly>
                                                            </div>
                                                            <div
                                                                class="py-2 d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                                                                <label
                                                                    class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                    <span>Rango</span>
                                                                </label>
                                                                <input type="text" name="i_range" id="i_range"
                                                                    class="form-control form-control-solid" readonly>
                                                            </div>
                                                            <div
                                                                class="py-2 d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                                                                <label
                                                                    class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                    <span>Puntos Personales</span>
                                                                </label>
                                                                <input type="text" name="i_point" id="i_point"
                                                                    class="form-control form-control-solid" readonly>
                                                            </div>
                                                            <div
                                                                class="py-2 d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                                                                <label
                                                                    class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                    <span>Puntos Grupales</span>
                                                                </label>
                                                                <input type="text" name="i_pointgroup" id="i_pointgroup"
                                                                    class="form-control form-control-solid" readonly>
                                                            </div>
                                                            <div
                                                                class="py-2 d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                                                                <label
                                                                    class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                    <span>Estado</span>
                                                                </label>
                                                                <div id="i_status"></div>
                                                            </div>
                                                            <div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="modalCustomerTreeSelector" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Seleccionar cliente para ver su red</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <input type="text" id="treeCustomerFilter"
                                                                class="form-control"
                                                                placeholder="Buscar por DNI, codigo o nombre">
                                                        </div>
                                                        <div class="table-responsive">
                                                            <table class="table table-hover table-bordered mb-0"
                                                                id="treeCustomerTable">
                                                                <thead class="thead-light">
                                                                    <tr>
                                                                        <th style="width: 110px;">DNI</th>
                                                                        <th style="width: 110px;">Codigo</th>
                                                                        <th>Cliente</th>
                                                                        <th style="width: 150px;">Accion</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($obj_customer_button_search as $customerRow): ?>
                                                                    <tr>
                                                                        <td><?php echo esc($customerRow->dni); ?></td>
                                                                        <td><?php echo esc($customerRow->code); ?></td>
                                                                        <td><?php echo esc(trim($customerRow->name . ' ' . $customerRow->lastname)); ?>
                                                                        </td>
                                                                        <td>
                                                                            <a href="<?php echo site_url('dashboard/estructura/' . $customerRow->id); ?>"
                                                                                class="btn btn-sm btn-primary">
                                                                                <i class="fa fa-sitemap"></i> Ver arbol
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                    <?php endforeach; ?>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js"></script>
    <script src="<?php echo base_url('assets/admin/js/script/estructure.js?123'); ?>"></script>
    <script>
    var auto_complete = new Autocomplete(document.getElementById('search'), {
        data: <?php echo json_encode($data); ?>,
        maximumItems: 10,
        highlightTyped: true,
        highlightClass: 'fw-bold text-primary'
    });

    function openCustomerTreeSelectorModal() {
        var modalId = 'modalCustomerTreeSelector';
        var modalElement = document.getElementById(modalId);
        if (!modalElement) {
            return;
        }

        if (window.bootstrap && window.bootstrap.Modal) {
            if (typeof window.bootstrap.Modal.getOrCreateInstance === 'function') {
                window.bootstrap.Modal.getOrCreateInstance(modalElement).show();
                return;
            }

            if (typeof window.bootstrap.Modal.getInstance === 'function') {
                var existingInstance = window.bootstrap.Modal.getInstance(modalElement);
                if (existingInstance) {
                    existingInstance.show();
                    return;
                }
            }

            try {
                (new window.bootstrap.Modal(modalElement)).show();
                return;
            } catch (error) {
                console.warn('No se pudo abrir el modal con bootstrap.Modal', error);
            }
        }

        if (window.jQuery && typeof window.jQuery.fn.modal === 'function') {
            window.jQuery(modalElement).modal('show');
            return;
        }

        modalElement.style.display = 'block';
        modalElement.classList.add('show');
        modalElement.removeAttribute('aria-hidden');
        document.body.classList.add('modal-open');

        if (!document.querySelector('.modal-backdrop')) {
            var backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            backdrop.setAttribute('data-manual-backdrop', modalId);
            document.body.appendChild(backdrop);
        }
    }

    (function() {
        var filterInput = document.getElementById('treeCustomerFilter');
        var table = document.getElementById('treeCustomerTable');
        if (!filterInput || !table) {
            return;
        }

        filterInput.addEventListener('input', function() {
            var term = this.value.toLowerCase().trim();
            var rows = table.querySelectorAll('tbody tr');
            rows.forEach(function(row) {
                var text = row.textContent.toLowerCase();
                row.style.display = text.indexOf(term) !== -1 ? '' : 'none';
            });
        });
    })();
    </script>
    <!-- [ Main Content ] end -->
    <?php echo view("admin/footer"); ?>
