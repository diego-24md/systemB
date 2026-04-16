<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRoles extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idrol' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'nombrerol' => ['type' => 'VARCHAR', 'constraint' => 50],
        ]);

        $this->forge->addKey('idrol', true);
        $this->forge->createTable('roles', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('roles');
    }
}