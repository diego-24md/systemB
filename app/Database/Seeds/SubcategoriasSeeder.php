<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SubcategoriasSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'idsubcategoria' => 1,
                'idcategoria' => 1,
                'subcategoria' => 'Novela'
            ],
            [
                'idsubcategoria' => 2,
                'idcategoria' => 1,
                'subcategoria' => 'Ficción'
            ],
            [
                'idsubcategoria' => 3,
                'idcategoria' => 1,
                'subcategoria' => 'Clásicos'
            ]
        ];

        $this->db->table('subcategorias')->insertBatch($data);
    }
}