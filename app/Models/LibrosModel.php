<?php

namespace App\Models;

use CodeIgniter\Model;

class LibrosModel extends Model
{
    protected $table      = 'recursos';
    protected $primaryKey = 'idrecurso';

    // 🔥 IMPORTANTE: para usar $recurso['campo']
    protected $returnType = 'array';

    protected $allowedFields = [
        'idtiporecurso',
        'idsubcategoria',
        'titulo',
        'isbn',
        'anio',
        'portada',
        'numpaginas'
    ];

    // =========================
    // 🔍 BUSCADOR DE LIBROS
    // =========================
    public function buscar($q = '', $idcategoria = '', $disponible = '')
    {
        $builder = $this->db->table('recursos r')
            ->select('
                r.idrecurso,
                r.titulo,
                r.isbn,
                r.anio,
                r.portada,

                GROUP_CONCAT(DISTINCT a.datoautor SEPARATOR ", ") AS autor,
                sc.subcategoria,
                c.idcategoria,
                c.categoria,
                tr.tipo,

                MAX(act.condicion) AS condicion,

                SUM(
                    CASE 
                        WHEN act.idactivo NOT IN (
                            SELECT idactivo 
                            FROM prestamos 
                            WHERE devolucion IS NULL
                        ) THEN 1 
                        ELSE 0 
                    END
                ) AS disponible
            ')
            ->join('autores a', 'a.idrecurso = r.idrecurso', 'left')
            ->join('subcategorias sc', 'sc.idsubcategoria = r.idsubcategoria', 'left')
            ->join('categorias c', 'c.idcategoria = sc.idcategoria', 'left')
            ->join('tiporecurso tr', 'tr.idtiporecurso = r.idtiporecurso', 'left')
            ->join('activos act', 'act.idrecurso = r.idrecurso', 'left')
            ->groupBy('r.idrecurso');

        // 🔎 búsqueda general
        if (!empty($q)) {
            $builder->groupStart()
                ->like('r.titulo', $q)
                ->orLike('r.isbn', $q)
                ->orLike('a.datoautor', $q)
            ->groupEnd();
        }

        // 📂 filtro por categoría
        if (!empty($idcategoria)) {
            $builder->where('c.idcategoria', $idcategoria);
        }

        // 📦 filtro disponibilidad
        if ($disponible !== '') {
            $builder->having('disponible ' . ($disponible == '1' ? '>' : '=') . ' 0');
        }

        return $builder->get()->getResultArray();
    }
}