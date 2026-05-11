<?php

/** @var string $header */
/** @var string $footer */
/** @var array $notificaciones */
/** @var int $totalGeneral */
/** @var int $totalLibros */
/** @var int $totalPrestamos */
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
        padding: 0;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .notif-item {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s;
    }

    .notif-item:last-child {
        border-bottom: none;
    }

    .notif-item:hover {
        background: #f8fafc;
    }

    .notif-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .notif-icon.success {
        background: #f0fdf4;
        color: #16a34a;
    }

    .notif-icon.danger {
        background: #fef2f2;
        color: #dc2626;
    }

    .notif-icon.primary {
        background: #eff6ff;
        color: #2563eb;
    }

    .notif-icon.info {
        background: #f0f9ff;
        color: #0369a1;
    }

    .notif-icon.warning {
        background: #fefce8;
        color: #ca8a04;
    }

    .notif-icon.default {
        background: #f1f5f9;
        color: #64748b;
    }

    .notif-body {
        flex: 1;
    }

    .notif-mensaje {
        font-size: 0.88rem;
        color: #1e293b;
        font-weight: 500;
        margin-bottom: 4px;
        line-height: 1.4;
    }

    .notif-fecha {
        font-size: 0.78rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .notif-tipo {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 2px 8px;
        border-radius: 20px;
        flex-shrink: 0;
        margin-top: 4px;
    }

    .tipo-libro {
        background: #eff6ff;
        color: #2563eb;
    }

    .tipo-prestamo {
        background: #f0fdf4;
        color: #16a34a;
    }

    .tipo-alumna {
        background: #fefce8;
        color: #ca8a04;
    }

    .tipo-default {
        background: #f1f5f9;
        color: #64748b;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 16px;
        display: block;
    }

    .empty-state p {
        font-size: 0.88rem;
        margin: 0;
    }

    .stats-bar {
        display: flex;
        gap: 16px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .stat-chip {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 10px 18px;
        font-size: 0.82rem;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .stat-chip strong {
        color: #1e293b;
        font-size: 1rem;
    }

    .btn-cargar-mas {
        display: block;
        width: 100%;
        padding: 14px;
        text-align: center;
        font-size: 0.85rem;
        font-weight: 600;
        color: #1e3a5f;
        background: #f8fafc;
        border: none;
        border-top: 1px solid #f1f5f9;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-cargar-mas:hover {
        background: #f1f5f9;
    }

    .btn-cargar-mas:disabled {
        color: #94a3b8;
        cursor: default;
    }

    .spinner {
        display: none;
        text-align: center;
        padding: 16px;
        color: #94a3b8;
        font-size: 0.85rem;
        border-top: 1px solid #f1f5f9;
    }
</style>

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