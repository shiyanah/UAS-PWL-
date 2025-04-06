<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/produk', 'Home::produk');
$routes->get('/kategori/(:num)', 'Home::kategori/$1');
$routes->get('/kategori', 'Home::kategori');


