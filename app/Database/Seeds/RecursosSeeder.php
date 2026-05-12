<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RecursosSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'idtiporecurso' => 1,
                'idcategoria'   => 2,
                'titulo'        => 'Libro de Python I',
                'isbn'          => '9780307474728',
                'anio'          => 2021,
                'portada'       => 'LibroDePython.jpg',
                'numpaginas'    => 417,
                'descripcion'   => ''
            ],
            [
                'idtiporecurso' => 1,
                'idcategoria'   => 1,
                'titulo'        => 'Libro de Matemática Vital 2',
                'isbn'          => '9788491050293',
                'anio'          => 2016,
                'portada'       => 'LibroDeMatematica.jpeg',
                'numpaginas'    => 863,
                'descripcion'   => ''
            ]
        ];

        $this->db->table('recursos')->insertBatch($data);
    }
}
