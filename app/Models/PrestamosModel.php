<?php

namespace App\Models;

use CodeIgniter\Model;

class PrestamosModel extends Model
{
    protected $table      = 'prestamos';
    protected $primaryKey = 'idprestamo';
    protected $allowedFields = [
        'idactivo',
        'idalumna',
        'entrega',
        'devolucion',
        'condicionentrega',
    ];

    public function getPrestamosConAlumna()
    {
        $db = \Config\Database::connect();

        return $db->table('prestamos p')
            ->select('p.idprestamo, p.idactivo, p.entrega, p.devolucion, p.condicionentrega, a.nombre, a.dni, ac.titulo')
            ->join('alumnas a', 'a.id = p.idalumna', 'left')
            ->join('activos ac', 'ac.idactivo = p.idactivo', 'left')
            ->orderBy('p.idprestamo', 'DESC')
            ->get()
            ->getResultArray();
    }
}
