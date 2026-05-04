<?php

namespace App\Models;

use CodeIgniter\Model;

class AlumnasModel extends Model
{
    protected $table      = 'alumnas';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'nombre',
        'dni',
        'clave',
        'grado_id',
        'seccion_id'
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'nombre'     => 'required|min_length[2]|max_length[150]',
        'dni'        => 'required|max_length[15]|is_unique[alumnas.dni,id,{id}]',
        'grado_id'   => 'required|is_natural_no_zero',
        'seccion_id' => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El campo nombre es obligatorio',
            'min_length' => 'El nombre debe tener al menos 2 caracteres',
        ],
        'dni' => [
            'required'   => 'El DNI es obligatorio',
            'max_length' => 'El DNI no debe superar 15 caracteres',
            'is_unique'  => 'Este DNI ya está registrado',
        ],
        'grado_id' => [
            'required' => 'El grado es obligatorio',
        ],
        'seccion_id' => [
            'required' => 'La sección es obligatoria',
        ],
    ];

    protected $skipValidation = false;

    // ====================== MÉTODOS PERSONALIZADOS ======================

    public function getByGradoSeccion(int $grado_id, int $seccion_id)
    {
        return $this->where('grado_id', $grado_id)
            ->where('seccion_id', $seccion_id)
            ->findAll();
    }

    public function deleteByGradoSeccion(int $grado_id, int $seccion_id): bool
    {
        return $this->where('grado_id', $grado_id)
            ->where('seccion_id', $seccion_id)
            ->delete();
    }

    public function findByDni(string $dni)
    {
        return $this->where('dni', $dni)->first();
    }

    public function countByGradoSeccion(int $grado_id, int $seccion_id): int
    {
        return $this->where('grado_id', $grado_id)
            ->where('seccion_id', $seccion_id)
            ->countAllResults();
    }
}
