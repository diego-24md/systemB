<?php

/** @var string $header */
/** @var string $footer */
/** @var array $alumnas */
/** @var array $grados */
/** @var array $secciones */
/** @var object $pager */
/** @var int $total */
/** @var string|null $grado */
/** @var string|null $seccion */
/** @var string|null $buscar */
/** @var string|null $turno */
?>
<?= $header ?>

<link rel="stylesheet" href="<?= base_url('css/alumnas/index.css') ?>">

<div class="container-fluid px-4 py-4">

    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="page-title">Gestión de alumnas</div>
            <div class="page-subtitle">Consulta e importación por grado y sección</div>
        </div>
        <a href="<?= base_url('alumnas/importar') ?>" class="btn btn-importar">
            <i class="fas fa-file-excel me-2"></i> Importar Excel
        </a>
    </div>

    <!-- Mensajes -->
    <?php if (session()->getFlashdata('success')): ?>
        <div id="success-alert" class="alert alert-success-custom" role="alert">
            <div class="alert-content">
                <i class="fas fa-check-circle"></i>
                <span><?= session()->getFlashdata('success') ?></span>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" style="background:#fef2f2;color:#dc2626;">
            <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Filtros -->
    <div class="panel">
        <div class="panel-label">Filtrar alumnas</div>
        <form method="GET" action="<?= base_url('alumnas') ?>">
            <div class="row g-3 align-items-end">

                <div class="col-md-2">
                    <label class="form-label text-muted" style="font-size:0.82rem;">Grado</label>
                    <select name="grado" class="form-select" id="selectGrado">
                        <option value="">Todos los grados</option>
                        <?php foreach ($grados as $g): ?>
                            <option value="<?= $g['id'] ?>" <?= ($grado ?? '') == $g['id'] ? 'selected' : '' ?>>
                                <?= esc((string)$g['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label text-muted" style="font-size:0.82rem;">Sección</label>
                    <select name="seccion" class="form-select" id="selectSeccion" <?= empty($grado) ? 'disabled' : '' ?>>
                        <option value="">Todas las secciones</option>
                        <?php foreach ($secciones as $s): ?>
                            <?php if (!empty($grado) && $s['grado_id'] == $grado): ?>
                                <option value="<?= $s['id'] ?>" <?= ($seccion ?? '') == $s['id'] ? 'selected' : '' ?>>
                                    <?= esc((string)$s['nombre']) ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- TURNO -->
                <div class="col-md-2">
                    <label class="form-label text-muted" style="font-size:0.82rem;">Turno</label>
                    <select name="turno" class="form-select">
                        <option value="">Todos los turnos</option>
                        <option value="manana" <?= ($turno ?? '') === 'manana' ? 'selected' : '' ?>>Mañana</option>
                        <option value="tarde" <?= ($turno ?? '') === 'tarde'  ? 'selected' : '' ?>>Tarde</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label text-muted" style="font-size:0.82rem;">Buscar por nombre o DNI</label>
                    <input type="text" name="buscar" class="form-control"
                        placeholder="Ej: María o 72894561"
                        value="<?= esc($buscar ?? '') ?>">
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-buscar w-100">
                        <i class="fas fa-search me-2"></i> Buscar
                    </button>
                </div>

                <div class="col-md-1">
                    <a href="<?= base_url('alumnas') ?>" class="btn w-100"
                        style="border:1px solid #e2e8f0;color:#64748b;border-radius:8px;padding:10px;height:42px;">
                        <i class="fas fa-eraser"></i>
                    </a>
                </div>

            </div>
        </form>
    </div>

    <!-- Resultados -->
    <?php
    $hayFiltro = ($grado !== null && $grado !== '')
        || ($seccion !== null && $seccion !== '')
        || ($turno !== null && $turno !== '')
        || ($buscar !== null && $buscar !== '');
    ?>

    <div class="panel">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="panel-label mb-0">Resultados</div>
            <?php if ($hayFiltro && !empty($alumnas)): ?>
                <span class="total-badge">
                    <?= number_format($total ?? 0) ?> alumna<?= ($total ?? 0) != 1 ? 's' : '' ?>
                </span>
            <?php endif; ?>
        </div>

        <?php if ($hayFiltro): ?>

            <?php
            $mapaGrados    = array_column($grados,    'nombre', 'id');
            $mapaSecciones = array_column($secciones, 'nombre', 'id');
            ?>

            <table class="table mb-0">
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>DNI</th>
                        <th>Nombre completo</th>
                        <th>Grado</th>
                        <th>Sección</th>
                        <th>Turno</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($alumnas)): ?>
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-user-friends"></i>
                                    <p>No se encontraron alumnas con los filtros seleccionados</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($alumnas as $i => $alumna): ?>
                            <tr>
                                <td class="num-col"><?= $i + 1 ?></td>
                                <td><?= esc((string)($alumna['dni'] ?? '')) ?></td>
                                <td><?= esc((string)($alumna['nombre'] ?? '')) ?></td>
                                <td>
                                    <span class="badge-grado">
                                        <?= esc((string)($mapaGrados[$alumna['grado_id']] ?? $alumna['grado_id'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-seccion">
                                        <?= esc((string)($mapaSecciones[$alumna['seccion_id']] ?? $alumna['seccion_id'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (($alumna['turno'] ?? '') === 'manana'): ?>
                                        <span class="badge-turno manana">
                                            <i class="fas fa-sun"></i> Mañana
                                        </span>
                                    <?php elseif (($alumna['turno'] ?? '') === 'tarde'): ?>
                                        <span class="badge-turno tarde">
                                            <i class="fas fa-moon"></i> Tarde
                                        </span>
                                    <?php else: ?>
                                        <span class="badge-turno sin-turno">—</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('alumnas/editar/' . ($alumna['id'] ?? 0)) ?>"
                                        class="btn-accion editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="<?= base_url('alumnas/eliminar/' . ($alumna['id'] ?? 0)) ?>"
                                        class="d-inline" onsubmit="return confirmarEliminar()">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn-accion eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-filter"></i>
                <p>Selecciona un grado y sección, o busca por nombre o DNI</p>
            </div>
        <?php endif; ?>

    </div>
</div>

<script>
    function confirmarEliminar() {
        return confirm('¿Estás seguro de eliminar esta alumna? Esta acción no se puede deshacer.');
    }

    const todasLasSecciones = <?= json_encode($secciones) ?>;

    document.getElementById('selectGrado').addEventListener('change', function() {
        const gradoId = parseInt(this.value);
        const selectSeccion = document.getElementById('selectSeccion');

        selectSeccion.innerHTML = '<option value="">Todas las secciones</option>';

        if (!gradoId) {
            selectSeccion.disabled = true;
            return;
        }

        selectSeccion.disabled = false;

        todasLasSecciones.forEach(function(s) {
            if (s.grado_id == gradoId) {
                const opt = document.createElement('option');
                opt.value = s.id;
                opt.textContent = s.nombre;
                selectSeccion.appendChild(opt);
            }
        });
    });

    setTimeout(() => {
        const alerta = document.getElementById('success-alert');
        if (alerta) {
            alerta.style.transition = "opacity 0.5s ease";
            alerta.style.opacity = "0";
            setTimeout(() => alerta.remove(), 500);
        }
    }, 5000);
</script>

<?= $footer ?>