<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PendientesSeeder extends Seeder
{
    public function run()
    {
        // Alumnas de turno mañana (grados 1° a 3°)
        $manana = $this->db->table('alumnas')
            ->where('turno', 'manana')
            ->get(2)->getResultArray();

        // Alumnas de turno tarde (grados 4° y 5°)
        $tarde = $this->db->table('alumnas')
            ->where('turno', 'tarde')
            ->get(2)->getResultArray();

        if (count($manana) < 2 || count($tarde) < 2) {
            throw new \RuntimeException(
                'PendientesSeeder: no hay suficientes alumnas sembradas. ' .
                    'Corre primero AlumnasSeeder.'
            );
        }

        $data = [
            // --- Turno mañana ---
            [
                'idalumna'         => $manana[0]['id'],
                'idactivo'         => 1,
                'entrega'          => date('Y-m-d'),
                'hora_entrega'     => '08:30:00',
                'condicionentrega' => 'bueno',
                'estado'           => 'pendiente',
            ],
            [
                'idalumna'         => $manana[1]['id'],
                'idactivo'         => 2,
                'entrega'          => date('Y-m-d'),
                'hora_entrega'     => '09:15:00',
                'condicionentrega' => 'bueno',
                'estado'           => 'pendiente',
            ],
            // --- Turno tarde ---
            [
                'idalumna'         => $tarde[0]['id'],
                'idactivo'         => 3,
                'entrega'          => date('Y-m-d'),
                'hora_entrega'     => '13:45:00',
                'condicionentrega' => 'bueno',
                'estado'           => 'pendiente',
            ],
            [
                'idalumna'         => $tarde[1]['id'],
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
