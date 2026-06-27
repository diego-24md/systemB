<?php

/** @var string $header */
/** @var string $footer */
/** @var array $pendientes */
/** @var int $hora_actual */

$manana    = array_filter($pendientes, fn($p) => ($p['turno'] ?? '') === 'manana');
$tarde     = array_filter($pendientes, fn($p) => ($p['turno'] ?? '') === 'tarde');
$sin_turno = array_filter($pendientes, fn($p) => !in_array($p['turno'] ?? '', ['manana', 'tarde']));

// Mañana: 8:00 - 13:00 | Tarde: 13:00 - 19:00
$turno_activo_manana = $hora_actual >= 8  && $hora_actual < 13;
$turno_activo_tarde  = $hora_actual >= 13 && $hora_actual < 19;
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
        <div class="text-muted small mt-1">
            <i class="fas fa-clock me-1"></i>
            Hora actual: <strong><?= (new \DateTime('now', new \DateTimeZone('America/Lima')))->format('H:i') ?></strong>
        </div>
    </div>

    <?php if (empty($pendientes)): ?>

        <div class="panel">
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h5>No hay reservas pendientes</h5>
                <p>Todas las solicitudes ya fueron revisadas correctamente.</p>
            </div>
        </div>

    <?php else: ?>

        <?php
        $secciones = [
            'manana' => [
                'label'   => 'Turno Mañana',
                'horario' => '8:00 am – 1:00 pm',
                'icon'    => 'fa-sun',
                'color'   => '#f59e0b',
                'activo'  => $turno_activo_manana,
                'data'    => $manana,
            ],
            'tarde' => [
                'label'   => 'Turno Tarde',
                'horario' => '1:00 pm – 7:00 pm',
                'icon'    => 'fa-moon',
                'color'   => '#3b82f6',
                'activo'  => $turno_activo_tarde,
                'data'    => $tarde,
            ],
        ];
        if (!empty($sin_turno)) {
            $secciones['sin_turno'] = [
                'label'   => 'Sin turno',
                'horario' => '',
                'icon'    => 'fa-question-circle',
                'color'   => '#6b7280',
                'activo'  => false,
                'data'    => $sin_turno,
            ];
        }
        ?>

        <div>

            <?php foreach ($secciones as $key => $sec): ?>
                <div class="col-12">
                    <div class="panel h-100">

                        <div class="panel-label panel-label--<?= $key ?>">
                            <i class="fas <?= $sec['icon'] ?>" style="color:<?= $sec['color'] ?>;"></i>
                            <?= $sec['label'] ?>
                            <?php if ($sec['horario']): ?>
                                <small class="text-muted fw-normal ms-1">(<?= $sec['horario'] ?>)</small>
                            <?php endif; ?>
                            <span class="badge-count"><?= count($sec['data']) ?></span>

                            <?php if (!$sec['activo'] && !empty($sec['data'])): ?>
                                <span class="badge bg-danger ms-2" style="font-size:11px;">
                                    <i class="fas fa-lock me-1"></i>Fuera de horario
                                </span>
                            <?php elseif ($sec['activo']): ?>
                                <span class="badge bg-success ms-2" style="font-size:11px;">
                                    <i class="fas fa-unlock me-1"></i>Turno activo
                                </span>
                            <?php endif; ?>
                        </div>

                        <?php if (!$sec['activo'] && !empty($sec['data'])): ?>
                            <div class="alert alert-warning mx-3 mt-3 mb-3 py-2 px-3" style="font-size:13px;">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Las reservas de este turno <strong>no pueden aprobarse</strong> fuera de su horario.
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($sec['data'])): ?>

                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th style="width:50px;">#</th>
                                            <th>Alumna</th>
                                            <th>DNI</th>
                                            <th>Ejemplar Solicitado</th>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th style="width:200px;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (array_values($sec['data']) as $i => $p): ?>
                                            <tr class="<?= !$sec['activo'] ? 'table-secondary' : '' ?>">
                                                <td><?= $i + 1 ?></td>
                                                <td class="student-name"><?= esc((string) $p['nombre']) ?></td>
                                                <td><?= esc((string) $p['dni']) ?></td>
                                                <td class="book-title"><?= esc((string) ($p['titulo'] ?? '—')) ?></td>
                                                <td><?= esc((string) $p['entrega']) ?></td>
                                                <td><?= esc((string) $p['hora_entrega']) ?></td>
                                                <td>
                                                    <?php if ($sec['activo']): ?>
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
                                                    <?php else: ?>
                                                        <span class="text-muted small">
                                                            <i class="fas fa-lock me-1"></i>Bloqueado
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                        <?php else: ?>

                            <div class="empty-state" style="padding:24px;">
                                <i class="fas fa-inbox"></i>
                                <p>No hay reservas para este turno.</p>
                            </div>

                        <?php endif; ?>

                    </div>
                </div>
            <?php endforeach; ?>

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