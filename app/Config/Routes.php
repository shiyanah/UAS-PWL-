<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('/page-faq', 'Home::faq');

// PERBAIKAN: Menggunakan FilterStokController untuk rute filter-stok
$routes->get('filter-stok', 'FilterStokController::index');
$routes->get('filter-stok/export-pdf', 'FilterStokController::exportPdf');

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

$routes->group('produk', ['filter' => 'auth', 'filter' => 'role:admin'], function ($routes) { // Tambahkan filter role admin
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

$routes->get('profile', 'Home::profile', ['filter' => 'auth']); // Mengarah ke halaman profil yang baru

// Rute untuk manajemen pesanan (admin)
$routes->group('pesanan', ['filter' => 'auth', 'filter' => 'role:admin'], function ($routes) { // Hanya untuk admin
    $routes->get('/', 'PesananController::index');
    $routes->get('detail/(:num)', 'PesananController::detail/$1');
    $routes->post('updateStatus/(:num)', 'PesananController::updateStatus/$1');
    $routes->get('delete/(:num)', 'PesananController::delete/$1');
});

// Rute untuk riwayat pesanan pelanggan
$routes->get('riwayat-pesanan', 'PesananController::riwayat', ['filter' => 'auth']); // Hanya user yang login

$routes->resource('api', ['controller' => 'ApiController']);
