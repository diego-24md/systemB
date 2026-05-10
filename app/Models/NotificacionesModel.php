<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificacionesModel extends Model
{
    protected $table      = 'notificaciones';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tipo',
        'mensaje',
        'icono',
        'color',
        'leida',
        'created_at',
    ];
    protected $useTimestamps = true;
    protected $updatedField  = '';
    protected $dateFormat    = 'datetime';

    public function getNoLeidas()
    {
        return $this->where('leida', 0)
            ->orderBy('created_at', 'DESC')
            ->limit(10)
            ->findAll();
    }

    public function contarNoLeidas()
    {
        return $this->where('leida', 0)->countAllResults();
    }

    public static function registrar(string $tipo, string $mensaje, string $icono = 'fas fa-bell', string $color = 'primary')
    {
        $lima = new \DateTimeZone('America/Lima');
        $now  = new \DateTime('now', $lima);

        $model = new self();
        $model->insert([
            'tipo'       => $tipo,
            'mensaje'    => $mensaje,
            'icono'      => $icono,
            'color'      => $color,
            'leida'      => 0,
            'created_at' => $now->format('Y-m-d H:i:s'),
        ]);
    }
}
