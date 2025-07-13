<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('/page-faq', 'Home::faq');

$routes->get('filter-stok', 'FilterStokController::index');
$routes->get('filter-stok/export-pdf', 'FilterStokController::exportPdf');

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

$routes->group('produk', ['filter' => 'auth', 'filter' => 'role:admin'], function ($routes) {
    $routes->get('', 'ProductController::index');
    $routes->post('', 'ProductController::create');
    $routes->post('edit/(:any)', 'ProductController::edit/$1');
    $routes->get('delete/(:any)', 'ProductController::delete/$1');
    $routes->get('download', 'ProductController::download');
});

$routes->get('produk_detail/(:num)', 'ProductController::detail/$1');

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

$routes->group('pesanan', ['filter' => 'auth', 'filter' => 'role:admin'], function ($routes) {
    $routes->get('/', 'PesananController::index');
    $routes->get('detail/(:num)', 'PesananController::detail/$1');
    $routes->post('updateStatus/(:num)', 'PesananController::updateStatus/$1');
    $routes->get('delete/(:num)', 'PesananController::delete/$1');
});

$routes->get('riwayat-pesanan', 'PesananController::riwayat', ['filter' => 'auth']);
$routes->get('riwayat-pesanan/detail/(:num)', 'PesananController::detail/$1');

$routes->resource('api', ['controller' => 'ApiController']);

$routes->get('faq', 'Home::faq');

$routes->get('pembayaran/(:num)', 'TransaksiController::pembayaran/$1', ['filter' => 'auth']);

// --- RUTE UNTUK KONFIRMASI PEMBAYARAN ---
$routes->get('konfirmasi-pembayaran/(:num)', 'TransaksiController::konfirmasiPembayaran/$1', ['filter' => 'auth']);
$routes->post('proses-konfirmasi-pembayaran', 'TransaksiController::prosesKonfirmasiPembayaran', ['filter' => 'auth']); // Pastikan ini POST
