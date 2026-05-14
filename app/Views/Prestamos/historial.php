<?php

/** @var string $header */
/** @var string $footer */
/** @var array<int, array<string, mixed>> $prestamos */
?>
<?= $header ?>

<link rel="stylesheet" href="<?= base_url('css/prestamos/historial.css') ?>">

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