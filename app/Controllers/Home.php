<?php

namespace App\Controllers;

use App\Models\LibrosModel;

class Home extends BaseController
{
    public function dashboard(): string
    {
        $librosModel = new LibrosModel();
        $db = \Config\Database::connect();

        // Total libros
        $totalLibros = $librosModel->countAll();

        // Libros prestados (no devueltos)
        $prestados = $db->table('prestamos')
            ->where('devolucion IS NULL', null, false)
            ->countAllResults();

        // Disponibles — solo activos que tienen un recurso existente
        $disponibles = $db->table('activos a')
            ->selectSum('a.cantidad_disponible')
            ->join('recursos r', 'r.titulo = a.titulo', 'inner')
            ->get()
            ->getRow()
            ->cantidad_disponible ?? 0;

        // Alumnas
        $usuarios = $db->table('alumnas')->countAllResults();

        return view('dashboard', [
            'header' => view('Partials/header'),
            'footer' => view('Partials/footer'),

            'totalLibros' => $totalLibros,
            'prestados' => $prestados,
            'disponibles' => $disponibles,
            'usuarios' => $usuarios,
        ]);
    }
}
