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
        font-size: 1.4rem;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 2px;
    }

    .page-subtitle {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 24px;
        margin-bottom: 20px;
    }

    .panel-label {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        color: #94a3b8;
        text-transform: uppercase;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .badge-count {
        background: #fff7ed;
        color: #d97706;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.07em;
        color: #94a3b8;
        text-transform: uppercase;
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        padding: 13px 16px;
        white-space: nowrap;
    }

    .table tbody td {
        padding: 14px 16px;
        font-size: 0.88rem;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .student-name {
        font-weight: 600;
        color: #1e293b;
    }

    .book-title {
        font-weight: 500;
        color: #334155;
    }

    .btn-aprobar,
    .btn-rechazar {
        border: none;
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: 0.2s ease;
    }

    .btn-aprobar {
        background: #1e3a5f;
        color: #ffffff;
    }

    .btn-aprobar:hover {
        background: #16304f;
        color: #ffffff;
    }

    .btn-rechazar {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    .btn-rechazar:hover {
        background: #fee2e2;
        color: #b91c1c;
    }

    .empty-state {
        text-align: center;
        padding: 55px 20px;
    }

    .empty-state i {
        font-size: 3rem;
        color: #94a3b8;
        margin-bottom: 15px;
    }

    .empty-state h5 {
        font-size: 1rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }

    .empty-state p {
        font-size: 0.88rem;
        color: #64748b;
        margin: 0;
    }

    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
    }
</style>

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="page-title">Reservas Pendientes</div>
            <div class="page-subtitle">
                Solicitudes de préstamo esperando aprobación
            </div>
        </div>
    </div>

    <?php if (!empty($pendientes)): ?>

        <div class="panel">

            <div class="panel-label">
                <i class="fas fa-clock" style="color:#f59e0b;"></i>
                Gestión de Reservas Pendientes

                <span class="badge-count">
                    <?= count($pendientes) ?>
                </span>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Alumna</th>
                            <th>DNI</th>
                            <th>Libro Solicitado</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th style="width: 260px;">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($pendientes as $i => $p): ?>
                            <tr>

                                <td><?= $i + 1 ?></td>

                                <td class="student-name">
                                    <?= esc((string) $p['nombre']) ?>
                                </td>

                                <td>
                                    <?= esc((string) $p['dni']) ?>
                                </td>

                                <td class="book-title">
                                    <?= esc((string) ($p['titulo'] ?? '—')) ?>
                                </td>

                                <td>
                                    <?= esc((string) $p['entrega']) ?>
                                </td>

                                <td>
                                    <?= esc((string) $p['hora_entrega']) ?>
                                </td>

                                <td>
                                    <div class="d-flex gap-2 flex-wrap">

                                        <a href="<?= base_url('prestamos/rechazar/' . $p['idprestamo']) ?>"
                                            class="btn-rechazar"
                                            onclick="return confirm('¿Rechazar esta reserva?')">
                                            <i class="fas fa-times"></i>
                                            Rechazar
                                        </a>

                                        <a href="<?= base_url('prestamos/aprobar/' . $p['idprestamo']) ?>"
                                            class="btn-aprobar"
                                            onclick="return confirm('¿Aprobar este préstamo?')">
                                            <i class="fas fa-check"></i>
                                            Aprobar
                                        </a>

                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>

    <?php else: ?>

        <div class="panel">
            <div class="empty-state">

                <i class="fas fa-inbox"></i>

                <h5>No hay reservas pendientes</h5>

                <p>
                    Todas las solicitudes ya fueron revisadas correctamente.
                </p>

            </div>
        </div>

    <?php endif; ?>

</div>

<?= $footer ?>