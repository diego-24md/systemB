<!-- BARRA DE NAVEGACIÓN INFERIOR (solo celular) -->
<nav class="bottom-nav">
    <a href="<?= base_url('catalogo') ?>"
        class="bottom-nav-item <?= (uri_string() === 'catalogo') ? 'activo' : '' ?>">
        <i class="fas fa-home"></i>
        <span>Inicio</span>
    </a>

    <a href="<?= base_url('biblioteca/mis-reservas') ?>"
        class="bottom-nav-item <?= (uri_string() === 'biblioteca/mis-reservas') ? 'activo' : '' ?>">
        <i class="fas fa-clipboard-list"></i>
        <span>Reservas</span>
    </a>

    <a href="<?= base_url('biblioteca/notificaciones') ?>"
        class="bottom-nav-item <?= (uri_string() === 'biblioteca/notificaciones') ? 'activo' : '' ?>"
        style="position:relative;">
        <i class="fas fa-bell"></i>
        <span>Avisos</span>
        <span class="bottom-notif-badge" id="bottomNotifBadge"
            style="display:none;position:absolute;top:4px;right:18px;background:#c0392b;color:#fff;font-size:9px;border-radius:999px;min-width:14px;height:14px;align-items:center;justify-content:center;padding:0 3px;">
        </span>
    </a>

    <a href="<?= base_url('biblioteca/ranking') ?>"
        class="bottom-nav-item <?= (uri_string() === 'biblioteca/ranking') ? 'activo' : '' ?>">
        <i class="fas fa-trophy"></i>
        <span>Ranking</span>
    </a>
</nav>

<style>
    .bottom-nav {
        display: none;
    }

    @media (max-width: 767px) {
        .bottom-nav {
            display: flex;
            justify-content: space-around;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #12203a;
            border-top: 1px solid rgba(255, 255, 255, .1);
            z-index: 999;
            padding: 6px 0 14px;
        }

        .main-content {
            padding-bottom: 70px;
        }
    }

    .bottom-nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 3px;
        color: rgba(255, 255, 255, .5);
        text-decoration: none;
        font-size: 11px;
        font-family: 'DM Sans', sans-serif;
        padding: 4px 16px;
        border-radius: 8px;
        transition: color .18s;
        position: relative;
    }

    .bottom-nav-item i {
        font-size: 20px;
    }

    .bottom-nav-item.activo {
        color: #fff;
    }

    .bottom-nav-item.activo i {
        color: #e74c3c;
    }

    .bottom-nav-item:hover {
        color: #fff;
    }
</style>

<script>
    // Badge notificaciones en barra inferior
    fetch("<?= base_url('biblioteca/notificaciones/sin-leer') ?>")
        .then(r => r.json())
        .then(data => {
            const badge = document.getElementById('bottomNotifBadge');
            if (badge && data.count > 0) {
                badge.textContent = data.count;
                badge.style.display = 'flex';
            }
        }).catch(() => {});
</script>