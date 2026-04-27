<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearAlumnas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'dni' => [
                'type' => 'VARCHAR',
                'constraint' => 15
            ],
            'nombre' => [
                'type' => 'VARCHAR',
                'constraint' => 150
            ],
            'clave' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'default'    => ''
            ],
            'grado_id' => [
                'type' => 'INT'
            ],
            'seccion_id' => [
                'type' => 'INT'
            ]
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('grado_id', 'grados', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('seccion_id', 'secciones', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('alumnas');
    }

    public function down()
    {
        $this->forge->dropTable('alumnas');
    }
}
