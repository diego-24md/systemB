<?php

namespace App\Models;

use CodeIgniter\Model;

class PrestamosModel extends Model
{
    protected $table      = 'prestamos';
    protected $primaryKey = 'idprestamo';
    protected $returnType = 'array';

    protected $allowedFields = [
        'idactivo',
        'idalumna',
        'entrega',
        'devolucion',
        'condicionentrega',
    ];

    protected $useTimestamps = false;
}
