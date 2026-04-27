<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePrestamos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idprestamo' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'idactivo' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true
            ],
            'idalumna' => [
                'type'       => 'INT',
                'constraint' => 11
            ],
            'entrega' => [
                'type' => 'DATE'
            ],
            'devolucion' => [
                'type' => 'DATE',
                'null' => true
            ],
            'condicionentrega' => [
                'type'       => 'VARCHAR',
                'constraint' => 50
            ],
        ]);

        $this->forge->addKey('idprestamo', true);
        $this->forge->addForeignKey('idactivo', 'activos', 'idactivo', 'CASCADE', 'CASCADE');

        $this->forge->createTable('prestamos', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('prestamos');
    }
}
