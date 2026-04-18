<nav class="pcoded-navbar navbar-collapsed" style="overflow-y:auto;overflow-x: hidden !important;">
    <div class="navbar-wrapper">
        <div class="navbar-brand header-logo">
            <a class="b-brand">
                <div class="">
                    <img alt="Logo" src="<?php echo site_url() . "assets/front/img/logo/logo_2025.png"; ?>"
                        width="30" />
                </div>
                <span class="b-title">Grupo Vivencia</span>
            </a>
            <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
        </div>
        <?php
        // Helper para cortar texto si no existe
        if (!function_exists('corta_texto')) {
            function corta_texto($texto, $max)
            {
                return (strlen($texto) > $max) ? substr($texto, 0, $max) . '...' : $texto;
            }
        }
        $url = explode("/", uri_string());
        if (isset($url[1])) {
            $nav = $url[1];
        } else {
            $nav = "";
        }
        $panel_style = null;
        $panel_color = null;
        $ventas_style = null;
        $ventas_color = null;
        $nuevo_socio_style = null;
        $nuevo_socio_color = null;
        $nueva_venta_style = null;
        $nueva_venta_color = null;
        $mantenimientos_style = null;
        $bonos_color =  null;
        $bancos_color =  null;
        $almacenes_color = null;
        $clientes_style = null;
        $clientes_color =  null;
        $comentarios_color =  null;
        $facturas_color =  null;
        $planes_color =  null;
        $pagos_color =  null;
        $puntos_color =  null;
        $rangos_color =  null;
        $penalties_style = null;
        $penalties_color = null;
        $usuarios_color = null;
        $usuarios_style = null;
        $recarga_style = null;
        $recarga_pendiente_color = null;
        $recarga_verificado_color = null;
        $activaciones_style = null;
        $activaciones_pendientes = null;
        $activaciones_verificadas = null;
        $nuevos_rangos_style = null;
        $pagos_style = null;
        $activar_pagos_color = null;
        $integracion_pagos_style = null;
        $concepto_ticket_style = null;
        $concepto_ticket_color = null;
        $usuarios_style = null;
        $integracion_pagos_color = null;
        $integracion_descuentos_color = null;
        $integracion_puntos_color = null;
        $integracion_puntos_rango_color = null;
        $soporte_style = null;
        $setting_color = null;
        $ticket_color = null;
        $nuevos_rangos_color = null;
        // $kyc_style = null;
        // $kyc_pendientes_color = null;
        // $kyc_verificados_color = null;
        $anuncios_style = null;
        $anuncios_color = null;
        $comisiones_style = null;
        $comisiones_color = null;
        $facturas_style = null;
        $facturas_color = null;
        $compras_style = null;
        $compras_color = null;
        $gastos_style = null;
        $gastos_color = null;
        $clasificacion_style = null;
        $clasificacion_color = null;
        $facturascontratos_style = null;
        $facturascontratos_color = null;
        $kit_afiliacion_style = null;
        $periodo_color = null;
        $reportes_style = null;
        $reportes_clientes_color = null;
        $reportes_ventas_color = null;
        $reportes_pagos_color = null;
        $reportes_ganancias_color = null;
        $estructura_style = null;
        $estructura_color = null;
        $pago_tienda_style = null;
        $pago_tienda_color = null;
        $pago_tienda_verificadas_color = null;
        $proveedores_style = null;
        $proveedores_verificadas_color = null;
        $entradas_verificadas_color = null;
        $traspaso_color = null;
        $salidas_color = null;
        $kardex_color = null;
        $sugerencias_color = null;
        $sugerencias_style = null;
        $inventario_color = null;
        $calificados_style = null;
        $calificados_color = null;
        $kit_afiliacion_color = null;
        $periodo_color = null;
        $inmueble_style = null;
        $inmueble_color = null;

        switch ($nav) {
            case "ventas":
                $ventas_style = "active pcoded-trigger";
                $ventas_color = "active_nav";
                break;
            case "usuarios":
                $mantenimientos_style = "active pcoded-trigger";
                $usuarios_color = "active_nav";
                break;
            // case "kyc_pendientes":
            //    $kyc_style = "active pcoded-trigger";
            //    $kyc_pendientes_color = "active_nav";
            //    break;
            // case "kyc_verificados":
            //    $kyc_style = "active pcoded-trigger";
            //    $kyc_verificados_color = "active_nav";
            //    break;
            case "recargas_pendientes":
                $recarga_style = "active pcoded-trigger";
                $recarga_pendiente_color = "active_nav";
                break;
            case "recargas_completas":
                $recarga_style = "active pcoded-trigger";
                $recarga_verificado_color = "active_nav";
                break;
            case "nuevos_rangos":
                $mantenimientos_style = "active pcoded-trigger";
                $nuevos_rangos_color = "active_nav";
                break;
            case "bonos":
                $mantenimientos_style = "active pcoded-trigger";
                $bonos_color = "active_nav";
                break;
            case "periodos":
                $mantenimientos_style = "active pcoded-trigger";
                $periodo_color = "active_nav";
                break;
            case "bancos":
                $mantenimientos_style = "active pcoded-trigger";
                $bancos_color = "active_nav";
                break;
            case "almacenes":
                $mantenimientos_style = "active pcoded-trigger";
                $almacenes_color = "active_nav";
                break;
            case "kit_afiliacion":
                $mantenimientos_style = "active pcoded-trigger";
                $kit_afiliacion_color = "active_nav";
                break;
            case "clientes":
                $mantenimientos_style = "active pcoded-trigger";
                $clientes_style = "active pcoded-trigger";
                $clientes_color = "active_nav";
                break;
            case "comentarios":
                $mantenimientos_style = "active pcoded-trigger";
                $comentarios_color = "active_nav";
                break;
            case "concepto_ticket":
                $mantenimientos_style = "active pcoded-trigger";
                $concepto_ticket_style = "active pcoded-trigger";
                $concepto_ticket_color = "active_nav";
                break;
            case "comisiones":
                $mantenimientos_style = "active pcoded-trigger";
                $comisiones_style = "active pcoded-trigger";
                $comisiones_color = "active_nav";
                break;
            case "facturas":
                $mantenimientos_style = "active pcoded-trigger";
                $facturas_style = "active pcoded-trigger";
                $facturas_color = "active_nav";
                break;
            case "facturasContratos":
                $mantenimientos_style = "active pcoded-trigger";
                $facturascontratos_style = "active pcoded-trigger";
                $facturascontratos_color = "active_nav";
                break;
            case "compras":
                $compras_style = "active pcoded-trigger";
                $compras_color = "active_nav";
                break;
            case "gastos":
                $compras_style = "active pcoded-trigger";
                $gastos_color = "active_nav";
                break;
            case "clasificacion":
                $compras_style = "active pcoded-trigger";
                $clasificacion_color = "active_nav";
                break;
            case "planes":
                $proveedores_style = "active pcoded-trigger";
                $planes_color = "active_nav";
                break;
            case "pagos":
                $mantenimientos_style = "active pcoded-trigger";
                $pagos_color = "active_nav";
                break;
            case "puntos":
                $mantenimientos_style = "active pcoded-trigger";
                $puntos_color = "active_nav";
                break;
            case "rangos":
                $mantenimientos_style = "active pcoded-trigger";
                $rangos_color = "active_nav";
                break;
            case "penalties":
                $penalties_style = "active pcoded-trigger";
                $penalties_color = "active_nav";
                break;
            case "activaciones":
                $activaciones_style = "active pcoded-trigger";
                $activaciones_pendientes = "active_nav";
                break;
            case "activaciones_verificadas":
                $activaciones_style = "active pcoded-trigger";
                $activaciones_verificadas = "active_nav";
                break;
            case "activar_pagos":
                $pagos_style = "active pcoded-trigger";
                $activar_pagos_color = "active_nav";
                break;
            case "integracion_pagos":
                $integracion_pagos_style = "active pcoded-trigger";
                $integracion_pagos_color = "active_nav";
                break;
            case "integracion_puntos":
                $integracion_pagos_style = "active pcoded-trigger";
                $integracion_puntos_color = "active_nav";
                break;
            case "integracion_puntos_rango":
                $integracion_pagos_style = "active pcoded-trigger";
                $integracion_puntos_rango_color = "active_nav";
                break;
            case "ticket":
                $soporte_style = "active pcoded-trigger";
                $ticket_color = "active_nav";
                break;
            case "reportes_clientes":
                $reportes_style = "active pcoded-trigger";
                $reportes_clientes_color = "active_nav";
                break;
            case "reportes_ventas":
                $reportes_style = "active pcoded-trigger";
                $reportes_ventas_color = "active_nav";
                break;
            case "reportes_pagos":
                $reportes_style = "active pcoded-trigger";
                $reportes_pagos_color = "active_nav";
                break;
            case "reportes_ganancias":
                $reportes_style = "active pcoded-trigger";
                $reportes_ganancias_color = "active_nav";
                break;
            case "estructura":
                $estructura_style = "pcoded-trigger";
                $estructura_color = "active_nav";
                break;
            case "nuevo_socio":
                $nuevo_socio_style = "pcoded-trigger";
                $nuevo_socio_color = "active_nav";
                break;
            case "nueva_venta":
                $nueva_venta_style = "pcoded-trigger";
                $nueva_venta_color = "active_nav";
                break;
            case "nueva_venta":
                $nueva_venta_style = "pcoded-trigger";
                $nueva_venta_color = "active_nav";
                break;
            case "sugerencias":
                $sugerencias_style = "active pcoded-trigger";
                $sugerencias_color = "active_nav";
                break;
            case "calificados":
                $calificados_style = "pcoded-trigger";
                $calificados_color = "active_nav";
                break;
            case "inmueble":
                $inmueble_style = "pcoded-trigger";
                $inmueble_color = "active_nav";
                break;
            case "pago_tienda":
                $pago_tienda_style = "active pcoded-trigger";
                $pago_tienda_color = "active_nav";
                break;
            case "pago_tienda_verificadas":
                $pago_tienda_style = "active pcoded-trigger";
                $pago_tienda_verificadas_color = "active_nav";
                break;
            case "proveedores":
                $proveedores_style = "active pcoded-trigger";
                $proveedores_verificadas_color = "active_nav";
                break;
            case "entradas":
                $proveedores_style = "active pcoded-trigger";
                $entradas_verificadas_color = "active_nav";
                break;
            case "traspaso":
                $proveedores_style = "active pcoded-trigger";
                $traspaso_color = "active_nav";
                break;
            case "salidas":
                $proveedores_style = "active pcoded-trigger";
                $salidas_color = "active_nav";
                break;
            case "kardex":
                $proveedores_style = "active pcoded-trigger";
                $kardex_color = "active_nav";
                break;
            case "inventario":
                $proveedores_style = "active pcoded-trigger";
                $inventario_color = "active_nav";
                break;
            default:
                $panel_style = "active pcoded-trigger";
                $panel_color = "active_nav";
                break;
        }
        ?>
        <div class="navbar-content scroll-div">
            <div class="user-profile-info"
                style="display:flex;flex-direction:column;align-items:center;padding:24px 0 8px 0;">
                <?php
                $session = session();
                $session_privilege = $session->get('privilegio');
                $session_name = $session->get('name');
                $session_lastname = $session->get('lastname');
                $session_dni = $session->get('dni');
                $session_avatar = $session->get('avatar');
                $session_email = $session->get('email');
                $avatar = site_url('assets/metronic8/media/avatars/300-1.jpg');
                $full_name = '';
                $dni = '';
                if ($session_privilege === 'admin' || $session_privilege === 'Administrador' || $session_privilege === 'superadmin') {
                    $full_name = trim($session_name . ' ' . $session_lastname);
                    $dni = $session_dni;
                    if (!empty($session_avatar)) {
                        $avatar = site_url('ruta/a/avatars/') . $session_avatar;
                    }
                    echo "<script>console.log('SIDEBAR/HEADER ADMIN:', {name: '$full_name', dni: '$dni', email: '$session_email', privilegio: '$session_privilege', avatar: '$avatar'});</script>";
                } else {
                    $customer = null;
                    if ($session_email) {
                        $CustomerModel = new \App\Models\CustomerModel();
                        $customer = $CustomerModel->where('email', $session_email)->first();
                    }
                    if ($customer) {
                        $full_name = trim($customer['name'] . ' ' . $customer['lastname']);
                        $dni = $customer['dni'] ?? '';
                        if (!empty($customer['avatar'])) {
                            $avatar = site_url('ruta/a/avatars/') . $customer['avatar'];
                        }
                        $customer_json = json_encode([
                            'name' => $full_name,
                            'dni' => $dni,
                            'email' => $session_email,
                            'privilegio' => $session_privilege,
                            'avatar' => $avatar
                        ]);
                        echo "<script>console.log('SIDEBAR/HEADER CUSTOMER:', $customer_json);</script>";
                    }
                }
                ?>
                <img src="<?php echo $avatar; ?>" alt="Avatar"
                    style="width:70px;height:70px;border-radius:50%;object-fit:cover;border:3px solid #e0e0e0;box-shadow:0 2px 8px #0001;">
                <div style="margin-top:10px;text-align:center;">
                    <span
                        style="font-weight:bold;display:block;font-size:16px;line-height:1.1;color:#fff;padding:0;border-radius:0;background:none;">
                        <?php echo corta_texto($full_name, 22); ?>
                    </span>
                    <?php if (!empty($dni)) { ?>
                        <span
                            style="font-size:13px;color:#fff;padding:0;border-radius:0;background:none;display:inline-block;margin-top:8px;letter-spacing:1px;font-weight:600;">
                            <?php echo $dni; ?></span>
                    <?php } ?>
                </div>
            </div>
            <style>
                .pcoded-navbar.navbar-collapsed .user-profile-info {
                    display: none !important;
                }

                .pcoded-navbar.navbar-collapsed:hover .user-profile-info {
                    display: flex !important;
                }
            </style>
            <ul class="nav pcoded-inner-navbar">
                <!-- <li class="nav-item pcoded-menu-caption">
                    <label>Inicio</label>
                </li> -->
                <!-- <li class="nav-item <?php echo $panel_style; ?>">
                    <a href="/dashboard/panel" class="nav-link <?php echo $panel_color; ?>">
                        <span class="pcoded-micon"><i class="feather icon-home"></i></span><span
                            class="pcoded-mtext">Panel </span>
                    </a>
                </li> -->
                <!-- <li class="nav-item <?php echo $ventas_style; ?>">
                    <a href="/dashboard/ventas" class="nav-link <?php echo $ventas_color; ?>">
                        <span class="pcoded-micon"><i class="feather icon-shopping-cart"></i></span>
                        <span class="pcoded-mtext">Ventas</span><span class="label pcoded-badge badge-danger">Hoy</span>
                    </a>
                </li> -->
                <!-- Historial/Comisiones -->
                <!-- <li class="nav-item">
                    <a href="/backoffice_new/historial/comisiones" class="nav-link">
                        <span class="pcoded-micon"><i class="fa fa-money-bill"></i></span>
                        <span class="pcoded-mtext">Historial Comisiones</span>
                    </a>
                </li> -->
                <li class="nav-item <?php echo $inmueble_style; ?>">
                    <a href="/dashboard/inmueble" class="nav-link <?php echo $inmueble_color; ?>">
                        <span class="pcoded-micon"><i class="feather icon-home"></i></span><span
                            class="pcoded-mtext">Panel</span>
                    </a>
                </li>
                <li class="nav-item <?php echo $estructura_style; ?>">
                    <a href="/dashboard/estructura" class="nav-link <?php echo $estructura_color; ?>">
                        <span class="pcoded-micon"><i class="feather icon-share-2"></i></span><span
                            class="pcoded-mtext">Estructura</span>
                    </a>
                </li>
                <li class="nav-item <?php echo $nuevo_socio_style; ?>">
                    <a href="/dashboard/nuevo_socio" class="nav-link <?php echo $nuevo_socio_color; ?>">
                        <span class="pcoded-micon"><i class="feather icon-user-plus"></i></span><span
                            class="pcoded-mtext">Nuevo Socio</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('dashboard/ventas'); ?>" class="nav-link">
                        <span class="pcoded-micon"><i class="feather icon-shopping-cart"></i></span>
                        <span class="pcoded-mtext">Ventas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('dashboard/documentario'); ?>" class="nav-link">
                        <span class="pcoded-micon"><i class="feather icon-shopping-cart"></i></span>
                        <span class="pcoded-mtext">Documentario</span>
                    </a>
                </li>
                <!-- <li class="nav-item <?php echo $sugerencias_style; ?>">
                    <a href="/dashboard/sugerencias" class="nav-link <?php echo $sugerencias_color; ?>">
                        <span class="pcoded-micon"><i class="feather icon-help-circle"></i></span>
                        <span class="pcoded-mtext">Sugerencias</span><span
                            class="label pcoded-badge badge-warning">Nuevo</span>
                    </a>
                </li> -->

                <!-- <li class="nav-item pcoded-menu-caption">
                    <label>Ventas & Pago en Tienda</label>
                </li>
                <li class="nav-item <?php echo $nueva_venta_style; ?>">
                    <a href="/dashboard/nueva_venta" class="nav-link <?php echo $nueva_venta_color; ?>">
                        <span class="pcoded-micon"><i class="fa fa-cart-plus"></i></span>
                        <span class="pcoded-mtext">Nueva venta</span><span
                            class="label pcoded-badge badge-success">Ventas</span>
                    </a>
                </li>
                <li class="nav-item pcoded-hasmenu <?php echo $pago_tienda_style; ?>">
                    <a href="#!" class="nav-link"><span class="pcoded-micon"><i class="fa fa-money"></i></span><span
                            class="pcoded-mtext">Pago en tienda</span></a>
                    <ul class="pcoded-submenu">
                        <li class=""><a href="/dashboard/pago_tienda" class="<?php echo $pago_tienda_color; ?>">Pago
                                Pendiente</a></li>
                        <li class=""><a href="/dashboard/pago_tienda_verificadas"
                                class="<?php echo $pago_tienda_verificadas_color; ?>">Pago Procesado</a></li>
                    </ul>
                </li>
                <li class="nav-item pcoded-hasmenu <?php echo $activaciones_style; ?>">
                    <a href="#!" class="nav-link"><span class="pcoded-micon"><i
                                class="fa fa-motorcycle"></i></span><span class="pcoded-mtext">Pedidos</span></a>
                    <ul class="pcoded-submenu">
                        <li class=""><a href="/dashboard/activaciones"
                                class="<?php echo $activaciones_pendientes; ?>">Por entregar</a></li>
                        <li class=""><a href="/dashboard/activaciones_verificadas"
                                class="<?php echo $activaciones_verificadas; ?>">Entregado</a></li>
                    </ul>
                </li> -->
                <!-- <li class="nav-item pcoded-menu-caption">
                    <label>Kardex & Almacen</label>
                </li>
                <li class="nav-item pcoded-hasmenu <?php echo $proveedores_style; ?>">
                    <a href="#!" class="nav-link"><span class="pcoded-micon"><i class="fa fa-list-alt"></i></span><span
                            class="pcoded-mtext">kardex</span></a>
                    <ul class="pcoded-submenu">
                        <li class=""><a href="/dashboard/kardex" class="<?php echo $kardex_color; ?>">Kardex <span
                                    class="label pcoded-badge label-danger">nuevo</span></a></li>
                        <li class=""><a href="/dashboard/inventario"
                                class="<?php echo $inventario_color; ?>">Inventario</a></li>
                        <li class=""><a href="/dashboard/entradas"
                                class="<?php echo $entradas_verificadas_color; ?>">Entradas</a></li>
                        <li class=""><a href="/dashboard/traspaso" class="<?php echo $traspaso_color; ?>">Traspaso</a>
                        </li>
                        <li class=""><a href="/dashboard/salidas" class="<?php echo $salidas_color; ?>">Salidas</a></li>
                        <li class=""><a href="/dashboard/planes" class="<?php echo $planes_color; ?>">Productos</a></li>
                        <li class=""><a href="/dashboard/proveedores"
                                class="<?php echo $proveedores_verificadas_color; ?>">Proveedores</a></li>
                    </ul>
                </li> -->

                <!-- <li class="nav-item pcoded-hasmenu <?php //echo $kyc_style; 
                                                        ?>">
               <a href="#!" class="nav-link"><span class="pcoded-micon"><i class="fa fa-id-badge"></i></span><span class="pcoded-mtext">KYC</span></a>
               <ul class="pcoded-submenu">
                  <li class=""><a href="/dashboard/kyc_pendientes" class="<?php //echo $kyc_pendientes_color; 
                                                                            ?>">KYC Pendientes</a></li>
                  <li class=""><a href="/dashboard/kyc_verificados" class="<?php //echo $kyc_verificados_color; 
                                                                            ?>">KYC Verificados</a></li>
               </ul>
            </li> -->



                <!-- Penalidades: moved out from submenu into its own top-level item -->
                <!-- (moved below to be penultimate) -->
                <!-- Clientes: moved out from submenu into its own top-level item -->
                <li class="nav-item <?php echo $clientes_style; ?>">
                    <a href="/dashboard/clientes" class="nav-link <?php echo $clientes_color; ?>">
                        <span class="pcoded-micon"><i class="fa fa-users"></i></span>
                        <span class="pcoded-mtext">Clientes</span>
                    </a>
                </li>
                <!-- Opción Asignar Patrocinador eliminada -->
                <!-- Comisiones: top-level -->
                <li class="nav-item <?php echo $comisiones_style; ?>">
                    <a href="/dashboard/comisiones" class="nav-link <?php echo $comisiones_color; ?>">
                        <span class="pcoded-micon"><i class="fa fa-money-bill"></i></span>
                        <span class="pcoded-mtext">Comisiones</span>
                    </a>
                </li>
                <!-- Demo Comisiones Multinivel -->

                <!-- Facturas: top-level -->

                <!-- Facturas Contratos: top-level -->
                <li class="nav-item <?php echo $facturascontratos_style; ?>">
                    <a href="/dashboard/facturasContratos" class="nav-link <?php echo $facturascontratos_color; ?>">
                        <span class="pcoded-micon"><i class="fa fa-file-contract"></i></span>
                        <span class="pcoded-mtext">Facturas Contratos</span>
                    </a>
                </li>

                <!-- Compras, Gastos y Clasificación: consolidado en UN item con submenú -->
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link"><span class="pcoded-micon"><i class="fa fa-shopping-cart"></i></span><span class="pcoded-mtext">Compras</span></a>
                    <ul class="pcoded-submenu">
                        <li class=""><a href="/dashboard/compras" class="nav-link <?php echo $compras_color; ?>" style="<?php echo ($compras_color ? 'font-weight: bold;' : ''); ?>"><span class="pcoded-micon"><i class="fa fa-file-invoice"></i></span><span class="pcoded-mtext">Registrar Compra</span></a></li>
                        <li class=""><a href="/dashboard/gastos" class="nav-link <?php echo $gastos_color; ?>" style="<?php echo ($gastos_color ? 'font-weight: bold;' : ''); ?>"><span class="pcoded-micon"><i class="fa fa-money-bill-wave"></i></span><span class="pcoded-mtext">Gastos</span></a></li>
                        <li class=""><a href="/dashboard/clasificacion" class="nav-link <?php echo $clasificacion_color; ?>" style="<?php echo ($clasificacion_color ? 'font-weight: bold;' : ''); ?>"><span class="pcoded-micon"><i class="fa fa-tags"></i></span><span class="pcoded-mtext">Clasificación</span></a></li>
                    </ul>
                </li>

                <li class="nav-item <?php echo $usuarios_style; ?>">
                    <a href="/dashboard/usuarios" class="nav-link <?php echo $usuarios_color; ?>">
                        <span class="pcoded-micon"><i class="fa fa-user-cog"></i></span>
                        <span class="pcoded-mtext">Usuarios</span>
                    </a>
                </li>
                <!-- <li class="nav-item pcoded-hasmenu <?php echo $integracion_pagos_style; ?>">
                    <a href="#!" class="nav-link"><span class="pcoded-micon"><i
                                class="feather icon-plus"></i></span><span class="pcoded-mtext">Integración</span></a>
                    <ul class="pcoded-submenu">
                        <li class=""><a href="/dashboard/integracion_pagos"
                                class="<?php echo $integracion_pagos_color; ?>">Integración & Descuento</a></li>
                    </ul>
                </li> -->

                <li class="nav-item <?php echo $penalties_style; ?>">
                    <a href="/dashboard/penalties" class="nav-link <?php echo $penalties_color; ?>">
                        <span class="pcoded-micon"><i class="fa fa-exclamation-triangle"></i></span>
                        <span class="pcoded-mtext">Penalidades</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>
<header class="navbar pcoded-header navbar-expand-lg navbar-light">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse1" href="#!"><span></span></a>
        <a href="index.html" class="b-brand">
            <div class="b-bg">
                <img alt="Logo" src="<?php echo site_url() . "assets/front/img/logo/logo_2025.png"; ?>" width="30" />
            </div>
            <span class="b-title">Grupo Vivencia</span>
        </a>
    </div>
    <a class="mobile-menu" id="mobile-header" href="#!">
        <i class="feather icon-more-horizontal"></i>
    </a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li><a href="#!" class="full-screen" onclick="javascript:toggleFullScreen()"><i
                        class="feather icon-maximize"></i></a></li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li>
                <div class="dropdown drp-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon feather icon-settings"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-notification">
                        <div class="pro-head">
                            <?php
                            $session = session();
                            $session_name = $session->get('name');
                            $session_lastname = $session->get('lastname');
                            $session_dni = $session->get('dni');
                            $avatar = site_url('assets/metronic8/media/avatars/300-1.jpg');
                            // $avatar = $session->get('avatar') ? site_url('ruta/a/avatars/').$session->get('avatar') : $avatar;
                            ?>
                            <img src="<?php echo $avatar; ?>" class="img-radius" alt="Imagen de Perfil"
                                style="width:48px;height:48px;object-fit:cover;">
                            <div style="margin-top:8px;">
                                <span style="font-weight:bold;display:block;">
                                    <?php echo corta_texto(trim($session_name . ' ' . $session_lastname), 18); ?>
                                </span>
                                <?php if ($session_dni) { ?>
                                    <span style="font-size:12px;color:#888;">DNI: <?php echo $session_dni; ?></span>
                                <?php } ?>
                                <?php
                                $header_json = json_encode([
                                    'name' => trim($session_name . ' ' . $session_lastname),
                                    'dni' => $session_dni,
                                    'email' => $session->get('email'),
                                    'privilegio' => $session->get('privilegio'),
                                    'avatar' => $avatar
                                ]);
                                echo "<script>console.log('HEADER USER:', $header_json);</script>";
                                ?>
                            </div>
                            <a href="/dashboard/logout" class="dud-logout" title="Logout">
                                <i class="feather icon-log-out"></i>
                            </a>
                        </div>
                        <ul class="pro-body">
                            <li><a href="/dashboard/logout" class="dropdown-item"><i class="feather icon-lock"></i>
                                    Salir</a></li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>