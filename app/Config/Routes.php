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
//$routes->setController('Usuarios');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// MANTENER AUTOROUTE ACTIVADO para otras rutas
$routes->setAutoRoute(true);

/*
 * ============================================================================
 * Route Definitions
 * ============================================================================
 */
// RUTAS DEL MÓDULO DE COMPRAS - PRIORITARIAS (Antes de cualquier otra ruta)
// ============================================================================

// Rutas para Dashboard::compras (para autoroute y acceso directo)
$routes->get('dashboard/compras', 'Dashboard::compras', ['filter' => 'authGuard']);
$routes->post('dashboard/compras', 'Dashboard::guardarCompra', ['filter' => 'authGuard']);

$routes->group('dashboard/compras', static function($routes){
    // Page views
    $routes->get('', 'D_compras::index', ['filter' => 'authGuard']);
    $routes->get('create', 'D_compras::create', ['filter' => 'authGuard']);
    
    // POST routes - tanto '' como 'store' van a store()
    $routes->post('', 'D_compras::store', ['filter' => 'authGuard']);
    $routes->post('store', 'D_compras::store', ['filter' => 'authGuard']);
    
    $routes->get('view/(:num)', 'D_compras::view/$1', ['filter' => 'authGuard']);
    
    // Actions
    $routes->post('clasificar', 'D_compras::clasificar', ['filter' => 'authGuard']);
    $routes->post('aprobar', 'D_compras::aprobar', ['filter' => 'authGuard']);
    $routes->post('delete/(:num)', 'D_compras::delete/$1', ['filter' => 'authGuard']);
    
    // Reports
    $routes->get('reporte', 'D_compras::reporte', ['filter' => 'authGuard']);
    
    // Downloads
    $routes->get('descargarComprobante/(:num)', 'D_compras::descargarComprobante/$1', ['filter' => 'authGuard']);
});
// ============================================================================

$routes->get('/dashboard/facturas/detalle/(:num)', 'D_facturas::detalle/$1', ['filter' => 'authGuard']);

$routes->post('/dashboard/inmueble/aprobarMejor', 'Inmueble::aprobarMejor');

$routes->get('dashboard/mostrarComprobante/(:any)', 'Inmueble::mostrarComprobante/$1', ['filter' => 'authGuard']);
// Aprobar contrato
$routes->post('/dashboard/inmueble/approve_contract', 'Inmueble::aprobarContrato', ['filter' => 'authGuard']);

// Desaprobar contrato
$routes->post('/dashboard/inmueble/reject_contract', 'Inmueble::reject_contract', ['filter' => 'authGuard']);

$routes->get('/dashboard/facturasContratos', 'D_facturas::facturasContratos', ['filter' => 'authGuard']);
$routes->get('/dashboard/facturas/emitir_desde_contrato/(:num)', 'D_facturas::emitirDesdeContrato/$1', ['filter' =>
'authGuard']);
// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/dashboard/inmueble/contracts/get_schedule/(:num)', 'B_admin::get_schedule/$1', ['filter' => 'authGuard']);

// Rutas para gestión de pagos y validación
$routes->get('/dashboard/inmueble/cronograma/(:num)', 'PagosController::cronograma_completo/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/inmueble/validar_pago', 'PagosController::validar_pago', ['filter' => 'authGuard']);
$routes->post('/dashboard/inmueble/generar_factura_cuota', 'PagosController::generar_factura_cuota', ['filter' => 'authGuard']);

//inicio
$routes->get('/lang/{locale}', 'Language::index');
$routes->get('/', 'Login::index'); // Redirige la raíz a iniciar sesión

$routes->get('/nosotros', 'Home::about');
$routes->get('/productos', 'Home::products');
$routes->get('/productos/(:any)', 'Home::product_detail/$1');
$routes->get('backoffice_new/contracts/cronograma/(:num)', 'BackofficeNew\\ContractsController::cronograma/$1');
$routes->get('/backoffice_new/contracts', 'B_contratos::index', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/contracts/edit/(:num)', 'B_contratos::edit/$1', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/contracts/delete/(:num)', 'B_contratos::delete/$1', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/contracts/detail/(:num)', 'B_contratos::detail/$1', ['filter' => 'authGuard']);
// Cronograma de pagos (Payment Schedule) para contratos
$routes->get('/backoffice_new/contracts/cronograma/(:num)', 'B_contratos::schedule/$1', ['filter' => 'authGuard']);
// Cronograma de pagos (Payment Schedule) for contracts
// Rutas para contratos en backoffice_new
$routes->get('/backoffice_new/contratos', 'B_contratos::index', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/contratos/load/(:num)', 'B_contratos::load/$1', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/contratos/validate', 'B_contratos::validacion', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/contracts/registrarPagoCuota', 'BackofficeNew\ContractsController::registrarPagoCuota', ['filter' => 'authGuard']);

$routes->post('/backoffice_new/contracts/activate/(:num)', 'B_contratos::activate/$1', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/contracts/suspend/(:num)', 'B_contratos::suspend/$1', ['filter' => 'authGuard']);

//$routes->get('/carrito', 'Cart::index');
$routes->post('/add_cart', 'Cart::add_cart');
// cart public
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
//recuperar pass
$routes->get('/recuperar-contrasena', 'Forget::index');
$routes->post('/recuperar-contrasena/validate', 'Forget::validacion');
$routes->post('/recuperar-contrasena/validate_captcha', 'Forget::validate_captcha');

$routes->get('/password/(:any)', 'Forget::recover/$1');
$routes->post('/password/validate_recover', 'Forget::validate_recover');


//terminos y condiciones
$routes->get('/terminos-y-condiciones', 'Home::terminos');
$routes->get('/privacidad', 'Home::policy');
$routes->get('/preguntas-frecuentes', 'Home::faq');
//registro
$routes->get('/registro/(:any)', 'Registro::index/$1');
$routes->get('/registro', 'Registro::index_register');
$routes->post('/register/validate_captcha', 'Registro::validate_captcha');
$routes->post('/register/validate_username', 'Registro::validate_username');
$routes->post('/register/validate_pass', 'Registro::validate_pass');
$routes->post('/register/validacion', 'Registro::validacion');

//CROME JOBS
$routes->get('/crone/reconsumo', 'Crone::index');
$routes->get('/crone/bono_auto', 'Crone::bono_auto');
$routes->get('/crone/rangos', 'Crone::ranges');
$routes->post('/crone/crone_range_ajax', 'Crone::crone_range_ajax');
$routes->get('/crone/liderazgo', 'Crone::lidership_bonus');
$routes->get('/crone/actualizar_periodo', 'Crone::update_period');


//site map
$routes->get('/crone/sitemap', 'Crone::sitemap');

$routes->post('api/consulta_dni', 'ApiController::consulta_dni');
$routes->get('/backoffice_new/plan2', 'Plan2::index', ['filter' => 'authGuard']);
$routes->post('backoffice/api/consulta_dni', 'ApiController::consulta_dni');
$routes->post('registro/api/consulta_dni', 'ApiController::consulta_dni');
//BACKOFFICE NEW
//home
$routes->get('/backoffice', 'B_home::home2', ['filter' => 'authGuard']);
// $routes->get('/backoffice', 'B_home2::index', ['filter' => 'authGuard']);
// $routes->get('/backoffice_new', 'B_home::index', ['filter' => 'authGuard']); // Ruta eliminada por requerimiento
// $routes->get('/backoffice_new/home2', 'B_home::home2', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/dont_show_ads', 'B_home::dont_show_ads', ['filter' => 'authGuard']);
//home
$routes->get('e', 'Home::index', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/calificacion', 'B_calification::index', ['filter' => 'authGuard']);
//perfil
$routes->get('/backoffice_new/perfil', 'B_perfil::index', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/configuracion', 'B_perfil::setting', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/save_profile', 'B_perfil::save_profile', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/save_bank', 'B_perfil::save_bank', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/save_email', 'B_perfil::save_email', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/save_pass', 'B_perfil::save_pass', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/save_billing', 'B_perfil::save_billing', ['filter' => 'authGuard']);
//kyc
$routes->get('/backoffice_new/kyc', 'B_perfil::kyc', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/kyc_validate', 'B_perfil::kyc_validate', ['filter' => 'authGuard']);
//pin
$routes->get('/backoffice_new/pin', 'B_perfil::pin', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/save_pin', 'B_perfil::save_pin', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/recover_pin', 'B_perfil::recover_pin', ['filter' => 'authGuard']);
$routes->get('/recover-pin/(:any)', 'Forget::recover_pin/$1');
$routes->post('/pin/validate_pin', 'Forget::validate_pin');


//kit
$routes->get('/backoffice_new/kit', 'B_plan::kit', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/kit/carrito', 'B_plan::cart_kit', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/kit/checkout', 'B_plan::checkout_kit', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/kit/activar', 'B_plan::activar_kit', ['filter' => 'authGuard']);
// $routes->post('/backoffice_new/kit/carrito_delete', 'B_plan::delete_cart_kit', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/kit/carrito_delete', 'B_plan::delete_cart', ['filter' => 'authGuard']);

$routes->get('/backoffice_new/plan', 'B_plan::index', ['filter' => 'authGuard']);

//planes
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


//backoffice_new/planes/pago_tienda
$routes->post('/backoffice_new/planes/activar', 'B_plan::activar', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/planes/activar_monedero', 'B_plan::activar_monedero', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/planes/activar_tienda', 'B_plan::activar_tienda', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/planes/activar_tienda_product', 'B_plan::activar_tienda_product', ['filter' => 'authGuard']);


$routes->get('/backoffice_new/failure', 'B_plan::index', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/success', 'B_plan::success', ['filter' => 'authGuard']);
//historial
$routes->match(['get', 'post'], '/backoffice_new/historial', 'B_finanzas::index', ['filter' => 'authGuard']);

$routes->post('/admin/comisiones/cambiar_estado', 'ComisionesController::cambiar_estado', ['filter' => 'authGuard']);
$routes->post('/admin/comisiones/eliminar', 'ComisionesController::eliminar', ['filter' => 'authGuard']);

// Historial de Comisiones (menú "Historial/Comisiones")
$routes->get('/backoffice_new/historial/comisiones', 'ComisionesController::historial', ['filter' => 'authGuard']);
//facturas
$routes->get('/backoffice_new/facturas', 'B_finanzas::facturas', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/facturas/(:any)', 'B_finanzas::facturas_detail/$1', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/facturas/eliminar', 'B_finanzas::delete_invoice', ['filter' => 'authGuard']);

//carrera
$routes->get('/backoffice_new/carrera', 'B_carrera::index', ['filter' => 'authGuard']);
//ticket
$routes->get('/backoffice_new/ticket', 'B_ticket::index', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/ticket/send_ticket', 'B_ticket::send_ticket', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/ticket/(:any)', 'B_ticket::description/$1', ['filter' => 'authGuard']);
//sugerencias
$routes->get('/backoffice_new/sugerencias', 'B_suggestion::index', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/sugerencias/send', 'B_suggestion::send', ['filter' => 'authGuard']);
//materiales
$routes->get('/backoffice_new/documentos', 'B_files::index', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/documentos/media', 'B_files::media', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/documentos/presentacion', 'B_files::presentacion', ['filter' => 'authGuard']);
//cobros
$routes->get('/backoffice_new/cobros', 'B_cobros::index', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/pay/make_pay', 'B_cobros::make_pay', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/cobros/validate_wallet', 'B_cobros::validate_wallet', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/cobros/send_pin', 'B_cobros::send_pin', ['filter' => 'authGuard']);
//transferencias
$routes->get('/backoffice_new/envios', 'B_finanzas::transfer', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/envios/search_username', 'B_finanzas::search_username', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/envios/send_commission', 'B_finanzas::send_commission', ['filter' => 'authGuard']);
//unilevel
$routes->get('/backoffice_new/unilevel', 'B_network::unilevel', ['filter' => 'authGuard']);
$routes->get('/backoffice_new/unilevel/(:any)', 'B_network::unilevel', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/unilevel/up', 'B_network::up', ['filter' => 'authGuard']);
//referidos
$routes->get('/backoffice_new/directos', 'B_network::index', ['filter' => 'authGuard']);

// Renovación anual
$routes->get('/backoffice_new/renovacion', 'B_renovacion::index', ['filter' => 'authGuard']);
$routes->post('/backoffice_new/renovacion/pagar', 'B_renovacion::pagar', ['filter' => 'authGuard']);





$routes->get('/backoffice_new', 'Home::index', ['filter' => 'authGuard']);
//new customer
$routes->post('/dashboard/postNewCustomer', 'D_panel::postNewCustomer', ['filter' => 'authGuard']);
$routes->post('/dashboard/clientes/updateCustomer', 'D_clientes::updateCustomer', ['filter' => 'authGuard']);


$routes->match(['get', 'post'], '/backoffice/historial', 'B_finanzas::index', ['filter' => 'authGuard']);
$routes->get('/backoffice/facturas', 'B_finanzas::facturas', ['filter' => 'authGuard']);
$routes->get('/backoffice/envios', 'B_finanzas::envios', ['filter' => 'authGuard']);
$routes->post('/backoffice/envios/search_username', 'B_finanzas::search_username', ['filter' => 'authGuard']);
$routes->post('/backoffice/envios/send_commission', 'B_finanzas::send_commission', ['filter' => 'authGuard']);
$routes->match(['get', 'post'], '/backoffice/puntosbinario', 'B_finanzas::list_binarypoint', ['filter' => 'authGuard']);

//Para el adminisrador
$routes->get('/admin', 'B_admin::admin');
$routes->post('/dashboard/validate', 'B_admin::login_admin');
$routes->get('/dashboard/panel', 'D_panel::index', ['filter' => 'authGuard']);
// Ruta para generar PDF del contrato
$routes->get('admin/contrato_pdf/(:num)', 'B_admin::contrato_pdf/$1');
$routes->get('/admin/contrato_word/(:num)', 'B_admin::contrato_word/$1');

// RUTAS PARA MODULO DE COMPRAS
// NOTE: Routes now configured in group below at line 509+


//estrucuta
$routes->get('dashboard/inmueble/edit_contract/(:num)', 'Inmueble::edit_contract/$1', ['filter' => 'authGuard']);
$routes->post('dashboard/inmueble/edit_contract/(:num)', 'Inmueble::edit_contract/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/inmueble/api/delete_contract', 'Inmueble::delete_contract', ['filter' => 'authGuard']);
$routes->match(['get', 'post'], '/dashboard/estructura', 'D_panel::estructura', ['filter' => 'authGuard']);
$routes->post('/dashboard/estructura_up', 'D_panel::estructura_up', ['filter' => 'authGuard']);
$routes->get('/dashboard/estructura/(:num)', 'D_panel::estructura/$1', ['filter' => 'authGuard']);
//nuevo cliente
$routes->get('/dashboard/nuevo_socio', 'D_panel::nuevo_socio', ['filter' => 'authGuard']);


//modulo ventas
/* $routes->get('/dashboard/ventas', 'D_ventas::index', ['filter' => 'authGuard']); */
$routes->get('dashboard/ventas', 'D_ventas::index', ['filter' => 'authGuard']);
$routes->get('dashboard/test_token', 'D_ventas::test_token', ['filter' => 'authGuard']);
$routes->get('dashboard/test_api_debug', 'D_ventas::test_api_debug', ['filter' => 'authGuard']);
$routes->get('dashboard/get_boletas_api', 'D_ventas::get_boletas_api', ['filter' => 'authGuard']);


//modulo documentario
$routes->get('dashboard/documentario', 'D_documentario::index', ['filter' => 'authGuard']);

//nuevo venta
$routes->get('/dashboard/nueva_venta', 'D_nueva_venta::index', ['filter' => 'authGuard']);
$routes->match(['get', 'post'], '/dashboard/nueva_venta/carrito', 'D_nueva_venta::cart', ['filter' => 'authGuard']);
$routes->post('/dashboard/nueva_venta/update_cart', 'D_nueva_venta::update_cart', ['filter' => 'authGuard']);
$routes->post('/dashboard/nueva_venta/carrito_delete', 'D_nueva_venta::delete_cart', ['filter' => 'authGuard']);
$routes->post('/dashboard/nueva_venta/checkout', 'D_nueva_venta::checkout', ['filter' => 'authGuard']);
$routes->post('/dashboard/nueva_venta/nuevo_metodo', 'D_nueva_venta::new_method_payment', ['filter' => 'authGuard']);
$routes->post('/dashboard/nueva_venta/procesar_venta', 'D_nueva_venta::process_sale', ['filter' => 'authGuard']);

$routes->post('dashboard/api/consulta_dni', 'ApiController::consulta_dni');
//ventas
$routes->match(['get', 'post'], '/dashboard/ventas', 'D_panel::ventas', ['filter' => 'authGuard']);
$routes->match(['get', 'post'], '/dashboard/ventas/load/(:num)', 'D_panel::load/$1', ['filter' => 'authGuard']);
$routes->match(['get', 'post'], '/dashboard/ventas/export_pdf/(:any)', 'D_panel::export_pdf/$1', ['filter' => 'authGuard']);

//estrucuta
$routes->match(['get', 'post'], '/dashboard/calificados', 'D_panel::qualified', ['filter' => 'authGuard']);
$routes->get('/dashboard/calificados/ver/(:num)', 'D_panel::view_qualified/$1', ['filter' => 'authGuard']);


$routes->get('/dashboard/almacenes', 'D_almacenes::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/almacenes/load', 'D_almacenes::load', ['filter' => 'authGuard']);
$routes->get('/dashboard/almacenes/load/(:num)', 'D_almacenes::load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/almacenes/validate', 'D_almacenes::validacion', ['filter' => 'authGuard']);
$routes->post('/dashboard/almacenes/eliminar', 'D_almacenes::eliminar', ['filter' => 'authGuard']);

//periodos
$routes->get('/dashboard/periodos', 'D_periodos::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/periodos/load', 'D_periodos::load', ['filter' => 'authGuard']);
$routes->get('/dashboard/periodos/load/(:num)', 'D_periodos::load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/periodos/validate', 'D_periodos::validacion', ['filter' => 'authGuard']);


//sugerencias
$routes->get('/dashboard/sugerencias', 'D_sugerencias::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/sugerencias/load', 'D_sugerencias::load', ['filter' => 'authGuard']);
$routes->get('/dashboard/sugerencias/load/(:num)', 'D_sugerencias::load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/sugerencias/validate', 'D_sugerencias::validacion', ['filter' => 'authGuard']);
$routes->post('/dashboard/sugerencias/eliminar', 'D_sugerencias::eliminar', ['filter' => 'authGuard']);

//Crud comentarios
$routes->get('/dashboard/comentarios', 'D_comentarios::index', ['filter' => 'authGuard']);
$routes->post('/dashboard/comentarios/cambiar_status', 'D_comentarios::change_status', ['filter' => 'authGuard']);
$routes->get('/dashboard/comentarios/load/(:num)', 'D_comentarios::load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/comentarios/validate', 'D_comentarios::validacion', ['filter' => 'authGuard']);
$routes->post('/dashboard/comentarios/eliminar', 'D_comentarios::eliminar', ['filter' => 'authGuard']);

//Crud Bancos
$routes->get('/dashboard/bancos', 'D_bancos::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/bancos/load', 'D_bancos::load', ['filter' => 'authGuard']);
$routes->get('/dashboard/bancos/load/(:num)', 'D_bancos::load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/bancos/validate', 'D_bancos::validacion', ['filter' => 'authGuard']);
$routes->post('/dashboard/bancos/eliminar', 'D_bancos::eliminar', ['filter' => 'authGuard']);

//Crud Bonos 
$routes->get('/dashboard/bonos', 'D_bonos::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/bonos/load', 'D_bonos::load', ['filter' => 'authGuard']);
$routes->get('/dashboard/bonos/load/(:num)', 'D_bonos::load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/bonos/validate', 'D_bonos::validacion', ['filter' => 'authGuard']);
$routes->post('/dashboard/bonos/eliminar', 'D_bonos::eliminar', ['filter' => 'authGuard']);

//kyc
$routes->get('/dashboard/kyc_pendientes', 'D_kyc::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/kyc_verificados', 'D_kyc::kyc_verificados', ['filter' => 'authGuard']);
$routes->post('/dashboard/kyc/cambiar_verificado', 'D_kyc::verificado', ['filter' => 'authGuard']);
$routes->post('/dashboard/kyc/cambiar_rechazado', 'D_kyc::rechazado', ['filter' => 'authGuard']);

//recarga
$routes->get('/dashboard/recargas_pendientes', 'D_recarga::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/recargas_completas', 'D_recarga::completed', ['filter' => 'authGuard']);
$routes->post('/dashboard/recargas_pendientes/cambiar_verificado', 'D_recarga::verificado', ['filter' => 'authGuard']);
$routes->post('/dashboard/recargas_pendientes/cambiar_rechazado', 'D_recarga::rechazado', ['filter' => 'authGuard']);
$routes->get('/dashboard/recargas_pendientes/load/(:num)', 'D_recarga::load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/recargas_pendientes/validate', 'D_recarga::validacion', ['filter' => 'authGuard']);
$routes->post('/dashboard/recargas_pendientes/eliminar', 'D_recarga::eliminar', ['filter' => 'authGuard']);

//Crud Comisiones
$routes->match(['get', 'post'], '/dashboard/comisiones', 'D_comisiones::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/comisiones/load/(:num)', 'D_comisiones::load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/comisiones/validate', 'D_comisiones::validacion', ['filter' => 'authGuard']);
$routes->post('/dashboard/comisiones/eliminar', 'D_comisiones::eliminar', ['filter' => 'authGuard']);
/* $routes->post('/dashboard/facturas/emitirFactura', 'D_facturas::emitirFactura', ['filter' => 'authGuard']); */
//Crud Facturas
$routes->get('dashboard/inmueble/contracts/view/(:num)', 'Inmueble::view_contract/$1', ['filter' => 'authGuard']);
$routes->get('/dashboard/facturas', 'D_facturas::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/facturas/load/(:num)', 'D_facturas::load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/facturas/validate', 'D_facturas::validacion', ['filter' => 'authGuard']);
$routes->post('/dashboard/facturas/delete', 'D_facturas::eliminar', ['filter' => 'authGuard']);
$routes->post('/dashboard/facturas/emitirFactura', 'D_facturas::emitirFactura', ['filter' => 'authGuard']);
//Crud Membership
$routes->get('/dashboard/planes', 'D_planes::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/planes/load', 'D_planes::load', ['filter' => 'authGuard']);
$routes->get('/dashboard/planes/load/(:num)', 'D_planes::load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/planes/validate', 'D_planes::validacion', ['filter' => 'authGuard']);
$routes->post('/dashboard/planes/eliminar', 'D_planes::eliminar', ['filter' => 'authGuard']);

//Crud concepto_ticket
$routes->get('/dashboard/concepto_ticket', 'D_concepto_ticket::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/concepto_ticket/load', 'D_concepto_ticket::load', ['filter' => 'authGuard']);
$routes->get('/dashboard/concepto_ticket/load/(:num)', 'D_concepto_ticket::load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/concepto_ticket/validate', 'D_concepto_ticket::validacion', ['filter' => 'authGuard']);
$routes->post('/dashboard/concepto_ticket/eliminar', 'D_concepto_ticket::eliminar', ['filter' => 'authGuard']);

//Crud pagos
$routes->get('/dashboard/pagos', 'D_pagos::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/pagos/load', 'D_pagos::load', ['filter' => 'authGuard']);
$routes->get('/dashboard/pagos/load/(:num)', 'D_pagos::load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/pagos/validate', 'D_pagos::validacion', ['filter' => 'authGuard']);
$routes->post('/dashboard/pagos/eliminar', 'D_pagos::eliminar', ['filter' => 'authGuard']);

//Crud puntos
$routes->get('/dashboard/puntos', 'D_puntos::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/puntos/load/(:num)', 'D_puntos::load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/puntos/validate', 'D_puntos::validacion', ['filter' => 'authGuard']);
$routes->post('/dashboard/puntos/eliminar', 'D_puntos::eliminar', ['filter' => 'authGuard']);

//Crud Clientes 
$routes->get('/dashboard/clientes', 'D_clientes::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/clientes/create', 'D_clientes::create', ['filter' => 'authGuard']);
$routes->post('/dashboard/clientes/store', 'D_clientes::store', ['filter' => 'authGuard']);
$routes->get('/dashboard/clientes/load/(:num)', 'D_clientes::load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/clientes/update', 'D_clientes::update', ['filter' => 'authGuard']);
$routes->post('/dashboard/clientes/validate', 'D_clientes::validacion', ['filter' => 'authGuard']);
$routes->post('/dashboard/clientes/eliminar', 'D_clientes::eliminar', ['filter' => 'authGuard']);
$routes->post('/dashboard/clientes/validacion', 'D_clientes::validacion');
//Crud kit de afiliación

// Ruta para asignar/modificar patrocinador a clientes (admin)
$routes->get('/dashboard/clientes/asignar_patocinador', 'D_clientes::asignar_patocinador', ['filter' => 'authGuard']);

// Ruta alternativa para acceder desde /admin/clientes/asignar_patocinador
$routes->get('/admin/clientes/asignar_patocinador', 'D_clientes::asignar_patocinador', ['filter' => 'authGuard']);
$routes->get('/dashboard/kit_afiliacion', 'D_kit_afiliacion::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/kit_afiliacion/load', 'D_kit_afiliacion::load', ['filter' => 'authGuard']);
$routes->get('/dashboard/kit_afiliacion/load/(:num)', 'D_kit_afiliacion::load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/kit_afiliacion/validate', 'D_kit_afiliacion::validacion', ['filter' => 'authGuard']);
$routes->post('/dashboard/kit_afiliacion/eliminar', 'D_kit_afiliacion::eliminar', ['filter' => 'authGuard']);

// Inmueble routes (grouped and ordered)
$routes->group('dashboard/inmueble', static function($routes){
        // Rechazar contrato
        $routes->post('reject_contract', 'Inmueble::reject_contract', ['filter' => 'authGuard']);
    // Page views
    $routes->get('', 'Inmueble::index', ['filter' => 'authGuard']);
    $routes->get('projects', 'Inmueble::projects', ['filter' => 'authGuard']);
    $routes->get('lots', 'Inmueble::lots', ['filter' => 'authGuard']);
    $routes->get('lots/(:num)', 'Inmueble::lots/$1', ['filter' => 'authGuard']);
    $routes->get('payment_plans', 'Inmueble::payment_plans', ['filter' => 'authGuard']);
    $routes->get('payment_plans/create_payment_plan', 'Inmueble::create_payment_plan', ['filter' => 'authGuard']);
    $routes->get('contracts', 'Inmueble::contracts', ['filter' => 'authGuard']);

    // Projects CRUD
    $routes->post('create_project', 'Inmueble::create_project', ['filter' => 'authGuard']);
    $routes->get('edit_project/(:num)', 'Inmueble::edit_project/$1', ['filter' => 'authGuard']);
    $routes->post('edit_project/(:num)', 'Inmueble::edit_project/$1', ['filter' => 'authGuard']);
    $routes->get('delete_project/(:num)', 'Inmueble::delete_project/$1', ['filter' => 'authGuard']);

    // Lots CRUD
    $routes->get('create_lot', 'Inmueble::create_lot', ['filter' => 'authGuard']);
    $routes->post('create_lot', 'Inmueble::create_lot', ['filter' => 'authGuard']);
    $routes->get('edit_lot/(:num)', 'Inmueble::edit_lot/$1', ['filter' => 'authGuard']);
    $routes->post('edit_lot/(:num)', 'Inmueble::edit_lot/$1', ['filter' => 'authGuard']);
    $routes->get('delete_lot/(:num)', 'Inmueble::delete_lot/$1', ['filter' => 'authGuard']);

    // Contracts / reserve
    $routes->post('create_contract', 'Inmueble::create_contract', ['filter' => 'authGuard']);
    $routes->post('reserve_lot', 'Inmueble::reserve_lot', ['filter' => 'authGuard']);

    // API endpoints (ajax)
    $routes->get('api/get_project/(:num)', 'Inmueble::get_project/$1', ['filter' => 'authGuard']);
    $routes->get('api/projects', 'Inmueble::get_projects_api', ['filter' => 'authGuard']);
    $routes->get('api/get_lot/(:num)', 'Inmueble::get_lot/$1', ['filter' => 'authGuard']);
    $routes->get('api/get_lot_details/(:num)', 'Inmueble::get_lot_details/$1', ['filter' => 'authGuard']);
    $routes->get('api/project_lots/(:num)', 'Inmueble::get_project_lots/$1', ['filter' => 'authGuard']);
    $routes->post('api/update_lot_status', 'Inmueble::update_lot_status', ['filter' => 'authGuard']);
    $routes->post('api/search_customers', 'Inmueble::search_customers', ['filter' => 'authGuard']);
    $routes->get('api/get_available_lots', 'Inmueble::get_available_lots', ['filter' => 'authGuard']);
    $routes->get('api/payment_plans', 'Inmueble::get_payment_plans_api', ['filter' => 'authGuard']);
    $routes->get('api/get_payment_plan/(:num)', 'Inmueble::get_payment_plan_api/$1', ['filter' => 'authGuard']);
    $routes->get('api/plan_contract_stats/(:num)', 'Inmueble::get_plan_contract_stats/$1', ['filter' => 'authGuard']);
    $routes->post('update_payment_plan/(:num)', 'Inmueble::update_payment_plan/$1', ['filter' => 'authGuard']);
    $routes->post('api/update_plan_status', 'Inmueble::update_plan_status', ['filter' => 'authGuard']);
    $routes->delete('api/delete_payment_plan/(:num)', 'Inmueble::delete_payment_plan/$1', ['filter' => 'authGuard']);
    $routes->post('api/update_contract_status', 'Inmueble::update_contract_status', ['filter' => 'authGuard']);
    $routes->post('api/delete_contract', 'Inmueble::delete_contract', ['filter' => 'authGuard']);

    // Utilities (non-auth) for selects
    $routes->get('getDepartments', 'Inmueble::getDepartments');
    $routes->get('getProvinces/(:num)', 'Inmueble::getProvinces/$1');
    $routes->get('getDistricts/(:num)', 'Inmueble::getDistricts/$1');

    // Misc: reminders
    $routes->post('enviar_recordatorios_vencimiento', 'Inmueble::enviar_recordatorios_vencimiento', ['filter' => 'authGuard']);
    // ...existing code...
});

// Gastos (Expenses) routes - NOTA: Rutas de Compras están al inicio del archivo
$routes->group('dashboard/gastos', static function($routes){
    // Main views
    $routes->get('', 'D_gastos::index', ['filter' => 'authGuard']);
    $routes->get('reporte', 'D_gastos::reporte', ['filter' => 'authGuard']);
    $routes->get('analitico', 'D_gastos::analitico', ['filter' => 'authGuard']);
    $routes->get('pendientes', 'D_gastos::pendientes', ['filter' => 'authGuard']);
    $routes->get('comparativo', 'D_gastos::comparativo', ['filter' => 'authGuard']);
    
    // Actions
    $routes->post('exportar', 'D_gastos::exportar', ['filter' => 'authGuard']);
    
    // API endpoints
    $routes->get('api/gastos-por-proyecto', 'D_gastos::gastosPorProyecto', ['filter' => 'authGuard']);
    $routes->get('api/estadisticas', 'D_gastos::estadisticas', ['filter' => 'authGuard']);
});

// Clasificación de Gastos routes
$routes->group('dashboard/clasificacion', static function($routes){
    // Main views
    $routes->get('', 'D_clasificacion::index', ['filter' => 'authGuard']);
    $routes->get('clasificar/(:num)', 'D_clasificacion::clasificar/$1', ['filter' => 'authGuard']);
    $routes->get('reportes', 'D_clasificacion::reportes', ['filter' => 'authGuard']);
    $routes->get('informe', 'D_clasificacion::informe', ['filter' => 'authGuard']);
    $routes->get('descargar-informe-pdf', 'D_clasificacion::descargarInformePDF', ['filter' => 'authGuard']);
    $routes->get('crear-reporte', 'D_clasificacion::crearReporte', ['filter' => 'authGuard']);
    $routes->get('ver-reporte/(:num)', 'D_clasificacion::verReporte/$1', ['filter' => 'authGuard']);
    
    // AJAX Actions
    $routes->get('detalles/(:num)', 'D_clasificacion::detalles/$1', ['filter' => 'authGuard']);
    $routes->post('guardarClasificacion', 'D_clasificacion::guardarClasificacion', ['filter' => 'authGuard']);
    $routes->get('subcategoriasPorTipo/(:num)', 'D_clasificacion::subcategoriasPorTipo/$1', ['filter' => 'authGuard']);
    $routes->post('subirDocumento/(:num)', 'D_clasificacion::subirDocumento/$1', ['filter' => 'authGuard']);
    $routes->post('eliminarDocumento/(:num)', 'D_clasificacion::eliminarDocumento/$1', ['filter' => 'authGuard']);
    $routes->post('guardarReporte', 'D_clasificacion::guardarReporte', ['filter' => 'authGuard']);
});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

$routes->post('/dashboard/integracion_pagos/validate_user', 'D_integracion_pagos::validate_user', ['filter' => 'authGuard']);
$routes->post('/dashboard/integracion_pagos/active', 'D_integracion_pagos::active', ['filter' => 'authGuard']);
$routes->post('/dashboard/integracion_pagos/delete', 'D_integracion_pagos::eliminar', ['filter' => 'authGuard']);

//Integración Descuentos
$routes->get('/dashboard/descuentos_pagos', 'D_integracion_pagos::descuentos', ['filter' => 'authGuard']);
$routes->get('/dashboard/descuentos_pagos/load', 'D_integracion_pagos::descuentos_load', ['filter' => 'authGuard']);
$routes->get('/dashboard/descuentos_pagos/load/(:num)', 'D_integracion_pagos::descuentos_load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/descuentos_pagos/validate_user', 'D_integracion_pagos::validate_user', ['filter' => 'authGuard']);
$routes->post('/dashboard/descuentos_pagos/active_discount', 'D_integracion_pagos::active_descuento', ['filter' => 'authGuard']);
$routes->post('/dashboard/descuentos_pagos/delete', 'D_integracion_pagos::eliminar', ['filter' => 'authGuard']);

//Integración Puntos Binario
$routes->get('/dashboard/integracion_puntos', 'D_integracion_pagos::puntos', ['filter' => 'authGuard']);
$routes->get('/dashboard/integracion_puntos/load', 'D_integracion_pagos::puntos_load', ['filter' => 'authGuard']);
$routes->get('/dashboard/integracion_puntos/load/(:num)', 'D_integracion_pagos::puntos_load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/integracion_puntos/validate_user', 'D_integracion_pagos::validate_user', ['filter' => 'authGuard']);
$routes->post('/dashboard/integracion_puntos/active_points', 'D_integracion_pagos::active_puntos', ['filter' => 'authGuard']);
$routes->post('/dashboard/integracion_puntos/delete', 'D_integracion_pagos::eliminar_point_binary', ['filter' => 'authGuard']);

//Integración Puntos Rango
$routes->get('/dashboard/integracion_puntos_rango', 'D_integracion_pagos::rangos', ['filter' => 'authGuard']);
$routes->get('/dashboard/integracion_puntos_rango/load', 'D_integracion_pagos::rangos_load', ['filter' => 'authGuard']);
$routes->get('/dashboard/integracion_puntos_rango/load/(:num)', 'D_integracion_pagos::rangos_load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/integracion_puntos_rango/validate_user', 'D_integracion_pagos::validate_user', ['filter' => 'authGuard']);
$routes->post('/dashboard/integracion_puntos_rango/active_points', 'D_integracion_pagos::active_puntos_rangos', ['filter' => 'authGuard']);
$routes->post('/dashboard/integracion_puntos_rango/delete', 'D_integracion_pagos::eliminar_point_rangos', ['filter' => 'authGuard']);

// Soporte
$routes->get('/dashboard/ticket', 'D_ticket::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/ticket/load/(:num)', 'D_ticket::load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/ticket/validate', 'D_ticket::validacion', ['filter' => 'authGuard']);
$routes->post('/dashboard/ticket/delete', 'D_ticket::eliminar', ['filter' => 'authGuard']);

//kardex
$routes->match(['get', 'post'], '/dashboard/kardex', 'D_kardex::index', ['filter' => 'authGuard']);
$routes->post('/dashboard/kardex/export', 'D_kardex::export', ['filter' => 'authGuard']);

$routes->match(['get', 'post'], '/dashboard/inventario', 'D_kardex::inventario', ['filter' => 'authGuard']);
$routes->post('/dashboard/inventario/export', 'D_kardex::inventario_export', ['filter' => 'authGuard']);

//entradas
$routes->match(['get', 'post'], '/dashboard/entradas', 'D_incoming::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/entradas/load', 'D_incoming::load', ['filter' => 'authGuard']);
$routes->get('/dashboard/entradas/load/(:num)', 'D_incoming::load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/entradas/validate', 'D_incoming::validacion', ['filter' => 'authGuard']);
$routes->post('/dashboard/entradas/delete', 'D_incoming::eliminar', ['filter' => 'authGuard']);
$routes->post('/dashboard/entradas/save_csv', 'D_incoming::save_csv', ['filter' => 'authGuard']);
$routes->post('/dashboard/entradas/export', 'D_incoming::export', ['filter' => 'authGuard']);
$routes->post('/dashboard/entradas/get_unit_cost', 'D_incoming::get_unit_cost', ['filter' => 'authGuard']);

//salidas
$routes->match(['get', 'post'], '/dashboard/salidas', 'D_outgoing::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/salidas/load', 'D_outgoing::load', ['filter' => 'authGuard']);
$routes->get('/dashboard/salidas/load/(:num)', 'D_outgoing::load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/salidas/validate', 'D_outgoing::validacion', ['filter' => 'authGuard']);
$routes->post('/dashboard/salidas/delete', 'D_outgoing::eliminar', ['filter' => 'authGuard']);
$routes->post('/dashboard/salidas/save_csv', 'D_outgoing::save_csv', ['filter' => 'authGuard']);
$routes->post('/dashboard/salidas/export', 'D_outgoing::export', ['filter' => 'authGuard']);


//proveedores
$routes->get('/dashboard/proveedores', 'D_supplier::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/proveedores/load', 'D_supplier::load', ['filter' => 'authGuard']);
$routes->get('/dashboard/proveedores/load/(:num)', 'D_supplier::load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/proveedores/validate', 'D_supplier::validacion', ['filter' => 'authGuard']);
$routes->post('/dashboard/proveedores/delete', 'D_supplier::eliminar', ['filter' => 'authGuard']);

//traspaso
$routes->get('/dashboard/traspaso', 'D_transfer::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/traspaso/load', 'D_transfer::load', ['filter' => 'authGuard']);
$routes->get('/dashboard/traspaso/load/(:num)', 'D_transfer::load/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/traspaso/validate', 'D_transfer::validacion', ['filter' => 'authGuard']);
$routes->post('/dashboard/traspaso/get_max_product', 'D_transfer::get_max_product', ['filter' => 'authGuard']);

// Reportes
//clientes
$routes->match(['get', 'post'], '/dashboard/reportes_clientes', 'D_report::index', ['filter' => 'authGuard']);
$routes->post('/dashboard/reportes/export_clientes', 'D_report::export_clientes', ['filter' => 'authGuard']);

//ventas
$routes->match(['get', 'post'], '/dashboard/reportes_ventas', 'D_report::ventas', ['filter' => 'authGuard']);
$routes->post('/dashboard/reportes/export_ventas', 'D_report::export_ventas', ['filter' => 'authGuard']);

//pagos
$routes->match(['get', 'post'], '/dashboard/reportes_pagos', 'D_report::pagos', ['filter' => 'authGuard']);
$routes->post('/dashboard/reportes/export_pagos', 'D_report::export_pagos', ['filter' => 'authGuard']);

//ganancias
$routes->match(['get', 'post'], '/dashboard/reportes_ganancias', 'D_report::ganancias', ['filter' => 'authGuard']);
$routes->post('/dashboard/reportes_ganancias/descontar', 'D_report::ganancias_discount', ['filter' => 'authGuard']);
$routes->post('/dashboard/reportes/export_ganancias', 'D_report::export_ganancias', ['filter' => 'authGuard']);

$routes->get('/logout', 'Home::logout');
$routes->get('/salir', 'Home::logout');
$routes->get('/dashboard/logout', 'Home::adm_logout');
// Rutas para selects dinámicos de ubicación
$routes->get('dashboard/inmueble/getDepartments', 'Inmueble::getDepartments');
$routes->get('dashboard/inmueble/getProvinces/(:num)', 'Inmueble::getProvinces/$1');
$routes->get('dashboard/inmueble/getDistricts/(:num)', 'Inmueble::getDistricts/$1');
$routes->post('/dashboard/facturas/generarFactura', 'D_facturas::generarFactura', ['filter' => 'authGuard']);

$routes->get('/dashboard/penalties/apply', 'Penalties::applyPenalties');
$routes->get('/dashboard/penalties', 'Penalties::index', ['filter' => 'authGuard']);
$routes->get('/dashboard/penalties/view/(:num)', 'Penalties::view/$1', ['filter' => 'authGuard']);
$routes->post('/dashboard/penalties/mark_paid', 'Penalties::markPaid', ['filter' => 'authGuard']);
$routes->post('/dashboard/penalties/delete', 'Penalties::delete', ['filter' => 'authGuard']);

// Ruta para editar proyecto inmueble en Dashboard
$routes->post('/dashboard/inmueble/enviar_recordatorios_vencimiento', 'Inmueble::enviar_recordatorios_vencimiento', ['filter' => 'authGuard']);

$routes->get('/dashboard/usuarios', 'D_usuarios::index', ['filter' => 'authGuard']);
$routes->get('/admin/comisiones/inmobiliaria', 'ComisionesController::inmobiliaria', ['filter' => 'authGuard']); 
$routes->get('/admin/comisiones/multinivel_demo', function() {
    echo view('admin/comisiones/multinivel_demo');
}, ['filter' => 'authGuard']);
$routes->get('/dashboard/usuarios/load/(:num)', 'D_usuarios::load/$1', ['filter' => 'authGuard']);
$routes->get('/dashboard/inmueble/api/get_customer/(:num)', 'Inmueble::get_customer/$1', ['filter' => 'authGuard']);
$routes->get('/dashboard/inmueble/api/get_lot_details/(:num)', 'Inmueble::get_lot_details/$1', ['filter' => 'authGuard']);
$routes->get('/dashboard/inmueble/api/get_contract_details/(:num)', 'Inmueble::get_contract_details/$1', ['filter' => 'authGuard']);

// RUTA CATCH-ALL - DEBE IR AL FINAL para no capturar rutas explícitas
$routes->get('/(:any)', 'Home::otras');


//rutas para generar documentos
$routes->post('/dashboard/operacion-facturacion', 'D_ventas::operacion_facturacion', ['filter' => 'authGuard']);
$routes->post('/dashboard/debug-eliminar', 'D_ventas::debug_eliminar', ['filter' => 'authGuard']);