<?php

/** @var string $header */
/** @var string $footer */
/** @var array<int, array<string, mixed>> $prestamos */
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
    }

    .filtros {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .filtros input,
    .filtros select {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.85rem;
        padding: 8px 14px;
        color: #475569;
        outline: none;
    }

    .filtros input:focus,
    .filtros select:focus {
        border-color: #1e3a5f;
        box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.08);
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
        vertical-align: middle;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table tbody tr:hover {
        background-color: #f8fafc;
    }

    .num-col {
        color: #cbd5e1;
        font-size: 0.82rem;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 12px;
        display: block;
    }

    .empty-state p {
        font-size: 0.88rem;
        margin: 0;
    }

    .badge-condicion {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
    }

    .condicion-bueno {
        background: #f0fdf4;
        color: #15803d;
    }

    .condicion-regular {
        background: #fef3c7;
        color: #d97706;
    }

    .condicion-malo {
        background: #fef2f2;
        color: #dc2626;
    }

    .badge-devuelto {
        background: #f0fdf4;
        color: #15803d;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
    }

    .minutos-badge {
        background: #f0f9ff;
        color: #0369a1;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
    }
</style>

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="page-title">Historial de Préstamos</div>
            <div class="page-subtitle">Registro de todos los préstamos devueltos</div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-label">Filtros</div>
        <div class="filtros">
            <input type="text" id="filtro-nombre" placeholder="Buscar alumna...">
            <input type="text" id="filtro-libro" placeholder="Buscar libro...">
            <input type="text" id="filtro-dni" placeholder="Buscar DNI...">
            <select id="filtro-grado">
                <option value="">Todos los grados</option>
                <?php
                $grados = array_unique(array_column($prestamos, 'grado'));
                sort($grados);
                foreach ($grados as $g): ?>
                    <option value="<?= esc((string)$g) ?>"><?= esc((string)$g) ?></option>
                <?php endforeach; ?>
            </select>
            <select id="filtro-seccion">
                <option value="">Todas las secciones</option>
                <?php
                $secciones = array_unique(array_column($prestamos, 'seccion'));
                sort($secciones);
                foreach ($secciones as $s): ?>
                    <option value="<?= esc((string)$s) ?>"><?= esc((string)$s) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <table class="table mb-0" id="tabla-historial">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Alumna</th>
                    <th>DNI</th>
                    <th>Grado</th>
                    <th>Sección</th>
                    <th>Libro</th>
                    <th>Hora Entrega</th>
                    <th>Hora Devolución</th>
                    <th>Duración</th>
                    <th>Condición</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody id="tbody-historial">
                <?php if (!empty($prestamos)): ?>
                    <?php foreach ($prestamos as $i => $p): ?>
                        <tr
                            data-nombre="<?= strtolower(esc((string)$p['nombre'])) ?>"
                            data-libro="<?= strtolower(esc((string)$p['titulo'] ?? '')) ?>"
                            data-dni="<?= esc((string)$p['dni']) ?>"
                            data-grado="<?= esc((string)$p['grado'] ?? '') ?>"
                            data-seccion="<?= esc((string)$p['seccion'] ?? '') ?>">
                            <td class="num-col"><?= $i + 1 ?></td>
                            <td><?= esc((string)$p['nombre']) ?></td>
                            <td><?= esc((string)$p['dni']) ?></td>
                            <td><?= esc((string)($p['grado'] ?? '—')) ?></td>
                            <td><?= esc((string)($p['seccion'] ?? '—')) ?></td>
                            <td><?= esc((string)($p['titulo'] ?? '—')) ?></td>
                            <td><?= esc((string)$p['hora_entrega']) ?></td>
                            <td><?= esc((string)$p['hora_devolucion']) ?></td>
                            <td>
                                <?php
                                $min = (int)$p['minutos'];
                                if ($min >= 60) {
                                    $horas = floor($min / 60);
                                    $restoMin = $min % 60;
                                    $tiempoTexto = $horas . 'h' . ($restoMin > 0 ? ' ' . $restoMin . 'min' : '');
                                } else {
                                    $tiempoTexto = $min . ' min';
                                }
                                ?>
                                <span class="minutos-badge">
                                    <i class="fas fa-clock me-1"></i><?= $tiempoTexto ?>
                                </span>
                            </td>
                            <td>
                                <?php
                                $condicion = strtolower((string)($p['condicionentrega'] ?? ''));
                                $clase = match ($condicion) {
                                    'bueno'   => 'condicion-bueno',
                                    'regular' => 'condicion-regular',
                                    'malo'    => 'condicion-malo',
                                    default   => ''
                                };
                                ?>
                                <span class="badge-condicion <?= $clase ?>">
                                    <?= esc((string)$p['condicionentrega']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge-devuelto">
                                    <i class="fas fa-check me-1"></i> Devuelto
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11">
                            <div class="empty-state">
                                <i class="fas fa-history"></i>
                                <p>No hay préstamos en el historial</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?= $footer ?>

<script>
    const filtros = ['filtro-nombre', 'filtro-libro', 'filtro-dni', 'filtro-grado', 'filtro-seccion'];

    filtros.forEach(id => {
        document.getElementById(id).addEventListener('input', filtrar);
        document.getElementById(id).addEventListener('change', filtrar);
    });

    function filtrar() {
        const nombre = document.getElementById('filtro-nombre').value.toLowerCase();
        const libro = document.getElementById('filtro-libro').value.toLowerCase();
        const dni = document.getElementById('filtro-dni').value.toLowerCase();
        const grado = document.getElementById('filtro-grado').value.toLowerCase();
        const seccion = document.getElementById('filtro-seccion').value.toLowerCase();

        document.querySelectorAll('#tbody-historial tr').forEach(row => {
            const matchNombre = row.dataset.nombre?.includes(nombre) ?? true;
            const matchLibro = row.dataset.libro?.includes(libro) ?? true;
            const matchDni = row.dataset.dni?.includes(dni) ?? true;
            const matchGrado = grado === '' || row.dataset.grado === grado;
            const matchSeccion = seccion === '' || row.dataset.seccion === seccion;

            row.style.display = (matchNombre && matchLibro && matchDni && matchGrado && matchSeccion) ?
                '' : 'none';
        });
    }
</script>