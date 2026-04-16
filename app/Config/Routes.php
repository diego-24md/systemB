<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


//El slash "/" representa el HOME de tu aplicación
//es decir www.miweb.com/programador

$routes->get('/', 'Home::dashboard');

//¿Cómo funciona una ruta?
//$routes->verbo('/ruta/', 'Controlador::MetodoAccion');
//Nota: Es posible crear más de una ruta para una vista

$routes->get('libros', 'Libros::index');
$routes->get('libros/registrar', 'Libros::registrar');
$routes->post('libros/guardar', 'Libros::guardar');

//Rutas para el CRUD de personas(alumnos)
$routes->get('/alumnos', 'Persona::index');
$routes->post('/alumnos/importar', 'Persona::importar');


//Para el BUSCADOR
$routes->get('buscador', 'Biblioteca::buscador');