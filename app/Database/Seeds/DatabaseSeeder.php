<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('TipoRecursoSeeder');
        $this->call('CategoriasSeeder');
        $this->call('GradosSeeder');
        $this->call('UsuarioSeeder');
        $this->call('LibrosSeeder');
        $this->call('AlumnasSeeder');
        $this->call('PrestamosSeeder');
        $this->call('PendientesSeeder');
    }
}