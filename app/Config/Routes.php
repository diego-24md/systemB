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

//Rutas para el CRUD de personas(alumnos)
$routes->get('/alumnos', 'Persona::index');
$routes->post('/alumnos/importar', 'Persona::importar');


//Para el BUSCADOR
$routes->get('catalogo', 'Libros::catalogo');
$routes->get('buscar-libros', 'Libros::buscarUsuario');


// Editar libro
$routes->get('libros/editar/(:num)', 'Libros::editar/$1');
//Actualizar libro
$routes->post('libros/actualizar/(:num)', 'Libros::actualizar/$1');

// Eliminar libro
$routes->get('libros/eliminar/(:num)', 'Libros::eliminar/$1');
