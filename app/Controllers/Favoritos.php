<?php

namespace App\Controllers;

use App\Models\FavoritosModel;
use CodeIgniter\Controller;

class Favoritos extends Controller
{
    /**
     * POST /favoritos/toggle
     * Body JSON: { "idrecurso": 123 }
     * Responde JSON: { "favorito": true/false }
     */
    public function toggle()
    {
        // Solo alumnas logueadas
        $alumnaId = session()->get('alumna_id');
        if (! $alumnaId) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON(['error' => 'No autorizado']);
        }

        $idrecurso = (int) $this->request->getJSON(true)['idrecurso'] ?? 0;
        if ($idrecurso <= 0) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON(['error' => 'ID de recurso inválido']);
        }

        $model = new FavoritosModel();

        // Verificar si ya es favorito
        $existe = $model->where('alumna_id', $alumnaId)
            ->where('idrecurso', $idrecurso)
            ->first();

        if ($existe) {
            $model->quitar($alumnaId, $idrecurso);
            return $this->response->setJSON(['favorito' => false]);
        } else {
            $model->agregar($alumnaId, $idrecurso);
            return $this->response->setJSON(['favorito' => true]);
        }
    }

    /**
     * GET /favoritos/ids
     * Devuelve los IDs favoritos de la alumna logueada (para marcar corazones).
     */
    public function ids()
    {
        $alumnaId = session()->get('alumna_id');
        if (! $alumnaId) {
            return $this->response->setStatusCode(401)->setJSON([]);
        }

        $model = new FavoritosModel();
        $rows  = $model->idsFavoritos($alumnaId);
        $ids   = array_column($rows, 'idrecurso');

        return $this->response->setJSON($ids);
    }
}
