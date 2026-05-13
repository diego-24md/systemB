<?php

/** @var string $header */
/** @var string $footer */
/** @var array $prestamos */
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
        flex-wrap: wrap;
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
        border-bottom: 1px solid #e2e8f0;
        background: #fff;
        padding: 12px 16px;
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

    .badge-estado,
    .badge-condicion {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.76rem;
        font-weight: 600;
        display: inline-block;
    }

    .badge-bueno {
        background: #ecfdf3;
        color: #15803d;
    }

    .badge-regular {
        background: #fff7ed;
        color: #d97706;
    }

    .badge-malo {
        background: #fef2f2;
        color: #dc2626;
    }

    .badge-estado {
        background: #eff6ff;
        color: #2563eb;
    }

    .empty-state {
        text-align: center;
        padding: 50px 20px;
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

                <p>
                    Actualmente no existen libros prestados en el sistema.
                </p>
            </div>
        </div>

    <?php endif; ?>

</div>

<?= $footer ?>