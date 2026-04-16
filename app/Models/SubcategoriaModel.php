<?php

namespace App\Models;

use CodeIgniter\Model;

class SubcategoriaModel extends Model
{
    protected $table            = 'subcategorias';
    protected $primaryKey       = 'idsubcategoria';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $allowedFields    = ['idsubcategoria', 'subcategoria', 'idcategoria'];
}