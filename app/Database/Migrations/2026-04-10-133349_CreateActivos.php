<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateActivos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idactivo' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'idrecurso' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'condicion' => ['type' => 'VARCHAR', 'constraint' => 50],
        ]);

        $this->forge->addKey('idactivo', true);
        $this->forge->addForeignKey('idrecurso', 'recursos', 'idrecurso', 'CASCADE', 'CASCADE');

        $this->forge->createTable('activos', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('activos');
    }
}