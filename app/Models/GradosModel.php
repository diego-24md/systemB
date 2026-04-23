<?php

namespace App\Models;

use CodeIgniter\Model;

class GradosModel extends Model
{
    protected $table = 'grados';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nombre'];

    protected $returnType = 'array';
}
