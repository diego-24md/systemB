<?php

namespace App\Models;

use CodeIgniter\Model;

class LibrosModel extends Model
{
    protected $table      = 'recursos';
    protected $primaryKey = 'idrecurso';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted_at';
    protected $useTimestamps  = false;

    protected $allowedFields = [
        'idtiporecurso',
        'idcategoria',
        'titulo',
        'isbn',
        'anio',
        'portada',
        'numpaginas',
        'descripcion',
    ];

    // =========================
    // BUSCADOR DE LIBROS
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
                r.descripcion,

                GROUP_CONCAT(DISTINCT a.nombre SEPARATOR ", ") AS autores,
                c.idcategoria,
                c.categoria,
                tr.tipo,

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
            ->join('recurso_autor ra', 'ra.idrecurso = r.idrecurso', 'left')
            ->join('autores a', 'a.idautor = ra.idautor', 'left')
            ->join('categorias c', 'c.idcategoria = r.idcategoria', 'left')
            ->join('tiporecurso tr', 'tr.idtiporecurso = r.idtiporecurso', 'left')
            ->join('activos act', 'act.idrecurso = r.idrecurso', 'left')
            ->groupBy('r.idrecurso')
            ->where('r.deleted_at IS NULL');

        // Búsqueda general
        if (!empty($q)) {
            $builder->groupStart()
                ->like('r.titulo', $q)
                ->orLike('r.isbn', $q)
                ->orLike('a.nombre', $q)
                ->groupEnd();
        }

        // Filtro por categoría
        if (!empty($idcategoria)) {
            $builder->where('c.idcategoria', $idcategoria);
        }

        // Filtro disponibilidad
        if ($disponible !== '') {
            $builder->having('disponible ' . ($disponible == '1' ? '>' : '=') . ' 0');
        }

        return $builder->get()->getResultArray();
    }
}
