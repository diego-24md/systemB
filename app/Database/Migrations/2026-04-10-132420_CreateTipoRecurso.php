<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTipoRecurso extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idtiporecurso' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'tipo' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ]
        ]);

        $this->forge->addKey('idtiporecurso', true);
        $this->forge->createTable('tiporecurso', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('tiporecurso');
    }
}