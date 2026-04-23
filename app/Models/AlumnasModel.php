<?php

namespace App\Models;

use CodeIgniter\Model;

class AlumnasModel extends Model
{
    protected $table = 'alumnas';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'dni',
        'nombre',
        'grado_id',
        'seccion_id'
    ];

    protected $returnType = 'array';

    // 🔥 MÉTODO PRO (JOIN COMPLETO)
    public function getAlumnasConDetalle($grado_id, $seccion_id)
    {
        return $this->select('alumnas.*, grados.nombre as grado, secciones.nombre as seccion')
            ->join('grados', 'grados.id = alumnas.grado_id')
            ->join('secciones', 'secciones.id = alumnas.seccion_id')
            ->where('alumnas.grado_id', $grado_id)
            ->where('alumnas.seccion_id', $seccion_id)
            ->findAll();
    }
}
