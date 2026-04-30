<?php

namespace App\Controllers;

use App\Models\AlumnasModel;

class Alumnas extends BaseController
{
    protected $alumnasModel;

    public function __construct()
    {
        $this->alumnasModel = new AlumnasModel();
        helper(['form', 'text']);
    }

    // ====================== LISTAR ALUMNAS ======================
    public function index()
    {
        $grado = $this->request->getGet('grado');
        $seccion = $this->request->getGet('seccion');
        $buscar = $this->request->getGet('buscar');

        if ($grado)
            $this->alumnasModel->where('grado', $grado);
        if ($seccion)
            $this->alumnasModel->where('seccion', $seccion);
        if ($buscar) {
            $this->alumnasModel->groupStart()
                ->like('nombres', $buscar)
                ->orLike('apellidos', $buscar)
                ->orLike('dni', $buscar)
                ->groupEnd();
        }

        $data['alumnas'] = $this->alumnasModel->paginate(15);
        $data['pager'] = $this->alumnasModel->pager;

        $countModel = new \App\Models\AlumnasModel();
        if ($grado)
            $countModel->where('grado', $grado);
        if ($seccion)
            $countModel->where('seccion', $seccion);
        if ($buscar) {
            $countModel->groupStart()
                ->like('nombres', $buscar)
                ->orLike('apellidos', $buscar)
                ->orLike('dni', $buscar)
                ->groupEnd();
        }
        $data['total'] = $countModel->countAllResults();

        $data['grado'] = $grado;
        $data['seccion'] = $seccion;
        $data['buscar'] = $buscar;
        $data['header'] = view('partials/header');
        $data['footer'] = view('partials/footer');

        return view('alumnas/index', $data);
    }

    // ====================== IMPORTAR EXCEL ======================
    public function guardar()
    {
        $archivo = $this->request->getFile('archivo');
        $grado = $this->request->getPost('grado');
        $seccion = $this->request->getPost('seccion');

        if (!$archivo || !$archivo->isValid()) {
            return redirect()->back()->with('error', 'Debe seleccionar un archivo Excel válido.');
        }

        if (empty($grado) || empty($seccion)) {
            return redirect()->back()->with('error', 'Grado y Sección son obligatorios.');
        }

        $archivo->move(WRITEPATH . 'uploads');
        $ruta = WRITEPATH . 'uploads/' . $archivo->getName();

        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($ruta);
            $hoja = $spreadsheet->getActiveSheet();
            $filas = $hoja->toArray();
            $insertados = 0;

            $this->alumnasModel->where('grado', $grado)
                ->where('seccion', $seccion)
                ->delete();

            foreach ($filas as $i => $fila) {
                if ($i === 0)
                    continue;

                $nombres = trim($fila[0] ?? '');
                $apellidos = trim($fila[1] ?? '');
                $dni = trim($fila[2] ?? '');

                if (empty($nombres) && empty($apellidos))
                    continue;

                $data = [
                    'nombres' => $nombres,
                    'apellidos' => $apellidos,
                    'dni' => $dni,
                    'grado' => $grado,
                    'seccion' => $seccion,
                ];

                if ($this->alumnasModel->save($data)) {
                    $insertados++;
                }
            }

            if (file_exists($ruta))
                unlink($ruta);

            return redirect()->to('/alumnas')
                ->with('success', "Se importaron correctamente {$insertados} alumnas en {$grado}° - {$seccion}.");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al procesar el archivo: ' . $e->getMessage());
        }
    }

    // ====================== ELIMINAR ======================
    public function eliminar($id)
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/alumnas');
        }

        if ($this->alumnasModel->delete($id)) {
            return redirect()->to('/alumnas')->with('success', 'Alumna eliminada correctamente.');
        }

        return redirect()->to('/alumnas')->with('error', 'No se pudo eliminar la alumna.');
    }

    // ====================== EDITAR ======================
    public function editar($id)
    {
        $data['alumna'] = $this->alumnasModel->find($id);

        if (empty($data['alumna'])) {
            return redirect()->to('/alumnas')->with('error', 'Alumna no encontrada.');
        }

        $data['header'] = view('partials/header');
        $data['footer'] = view('partials/footer');

        return view('alumnas/editar', $data);
    }

    // ====================== ACTUALIZAR ======================
    public function actualizar($id)
    {
        $rules = [
            'nombres' => 'required|min_length[2]|max_length[100]',
            'apellidos' => 'required|min_length[2]|max_length[100]',
            'dni' => 'required|exact_length[8]|numeric',
            'grado' => 'required',
            'seccion' => 'required|max_length[2]',
        ];

        if (!$this->validate($rules)) {
            $data['alumna'] = $this->alumnasModel->find($id);
            $data['header'] = view('partials/header');
            $data['footer'] = view('partials/footer');
            return view('alumnas/editar', $data);
        }

        $dataUpdate = [
            'nombres' => $this->request->getPost('nombres'),
            'apellidos' => $this->request->getPost('apellidos'),
            'dni' => $this->request->getPost('dni'),
            'grado' => $this->request->getPost('grado'),
            'seccion' => $this->request->getPost('seccion'),
        ];

        if ($this->alumnasModel->update($id, $dataUpdate)) {
            return redirect()->to('/alumnas')->with('success', 'Alumna actualizada correctamente.');
        }

        return redirect()->to('/alumnas')->with('error', 'Error al actualizar la alumna.');
    }
}