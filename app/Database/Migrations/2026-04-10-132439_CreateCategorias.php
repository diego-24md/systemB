<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategorias extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idcategoria' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'idtiporecurso' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'categoria' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ]
        ]);

        $this->forge->addKey('idcategoria', true);
        $this->forge->addForeignKey('idtiporecurso', 'tiporecurso', 'idtiporecurso', 'SET NULL', 'CASCADE');
        $this->forge->createTable('categorias', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('categorias');
    }
}
