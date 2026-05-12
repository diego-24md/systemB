<?php
if (! session()->get('alumna_id')) {
    return redirect()->to(base_url('login'));
}
$alumnaId     = session()->get('alumna_id');
$alumnaNombre = (string)(session()->get('alumna_nombre') ?? 'Alumna');
$libros       = $libros ?? [];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo — Biblioteca</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --ink: #1b2436;
            --ink-light: #4a5568;
            --teal: #0f6e56;
            --teal-mid: #1d9e75;
            --teal-pale: #e1f5ee;
            --amber: #ba7517;
            --amber-pale: #faeeda;
            --sand: #f7f4ef;
            --white: #ffffff;
            --border: rgba(27, 36, 54, .1);
            --shadow: 0 2px 12px rgba(27, 36, 54, .07);
            --shadow-lg: 0 8px 28px rgba(27, 36, 54, .13);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', system-ui, sans-serif;
            background: var(--sand);
            color: var(--ink);
            line-height: 1.5;
        }

        /* ── TOPBAR ─────────────────────────────── */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: var(--ink);
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 0 24px;
            height: 60px;
        }

        .topbar-logo {
            height: 36px;
            width: 31px;
            object-fit: cover;
            border-radius: 4px;
        }

        .topbar-brand {
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: -.01em;
            line-height: 1.25;
        }

        .topbar-brand small {
            display: block;
            font-size: 11px;
            font-weight: 300;
            color: rgba(255, 255, 255, .5);
        }

        .topbar-sep {
            flex: 1;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* botón corazón en topbar */
        .btn-fav-top {
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
            transition: background .18s;
        }

        .btn-fav-top:hover {
            background: rgba(255, 255, 255, .2);
        }

        .fav-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: var(--amber);
            color: #3b2500;
            font-size: 10px;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            border: 1.5px solid var(--ink);
        }

        /* menú usuario */
        .topbar-user {
            position: relative;
        }

        .btn-user {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .14);
            border-radius: 30px;
            padding: 6px 14px 6px 8px;
            cursor: pointer;
            color: #fff;
            font-size: 13px;
            font-weight: 500;
            font-family: inherit;
            white-space: nowrap;
            transition: background .2s;
        }

        .btn-user:hover {
            background: rgba(255, 255, 255, .16);
        }

        .btn-user i {
            font-size: 20px;
        }

        .user-dd {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: var(--white);
            border-radius: 14px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, .16);
            min-width: 200px;
            overflow: hidden;
            z-index: 200;
            border: 1px solid var(--border);
        }

        .user-dd.open {
            display: block;
        }

        .dd-head {
            padding: 14px 18px 12px;
            border-bottom: 1px solid var(--border);
            background: var(--sand);
        }

        .dd-head small {
            display: block;
            font-size: 11px;
            color: var(--ink-light);
            text-transform: uppercase;
            letter-spacing: .04em;
            margin-bottom: 2px;
        }

        .dd-head strong {
            font-size: 14px;
        }

        .dd-logout {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px;
            color: var(--teal);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: background .15s;
        }

        .dd-logout:hover {
            background: var(--teal-pale);
        }

        /* ── DRAWER FAVORITOS ───────────────────── */
        .drawer-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(27, 36, 54, .4);
            z-index: 300;
            backdrop-filter: blur(2px);
        }

        .drawer-overlay.open {
            display: block;
        }

        .drawer {
            position: fixed;
            top: 0;
            right: -420px;
            width: 380px;
            max-width: 96vw;
            height: 100%;
            background: var(--white);
            z-index: 400;
            display: flex;
            flex-direction: column;
            transition: right .3s cubic-bezier(.4, 0, .2, 1);
            border-left: 1px solid var(--border);
        }

        .drawer.open {
            right: 0;
        }

        .drawer-header {
            padding: 18px 20px 16px;
            border-bottom: 1px solid var(--border);
            background: var(--sand);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .drawer-header h2 {
            font-size: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .drawer-header h2 i {
            color: var(--teal);
        }

        .drawer-close {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--white);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 13px;
            color: var(--ink-light);
            transition: all .15s;
        }

        .drawer-close:hover {
            background: var(--teal-pale);
            color: var(--teal);
            border-color: var(--teal-mid);
        }

        .drawer-body {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
        }

        .drawer-vacio {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 220px;
            color: var(--ink-light);
            font-size: 13.5px;
            gap: 12px;
            text-align: center;
            line-height: 1.6;
        }

        .drawer-vacio i {
            font-size: 2.2rem;
            color: #ccc;
        }

        .fav-item {
            display: flex;
            gap: 12px;
            align-items: center;
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 12px;
            margin-bottom: 10px;
            background: var(--white);
            transition: border-color .15s, background .15s;
        }

        .fav-item:hover {
            background: var(--sand);
            border-color: rgba(27, 36, 54, .18);
        }

        .fav-thumb {
            width: 48px;
            height: 64px;
            border-radius: 7px;
            background: var(--sand);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
            color: #ccc;
            font-size: 1.2rem;
        }

        .fav-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .fav-info {
            flex: 1;
            min-width: 0;
        }

        .fav-titulo {
            font-size: 13px;
            font-weight: 600;
            color: var(--ink);
            line-height: 1.3;
            margin-bottom: 3px;
        }

        .fav-autor {
            font-size: 11.5px;
            color: var(--ink-light);
            margin-bottom: 8px;
        }

        .fav-ver {
            font-size: 11.5px;
            font-weight: 600;
            padding: 4px 12px;
            background: var(--teal);
            color: #fff;
            border-radius: 20px;
            text-decoration: none;
            display: inline-block;
            transition: background .18s;
        }

        .fav-ver:hover {
            background: var(--teal-mid);
        }

        .fav-remove {
            background: none;
            border: none;
            color: #ccc;
            font-size: 14px;
            cursor: pointer;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all .15s;
        }

        .fav-remove:hover {
            color: var(--teal);
            background: var(--teal-pale);
        }

        /* ── MAIN ───────────────────────────────── */
        .main {
            max-width: 1100px;
            margin: 0 auto;
            padding: 32px 24px 60px;
        }

        /* ── BUSCADOR HERO ──────────────────────── */
        .search-hero {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px 26px 22px;
            margin-bottom: 28px;
            box-shadow: var(--shadow);
        }

        .search-label {
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--ink-light);
            margin-bottom: 10px;
        }

        .search-wrap {
            position: relative;
        }

        .search-wrap i {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: var(--ink-light);
            pointer-events: none;
        }

        .search-wrap input {
            width: 100%;
            padding: 12px 44px 12px 16px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            background: var(--sand);
            color: var(--ink);
            transition: all .2s;
        }

        .search-wrap input:focus {
            border-color: var(--teal-mid);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(29, 158, 117, .1);
        }

        .search-wrap input::placeholder {
            color: #aaa;
        }

        /* filtros */
        .filtros-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 14px;
            padding-top: 14px;
            border-top: 1px solid var(--border);
        }

        .filtro-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 500;
            font-family: inherit;
            border: 1.5px solid var(--border);
            background: var(--white);
            color: var(--ink-light);
            cursor: pointer;
            transition: all .18s;
            white-space: nowrap;
        }

        .filtro-btn:hover {
            border-color: var(--teal-mid);
            color: var(--teal);
        }

        .filtro-btn.activo {
            background: var(--teal);
            border-color: var(--teal);
            color: #fff;
        }

        .filtro-btn .count {
            font-size: 11px;
            opacity: .7;
            font-weight: 400;
        }

        /* ── SECTION LABEL ──────────────────────── */
        .section-label {
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--ink-light);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── GRID ───────────────────────────────── */
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(178px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        /* ── BOOK CARD ──────────────────────────── */
        .book-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            position: relative;
            box-shadow: var(--shadow);
            transition: transform .25s, box-shadow .25s, border-color .25s;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(27, 36, 54, .18);
        }

        /* corazón flotante */
        .btn-fav-card {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .92);
            border: 1px solid rgba(0, 0, 0, .06);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #ccc;
            z-index: 5;
            transition: all .2s;
        }

        .btn-fav-card:hover {
            background: #fff;
            color: var(--teal);
            transform: scale(1.12);
            border-color: var(--teal-pale);
        }

        .btn-fav-card.activo {
            color: var(--teal);
        }

        .book-cover {
            height: 228px;
            background: var(--sand);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-bottom: 1px solid var(--border);
        }

        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .4s;
        }

        .book-card:hover .book-cover img {
            transform: scale(1.05);
        }

        .book-cover i {
            font-size: 3rem;
            color: #d0cdc7;
        }

        .book-info {
            padding: 14px 16px 16px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .book-title {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--ink);
            line-height: 1.35;
            margin-bottom: 5px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .book-author {
            font-size: 12px;
            color: var(--ink-light);
            margin-bottom: 14px;
            flex: 1;
        }

        .book-btn {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            font-family: inherit;
            padding: 9px 16px;
            background: var(--teal);
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
            letter-spacing: .01em;
            transition: background .2s, transform .15s;
        }

        .book-btn:hover {
            background: var(--teal-mid);
            transform: translateY(-1px);
        }

        .no-resultados {
            color: var(--ink-light);
            font-size: 14px;
            padding: 24px 0;
            text-align: center;
            grid-column: 1 / -1;
        }

        /* ── RESPONSIVE ─────────────────────────── */
        @media (max-width: 780px) {
            .main {
                padding: 24px 20px 48px;
            }

            .books-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 16px;
            }
        }

        @media (max-width: 520px) {
            .topbar {
                padding: 0 16px;
                gap: 10px;
            }

            .topbar-brand {
                font-size: 12.5px;
            }

            .topbar-brand small {
                display: none;
            }

            .btn-user span {
                display: none;
            }

            .btn-user {
                padding: 6px 10px;
                gap: 4px;
            }

            .main {
                padding: 20px 16px 48px;
            }

            .search-hero {
                padding: 18px 16px;
                border-radius: 14px;
            }

            .filtros-wrap {
                gap: 6px;
            }

            .filtro-btn {
                font-size: 12px;
                padding: 4px 12px;
            }

            .books-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .book-cover {
                height: 190px;
            }

            .book-info {
                padding: 12px 12px 14px;
            }

            .drawer {
                width: 100%;
                max-width: 100%;
            }
        }

        @media (max-width: 360px) {
            .books-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .book-cover {
                height: 160px;
            }

            .book-title {
                font-size: 12.5px;
            }
        }
    </style>
</head>

<body>

    <!-- ── DRAWER FAVORITOS ──────────────────── -->
    <div class="drawer-overlay" id="drawerOverlay"></div>
    <div class="drawer" id="drawer">
        <div class="drawer-header">
            <h2><i class="fas fa-heart"></i> Mis favoritos <span id="drawer-count" style="font-size:12px;color:var(--ink-light);font-weight:400;"></span></h2>
            <button class="drawer-close" id="drawerClose"><i class="fas fa-xmark"></i></button>
        </div>
        <div class="drawer-body" id="drawerBody">
            <div class="drawer-vacio" id="drawerVacio">
                <i class="fa-regular fa-heart"></i>
                <p>Aún no tienes favoritos.<br>¡Presiona el corazón en cualquier libro!</p>
            </div>
        </div>
    </div>

    <!-- ── TOPBAR ────────────────────────────── -->
    <header class="topbar">
        <img src="<?= base_url('/img/insignia.jpg') ?>" alt="Logo" class="topbar-logo">
        <div class="topbar-brand">
            Institución Educativa Chinchaysuyo
            <small>Biblioteca escolar</small>
        </div>
        <div class="topbar-sep"></div>
        <div class="topbar-actions">
            <button class="btn-fav-top" id="btnAbrirFav" title="Mis favoritos">
                <i class="fas fa-heart"></i>
                <span class="fav-badge" id="favBadge"></span>
            </button>
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
                    <a href="<?= base_url('alumnas/logout') ?>" class="dd-logout">
                        <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- ── CONTENIDO ─────────────────────────── -->
    <div class="main">

        <!-- Buscador + filtros -->
        <div class="search-hero">
            <p class="search-label">Buscar libros</p>
            <div class="search-wrap">
                <i class="fas fa-magnifying-glass"></i>
                <input type="text" id="buscador" placeholder="Buscar por título o autor…">
            </div>

            <?php
            $categorias = [];
            foreach ($libros as $l) {
                $id  = $l['idcategoria'] ?? null;
                $nom = $l['categoria']   ?? null;
                if ($id && $nom && !isset($categorias[$id])) {
                    $categorias[$id] = ['nombre' => $nom, 'count' => 0];
                }
                if ($id) $categorias[$id]['count']++;
            }
            ?>
            <?php if (!empty($categorias)): ?>
                <div class="filtros-wrap" id="filtrosWrap">
                    <button class="filtro-btn activo" data-cat="todos">
                        Todos <span class="count">(<?= count($libros) ?>)</span>
                    </button>
                    <?php foreach ($categorias as $id => $cat): ?>
                        <button class="filtro-btn" data-cat="<?= (int)$id ?>">
                            <?= esc((string)$cat['nombre']) ?> <span class="count">(<?= $cat['count'] ?>)</span>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Resultados de búsqueda (se llena dinámicamente) -->
        <div id="resultados" class="books-grid"></div>

        <!-- Grid principal -->
        <p class="section-label" id="label-todos">Todos los libros</p>
        <div class="books-grid" id="grid">
            <?php if (!empty($libros)): ?>
                <?php foreach ($libros as $libro): ?>
                    <div class="book-card"
                        data-id="<?= (int)($libro['idrecurso'] ?? 0) ?>"
                        data-titulo="<?= strtolower(esc((string)($libro['titulo'] ?? ''))) ?>"
                        data-autor="<?= strtolower(esc((string)($libro['autores'] ?? ''))) ?>"
                        data-portada="<?= esc((string)($libro['portada'] ?? '')) ?>"
                        data-autortxt="<?= esc((string)($libro['autores'] ?? 'Sin autor')) ?>"
                        data-titulotxt="<?= esc((string)($libro['titulo'] ?? '')) ?>"
                        data-categoria="<?= (int)($libro['idcategoria'] ?? 0) ?>">

                        <button class="btn-fav-card" data-id="<?= (int)($libro['idrecurso'] ?? 0) ?>" title="Agregar a favoritos">
                            <i class="fa-regular fa-heart"></i>
                        </button>

                        <div class="book-cover">
                            <?php if (!empty($libro['portada']) && file_exists('uploads/portadas/' . $libro['portada'])): ?>
                                <img src="<?= base_url('uploads/portadas/' . $libro['portada']) ?>"
                                    alt="<?= esc((string)($libro['titulo'] ?? '')) ?>">
                            <?php else: ?>
                                <i class="fas fa-book fa-3x"></i>
                            <?php endif; ?>
                        </div>

                        <div class="book-info">
                            <p class="book-title"><?= esc((string)($libro['titulo'] ?? '')) ?></p>
                            <p class="book-author"><?= esc((string)($libro['autores'] ?? 'Sin autor')) ?></p>
                            <a href="<?= base_url('biblioteca/detalle/' . ($libro['idrecurso'] ?? '')) ?>" class="book-btn">Ver detalle</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div><!-- /main -->

    <script>
        /* ── menú usuario ──────────────────────── */
        const userBtn = document.getElementById('userBtn');
        const userDd = document.getElementById('userDd');
        userBtn.addEventListener('click', e => {
            e.stopPropagation();
            const open = userDd.classList.toggle('open');
            userBtn.setAttribute('aria-expanded', open);
        });
        document.addEventListener('click', () => {
            userDd.classList.remove('open');
            userBtn.setAttribute('aria-expanded', false);
        });

        /* ── drawer ─────────────────────────────── */
        const drawer = document.getElementById('drawer');
        const drawerOverlay = document.getElementById('drawerOverlay');
        const drawerBody = document.getElementById('drawerBody');
        const drawerVacio = document.getElementById('drawerVacio');
        const drawerCount = document.getElementById('drawer-count');
        const favBadge = document.getElementById('favBadge');

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

        /* ── buscador ───────────────────────────── */
        const input = document.getElementById('buscador');
        const resultados = document.getElementById('resultados');
        const grid = document.getElementById('grid');
        const labelTodos = document.getElementById('label-todos');

        input.addEventListener('input', function() {
            const q = this.value.trim();
            if (!q) {
                resultados.innerHTML = '';
                grid.style.display = '';
                labelTodos.style.display = '';
                return;
            }
            grid.style.display = 'none';
            labelTodos.style.display = 'none';

            fetch("<?= base_url('buscar-libros') ?>?q=" + encodeURIComponent(q))
                .then(r => r.json())
                .then(data => {
                    if (!Array.isArray(data)) {
                        resultados.innerHTML = '<p class="no-resultados">Error en el servidor.</p>';
                        return;
                    }
                    if (!data.length) {
                        resultados.innerHTML = `<p class="no-resultados">Sin resultados para "<strong>${q}</strong>".</p>`;
                        return;
                    }
                    resultados.innerHTML = data.map(l => `
                        <div class="book-card" data-id="${l.idrecurso}"
                             data-portada="${l.portada ?? ''}"
                             data-autortxt="${l.autores ?? 'Sin autor'}"
                             data-titulotxt="${l.titulo}">
                            <button class="btn-fav-card ${favIds.has(Number(l.idrecurso)) ? 'activo' : ''}" data-id="${l.idrecurso}">
                                <i class="fa-${favIds.has(Number(l.idrecurso)) ? 'solid' : 'regular'} fa-heart"></i>
                            </button>
                            <div class="book-cover">
                                ${l.portada ? `<img src="/uploads/portadas/${l.portada}" alt="${l.titulo}">` : `<i class="fas fa-book fa-3x"></i>`}
                            </div>
                            <div class="book-info">
                                <p class="book-title">${l.titulo}</p>
                                <p class="book-author">${l.autores ?? 'Sin autor'}</p>
                                <a href="/biblioteca/detalle/${l.idrecurso}" class="book-btn">Ver detalle</a>
                            </div>
                        </div>
                    `).join('');
                    bindFavCards(resultados);
                })
                .catch(() => {
                    resultados.innerHTML = '<p class="no-resultados">Error de conexión.</p>';
                });
        }, true);

        /* ── favoritos ──────────────────────────── */
        let favIds = new Set();
        let favData = {};

        fetch("<?= base_url('favoritos/ids') ?>")
            .then(r => r.json())
            .then(ids => {
                favIds = new Set(ids.map(Number));
                marcarCorazones();
                actualizarBadge();
                renderDrawer();
            }).catch(() => {});

        function marcarCorazones() {
            document.querySelectorAll('.btn-fav-card').forEach(btn => {
                favIds.has(Number(btn.dataset.id)) ? activarBtn(btn) : desactivarBtn(btn);
            });
        }

        function activarBtn(btn) {
            btn.classList.add('activo');
            btn.querySelector('i').className = 'fa-solid fa-heart';
            btn.title = 'Quitar de favoritos';
        }

        function desactivarBtn(btn) {
            btn.classList.remove('activo');
            btn.querySelector('i').className = 'fa-regular fa-heart';
            btn.title = 'Agregar a favoritos';
        }

        function actualizarBadge() {
            const n = favIds.size;
            if (n > 0) {
                favBadge.textContent = n;
                favBadge.style.display = 'flex';
            } else {
                favBadge.style.display = 'none';
            }
            drawerCount.textContent = n > 0 ? `(${n})` : '';
        }

        function renderDrawer() {
            Array.from(drawerBody.children).forEach(el => {
                if (el.id !== 'drawerVacio') el.remove();
            });
            if (!favIds.size) {
                drawerVacio.style.display = 'flex';
                return;
            }
            drawerVacio.style.display = 'none';

            favIds.forEach(id => {
                let d = favData[id];
                if (!d) {
                    const card = document.querySelector(`.book-card[data-id="${id}"]`);
                    if (card) {
                        d = {
                            titulo: card.dataset.titulotxt || '—',
                            autor: card.dataset.autortxt || 'Sin autor',
                            portada: card.dataset.portada || '',
                            id
                        };
                        favData[id] = d;
                    }
                }
                if (!d) return;

                const item = document.createElement('div');
                item.className = 'fav-item';
                item.dataset.id = id;
                item.innerHTML = `
                    <div class="fav-thumb">
                        ${d.portada ? `<img src="/uploads/portadas/${d.portada}" alt="${d.titulo}">` : `<i class="fas fa-book"></i>`}
                    </div>
                    <div class="fav-info">
                        <div class="fav-titulo">${d.titulo}</div>
                        <div class="fav-autor">${d.autor}</div>
                        <a href="/biblioteca/detalle/${id}" class="fav-ver">Ver detalle</a>
                    </div>
                    <button class="fav-remove" data-id="${id}" title="Quitar"><i class="fas fa-xmark"></i></button>
                `;
                item.querySelector('.fav-remove').addEventListener('click', () => toggleFav(id));
                drawerBody.appendChild(item);
            });
        }

        function bindFavCards(container) {
            container.querySelectorAll('.btn-fav-card').forEach(btn => {
                btn.addEventListener('click', e => {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleFav(Number(btn.dataset.id));
                });
            });
        }

        function toggleFav(idrecurso) {
            fetch("<?= base_url('favoritos/toggle') ?>", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        idrecurso
                    })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.favorito) favIds.add(idrecurso);
                    else {
                        favIds.delete(idrecurso);
                        delete favData[idrecurso];
                    }
                    marcarCorazones();
                    actualizarBadge();
                    renderDrawer();
                })
                .catch(() => alert('Error al actualizar favoritos.'));
        }

        bindFavCards(grid);

        /* ── filtros por categoría ──────────────── */
        let filtroActual = 'todos';
        document.querySelectorAll('.filtro-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                if (input.value.trim()) {
                    input.value = '';
                    resultados.innerHTML = '';
                    grid.style.display = '';
                    labelTodos.style.display = '';
                }
                filtroActual = btn.dataset.cat;
                document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('activo'));
                btn.classList.add('activo');
                grid.querySelectorAll('.book-card').forEach(card => {
                    card.style.display = (filtroActual === 'todos' || card.dataset.categoria === filtroActual) ? '' : 'none';
                });
            });
        });
    </script>

</body>

</html>