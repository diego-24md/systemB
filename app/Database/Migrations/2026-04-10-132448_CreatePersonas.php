<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePersonas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idpersona' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'apellidos' => ['type' => 'VARCHAR', 'constraint' => 100],
            'nombres' => ['type' => 'VARCHAR', 'constraint' => 100],
            'tipodoc' => ['type' => 'VARCHAR', 'constraint' => 20],
            'numdoc' => ['type' => 'VARCHAR', 'constraint' => 20],
            'telefono' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
        ]);

        $this->forge->addKey('idpersona', true);
        $this->forge->createTable('personas', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('personas');
    }
}