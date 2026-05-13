<?php

namespace App\Controllers;

use App\Models\PrestamosModel;
use App\Models\AlumnasModel;

class Prestamos extends BaseController
{
    protected $prestamosModel;
    protected $alumnasModel;
    protected $db;

    public function __construct()
    {
        $this->prestamosModel = new PrestamosModel();
        $this->alumnasModel   = new AlumnasModel();
        $this->db             = \Config\Database::connect();
    }

    // ====================== LISTAR ======================
    public function index()
    {
        $prestamos = $this->db->query("
            SELECT
                p.idprestamo,
                p.entrega,
                p.devolucion,
                p.condicionentrega,
                al.nombre AS alumna_nombre,
                al.dni    AS alumna_dni,
                ac.titulo AS libro_titulo,
                ac.idactivo,
                CASE
                    WHEN p.devolucion IS NOT NULL THEN 'devuelto'
                    WHEN p.devolucion IS NULL AND DATEDIFF(CURDATE(), p.entrega) > 7 THEN 'vencido'
                    ELSE 'activo'
                END AS estado
            FROM prestamos p
            LEFT JOIN alumnas al ON al.id = p.idalumna
            LEFT JOIN activos ac ON ac.idactivo = p.idactivo
            ORDER BY p.idprestamo DESC
        ")->getResultArray();

        $alumnas  = $this->alumnasModel->findAll();
        $activos = $this->db->table('activos')
            ->select('idactivo, titulo')
            ->orderBy('titulo', 'ASC')
            ->get()
            ->getResultArray();

        $data['prestamos'] = $prestamos;
        $data['alumnas']   = $alumnas;
        $data['activos']   = $activos;
        $data['header']    = view('Partials/header');
        $data['footer']    = view('Partials/footer');

        return view('Prestamos/index', $data);
    }

    // ====================== BUSCAR ALUMNA ======================
    public function buscarAlumna()
    {
        $dni    = $this->request->getGet('dni');
        $alumna = $this->alumnasModel->findByDni($dni);

        if (!$alumna) {
            return $this->response->setJSON(['error' => 'Alumna no encontrada']);
        }

        $grado   = $this->db->table('grados')->where('id', $alumna['grado_id'])->get()->getRowArray();
        $seccion = $this->db->table('secciones')->where('id', $alumna['seccion_id'])->get()->getRowArray();

        return $this->response->setJSON([
            'id'      => $alumna['id'],
            'nombre'  => $alumna['nombre'],
            'dni'     => $alumna['dni'],
            'grado'   => $grado['nombre']   ?? '—',
            'seccion' => $seccion['nombre'] ?? '—',
        ]);
    }

    // ====================== BUSCAR ACTIVO ======================
    public function buscarRecurso()
    {
        $id = $this->request->getGet('id');

        $activo = $this->db->query("
            SELECT
                idactivo,
                titulo,
                autor,
                cantidad_total,
                cantidad_disponible
            FROM activos
            WHERE idactivo = ?
        ", [$id])->getRowArray();

        if (!$activo) {
            return $this->response->setJSON(['error' => 'Libro no encontrado']);
        }

        return $this->response->setJSON($activo);
    }

    // ====================== GUARDAR ======================
    public function guardar()
    {
        $idalumna   = $this->request->getPost('idalumna');
        $idactivo   = $this->request->getPost('idactivo');
        $entrega    = $this->request->getPost('entrega');
        $devolucion = $this->request->getPost('devolucion') ?: null;
        $condicion  = $this->request->getPost('condicionentrega') ?: 'Bueno';

        $this->db->table('prestamos')->insert([
            'idactivo'         => $idactivo,
            'idalumna'         => $idalumna,
            'entrega'          => $entrega,
            'devolucion'       => $devolucion,
            'condicionentrega' => $condicion,
        ]);

        return redirect()->to(base_url('prestamos'))
            ->with('success', 'Préstamo registrado correctamente ✅');
    }

    // ====================== DEVOLVER ======================
    public function devolver($id)
    {
        $this->db->table('prestamos')
            ->where('idprestamo', $id)
            ->update(['devolucion' => date('Y-m-d')]);

        return redirect()->to(base_url('prestamos'))
            ->with('success', 'Devolución registrada correctamente ✅');
    }

    // ====================== PENDIENTES ======================
    public function pendientes()
    {
        $prestamos = $this->db->query("
            SELECT
                p.idprestamo,
                p.entrega,
                p.condicionentrega,
                al.nombre AS alumna_nombre,
                al.dni    AS alumna_dni,
                ac.titulo AS libro_titulo,
                DATEDIFF(CURDATE(), p.entrega) AS dias_prestado
            FROM prestamos p
            LEFT JOIN alumnas al ON al.id = p.idalumna
            LEFT JOIN activos ac ON ac.idactivo = p.idactivo
            WHERE p.devolucion IS NULL
            ORDER BY p.entrega ASC
        ")->getResultArray();

        $data['prestamos'] = $prestamos;
        $data['header']    = view('Partials/header');
        $data['footer']    = view('Partials/footer');

        return view('Prestamos/pendientes', $data);
    }

    // ====================== VENCIDOS ======================
    public function vencidos()
    {
        $prestamos = $this->db->query("
            SELECT
                p.idprestamo,
                p.entrega,
                p.condicionentrega,
                al.nombre AS alumna_nombre,
                al.dni    AS alumna_dni,
                ac.titulo AS libro_titulo,
                DATEDIFF(CURDATE(), p.entrega) AS dias_vencido
            FROM prestamos p
            LEFT JOIN alumnas al ON al.id = p.idalumna
            LEFT JOIN activos ac ON ac.idactivo = p.idactivo
            WHERE p.devolucion IS NULL
              AND DATEDIFF(CURDATE(), p.entrega) > 7
            ORDER BY p.entrega ASC
        ")->getResultArray();

        $data['prestamos'] = $prestamos;
        $data['header']    = view('Partials/header');
        $data['footer']    = view('Partials/footer');

        return view('Prestamos/vencidos', $data);
    }
}