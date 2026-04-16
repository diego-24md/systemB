<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAutores extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idautor' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'idrecurso' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'datoautor' => ['type' => 'VARCHAR', 'constraint' => 150],
        ]);

        $this->forge->addKey('idautor', true);
        $this->forge->addForeignKey('idrecurso', 'recursos', 'idrecurso', 'CASCADE', 'CASCADE');

        $this->forge->createTable('autores', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('autores');
    }
}