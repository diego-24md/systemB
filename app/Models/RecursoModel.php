<?php

namespace App\Models;

use CodeIgniter\Model;

class RecursoModel extends Model
{
    protected $table         = 'recursos';
    protected $primaryKey    = 'idrecurso';
    protected $allowedFields = [
        'idtiporecurso',
        'idsubcategoria',
        'titulo',
        'isbn',
        'anio',
        'portada',
        'numpaginas'
    ];
}