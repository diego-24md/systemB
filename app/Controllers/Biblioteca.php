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
                GROUP_CONCAT(DISTINCT a.nombre SEPARATOR ", ") AS autores,
                c.categoria,
                c.idcategoria
            ')
            ->join('recurso_autor ra', 'ra.idrecurso = r.idrecurso', 'left')
            ->join('autores a', 'a.idautor = ra.idautor', 'left')
            ->join('categorias c', 'c.idcategoria = r.idcategoria', 'left')
            ->groupBy('r.idrecurso')
            ->get()
            ->getResultArray();

        $data['libros'] = array_map(function ($libro) {
            $libro['autores']   = (string)($libro['autores']   ?? 'Sin autor');
            $libro['categoria'] = (string)($libro['categoria'] ?? '');
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
                GROUP_CONCAT(DISTINCT a.nombre SEPARATOR ", ") AS autores,
                c.categoria,
                c.idcategoria
            ')
            ->join('recurso_autor ra', 'ra.idrecurso = r.idrecurso', 'left')
            ->join('autores a', 'a.idautor = ra.idautor', 'left')
            ->join('categorias c', 'c.idcategoria = r.idcategoria', 'left')
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
            $r['autores']   = (string)($r['autores']   ?? 'Sin autor');
            $r['categoria'] = (string)($r['categoria'] ?? '');
            return $r;
        }, $resultados);

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

        // Otros libros disponibles de la misma categoría
        $data['relacionados'] = $this->db->table('recursos r')
            ->select('r.idrecurso, r.titulo, r.portada, GROUP_CONCAT(DISTINCT a.nombre SEPARATOR ", ") AS autores, act.cantidad_disponible')
            ->join('recurso_autor ra', 'ra.idrecurso = r.idrecurso', 'left')
            ->join('autores a', 'a.idautor = ra.idautor', 'left')
            ->join('activos act', 'act.titulo = r.titulo', 'left')
            ->where('r.idcategoria', $libro['idcategoria'])
            ->where('r.idrecurso !=', $id)
            ->where('act.cantidad_disponible >', 0)
            ->groupBy('r.idrecurso')
            ->limit(8)
            ->get()
            ->getResultArray();

        $data['libro'] = $libro;

        return view('Biblioteca/detalles', $data);
    }
}
