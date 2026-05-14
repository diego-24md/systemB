<?php

/** @var string $header */
/** @var string $footer */
/** @var array $pendientes */
?>
<?= $header ?>

<link rel="stylesheet" href="<?= base_url('css/prestamos/pendientes.css') ?>">

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