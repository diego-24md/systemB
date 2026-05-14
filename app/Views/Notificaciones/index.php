<?php

/** @var string $header */
/** @var string $footer */
/** @var array $notificaciones */
/** @var int $totalGeneral */
/** @var int $totalLibros */
/** @var int $totalPrestamos */
?>
<?= $header ?>

<link rel="stylesheet" href="<?= base_url('css/notificaciones/index.css') ?>">

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="page-title">Notificaciones</div>
            <div class="page-subtitle">Registro de actividad del sistema</div>
        </div>
    </div>

    <div class="stats-bar">
        <div class="stat-chip">
            <i class="fas fa-bell" style="color:#94a3b8;"></i>
            Total: <strong><?= $totalGeneral ?></strong>
        </div>
        <div class="stat-chip">
            <i class="fas fa-book" style="color:#2563eb;"></i>
            Libros: <strong><?= $totalLibros ?></strong>
        </div>
        <div class="stat-chip">
            <i class="fas fa-hand-holding-heart" style="color:#16a34a;"></i>
            Préstamos: <strong><?= $totalPrestamos ?></strong>
        </div>
    </div>

    <div class="panel">
        <?php if (!empty($notificaciones)): ?>

            <div id="lista-notificaciones">
                <?php foreach ($notificaciones as $n): ?>
                    <?= renderNotif($n) ?>
                <?php endforeach; ?>
            </div>

            <div class="spinner" id="spinner">
                <i class="fas fa-spinner fa-spin me-2"></i> Cargando...
            </div>

            <?php if ($totalGeneral > 15): ?>
                <button class="btn-cargar-mas" id="btn-cargar-mas">
                    <i class="fas fa-chevron-down me-2"></i> Cargar más notificaciones
                </button>
            <?php endif; ?>

        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-bell-slash"></i>
                <p>No hay notificaciones registradas</p>
            </div>
        <?php endif; ?>
    </div>

</div>

<?php
function renderNotif(array $n): string
{
    $colorClass = match ($n['color'] ?? 'default') {
        'success' => 'success',
        'danger'  => 'danger',
        'primary' => 'primary',
        'info'    => 'info',
        'warning' => 'warning',
        default   => 'default'
    };

    $tipoClass = match ($n['tipo'] ?? '') {
        'libro'    => 'tipo-libro',
        'prestamo' => 'tipo-prestamo',
        'alumna'   => 'tipo-alumna',
        default    => 'tipo-default'
    };

    $tipoLabel = match ($n['tipo'] ?? '') {
        'libro'    => 'Libro',
        'prestamo' => 'Préstamo',
        'alumna'   => 'Alumna',
        default    => 'Sistema'
    };

    $fecha      = new \DateTime($n['created_at']);
    $fechaTexto = $fecha->format('d/m/Y H:i');
    $icono      = htmlspecialchars($n['icono']);
    $mensaje    = htmlspecialchars($n['mensaje']);

    return "
    <div class='notif-item'>
        <div class='notif-icon {$colorClass}'>
            <i class='{$icono}'></i>
        </div>
        <div class='notif-body'>
            <div class='notif-mensaje'>{$mensaje}</div>
            <div class='notif-fecha'>
                <i class='fas fa-clock'></i> {$fechaTexto}
            </div>
        </div>
        <span class='notif-tipo {$tipoClass}'>{$tipoLabel}</span>
    </div>";
}
?>

<?= $footer ?>

<script>
    const limit = 15;
    let offset = limit;
    const total = <?= $totalGeneral ?>;
    const btnCargar = document.getElementById('btn-cargar-mas');
    const spinner = document.getElementById('spinner');
    const lista = document.getElementById('lista-notificaciones');
    const urlBase = '<?= base_url('notificaciones/cargar-mas') ?>';

    if (btnCargar) {
        btnCargar.addEventListener('click', async () => {
            btnCargar.style.display = 'none';
            spinner.style.display = 'block';

            try {
                const res = await fetch(`${urlBase}?offset=${offset}`);
                const data = await res.json();

                data.forEach(n => {
                    const colorClass = getColor(n.color);
                    const tipoClass = getTipoClass(n.tipo);
                    const tipoLabel = getTipoLabel(n.tipo);
                    const fecha = new Date(n.created_at).toLocaleString('es-PE', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    lista.insertAdjacentHTML('beforeend', `
                        <div class="notif-item">
                            <div class="notif-icon ${colorClass}">
                                <i class="${n.icono}"></i>
                            </div>
                            <div class="notif-body">
                                <div class="notif-mensaje">${n.mensaje}</div>
                                <div class="notif-fecha">
                                    <i class="fas fa-clock"></i> ${fecha}
                                </div>
                            </div>
                            <span class="notif-tipo ${tipoClass}">${tipoLabel}</span>
                        </div>
                    `);
                });

                offset += data.length;
                spinner.style.display = 'none';

                if (offset < total) {
                    btnCargar.style.display = 'block';
                } else {
                    btnCargar.textContent = 'No hay más notificaciones';
                    btnCargar.disabled = true;
                    btnCargar.style.display = 'block';
                }

            } catch (err) {
                spinner.style.display = 'none';
                btnCargar.style.display = 'block';
                console.error('Error cargando notificaciones:', err);
            }
        });
    }

    function getColor(color) {
        const map = {
            success: 'success',
            danger: 'danger',
            primary: 'primary',
            info: 'info',
            warning: 'warning'
        };
        return map[color] ?? 'default';
    }

    function getTipoClass(tipo) {
        const map = {
            libro: 'tipo-libro',
            prestamo: 'tipo-prestamo',
            alumna: 'tipo-alumna'
        };
        return map[tipo] ?? 'tipo-default';
    }

    function getTipoLabel(tipo) {
        const map = {
            libro: 'Libro',
            prestamo: 'Préstamo',
            alumna: 'Alumna'
        };
        return map[tipo] ?? 'Sistema';
    }
</script>