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
        $this->db = \Config\Database::connect();
        helper(['form', 'text']);
    }

    // ====================== LISTAR ALUMNAS ======================
    public function index()
    {
        $grado_id   = $this->request->getGet('grado');
        $seccion_id = $this->request->getGet('seccion');
        $buscar     = $this->request->getGet('buscar');
        $turno      = $this->request->getGet('turno');

        if ($grado_id !== null && $grado_id !== '') {
            $this->alumnasModel->where('grado_id', (int)$grado_id);
        }

        if ($seccion_id !== null && $seccion_id !== '') {
            $this->alumnasModel->where('seccion_id', (int)$seccion_id);
        }

        if ($turno !== null && $turno !== '') {
            $this->alumnasModel->where('turno', $turno);
        }

        if ($buscar) {
            $this->alumnasModel->groupStart()
                ->like('nombre', $buscar)
                ->orLike('dni', $buscar)
                ->groupEnd();
        }

        $data['alumnas'] = $this->alumnasModel->findAll();
        $data['pager']   = null;

        // Conteo total
        $countModel = new \App\Models\AlumnasModel();
        if ($grado_id !== null && $grado_id !== '') {
            $countModel->where('grado_id', (int)$grado_id);
        }
        if ($seccion_id !== null && $seccion_id !== '') {
            $countModel->where('seccion_id', (int)$seccion_id);
        }
        if ($turno !== null && $turno !== '') {
            $countModel->where('turno', $turno);
        }
        if ($buscar) {
            $countModel->groupStart()
                ->like('nombre', $buscar)
                ->orLike('dni', $buscar)
                ->groupEnd();
        }
        $data['total'] = $countModel->countAllResults();

        $data['grados'] = $this->db->table('grados')
            ->select('id, nombre')
            ->orderBy('id', 'ASC')
            ->get()->getResultArray();

        $data['secciones'] = $this->db->table('secciones')
            ->select('id, nombre, grado_id')
            ->orderBy('grado_id', 'ASC')
            ->orderBy('nombre', 'ASC')
            ->get()->getResultArray();

        $data['grado']   = $grado_id;
        $data['seccion'] = $seccion_id;
        $data['turno']   = $turno;
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
                ->select('id, nombre')
                ->orderBy('id', 'ASC')
                ->get()
                ->getResultArray();

            $secciones = $this->db->table('secciones')
                ->select('id, nombre, grado_id')
                ->orderBy('grado_id', 'ASC')
                ->orderBy('nombre', 'ASC')
                ->get()
                ->getResultArray();

            $data = [
                'grados'    => $grados,
                'secciones' => $secciones,
                'header'    => view('partials/header'),
                'footer'    => view('partials/footer')
            ];

            return view('alumnas/importar', $data);
        } catch (\Exception $e) {
            log_message('error', 'Error al cargar importar: ' . $e->getMessage());
            return redirect()->to('/alumnas')
                ->with('error', 'Error al cargar el formulario. Verifique las tablas de grados y secciones.');
        }
    }

    // ====================== IMPORTAR EXCEL ======================
    public function guardar()
    {
        $archivo    = $this->request->getFile('archivo');
        $grado_id   = $this->request->getPost('grado');
        $seccion_id = $this->request->getPost('seccion');
        $turno      = $this->request->getPost('turno');

        if (!$archivo || !$archivo->isValid()) {
            return redirect()->back()->with('error', 'Debe seleccionar un archivo Excel válido.');
        }

        if (empty($grado_id) || empty($seccion_id)) {
            return redirect()->back()->with('error', 'Grado y Sección son obligatorios.');
        }

        if (empty($turno) || !in_array($turno, ['manana', 'tarde'])) {
            return redirect()->back()->with('error', 'Debe seleccionar un turno válido.');
        }

        $archivo->move(WRITEPATH . 'uploads');
        $ruta = WRITEPATH . 'uploads/' . $archivo->getName();

        try {
            $grado   = $this->db->table('grados')->where('id', $grado_id)->get()->getRowArray();
            $seccion = $this->db->table('secciones')->where('id', $seccion_id)->get()->getRowArray();

            if (!$grado || !$seccion) {
                if (file_exists($ruta)) unlink($ruta);
                return redirect()->back()->with('error', 'Grado o sección no válidos.');
            }

            $nombreHoja = trim($grado['nombre']) . ' ' . trim($seccion['nombre']);
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($ruta);
            $hoja = $spreadsheet->getSheetByName($nombreHoja);

            if (!$hoja) {
                foreach ($spreadsheet->getSheetNames() as $sheetName) {
                    if (
                        stripos($sheetName, $grado['nombre']) !== false &&
                        stripos($sheetName, $seccion['nombre']) !== false
                    ) {
                        $hoja = $spreadsheet->getSheetByName($sheetName);
                        break;
                    }
                }
            }

            if (!$hoja) {
                if (file_exists($ruta)) unlink($ruta);
                return redirect()->back()
                    ->with('error', "No se encontró la pestaña \"{$nombreHoja}\" en el archivo Excel.");
            }

            $filas = $hoja->toArray();

            // ====================== DETECTAR COLUMNAS POR NOMBRE ======================
            $colNombre = null;
            $colDni    = null;
            $filaEncabezado = null;

            foreach ($filas as $rowIndex => $fila) {
                foreach ($fila as $colIndex => $celda) {
                    $valor = strtoupper(trim((string)($celda ?? '')));

                    if ($colNombre === null && (
                        str_contains($valor, 'APELLIDOS Y NOMBRES') ||
                        str_contains($valor, 'APELLIDOS') ||
                        str_contains($valor, 'NOMBRES')
                    )) {
                        $colNombre = $colIndex;
                    }

                    if ($colDni === null && (
                        str_contains($valor, 'N° DOCUMENTO') ||
                        str_contains($valor, 'DOCUMENTO') ||
                        str_contains($valor, 'DNI')
                    )) {
                        $colDni = $colIndex;
                    }
                }

                if ($colNombre !== null && $colDni !== null) {
                    $filaEncabezado = $rowIndex;
                    break;
                }
            }

            if ($colNombre === null || $colDni === null) {
                if (file_exists($ruta)) unlink($ruta);
                return redirect()->back()
                    ->with('error', 'No se encontraron las columnas de Apellidos/Nombres y DNI en el archivo.');
            }
            // =========================================================================

            $insertados = 0;

            // Eliminar alumnas existentes del mismo grado, sección y turno
            $this->alumnasModel->where('grado_id', $grado_id)
                ->where('seccion_id', $seccion_id)
                ->where('turno', $turno)
                ->delete();

            foreach ($filas as $rowIndex => $fila) {
                if ($rowIndex <= $filaEncabezado) continue;

                $nombre     = trim((string)($fila[$colNombre] ?? ''));
                $posibleDni = trim((string)($fila[$colDni]    ?? ''));

                if (empty($nombre) || !preg_match('/^\d{8}$/', $posibleDni)) {
                    continue;
                }

                $dataInsert = [
                    'nombre'     => $nombre,
                    'dni'        => $posibleDni,
                    'grado_id'   => $grado_id,
                    'seccion_id' => $seccion_id,
                    'turno'      => $turno,
                ];

                if ($this->alumnasModel->save($dataInsert)) {
                    $insertados++;
                }
            }

            if (file_exists($ruta)) unlink($ruta);

            $turnoLabel = $turno === 'manana' ? 'Mañana' : 'Tarde';

            return redirect()->to('/alumnas')
                ->with('success', "Se importaron correctamente {$insertados} alumnas del turno {$turnoLabel} en {$grado['nombre']} {$seccion['nombre']}.");
        } catch (\Exception $e) {
            if (file_exists($ruta ?? '')) unlink($ruta);
            return redirect()->back()
                ->with('error', 'Error al procesar el archivo: ' . $e->getMessage());
        }
    }

    // ====================== ELIMINAR ======================
    public function eliminar($id)
    {
        $this->alumnasModel->delete($id);
        return redirect()->to('/alumnas')->with('success', 'Alumna eliminada correctamente.');
    }

    // ====================== EDITAR ======================
    public function editar($id)
    {
        $data['alumna'] = $this->alumnasModel->find($id);

        if (empty($data['alumna'])) {
            return redirect()->to('/alumnas')->with('error', 'Alumna no encontrada.');
        }

        $data['grados'] = $this->db->table('grados')
            ->select('id, nombre')
            ->orderBy('id', 'ASC')
            ->get()->getResultArray();

        $data['secciones'] = $this->db->table('secciones')
            ->select('id, nombre, grado_id')
            ->orderBy('grado_id', 'ASC')
            ->orderBy('nombre', 'ASC')
            ->get()->getResultArray();

        $data['header'] = view('partials/header');
        $data['footer'] = view('partials/footer');

        return view('alumnas/editar', $data);
    }

    // ====================== ACTUALIZAR ======================
    public function actualizar($id)
    {
        $rules = [
            'nombre'     => 'required|min_length[2]|max_length[150]',
            'dni'        => "required|max_length[15]|is_unique[alumnas.dni,id,{$id}]",
            'grado_id'   => 'required|is_natural_no_zero',
            'seccion_id' => 'required|is_natural_no_zero',
            'turno'      => 'required|in_list[manana,tarde]',
        ];

        if (!$this->validate($rules)) {
            $data['alumna']     = $this->alumnasModel->find($id);
            $data['grados']     = $this->db->table('grados')->select('id, nombre')->orderBy('id', 'ASC')->get()->getResultArray();
            $data['secciones']  = $this->db->table('secciones')->select('id, nombre, grado_id')->orderBy('grado_id', 'ASC')->orderBy('nombre', 'ASC')->get()->getResultArray();
            $data['validation'] = $this->validator;
            $data['header']     = view('partials/header');
            $data['footer']     = view('partials/footer');
            return view('alumnas/editar', $data);
        }

        $dataUpdate = [
            'nombre'     => $this->request->getPost('nombre'),
            'dni'        => $this->request->getPost('dni'),
            'grado_id'   => $this->request->getPost('grado_id'),
            'seccion_id' => $this->request->getPost('seccion_id'),
            'turno'      => $this->request->getPost('turno'),
        ];

        $this->alumnasModel->skipValidation(true)->update($id, $dataUpdate);

        // Notificación
        $db = \Config\Database::connect();
        $alumna = $this->alumnasModel->find($id);
        $db->table('notificaciones')->insert([
            'mensaje'    => 'Alumna actualizada: ' . $alumna['nombre'],
            'tipo'       => 'alumna',
            'leida'      => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/alumnas');
    }
}
