<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearGradosYSecciones extends Migration
{
    public function up()
    {
        // TABLA GRADOS
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'nombre' => [
                'type' => 'VARCHAR',
                'constraint' => 10
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('grados');

        // TABLA SECCIONES
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'nombre' => [
                'type' => 'VARCHAR',
                'constraint' => 5
            ],
            'grado_id' => [
                'type' => 'INT'
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('grado_id', 'grados', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('secciones');
    }

    public function down()
    {
        $this->forge->dropTable('secciones');
        $this->forge->dropTable('grados');
    }
}