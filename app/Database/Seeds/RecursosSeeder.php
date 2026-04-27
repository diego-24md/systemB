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
                'idcategoria'   => 1,
                'titulo'        => 'Libro de Python I',
                'isbn'          => '9780307474728',
                'anio'          => 1967,
                'portada'       => '1776442538_4699499bcb8287599e50.webp',
                'numpaginas'    => 417
            ],
            [
                'idtiporecurso' => 1,
                'idcategoria'   => 1,
                'titulo'        => 'Libro de Matemática Vital 2',
                'isbn'          => '9788491050293',
                'anio'          => 1605,
                'portada'       => '1776442659_a113e5624fb1880f13b7.png',
                'numpaginas'    => 863
            ]
        ];

        $this->db->table('recursos')->insertBatch($data);
    }
}