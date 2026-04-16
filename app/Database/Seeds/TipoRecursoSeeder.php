<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TiporecursoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['idtiporecurso' => 1, 'nombre' => 'Libro']
        ];

        $this->db->table('tiporecurso')->insertBatch($data);
    }
}