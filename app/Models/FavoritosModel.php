<?php

namespace App\Models;

use CodeIgniter\Model;

class FavoritosModel extends Model
{
    protected $table      = 'favoritos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['alumna_id', 'idrecurso', 'created_at'];

    /**
     * Agrega un libro a favoritos.
     * Si ya existe, no hace nada (INSERT IGNORE).
     */
    public function agregar(int $alumnaId, int $idrecurso): void
    {
        $this->db->query(
            'INSERT IGNORE INTO favoritos (alumna_id, idrecurso, created_at) VALUES (?, ?, NOW())',
            [$alumnaId, $idrecurso]
        );
    }

    /**
     * Quita un libro de favoritos.
     */
    public function quitar(int $alumnaId, int $idrecurso): void
    {
        $this->where('alumna_id', $alumnaId)
            ->where('idrecurso', $idrecurso)
            ->delete();
    }

    /**
     * Devuelve todos los idrecurso favoritos de una alumna.
     */
    public function idsFavoritos(int $alumnaId): array
    {
        return $this->select('idrecurso')
            ->where('alumna_id', $alumnaId)
            ->findAll();
    }

    /**
     * Devuelve los libros completos de una alumna (JOIN con recursos).
     * Ajusta el nombre de la tabla y columnas según tu BD.
     */
    public function librosFavoritos(int $alumnaId): array
    {
        return $this->db->table('favoritos f')
            ->select('r.*')
            ->join('recursos r', 'r.idrecurso = f.idrecurso')
            ->where('f.alumna_id', $alumnaId)
            ->orderBy('f.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }
}
