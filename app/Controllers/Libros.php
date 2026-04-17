<?php

namespace App\Controllers;

use App\Models\LibrosModel;
use App\Models\TipoRecursoModel;
use App\Models\CategoriasModel;

class Libros extends BaseController
{
    protected $librosModel;
    protected $tipoRecursoModel;
    protected $categoriasModel;

    public function __construct()
    {
        $this->librosModel = new LibrosModel();
        $this->tipoRecursoModel = new TipoRecursoModel();
        $this->categoriasModel = new CategoriasModel();
    }

    // ====================== LISTAR LIBROS - VISTA ======================
    public function index()
    {
        $data['libros'] = $this->librosModel->findAll();

        $data['header'] = view('partials/header');
        $data['footer'] = view('partials/footer');

        return view('libros/index', $data);
    }

    // ====================== FORMULARIO ======================
    public function registrar()
    {
        $data['tipos_recurso'] = $this->tipoRecursoModel->findAll();
        $data['categorias'] = $this->categoriasModel->findAll();

        $data['header'] = view('partials/header');
        $data['footer'] = view('partials/footer');

        return view('libros/registrar', $data);
    }

    // ====================== GUARDAR ======================
    public function guardar()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'titulo'          => 'required|min_length[3]',
            'autor'           => 'required|min_length[3]',
            'isbn'            => 'required|min_length[10]',
            'id_tipo_recurso' => 'required|integer',
            'categoria_id'    => 'required|integer',
            'anio'            => 'required|integer|greater_than[1900]',
            'numpaginas'      => 'required|integer|greater_than[1]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        // ====================== PORTADA ======================
        $file = $this->request->getFile('portada');
        $nombreImagen = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $nombreImagen = $file->getRandomName();
            $file->move('uploads/portadas/', $nombreImagen);
        }

        // ====================== DATA ======================
        $data = [
            'titulo'       => $this->request->getPost('titulo'),
            'autor'        => $this->request->getPost('autor'),
            'isbn'         => $this->request->getPost('isbn'),
            'idtiporecurso'=> $this->request->getPost('id_tipo_recurso'),
            'idcategoria'  => $this->request->getPost('categoria_id'),
            'descripcion'  => $this->request->getPost('descripcion'),
            'anio'         => $this->request->getPost('anio'),
            'numpaginas'   => $this->request->getPost('numpaginas'),
            'portada'      => $nombreImagen,
        ];

        if ($this->librosModel->save($data)) {
            return redirect()->to('/libros')
                ->with('success', 'Libro registrado correctamente ✅');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Error al guardar el libro');
    }

    // ====================== BUSCAR ======================
    public function buscar()
    {
        $q          = $this->request->getGet('q') ?? '';
        $categoria  = $this->request->getGet('categoria') ?? '';
        $disponible = $this->request->getGet('disponible') ?? '';

        $resultados = $this->librosModel->buscar($q, $categoria, $disponible);

        return $this->response
            ->setContentType('application/json')
            ->setJSON($resultados);
    }

    // ====================== DETALLE ======================
    public function detalle($id)
    {
        $db = \Config\Database::connect();

        $libro = $db->table('recursos r')
            ->select('
                r.*,
                GROUP_CONCAT(DISTINCT a.datoautor SEPARATOR ", ") AS autores,
                c.categoria,
                tr.tipo,
                COUNT(act.idactivo) AS total_ejemplares,
                SUM(
                    CASE WHEN act.idactivo NOT IN (
                        SELECT idactivo FROM prestamos WHERE devolucion IS NULL
                    ) THEN 1 ELSE 0 END
                ) AS disponibles
            ')
            ->join('autores a', 'a.idrecurso = r.idrecurso', 'left')
            ->join('categorias c', 'c.idcategoria = r.idcategoria', 'left')
            ->join('tiporecurso tr', 'tr.idtiporecurso = r.idtiporecurso', 'left')
            ->join('activos act', 'act.idrecurso = r.idrecurso', 'left')
            ->where('r.idrecurso', $id)
            ->groupBy('r.idrecurso')
            ->get()
            ->getRowObject();

        $data['libro'] = $libro;

        return view('libros/detalle', $data);
    }

    // ====================== RESERVAR ======================
    public function reservar()
    {
        $idactivo = $this->request->getPost('idactivo');

        if (!$idactivo) {
            return $this->response
                ->setJSON(['error' => 'ID de activo inválido'])
                ->setStatusCode(400);
        }

        $db = \Config\Database::connect();

        $activo = $db->table('activos')
            ->where('idactivo', $idactivo)
            ->get()
            ->getRowObject();

        if (!$activo) {
            return $this->response
                ->setJSON(['error' => 'El activo no existe'])
                ->setStatusCode(404);
        }

        $prestamoActivo = $db->table('prestamos')
            ->where('idactivo', $idactivo)
            ->where('devolucion IS NULL')
            ->get()
            ->getRowObject();

        if ($prestamoActivo) {
            return $this->response
                ->setJSON(['error' => 'Este ejemplar ya está prestado'])
                ->setStatusCode(409);
        }

        $idusuario = session()->get('idusuario') ?? 1;

        $db->table('prestamos')->insert([
            'idactivo'         => $idactivo,
            'entrega'          => date('Y-m-d'),
            'devolucion'       => null,
            'idusuario'        => $idusuario,
            'condicionentrega' => $activo->condicion ?? 'Buena',
        ]);

        return $this->response->setJSON(['success' => true]);
    }

    // ====================== EDITAR LIBRO ======================
    public function editar($id)
    {
        $data['libro'] = $this->librosModel->find($id);

        if (!$data['libro']) {
            return redirect()->to(base_url('libros'))
                ->with('error', 'Libro no encontrado');
        }

        $data['header'] = view('partials/header');
        $data['footer'] = view('partials/footer');

        return view('libros/editar', $data);
    }

    // ====================== ACTUALIZAR LIBRO ======================
    public function actualizar($id)
    {
        // ================= VALIDACIÓN =================
        // Solo validamos los campos que existen en el formulario editar.php
        $validation = \Config\Services::validation();

        $validation->setRules([
            'titulo'     => 'required|min_length[3]',
            'isbn'       => 'permit_empty|min_length[10]',
            'anio'       => 'permit_empty|integer|greater_than[1900]',
            'numpaginas' => 'permit_empty|integer|greater_than[1]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        // ================= IMAGEN =================
        $file = $this->request->getFile('portada');
        $nombreImagen = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $nombreImagen = $file->getRandomName();
            $file->move('uploads/portadas/', $nombreImagen);
        }

        // ================= DATA =================
        // Solo incluimos los campos que el formulario editar.php envía
        $data = [
            'titulo'      => $this->request->getPost('titulo'),
            'isbn'        => $this->request->getPost('isbn'),
            'descripcion' => $this->request->getPost('descripcion'),
            'anio'        => $this->request->getPost('anio'),
            'numpaginas'  => $this->request->getPost('numpaginas'),
        ];

        // Solo actualiza portada si subieron una nueva
        if ($nombreImagen) {
            $data['portada'] = $nombreImagen;
        }

        // ================= UPDATE =================
        if ($this->librosModel->update($id, $data)) {
            return redirect()->to(base_url('libros'))
                ->with('success', 'Libro actualizado correctamente ✅');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Error al actualizar el libro');
    }
}