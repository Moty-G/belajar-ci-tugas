<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

$routes->group('produk', ['filter' => 'auth'], function ($routes) { 
    $routes->get('', 'ProdukController::index');
    $routes->post('', 'ProdukController::create');
    $routes->post('edit/(:any)', 'ProdukController::edit/$1');
    $routes->get('delete/(:any)', 'ProdukController::delete/$1');
    $routes->get('download', 'ProdukController::download');
});

$routes->group('keranjang', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'TransaksiController::index');
    $routes->post('', 'TransaksiController::cart_add');
    $routes->post('edit', 'TransaksiController::cart_edit');
    $routes->get('delete/(:any)', 'TransaksiController::cart_delete/$1');
    $routes->get('clear', 'TransaksiController::cart_clear');
    $routes->get('checkout', 'TransaksiController::checkout');

});

$routes->get('keranjang', 'TransaksiController::index', ['filter' => 'auth']);
$routes->get('profile', 'Home::profile', ['filter' => 'role']);

$routes->get('checkout', 'TransaksiController::checkout', ['filter' => 'auth']);
$routes->post('buy', 'TransaksiController::buy', ['filter' => 'auth']);
$routes->get('history', 'TransaksiController::history', ['filter' => 'auth']);

$routes->get('ajax/destinations','TransaksiController::destinations', ['filter' => 'auth']);
$routes->get('ajax/costs','TransaksiController::costs', ['filter' => 'auth']);

$routes->resource('api/products', ['controller' => 'Api\ProdukController']);

$routes->get('api/transactions', 'Api\TransaksiController::index');

// API Discount (Soal 6)
$routes->get('api/discounts', 'Api\Discount::index');
$routes->get('api/discounts/(:num)', 'Api\Discount::show/$1');
$routes->post('api/discounts', 'Api\Discount::create');
$routes->put('api/discounts/(:num)', 'Api\Discount::update/$1');
$routes->delete('api/discounts/(:num)', 'Api\Discount::delete/$1');

// Admin: Diskon (Soal 3)
$routes->group('diskon', ['filter' => 'admin_role'], function ($routes) {
    $routes->get('/', 'Diskon::index');
    $routes->post('store', 'Diskon::store');
    $routes->post('update/(:num)', 'Diskon::update/$1');
    $routes->get('delete/(:num)', 'Diskon::delete/$1');
});

// Admin: Pembelian (Soal 5)
$routes->group('pembelian', ['filter' => 'admin_role'], function ($routes) {
    $routes->get('/', 'Pembelian::index');
    $routes->post('status/(:num)', 'Pembelian::updateStatus/$1');
});