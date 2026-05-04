<?php

namespace App\Controllers;

use App\Models\AlumnasModel;

class Alumnas extends BaseController
{
    protected $alumnasModel;
    protected $db;

    public function __construct()
    {
        $this->alumnasModel = new AlumnasModel();
        $this->db = \Config\Database::connect(); // ← agregado
        helper(['form', 'text']);
    }

    // ====================== LISTAR ALUMNAS ======================
    public function index()
    {
        $grado_id   = $this->request->getGet('grado');
        $seccion_id = $this->request->getGet('seccion');
        $buscar     = $this->request->getGet('buscar');

        if ($grado_id)
            $this->alumnasModel->where('grado_id', $grado_id);
        if ($seccion_id)
            $this->alumnasModel->where('seccion_id', $seccion_id);
        if ($buscar) {
            $this->alumnasModel->groupStart()
                ->like('nombre', $buscar)
                ->orLike('dni', $buscar)
                ->groupEnd();
        }

        $data['alumnas'] = $this->alumnasModel->paginate(15);
        $data['pager']   = $this->alumnasModel->pager;

        $countModel = new \App\Models\AlumnasModel();
        if ($grado_id)
            $countModel->where('grado_id', $grado_id);
        if ($seccion_id)
            $countModel->where('seccion_id', $seccion_id);
        if ($buscar) {
            $countModel->groupStart()
                ->like('nombre', $buscar)
                ->orLike('dni', $buscar)
                ->groupEnd();
        }
        $data['total'] = $countModel->countAllResults();

        $data['grado']   = $grado_id;
        $data['seccion'] = $seccion_id;
        $data['buscar']  = $buscar;
        $data['header']  = view('partials/header');
        $data['footer']  = view('partials/footer');

        return view('alumnas/index', $data);
    }

    // ====================== VISTA IMPORTAR ======================
    public function importar()
    {
        try {
            $grados = $this->db->table('grados')
                ->orderBy('id', 'ASC')
                ->get()
                ->getResultArray();

            $secciones = $this->db->table('secciones')
                ->select('id, nombre, grado_id')   // ← importante agregar grado_id
                ->orderBy('grado_id', 'ASC')
                ->orderBy('nombre', 'ASC')
                ->get()
                ->getResultArray();

            $data = [
                'grados'     => $grados,
                'secciones'  => $secciones,
                'header'     => view('partials/header'),
                'footer'     => view('partials/footer')
            ];

            return view('alumnas/importar', $data);
        } catch (\Exception $e) {
            log_message('error', 'Error al cargar importar: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error al cargar el formulario. Verifique las tablas de grados y secciones.');
        }
    }

    // ====================== IMPORTAR EXCEL ======================
    public function guardar()
    {
        $archivo    = $this->request->getFile('archivo');
        $grado_id   = $this->request->getPost('grado');
        $seccion_id = $this->request->getPost('seccion');

        if (!$archivo || !$archivo->isValid()) {
            return redirect()->back()->with('error', 'Debe seleccionar un archivo Excel válido.');
        }

        if (empty($grado_id) || empty($seccion_id)) {
            return redirect()->back()->with('error', 'Grado y Sección son obligatorios.');
        }

        $archivo->move(WRITEPATH . 'uploads');
        $ruta = WRITEPATH . 'uploads/' . $archivo->getName();

        try {
            // Obtener nombre del grado y sección desde la BD
            $grado   = $this->db->table('grados')->where('id', $grado_id)->get()->getRowArray();
            $seccion = $this->db->table('secciones')->where('id', $seccion_id)->get()->getRowArray();

            if (!$grado || !$seccion) {
                if (file_exists($ruta)) unlink($ruta);
                return redirect()->back()->with('error', 'Grado o sección no válidos.');
            }

            // Construir nombre de pestaña: ej. "1° A"
            $nombreHoja = $grado['nombre'] . ' ' . $seccion['nombre'];

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($ruta);
            $hoja        = $spreadsheet->getSheetByName($nombreHoja);

            if (!$hoja) {
                if (file_exists($ruta)) unlink($ruta);
                return redirect()->back()
                    ->with('error', "No se encontró la pestaña \"{$nombreHoja}\" en el archivo Excel.");
            }

            $filas      = $hoja->toArray();
            $insertados = 0;

            $this->alumnasModel->where('grado_id', $grado_id)
                ->where('seccion_id', $seccion_id)
                ->delete();

            foreach ($filas as $fila) {
                $posibleDni = trim($fila[4] ?? '');

                // Solo filas con DNI de 8 dígitos
                if (!preg_match('/^\d{8}$/', $posibleDni)) continue;

                $nombre = trim($fila[2] ?? '');

                if (empty($nombre)) continue;

                $data = [
                    'nombre'     => $nombre,
                    'dni'        => $posibleDni,
                    'grado_id'   => $grado_id,
                    'seccion_id' => $seccion_id,
                ];

                if ($this->alumnasModel->save($data)) {
                    $insertados++;
                }
            }

            if (file_exists($ruta)) unlink($ruta);

            return redirect()->to('/alumnas')
                ->with('success', "Se importaron correctamente {$insertados} alumnas.");
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
            'nombre'     => 'required|min_length[2]|max_length[150]',
            'dni'        => 'required|max_length[15]',
            'grado_id'   => 'required|is_natural_no_zero',
            'seccion_id' => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            $data['alumna'] = $this->alumnasModel->find($id);
            $data['header'] = view('partials/header');
            $data['footer'] = view('partials/footer');
            return view('alumnas/editar', $data);
        }

        $dataUpdate = [
            'nombre'     => $this->request->getPost('nombre'),
            'dni'        => $this->request->getPost('dni'),
            'grado_id'   => $this->request->getPost('grado_id'),
            'seccion_id' => $this->request->getPost('seccion_id'),
        ];

        if ($this->alumnasModel->update($id, $dataUpdate)) {
            return redirect()->to('/alumnas')->with('success', 'Alumna actualizada correctamente.');
        }

        return redirect()->to('/alumnas')->with('error', 'Error al actualizar la alumna.');
    }
}
