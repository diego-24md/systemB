<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nombrerol' => 'Administrador'],
            ['nombrerol' => 'Bibliotecario'],
            ['nombrerol' => 'Alumno'],
        ];

        $this->db->table('roles')->insertBatch($data);
    }
}