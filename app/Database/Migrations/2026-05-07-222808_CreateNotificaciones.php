<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotificaciones extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true
            ],
            'tipo' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'mensaje' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'icono' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'fas fa-bell'
            ],
            'color' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'primary'
            ],
            'leida' => [
                'type'    => 'TINYINT',
                'default' => 0
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('notificaciones', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('notificaciones');
    }
}
