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
                            <th>Turno</th>
                            <th>Ejemplar Solicitado</th>
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

                                <td>
                                    <?php if (($p['turno'] ?? '') === 'manana'): ?>
                                        <span class="badge-turno manana">
                                            <i class="fas fa-sun"></i> Mañana
                                        </span>
                                    <?php elseif (($p['turno'] ?? '') === 'tarde'): ?>
                                        <span class="badge-turno tarde">
                                            <i class="fas fa-moon"></i> Tarde
                                        </span>
                                    <?php else: ?>
                                        <span class="badge-turno sin-turno">—</span>
                                    <?php endif; ?>
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
                                            class="btn-rechazar">
                                            <i class="fas fa-times"></i> Rechazar
                                        </a>
                                        <a href="<?= base_url('prestamos/aprobar/' . $p['idprestamo']) ?>"
                                            class="btn-aprobar">
                                            <i class="fas fa-check"></i> Aprobar
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
                <p>Todas las solicitudes ya fueron revisadas correctamente.</p>
            </div>
        </div>

    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.btn-aprobar').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.href;
            Swal.fire({
                title: '¿Aprobar préstamo?',
                text: 'Se aceptará la reserva y se descontará el stock.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1D9E75',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-check"></i> Sí, aprobar',
                cancelButtonText: 'Cancelar',
            }).then(result => {
                if (result.isConfirmed) window.location.href = url;
            });
        });
    });

    document.querySelectorAll('.btn-rechazar').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.href;
            Swal.fire({
                title: '¿Rechazar reserva?',
                text: 'Se notificará a la alumna que su reserva fue rechazada.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#E24B4A',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-times"></i> Sí, rechazar',
                cancelButtonText: 'Cancelar',
            }).then(result => {
                if (result.isConfirmed) window.location.href = url;
            });
        });
    });
</script>

<?= $footer ?>