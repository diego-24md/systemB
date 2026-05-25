<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAlumnaNotificacionesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'alumna_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'mensaje' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'tipo' => [
                'type'       => 'ENUM',
                'constraint' => ['aceptado', 'rechazado'],
            ],
            'leido' => [
                'type'    => 'TINYINT',
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('alumna_id');
        $this->forge->createTable('alumna_notificaciones');
    }

    public function down()
    {
        $this->forge->dropTable('alumna_notificaciones');
    }
}
