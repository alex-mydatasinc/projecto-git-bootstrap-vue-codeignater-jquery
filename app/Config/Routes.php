<?php

namespace Config;
use App\Controllers\BaseController;
use App\Controllers\AuthController;
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

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->post('login', 'AuthController::auth_login');
$routes->get('logout', 'AuthController::logout');
$routes->get('login_in', 'AuthController::index');

$routes->get('/register','AuthController::indexregister');
$routes->post('auth/register','AuthController::save');

$routes->get('/pais', 'Paises::index', ['filter' => 'auth']);
$routes->get('paises', 'Paises::list', ['filter' => 'auth']);
$routes->post('paises/categorias', 'CategoriasController::get_categorias', ['filter' => 'auth']);
$routes->post('paises/detalle', 'CategoriasController::get_detalle', ['filter' => 'auth']);
$routes->get('paises/atributos/(:alphanum)', 'CategoriasController::get_atributos/$1', ['filter' => 'auth']);
$routes->get('dashboard', 'DashboardController::index', ['filter' => 'auth']);
$routes->get('dashboard/productos', 'ProductoController::index', ['filter' => 'auth']);
$routes->get('dashboard/productos/list', 'ProductoController::list', ['filter' => 'auth']);
$routes->get('dashboard/get_productos', 'ProductoController::get_productos', ['filter' => 'auth']);
$routes->get('dashboard/productos/Generar', 'ProductoController::productos_user');
$routes->post('dashboard/productos/update', 'ProductoController::update_productos', ['filter' => 'auth']);
$routes->post('dashboard/productos/store', 'ProductoController::store_producto', ['filter' => 'auth']);
$routes->post('dashboard/productos/delete', 'ProductoController::delete_producto', ['filter' => 'auth']);

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
