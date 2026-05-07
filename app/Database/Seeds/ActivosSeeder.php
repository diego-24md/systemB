<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ActivosSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->table('activos')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

        $data = [
            // MATEMÁTICA (idcategoria=1, idtiporecurso=1)
            ['titulo' => 'Matemática 1°',  'autor' => 'MINEDU', 'idcategoria' => 1, 'idtiporecurso' => 1, 'cantidad_total' => 10, 'cantidad_disponible' => 10, 'estado' => 'disponible'],
            ['titulo' => 'Matemática 2°',  'autor' => 'MINEDU', 'idcategoria' => 1, 'idtiporecurso' => 1, 'cantidad_total' => 10, 'cantidad_disponible' => 10, 'estado' => 'disponible'],
            ['titulo' => 'Matemática 3°',  'autor' => 'MINEDU', 'idcategoria' => 1, 'idtiporecurso' => 1, 'cantidad_total' => 10, 'cantidad_disponible' => 10, 'estado' => 'disponible'],
            ['titulo' => 'Matemática 4°',  'autor' => 'MINEDU', 'idcategoria' => 1, 'idtiporecurso' => 1, 'cantidad_total' => 10, 'cantidad_disponible' => 10, 'estado' => 'disponible'],
            ['titulo' => 'Matemática 5°',  'autor' => 'MINEDU', 'idcategoria' => 1, 'idtiporecurso' => 1, 'cantidad_total' => 10, 'cantidad_disponible' => 10, 'estado' => 'disponible'],

            // COMUNICACIÓN (idcategoria=10, idtiporecurso=1)
            ['titulo' => 'Comunicación 1°', 'autor' => 'MINEDU', 'idcategoria' => 10, 'idtiporecurso' => 1, 'cantidad_total' => 10, 'cantidad_disponible' => 10, 'estado' => 'disponible'],
            ['titulo' => 'Comunicación 2°', 'autor' => 'MINEDU', 'idcategoria' => 10, 'idtiporecurso' => 1, 'cantidad_total' => 10, 'cantidad_disponible' => 10, 'estado' => 'disponible'],
            ['titulo' => 'Comunicación 3°', 'autor' => 'MINEDU', 'idcategoria' => 10, 'idtiporecurso' => 1, 'cantidad_total' => 10, 'cantidad_disponible' => 10, 'estado' => 'disponible'],
            ['titulo' => 'Comunicación 4°', 'autor' => 'MINEDU', 'idcategoria' => 10, 'idtiporecurso' => 1, 'cantidad_total' => 10, 'cantidad_disponible' => 10, 'estado' => 'disponible'],
            ['titulo' => 'Comunicación 5°', 'autor' => 'MINEDU', 'idcategoria' => 10, 'idtiporecurso' => 1, 'cantidad_total' => 10, 'cantidad_disponible' => 10, 'estado' => 'disponible'],

            // FÍSICA (idcategoria=2, idtiporecurso=1)
            ['titulo' => 'Física 3°', 'autor' => 'MINEDU', 'idcategoria' => 2, 'idtiporecurso' => 1, 'cantidad_total' => 8, 'cantidad_disponible' => 8, 'estado' => 'disponible'],
            ['titulo' => 'Física 4°', 'autor' => 'MINEDU', 'idcategoria' => 2, 'idtiporecurso' => 1, 'cantidad_total' => 8, 'cantidad_disponible' => 8, 'estado' => 'disponible'],
            ['titulo' => 'Física 5°', 'autor' => 'MINEDU', 'idcategoria' => 2, 'idtiporecurso' => 1, 'cantidad_total' => 8, 'cantidad_disponible' => 8, 'estado' => 'disponible'],

            // QUÍMICA (idcategoria=3, idtiporecurso=1)
            ['titulo' => 'Química 3°', 'autor' => 'MINEDU', 'idcategoria' => 3, 'idtiporecurso' => 1, 'cantidad_total' => 8, 'cantidad_disponible' => 8, 'estado' => 'disponible'],
            ['titulo' => 'Química 4°', 'autor' => 'MINEDU', 'idcategoria' => 3, 'idtiporecurso' => 1, 'cantidad_total' => 8, 'cantidad_disponible' => 8, 'estado' => 'disponible'],
            ['titulo' => 'Química 5°', 'autor' => 'MINEDU', 'idcategoria' => 3, 'idtiporecurso' => 1, 'cantidad_total' => 8, 'cantidad_disponible' => 8, 'estado' => 'disponible'],

            // HISTORIA (idcategoria=6, idtiporecurso=1)
            ['titulo' => 'Historia 1°', 'autor' => 'MINEDU', 'idcategoria' => 6, 'idtiporecurso' => 1, 'cantidad_total' => 10, 'cantidad_disponible' => 10, 'estado' => 'disponible'],
            ['titulo' => 'Historia 2°', 'autor' => 'MINEDU', 'idcategoria' => 6, 'idtiporecurso' => 1, 'cantidad_total' => 10, 'cantidad_disponible' => 10, 'estado' => 'disponible'],
            ['titulo' => 'Historia 3°', 'autor' => 'MINEDU', 'idcategoria' => 6, 'idtiporecurso' => 1, 'cantidad_total' => 10, 'cantidad_disponible' => 10, 'estado' => 'disponible'],
            ['titulo' => 'Historia 4°', 'autor' => 'MINEDU', 'idcategoria' => 6, 'idtiporecurso' => 1, 'cantidad_total' => 10, 'cantidad_disponible' => 10, 'estado' => 'disponible'],
            ['titulo' => 'Historia 5°', 'autor' => 'MINEDU', 'idcategoria' => 6, 'idtiporecurso' => 1, 'cantidad_total' => 10, 'cantidad_disponible' => 10, 'estado' => 'disponible'],

            // INGLÉS (idcategoria=13, idtiporecurso=9)
            ['titulo' => 'Inglés 1°', 'autor' => 'MINEDU', 'idcategoria' => 13, 'idtiporecurso' => 9, 'cantidad_total' => 8, 'cantidad_disponible' => 8, 'estado' => 'disponible'],
            ['titulo' => 'Inglés 2°', 'autor' => 'MINEDU', 'idcategoria' => 13, 'idtiporecurso' => 9, 'cantidad_total' => 8, 'cantidad_disponible' => 8, 'estado' => 'disponible'],
            ['titulo' => 'Inglés 3°', 'autor' => 'MINEDU', 'idcategoria' => 13, 'idtiporecurso' => 9, 'cantidad_total' => 8, 'cantidad_disponible' => 8, 'estado' => 'disponible'],
        ];

        $this->db->table('activos')->insertBatch($data);

        echo "✅ Seeder de Activos ejecutado correctamente.\n";
    }
}
