<?php

namespace App\Controllers;

use App\Models\PrestamosModel;

class Prestamos extends BaseController
{
    protected $prestamosModel;

    public function __construct()
    {
        $this->prestamosModel = new PrestamosModel();
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

        $db     = \Config\Database::connect();
        $alumna = $db->table('alumnas')->where('id', $idalumna)->get()->getRowArray();

        if (!$alumna) {
            return redirect()->back()->with('error', 'La alumna no existe.');
        }

        $activo = $db->table('activos')->where('idactivo', $idactivo)->get()->getRowArray();

        if (!$activo) {
            return redirect()->back()->with('error', 'El activo no existe.');
        }

        if ($activo['cantidad_disponible'] <= 0) {
            return redirect()->back()->with('error', 'No hay ejemplares disponibles de ese libro.');
        }

        $this->prestamosModel->insert([
            'idalumna'         => $idalumna,
            'idactivo'         => $idactivo,
            'entrega'          => $this->request->getPost('entrega'),
            'devolucion'       => $this->request->getPost('devolucion') ?: null,
            'condicionentrega' => $this->request->getPost('condicionentrega'),
        ]);

        // Reducir cantidad disponible
        $db->table('activos')->where('idactivo', $idactivo)->update([
            'cantidad_disponible' => $activo['cantidad_disponible'] - 1,
            'estado'              => ($activo['cantidad_disponible'] - 1) <= 0 ? 'agotado' : 'disponible',
        ]);

        \App\Models\NotificacionesModel::registrar(
            'prestamo',
            'Nuevo préstamo registrado para: ' . $alumna['nombre'],
            'fas fa-book-reader',
            'warning'
        );

        return redirect()->to(base_url('prestamos'))
            ->with('success', 'Préstamo registrado correctamente.');
    }
}
