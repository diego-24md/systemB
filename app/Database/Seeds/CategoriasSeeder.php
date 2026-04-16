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
            ['categoria' => 'Ciencias Sociales'],
            ['categoria' => 'Ciencia y Tecnología'],
            ['categoria' => 'Física'],
            ['categoria' => 'Química'],
            ['categoria' => 'Biología'],
            ['categoria' => 'Historia'],
            ['categoria' => 'Geografía'],
            ['categoria' => 'Educación Cívica'],
            ['categoria' => 'Inglés'],
            ['categoria' => 'Arte y Cultura'],
            ['categoria' => 'Educación Física'],
            ['categoria' => 'Computación / Informática'],
            ['categoria' => 'Educación Religiosa'],
            ['categoria' => 'Tutoría y Orientación'],
        ];

        $this->db->table('categorias')->insertBatch($data);
    }
}
