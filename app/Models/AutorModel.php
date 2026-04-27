<?php

namespace App\Models;

use CodeIgniter\Model;

class AutorModel extends Model
{
    protected $table = 'autores';
    protected $primaryKey = 'idautor';
    protected $returnType = 'array';
    protected $allowedFields = ['nombre'];
}