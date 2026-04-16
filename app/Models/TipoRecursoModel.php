<?php

namespace App\Models;

use CodeIgniter\Model;

class TipoRecursoModel extends Model
{
    protected $table            = 'tiporecurso';
    protected $primaryKey       = 'idtiporecurso';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'tipo', 
        'descripcion'
        // Agrega aquí otros campos que tenga tu tabla tiporecurso
    ];

    protected $useTimestamps = false;   // Cambia a true si tienes created_at / updated_at

    // Opcional: para ordenar por defecto
    protected $orderBy = 'tipo ASC';
}