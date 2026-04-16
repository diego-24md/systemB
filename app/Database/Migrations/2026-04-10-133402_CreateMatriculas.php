<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMatriculas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idmatricula' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'idpersona' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'idgrupo' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'periodo' => ['type' => 'YEAR', 'null' => true],
            'estado' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);

        $this->forge->addKey('idmatricula', true);
        $this->forge->addForeignKey('idpersona', 'personas', 'idpersona', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('idgrupo', 'grupos', 'idgrupo', 'CASCADE', 'CASCADE');

        $this->forge->createTable('matriculas', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('matriculas');
    }
}