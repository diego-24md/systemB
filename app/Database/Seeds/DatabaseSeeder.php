<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('TipoRecursoSeeder');
        $this->call('CategoriasSeeder');
        $this->call('RolesSeeder');
        $this->call('GruposSeeder');
    }
}