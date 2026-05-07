<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('usuario_id') && session()->get('bibliotecario_rol') === 'bibliotecario') {
            return redirect()->to('/');
        }

        return view('auth/login', [
            'error' => session()->getFlashdata('error')
        ]);
    }

    public function login()
    {
        $usuario  = $this->request->getPost('usuario');
        $password = $this->request->getPost('password');

        $db   = \Config\Database::connect();
        $user = $db->table('usuarios')
            ->where('usuario', $usuario)
            ->where('rol', 'bibliotecario')
            ->where('activo', 1)
            ->get()->getRowArray();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->to('/login')
                ->with('error', 'Usuario o contraseña incorrectos.');
        }

        session()->set([
            'usuario_id'        => $user['id'],
            'nombre'            => $user['nombre'],
            'usuario'           => $user['usuario'],
            'bibliotecario_rol' => 'bibliotecario',
            'foto'              => $user['foto'],
        ]);

        return redirect()->to('/');
    }

    public function logout()
    {
        session()->remove([
            'usuario_id',
            'nombre',
            'usuario',
            'bibliotecario_rol',
            'foto',
        ]);
        return redirect()->to('/login');
    }

    public function perfil()
    {
        $db   = \Config\Database::connect();
        $user = $db->table('usuarios')->where('id', session()->get('usuario_id'))->get()->getRowArray();

        return view('Auth/perfil', [
            'usuario' => $user,
            'header'  => view('partials/header'),
            'footer'  => view('partials/footer'),
        ]);
    }

    public function cambiarPassword()
    {
        $actual    = $this->request->getPost('password_actual');
        $nueva     = $this->request->getPost('password_nueva');
        $confirmar = $this->request->getPost('password_confirmar');

        $db   = \Config\Database::connect();
        $user = $db->table('usuarios')->where('id', session()->get('usuario_id'))->get()->getRowArray();

        if (!password_verify($actual, $user['password'])) {
            return redirect()->to('/perfil')->with('error', 'La contraseña actual es incorrecta.');
        }

        if ($nueva !== $confirmar) {
            return redirect()->to('/perfil')->with('error', 'Las contraseñas nuevas no coinciden.');
        }

        if (strlen($nueva) < 6) {
            return redirect()->to('/perfil')->with('error', 'La contraseña debe tener al menos 6 caracteres.');
        }

        $db->table('usuarios')->where('id', session()->get('usuario_id'))->update([
            'password'   => password_hash($nueva, PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/perfil')->with('success', 'Contraseña actualizada correctamente.');
    }
}
