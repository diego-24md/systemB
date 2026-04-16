<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGrupos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idgrupo' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'grado' => ['type' => 'VARCHAR', 'constraint' => 20],
            'seccion' => ['type' => 'VARCHAR', 'constraint' => 20],
        ]);

        $this->forge->addKey('idgrupo', true);
        $this->forge->createTable('grupos', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('grupos');
    }
}