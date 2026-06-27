<?php

namespace App\Controllers;

use App\Models\PrestamosModel;
use App\Models\ActivosModel;

class Prestamos extends BaseController
{
    protected $prestamosModel;
    protected $activosModel;

    public function __construct()
    {
        $this->prestamosModel = new PrestamosModel();
        $this->activosModel   = new ActivosModel();
    }

    public function index()
    {
        $data['header'] = view('Partials/header');
        $data['footer'] = view('Partials/footer');

        return view('prestamos/index', $data);
    }

    public function buscarAlumna()
    {
        $q   = trim($this->request->getGet('q') ?? $this->request->getGet('dni') ?? '');
        $db  = \Config\Database::connect();

        if ($q === '') {
            return $this->response->setJSON(['success' => false, 'resultados' => []]);
        }

        if (preg_match('/^\d+$/', $q)) {
            if (strlen($q) === 8) {
                $alumna = $db->table('alumnas a')
                    ->select('a.id, a.nombre, a.dni, g.nombre AS grado, s.nombre AS seccion, a.turno')
                    ->join('grados g', 'g.id = a.grado_id', 'left')
                    ->join('secciones s', 's.id = a.seccion_id', 'left')
                    ->where('a.dni', $q)
                    ->get()->getRowArray();

                if (!$alumna) {
                    return $this->response->setJSON(['success' => false, 'resultados' => [], 'unico' => false]);
                }

                return $this->response->setJSON([
                    'success'    => true,
                    'resultados' => [$alumna],
                    'unico'      => true,
                ]);
            }

            $resultados = $db->table('alumnas a')
                ->select('a.id, a.nombre, a.dni, g.nombre AS grado, s.nombre AS seccion, a.turno')
                ->join('grados g', 'g.id = a.grado_id', 'left')
                ->join('secciones s', 's.id = a.seccion_id', 'left')
                ->like('a.dni', $q, 'after')
                ->orderBy('a.dni', 'ASC')
                ->limit(8)
                ->get()->getResultArray();

            return $this->response->setJSON([
                'success'    => count($resultados) > 0,
                'resultados' => $resultados,
                'unico'      => false,
            ]);
        }

        $resultados = $db->table('alumnas a')
            ->select('a.id, a.nombre, a.dni, g.nombre AS grado, s.nombre AS seccion, a.turno')
            ->join('grados g', 'g.id = a.grado_id', 'left')
            ->join('secciones s', 's.id = a.seccion_id', 'left')
            ->like('a.nombre', $q)
            ->orderBy('a.nombre', 'ASC')
            ->limit(8)
            ->get()->getResultArray();

        return $this->response->setJSON([
            'success'    => count($resultados) > 0,
            'resultados' => $resultados,
            'unico'      => false,
        ]);
    }

    public function guardar()
    {
        $idalumna = $this->request->getPost('idalumna');
        $idactivo = $this->request->getPost('idactivo');

        $db   = \Config\Database::connect();
        $lima = new \DateTimeZone('America/Lima');
        $now  = new \DateTime('now', $lima);

        $activo = $db->table('activos')
            ->where('idactivo', $idactivo)
            ->where('cantidad_disponible >', 0)
            ->get()
            ->getRowArray();

        if (!$activo) {
            return redirect()->back()->with('error', 'No hay disponibilidad.');
        }

        $alumna = $db->table('alumnas')
            ->where('id', $idalumna)
            ->get()->getRowArray();

        if (!$alumna) {
            return redirect()->back()->with('error', 'La alumna no existe.');
        }

        $existe = $db->table('prestamos')
            ->where('idalumna', $idalumna)
            ->where('idactivo', $idactivo)
            ->where('estado', 'activo')
            ->countAllResults();

        if ($existe > 0) {
            return redirect()->back()->with('error', 'Este libro ya está prestado a esta alumna.');
        }

        $tieneActivo = $db->table('prestamos')
            ->where('idalumna', $idalumna)
            ->where('estado', 'activo')
            ->countAllResults();

        if ($tieneActivo > 0) {
            return redirect()->back()->with('error', 'La alumna ya tiene un libro prestado. Debe devolverlo antes de pedir otro.');
        }

        $this->prestamosModel->insert([
            'idalumna'         => $idalumna,
            'idactivo'         => $idactivo,
            'entrega'          => $now->format('Y-m-d'),
            'hora_entrega'     => $now->format('H:i:s'),
            'condicionentrega' => $this->request->getPost('condicionentrega'),
            'estado'           => 'activo',
        ]);

        \App\Models\NotificacionesModel::registrar(
            'prestamo',
            'Préstamo registrado: ' . $activo['titulo'] . ' → ' . $alumna['nombre'],
            'fas fa-hand-holding-heart',
            'primary'
        );

        $db->table('activos')
            ->set('cantidad_disponible', 'cantidad_disponible - 1', false)
            ->set('estado', "IF(cantidad_disponible - 1 <= 0, 'agotado', 'disponible')", false)
            ->where('idactivo', $idactivo)
            ->update();

        return redirect()->to(base_url('prestamos'))
            ->with('success', 'Préstamo registrado correctamente.');
    }

    public function devoluciones()
    {
        $data['prestamos'] = $this->prestamosModel->getPrestamosActivos();
        $data['header']    = view('Partials/header');
        $data['footer']    = view('Partials/footer');

        return view('prestamos/devoluciones', $data);
    }

    public function devolver($id)
    {
        $db   = \Config\Database::connect();
        $lima = new \DateTimeZone('America/Lima');
        $now  = new \DateTime('now', $lima);

        $prestamo = $db->table('prestamos')
            ->where('idprestamo', $id)
            ->where('estado', 'activo')
            ->get()->getRowArray();

        if (!$prestamo) {
            return redirect()->back()->with('error', 'Préstamo no encontrado.');
        }

        $horaEntrega = new \DateTime($prestamo['entrega'] . ' ' . $prestamo['hora_entrega'], $lima);
        $diff        = $horaEntrega->diff($now);
        $minutos     = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;

        $detalle = $db->table('prestamos p')
            ->select('ac.titulo, a.nombre')
            ->join('alumnas a', 'a.id = p.idalumna', 'left')
            ->join('activos ac', 'ac.idactivo = p.idactivo', 'left')
            ->where('p.idprestamo', $id)
            ->get()->getRowArray();

        \App\Models\NotificacionesModel::registrar(
            'prestamo',
            'Devolución: ' . ($detalle['titulo'] ?? '—') . ' → ' . ($detalle['nombre'] ?? '—'),
            'fas fa-undo',
            'success'
        );

        $db->table('prestamos')
            ->where('idprestamo', $id)
            ->update([
                'devolucion'      => $now->format('Y-m-d'),
                'hora_devolucion' => $now->format('H:i:s'),
                'minutos'         => $minutos,
                'estado'          => 'devuelto',
            ]);

        $db->table('activos')
            ->set('cantidad_disponible', 'cantidad_disponible + 1', false)
            ->set('estado', 'disponible')
            ->where('idactivo', $prestamo['idactivo'])
            ->update();

        return redirect()->to(base_url('prestamos/devoluciones'))
            ->with('success', 'Devolución registrada correctamente.');
    }

    public function historial()
    {
        $data['prestamos'] = $this->prestamosModel->getHistorial();
        $data['header']    = view('Partials/header');
        $data['footer']    = view('Partials/footer');

        return view('prestamos/historial', $data);
    }

    public function ranking()
    {
        $data['aulas']   = $this->prestamosModel->getRankingAulas();
        $data['alumnas'] = $this->prestamosModel->getRankingAlumnas();
        $data['header']  = view('Partials/header');
        $data['footer']  = view('Partials/footer');

        return view('prestamos/ranking', $data);
    }

    public function buscarLibros()
    {
        $q  = $this->request->getGet('q');
        $db = \Config\Database::connect();

        $data = $db->table('activos a')
            ->select('a.idactivo, a.titulo, a.autor, a.cantidad_disponible, a.foto, c.categoria')
            ->join('categorias c', 'c.idcategoria = a.idcategoria', 'left')
            ->groupStart()
            ->like('a.titulo', $q)
            ->orLike('a.autor', $q)
            ->groupEnd()
            ->where('a.estado', 'disponible')
            ->where('a.cantidad_disponible >', 0)
            ->limit(10)
            ->get()
            ->getResultArray();

        foreach ($data as &$row) {
            $row['foto_url'] = !empty($row['foto'])
                ? base_url('uploads/portadas/' . $row['foto'])
                : base_url('img/default-book.jpg');
        }

        return $this->response->setJSON($data);
    }

    // ====================== APROBAR RESERVA ======================
    public function aprobar($id)
    {
        $db   = \Config\Database::connect();
        $lima = new \DateTimeZone('America/Lima');
        $now  = new \DateTime('now', $lima);
        $hora = (int) $now->format('H');

        $prestamo = $db->table('prestamos')
            ->where('idprestamo', $id)
            ->where('estado', 'pendiente')
            ->get()->getRowArray();

        if (!$prestamo) {
            return redirect()->to(base_url('prestamos/pendientes'))
                ->with('error', 'Reserva no encontrada o ya fue procesada.');
        }

        // ── Validación de turno ──────────────────────────────────────
        $turno = $prestamo['turno'] ?? '';

        $turnoValido = match ($turno) {
            'manana' => $hora >= 8  && $hora < 13,
            'tarde'  => $hora >= 13 && $hora < 19,
            default  => true, // sin turno definido: no se bloquea
        };

        if (!$turnoValido) {
            $horario = $turno === 'manana' ? '8:00 am – 1:00 pm' : '1:00 pm – 7:00 pm';
            return redirect()->to(base_url('prestamos/pendientes'))
                ->with('error', "No se puede aprobar esta reserva fuera del horario del turno ($horario).");
        }
        // ─────────────────────────────────────────────────────────────

        $activo = $db->table('activos')
            ->where('idactivo', $prestamo['idactivo'])
            ->where('cantidad_disponible >', 0)
            ->get()->getRowArray();

        if (!$activo) {
            return redirect()->to(base_url('prestamos/pendientes'))
                ->with('error', 'No hay stock disponible para aprobar este préstamo.');
        }

        $alumna = $db->table('alumnas')
            ->where('id', $prestamo['idalumna'])
            ->get()->getRowArray();

        $db->table('prestamos')
            ->where('idprestamo', $id)
            ->update([
                'estado'       => 'activo',
                'hora_entrega' => $now->format('H:i:s'),
            ]);

        $db->table('activos')
            ->set('cantidad_disponible', 'cantidad_disponible - 1', false)
            ->set('estado', "IF(cantidad_disponible - 1 <= 0, 'agotado', 'disponible')", false)
            ->where('idactivo', $prestamo['idactivo'])
            ->update();

        \App\Models\NotificacionesModel::registrar(
            'prestamo',
            'Préstamo aprobado: ' . $activo['titulo'] . ' → ' . ($alumna['nombre'] ?? '—'),
            'fas fa-check-circle',
            'success'
        );

        $notifAlumna = new \App\Models\AlumnaNotificacionModel();
        $notifAlumna->notificar(
            (int) $prestamo['idalumna'],
            'Tu reserva del libro "' . ($activo['titulo'] ?? '—') . '" fue aceptada.',
            'aceptado'
        );

        return redirect()->to(base_url('prestamos/pendientes'))
            ->with('success', 'Préstamo aprobado correctamente.');
    }

    // ====================== RECHAZAR RESERVA ======================
    public function rechazar($id)
    {
        $db = \Config\Database::connect();

        $prestamo = $db->table('prestamos')
            ->where('idprestamo', $id)
            ->where('estado', 'pendiente')
            ->get()->getRowArray();

        if (!$prestamo) {
            return redirect()->to(base_url('prestamos/pendientes'))
                ->with('error', 'Reserva no encontrada o ya fue procesada.');
        }

        $activo = $db->table('activos')
            ->where('idactivo', $prestamo['idactivo'])
            ->get()->getRowArray();

        $alumna = $db->table('alumnas')
            ->where('id', $prestamo['idalumna'])
            ->get()->getRowArray();

        $db->table('prestamos')
            ->where('idprestamo', $id)
            ->update(['estado' => 'rechazado']);

        \App\Models\NotificacionesModel::registrar(
            'prestamo',
            'Reserva rechazada: ' . ($activo['titulo'] ?? '—') . ' → ' . ($alumna['nombre'] ?? '—'),
            'fas fa-times-circle',
            'danger'
        );

        $notifAlumna = new \App\Models\AlumnaNotificacionModel();
        $notifAlumna->notificar(
            (int) $prestamo['idalumna'],
            'Tu reserva del libro "' . ($activo['titulo'] ?? '—') . '" fue rechazada.',
            'rechazado'
        );

        return redirect()->to(base_url('prestamos/pendientes'))
            ->with('success', 'Reserva rechazada.');
    }

    // ====================== RESERVAS PENDIENTES ======================
    public function pendientes()
    {
        $db   = \Config\Database::connect();
        $lima = new \DateTimeZone('America/Lima');
        $now  = new \DateTime('now', $lima);
        $hora = (int) $now->format('H'); // ← ahora sí toma hora de Lima

        $data['pendientes'] = $db->table('prestamos p')
            ->select('p.idprestamo, p.idactivo, p.entrega, p.hora_entrega, p.condicionentrega,
                  a.nombre, a.dni, a.turno, ac.titulo')
            ->join('alumnas a', 'a.id = p.idalumna', 'left')
            ->join('activos ac', 'ac.idactivo = p.idactivo', 'left')
            ->where('p.estado', 'pendiente')
            ->orderBy('p.idprestamo', 'ASC')
            ->get()
            ->getResultArray();

        $data['hora_actual'] = $hora;

        $data['header'] = view('Partials/header');
        $data['footer'] = view('Partials/footer');

        return view('prestamos/pendientes', $data);
    }

    // ====================== PRÉSTAMOS ACTIVOS ======================
    public function activos()
    {
        $data['prestamos'] = $this->prestamosModel->getPrestamosActivos();
        $data['header']    = view('Partials/header');
        $data['footer']    = view('Partials/footer');

        return view('prestamos/activos', $data);
    }
}
