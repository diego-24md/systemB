<?php

namespace App\Controllers;

use App\Models\AlumnaNotificacionModel;

class AlumnaNotificacion extends BaseController
{
    protected AlumnaNotificacionModel $notifModel;

    public function __construct()
    {
        $this->notifModel = new AlumnaNotificacionModel();
    }

    // Página principal de notificaciones
    public function index()
    {
        if (! session()->get('alumna_id')) {
            return redirect()->to(base_url('login'));
        }

        $alumnaId = (int) session()->get('alumna_id');

        // Marcar todas como leídas al entrar
        $this->notifModel->marcarTodasLeidas($alumnaId);

        // Obtener todas las notificaciones
        $notificaciones = $this->notifModel->getDeAlumna($alumnaId);

        return view('Biblioteca/notificaciones', [
            'notificaciones' => $notificaciones,
        ]);
    }

    // Endpoint para el badge (devuelve JSON)
    public function sinLeer()
    {
        if (! session()->get('alumna_id')) {
            return $this->response->setJSON(['count' => 0]);
        }

        $alumnaId = (int) session()->get('alumna_id');
        $count    = $this->notifModel->contarSinLeer($alumnaId);

        return $this->response->setJSON(['count' => $count]);
    }
}
