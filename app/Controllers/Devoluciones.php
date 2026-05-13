<?php

namespace App\Controllers;

use App\Models\PrestamosModel;

class Devoluciones extends BaseController
{
    public function index()
    {
        $model = new PrestamosModel();

        $data['prestamos'] = $model
            ->where('estado', 'activo')
            ->findAll();

        // 👇 CAMBIO AQUÍ (sin /index)
        return view('devoluciones', $data);
    }

    public function guardar()
    {
        $id = $this->request->getPost('idprestamo');

        // 👇 CAMBIO AQUÍ (nombre correcto)
        $model = new PrestamosModel();

        $model->update($id, [
            'estado' => 'devuelto'
        ]);

        return redirect()->to('/devoluciones')
            ->with('success', 'Libro devuelto correctamente');
    }
}