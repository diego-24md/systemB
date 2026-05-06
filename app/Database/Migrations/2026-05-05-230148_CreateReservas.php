<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReservas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'alumna_id'   => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'recurso_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => false],
            'estado'      => ['type' => 'ENUM', 'constraint' => ['pendiente', 'aceptada', 'rechazada', 'cancelada'], 'default' => 'pendiente'],
            'fecha_reserva'      => ['type' => 'DATETIME', 'null' => false],
            'fecha_respuesta'    => ['type' => 'DATETIME', 'null' => true],
            'nota_alumna'        => ['type' => 'TEXT', 'null' => true],
            'nota_bibliotecario' => ['type' => 'TEXT', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('alumna_id',  'alumnas',  'id',         'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('recurso_id', 'recursos', 'idrecurso',  'CASCADE', 'CASCADE');

        $this->forge->createTable('reservas');
    }

    public function down()
    {
        $this->forge->dropTable('reservas');
    }
}
