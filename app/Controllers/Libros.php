<?php

namespace App\Controllers;

use App\Models\LibrosModel;
use App\Models\CategoriasModel;

class Libros extends BaseController
{
    protected $librosModel;
    protected $categoriasModel;

    public function __construct()
    {
        $this->librosModel     = new LibrosModel();
        $this->categoriasModel = new CategoriasModel();
    }

    // Vista principal
    public function index()
    {
        $data['categorias'] = $this->categoriasModel->findAll();
        return view('libros/buscador', $data);
    }

    // AJAX: buscar libros
    public function buscar()
    {
        $q          = $this->request->getGet('q')          ?? '';
        $categoria  = $this->request->getGet('categoria')  ?? '';
        $disponible = $this->request->getGet('disponible') ?? '';

        $resultados = $this->librosModel->buscar($q, $categoria, $disponible);

        return $this->response
                    ->setContentType('application/json')
                    ->setJSON($resultados);
    }

    // Detalle de un libro
    public function detalle($id)
    {
        $db   = \Config\Database::connect();

        $libro = $db->table('recursos r')
            ->select('
                r.*,
                GROUP_CONCAT(DISTINCT a.datoautor SEPARATOR ", ") AS autores,
                sc.subcategoria,
                c.categoria,
                tr.tipo,
                COUNT(act.idactivo) AS total_ejemplares,
                SUM(
                    CASE WHEN act.idactivo NOT IN (
                        SELECT idactivo FROM prestamos WHERE devolucion IS NULL
                    ) THEN 1 ELSE 0 END
                ) AS disponibles
            ')
            ->join('autores a',        'a.idrecurso = r.idrecurso',          'left')
            ->join('sucbategorias sc', 'sc.idsubcategoria = r.idsubcategoria','left')
            ->join('categorias c',     'c.idcategoria = sc.idcategoria',     'left')
            ->join('tiporecurso tr',   'tr.idtiporecurso = r.idtiporecurso', 'left')
            ->join('activos act',      'act.idrecurso = r.idrecurso',        'left')
            ->where('r.idrecurso', $id)
            ->groupBy('r.idrecurso')
            ->get()->getRowObject();

        $data['libro'] = $libro;
        return view('libros/detalle', $data);
    }

    // Reservar / Préstamo
    public function reservar()
    {
        $idactivo = $this->request->getPost('idactivo');

        if (!$idactivo) {
            return $this->response
                        ->setJSON(['error' => 'ID de activo inválido'])
                        ->setStatusCode(400);
        }

        $db = \Config\Database::connect();

        // Verificar que el activo existe y no tiene préstamo activo
        $activo = $db->table('activos')
                     ->where('idactivo', $idactivo)
                     ->get()->getRowObject();

        if (!$activo) {
            return $this->response
                        ->setJSON(['error' => 'El activo no existe'])
                        ->setStatusCode(404);
        }

        $prestamoActivo = $db->table('prestamos')
                             ->where('idactivo', $idactivo)
                             ->where('devolucion IS NULL')
                             ->get()->getRowObject();

        if ($prestamoActivo) {
            return $this->response
                        ->setJSON(['error' => 'Este ejemplar ya está prestado'])
                        ->setStatusCode(409);
        }

        // Registrar préstamo
        // idusuario: aquí deberías tomar el usuario de sesión
        $idusuario = session()->get('idusuario') ?? 1;

        $db->table('prestamos')->insert([
            'idactivo'          => $idactivo,
            'entrega'           => date('Y-m-d'),
            'devolucion'        => null,
            'idusuario'         => $idusuario,
            'condicionentrega'  => $activo->condicion,
        ]);

        return $this->response->setJSON(['success' => true]);
    }
}