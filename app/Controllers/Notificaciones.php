<?php

namespace App\Controllers;

use App\Models\NotificacionesModel;

class Notificaciones extends BaseController
{

    public function index()
    {
        $model = new NotificacionesModel();
        $db    = \Config\Database::connect();

        // Marcar todas como leídas
        $db->table('notificaciones')->where('leida', 0)->update(['leida' => 1]);

        $data['notificaciones'] = $model
            ->orderBy('created_at', 'DESC')
            ->limit(15)
            ->findAll();

        $data['totalGeneral'] = $model->countAll();
        $data['header']       = view('Partials/header');
        $data['footer']       = view('Partials/footer');
        $data['totalLibros']    = $db->table('notificaciones')->where('tipo', 'libro')->countAllResults();
        $data['totalPrestamos'] = $db->table('notificaciones')->where('tipo', 'prestamo')->countAllResults();

        return view('notificaciones/index', $data);
    }

    public function marcar($id)
    {
        $model = new NotificacionesModel();
        $model->update($id, ['leida' => 1]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true]);
        }
        return redirect()->back();
    }

    public function cargarMas()
    {
        $offset = (int) $this->request->getGet('offset');
        $limit  = 15;

        $model = new NotificacionesModel();
        $notificaciones = $model
            ->orderBy('created_at', 'DESC')
            ->limit($limit, $offset)
            ->findAll();

        return $this->response->setJSON($notificaciones);
    }

    public function marcarTodas()
    {
        $db = \Config\Database::connect();
        $db->table('notificaciones')->where('leida', 0)->update(['leida' => 1]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true]);
        }
        return redirect()->back();
    }
}
