<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LibrosSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        $libros = [
            [
                'titulo'        => 'Matemática 1',
                'isbn'          => '9780306406001',
                'idtiporecurso' => 1,
                'idcategoria'   => 1,
                'descripcion'   => 'Libro de matemática para primer grado.',
                'anio'          => 2020,
                'numpaginas'    => 320,
                'portada'       => null,
                'autores'       => ['Juan Pérez'],
                'cantidad'      => 3,
            ],
            [
                'titulo'        => 'Física General',
                'isbn'          => '9780306406002',
                'idtiporecurso' => 1,
                'idcategoria'   => 2,
                'descripcion'   => 'Introducción a la física clásica y moderna.',
                'anio'          => 2019,
                'numpaginas'    => 450,
                'portada'       => null,
                'autores'       => ['Carlos Mendoza'],
                'cantidad'      => 2,
            ],
            [
                'titulo'        => 'Comunicación y Lenguaje',
                'isbn'          => '9780306406003',
                'idtiporecurso' => 1,
                'idcategoria'   => 3,
                'descripcion'   => 'Gramática y comprensión lectora.',
                'anio'          => 2021,
                'numpaginas'    => 280,
                'portada'       => null,
                'autores'       => ['María López'],
                'cantidad'      => 4,
            ],
            [
                'titulo'        => 'Historia del Perú',
                'isbn'          => '9780306406004',
                'idtiporecurso' => 1,
                'idcategoria'   => 1,
                'descripcion'   => 'Historia del Perú desde sus orígenes.',
                'anio'          => 2018,
                'numpaginas'    => 390,
                'portada'       => null,
                'autores'       => ['Luis Torres', 'Ana Ríos'],
                'cantidad'      => 2,
            ],
            [
                'titulo'        => 'Química Orgánica',
                'isbn'          => '9780306406005',
                'idtiporecurso' => 1,
                'idcategoria'   => 2,
                'descripcion'   => 'Fundamentos de química orgánica.',
                'anio'          => 2020,
                'numpaginas'    => 510,
                'portada'       => null,
                'autores'       => ['Roberto Silva'],
                'cantidad'      => 3,
            ],
            [
                'titulo'        => 'Álgebra Lineal',
                'isbn'          => '9780306406006',
                'idtiporecurso' => 1,
                'idcategoria'   => 1,
                'descripcion'   => 'Vectores, matrices y transformaciones lineales.',
                'anio'          => 2022,
                'numpaginas'    => 360,
                'portada'       => null,
                'autores'       => ['Patricia Vega'],
                'cantidad'      => 2,
            ],
            [
                'titulo'        => 'Biología Celular',
                'isbn'          => '9780306406007',
                'idtiporecurso' => 1,
                'idcategoria'   => 2,
                'descripcion'   => 'Estructura y función de la célula.',
                'anio'          => 2021,
                'numpaginas'    => 420,
                'portada'       => null,
                'autores'       => ['Jorge Castro'],
                'cantidad'      => 3,
            ],
            [
                'titulo'        => 'Geografía del Perú',
                'isbn'          => '9780306406008',
                'idtiporecurso' => 1,
                'idcategoria'   => 3,
                'descripcion'   => 'Geografía física y humana del Perú.',
                'anio'          => 2019,
                'numpaginas'    => 300,
                'portada'       => null,
                'autores'       => ['Carmen Flores'],
                'cantidad'      => 4,
            ],
            [
                'titulo'        => 'Introducción a la Programación',
                'isbn'          => '9780306406009',
                'idtiporecurso' => 1,
                'idcategoria'   => 1,
                'descripcion'   => 'Fundamentos de programación con Python.',
                'anio'          => 2023,
                'numpaginas'    => 340,
                'portada'       => null,
                'autores'       => ['Miguel Ángel Rojas'],
                'cantidad'      => 5,
            ],
        ];

        foreach ($libros as $libro) {
            // 1. Insertar en recursos
            $idRecurso = $db->table('recursos')->insert([
                'titulo'        => $libro['titulo'],
                'isbn'          => $libro['isbn'],
                'idtiporecurso' => $libro['idtiporecurso'],
                'idcategoria'   => $libro['idcategoria'],
                'descripcion'   => $libro['descripcion'],
                'anio'          => $libro['anio'],
                'numpaginas'    => $libro['numpaginas'],
                'portada'       => $libro['portada'],
            ]);
            $idRecurso = $db->insertID();

            // 2. Insertar en activos
            $db->table('activos')->insert([
                'titulo'              => $libro['titulo'],
                'idcategoria'         => $libro['idcategoria'],
                'idtiporecurso'       => $libro['idtiporecurso'],
                'cantidad_total'      => $libro['cantidad'],
                'cantidad_disponible' => $libro['cantidad'],
                'estado'              => 'disponible',
                'autor'               => implode(', ', $libro['autores']),
                'foto'                => $libro['portada'],
            ]);

            // 3. Insertar autores y relación recurso_autor
            foreach ($libro['autores'] as $nombreAutor) {
                $autor = $db->table('autores')
                    ->where('nombre', $nombreAutor)
                    ->get()
                    ->getRowArray();

                if (!$autor) {
                    $db->table('autores')->insert(['nombre' => $nombreAutor]);
                    $idAutor = $db->insertID();
                } else {
                    $idAutor = $autor['idautor'];
                }

                $db->table('recurso_autor')->insert([
                    'idrecurso' => $idRecurso,
                    'idautor'   => $idAutor,
                ]);
            }
        }

        echo "9 libros insertados correctamente.\n";
    }
}