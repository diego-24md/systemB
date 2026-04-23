<?php

namespace App\Controllers;

use App\Models\AlumnasModel;
use App\Models\GradosModel;
use App\Models\SeccionesModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Alumnas extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new AlumnasModel();
    }

    // 🔹 CARGA VISTA + GRADOS
    public function index()
    {
        $gradosModel = new GradosModel();

        return view('Alumnas/index', [
            'header' => view('partials/header'),
            'footer' => view('partials/footer'),
            'grados' => $gradosModel->findAll()
        ]);
    }

    // 🔹 OBTENER ALUMNAS (AHORA CON IDS)
    public function obtener()
    {
        $grado_id = $this->request->getGet('grado_id');
        $seccion_id = $this->request->getGet('seccion_id');

        $data = $this->model
            ->select('alumnas.*, grados.nombre as grado, secciones.nombre as seccion')
            ->join('grados', 'grados.id = alumnas.grado_id')
            ->join('secciones', 'secciones.id = alumnas.seccion_id')
            ->where('alumnas.grado_id', $grado_id)
            ->where('alumnas.seccion_id', $seccion_id)
            ->findAll();

        return $this->response->setJSON($data);
    }

    // 🔹 OBTENER SECCIONES POR GRADO (AJAX)
    public function seccionesPorGrado()
    {
        $grado_id = $this->request->getGet('grado_id');

        $model = new SeccionesModel();

        $data = $model->where('grado_id', $grado_id)->findAll();

        return $this->response->setJSON($data);
    }

    // 🔹 IMPORTAR EXCEL (CON IDS)
    public function importar()
    {
        $file = $this->request->getFile('archivo');
        $grado_id = $this->request->getPost('grado_id');
        $seccion_id = $this->request->getPost('seccion_id');

        $spreadsheet = IOFactory::load($file);
        $rows = $spreadsheet->getActiveSheet()->toArray();

        // 🔥 eliminar registros previos
        $this->model
            ->where('grado_id', $grado_id)
            ->where('seccion_id', $seccion_id)
            ->delete();

        foreach ($rows as $i => $row) {
            if ($i == 0) continue; // encabezado
            if (empty($row[0])) continue;

            $this->model->insert([
                'dni' => $row[0],
                'nombre' => $row[1],
                'grado_id' => $grado_id,
                'seccion_id' => $seccion_id
            ]);
        }

        return $this->response->setJSON(['status' => 'ok']);
    }
}
