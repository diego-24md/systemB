<?php

/** @var string $header */
/** @var string $footer */
/** @var array $reservasPendientes */
/** @var array $historial */
/** @var int $totalGeneral */
/** @var int $totalLibros */
/** @var int $totalPrestamos */
/** @var int $totalReservas */
/** @var int $totalHistorial */
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

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert-success-bar mb-3"><i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

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
            Prestamos: <strong><?= $totalPrestamos ?></strong>
        </div>
    </div>

    <!-- SECCION 1: RESERVAS DE ALUMNAS -->
    <div class="panel mb-4">
        <div class="section-header">
            <div class="section-header-left">
                <i class="fas fa-bookmark" style="color:#16a34a;"></i>
                <span>Reservas de alumnas</span>
            </div>
            <?php if ($totalReservas > 0): ?>
                <span class="badge-nuevas"><?= $totalReservas ?> pendiente<?= $totalReservas > 1 ? 's' : '' ?></span>
            <?php endif; ?>
        </div>

        <?php if (!empty($reservasPendientes)): ?>
            <?php foreach ($reservasPendientes as $n): ?>
                <?= renderNotif($n) ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-bookmark"></i>
                <p>No hay reservas pendientes</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- SECCION 2: HISTORIAL DEL SISTEMA -->
    <div class="panel">
        <div class="section-header">
            <div class="section-header-left">
                <i class="fas fa-history" style="color:#94a3b8;"></i>
                <span>Historial del sistema</span>
            </div>
            <?php if (!empty($historial)): ?>
                <button class="btn-limpiar" onclick="confirmarLimpiar()">
                    <i class="fas fa-trash-alt me-1"></i> Limpiar historial
                </button>
            <?php endif; ?>
        </div>

        <?php if (!empty($historial)): ?>
            <div id="lista-notificaciones">
                <?php foreach ($historial as $n): ?>
                    <?= renderNotif($n, true) ?>
                <?php endforeach; ?>
            </div>

            <div class="spinner" id="spinner">
                <i class="fas fa-spinner fa-spin me-2"></i> Cargando...
            </div>

            <?php if ($totalHistorial > 15): ?>
                <button class="btn-cargar-mas" id="btn-cargar-mas">
                    <i class="fas fa-chevron-down me-2"></i> Cargar mas
                </button>
            <?php endif; ?>

        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-history"></i>
                <p>No hay actividad registrada</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- MODAL CONFIRMAR LIMPIAR -->
<div id="modal-limpiar" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <h3>Limpiar historial</h3>
        <p>Se eliminaran todas las notificaciones del historial del sistema. Esta accion no se puede deshacer.</p>
        <div class="modal-actions">
            <button class="btn-cancel-modal" onclick="document.getElementById('modal-limpiar').style.display='none'">Cancelar</button>
            <button class="btn-confirm-delete" onclick="ejecutarLimpiar()">Si, limpiar todo</button>
        </div>
    </div>
</div>

<?php
function renderNotif(array $n, bool $conEliminar = false): string
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
        'prestamo' => 'Prestamo',
        'alumna'   => 'Alumna',
        default    => 'Sistema'
    };

    $fecha      = new \DateTime($n['created_at']);
    $fechaTexto = $fecha->format('d/m/Y H:i');
    $icono      = htmlspecialchars($n['icono']);
    $mensaje    = htmlspecialchars($n['mensaje']);
    $id         = (int) $n['id'];

    $btnEliminar = $conEliminar
        ? "<button class='btn-eliminar-notif' onclick='eliminarNotif({$id}, this)' title='Eliminar'><i class='fas fa-times'></i></button>"
        : '';

    return "
    <div class='notif-item' id='notif-{$id}'>
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
        {$btnEliminar}
    </div>";
}
?>

<?= $footer ?>

<style>
    .alert-success-bar {
        padding: 0.8rem 1rem;
        border-radius: 8px;
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
        font-size: 0.875rem;
    }

    .btn-limpiar {
        background: none;
        border: 1px solid #fecaca;
        color: #dc2626;
        border-radius: 7px;
        padding: 5px 12px;
        font-size: 0.78rem;
        font-weight: 600;
        cursor: pointer;
        transition: all .2s;
    }

    .btn-limpiar:hover {
        background: #fef2f2;
    }

    .btn-eliminar-notif {
        background: none;
        border: none;
        color: #cbd5e1;
        cursor: pointer;
        font-size: 0.85rem;
        padding: 4px 6px;
        border-radius: 6px;
        flex-shrink: 0;
        transition: all .2s;
    }

    .btn-eliminar-notif:hover {
        color: #dc2626;
        background: #fef2f2;
    }

    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .45);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .modal-box {
        background: #fff;
        border-radius: 14px;
        padding: 2rem;
        max-width: 380px;
        width: 90%;
        text-align: center;
        box-shadow: 0 20px 40px rgba(0, 0, 0, .15);
    }

    .modal-icon {
        font-size: 2.5rem;
        color: #f59e0b;
        margin-bottom: .75rem;
    }

    .modal-box h3 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1b2436;
        margin: 0 0 .5rem;
    }

    .modal-box p {
        color: #64748b;
        font-size: 0.875rem;
        margin-bottom: 1.5rem;
    }

    .modal-actions {
        display: flex;
        gap: .75rem;
        justify-content: center;
    }

    .btn-cancel-modal {
        padding: .6rem 1.3rem;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #fff;
        color: #64748b;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-confirm-delete {
        padding: .6rem 1.3rem;
        border-radius: 8px;
        background: #dc2626;
        color: #fff;
        border: none;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-confirm-delete:hover {
        background: #b91c1c;
    }
</style>

<script>
    const limit = 15;
    let offset = limit;
    const total = <?= $totalHistorial ?>;
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
                        <div class="notif-item" id="notif-${n.id}">
                            <div class="notif-icon ${colorClass}"><i class="${n.icono}"></i></div>
                            <div class="notif-body">
                                <div class="notif-mensaje">${n.mensaje}</div>
                                <div class="notif-fecha"><i class="fas fa-clock"></i> ${fecha}</div>
                            </div>
                            <span class="notif-tipo ${tipoClass}">${tipoLabel}</span>
                            <button class="btn-eliminar-notif" onclick="eliminarNotif(${n.id}, this)" title="Eliminar">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `);
                });
                offset += data.length;
                spinner.style.display = 'none';
                if (offset < total) {
                    btnCargar.style.display = 'block';
                } else {
                    btnCargar.textContent = 'No hay mas notificaciones';
                    btnCargar.disabled = true;
                    btnCargar.style.display = 'block';
                }
            } catch (err) {
                spinner.style.display = 'none';
                btnCargar.style.display = 'block';
            }
        });
    }

    async function eliminarNotif(id, btn) {
        try {
            const res = await fetch(`<?= base_url('notificaciones/eliminar/') ?>${id}`, {
                method: 'GET'
            });
            const data = await res.json();
            if (data.success) {
                const item = document.getElementById(`notif-${id}`);
                item.style.opacity = '0';
                item.style.transition = 'opacity .3s';
                setTimeout(() => item.remove(), 300);
            }
        } catch (e) {
            alert('Error al eliminar.');
        }
    }

    function confirmarLimpiar() {
        document.getElementById('modal-limpiar').style.display = 'flex';
    }

    async function ejecutarLimpiar() {
        document.getElementById('modal-limpiar').style.display = 'none';
        try {
            const res = await fetch('<?= base_url('notificaciones/limpiar-historial') ?>');
            const data = await res.json();
            if (data.success) {
                if (lista) lista.innerHTML = '';
                document.querySelector('.section-header .btn-limpiar')?.remove();
                const empty = document.createElement('div');
                empty.className = 'empty-state';
                empty.innerHTML = '<i class="fas fa-history"></i><p>No hay actividad registrada</p>';
                lista?.parentNode?.appendChild(empty);
                if (btnCargar) btnCargar.style.display = 'none';
            }
        } catch (e) {
            alert('Error al limpiar.');
        }
    }

    document.getElementById('modal-limpiar')?.addEventListener('click', function(e) {
        if (e.target === this) this.style.display = 'none';
    });

    function getColor(color) {
        return {
            success: 'success',
            danger: 'danger',
            primary: 'primary',
            info: 'info',
            warning: 'warning'
        } [color] ?? 'default';
    }

    function getTipoClass(tipo) {
        return {
            libro: 'tipo-libro',
            prestamo: 'tipo-prestamo',
            alumna: 'tipo-alumna'
        } [tipo] ?? 'tipo-default';
    }

    function getTipoLabel(tipo) {
        return {
            libro: 'Libro',
            prestamo: 'Prestamo',
            alumna: 'Alumna'
        } [tipo] ?? 'Sistema';
    }
</script>