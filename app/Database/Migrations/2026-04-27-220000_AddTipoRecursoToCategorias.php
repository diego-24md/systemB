<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTipoRecursoToCategorias extends Migration
{
    public function up()
    {
        $this->forge->addColumn('categorias', [
            'idtiporecurso' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'idcategoria'
            ]
        ]);

        $this->forge->addForeignKey('idtiporecurso', 'tiporecurso', 'idtiporecurso', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropColumn('categorias', 'idtiporecurso');
    }
}
