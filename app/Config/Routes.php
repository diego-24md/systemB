<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::dashboard');

// ====================== LIBROS ======================
$routes->get('libros', 'Libros::index');
$routes->get('libros/registrar', 'Libros::registrar');
$routes->post('libros/guardar', 'Libros::guardar');
$routes->get('libros/editar/(:num)', 'Libros::editar/$1');
$routes->post('libros/actualizar/(:num)', 'Libros::actualizar/$1');
$routes->post('libros/eliminar/(:num)', 'Libros::eliminar/$1');

// ====================== ALUMNAS ======================
$routes->get('alumnas', 'Alumnas::index');
$routes->get('alumnas/importar', 'Alumnas::importar');      // ← agregada
$routes->post('alumnas/guardar', 'Alumnas::guardar');
$routes->get('alumnas/editar/(:num)', 'Alumnas::editar/$1');
$routes->post('alumnas/actualizar/(:num)', 'Alumnas::actualizar/$1');
$routes->post('alumnas/eliminar/(:num)', 'Alumnas::eliminar/$1'); // ← cambiado a post

// ====================== BIBLIOTECA ======================
$routes->get('catalogo', 'Biblioteca::catalogo');
$routes->get('buscar-libros', 'Biblioteca::buscar');
$routes->get('biblioteca/detalle/(:num)', 'Biblioteca::detalle/$1');

// ====================== PRESTAMOS ======================
$routes->get('prestamos', 'Prestamos::index');
