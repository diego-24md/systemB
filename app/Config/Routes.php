<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ====================== AUTH BIBLIOTECARIO ======================
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

// ====================== AUTH ALUMNAS ======================
$routes->get('alumnas/login', 'AuthAlumna::index');
$routes->post('alumnas/login', 'AuthAlumna::login');
$routes->get('alumnas/logout', 'AuthAlumna::logout');

// ====================== RUTAS PROTEGIDAS (solo bibliotecario) ======================
$routes->group('', ['filter' => 'auth.bibliotecario'], function ($routes) {

    $routes->get('/', 'Home::dashboard');

    // Libros
    $routes->get('libros', 'Libros::index');
    $routes->get('libros/registrar', 'Libros::registrar');
    $routes->post('libros/guardar', 'Libros::guardar');
    $routes->get('libros/editar/(:num)', 'Libros::editar/$1');
    $routes->post('libros/actualizar/(:num)', 'Libros::actualizar/$1');
    $routes->post('libros/eliminar/(:num)', 'Libros::eliminar/$1');

    // Alumnas
    $routes->get('alumnas', 'Alumnas::index');
    $routes->get('alumnas/importar', 'Alumnas::importar');
    $routes->post('alumnas/guardar', 'Alumnas::guardar');
    $routes->get('alumnas/editar/(:num)', 'Alumnas::editar/$1');
    $routes->post('alumnas/actualizar/(:num)', 'Alumnas::actualizar/$1');
    $routes->post('alumnas/eliminar/(:num)', 'Alumnas::eliminar/$1');

    // Préstamos
    $routes->get('prestamos', 'Prestamos::index');

    // Perfil
    $routes->get('perfil', 'PerfilController::index');
    $routes->post('perfil/actualizar', 'PerfilController::actualizar');
    $routes->post('perfil/actualizar-foto', 'PerfilController::actualizarFoto');

    //Guardar préstamos
    $routes->post('prestamos/guardar', 'Prestamos::guardar');
    $routes->get('prestamos/buscar-alumna', 'Prestamos::buscarAlumna');

    //Notificaciones
    $routes->get('notificaciones/marcar/(:num)', 'Notificaciones::marcar/$1');
});

// ====================== BIBLIOTECA (protegida para alumnas) ======================
$routes->group('', ['filter' => 'auth.alumna'], function ($routes) {
    $routes->get('catalogo', 'Biblioteca::catalogo');
    $routes->get('buscar-libros', 'Biblioteca::buscar');
    $routes->get('biblioteca/detalle/(:num)', 'Biblioteca::detalle/$1');

    // Favoritos
    $routes->post('favoritos/toggle', 'Favoritos::toggle');
    $routes->get('favoritos/ids',     'Favoritos::ids');
});
