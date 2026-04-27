<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRecursos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idrecurso' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'idtiporecurso' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'idcategoria' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'titulo' => [
                'type' => 'VARCHAR',
                'constraint' => 200
            ],
            'descripcion' => [
                'type' => 'TEXT',
                'null' => true,
                'default' => null
            ],
            'isbn' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'anio' => [
                'type' => 'YEAR'
            ],
            'portada' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'numpaginas' => [
                'type' => 'INT',
                'constraint' => 11
            ],
        ]);

        $this->forge->addKey('idrecurso', true);

        $this->forge->addForeignKey(
            'idtiporecurso',
            'tiporecurso',
            'idtiporecurso',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'idcategoria',
            'categorias',
            'idcategoria',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('recursos', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('recursos');
    }
}
