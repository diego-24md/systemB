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
        'hora_entrega',
        'hora_devolucion',
        'minutos',
        'estado',
    ];

    public function getPrestamosConAlumna()
    {
        $db = \Config\Database::connect();

        return $db->table('prestamos p')
            ->select('p.idprestamo, p.idactivo, p.entrega, p.devolucion, p.condicionentrega, p.hora_entrega, p.hora_devolucion, p.minutos, p.estado, a.nombre, a.dni, ac.titulo')
            ->join('alumnas a', 'a.id = p.idalumna', 'left')
            ->join('activos ac', 'ac.idactivo = p.idactivo', 'left')
            ->orderBy('p.idprestamo', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getPrestamosActivos()
    {
        $db = \Config\Database::connect();

        return $db->table('prestamos p')
            ->select('p.idprestamo, p.idactivo, p.entrega, p.hora_entrega, p.condicionentrega, a.nombre, a.dni, ac.titulo, ac.foto')
            ->join('alumnas a', 'a.id = p.idalumna', 'left')
            ->join('activos ac', 'ac.idactivo = p.idactivo', 'left')
            ->where('p.estado', 'activo')
            ->orderBy('p.idprestamo', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getHistorial()
    {
        $db = \Config\Database::connect();

        return $db->table('prestamos p')
            ->select('p.idprestamo, p.entrega, p.hora_entrega, p.devolucion, p.hora_devolucion, p.minutos, p.condicionentrega, a.nombre, a.dni, a.grado, a.seccion, ac.titulo')
            ->join('alumnas a', 'a.id = p.idalumna', 'left')
            ->join('activos ac', 'ac.idactivo = p.idactivo', 'left')
            ->where('p.estado', 'devuelto')
            ->orderBy('p.idprestamo', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getRankingAulas()
    {
        $db = \Config\Database::connect();

        return $db->table('prestamos p')
            ->select('a.grado, a.seccion, SUM(p.minutos) AS total_minutos, COUNT(p.idprestamo) AS total_prestamos')
            ->join('alumnas a', 'a.id = p.idalumna', 'left')
            ->where('p.estado', 'devuelto')
            ->groupBy('a.grado, a.seccion')
            ->orderBy('total_minutos', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getRankingAlumnas()
    {
        $db = \Config\Database::connect();

        return $db->table('prestamos p')
            ->select('a.nombre, a.dni, a.grado, a.seccion, SUM(p.minutos) AS total_minutos, COUNT(p.idprestamo) AS total_prestamos')
            ->join('alumnas a', 'a.id = p.idalumna', 'left')
            ->where('p.estado', 'devuelto')
            ->groupBy('a.id')
            ->orderBy('total_minutos', 'DESC')
            ->get()
            ->getResultArray();
    }
}
