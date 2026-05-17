<?php

namespace App\Controllers;

class Exportar extends BaseController
{
    protected $db;

    public function __construct()
    {
        date_default_timezone_set('America/Lima');

        $this->db = \Config\Database::connect();
    }

    // ====================== PDF HISTORIAL ======================
    public function historial()
    {
        $prestamos = $this->db->table('prestamos p')
            ->select('
                p.idprestamo,
                p.entrega,
                p.hora_entrega,
                p.hora_devolucion,
                p.minutos,
                p.condicionentrega,
                a.nombre,
                a.dni,
                g.nombre AS grado,
                s.nombre AS seccion,
                ac.titulo
            ')
            ->join('alumnas a',   'a.id = p.idalumna',       'left')
            ->join('grados g',    'g.id = a.grado_id',       'left')
            ->join('secciones s', 's.id = a.seccion_id',     'left')
            ->join('activos ac',  'ac.idactivo = p.idactivo', 'left')
            ->where('p.estado', 'devuelto')
            ->orderBy('p.idprestamo', 'DESC')
            ->get()
            ->getResultArray();

        return view('exportar/historial_pdf', [
            'prestamos' => $prestamos,
            'fecha'     => date('d/m/Y H:i'),
        ]);
    }

    // ====================== PDF CATÁLOGO ======================
    public function catalogo()
    {
        $libros = $this->db->table('recursos r')
            ->select('
                r.titulo,
                r.isbn,
                r.anio,
                r.numpaginas,
                c.categoria,
                tr.tipo,
                GROUP_CONCAT(DISTINCT a.nombre SEPARATOR ", ") AS autores,
                act.cantidad_total,
                act.cantidad_disponible
            ')
            ->join('recurso_autor ra', 'ra.idrecurso = r.idrecurso', 'left')
            ->join('autores a',        'a.idautor = ra.idautor',     'left')
            ->join('categorias c',     'c.idcategoria = r.idcategoria', 'left')
            ->join('tiporecurso tr',   'tr.idtiporecurso = r.idtiporecurso', 'left')
            ->join('activos act',      'act.titulo = r.titulo',      'left')
            ->groupBy('r.idrecurso')
            ->orderBy('r.titulo', 'ASC')
            ->get()
            ->getResultArray();

        return view('exportar/catalogo_pdf', [
            'libros' => $libros,
            'fecha'  => date('d/m/Y H:i'),
        ]);
    }
}
