<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ====================== AUTH ======================
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

// Auth Alumnas
$routes->get('alumnas/login', 'AuthAlumna::index');
$routes->post('alumnas/login', 'AuthAlumna::login');
$routes->get('alumnas/logout', 'AuthAlumna::logout');

// ====================== RUTAS PROTEGIDAS (Bibliotecario) ======================
$routes->group('', ['filter' => 'auth.bibliotecario'], function ($routes) {

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
    $routes->get('alumnas/importar', 'Alumnas::importar');
    $routes->post('alumnas/guardar', 'Alumnas::guardar');
    $routes->get('alumnas/editar/(:num)', 'Alumnas::editar/$1');
    $routes->post('alumnas/actualizar/(:num)', 'Alumnas::actualizar/$1');
    $routes->post('alumnas/eliminar/(:num)', 'Alumnas::eliminar/$1');

    // ====================== PRÉSTAMOS ======================
    $routes->group('prestamos', function ($routes) {

        // Dashboard / Página principal de préstamos
        $routes->get('/', 'Prestamos::index');

        // Registrar Préstamo
        $routes->get('registrar', 'Prestamos::registrar');
        $routes->post('guardar', 'Prestamos::guardar');

        // AJAX
        $routes->get('buscar-alumna', 'Prestamos::buscarAlumna');
        $routes->get('buscar-libros', 'Prestamos::buscarLibros');

        // Reservas Pendientes
        $routes->get('pendientes', 'Prestamos::pendientes');

        // Préstamos Activos
        $routes->get('activos', 'Prestamos::activos');

        // Acciones
        $routes->get('aprobar/(:num)', 'Prestamos::aprobar/$1');
        $routes->get('rechazar/(:num)', 'Prestamos::rechazar/$1');
        $routes->get('devolver/(:num)', 'Prestamos::devolver/$1');

        // Otras secciones
        $routes->get('devoluciones', 'Prestamos::devoluciones');
        $routes->get('historial', 'Prestamos::historial');
        $routes->get('ranking', 'Prestamos::ranking');
    });

    // ====================== PERFIL ======================
    $routes->get('perfil', 'PerfilController::index');
    $routes->post('perfil/actualizar', 'PerfilController::actualizar');
    $routes->post('perfil/actualizar-foto', 'PerfilController::actualizarFoto');

    // ====================== NOTIFICACIONES ======================
    $routes->get('notificaciones', 'Notificaciones::index');
    $routes->get('notificaciones/marcar/(:num)', 'Notificaciones::marcar/$1');
    $routes->get('notificaciones/cargar-mas', 'Notificaciones::cargarMas');
});

// ====================== RUTAS PARA ALUMNAS ======================
$routes->group('', ['filter' => 'auth.alumna'], function ($routes) {

    $routes->get('catalogo', 'Biblioteca::catalogo');
    $routes->get('buscar-libros', 'Biblioteca::buscar');
    $routes->get('biblioteca/detalle/(:num)', 'Biblioteca::detalle/$1');
    $routes->get('biblioteca/reservar/(:num)', 'Biblioteca::reservar/$1');
    $routes->post('biblioteca/procesarReserva', 'Biblioteca::procesarReserva');

    // Favoritos
    $routes->post('favoritos/toggle', 'Favoritos::toggle');
    $routes->get('favoritos/ids', 'Favoritos::ids');
});
