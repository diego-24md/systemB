<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nombre'     => 'Bibliotecario Raúl',
            'usuario' => 'bibliotecario',
            'password'   => password_hash('bibliotecario123', PASSWORD_DEFAULT),
            'rol'        => 'bibliotecario',
            'activo'     => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('usuarios')->insert($data);
    }
}
