<?php

namespace App\Controllers;

class AuthAlumna extends BaseController
{
    public function index()
    {
        if (session()->get('alumna_id')) {
            return redirect()->to('/catalogo');
        }

        return view('Auth/login_alumna', [
            'error' => session()->getFlashdata('error')
        ]);
    }

    public function login()
    {
        $dni    = $this->request->getPost('dni');
        $nombre = strtoupper(trim($this->request->getPost('nombre')));

        $db     = \Config\Database::connect();
        $alumna = $db->table('alumnas')
            ->where('dni', $dni)
            ->get()->getRowArray();

        if (!$alumna) {
            return redirect()->to('/alumnas/login')
                ->with('error', 'DNI no encontrado.');
        }

        $nombreBD = strtoupper(trim($alumna['nombre']));
        if (strpos($nombreBD, $nombre) === false && strpos($nombre, explode(',', $nombreBD)[0]) === false) {
            return redirect()->to('/alumnas/login')
                ->with('error', 'El nombre no coincide con el DNI ingresado.');
        }

        session()->set([
            'alumna_id'      => $alumna['id'],
            'alumna_nombre'  => $alumna['nombre'],
            'alumna_dni'     => $alumna['dni'],
            'alumna_grado'   => $alumna['grado_id'],
            'alumna_seccion' => $alumna['seccion_id'],
        ]);

        return redirect()->to('/catalogo');
    }

    public function logout()
    {
        session()->remove([
            'alumna_id',
            'alumna_nombre',
            'alumna_dni',
            'alumna_grado',
            'alumna_seccion',
        ]);
        return redirect()->to('/alumnas/login');
    }
}
