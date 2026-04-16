<?php

namespace App\Controllers;

class Biblioteca extends BaseController
{
    public function buscador()
    {
        $categorias = [
            ['idcategoria' => 1, 'categoria' => 'Novela'],
            ['idcategoria' => 2, 'categoria' => 'Ciencia'],
            ['idcategoria' => 3, 'categoria' => 'Historia'],
            ['idcategoria' => 4, 'categoria' => 'Tecnología'],
        ];

        $data = [
            'categorias' => $categorias
        ];

        return view('Biblioteca/buscador', $data);
    }
}
