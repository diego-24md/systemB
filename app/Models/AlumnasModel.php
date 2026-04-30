<?php

namespace App\Models;

use CodeIgniter\Model;

class AlumnasModel extends Model  // ← corregido
{
    protected $table = 'alumnas';  // ← corregido (o déjalo 'alumnasp' si tu tabla en BD se llama así)
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'nombres',
        'apellidos',
        'dni',
        'grado',
        'seccion'
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'nombres' => 'required|min_length[2]|max_length[100]',
        'apellidos' => 'required|min_length[2]|max_length[100]',
        'dni' => 'required|exact_length[8]|is_unique[alumnas.dni,id,{id}]',  // ← corregido
        'grado' => 'required',
        'seccion' => 'required|max_length[10]'
    ];

    protected $validationMessages = [
        'nombres' => [
            'required' => 'El campo nombres es obligatorio',
            'min_length' => 'El nombre debe tener al menos 2 caracteres',
        ],
        'apellidos' => [
            'required' => 'El campo apellidos es obligatorio',
        ],
        'dni' => [
            'required' => 'El DNI es obligatorio',
            'exact_length' => 'El DNI debe tener exactamente 8 dígitos',
            'is_unique' => 'Este DNI ya está registrado',
        ],
    ];

    protected $skipValidation = false;

    // ====================== MÉTODOS PERSONALIZADOS ======================

    public function getByGradoSeccion(string $grado, string $seccion)
    {
        return $this->where('grado', $grado)
            ->where('seccion', $seccion)
            ->findAll();
    }

    public function deleteByGradoSeccion(string $grado, string $seccion): bool
    {
        return $this->where('grado', $grado)
            ->where('seccion', $seccion)
            ->delete();
    }

    public function findByDni(string $dni)
    {
        return $this->where('dni', $dni)->first();
    }

    public function countByGradoSeccion(string $grado, string $seccion): int
    {
        return $this->where('grado', $grado)
            ->where('seccion', $seccion)
            ->countAllResults();
    }
}