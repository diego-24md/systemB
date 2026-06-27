<?php

namespace App\Controllers;

use App\Models\NotificacionesModel;

class Notificaciones extends BaseController
{
    public function index()
    {
        $model = new NotificacionesModel();
        $db    = \Config\Database::connect();

        $db->table('notificaciones')->where('leida', 0)->update(['leida' => 1]);

        $reservasPendientes = $db->table('notificaciones')
            ->where('tipo', 'prestamo')
            ->like('mensaje', 'Nueva reserva pendiente', 'after')
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();

        $historial = $db->table('notificaciones')
            ->groupStart()
            ->where('tipo', 'libro')
            ->orGroupStart()
            ->where('tipo', 'prestamo')
            ->notLike('mensaje', 'Nueva reserva pendiente')
            ->groupEnd()
            ->orGroupStart()
            ->where('tipo', 'catalogo')
            ->groupEnd()
            ->groupEnd()
            ->orderBy('created_at', 'DESC')
            ->limit(15)
            ->get()->getResultArray();

        $data['reservasPendientes'] = $reservasPendientes;
        $data['historial']          = $historial;
        $data['totalReservas']      = count($reservasPendientes);
        $data['totalGeneral']       = $model->countAll();
        $data['totalLibros']        = $db->table('notificaciones')->where('tipo', 'libro')->countAllResults();
        $data['totalPrestamos']     = $db->table('notificaciones')->where('tipo', 'prestamo')->countAllResults();
        $data['totalHistorial']     = $db->table('notificaciones')
            ->groupStart()
            ->where('tipo', 'libro')
            ->orGroupStart()
            ->where('tipo', 'prestamo')
            ->notLike('mensaje', 'Nueva reserva pendiente')
            ->groupEnd()
            ->groupEnd()
            ->countAllResults();

        $data['header'] = view('Partials/header');
        $data['footer'] = view('Partials/footer');

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
        $db     = \Config\Database::connect();

        $historial = $db->table('notificaciones')
            ->groupStart()
            ->where('tipo', 'libro')
            ->orGroupStart()
            ->where('tipo', 'prestamo')
            ->notLike('mensaje', 'Nueva reserva pendiente')
            ->groupEnd()
            ->groupEnd()
            ->orderBy('created_at', 'DESC')
            ->limit($limit, $offset)
            ->get()->getResultArray();

        return $this->response->setJSON($historial);
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

    public function eliminar($id)
    {
        $db = \Config\Database::connect();
        $db->table('notificaciones')->where('id', $id)->delete();
        return $this->response->setJSON(['success' => true]);
    }

    public function limpiarHistorial()
    {
        $db = \Config\Database::connect();

        $db->table('notificaciones')
            ->groupStart()
            ->where('tipo', 'libro')
            ->orGroupStart()
            ->where('tipo', 'prestamo')
            ->notLike('mensaje', 'Nueva reserva pendiente')
            ->groupEnd()
            ->orGroupStart()
            ->where('tipo', 'catalogo')
            ->groupEnd()
            ->groupEnd()
            ->delete();

        return $this->response->setJSON(['success' => true]);
    }
}
