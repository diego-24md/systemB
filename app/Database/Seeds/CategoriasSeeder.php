<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoriasSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['categoria' => 'Matemática'],
            ['categoria' => 'Comunicación'],
            ['categoria' => 'Ciencia'],
        ];

        $this->db->table('categorias')->insertBatch($data);
    }
}