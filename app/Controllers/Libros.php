<?php

namespace App\Controllers;

use App\Models\LibrosModel;
use App\Models\TipoRecursoModel;
use App\Models\CategoriasModel;
use App\Models\AutorModel;

class Libros extends BaseController
{
    protected $librosModel;
    protected $tipoRecursoModel;
    protected $categoriasModel;
    protected $autorModel;
    protected $db;

    public function __construct()
    {
        $this->librosModel      = new LibrosModel();
        $this->tipoRecursoModel = new TipoRecursoModel();
        $this->categoriasModel  = new CategoriasModel();
        $this->autorModel       = new AutorModel();
        $this->db               = \Config\Database::connect();
    }

    // ====================== LISTAR ======================
    public function index()
    {
        $data['libros'] = $this->db->table('recursos r')
            ->select('
                r.*,
                GROUP_CONCAT(DISTINCT a.nombre SEPARATOR ", ") AS autores
            ')
            ->join('recurso_autor ra', 'ra.idrecurso = r.idrecurso', 'left')
            ->join('autores a', 'a.idautor = ra.idautor', 'left')
            ->groupBy('r.idrecurso')
            ->get()
            ->getResultArray();

        $data['header'] = view('partials/header');
        $data['footer'] = view('partials/footer');

        return view('libros/index', $data);
    }

    // ====================== FORMULARIO REGISTRAR ======================
    public function registrar()
    {
        $data['tipos_recurso'] = $this->tipoRecursoModel->findAll();

        $categorias = $this->categoriasModel
            ->select('idcategoria, categoria, idtiporecurso')
            ->orderBy('categoria', 'ASC')
            ->findAll();

        $categorias_por_tipo = [];

        foreach ($categorias as $cat) {
            $tipoId = $cat['idtiporecurso'];
            if ($tipoId !== null) {
                if (!isset($categorias_por_tipo[$tipoId])) {
                    $categorias_por_tipo[$tipoId] = [];
                }
                $categorias_por_tipo[$tipoId][] = [
                    'id'     => $cat['idcategoria'],
                    'nombre' => $cat['categoria']
                ];
            }
        }

        $data['categorias_por_tipo'] = $categorias_por_tipo;
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
            'id_tipo_recurso' => 'required|integer',
            'categoria_id'    => 'required|integer',
            'anio'            => 'required|integer|greater_than[1900]',
            'numpaginas'      => 'required|integer|greater_than[1]',
            'cantidad'        => 'required|integer|greater_than[0]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $isbn = preg_replace('/\D/', '', $this->request->getPost('isbn'));

        if (strlen($isbn) !== 13 && strlen($isbn) !== 10) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['isbn' => 'El ISBN debe tener 10 o 13 dígitos']);
        }

        $file         = $this->request->getFile('portada');
        $nombreImagen = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $nombreImagen = $file->getRandomName();
            $file->move('uploads/portadas/', $nombreImagen);
        }

        $data = [
            'titulo'        => $this->request->getPost('titulo'),
            'isbn'          => $isbn,
            'idtiporecurso' => $this->request->getPost('id_tipo_recurso'),
            'idcategoria'   => $this->request->getPost('categoria_id'),
            'descripcion'   => $this->request->getPost('descripcion'),
            'anio'          => $this->request->getPost('anio'),
            'numpaginas'    => $this->request->getPost('numpaginas'),
            'portada'       => $nombreImagen,
        ];

        $idRecurso = $this->librosModel->insert($data);

        // ====================== ACTIVOS ======================
        $cantidad = (int)$this->request->getPost('cantidad');

        if ($cantidad > 0) {
            $this->db->table('activos')->insert([
                'titulo'              => $this->request->getPost('titulo'),
                'idcategoria'         => $this->request->getPost('categoria_id'),
                'idtiporecurso'       => $this->request->getPost('id_tipo_recurso'),
                'cantidad_total'      => $cantidad,
                'cantidad_disponible' => $cantidad,
                'estado'              => 'disponible',
            ]);
        }

        // ====================== AUTORES ======================
        $autores = $this->request->getPost('autores');

        if ($autores) {
            foreach ($autores as $nombreAutor) {
                $nombreAutor = trim($nombreAutor);
                if ($nombreAutor === '') continue;

                $autor = $this->db->table('autores')
                    ->where('nombre', $nombreAutor)
                    ->get()
                    ->getRowArray();

                if (!$autor) {
                    $idAutor = $this->autorModel->insert(['nombre' => $nombreAutor]);
                } else {
                    $idAutor = $autor['idautor'];
                }

                $this->db->table('recurso_autor')->insert([
                    'idrecurso' => $idRecurso,
                    'idautor'   => $idAutor
                ]);
            }
        }

        \App\Models\NotificacionesModel::registrar(
            'libro',
            'Nuevo libro registrado: ' . $this->request->getPost('titulo'),
            'fas fa-book',
            'success'
        );

        return redirect()->to('/libros')
            ->with('success', 'Libro registrado correctamente');
    }

    // ====================== DETALLE ======================
    public function detalle($id)
    {
        $libro = $this->db->table('recursos r')
            ->select('
                r.*,
                GROUP_CONCAT(DISTINCT a.nombre SEPARATOR ", ") AS autores,
                c.categoria,
                tr.tipo,
                COUNT(act.idactivo) AS total_ejemplares,
                SUM(
                    CASE WHEN act.idactivo NOT IN (
                        SELECT idactivo FROM prestamos WHERE devolucion IS NULL
                    ) THEN 1 ELSE 0 END
                ) AS disponibles
            ')
            ->join('recurso_autor ra', 'ra.idrecurso = r.idrecurso', 'left')
            ->join('autores a', 'a.idautor = ra.idautor', 'left')
            ->join('categorias c', 'c.idcategoria = r.idcategoria', 'left')
            ->join('tiporecurso tr', 'tr.idtiporecurso = r.idtiporecurso', 'left')
            ->join('activos act', 'act.idrecurso = r.idrecurso', 'left')
            ->where('r.idrecurso', $id)
            ->groupBy('r.idrecurso')
            ->get()
            ->getRowArray();

        if (!$libro) {
            return redirect()->to('/libros')->with('error', 'Libro no encontrado');
        }

        $data['libro']  = $libro;
        $data['header'] = view('partials/header');
        $data['footer'] = view('partials/footer');

        return view('libros/detalle', $data);
    }

    // ====================== EDITAR ======================
    public function editar($id)
    {
        $data['libro'] = $this->db->table('recursos')
            ->where('idrecurso', $id)
            ->get()
            ->getRowArray();

        if (!$data['libro']) {
            return redirect()->to('/libros')->with('error', 'Libro no encontrado');
        }

        $data['autores'] = $this->db->table('recurso_autor ra')
            ->select('a.idautor, a.nombre')
            ->join('autores a', 'a.idautor = ra.idautor')
            ->where('ra.idrecurso', $id)
            ->get()
            ->getResultArray();

        // Activo relacionado
        $data['activo'] = $this->db->table('activos')
            ->where('titulo', $data['libro']['titulo'])
            ->get()
            ->getRowArray();

        $data['tipos_recurso'] = $this->tipoRecursoModel->findAll();
        $data['categorias']    = $this->categoriasModel->findAll();
        $data['header']        = view('partials/header');
        $data['footer']        = view('partials/footer');

        return view('libros/editar', $data);
    }

    // ====================== ACTUALIZAR ======================
    public function actualizar($id)
    {
        $isbn = preg_replace('/\D/', '', $this->request->getPost('isbn'));

        $file         = $this->request->getFile('portada');
        $nombreImagen = $this->request->getPost('portada_actual');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $nombreImagen = $file->getRandomName();
            $file->move('uploads/portadas/', $nombreImagen);
        }

        $data = [
            'titulo'        => $this->request->getPost('titulo'),
            'isbn'          => $isbn,
            'idtiporecurso' => $this->request->getPost('id_tipo_recurso'),
            'idcategoria'   => $this->request->getPost('categoria_id'),
            'descripcion'   => $this->request->getPost('descripcion'),
            'anio'          => $this->request->getPost('anio'),
            'numpaginas'    => $this->request->getPost('numpaginas'),
            'portada'       => $nombreImagen,
        ];

        $this->librosModel->update($id, $data);

        // ====================== ACTUALIZAR ACTIVO ======================
        $cantidad = (int)$this->request->getPost('cantidad');

        if ($cantidad > 0) {
            $activo = $this->db->table('activos')
                ->where('titulo', $this->request->getPost('titulo'))
                ->get()->getRowArray();

            if ($activo) {
                $diff = $cantidad - $activo['cantidad_total'];
                $nuevaDisponible = max(0, $activo['cantidad_disponible'] + $diff);

                $this->db->table('activos')
                    ->where('idactivo', $activo['idactivo'])
                    ->update([
                        'titulo'              => $this->request->getPost('titulo'),
                        'cantidad_total'      => $cantidad,
                        'cantidad_disponible' => $nuevaDisponible,
                        'estado'              => $nuevaDisponible > 0 ? 'disponible' : 'agotado',
                    ]);
            } else {
                $this->db->table('activos')->insert([
                    'titulo'              => $this->request->getPost('titulo'),
                    'idcategoria'         => $this->request->getPost('categoria_id'),
                    'idtiporecurso'       => $this->request->getPost('id_tipo_recurso'),
                    'cantidad_total'      => $cantidad,
                    'cantidad_disponible' => $cantidad,
                    'estado'              => 'disponible',
                ]);
            }
        }

        // ====================== ACTUALIZAR AUTORES ======================
        $this->db->table('recurso_autor')->where('idrecurso', $id)->delete();

        $autores = $this->request->getPost('autores');

        if ($autores) {
            foreach ($autores as $nombreAutor) {
                $nombreAutor = trim($nombreAutor);
                if ($nombreAutor === '') continue;

                $autor = $this->db->table('autores')
                    ->where('nombre', $nombreAutor)
                    ->get()
                    ->getRowArray();

                if (!$autor) {
                    $idAutor = $this->autorModel->insert(['nombre' => $nombreAutor]);
                } else {
                    $idAutor = $autor['idautor'];
                }

                $this->db->table('recurso_autor')->insert([
                    'idrecurso' => $id,
                    'idautor'   => $idAutor
                ]);
            }
        }

        \App\Models\NotificacionesModel::registrar(
            'libro',
            'Libro actualizado: ' . $this->request->getPost('titulo'),
            'fas fa-edit',
            'info'
        );

        return redirect()->to('/libros')
            ->with('success', 'Libro actualizado correctamente');
    }

    // ====================== ELIMINAR ======================
    public function eliminar($id)
    {
        $this->db->table('recurso_autor')->where('idrecurso', $id)->delete();
        $this->librosModel->delete($id);

        \App\Models\NotificacionesModel::registrar(
            'libro',
            'Libro eliminado (ID: ' . $id . ')',
            'fas fa-trash',
            'danger'
        );

        return redirect()->to('/libros')
            ->with('success', 'Libro eliminado');
    }
}
