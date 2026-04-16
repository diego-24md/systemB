<?php

namespace App\Controllers;

use App\Models\RecursoModel;

class RecursosController extends BaseController
{
    public function buscar()
    {
        $query = trim($this->request->getGet('q'));

        if ($query === '') {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Escribe algo para buscar',
                'data' => []
            ]);
        }

        $model = new RecursoModel();

        $resultados = $model
            ->groupStart()
            ->like('titulo', $query)
            ->orLike('isbn', $query)
            ->orLike('anio', $query)
            ->groupEnd()
            ->orderBy('titulo', 'ASC')
            ->findAll();

        return $this->response->setJSON([
            'status' => true,
            'query' => $query,
            'count' => count($resultados),
            'data' => $resultados
        ]);
    }
}