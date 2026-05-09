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
        $db = \Config\Database::connect();

        $data['prestamos'] = $this->prestamosModel->getPrestamosConAlumna();
        $data['activos']   = $db->table('activos')
            ->where('estado', 'disponible')
            ->orderBy('titulo', 'ASC')
            ->get()->getResultArray();
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

        $db = \Config\Database::connect();

        //Validación
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

        // Validar duplicado ANTES de insertar
        $existe = $db->table('prestamos')
            ->where('idalumna', $idalumna)
            ->where('idactivo', $idactivo)
            ->where('devolucion IS NULL', null, false)
            ->countAllResults();

        if ($existe > 0) {
            return redirect()->back()->with('error', 'Este libro ya está prestado a esta alumna.');
        }

        // Insertar préstamo
        $this->prestamosModel->insert([
            'idalumna'         => $idalumna,
            'idactivo'         => $idactivo,
            'entrega'          => $this->request->getPost('entrega'),
            'devolucion'       => $this->request->getPost('devolucion') ?: null,
            'condicionentrega' => $this->request->getPost('condicionentrega'),
        ]);

        // Descontar stock
        $db->table('activos')
            ->set('cantidad_disponible', 'cantidad_disponible - 1', false)
            ->set("estado", "IF(cantidad_disponible - 1 <= 0, 'agotado', 'disponible')", false)
            ->where('idactivo', $idactivo)
            ->update();

        return redirect()->to(base_url('prestamos'))
            ->with('success', 'Préstamo registrado correctamente.');
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
