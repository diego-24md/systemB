<?php

/** @var string $header */
/** @var string $footer */
/** @var array<int, array<string, mixed>> $prestamos */
?>
<?= $header ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="<?= base_url('css/prestamos/devoluciones.css') ?>">

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="page-title">Devoluciones</div>
            <div class="page-subtitle">Gestión de devoluciones de ejemplares prestados</div>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert fade show rounded-3 border-0 mb-3" style="background:#f0fdf4;color:#15803d;">
            <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert fade show rounded-3 border-0 mb-3" style="background:#fef2f2;color:#dc2626;">
            <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="panel">
        <div class="panel-label">Préstamos Activos</div>
        <table class="table mb-0">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Alumna</th>
                    <th>DNI</th>
                    <th>Ejemplar</th>
                    <th>Fecha</th>
                    <th>Hora Entrega</th>
                    <th>Condición</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($prestamos)): ?>
                    <?php foreach ($prestamos as $i => $p): ?>
                        <tr>
                            <td class="num-col"><?= $i + 1 ?></td>
                            <td><?= esc((string)$p['nombre']) ?></td>
                            <td><?= esc((string)$p['dni']) ?></td>
                            <td><?= esc((string)($p['titulo'] ?? '—')) ?></td>
                            <td><?= esc((string)$p['entrega']) ?></td>
                            <td><?= esc((string)$p['hora_entrega']) ?></td>
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
                                <span class="badge-activo">
                                    <i class="fas fa-circle me-1" style="font-size:0.5rem;"></i> Activo
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('prestamos/devolver/' . $p['idprestamo']) ?>"
                                    class="btn-devolver"
                                    data-titulo="<?= esc((string)$p['titulo']) ?>"
                                    onclick="confirmarDevolucion(event, this)">
                                    <i class="fas fa-undo"></i> Devolver
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <i class="fas fa-book-open"></i>
                                <p>No hay préstamos activos</p>
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
    function confirmarDevolucion(e, el) {
        e.preventDefault();
        const titulo = el.dataset.titulo;
        const url = el.href;

        Swal.fire({
            title: '¿Confirmar devolución?',
            text: `"${titulo}" será marcado como devuelto.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Sí, devolver',
            cancelButtonText: 'Cancelar',
            borderRadius: '12px',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }

    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(a => {
            a.style.transition = 'opacity 0.5s';
            a.style.opacity = '0';
            setTimeout(() => a.remove(), 500);
        });
    }, 5000);
</script>