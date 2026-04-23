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
$routes->get('/obtener-alumnas', 'Alumnas::obtener');
$routes->post('/importar-alumnas', 'Alumnas::importar');

$routes->get('/secciones', 'Alumnas::seccionesPorGrado');

//Para el BUSCADOR
$routes->get('catalogo', 'Libros::catalogo');
$routes->get('buscar-libros', 'Libros::buscar');


// Editar libro
$routes->get('libros/editar/(:num)', 'Libros::editar/$1');
//Actualizar libro
$routes->post('libros/actualizar/(:num)', 'Libros::actualizar/$1');

// Eliminar libro
$routes->get('libros/eliminar/(:num)', 'Libros::eliminar/$1');

// Prestamos de libros - Registrar prestamo
$routes->get('/prestamos', 'Prestamos::index');
