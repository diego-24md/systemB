<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GradosSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->table('secciones')->truncate();
        $this->db->table('grados')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

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

        echo "Seeder de Grados y Secciones ejecutado correctamente.\n";
    }
}
