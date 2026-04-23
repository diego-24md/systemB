<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GradosSeeder extends Seeder
{
    public function run()
    {
        // GRADOS 1 a 5
        for ($i = 1; $i <= 5; $i++) {

            $this->db->table('grados')->insert([
                'nombre' => $i . '°'
            ]);

            $grado_id = $this->db->insertID();

            // SECCIONES A, B, C, D
            foreach (['A', 'B', 'C', 'D'] as $sec) {
                $this->db->table('secciones')->insert([
                    'nombre' => $sec,
                    'grado_id' => $grado_id
                ]);
            }
        }
    }
}
