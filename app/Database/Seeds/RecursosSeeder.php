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
                'idsubcategoria' => 1,
                'titulo' => 'Cien años de soledad',
                'isbn' => '9780307474728',
                'anio' => 1967,
                'portada' => null,
                'numpaginas' => 417
            ],
            [
                'idtiporecurso' => 1,
                'idsubcategoria' => 1,
                'titulo' => 'Don Quijote de la Mancha',
                'isbn' => '9788491050293',
                'anio' => 1605,
                'portada' => null,
                'numpaginas' => 863
            ]
        ];

        $this->db->table('recursos')->insertBatch($data);
    }
}