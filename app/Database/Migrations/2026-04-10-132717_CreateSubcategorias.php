<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubcategorias extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idsubcategoria' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'idcategoria' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'subcategoria' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);

        $this->forge->addKey('idsubcategoria', true);
        $this->forge->addForeignKey('idcategoria', 'categorias', 'idcategoria', 'CASCADE', 'CASCADE');
        $this->forge->createTable('subcategorias', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('subcategorias');
    }
}