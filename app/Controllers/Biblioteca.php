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

    public function reservar($id)
    {
        if (! session()->get('alumna_id')) {
            return redirect()->to(base_url('login'));
        }

        $idalumna = (int) session()->get('alumna_id');

        // Bloquear si ya tiene préstamo pendiente o activo
        $bloqueo = $this->db->table('prestamos')
            ->whereIn('estado', ['pendiente', 'activo'])
            ->where('idalumna', $idalumna)
            ->countAllResults();

        if ($bloqueo > 0) {
            return redirect()->to(base_url('biblioteca/detalle/' . $id))
                ->with('error', 'Ya tienes un libro prestado o una reserva pendiente. Debes devolverlo antes de pedir otro.');
        }

        // Obtener recurso
        $libro = $this->db->table('recursos r')
            ->select('r.*, GROUP_CONCAT(DISTINCT a.nombre SEPARATOR ", ") AS autores, c.categoria')
            ->join('recurso_autor ra', 'ra.idrecurso = r.idrecurso', 'left')
            ->join('autores a', 'a.idautor = ra.idautor', 'left')
            ->join('categorias c', 'c.idcategoria = r.idcategoria', 'left')
            ->where('r.idrecurso', $id)
            ->groupBy('r.idrecurso')
            ->get()
            ->getRowArray();

        if (! $libro) {
            return redirect()->to(base_url('catalogo'))->with('error', 'Libro no encontrado.');
        }

        // Obtener activo vinculado por título
        $activo = $this->db->table('activos')
            ->where('titulo', $libro['titulo'])
            ->get()
            ->getRowArray();

        if (! $activo || (int)($activo['cantidad_disponible'] ?? 0) <= 0) {
            return redirect()->to(base_url('biblioteca/detalle/' . $id))
                ->with('error', 'Este libro no está disponible para préstamo.');
        }

        $libro['autores']          = (string)($libro['autores'] ?? 'Sin autor');
        $libro['total_ejemplares'] = (int)($activo['cantidad_total'] ?? 0);
        $libro['disponibles']      = (int)($activo['cantidad_disponible'] ?? 0);
        $libro['idactivo']         = $activo['idactivo'];

        return view('Biblioteca/reservar', ['libro' => $libro]);
    }

    // ====================== PROCESAR RESERVA ======================
    public function procesarReserva()
    {
        if (! session()->get('alumna_id')) {
            return redirect()->to(base_url('login'));
        }

        $idalumna  = (int) session()->get('alumna_id');
        $idactivo  = (int) $this->request->getPost('idactivo');
        $idrecurso = (int) $this->request->getPost('idrecurso');

        $lima = new \DateTimeZone('America/Lima');
        $now  = new \DateTime('now', $lima);

        // Bloquear si ya tiene préstamo pendiente o activo
        $bloqueo = $this->db->table('prestamos')
            ->whereIn('estado', ['pendiente', 'activo'])
            ->where('idalumna', $idalumna)
            ->countAllResults();

        if ($bloqueo > 0) {
            return redirect()->to(base_url('biblioteca/detalle/' . $idrecurso))
                ->with('error', 'Ya tienes un libro prestado o una reserva pendiente. Debes devolverlo antes de pedir otro.');
        }

        // Validar que el activo existe y tiene stock
        $activo = $this->db->table('activos')
            ->where('idactivo', $idactivo)
            ->where('cantidad_disponible >', 0)
            ->get()
            ->getRowArray();

        if (! $activo) {
            return redirect()->to(base_url('biblioteca/detalle/' . $idrecurso))
                ->with('error', 'No hay ejemplares disponibles.');
        }

        // Validar alumna
        $alumna = $this->db->table('alumnas')
            ->where('id', $idalumna)
            ->get()
            ->getRowArray();

        if (! $alumna) {
            return redirect()->to(base_url('login'));
        }

        // Insertar préstamo como PENDIENTE (sin descontar stock todavía)
        $this->db->table('prestamos')->insert([
            'idalumna'         => $idalumna,
            'idactivo'         => $idactivo,
            'entrega'          => $now->format('Y-m-d'),
            'hora_entrega'     => $now->format('H:i:s'),
            'condicionentrega' => 'bueno',
            'estado'           => 'pendiente',
        ]);

        // Notificación al bibliotecario
        \App\Models\NotificacionesModel::registrar(
            'prestamo',
            'Nueva reserva pendiente: ' . $activo['titulo'] . ' → ' . $alumna['nombre'],
            'fas fa-bookmark',
            'warning'
        );

        return redirect()->to(base_url('catalogo'))
            ->with('success', '¡Reserva enviada! El bibliotecario la revisará pronto. Pasa a la biblioteca para recoger tu libro.');
    }

    // ====================== RANKING ======================
    public function ranking()
    {
        if (! session()->get('alumna_id')) {
            return redirect()->to(base_url('login'));
        }

        // Ranking de alumnas por total de préstamos
        $rankingAlumnas = $this->db->table('prestamos p')
            ->select('
                a.id AS idalumna,
                a.nombre,
                g.nombre AS grado,
                s.nombre AS seccion,
                COUNT(p.idprestamo) AS total_prestamos
            ')
            ->join('alumnas a',   'a.id = p.idalumna',       'left')
            ->join('grados g',    'g.id = a.grado_id',       'left')
            ->join('secciones s', 's.id = a.seccion_id',     'left')
            ->whereIn('p.estado', ['activo', 'devuelto'])
            ->groupBy('a.id')
            ->orderBy('total_prestamos', 'DESC')
            ->limit(20)
            ->get()
            ->getResultArray();

        // Ranking de aulas por total de préstamos
        $rankingAulas = $this->db->table('prestamos p')
            ->select('
                g.nombre AS grado,
                s.nombre AS seccion,
                COUNT(p.idprestamo)  AS total_prestamos,
                COUNT(DISTINCT a.id) AS total_alumnas
            ')
            ->join('alumnas a',   'a.id = p.idalumna',   'left')
            ->join('grados g',    'g.id = a.grado_id',   'left')
            ->join('secciones s', 's.id = a.seccion_id', 'left')
            ->whereIn('p.estado', ['activo', 'devuelto'])
            ->groupBy('g.id, s.id')
            ->orderBy('total_prestamos', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();

        return view('Biblioteca/ranking', [
            'rankingAlumnas' => $rankingAlumnas,
            'rankingAulas'   => $rankingAulas,
        ]);
    }
}
