<?php

namespace App\Controllers;

class Biblioteca extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    // ====================== CATÁLOGO ======================
    public function catalogo()
    {
        $data['libros'] = $this->db->table('recursos r')
            ->select('
                r.*,
                GROUP_CONCAT(DISTINCT a.nombre SEPARATOR ", ") AS autores
            ')
            ->join('recurso_autor ra', 'ra.idrecurso = r.idrecurso', 'left')
            ->join('autores a', 'a.idautor = ra.idautor', 'left')
            ->groupBy('r.idrecurso')
            ->get()
            ->getResultArray();

        return view('Biblioteca/catalogo', $data);
    }

    // ====================== BUSCADOR ======================
    public function buscar()
    {
        $q = trim($this->request->getGet('q'));

        if ($q === '') {
            return $this->response->setJSON([]);
        }

        $resultados = $this->db->table('recursos r')
            ->select('
                r.*,
                GROUP_CONCAT(DISTINCT a.nombre SEPARATOR ", ") AS autores
            ')
            ->join('recurso_autor ra', 'ra.idrecurso = r.idrecurso', 'left')
            ->join('autores a', 'a.idautor = ra.idautor', 'left')
            ->groupStart()
            ->like('r.titulo', $q)
            ->orLike('r.isbn', $q)
            ->orLike('a.nombre', $q)
            ->groupEnd()
            ->groupBy('r.idrecurso')
            ->orderBy('r.titulo', 'ASC')
            ->get()
            ->getResultArray();

        return $this->response->setJSON($resultados);
    }

    // ====================== DETALLE ======================
    public function detalle($id)
    {
        $libro = $this->db->table('recursos r')
            ->select('
            r.*,
            GROUP_CONCAT(DISTINCT a.nombre SEPARATOR ", ") AS autores,
            c.categoria,
            tr.tipo,
            COUNT(act.idactivo) AS total_ejemplares,
            SUM(
                CASE WHEN act.idactivo NOT IN (
                    SELECT idactivo FROM prestamos WHERE devolucion IS NULL
                ) THEN 1 ELSE 0 END
            ) AS disponibles
        ')
            ->join('recurso_autor ra', 'ra.idrecurso = r.idrecurso', 'left')
            ->join('autores a', 'a.idautor = ra.idautor', 'left')
            ->join('categorias c', 'c.idcategoria = r.idcategoria', 'left')
            ->join('tiporecurso tr', 'tr.idtiporecurso = r.idtiporecurso', 'left')
            ->join('activos act', 'act.idrecurso = r.idrecurso', 'left')
            ->where('r.idrecurso', $id)
            ->groupBy('r.idrecurso')
            ->get()
            ->getRowArray();

        if (!$libro) {
            return redirect()->to('/catalogo')->with('error', 'Libro no encontrado');
        }

        $data['libro'] = $libro;

        return view('Biblioteca/detalles', $data);
    }
}
