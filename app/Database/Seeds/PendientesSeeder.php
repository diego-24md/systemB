<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PendientesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'idalumna'         => 49,
                'idactivo'         => 1,
                'entrega'          => date('Y-m-d'),
                'hora_entrega'     => '08:30:00',
                'condicionentrega' => 'bueno',
                'estado'           => 'pendiente',
            ],
            [
                'idalumna'         => 50,
                'idactivo'         => 2,
                'entrega'          => date('Y-m-d'),
                'hora_entrega'     => '09:15:00',
                'condicionentrega' => 'bueno',
                'estado'           => 'pendiente',
            ],
            [
                'idalumna'         => 51,
                'idactivo'         => 3,
                'entrega'          => date('Y-m-d'),
                'hora_entrega'     => '13:45:00',
                'condicionentrega' => 'bueno',
                'estado'           => 'pendiente',
            ],
            [
                'idalumna'         => 52,
                'idactivo'         => 4,
                'entrega'          => date('Y-m-d'),
                'hora_entrega'     => '14:20:00',
                'condicionentrega' => 'bueno',
                'estado'           => 'pendiente',
            ],
        ];

        $this->db->table('prestamos')->insertBatch($data);
    }
}
