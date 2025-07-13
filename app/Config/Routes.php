<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('/page-faq', 'Home::faq');

// Rute untuk halaman detail produk
$routes->get('produk_detail/(:num)', 'ProductController::detail/$1', ['filter' => 'auth']); // Perbaiki controller ke ProductController

// PERBAIKAN: Menggunakan FilterStokController untuk rute filter-stok
$routes->get('filter-stok', 'FilterStokController::index');
$routes->get('filter-stok/export-pdf', 'FilterStokController::exportPdf');

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

// Rute untuk produk (hanya untuk admin)
// Menggabungkan filter 'auth' dan 'role:admin' dalam satu definisi group
$routes->group('produk', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('', 'ProductController::index');
    $routes->post('', 'ProductController::create');
    $routes->post('edit/(:any)', 'ProductController::edit/$1');
    $routes->get('delete/(:any)', 'ProductController::delete/$1');
    $routes->get('download', 'ProductController::download');
});


$routes->group('keranjang', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'TransaksiController::index');
    $routes->post('', 'TransaksiController::cart_add');
    $routes->post('edit', 'TransaksiController::cart_edit');
    $routes->get('delete/(:any)', 'TransaksiController::cart_delete/$1');
    $routes->get('clear', 'TransaksiController::cart_clear');
});
$routes->get('checkout', 'TransaksiController::checkout', ['filter' => 'auth']);

$routes->get('get-location', 'TransaksiController::getLocation', ['filter' => 'auth']);
$routes->get('get-cost', 'TransaksiController::getCost', ['filter' => 'auth']);
$routes->post('buy', 'TransaksiController::buy', ['filter' => 'auth']);

$routes->get('profile', 'Home::profile', ['filter' => 'auth']);

// Rute untuk manajemen pesanan (admin)
$routes->group('pesanan', ['filter' => ['auth', 'role:admin']], function ($routes) { // Hanya untuk admin
    $routes->get('/', 'PesananController::index');
    $routes->get('detail/(:num)', 'PesananController::detail/$1');
    $routes->post('updateStatus/(:num)', 'PesananController::updateStatus/$1');
    $routes->get('delete/(:num)', 'PesananController::delete/$1');
});

// Rute untuk riwayat pesanan pelanggan
$routes->get('riwayat-pesanan', 'PesananController::riwayat', ['filter' => 'auth']); // Hanya user yang login

$routes->resource('api', ['controller' => 'ApiController']);