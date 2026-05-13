<?php

/** @var string $header */
/** @var string $footer */
/** @var array $pendientes */
?>
<?= $header ?>

<style>
    body {
        background-color: #f4f6f9;
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1a1a2e;
    }

    .panel {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 24px;
        margin-bottom: 20px;
    }

    .panel-label {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        color: #94a3b8;
        text-transform: uppercase;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .table thead th {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.07em;
        color: #94a3b8;
        text-transform: uppercase;
        border-bottom: 1px solid #e2e8f0;
        background: #fff;
        padding: 12px 16px;
    }

    .table tbody td {
        padding: 13px 16px;
        font-size: 0.88rem;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
    }

    .btn-aprobar,
    .btn-rechazar {
        padding: 6px 14px;
        font-size: 0.8rem;
        font-weight: 600;
        border-radius: 7px;
    }
</style>

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="page-title">Reservas Pendientes</div>
            <div class="page-subtitle">Solicitudes de préstamo esperando aprobación</div>
        </div>
    </div>

    <?php if (!empty($pendientes)): ?>
        <div class="panel">
            <div class="panel-label">
                <i class="fas fa-clock" style="color:#f59e0b;"></i>
                Reservas Pendientes de Aprobación
                <span style="background:#fef3c7;color:#d97706;padding:2px 8px;border-radius:20px;font-size:0.75rem;">
                    <?= count($pendientes) ?>
                </span>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Alumna</th>
                        <th>DNI</th>
                        <th>Libro</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pendientes as $i => $p): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= esc((string)$p['nombre']) ?></td>
                            <td><?= esc((string)$p['dni']) ?></td>
                            <td><?= esc((string)($p['titulo'] ?? '—')) ?></td>
                            <td><?= esc((string)$p['entrega']) ?></td>
                            <td><?= esc((string)$p['hora_entrega']) ?></td>
                            <td>
                                <a href="<?= base_url('prestamos/rechazar/' . $p['idprestamo']) ?>"
                                    class="btn btn-rechazar me-2"
                                    onclick="return confirm('¿Rechazar esta reserva?')">
                                    <i class="fas fa-times"></i> Rechazar
                                </a>
                                <a href="<?= base_url('prestamos/aprobar/' . $p['idprestamo']) ?>"
                                    class="btn btn-aprobar"
                                    onclick="return confirm('¿Aprobar este préstamo?')">
                                    <i class="fas fa-check"></i> Aprobar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="panel text-center py-5">
            <i class="fas fa-check-circle fa-3x" style="color:#86efac;"></i>
            <h5 class="mt-3">No hay reservas pendientes</h5>
        </div>
    <?php endif; ?>

</div>

<?= $footer ?>