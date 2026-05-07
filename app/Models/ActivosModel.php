<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivosModel extends Model
{
    protected $table      = 'activos';
    protected $primaryKey = 'idactivo';
    protected $allowedFields = [
        'titulo',
        'autor',
        'idcategoria',
        'idtiporecurso',
        'cantidad_total',
        'cantidad_disponible',
        'estado',
    ];
    protected $useTimestamps = true;

    public function getActivosConCategoria()
    {
        $db = \Config\Database::connect();

        return $db->table('activos a')
            ->select('a.idactivo, a.titulo, a.autor, a.cantidad_total, a.cantidad_disponible, a.estado, c.categoria, t.tipo')
            ->join('categorias c', 'c.idcategoria = a.idcategoria', 'left')
            ->join('tiporecurso t', 't.idtiporecurso = a.idtiporecurso', 'left')
            ->orderBy('a.titulo', 'ASC')
            ->get()
            ->getResultArray();
    }
}
