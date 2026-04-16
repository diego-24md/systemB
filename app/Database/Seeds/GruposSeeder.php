<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GruposSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['grado' => '1ro', 'seccion' => 'A'],
            ['grado' => '2do', 'seccion' => 'A'],
            ['grado' => '3ro', 'seccion' => 'B'],
        ];

        $this->db->table('grupos')->insertBatch($data);
    }
}