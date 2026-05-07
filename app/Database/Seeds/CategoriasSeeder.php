<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoriasSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // ==================== LIBROS (idtiporecurso = 1) ====================
            ['categoria' => 'Matemática', 'idtiporecurso' => 1],
            ['categoria' => 'Física', 'idtiporecurso' => 1],
            ['categoria' => 'Química', 'idtiporecurso' => 1],
            ['categoria' => 'Biología', 'idtiporecurso' => 1],
            ['categoria' => 'Ciencias Sociales', 'idtiporecurso' => 1],
            ['categoria' => 'Historia', 'idtiporecurso' => 1],
            ['categoria' => 'Geografía', 'idtiporecurso' => 1],
            ['categoria' => 'Arte y Cultura', 'idtiporecurso' => 1],
            ['categoria' => 'Computación / Informática', 'idtiporecurso' => 1],
            ['categoria' => 'Comunicación', 'idtiporecurso' => 1],

            // ==================== GUÍAS DE ESTUDIO (idtiporecurso = 9) ====================
            ['categoria' => 'Educación Cívica', 'idtiporecurso' => 9],
            ['categoria' => 'Educación Física', 'idtiporecurso' => 9],
            ['categoria' => 'Inglés', 'idtiporecurso' => 9],
            ['categoria' => 'Tutoría y Orientación', 'idtiporecurso' => 9],

            // ==================== ENCICLOPEDIA (idtiporecurso = 5) ====================
            ['categoria' => 'Ciencia y Tecnología', 'idtiporecurso' => 5],

            // ==================== EDUCACIÓN RELIGIOSA ====================
            ['categoria' => 'Educación Religiosa', 'idtiporecurso' => 1],   // por ahora en Libro (puedes cambiarlo después)
        ];

        // Limpiamos la tabla antes de insertar (recomendado en seeders)
        $this->db->table('categorias')->truncate();

        $this->db->table('categorias')->insertBatch($data);

        echo "✅ Seeder de Categorías ejecutado correctamente con idtiporecurso.\n";
    }
}
