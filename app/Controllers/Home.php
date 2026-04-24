<?php

namespace App\Controllers;

use App\Models\LibrosModel;

class Home extends BaseController
{
    public function dashboard(): string
    {
        $librosModel = new LibrosModel();
        $db = \Config\Database::connect();

        // 📚 Total libros
        $totalLibros = $librosModel->countAll();

        // 📦 Libros prestados (no devueltos)
        $prestados = $db->table('prestamos')
            ->where('devolucion IS NULL', null, false)
            ->countAllResults();

        // 📖 Disponibles (aprox: activos - prestados)
        $disponibles = $db->table('activos')
            ->countAllResults() - $prestados;

        // 👥 Usuarios
        $usuarios = $db->table('usuarios')->countAllResults();

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