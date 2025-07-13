<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- Rute Umum (Tanpa Filter atau Filter Auth Saja) ---

// Rute Home
$routes->get('/', 'Home::index', ['filter' => 'auth']);

// Rute FAQ
$routes->get('faq', 'Home::faq'); // Pastikan ini mengarah ke Home::faq

// Rute Login/Logout
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

// Rute Detail Produk (akses oleh user biasa)
$routes->get('produk_detail/(:num)', 'ProductController::detail/$1', ['filter' => 'auth']);

// Rute Keranjang (akses oleh user biasa)
$routes->group('keranjang', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'TransaksiController::index');
    $routes->post('', 'TransaksiController::cart_add');
    $routes->post('edit', 'TransaksiController::cart_edit');
    $routes->get('delete/(:any)', 'TransaksiController::cart_delete/$1');
    $routes->get('clear', 'TransaksiController::cart_clear');
});

// Rute Checkout (akses oleh user biasa)
$routes->get('checkout', 'TransaksiController::checkout', ['filter' => 'auth']);

// Rute untuk proses transaksi (AJAX dan Buy)
$routes->get('get-location', 'TransaksiController::getLocation', ['filter' => 'auth']);
$routes->get('get-cost', 'TransaksiController::getCost', ['filter' => 'auth']);
$routes->post('buy', 'TransaksiController::buy', ['filter' => 'auth']);

// Rute Profile (akses oleh user biasa)
$routes->get('profile', 'Home::profile', ['filter' => 'auth']);

// Rute Riwayat Pesanan (akses oleh user biasa)
$routes->get('riwayat-pesanan', 'PesananController::riwayat', ['filter' => 'auth']);
$routes->get('riwayat-pesanan/detail/(:num)', 'PesananController::detail/$1', ['filter' => 'auth']); // Detail riwayat pesanan user

// Rute Pembayaran
$routes->get('pembayaran/(:num)', 'TransaksiController::pembayaran/$1', ['filter' => 'auth']);

// Rute Konfirmasi Pembayaran
$routes->get('konfirmasi-pembayaran/(:num)', 'TransaksiController::konfirmasiPembayaran/$1', ['filter' => 'auth']);
$routes->post('proses-konfirmasi-pembayaran', 'TransaksiController::prosesKonfirmasiPembayaran', ['filter' => 'auth']);


// --- Rute Khusus Admin ---

// Rute Produk (CRUD) - Hanya untuk admin
$routes->group('produk', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('', 'ProductController::index');
    $routes->post('', 'ProductController::create');
    $routes->post('edit/(:any)', 'ProductController::edit/$1');
    $routes->get('delete/(:any)', 'ProductController::delete/$1');
    $routes->get('download', 'ProductController::download');
});

// Rute Manajemen Pesanan - Hanya untuk admin
$routes->group('pesanan', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'PesananController::index');
    $routes->get('detail/(:num)', 'PesananController::detail/$1'); // Detail pesanan untuk admin
    $routes->post('updateStatus/(:num)', 'PesananController::updateStatus/$1');
    $routes->get('delete/(:num)', 'PesananController::delete/$1');
});

// Rute Filter Stok - Hanya untuk admin
$routes->group('filter-stok', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('', 'FilterStokController::index');
    $routes->get('export-pdf', 'FilterStokController::exportPdf');
});

// Rute API (jika ada)
$routes->resource('api', ['controller' => 'ApiController']);
