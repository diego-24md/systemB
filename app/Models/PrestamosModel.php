<?php

namespace App\Models;

use CodeIgniter\Model;

class PrestamosModel extends Model
{
    protected $table = 'prestamos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'alumna_id',
        'libro_id',
        'fecha_prestamo',
        'fecha_devolucion',
        'estado'
    ];
}