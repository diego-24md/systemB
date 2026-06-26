<?php

namespace App\Controllers;

use App\Models\CategoriasModel;
use App\Models\TipoRecursoModel;

class Recursos extends BaseController
{
    protected $categoriasModel;
    protected $tipoRecursoModel;
    protected $db;

    public function __construct()
    {
        $this->categoriasModel  = new CategoriasModel();
        $this->tipoRecursoModel = new TipoRecursoModel();
        $this->db               = \Config\Database::connect();
    }

    // ================================================================
    //  AUTORES
    // ================================================================
    public function tipoGuardarAjax()
    {
        $nombre = trim($this->request->getPost('tipo'));

        if (!$nombre) {
            return $this->response->setJSON(['success' => false, 'message' => 'El nombre es obligatorio.']);
        }

        $existe = $this->tipoRecursoModel->where('tipo', $nombre)->first();
        if ($existe) {
            return $this->response->setJSON(['success' => false, 'message' => 'Ya existe ese tipo de recurso.']);
        }

        $id = $this->tipoRecursoModel->insert(['tipo' => $nombre]);

        return $this->response->setJSON([
            'success' => true,
            'id'      => $id,
            'tipo'    => $nombre,
        ]);
    }

    public function categoriaGuardarAjax()
    {
        $nombre  = trim($this->request->getPost('categoria'));
        $idTipo  = (int) $this->request->getPost('idtiporecurso');

        if (!$nombre || !$idTipo) {
            return $this->response->setJSON(['success' => false, 'message' => 'Completa todos los campos.']);
        }

        $existe = $this->categoriasModel
            ->where('categoria', $nombre)
            ->where('idtiporecurso', $idTipo)
            ->first();

        if ($existe) {
            return $this->response->setJSON(['success' => false, 'message' => 'Ya existe esa categoria para el tipo seleccionado.']);
        }

        $id = $this->categoriasModel->insert([
            'categoria'     => $nombre,
            'idtiporecurso' => $idTipo,
        ]);

        return $this->response->setJSON([
            'success'   => true,
            'id'        => $id,
            'categoria' => $nombre,
        ]);
    }

    // ================================================================
    //  TIPOS DE RECURSO
    // ================================================================

    public function tipos()
    {
        $data['tipos']  = $this->tipoRecursoModel->orderBy('tipo', 'ASC')->findAll();
        $data['header'] = view('partials/header');
        $data['footer'] = view('partials/footer');
        return view('recursos/tipos', $data);
    }

    public function tipoGuardar()
    {
        $rules = ['tipo' => 'required|min_length[2]|max_length[100]'];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $existe = $this->tipoRecursoModel->where('tipo', $this->request->getPost('tipo'))->first();
        if ($existe) {
            return redirect()->back()->withInput()->with('error', 'Ya existe un tipo de recurso con ese nombre.');
        }

        $this->tipoRecursoModel->insert([
            'tipo' => trim($this->request->getPost('tipo')),
        ]);

        \App\Models\NotificacionesModel::registrar(
            'catalogo',
            'Nuevo tipo de recurso: ' . $this->request->getPost('tipo'),
            'fas fa-tags',
            'success'
        );

        return redirect()->to('/recursos/tipos')->with('success', 'Tipo de recurso creado correctamente.');
    }

    public function tipoActualizar($id)
    {
        $tipo = $this->tipoRecursoModel->find($id);
        if (!$tipo) {
            return redirect()->to('/recursos/tipos')->with('error', 'Tipo no encontrado.');
        }

        $rules = ['tipo' => 'required|min_length[2]|max_length[100]'];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $existe = $this->tipoRecursoModel
            ->where('tipo', $this->request->getPost('tipo'))
            ->where('idtiporecurso !=', $id)
            ->first();

        if ($existe) {
            return redirect()->back()->withInput()->with('error', 'Ya existe otro tipo de recurso con ese nombre.');
        }

        $this->tipoRecursoModel->update($id, [
            'tipo' => trim($this->request->getPost('tipo')),
        ]);

        \App\Models\NotificacionesModel::registrar(
            'catalogo',
            'Tipo de recurso actualizado: ' . $this->request->getPost('tipo'),
            'fas fa-edit',
            'info'
        );

        return redirect()->to('/recursos/tipos')->with('success', 'Tipo de recurso actualizado correctamente.');
    }

    public function tipoEliminar($id)
    {
        $tipo = $this->tipoRecursoModel->find($id);
        if (!$tipo) {
            return redirect()->to('/recursos/tipos')->with('error', 'Tipo no encontrado.');
        }

        $categorias = $this->categoriasModel->where('idtiporecurso', $id)->countAllResults();
        if ($categorias > 0) {
            return redirect()->to('/recursos/tipos')
                ->with('error', 'No se puede eliminar: este tipo tiene ' . $categorias . ' categoria(s) asignada(s). Eliminaelas primero.');
        }

        $recursos = $this->db->table('recursos')->where('idtiporecurso', $id)->countAllResults();
        if ($recursos > 0) {
            return redirect()->to('/recursos/tipos')
                ->with('error', 'No se puede eliminar: este tipo tiene ' . $recursos . ' recurso(s) asignado(s).');
        }

        $this->tipoRecursoModel->delete($id);

        \App\Models\NotificacionesModel::registrar(
            'catalogo',
            'Tipo eliminado: ' . $tipo['tipo'],
            'fas fa-trash',
            'danger'
        );

        return redirect()->to('/recursos/tipos')->with('success', 'Tipo de recurso eliminado correctamente.');
    }

    // ================================================================
    //  CATEGORIAS
    // ================================================================

    public function categorias()
    {
        $data['categorias'] = $this->db->table('categorias c')
            ->select('c.idcategoria, c.categoria, t.tipo, t.idtiporecurso')
            ->join('tiporecurso t', 't.idtiporecurso = c.idtiporecurso', 'left')
            ->orderBy('t.tipo', 'ASC')
            ->orderBy('c.categoria', 'ASC')
            ->get()
            ->getResultArray();

        $data['tipos']  = $this->tipoRecursoModel->orderBy('tipo', 'ASC')->findAll();
        $data['header'] = view('partials/header');
        $data['footer'] = view('partials/footer');
        return view('recursos/categorias', $data);
    }

    public function categoriaGuardar()
    {
        $rules = [
            'categoria'     => 'required|min_length[2]|max_length[100]',
            'idtiporecurso' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $existe = $this->categoriasModel
            ->where('categoria', $this->request->getPost('categoria'))
            ->where('idtiporecurso', $this->request->getPost('idtiporecurso'))
            ->first();

        if ($existe) {
            return redirect()->back()->withInput()->with('error', 'Ya existe esa categoria para el tipo seleccionado.');
        }

        $this->categoriasModel->insert([
            'categoria'     => trim($this->request->getPost('categoria')),
            'idtiporecurso' => $this->request->getPost('idtiporecurso'),
        ]);

        \App\Models\NotificacionesModel::registrar(
            'catalogo',
            'Nueva categoria: ' . $this->request->getPost('categoria'),
            'fas fa-folder-plus',
            'success'
        );

        return redirect()->to('/recursos/categorias')->with('success', 'Categoria creada correctamente.');
    }

    public function categoriaActualizar($id)
    {
        $categoria = $this->categoriasModel->find($id);
        if (!$categoria) {
            return redirect()->to('/recursos/categorias')->with('error', 'Categoria no encontrada.');
        }

        $rules = [
            'categoria'     => 'required|min_length[2]|max_length[100]',
            'idtiporecurso' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $existe = $this->categoriasModel
            ->where('categoria', $this->request->getPost('categoria'))
            ->where('idtiporecurso', $this->request->getPost('idtiporecurso'))
            ->where('idcategoria !=', $id)
            ->first();

        if ($existe) {
            return redirect()->back()->withInput()->with('error', 'Ya existe esa categoria para el tipo seleccionado.');
        }

        $this->categoriasModel->update($id, [
            'categoria'     => trim($this->request->getPost('categoria')),
            'idtiporecurso' => $this->request->getPost('idtiporecurso'),
        ]);

        \App\Models\NotificacionesModel::registrar(
            'catalogo',
            'Categoria actualizada: ' . $this->request->getPost('categoria'),
            'fas fa-edit',
            'info'
        );

        return redirect()->to('/recursos/categorias')->with('success', 'Categoria actualizada correctamente.');
    }

    public function categoriaEliminar($id)
    {
        $categoria = $this->categoriasModel->find($id);
        if (!$categoria) {
            return redirect()->to('/recursos/categorias')->with('error', 'Categoria no encontrada.');
        }

        $recursos = $this->db->table('recursos')->where('idcategoria', $id)->countAllResults();
        if ($recursos > 0) {
            return redirect()->to('/recursos/categorias')
                ->with('error', 'No se puede eliminar: esta categoria tiene ' . $recursos . ' recurso(s) asignado(s).');
        }

        $this->categoriasModel->delete($id);

        \App\Models\NotificacionesModel::registrar(
            'catalogo',
            'Categoria eliminada: ' . $categoria['categoria'],
            'fas fa-trash',
            'danger'
        );

        return redirect()->to('/recursos/categorias')->with('success', 'Categoria eliminada correctamente.');
    }
}
