<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsuarios extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idusuario' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'idpersona' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nomusuario' => ['type' => 'VARCHAR', 'constraint' => 50],
            'claveacceso' => ['type' => 'VARCHAR', 'constraint' => 255],
            'idrol' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);

        $this->forge->addKey('idusuario', true);
        $this->forge->addForeignKey('idpersona', 'personas', 'idpersona', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('idrol', 'roles', 'idrol', 'CASCADE', 'CASCADE');

        $this->forge->createTable('usuarios', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('usuarios');
    }
}