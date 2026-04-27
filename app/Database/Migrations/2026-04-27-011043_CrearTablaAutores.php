<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaAutores extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idautor' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
        ]);

        $this->forge->addKey('idautor', true);
        $this->forge->addUniqueKey('nombre'); // 🔥 mejora

        $this->forge->createTable('autores');
    }

    public function down()
    {
        $this->forge->dropTable('autores');
    }
}
