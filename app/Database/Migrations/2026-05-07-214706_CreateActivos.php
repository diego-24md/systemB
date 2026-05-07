<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateActivos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idactivo' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'titulo' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'autor' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true
            ],
            'idcategoria' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true
            ],
            'idtiporecurso' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true
            ],
            'cantidad_total' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 1
            ],
            'cantidad_disponible' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 1
            ],
            'estado' => [
                'type'       => 'ENUM',
                'constraint' => ['disponible', 'agotado'],
                'default'    => 'disponible'
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('idactivo', true);
        $this->forge->addForeignKey('idcategoria',    'categorias',   'idcategoria', 'SET NULL', 'SET NULL');
        $this->forge->addForeignKey('idtiporecurso',  'tiporecurso',  'idtiporecurso', 'SET NULL', 'SET NULL');

        $this->forge->createTable('activos', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('activos');
    }
}
