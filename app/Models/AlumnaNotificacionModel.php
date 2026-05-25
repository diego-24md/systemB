<?php

namespace App\Models;

use CodeIgniter\Model;

class AlumnaNotificacionModel extends Model
{
    protected $table         = 'alumna_notificaciones';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['alumna_id', 'mensaje', 'tipo', 'leido'];
    protected $useTimestamps = true;
    protected $updatedField  = ''; // solo created_at, no updated_at
    protected $createdField  = 'created_at';

    // Obtener todas las notificaciones de una alumna
    public function getDeAlumna(int $alumnaId): array
    {
        return $this->where('alumna_id', $alumnaId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    // Contar notificaciones sin leer de una alumna
    public function contarSinLeer(int $alumnaId): int
    {
        return $this->where('alumna_id', $alumnaId)
            ->where('leido', 0)
            ->countAllResults();
    }

    // Marcar todas como leídas
    public function marcarTodasLeidas(int $alumnaId): void
    {
        $this->where('alumna_id', $alumnaId)
            ->where('leido', 0)
            ->set(['leido' => 1])
            ->update();
    }

    // Crear una notificación para una alumna
    public function notificar(int $alumnaId, string $mensaje, string $tipo): void
    {
        $this->insert([
            'alumna_id' => $alumnaId,
            'mensaje'   => $mensaje,
            'tipo'      => $tipo,
        ]);
    }
}
