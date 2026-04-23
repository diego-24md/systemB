<?php

namespace App\Models;

use CodeIgniter\Model;

class SeccionesModel extends Model
{
    protected $table = 'secciones';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nombre', 'grado_id'];

    protected $returnType = 'array';
}
