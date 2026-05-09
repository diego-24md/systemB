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
        $data['prestamos'] = $this->prestamosModel->getPrestamosActivos();
        $data['header']    = view('Partials/header');
        $data['footer']    = view('Partials/footer');

        return view('prestamos/index', $data);
    }

    public function buscarAlumna()
    {
        $dni = $this->request->getGet('dni');
        $db  = \Config\Database::connect();

        $alumna = $db->table('alumnas')
            ->where('dni', $dni)
            ->get()->getRowArray();

        if (!$alumna) {
            return $this->response->setJSON(['success' => false]);
        }

        return $this->response->setJSON([
            'success' => true,
            'id'      => $alumna['id'],
            'nombre'  => $alumna['nombre'],
        ]);
    }

    public function guardar()
    {
        $idalumna = $this->request->getPost('idalumna');
        $idactivo = $this->request->getPost('idactivo');

        $db   = \Config\Database::connect();
        $lima = new \DateTimeZone('America/Lima');
        $now  = new \DateTime('now', $lima);

        // Validar stock
        $activo = $db->table('activos')
            ->where('idactivo', $idactivo)
            ->where('cantidad_disponible >', 0)
            ->get()
            ->getRowArray();

        if (!$activo) {
            return redirect()->back()->with('error', 'No hay disponibilidad.');
        }

        // Validar alumna
        $alumna = $db->table('alumnas')
            ->where('id', $idalumna)
            ->get()->getRowArray();

        if (!$alumna) {
            return redirect()->back()->with('error', 'La alumna no existe.');
        }

        // Validar duplicado
        $existe = $db->table('prestamos')
            ->where('idalumna', $idalumna)
            ->where('idactivo', $idactivo)
            ->where('estado', 'activo')
            ->countAllResults();

        if ($existe > 0) {
            return redirect()->back()->with('error', 'Este libro ya está prestado a esta alumna.');
        }

        // Validar que la alumna no tenga ningún préstamo activo
        $tieneActivo = $db->table('prestamos')
            ->where('idalumna', $idalumna)
            ->where('estado', 'activo')
            ->countAllResults();

        if ($tieneActivo > 0) {
            return redirect()->back()->with('error', 'La alumna ya tiene un libro prestado. Debe devolverlo antes de pedir otro.');
        }

        // Insertar préstamo
        $this->prestamosModel->insert([
            'idalumna'         => $idalumna,
            'idactivo'         => $idactivo,
            'entrega'          => $now->format('Y-m-d'),
            'hora_entrega'     => $now->format('H:i:s'),
            'condicionentrega' => $this->request->getPost('condicionentrega'),
            'estado'           => 'activo',
        ]);

        // ✅ Notificación
        \App\Models\NotificacionesModel::registrar(
            'prestamo',
            'Préstamo registrado: ' . $activo['titulo'] . ' → ' . $alumna['nombre'],
            'fas fa-hand-holding-heart',
            'primary'
        );

        // Descontar stock
        $db->table('activos')
            ->set('cantidad_disponible', 'cantidad_disponible - 1', false)
            ->set("estado", "IF(cantidad_disponible - 1 <= 0, 'agotado', 'disponible')", false)
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
        $db = \Config\Database::connect();

        $prestamo = $db->table('prestamos')
            ->where('idprestamo', $id)
            ->where('estado', 'activo')
            ->get()->getRowArray();

        if (!$prestamo) {
            return redirect()->back()->with('error', 'Préstamo no encontrado.');
        }

        // Calcular minutos
        $horaEntrega    = new \DateTime($prestamo['entrega'] . ' ' . $prestamo['hora_entrega']);
        $horaDevolucion = new \DateTime(date('Y-m-d') . ' ' . date('H:i:s'));
        $diff           = $horaEntrega->diff($horaDevolucion);
        $minutos        = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;

        // Actualizar préstamo
        $db->table('prestamos')
            ->where('idprestamo', $id)
            ->update([
                'devolucion'      => date('Y-m-d'),
                'hora_devolucion' => date('H:i:s'),
                'minutos'         => $minutos,
                'estado'          => 'devuelto',
            ]);

        // Devolver stock
        $db->table('activos')
            ->set('cantidad_disponible', 'cantidad_disponible + 1', false)
            ->set('estado', 'disponible', false)
            ->where('idactivo', $prestamo['idactivo'])
            ->update();

        return redirect()->to(base_url('prestamos'))
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
}
