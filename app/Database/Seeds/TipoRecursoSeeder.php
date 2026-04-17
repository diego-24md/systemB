<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TiporecursoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['tipo' => 'Libro'],
            ['tipo' => 'Revista'],
            ['tipo' => 'Artículo científico'],
            ['tipo' => 'Tesis'],
            ['tipo' => 'Enciclopedia'],
            ['tipo' => 'Manual'],
            ['tipo' => 'Diccionario'],
            ['tipo' => 'Periódico'],
            ['tipo' => 'Guía de estudio'],
            ['tipo' => 'Documento digital'],
        ];

        $this->db->table('tiporecurso')->insertBatch($data);
    }
}