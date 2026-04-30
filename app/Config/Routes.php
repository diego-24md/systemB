<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


//El slash "/" representa el HOME de tu aplicación
//es decir www.miweb.com/programador
$routes->get('/', 'Home::dashboard');

$routes->get('libros', 'Libros::index');
$routes->get('libros/registrar', 'Libros::registrar');
$routes->post('libros/guardar', 'Libros::guardar');

//Rutas para las alumnas
$routes->get('/alumnas', 'Alumnas::index');
$routes->post('/alumnas/guardar', 'Alumnas::guardar');
$routes->get('/alumnas/eliminar/(:num)', 'Alumnas::eliminar/$1');
$routes->get('/alumnas/editar/(:num)', 'Alumnas::editar/$1');
$routes->post('/alumnas/actualizar/(:num)', 'Alumnas::actualizar/$1');

//Para el BUSCADOR
$routes->get('catalogo', 'Biblioteca::catalogo');
$routes->get('buscar-libros', 'Biblioteca::buscar');
$routes->get('biblioteca/detalle/(:num)', 'Biblioteca::detalle/$1');


// CRUD para libros
$routes->get('libros/editar/(:num)', 'Libros::editar/$1');
$routes->post('libros/actualizar/(:num)', 'Libros::actualizar/$1');
$routes->post('libros/eliminar/(:num)', 'Libros::eliminar/$1');


// Prestamos de libros - Registrar prestamo
$routes->get('/prestamos', 'Prestamos::index');
