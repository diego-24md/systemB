<?php

namespace App\Controllers;

use App\Models\PersonaModel;
use App\Models\GrupoModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Persona extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();

        // ✅ JOIN CORRECTO (usando matriculas)
        $personas = $db->table('personas p')
            ->select('p.*, g.grado, g.seccion, m.idgrupo')
            ->join('matriculas m', 'm.idpersona = p.idpersona', 'left')
            ->join('grupos g', 'g.idgrupo = m.idgrupo', 'left')
            ->get()
            ->getResultArray();

        $grupoModel = new GrupoModel();

        return view('Alumnos/index', [
            'personas' => $personas,
            'grupos'   => $grupoModel->findAll(),
            'header'   => view('Partials/header'),
            'footer'   => view('Partials/footer'),
        ]);
    }

    public function importar()
    {
        $db = \Config\Database::connect();

        $archivo = $this->request->getFile('archivo_excel');
        $idgrupo = $this->request->getPost('idgrupo');

        if (!$archivo->isValid()) {
            return redirect()->to(base_url('alumnos'))->with('error', 'Archivo inválido');
        }

        // mover archivo
        $archivo->move(WRITEPATH . 'uploads');
        $ruta = WRITEPATH . 'uploads/' . $archivo->getName();

        $spreadsheet = IOFactory::load($ruta);
        $hoja = $spreadsheet->getActiveSheet();
        $filas = $hoja->toArray();

        $model = new PersonaModel();

        foreach ($filas as $i => $fila) {
            if ($i === 0) continue; // saltar encabezado

            // ✅ guardar persona
            $personaId = $model->insert([
                'apellidos' => $fila[0],
                'nombres'   => $fila[1],
                'tipodoc'   => $fila[2],
                'numdoc'    => $fila[3],
                'telefono'  => $fila[4],
            ]);

            // ✅ guardar matrícula (AQUÍ VA EL GRUPO)
            $db->table('matriculas')->insert([
                'idpersona' => $personaId,
                'idgrupo'   => $idgrupo,
                'periodo'   => date('Y'),
                'estado'    => 1
            ]);
        }

        return redirect()->to(base_url('alumnos'))->with('success', 'Alumnos cargados correctamente');
    }
}