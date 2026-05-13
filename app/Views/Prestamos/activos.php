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

    .badge-condicion {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
    }
</style>

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="page-title">Préstamos Activos</div>
            <div class="page-subtitle">Libros actualmente prestados</div>
        </div>
    </div>

    <?php if (!empty($prestamos)): ?>
        <div class="panel">
            <div class="panel-label">
                <i class="fas fa-book-open"></i>
                Préstamos Activos
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
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
                            <td><?= esc((string)$p['nombre']) ?></td>
                            <td><?= esc((string)$p['dni']) ?></td>
                            <td><?= esc((string)($p['titulo'] ?? '—')) ?></td>
                            <td><?= esc((string)$p['entrega']) ?></td>
                            <td>
                                <?php
                                $cond = strtolower($p['condicionentrega'] ?? '');
                                $clase = $cond === 'bueno' ? 'bg-success' : ($cond === 'regular' ? 'bg-warning' : 'bg-danger');
                                ?>
                                <span class="badge <?= $clase ?>"><?= esc((string)$p['condicionentrega']) ?></span>
                            </td>
                            <td>
                                <span class="badge bg-primary">Activo</span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="panel text-center py-5">
            <i class="fas fa-book-open fa-3x text-muted"></i>
            <h5 class="mt-3">No hay préstamos activos</h5>
        </div>
    <?php endif; ?>

</div>

<?= $footer ?>