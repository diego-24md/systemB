<?php

/** @var string $header */
/** @var string $footer */
/** @var array $prestamos */
?>
<?= $header ?>

<link rel="stylesheet" href="<?= base_url('css/prestamos/activos.css') ?>">

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="page-title">Préstamos Activos</div>
            <div class="page-subtitle">
                Libros actualmente prestados
            </div>
        </div>
    </div>

    <?php if (!empty($prestamos)): ?>

        <div class="panel">
            <div class="panel-label">
                <i class="fas fa-book-open" style="color:#2563eb;"></i>
                Préstamos Activos
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Alumna</th>
                            <th>DNI</th>
                            <th>Turno</th>
                            <th>Libro</th>
                            <th>Fecha Entrega</th>
                            <th>Condición</th>
                            <th>Estado</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($prestamos as $i => $p): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>

                                <td>
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

                                <td>
                                    <?= esc((string) ($p['titulo'] ?? '—')) ?>
                                </td>

                                <td>
                                    <?= esc((string) $p['entrega']) ?>
                                </td>

                                <td>
                                    <?php
                                    $condicion = strtolower(trim($p['condicionentrega'] ?? ''));
                                    if ($condicion === 'bueno') {
                                        $clase = 'badge-bueno';
                                    } elseif ($condicion === 'regular') {
                                        $clase = 'badge-regular';
                                    } else {
                                        $clase = 'badge-malo';
                                    }
                                    ?>
                                    <span class="badge-condicion <?= $clase ?>">
                                        <?= esc((string) ($p['condicionentrega'] ?? '—')) ?>
                                    </span>
                                </td>

                                <td>
                                    <span class="badge-estado">
                                        Activo
                                    </span>
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
                <i class="fas fa-book-open"></i>
                <h5>No hay préstamos activos</h5>
                <p>Actualmente no existen libros prestados en el sistema.</p>
            </div>
        </div>

    <?php endif; ?>

</div>

<?= $footer ?>