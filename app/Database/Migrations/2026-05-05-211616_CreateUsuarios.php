<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsuarios extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'nombre'     => ['type' => 'VARCHAR', 'constraint' => 150],
            'usuario'    => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'password'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'rol'        => ['type' => 'ENUM', 'constraint' => ['bibliotecario', 'alumna']],
            'activo'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('usuarios');
    }

    public function down()
    {
        $this->forge->dropTable('usuarios');
    }
}
