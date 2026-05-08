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
                'auto_increment' => true,
            ],
            'idactivo' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'idalumna' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'entrega' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'devolucion' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'condicionentrega' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('idprestamo');

        // Foreign keys comentadas temporalmente
        // $this->forge->addForeignKey('idactivo', 'activos', 'idactivo', 'CASCADE', 'CASCADE');
        // $this->forge->addForeignKey('idalumna', 'alumnas', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('prestamos', true, [
            'ENGINE'        => 'InnoDB',
            'CHARACTER SET' => 'utf8mb4',
            'COLLATE'       => 'utf8mb4_general_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('prestamos', true);
    }
}
