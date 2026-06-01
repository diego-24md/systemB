<?php

namespace App\Controllers;

use App\Models\LibrosModel;

class Home extends BaseController
{
    public function dashboard(): string
    {
        $librosModel = new LibrosModel();
        $db = \Config\Database::connect();

        // Total libros
        $totalLibros = $librosModel->countAll();

        // Libros prestados (activos)
        $prestados = $db->table('prestamos')
            ->where('estado', 'activo')
            ->countAllResults();

        // Disponibles
        $disponibles = $db->table('activos a')
            ->selectSum('a.cantidad_disponible')
            ->join('recursos r', 'r.titulo = a.titulo', 'inner')
            ->get()
            ->getRow()
            ->cantidad_disponible ?? 0;

        // Alumnas
        $usuarios = $db->table('alumnas')->countAllResults();

        // Reservas pendientes ← NUEVO
        $pendientes = $db->table('prestamos')
            ->where('estado', 'pendiente')
            ->countAllResults();

        return view('dashboard', [
            'header'      => view('Partials/header'),
            'footer'      => view('Partials/footer'),
            'totalLibros' => $totalLibros,
            'prestados'   => $prestados,
            'disponibles' => $disponibles,
            'usuarios'    => $usuarios,
            'pendientes'  => $pendientes, // ← NUEVO
        ]);
    }

    // ====================== AJAX: DATOS GRÁFICO ======================
    public function chartData(): \CodeIgniter\HTTP\ResponseInterface
    {
        $db   = \Config\Database::connect();
        $lima = new \DateTimeZone('America/Lima');
        $now  = new \DateTime('now', $lima);
        $modo = $this->request->getGet('modo') ?? 'dias';

        $labels = [];
        $datos  = [];

        switch ($modo) {

            // ── POR HORAS ──────────────────────────────────────────
            case 'horas':
                $fecha = $this->request->getGet('fecha') ?? $now->format('Y-m-d');
                for ($h = 6; $h <= 20; $h++) {
                    $count = $db->table('prestamos')
                        ->where('entrega', $fecha)
                        ->whereIn('estado', ['activo', 'devuelto'])
                        ->where('hora_entrega >=', sprintf('%02d:00:00', $h))
                        ->where('hora_entrega <=', sprintf('%02d:59:59', $h))
                        ->countAllResults();
                    $labels[] = sprintf('%02d:00', $h);
                    $datos[]  = $count;
                }
                break;

            // ── POR DÍAS ───────────────────────────────────────────
            case 'dias':
                $inicio = $this->request->getGet('inicio')
                    ?? (clone $now)->modify('-29 days')->format('Y-m-d');
                $fin = $this->request->getGet('fin')
                    ?? $now->format('Y-m-d');

                $cursor = new \DateTime($inicio, $lima);
                $end    = new \DateTime($fin, $lima);

                while ($cursor <= $end) {
                    $fecha = $cursor->format('Y-m-d');
                    $count = $db->table('prestamos')
                        ->where('entrega', $fecha)
                        ->whereIn('estado', ['activo', 'devuelto'])
                        ->countAllResults();
                    $labels[] = $cursor->format('d/m');
                    $datos[]  = $count;
                    $cursor->modify('+1 day');
                }
                break;

            // ── POR MESES ──────────────────────────────────────────
            case 'meses':
                $anio = (int)($this->request->getGet('anio') ?? $now->format('Y'));
                $mesesNombres = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                for ($m = 1; $m <= 12; $m++) {
                    $inicioMes = sprintf('%04d-%02d-01', $anio, $m);
                    $finMes    = (new \DateTime($inicioMes))->format('Y-m-t');
                    $count = $db->table('prestamos')
                        ->where('entrega >=', $inicioMes)
                        ->where('entrega <=', $finMes)
                        ->whereIn('estado', ['activo', 'devuelto'])
                        ->countAllResults();
                    $labels[] = $mesesNombres[$m - 1] . ' ' . $anio;
                    $datos[]  = $count;
                }
                break;
        }

        return $this->response->setJSON([
            'labels' => $labels,
            'datos'  => $datos,
            'total'  => array_sum($datos),
        ]);
    }
}
