/**
* RUTAS PARA MÓDULOS NUEVOS
* Agrega estas rutas a tu archivo app/Config/Routes.php
*/

// ===== MÓDULO BANCARIO =====
$routes->group('admin/bancario', ['namespace' => 'App\Controllers'], function($routes) {
$routes->get('cuentas', 'Bancario::cuentas');
$routes->get('crear_cuenta', 'Bancario::crear_cuenta');
$routes->post('crear_cuenta', 'Bancario::crear_cuenta');
$routes->get('editar_cuenta/(:num)', 'Bancario::editar_cuenta/$1');
$routes->post('editar_cuenta/(:num)', 'Bancario::editar_cuenta/$1');
$routes->get('movimientos/(:num)', 'Bancario::movimientos/$1');
$routes->get('agregar_movimiento/(:num)', 'Bancario::agregar_movimiento/$1');
$routes->post('agregar_movimiento/(:num)', 'Bancario::agregar_movimiento/$1');
$routes->get('conciliaciones', 'Bancario::conciliaciones');
$routes->get('crear_conciliacion', 'Bancario::crear_conciliacion');
$routes->post('crear_conciliacion', 'Bancario::crear_conciliacion');
});

// ===== MÓDULO PAGOS =====
$routes->group('pagos', ['namespace' => 'App\Controllers'], function($routes) {
$routes->get('proveedores', 'Pagos::proveedores');
$routes->get('crear_proveedor', 'Pagos::crear_proveedor');
$routes->post('crear_proveedor', 'Pagos::crear_proveedor');
$routes->get('editar_proveedor/(:num)', 'Pagos::editar_proveedor/$1');
$routes->post('editar_proveedor/(:num)', 'Pagos::editar_proveedor/$1');
$routes->get('comisiones', 'Pagos::comisiones');
$routes->get('crear_comision', 'Pagos::crear_comision');
$routes->post('crear_comision', 'Pagos::crear_comision');
$routes->get('pagos_proveedores', 'Pagos::pagos_proveedores');
$routes->get('registrar_pago', 'Pagos::registrar_pago');
$routes->post('registrar_pago', 'Pagos::registrar_pago');
$routes->get('recibos_honorarios', 'Pagos::recibos_honorarios');
$routes->get('crear_recibo', 'Pagos::crear_recibo');
$routes->post('crear_recibo', 'Pagos::crear_recibo');
});

// ===== MÓDULO TRIBUTARIO =====
$routes->group('tributario', ['namespace' => 'App\Controllers'], function($routes) {
$routes->get('compras', 'Tributario::compras');
$routes->get('registrar_compra', 'Tributario::registrar_compra');
$routes->post('registrar_compra', 'Tributario::registrar_compra');
$routes->get('ventas', 'Tributario::ventas');
$routes->get('registrar_venta', 'Tributario::registrar_venta');
$routes->post('registrar_venta', 'Tributario::registrar_venta');
$routes->get('declaraciones', 'Tributario::declaraciones');
$routes->get('crear_declaracion', 'Tributario::crear_declaracion');
$routes->post('crear_declaracion', 'Tributario::crear_declaracion');
$routes->get('costo_proyecto', 'Tributario::costo_proyecto');
$routes->get('registrar_costo', 'Tributario::registrar_costo');
$routes->post('registrar_costo', 'Tributario::registrar_costo');
$routes->get('clasificacion_compras', 'Tributario::clasificacion_compras');
});

// ===== MÓDULO DOCUMENTAL =====
$routes->group('documental', ['namespace' => 'App\Controllers'], function($routes) {
$routes->get('archivos', 'Documental::archivos');
$routes->get('subir_archivo', 'Documental::subir_archivo');
$routes->post('subir_archivo', 'Documental::subir_archivo');
$routes->get('descargar_archivo/(:num)', 'Documental::descargar_archivo/$1');
$routes->get('eliminar_archivo/(:num)', 'Documental::eliminar_archivo/$1');
$routes->get('requerimientos', 'Documental::requerimientos');
$routes->get('crear_requerimiento', 'Documental::crear_requerimiento');
$routes->post('crear_requerimiento', 'Documental::crear_requerimiento');
$routes->get('actualizar_requerimiento/(:num)', 'Documental::actualizar_requerimiento/$1');
$routes->post('actualizar_requerimiento/(:num)', 'Documental::actualizar_requerimiento/$1');
$routes->get('documentos', 'Documental::documentos');
$routes->get('crear_documento', 'Documental::crear_documento');
$routes->post('crear_documento', 'Documental::crear_documento');
});