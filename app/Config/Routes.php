<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// =====================================================================
// RUTAS DEL ADMIN / DASHBOARD  →  filter: authAdmin
// =====================================================================

$routes->get('/dashboard/facturas/detalle/(:num)', 'D_facturas::detalle/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/inmueble/aprobarMejor', 'Inmueble::aprobarMejor');
$routes->get('dashboard/mostrarComprobante/(:any)', 'Inmueble::mostrarComprobante/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/inmueble/approve_contract', 'Inmueble::aprobarContrato', ['filter' => 'authAdmin']);
$routes->post('/dashboard/inmueble/reject_contract', 'Inmueble::reject_contract', ['filter' => 'authAdmin']);
$routes->get('/dashboard/facturasContratos', 'D_facturas::facturasContratos', ['filter' => 'authAdmin']);
$routes->get('/dashboard/facturas/emitir_desde_contrato/(:num)', 'D_facturas::emitirDesdeContrato/$1', ['filter' => 'authAdmin']);
$routes->get('/dashboard/inmueble/contracts/get_schedule/(:num)', 'B_admin::get_schedule/$1', ['filter' => 'authAdmin']);

// Pagos y validación
$routes->get('/dashboard/inmueble/cronograma/(:num)', 'PagosController::cronograma_completo/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/inmueble/validar_pago', 'PagosController::validar_pago', ['filter' => 'authAdmin']);
$routes->post('/dashboard/inmueble/generar_factura_cuota', 'PagosController::generar_factura_cuota', ['filter' => 'authAdmin']);

// =====================================================================
// RUTAS PÚBLICAS
// =====================================================================

$routes->get('/lang/{locale}', 'Language::index');
$routes->get('/', 'Login::index');
$routes->get('/nosotros', 'Home::about');
$routes->get('/productos', 'Home::products');
$routes->get('/productos/(:any)', 'Home::product_detail/$1');

// Cart público
$routes->post('/add_cart', 'Cart::add_cart');
$routes->get('/carrito', 'Cart::index');
$routes->get('/cart', 'Cart::index');
$routes->post('/cart/add', 'Cart::add_cart_public');
$routes->post('/cart/update', 'Cart::update_quantity');
$routes->post('/cart/remove', 'Cart::remove_item');
$routes->get('/checkout', 'Cart::checkout');
$routes->post('/page-method', 'Cart::page_method');

$routes->get('/contacto', 'Home::contact');
$routes->post('/contacto/validate_captcha', 'Home::validate_captcha');
$routes->post('/contacto/send_messages', 'Home::send_messages');

$routes->get('/login', 'Login::index');
$routes->get('/iniciar-sesion', 'Login::index');
$routes->post('/iniciar-sesion/validate_captcha', 'Login::validate_captcha');
$routes->post('/iniciar-sesion/login_user', 'Login::login_user');
$routes->get('/login-register', 'Login::login_register');
$routes->post('/login-register/validate', 'Login::login_register_validate');

// Recuperar contraseña
$routes->get('/recuperar-contrasena', 'Forget::index');
$routes->post('/recuperar-contrasena/validate', 'Forget::validacion');
$routes->post('/recuperar-contrasena/validate_captcha', 'Forget::validate_captcha');
$routes->get('/password/(:any)', 'Forget::recover/$1');
$routes->post('/password/validate_recover', 'Forget::validate_recover');

// Términos y condiciones
$routes->get('/terminos-y-condiciones', 'Home::terminos');
$routes->get('/privacidad', 'Home::policy');
$routes->get('/preguntas-frecuentes', 'Home::faq');

// Registro
$routes->get('/registro/(:any)', 'Registro::index/$1');
$routes->get('/registro', 'Registro::index_register');
$routes->post('/register/validate_captcha', 'Registro::validate_captcha');
$routes->post('/register/validate_username', 'Registro::validate_username');
$routes->post('/register/validate_pass', 'Registro::validate_pass');
$routes->post('/register/validacion', 'Registro::validacion');

// Cron Jobs
$routes->get('/crone/reconsumo', 'Crone::index');
$routes->get('/crone/bono_auto', 'Crone::bono_auto');
$routes->get('/crone/rangos', 'Crone::ranges');
$routes->post('/crone/crone_range_ajax', 'Crone::crone_range_ajax');
$routes->get('/crone/liderazgo', 'Crone::lidership_bonus');
$routes->get('/crone/actualizar_periodo', 'Crone::update_period');
$routes->get('/crone/sitemap', 'Crone::sitemap');

// API pública
$routes->post('api/consulta_dni', 'ApiController::consulta_dni');
$routes->post('backoffice/api/consulta_dni', 'ApiController::consulta_dni');
$routes->post('registro/api/consulta_dni', 'ApiController::consulta_dni');

// =====================================================================
// BACKOFFICE / BACKOFFICE_NEW  →  filter: authGuard
// =====================================================================

$routes->get('/backoffice_new/plan2', 'Plan2::index', ['filter' => 'authGuard']);

// Contratos backoffice_new
$routes->get('backoffice_new/contracts/cronograma/(:num)', 'BackofficeNew\\ContractsController::cronograma/$1');
$routes->get('/backoffice_new/contracts', 'B_contratos::index', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/contracts/edit/(:num)', 'B_contratos::edit/$1', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/contracts/delete/(:num)', 'B_contratos::delete/$1', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/contracts/detail/(:num)', 'B_contratos::detail/$1', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/contracts/cronograma/(:num)', 'B_contratos::schedule/$1', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/contratos', 'B_contratos::index', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/contratos/load/(:num)', 'B_contratos::load/$1', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/contratos/validate', 'B_contratos::validacion', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/contracts/registrarPagoCuota', 'BackofficeNew\ContractsController::registrarPagoCuota', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/contracts/activate/(:num)', 'B_contratos::activate/$1', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/contracts/suspend/(:num)', 'B_contratos::suspend/$1', ['filter' => 'authGuard']);

// Home backoffice
$routes->get('/backoffice', 'B_home::home2', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/dont_show_ads', 'B_home::dont_show_ads', ['filter' => 'authGuard']);
$routes->get('e', 'Home::index', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/calificacion', 'B_calification::index', ['filter' => 'authGuard']);

// Perfil
$routes->get('/backoffice_new/perfil', 'B_perfil::index', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/configuracion', 'B_perfil::setting', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/save_profile', 'B_perfil::save_profile', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/save_bank', 'B_perfil::save_bank', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/save_email', 'B_perfil::save_email', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/save_pass', 'B_perfil::save_pass', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/save_billing', 'B_perfil::save_billing', ['filter' => 'authGuard']);

// KYC
$routes->get('/backoffice_new/kyc', 'B_perfil::kyc', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/kyc_validate', 'B_perfil::kyc_validate', ['filter' => 'authGuard']);

// PIN
$routes->get('/backoffice_new/pin', 'B_perfil::pin', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/save_pin', 'B_perfil::save_pin', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/recover_pin', 'B_perfil::recover_pin', ['filter' => 'authGuard']);
$routes->get('/recover-pin/(:any)', 'Forget::recover_pin/$1');
$routes->post('/pin/validate_pin', 'Forget::validate_pin');

// Kit
$routes->get('/backoffice_new/kit', 'B_plan::kit', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/kit/carrito', 'B_plan::cart_kit', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/kit/checkout', 'B_plan::checkout_kit', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/kit/activar', 'B_plan::activar_kit', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/kit/carrito_delete', 'B_plan::delete_cart', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/plan', 'B_plan::index', ['filter' => 'authGuard']);

// Planes
$routes->get('/backoffice_new/planes', 'B_plan::planes', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/planes/add_cart_planes', 'B_plan::add_cart_plan', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/planes/add_cart_product', 'B_plan::add_cart_product', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/planes/update_cart', 'B_plan::update_cart', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/planes/ver_carrito', 'B_plan::view_cart', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/planes/add_cart', 'B_plan::add_cart', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/planes/carrito', 'B_plan::cart', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/planes/carrito_delete', 'B_plan::delete_cart', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/planes/carrito_edit', 'B_plan::carrito_edit', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/planes/checkout', 'B_plan::checkout', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/cart_destroy', 'B_plan::cart_destroy');
$routes->post('/backoffice_new/planes/activar', 'B_plan::activar', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/planes/activar_monedero', 'B_plan::activar_monedero', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/planes/activar_tienda', 'B_plan::activar_tienda', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/planes/activar_tienda_product', 'B_plan::activar_tienda_product', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/failure', 'B_plan::index', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/success', 'B_plan::success', ['filter' => 'authGuard']);

// Historial
$routes->match(['get', 'post'], '/backoffice_new/historial', 'B_finanzas::index', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/historial/comisiones', 'ComisionesController::historial', ['filter' => 'authGuard']);

// Facturas backoffice
$routes->get('/backoffice_new/facturas', 'B_finanzas::facturas', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/facturas/(:any)', 'B_finanzas::facturas_detail/$1', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/facturas/eliminar', 'B_finanzas::delete_invoice', ['filter' => 'authGuard']);

// Carrera, Ticket, Sugerencias, Documentos
$routes->get('/backoffice_new/carrera', 'B_carrera::index', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/ticket', 'B_ticket::index', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/ticket/send_ticket', 'B_ticket::send_ticket', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/ticket/(:any)', 'B_ticket::description/$1', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/sugerencias', 'B_suggestion::index', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/sugerencias/send', 'B_suggestion::send', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/documentos', 'B_files::index', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/documentos/media', 'B_files::media', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/documentos/presentacion', 'B_files::presentacion', ['filter' => 'authGuard']);

// Cobros
$routes->get('/backoffice_new/cobros', 'B_cobros::index', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/pay/make_pay', 'B_cobros::make_pay', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/cobros/validate_wallet', 'B_cobros::validate_wallet', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/cobros/send_pin', 'B_cobros::send_pin', ['filter' => 'authGuard']);

// Transferencias
$routes->get('/backoffice_new/envios', 'B_finanzas::transfer', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/envios/search_username', 'B_finanzas::search_username', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/envios/send_commission', 'B_finanzas::send_commission', ['filter' => 'authGuard']);

// Red / Unilevel
$routes->get('/backoffice_new/unilevel', 'B_network::unilevel', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/unilevel/(:any)', 'B_network::unilevel', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/unilevel/up', 'B_network::up', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/directos', 'B_network::index', ['filter' => 'authGuard']);

// Renovación
$routes->get('/backoffice_new/renovacion', 'B_renovacion::index', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/renovacion/pagar', 'B_renovacion::pagar', ['filter' => 'authGuard']);
$routes->get('/backoffice_new', 'Home::index', ['filter' => 'authGuard']);

// Backoffice viejo
$routes->match(['get', 'post'], '/backoffice/historial', 'B_finanzas::index', ['filter' => 'authGuard']);
$routes->get('/backoffice/facturas', 'B_finanzas::facturas', ['filter' => 'authGuard']);
$routes->get('/backoffice/envios', 'B_finanzas::envios', ['filter' => 'authGuard']);
$routes->post('/backoffice/envios/search_username', 'B_finanzas::search_username', ['filter' => 'authGuard']);
$routes->post('/backoffice/envios/send_commission', 'B_finanzas::send_commission', ['filter' => 'authGuard']);
$routes->match(['get', 'post'], '/backoffice/puntosbinario', 'B_finanzas::list_binarypoint', ['filter' => 'authGuard']);

// =====================================================================
// ADMIN  →  filter: authAdmin
// =====================================================================

$routes->get('/admin', 'B_admin::admin');
$routes->post('/dashboard/validate', 'B_admin::login_admin');
$routes->get('/dashboard/panel', 'D_panel::index', ['filter' => 'authAdmin']);
$routes->get('admin/contrato_pdf/(:num)', 'B_admin::contrato_pdf/$1');
$routes->get('/admin/contrato_word/(:num)', 'B_admin::contrato_word/$1');

// Estructura
$routes->get('dashboard/inmueble/edit_contract/(:num)', 'Inmueble::edit_contract/$1', ['filter' => 'authAdmin']);
$routes->post('dashboard/inmueble/edit_contract/(:num)', 'Inmueble::edit_contract/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/inmueble/api/delete_contract', 'Inmueble::delete_contract', ['filter' => 'authAdmin']);
$routes->match(['get', 'post'], '/dashboard/estructura', 'D_panel::estructura', ['filter' => 'authAdmin']);
$routes->post('/dashboard/estructura_up', 'D_panel::estructura_up', ['filter' => 'authAdmin']);
$routes->get('/dashboard/estructura/(:num)', 'D_panel::estructura/$1', ['filter' => 'authAdmin']);
$routes->get('/dashboard/nuevo_socio', 'D_panel::nuevo_socio', ['filter' => 'authAdmin']);

// Clientes admin
$routes->post('/dashboard/postNewCustomer', 'D_panel::postNewCustomer', ['filter' => 'authAdmin']);
$routes->post('/dashboard/clientes/updateCustomer', 'D_clientes::updateCustomer', ['filter' => 'authAdmin']);

// Ventas
$routes->get('dashboard/ventas', 'D_ventas::index', ['filter' => 'authAdmin']);
$routes->get('dashboard/get_boletas_api', 'D_ventas::get_boletas_api', ['filter' => 'authAdmin']);
$routes->get('dashboard/documentario', 'D_documentario::index', ['filter' => 'authAdmin']);

// Nueva venta
$routes->get('/dashboard/nueva_venta', 'D_nueva_venta::index', ['filter' => 'authAdmin']);
$routes->match(['get', 'post'], '/dashboard/nueva_venta/carrito', 'D_nueva_venta::cart', ['filter' => 'authAdmin']);
$routes->post('/dashboard/nueva_venta/update_cart', 'D_nueva_venta::update_cart', ['filter' => 'authAdmin']);
$routes->post('/dashboard/nueva_venta/carrito_delete', 'D_nueva_venta::delete_cart', ['filter' => 'authAdmin']);
$routes->post('/dashboard/nueva_venta/checkout', 'D_nueva_venta::checkout', ['filter' => 'authAdmin']);
$routes->post('/dashboard/nueva_venta/nuevo_metodo', 'D_nueva_venta::new_method_payment', ['filter' => 'authAdmin']);
$routes->post('/dashboard/nueva_venta/procesar_venta', 'D_nueva_venta::process_sale', ['filter' => 'authAdmin']);
$routes->post('dashboard/api/consulta_dni', 'ApiController::consulta_dni');

$routes->match(['get', 'post'], '/dashboard/ventas', 'D_panel::ventas', ['filter' => 'authAdmin']);
$routes->match(['get', 'post'], '/dashboard/ventas/load/(:num)', 'D_panel::load/$1', ['filter' => 'authAdmin']);
$routes->match(['get', 'post'], '/dashboard/ventas/export_pdf/(:any)', 'D_panel::export_pdf/$1', ['filter' => 'authAdmin']);
$routes->match(['get', 'post'], '/dashboard/calificados', 'D_panel::qualified', ['filter' => 'authAdmin']);
$routes->get('/dashboard/calificados/ver/(:num)', 'D_panel::view_qualified/$1', ['filter' => 'authAdmin']);

// Almacenes
$routes->get('/dashboard/almacenes', 'D_almacenes::index', ['filter' => 'authAdmin']);
$routes->get('/dashboard/almacenes/load', 'D_almacenes::load', ['filter' => 'authAdmin']);
$routes->get('/dashboard/almacenes/load/(:num)', 'D_almacenes::load/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/almacenes/validate', 'D_almacenes::validacion', ['filter' => 'authAdmin']);
$routes->post('/dashboard/almacenes/eliminar', 'D_almacenes::eliminar', ['filter' => 'authAdmin']);

// Periodos
$routes->get('/dashboard/periodos', 'D_periodos::index', ['filter' => 'authAdmin']);
$routes->get('/dashboard/periodos/load', 'D_periodos::load', ['filter' => 'authAdmin']);
$routes->get('/dashboard/periodos/load/(:num)', 'D_periodos::load/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/periodos/validate', 'D_periodos::validacion', ['filter' => 'authAdmin']);

// Sugerencias admin
$routes->get('/dashboard/sugerencias', 'D_sugerencias::index', ['filter' => 'authAdmin']);
$routes->get('/dashboard/sugerencias/load', 'D_sugerencias::load', ['filter' => 'authAdmin']);
$routes->get('/dashboard/sugerencias/load/(:num)', 'D_sugerencias::load/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/sugerencias/validate', 'D_sugerencias::validacion', ['filter' => 'authAdmin']);
$routes->post('/dashboard/sugerencias/eliminar', 'D_sugerencias::eliminar', ['filter' => 'authAdmin']);

// Comentarios
$routes->get('/dashboard/comentarios', 'D_comentarios::index', ['filter' => 'authAdmin']);
$routes->post('/dashboard/comentarios/cambiar_status', 'D_comentarios::change_status', ['filter' => 'authAdmin']);
$routes->get('/dashboard/comentarios/load/(:num)', 'D_comentarios::load/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/comentarios/validate', 'D_comentarios::validacion', ['filter' => 'authAdmin']);
$routes->post('/dashboard/comentarios/eliminar', 'D_comentarios::eliminar', ['filter' => 'authAdmin']);

// Bancos
$routes->get('/dashboard/bancos', 'D_bancos::index', ['filter' => 'authAdmin']);
$routes->get('/dashboard/bancos/load', 'D_bancos::load', ['filter' => 'authAdmin']);
$routes->get('/dashboard/bancos/load/(:num)', 'D_bancos::load/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/bancos/validate', 'D_bancos::validacion', ['filter' => 'authAdmin']);
$routes->post('/dashboard/bancos/eliminar', 'D_bancos::eliminar', ['filter' => 'authAdmin']);

// Bonos
$routes->get('/dashboard/bonos', 'D_bonos::index', ['filter' => 'authAdmin']);
$routes->get('/dashboard/bonos/load', 'D_bonos::load', ['filter' => 'authAdmin']);
$routes->get('/dashboard/bonos/load/(:num)', 'D_bonos::load/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/bonos/validate', 'D_bonos::validacion', ['filter' => 'authAdmin']);
$routes->post('/dashboard/bonos/eliminar', 'D_bonos::eliminar', ['filter' => 'authAdmin']);

// KYC admin
$routes->get('/dashboard/kyc_pendientes', 'D_kyc::index', ['filter' => 'authAdmin']);
$routes->get('/dashboard/kyc_verificados', 'D_kyc::kyc_verificados', ['filter' => 'authAdmin']);
$routes->post('/dashboard/kyc/cambiar_verificado', 'D_kyc::verificado', ['filter' => 'authAdmin']);
$routes->post('/dashboard/kyc/cambiar_rechazado', 'D_kyc::rechazado', ['filter' => 'authAdmin']);

// Recargas
$routes->get('/dashboard/recargas_pendientes', 'D_recarga::index', ['filter' => 'authAdmin']);
$routes->get('/dashboard/recargas_completas', 'D_recarga::completed', ['filter' => 'authAdmin']);
$routes->post('/dashboard/recargas_pendientes/cambiar_verificado', 'D_recarga::verificado', ['filter' => 'authAdmin']);
$routes->post('/dashboard/recargas_pendientes/cambiar_rechazado', 'D_recarga::rechazado', ['filter' => 'authAdmin']);
$routes->get('/dashboard/recargas_pendientes/load/(:num)', 'D_recarga::load/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/recargas_pendientes/validate', 'D_recarga::validacion', ['filter' => 'authAdmin']);
$routes->post('/dashboard/recargas_pendientes/eliminar', 'D_recarga::eliminar', ['filter' => 'authAdmin']);

// Comisiones
$routes->match(['get', 'post'], '/dashboard/comisiones', 'D_comisiones::index', ['filter' => 'authAdmin']);
$routes->get('/dashboard/comisiones/load/(:num)', 'D_comisiones::load/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/comisiones/validate', 'D_comisiones::validacion', ['filter' => 'authAdmin']);
$routes->post('/dashboard/comisiones/eliminar', 'D_comisiones::eliminar', ['filter' => 'authAdmin']);
$routes->post('/admin/comisiones/cambiar_estado', 'ComisionesController::cambiar_estado', ['filter' => 'authAdmin']);
$routes->post('/admin/comisiones/eliminar', 'ComisionesController::eliminar', ['filter' => 'authAdmin']);

// Facturas admin
$routes->get('dashboard/inmueble/contracts/view/(:num)', 'Inmueble::view_contract/$1', ['filter' => 'authAdmin']);
$routes->get('/dashboard/facturas', 'D_facturas::index', ['filter' => 'authAdmin']);
$routes->get('/dashboard/facturas/load/(:num)', 'D_facturas::load/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/facturas/validate', 'D_facturas::validacion', ['filter' => 'authAdmin']);
$routes->post('/dashboard/facturas/delete', 'D_facturas::eliminar', ['filter' => 'authAdmin']);
$routes->post('/dashboard/facturas/emitirFactura', 'D_facturas::emitirFactura', ['filter' => 'authAdmin']);
$routes->post('/dashboard/facturas/generarFactura', 'D_facturas::generarFactura', ['filter' => 'authAdmin']);

// Planes admin
$routes->get('/dashboard/planes', 'D_planes::index', ['filter' => 'authAdmin']);
$routes->get('/dashboard/planes/load', 'D_planes::load', ['filter' => 'authAdmin']);
$routes->get('/dashboard/planes/load/(:num)', 'D_planes::load/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/planes/validate', 'D_planes::validacion', ['filter' => 'authAdmin']);
$routes->post('/dashboard/planes/eliminar', 'D_planes::eliminar', ['filter' => 'authAdmin']);

// Concepto ticket
$routes->get('/dashboard/concepto_ticket', 'D_concepto_ticket::index', ['filter' => 'authAdmin']);
$routes->get('/dashboard/concepto_ticket/load', 'D_concepto_ticket::load', ['filter' => 'authAdmin']);
$routes->get('/dashboard/concepto_ticket/load/(:num)', 'D_concepto_ticket::load/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/concepto_ticket/validate', 'D_concepto_ticket::validacion', ['filter' => 'authAdmin']);
$routes->post('/dashboard/concepto_ticket/eliminar', 'D_concepto_ticket::eliminar', ['filter' => 'authAdmin']);

// Pagos admin
$routes->get('/dashboard/pagos', 'D_pagos::index', ['filter' => 'authAdmin']);
$routes->get('/dashboard/pagos/load', 'D_pagos::load', ['filter' => 'authAdmin']);
$routes->get('/dashboard/pagos/load/(:num)', 'D_pagos::load/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/pagos/validate', 'D_pagos::validacion', ['filter' => 'authAdmin']);
$routes->post('/dashboard/pagos/eliminar', 'D_pagos::eliminar', ['filter' => 'authAdmin']);

// Puntos
$routes->get('/dashboard/puntos', 'D_puntos::index', ['filter' => 'authAdmin']);
$routes->get('/dashboard/puntos/load/(:num)', 'D_puntos::load/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/puntos/validate', 'D_puntos::validacion', ['filter' => 'authAdmin']);
$routes->post('/dashboard/puntos/eliminar', 'D_puntos::eliminar', ['filter' => 'authAdmin']);

// Clientes admin
$routes->get('/dashboard/clientes', 'D_clientes::index', ['filter' => 'authAdmin']);
$routes->get('/dashboard/clientes/create', 'D_clientes::create', ['filter' => 'authAdmin']);
$routes->post('/dashboard/clientes/store', 'D_clientes::store', ['filter' => 'authAdmin']);
$routes->get('/dashboard/clientes/load/(:num)', 'D_clientes::load/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/clientes/update', 'D_clientes::update', ['filter' => 'authAdmin']);
$routes->post('/dashboard/clientes/validate', 'D_clientes::validacion', ['filter' => 'authAdmin']);
$routes->post('/dashboard/clientes/eliminar', 'D_clientes::eliminar', ['filter' => 'authAdmin']);
$routes->post('/dashboard/clientes/validacion', 'D_clientes::validacion');
$routes->get('/dashboard/clientes/asignar_patocinador', 'D_clientes::asignar_patocinador', ['filter' => 'authAdmin']);
$routes->get('/admin/clientes/asignar_patocinador', 'D_clientes::asignar_patocinador', ['filter' => 'authAdmin']);

// Kit afiliación
$routes->get('/dashboard/kit_afiliacion', 'D_kit_afiliacion::index', ['filter' => 'authAdmin']);
$routes->get('/dashboard/kit_afiliacion/load', 'D_kit_afiliacion::load', ['filter' => 'authAdmin']);
$routes->get('/dashboard/kit_afiliacion/load/(:num)', 'D_kit_afiliacion::load/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/kit_afiliacion/validate', 'D_kit_afiliacion::validacion', ['filter' => 'authAdmin']);
$routes->post('/dashboard/kit_afiliacion/eliminar', 'D_kit_afiliacion::eliminar', ['filter' => 'authAdmin']);

// Inmueble routes
$routes->group('dashboard/inmueble', static function($routes){
    $routes->post('reject_contract', 'Inmueble::reject_contract', ['filter' => 'authAdmin']);
    $routes->get('', 'Inmueble::index', ['filter' => 'authAdmin']);
    $routes->get('projects', 'Inmueble::projects', ['filter' => 'authAdmin']);
    $routes->get('lots', 'Inmueble::lots', ['filter' => 'authAdmin']);
    $routes->get('lots/(:num)', 'Inmueble::lots/$1', ['filter' => 'authAdmin']);
    $routes->get('payment_plans', 'Inmueble::payment_plans', ['filter' => 'authAdmin']);
    $routes->get('payment_plans/create_payment_plan', 'Inmueble::create_payment_plan', ['filter' => 'authAdmin']);
    $routes->get('contracts', 'Inmueble::contracts', ['filter' => 'authAdmin']);
    $routes->post('create_project', 'Inmueble::create_project', ['filter' => 'authAdmin']);
    $routes->get('edit_project/(:num)', 'Inmueble::edit_project/$1', ['filter' => 'authAdmin']);
    $routes->post('edit_project/(:num)', 'Inmueble::edit_project/$1', ['filter' => 'authAdmin']);
    $routes->get('delete_project/(:num)', 'Inmueble::delete_project/$1', ['filter' => 'authAdmin']);
    $routes->get('create_lot', 'Inmueble::create_lot', ['filter' => 'authAdmin']);
    $routes->post('create_lot', 'Inmueble::create_lot', ['filter' => 'authAdmin']);
    $routes->get('edit_lot/(:num)', 'Inmueble::edit_lot/$1', ['filter' => 'authAdmin']);
    $routes->post('edit_lot/(:num)', 'Inmueble::edit_lot/$1', ['filter' => 'authAdmin']);
    $routes->get('delete_lot/(:num)', 'Inmueble::delete_lot/$1', ['filter' => 'authAdmin']);
    $routes->post('create_contract', 'Inmueble::create_contract', ['filter' => 'authAdmin']);
    $routes->post('reserve_lot', 'Inmueble::reserve_lot', ['filter' => 'authAdmin']);
    $routes->get('api/get_project/(:num)', 'Inmueble::get_project/$1', ['filter' => 'authAdmin']);
    $routes->get('api/projects', 'Inmueble::get_projects_api', ['filter' => 'authAdmin']);
    $routes->get('api/get_lot/(:num)', 'Inmueble::get_lot/$1', ['filter' => 'authAdmin']);
    $routes->get('api/get_lot_details/(:num)', 'Inmueble::get_lot_details/$1', ['filter' => 'authAdmin']);
    $routes->get('api/project_lots/(:num)', 'Inmueble::get_project_lots/$1', ['filter' => 'authAdmin']);
    $routes->post('api/update_lot_status', 'Inmueble::update_lot_status', ['filter' => 'authAdmin']);
    $routes->post('api/search_customers', 'Inmueble::search_customers', ['filter' => 'authAdmin']);
    $routes->get('api/get_available_lots', 'Inmueble::get_available_lots', ['filter' => 'authAdmin']);
    $routes->get('api/payment_plans', 'Inmueble::get_payment_plans_api', ['filter' => 'authAdmin']);
    $routes->get('api/get_payment_plan/(:num)', 'Inmueble::get_payment_plan_api/$1', ['filter' => 'authAdmin']);
    $routes->get('api/plan_contract_stats/(:num)', 'Inmueble::get_plan_contract_stats/$1', ['filter' => 'authAdmin']);
    $routes->post('update_payment_plan/(:num)', 'Inmueble::update_payment_plan/$1', ['filter' => 'authAdmin']);
    $routes->post('api/update_plan_status', 'Inmueble::update_plan_status', ['filter' => 'authAdmin']);
    $routes->delete('api/delete_payment_plan/(:num)', 'Inmueble::delete_payment_plan/$1', ['filter' => 'authAdmin']);
    $routes->post('api/update_contract_status', 'Inmueble::update_contract_status', ['filter' => 'authAdmin']);
    $routes->post('api/delete_contract', 'Inmueble::delete_contract', ['filter' => 'authAdmin']);
    $routes->get('getDepartments', 'Inmueble::getDepartments');
    $routes->get('getProvinces/(:num)', 'Inmueble::getProvinces/$1');
    $routes->get('getDistricts/(:num)', 'Inmueble::getDistricts/$1');
    $routes->post('enviar_recordatorios_vencimiento', 'Inmueble::enviar_recordatorios_vencimiento', ['filter' => 'authAdmin']);
    $routes->post('aprobarMejor', 'Inmueble::aprobarMejor');
    $routes->post('approve_contract', 'Inmueble::aprobarContrato', ['filter' => 'authAdmin']);
    $routes->get('api/get_customer/(:num)', 'Inmueble::get_customer/$1', ['filter' => 'authAdmin']);
    $routes->get('api/get_contract_details/(:num)', 'Inmueble::get_contract_details/$1', ['filter' => 'authAdmin']);
});

if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

// Integración pagos
$routes->post('/dashboard/integracion_pagos/validate_user', 'D_integracion_pagos::validate_user', ['filter' => 'authAdmin']);
$routes->post('/dashboard/integracion_pagos/active', 'D_integracion_pagos::active', ['filter' => 'authAdmin']);
$routes->post('/dashboard/integracion_pagos/delete', 'D_integracion_pagos::eliminar', ['filter' => 'authAdmin']);

// Descuentos
$routes->get('/dashboard/descuentos_pagos', 'D_integracion_pagos::descuentos', ['filter' => 'authAdmin']);
$routes->get('/dashboard/descuentos_pagos/load', 'D_integracion_pagos::descuentos_load', ['filter' => 'authAdmin']);
$routes->get('/dashboard/descuentos_pagos/load/(:num)', 'D_integracion_pagos::descuentos_load/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/descuentos_pagos/validate_user', 'D_integracion_pagos::validate_user', ['filter' => 'authAdmin']);
$routes->post('/dashboard/descuentos_pagos/active_discount', 'D_integracion_pagos::active_descuento', ['filter' => 'authAdmin']);
$routes->post('/dashboard/descuentos_pagos/delete', 'D_integracion_pagos::eliminar', ['filter' => 'authAdmin']);

// Puntos binario
$routes->get('/dashboard/integracion_puntos', 'D_integracion_pagos::puntos', ['filter' => 'authAdmin']);
$routes->get('/dashboard/integracion_puntos/load', 'D_integracion_pagos::puntos_load', ['filter' => 'authAdmin']);
$routes->get('/dashboard/integracion_puntos/load/(:num)', 'D_integracion_pagos::puntos_load/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/integracion_puntos/validate_user', 'D_integracion_pagos::validate_user', ['filter' => 'authAdmin']);
$routes->post('/dashboard/integracion_puntos/active_points', 'D_integracion_pagos::active_puntos', ['filter' => 'authAdmin']);
$routes->post('/dashboard/integracion_puntos/delete', 'D_integracion_pagos::eliminar_point_binary', ['filter' => 'authAdmin']);

// Puntos rango
$routes->get('/dashboard/integracion_puntos_rango', 'D_integracion_pagos::rangos', ['filter' => 'authAdmin']);
$routes->get('/dashboard/integracion_puntos_rango/load', 'D_integracion_pagos::rangos_load', ['filter' => 'authAdmin']);
$routes->get('/dashboard/integracion_puntos_rango/load/(:num)', 'D_integracion_pagos::rangos_load/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/integracion_puntos_rango/validate_user', 'D_integracion_pagos::validate_user', ['filter' => 'authAdmin']);
$routes->post('/dashboard/integracion_puntos_rango/active_points', 'D_integracion_pagos::active_puntos_rangos', ['filter' => 'authAdmin']);
$routes->post('/dashboard/integracion_puntos_rango/delete', 'D_integracion_pagos::eliminar_point_rangos', ['filter' => 'authAdmin']);

// Soporte admin
$routes->get('/dashboard/ticket', 'D_ticket::index', ['filter' => 'authAdmin']);
$routes->get('/dashboard/ticket/load/(:num)', 'D_ticket::load/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/ticket/validate', 'D_ticket::validacion', ['filter' => 'authAdmin']);
$routes->post('/dashboard/ticket/delete', 'D_ticket::eliminar', ['filter' => 'authAdmin']);

// Kardex
$routes->match(['get', 'post'], '/dashboard/kardex', 'D_kardex::index', ['filter' => 'authAdmin']);
$routes->post('/dashboard/kardex/export', 'D_kardex::export', ['filter' => 'authAdmin']);
$routes->match(['get', 'post'], '/dashboard/inventario', 'D_kardex::inventario', ['filter' => 'authAdmin']);
$routes->post('/dashboard/inventario/export', 'D_kardex::inventario_export', ['filter' => 'authAdmin']);

// Entradas
$routes->match(['get', 'post'], '/dashboard/entradas', 'D_incoming::index', ['filter' => 'authAdmin']);
$routes->get('/dashboard/entradas/load', 'D_incoming::load', ['filter' => 'authAdmin']);
$routes->get('/dashboard/entradas/load/(:num)', 'D_incoming::load/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/entradas/validate', 'D_incoming::validacion', ['filter' => 'authAdmin']);
$routes->post('/dashboard/entradas/delete', 'D_incoming::eliminar', ['filter' => 'authAdmin']);
$routes->post('/dashboard/entradas/save_csv', 'D_incoming::save_csv', ['filter' => 'authAdmin']);
$routes->post('/dashboard/entradas/export', 'D_incoming::export', ['filter' => 'authAdmin']);
$routes->post('/dashboard/entradas/get_unit_cost', 'D_incoming::get_unit_cost', ['filter' => 'authAdmin']);

// Salidas
$routes->match(['get', 'post'], '/dashboard/salidas', 'D_outgoing::index', ['filter' => 'authAdmin']);
$routes->get('/dashboard/salidas/load', 'D_outgoing::load', ['filter' => 'authAdmin']);
$routes->get('/dashboard/salidas/load/(:num)', 'D_outgoing::load/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/salidas/validate', 'D_outgoing::validacion', ['filter' => 'authAdmin']);
$routes->post('/dashboard/salidas/delete', 'D_outgoing::eliminar', ['filter' => 'authAdmin']);
$routes->post('/dashboard/salidas/save_csv', 'D_outgoing::save_csv', ['filter' => 'authAdmin']);
$routes->post('/dashboard/salidas/export', 'D_outgoing::export', ['filter' => 'authAdmin']);

// Proveedores
$routes->get('/dashboard/proveedores', 'D_supplier::index', ['filter' => 'authAdmin']);
$routes->get('/dashboard/proveedores/load', 'D_supplier::load', ['filter' => 'authAdmin']);
$routes->get('/dashboard/proveedores/load/(:num)', 'D_supplier::load/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/proveedores/validate', 'D_supplier::validacion', ['filter' => 'authAdmin']);
$routes->post('/dashboard/proveedores/delete', 'D_supplier::eliminar', ['filter' => 'authAdmin']);

// Traspaso
$routes->get('/dashboard/traspaso', 'D_transfer::index', ['filter' => 'authAdmin']);
$routes->get('/dashboard/traspaso/load', 'D_transfer::load', ['filter' => 'authAdmin']);
$routes->get('/dashboard/traspaso/load/(:num)', 'D_transfer::load/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/traspaso/validate', 'D_transfer::validacion', ['filter' => 'authAdmin']);
$routes->post('/dashboard/traspaso/get_max_product', 'D_transfer::get_max_product', ['filter' => 'authAdmin']);

// Reportes
$routes->match(['get', 'post'], '/dashboard/reportes_clientes', 'D_report::index', ['filter' => 'authAdmin']);
$routes->post('/dashboard/reportes/export_clientes', 'D_report::export_clientes', ['filter' => 'authAdmin']);
$routes->match(['get', 'post'], '/dashboard/reportes_ventas', 'D_report::ventas', ['filter' => 'authAdmin']);
$routes->post('/dashboard/reportes/export_ventas', 'D_report::export_ventas', ['filter' => 'authAdmin']);
$routes->match(['get', 'post'], '/dashboard/reportes_pagos', 'D_report::pagos', ['filter' => 'authAdmin']);
$routes->post('/dashboard/reportes/export_pagos', 'D_report::export_pagos', ['filter' => 'authAdmin']);
$routes->match(['get', 'post'], '/dashboard/reportes_ganancias', 'D_report::ganancias', ['filter' => 'authAdmin']);
$routes->post('/dashboard/reportes_ganancias/descontar', 'D_report::ganancias_discount', ['filter' => 'authAdmin']);
$routes->post('/dashboard/reportes/export_ganancias', 'D_report::export_ganancias', ['filter' => 'authAdmin']);

// Penalties
$routes->get('/dashboard/penalties/apply', 'Penalties::applyPenalties');
$routes->get('/dashboard/penalties', 'Penalties::index', ['filter' => 'authAdmin']);
$routes->get('/dashboard/penalties/view/(:num)', 'Penalties::view/$1', ['filter' => 'authAdmin']);
$routes->post('/dashboard/penalties/mark_paid', 'Penalties::markPaid', ['filter' => 'authAdmin']);
$routes->post('/dashboard/penalties/delete', 'Penalties::delete', ['filter' => 'authAdmin']);

// Usuarios admin
$routes->get('/dashboard/usuarios', 'D_usuarios::index', ['filter' => 'authAdmin']);
$routes->get('/dashboard/usuarios/load/(:num)', 'D_usuarios::load/$1', ['filter' => 'authAdmin']);

// Admin comisiones
$routes->get('/admin/comisiones/inmobiliaria', 'ComisionesController::inmobiliaria', ['filter' => 'authAdmin']);
$routes->get('/admin/comisiones/multinivel_demo', function() {
    echo view('admin/comisiones/multinivel_demo');
}, ['filter' => 'authAdmin']);

// Logout
$routes->get('/logout', 'Home::logout');
$routes->get('/salir', 'Home::logout');
$routes->get('/dashboard/logout', 'Home::adm_logout');

// Selects dinámicos ubicación
$routes->get('dashboard/inmueble/getDepartments', 'Inmueble::getDepartments');
$routes->get('dashboard/inmueble/getProvinces/(:num)', 'Inmueble::getProvinces/$1');
$routes->get('dashboard/inmueble/getDistricts/(:num)', 'Inmueble::getDistricts/$1');

// Facturación
$routes->post('dashboard/operacion-facturacion', 'D_ventas::operacion_facturacion');

// Catch-all (debe ir al final)
$routes->get('/(:any)', 'Home::otras');