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
        $libros = $this->db->table('recursos r')
            ->select('
                r.*,
                GROUP_CONCAT(DISTINCT a.nombre SEPARATOR ", ") AS autores
            ')
            ->join('recurso_autor ra', 'ra.idrecurso = r.idrecurso', 'left')
            ->join('autores a', 'a.idautor = ra.idautor', 'left')
            ->groupBy('r.idrecurso')
            ->get()
            ->getResultArray();

        $data['libros'] = array_map(function ($libro) {
            $libro['autores'] = (string)($libro['autores'] ?? 'Sin autor');
            return $libro;
        }, $libros);

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

        $resultados = array_map(function ($r) {
            $r['autores'] = (string)($r['autores'] ?? 'Sin autor');
            return $r;
        }, $resultados);

        return $this->response->setJSON($resultados);
    }

    // ====================== DETALLE ======================
    // ====================== DETALLE ======================
    public function detalle($id)
    {
        $libro = $this->db->table('recursos r')
            ->select('
            r.*,
            GROUP_CONCAT(DISTINCT a.nombre SEPARATOR ", ") AS autores,
            c.categoria,
            tr.tipo
        ')
            ->join('recurso_autor ra', 'ra.idrecurso = r.idrecurso', 'left')
            ->join('autores a', 'a.idautor = ra.idautor', 'left')
            ->join('categorias c', 'c.idcategoria = r.idcategoria', 'left')
            ->join('tiporecurso tr', 'tr.idtiporecurso = r.idtiporecurso', 'left')
            ->where('r.idrecurso', $id)
            ->groupBy('r.idrecurso')
            ->get()
            ->getRowArray();

        if (!$libro) {
            return redirect()->to('/catalogo')->with('error', 'Libro no encontrado');
        }

        // Buscar activo por título para obtener ejemplares
        $activo = $this->db->table('activos')
            ->where('titulo', $libro['titulo'])
            ->get()
            ->getRowArray();

        $libro['autores']          = (string)($libro['autores'] ?? 'Sin autor');
        $libro['total_ejemplares'] = (int)($activo['cantidad_total'] ?? 0);
        $libro['disponibles']      = (int)($activo['cantidad_disponible'] ?? 0);

        $data['libro'] = $libro;

        return view('Biblioteca/detalles', $data);
    }
}
