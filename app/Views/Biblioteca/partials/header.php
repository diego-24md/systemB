<?php
if (! session()->get('alumna_id')) {
    return redirect()->to(base_url('login'));
}
$alumnaNombre = (string)(session()->get('alumna_nombre') ?? 'Alumna');
?>

<!-- DRAWER FAVORITOS -->
<div class="drawer-overlay" id="drawerOverlay"></div>
<div class="drawer" id="drawer">
    <div class="drawer-header">
        <h2>
            <i class="fas fa-heart"></i> Mis favoritos
            <span id="drawer-count" style="font-size:12px;color:var(--ink-light);font-weight:400;"></span>
        </h2>
        <button class="drawer-close" id="drawerClose">
            <i class="fas fa-xmark"></i>
        </button>
    </div>
    <div class="drawer-body" id="drawerBody">
        <div class="drawer-vacio" id="drawerVacio">
            <i class="fa-regular fa-heart"></i>
            <p>Aún no tienes favoritos.<br>¡Presiona el corazón en cualquier libro!</p>
        </div>
    </div>
</div>

<!-- TOPBAR -->
<header class="topbar">
    <img src="<?= base_url('/img/insignia.jpg') ?>" alt="Logo" class="topbar-logo">

    <div class="topbar-brand">
        Institución Educativa Chinchaysuyo
        <small>Biblioteca escolar</small>
    </div>

    <div class="topbar-sep"></div>

    <div class="topbar-actions">

        <!-- Favoritos (visible en PC y celular) -->
        <button class="btn-fav-top" id="btnAbrirFav" title="Mis favoritos">
            <i class="fas fa-heart"></i>
            <span class="fav-badge" id="favBadge"></span>
        </button>

        <!-- Solo visible en PC -->
        <div class="topbar-pc-only">

            <!-- Dropdown usuario -->
            <div class="topbar-user">
                <button class="btn-user" id="userBtn" aria-expanded="false">
                    <i class="fa-solid fa-circle-user"></i>
                    <span><?= htmlspecialchars($alumnaNombre) ?></span>
                    <i class="fa-solid fa-chevron-down" style="font-size:10px;opacity:.6;margin-left:2px;"></i>
                </button>
                <div class="user-dd" id="userDd">
                    <div class="dd-head">
                        <small>Conectada como</small>
                        <strong><?= htmlspecialchars($alumnaNombre) ?></strong>
                    </div>
                    <a href="<?= base_url('biblioteca/mis-reservas') ?>" class="dd-link">
                        <i class="fa-solid fa-clipboard-list"></i> Mis reservas
                    </a>
                    <a href="<?= base_url('biblioteca/notificaciones') ?>" class="dd-link">
                        <i class="fa-solid fa-bell"></i> Notificaciones
                        <span id="ddNotifBadge" style="display:none;background:#c0392b;color:#fff;font-size:10px;border-radius:999px;padding:1px 6px;margin-left:auto;"></span>
                    </a>
                    <a href="<?= base_url('biblioteca/ranking') ?>" class="dd-link">
                        <i class="fa-solid fa-trophy"></i> Ranking
                    </a>
                    <div class="dd-divider"></div>
                    <a href="<?= base_url('alumnas/logout') ?>" class="dd-logout">
                        <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión
                    </a>
                </div>
            </div>

        </div>

        <!-- Solo visible en celular: botón perfil -->
        <div class="topbar-movil-only">
            <button class="btn-ranking-top" id="userBtnMovil" title="Mi perfil">
                <i class="fa-solid fa-circle-user"></i>
            </button>
            <div class="user-dd" id="userDdMovil">
                <div class="dd-head">
                    <small>Conectada como</small>
                    <strong><?= htmlspecialchars($alumnaNombre) ?></strong>
                </div>
                <div class="dd-divider"></div>
                <a href="<?= base_url('alumnas/logout') ?>" class="dd-logout">
                    <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión
                </a>
            </div>
        </div>

    </div>
</header>

<style>
    .btn-ranking-top {
        position: relative;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .1);
        border: 1px solid rgba(255, 255, 255, .18);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #fff;
        font-size: 16px;
        text-decoration: none;
        transition: background .18s;
    }

    .btn-ranking-top:hover {
        background: rgba(255, 255, 255, .2);
        color: #fff;
    }

    .dd-link {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 9px 16px;
        font-size: 13px;
        color: var(--ink);
        text-decoration: none;
        transition: background .15s;
    }

    .dd-link:hover {
        background: var(--surface);
    }

    .dd-divider {
        height: 0.5px;
        background: var(--border);
        margin: 4px 0;
    }

    /* PC: mostrar sección PC, ocultar sección móvil */
    @media (min-width: 768px) {
        .topbar-pc-only {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar-movil-only {
            display: none;
        }
    }

    /* Celular: ocultar sección PC, mostrar sección móvil */
    @media (max-width: 767px) {
        .topbar-pc-only {
            display: none;
        }

        .topbar-movil-only {
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
        }
    }
</style>

<script>
    // Dropdown PC
    const userBtn = document.getElementById('userBtn');
    const userDd = document.getElementById('userDd');
    if (userBtn) {
        userBtn.addEventListener('click', e => {
            e.stopPropagation();
            const open = userDd.classList.toggle('open');
            userBtn.setAttribute('aria-expanded', open);
        });
    }

    // Dropdown móvil (solo perfil + cerrar sesión)
    const userBtnMovil = document.getElementById('userBtnMovil');
    const userDdMovil = document.getElementById('userDdMovil');
    if (userBtnMovil) {
        userBtnMovil.addEventListener('click', e => {
            e.stopPropagation();
            userDdMovil.classList.toggle('open');
        });
    }

    document.addEventListener('click', () => {
        userDd?.classList.remove('open');
        userDdMovil?.classList.remove('open');
        userBtn?.setAttribute('aria-expanded', false);
    });

    // Drawer favoritos
    const drawer = document.getElementById('drawer');
    const drawerOverlay = document.getElementById('drawerOverlay');
    document.getElementById('btnAbrirFav').addEventListener('click', e => {
        e.stopPropagation();
        drawer.classList.add('open');
        drawerOverlay.classList.add('open');
    });
    document.getElementById('drawerClose').addEventListener('click', cerrarDrawer);
    drawerOverlay.addEventListener('click', cerrarDrawer);

    function cerrarDrawer() {
        drawer.classList.remove('open');
        drawerOverlay.classList.remove('open');
    }

    // Badge notificaciones
    fetch("<?= base_url('biblioteca/notificaciones/sin-leer') ?>")
        .then(r => r.json())
        .then(data => {
            if (data.count > 0) {
                const b1 = document.getElementById('notifBadge');
                const b2 = document.getElementById('ddNotifBadge');
                if (b1) {
                    b1.textContent = data.count;
                    b1.style.display = 'flex';
                }
                if (b2) {
                    b2.textContent = data.count;
                    b2.style.display = 'inline';
                }
            }
        }).catch(() => {});
</script>