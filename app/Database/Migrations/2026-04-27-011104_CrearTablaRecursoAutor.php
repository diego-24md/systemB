<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaRecursoAutor extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idrecurso' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'idautor' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);

        // 🔑 Clave primaria compuesta
        $this->forge->addKey(['idrecurso', 'idautor'], true);

        // 🔥 Índices (mejora rendimiento)
        $this->forge->addKey('idrecurso');
        $this->forge->addKey('idautor');

        // 🔗 Foreign Keys
        $this->forge->addForeignKey('idrecurso', 'recursos', 'idrecurso', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('idautor', 'autores', 'idautor', 'CASCADE', 'CASCADE');

        $this->forge->createTable('recurso_autor');
    }

    public function down()
    {
        $this->forge->dropTable('recurso_autor');
    }
}
