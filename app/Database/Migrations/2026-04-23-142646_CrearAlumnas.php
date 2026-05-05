<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearAlumnas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'nombre'     => ['type' => 'VARCHAR', 'constraint' => 150],
            'dni'        => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'grado_id'   => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'seccion_id' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('grado_id',   'grados',    'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('seccion_id',  'secciones', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('alumnas');
    }

    public function down()
    {
        $this->forge->dropTable('alumnas');
    }
}
