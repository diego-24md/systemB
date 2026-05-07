<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class PerfilController extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    // =========================
    // MOSTRAR PERFIL
    // =========================
    public function index()
    {
        $session = session();
        $idUsuario = $session->get('usuario_id');

        $usuario = $this->usuarioModel->find($idUsuario);

        $data = [
            'header' => view('partials/header'),
            'footer' => view('partials/footer'),
            'usuario' => $usuario
        ];

        return view('Auth/perfil', $data);
    }

    // =========================
    // ACTUALIZAR NOMBRE / PASSWORD
    // =========================
    public function actualizar()
    {
        $session = session();
        $idUsuario = $session->get('usuario_id');

        $tipo = $this->request->getPost('tipo');

        // =========================
        // ACTUALIZAR NOMBRE
        // =========================
        if ($tipo === 'nombre') {

            $nombre = $this->request->getPost('nombre');

            if (empty($nombre)) {
                return redirect()->back()->with('error', 'El nombre no puede estar vacío');
            }

            $this->usuarioModel->update($idUsuario, [
                'nombre' => $nombre
            ]);

            session()->set('nombre', $nombre);

            return redirect()->to(base_url('perfil'))
                ->with('success', 'Nombre actualizado correctamente');
        }

        // =========================
        // CAMBIAR PASSWORD
        // =========================
        if ($tipo === 'password') {

            $passwordActual = $this->request->getPost('password_actual');
            $passwordNueva = $this->request->getPost('password_nueva');
            $passwordConfirmar = $this->request->getPost('password_confirmar');

            $usuario = $this->usuarioModel->find($idUsuario);

            if (!$usuario || !password_verify($passwordActual, (string)($usuario['password'] ?? ''))) {
                return redirect()->back()
                    ->with('error', 'La contraseña actual es incorrecta');
            }

            if ($passwordNueva !== $passwordConfirmar) {
                return redirect()->back()
                    ->with('error', 'Las contraseñas nuevas no coinciden');
            }

            $this->usuarioModel->update($idUsuario, [
                'password' => password_hash($passwordNueva, PASSWORD_DEFAULT)
            ]);

            return redirect()->to(base_url('perfil'))
                ->with('success', 'Contraseña actualizada correctamente');
        }

        return redirect()->back()
            ->with('error', 'Acción no válida');
    }

    // =========================
    // ACTUALIZR FOTO
    // =========================
    public function actualizarFoto()
    {
        $session = session();
        $idUsuario = $session->get('usuario_id');

        $archivo = $this->request->getFile('foto');

        if (!$archivo || !$archivo->isValid()) {
            return redirect()->back()
                ->with('error', 'No se seleccionó ninguna imagen válida');
        }

        $nombreNuevo = $archivo->getRandomName();

        $archivo->move('uploads/perfiles', $nombreNuevo);

        $rutaFoto = $nombreNuevo;

        $this->usuarioModel->update($idUsuario, [
            'foto' => $rutaFoto
        ]);

        session()->set('foto', $rutaFoto);

        return redirect()->to(base_url('perfil'))
            ->with('success', 'Foto actualizada correctamente');
    }
}
