<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFavoritos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'alumna_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'idrecurso' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        // Clave única: una alumna no puede agregar el mismo libro dos veces
        $this->forge->addUniqueKey(['alumna_id', 'idrecurso']);

        $this->forge->createTable('favoritos');
    }

    public function down()
    {
        $this->forge->dropTable('favoritos');
    }
}
