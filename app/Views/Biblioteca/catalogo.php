<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Catálogo de Libros</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">

    <style>
        :root {
            --rojo: #b8001e;
            --rojo-dark: #8f0017;
            --rojo-light: #fff0f2;
            --dorado: #d4a017;
            --dorado-light: #fdf6e3;
            --gris-fondo: #f4f3f0;
            --gris-borde: #e4e2dc;
            --gris-texto: #6b6860;
            --texto: #1c1b19;
            --blanco: #ffffff;
            --radio: 12px;
            --radio-lg: 18px;
            --sombra: 0 2px 12px rgba(0, 0, 0, 0.07);
            --sombra-hover: 0 8px 28px rgba(0, 0, 0, 0.13);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', system-ui, sans-serif;
            background: var(--gris-fondo);
            color: var(--texto);
            line-height: 1.5;
        }

        /* ==================== HEADER ==================== */
        .header {
            background: var(--rojo);
            padding: 0 28px;
            display: flex;
            align-items: center;
            gap: 16px;
            height: 64px;
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 3px solid var(--dorado);
        }

        .header-divider {
            width: 1px;
            height: 28px;
            background: rgba(255, 255, 255, 0.2);
            margin: 0 4px;
        }

        .header img {
            height: 50px;
            width: 50px;
            object-fit: contain;
            border-radius: 6px;
            border: 1.5px solid rgba(255, 255, 255, 0.3);
        }

        .header-text h1 {
            color: white;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: -0.01em;
        }

        .header-text p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 11.5px;
            font-weight: 400;
        }

        .header-actions {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ===== BOTÓN FAVORITOS EN HEADER ===== */
        .btn-fav-header {
            position: relative;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: white;
            font-size: 16px;
            transition: background 0.18s;
        }

        .btn-fav-header:hover {
            background: rgba(255, 255, 255, 0.22);
        }

        .fav-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--dorado);
            color: #5a3a00;
            font-size: 10px;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            border: 1.5px solid var(--rojo);
        }

        /* ===== MENÚ DE USUARIO ===== */
        .user-menu-wrap {
            position: relative;
        }

        .user-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            padding: 6px 13px 6px 8px;
            cursor: pointer;
            color: white;
            font-size: 13px;
            font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            transition: background 0.18s;
            white-space: nowrap;
        }

        .user-btn:hover {
            background: rgba(255, 255, 255, 0.22);
        }

        .user-btn i {
            font-size: 17px;
        }

        .user-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: var(--blanco);
            border-radius: var(--radio-lg);
            box-shadow: 0 12px 36px rgba(0, 0, 0, 0.14);
            min-width: 200px;
            z-index: 200;
            overflow: hidden;
            border: 1px solid var(--gris-borde);
            animation: fadeDown 0.16s ease;
        }

        @keyframes fadeDown {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .user-dropdown.open {
            display: block;
        }

        .dropdown-header {
            padding: 14px 16px 10px;
            border-bottom: 1px solid var(--gris-borde);
            background: var(--gris-fondo);
        }

        .dropdown-header span {
            display: block;
            font-size: 11px;
            color: var(--gris-texto);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 2px;
        }

        .dropdown-header strong {
            font-size: 14px;
            color: var(--texto);
            font-weight: 600;
        }

        .dropdown-logout {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            color: var(--rojo);
            font-size: 13.5px;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.15s;
        }

        .dropdown-logout:hover {
            background: var(--rojo-light);
        }

        /* ==================== DRAWER FAVORITOS ==================== */
        .drawer-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            z-index: 300;
            animation: fadeIn 0.2s ease;
            backdrop-filter: blur(2px);
        }

        .drawer-overlay.open {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .drawer {
            position: fixed;
            top: 0;
            right: -420px;
            width: 380px;
            max-width: 95vw;
            height: 100%;
            background: var(--blanco);
            z-index: 400;
            display: flex;
            flex-direction: column;
            transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 1px solid var(--gris-borde);
        }

        .drawer.open {
            right: 0;
        }

        .drawer-header {
            padding: 20px 20px 16px;
            border-bottom: 1px solid var(--gris-borde);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
            background: var(--gris-fondo);
        }

        .drawer-header h2 {
            font-size: 15px;
            font-weight: 600;
            color: var(--texto);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .drawer-header h2 i {
            color: var(--rojo);
        }

        .drawer-close {
            background: var(--blanco);
            border: 1px solid var(--gris-borde);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 13px;
            color: var(--gris-texto);
            transition: all 0.15s;
        }

        .drawer-close:hover {
            background: var(--rojo-light);
            color: var(--rojo);
            border-color: #f5c0c8;
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
            color: #bbb;
            font-size: 13.5px;
            gap: 12px;
            text-align: center;
            line-height: 1.6;
        }

        .drawer-vacio i {
            font-size: 2.2rem;
            color: #ddd;
        }

        .fav-drawer-item {
            display: flex;
            gap: 12px;
            align-items: center;
            padding: 12px;
            border: 1px solid var(--gris-borde);
            border-radius: var(--radio);
            margin-bottom: 10px;
            transition: background 0.15s, border-color 0.15s;
            background: var(--blanco);
        }

        .fav-drawer-item:hover {
            background: var(--gris-fondo);
            border-color: #d0cec8;
        }

        .fav-drawer-cover {
            width: 50px;
            height: 66px;
            border-radius: 7px;
            overflow: hidden;
            background: var(--gris-fondo);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--gris-borde);
        }

        .fav-drawer-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .fav-drawer-cover i {
            font-size: 1.3rem;
            color: #ccc;
        }

        .fav-drawer-info {
            flex: 1;
        }

        .fav-drawer-titulo {
            font-size: 13px;
            font-weight: 600;
            color: var(--texto);
            line-height: 1.3;
            margin-bottom: 3px;
        }

        .fav-drawer-autor {
            font-size: 11.5px;
            color: var(--gris-texto);
            margin-bottom: 8px;
        }

        .fav-drawer-btn {
            font-size: 11.5px;
            font-weight: 600;
            padding: 4px 12px;
            background: var(--rojo);
            color: white;
            border-radius: 20px;
            text-decoration: none;
            display: inline-block;
            transition: background 0.18s;
            letter-spacing: 0.01em;
        }

        .fav-drawer-btn:hover {
            background: var(--rojo-dark);
        }

        .fav-drawer-remove {
            background: none;
            border: none;
            color: #ccc;
            font-size: 14px;
            cursor: pointer;
            padding: 4px;
            transition: color 0.15s;
            flex-shrink: 0;
            border-radius: 50%;
            width: 26px;
            height: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .fav-drawer-remove:hover {
            color: var(--rojo);
            background: var(--rojo-light);
        }

        /* ==================== MAIN ==================== */
        .main {
            max-width: 1100px;
            margin: 0 auto;
            padding: 36px 24px;
        }

        /* ==================== HERO BUSCADOR ==================== */
        .search-hero {
            background: var(--blanco);
            border: 1px solid var(--gris-borde);
            border-radius: var(--radio-lg);
            padding: 28px 28px 24px;
            margin-bottom: 32px;
            box-shadow: var(--sombra);
        }

        .search-hero-label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: var(--gris-texto);
            margin-bottom: 10px;
        }

        .search-wrap {
            position: relative;
        }

        .search-wrap i.fa-magnifying-glass {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: var(--gris-texto);
            pointer-events: none;
        }

        .search-wrap input {
            width: 100%;
            padding: 12px 44px 12px 16px;
            border: 1.5px solid var(--gris-borde);
            border-radius: var(--radio);
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            outline: none;
            background: var(--gris-fondo);
            color: var(--texto);
            transition: all 0.2s ease;
        }

        .search-wrap input:focus {
            border-color: var(--rojo);
            background: var(--blanco);
            box-shadow: 0 0 0 3px rgba(184, 0, 30, 0.08);
        }

        .search-wrap input::placeholder {
            color: #aaa;
        }

        /* ==================== SECTION LABEL ==================== */
        .section-label {
            font-size: 11.5px;
            font-weight: 600;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: var(--gris-texto);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--gris-borde);
        }

        /* ==================== GRID DE LIBROS ==================== */
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(178px, 1fr));
            gap: 20px;
        }

        .book-card {
            background: var(--blanco);
            border: 1px solid var(--gris-borde);
            border-radius: var(--radio-lg);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
            box-shadow: var(--sombra);
            position: relative;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--sombra-hover);
            border-color: #d0cec8;
        }

        .btn-fav {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(0, 0, 0, 0.06);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #ccc;
            transition: all 0.2s ease;
            z-index: 5;
        }

        .btn-fav:hover {
            background: white;
            color: var(--rojo);
            transform: scale(1.12);
            border-color: #f5c0c8;
        }

        .btn-fav.activo {
            color: var(--rojo);
        }

        .book-cover {
            height: 230px;
            background: var(--gris-fondo);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-bottom: 1px solid var(--gris-borde);
        }

        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .book-card:hover .book-cover img {
            transform: scale(1.05);
        }

        .book-cover i.fas {
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
            color: var(--texto);
            line-height: 1.35;
            margin-bottom: 5px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .book-author {
            font-size: 12px;
            color: var(--gris-texto);
            margin-bottom: 14px;
            flex: 1;
        }

        .book-btn {
            display: block;
            margin-top: auto;
            font-size: 12.5px;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            padding: 9px 16px;
            background: var(--rojo);
            color: white;
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
            transition: background 0.2s ease, transform 0.15s ease;
            letter-spacing: 0.01em;
        }

        .book-btn:hover {
            background: var(--rojo-dark);
            transform: translateY(-1px);
        }

        .no-resultados {
            color: var(--gris-texto);
            font-size: 14px;
            padding: 24px 0;
            text-align: center;
            grid-column: 1 / -1;
        }

        /* ==================== FILTROS ==================== */
        .filtros-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 14px;
            padding-top: 14px;
            border-top: 1px solid var(--gris-borde);
        }

        .filtro-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            border: 1.5px solid var(--gris-borde);
            background: var(--blanco);
            color: var(--gris-texto);
            cursor: pointer;
            transition: all 0.18s ease;
            white-space: nowrap;
        }

        .filtro-btn:hover {
            border-color: var(--rojo);
            color: var(--rojo);
        }

        .filtro-btn.activo {
            background: var(--rojo);
            border-color: var(--rojo);
            color: white;
        }

        .filtro-btn .count {
            font-size: 11px;
            opacity: 0.75;
            font-weight: 400;
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 640px) {
            .header {
                padding: 0 16px;
                height: 58px;
            }

            .books-grid {
                grid-template-columns: repeat(auto-fill, minmax(155px, 1fr));
                gap: 14px;
            }

            .book-cover {
                height: 200px;
            }

            .user-btn span {
                display: none;
            }

            .drawer {
                width: 100%;
                max-width: 100%;
            }

            .main {
                padding: 24px 16px;
            }

            .search-hero {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <?php
    if (! session()->get('alumna_id')) {
        return redirect()->to(base_url('login'));
    }

    $alumnaId     = session()->get('alumna_id');
    $alumnaNombre = (string)(session()->get('alumna_nombre') ?? 'Alumna');
    $libros       = $libros ?? [];
    ?>

    <!-- ==================== DRAWER FAVORITOS ==================== -->
    <div class="drawer-overlay" id="drawerOverlay"></div>

    <div class="drawer" id="drawerFav">
        <div class="drawer-header">
            <h2><i class="fa-solid fa-heart"></i> Mis favoritos <span id="drawer-count" style="font-size:12px;color:#999;font-weight:400;"></span></h2>
            <button class="drawer-close" id="drawerClose"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="drawer-body" id="drawerBody">
            <div class="drawer-vacio" id="drawerVacio">
                <i class="fa-regular fa-heart"></i>
                <p>Aún no tienes favoritos.<br>¡Presiona el corazón en cualquier libro!</p>
            </div>
        </div>
    </div>

    <!-- ==================== HEADER ==================== -->
    <div class="header">
        <img src="<?= base_url('/img/insignia.jpg') ?>" alt="Logo">
        <div class="header-divider"></div>
        <div class="header-text">
            <h1>Institución Educativa Chinchaysuyo</h1>
            <p>Biblioteca escolar</p>
        </div>

        <div class="header-actions">
            <!-- Botón favoritos -->
            <button class="btn-fav-header" id="btnAbrirFav" title="Mis favoritos">
                <i class="fa-solid fa-heart"></i>
                <span class="fav-badge" id="favBadge"></span>
            </button>

            <!-- Menú de usuario -->
            <div class="user-menu-wrap">
                <button class="user-btn" id="userBtn" aria-expanded="false">
                    <i class="fa-solid fa-circle-user"></i>
                    <span><?= htmlspecialchars($alumnaNombre) ?></span>
                    <i class="fa-solid fa-chevron-down" style="font-size:10px;opacity:0.6;"></i>
                </button>
                <div class="user-dropdown" id="userDropdown">
                    <div class="dropdown-header">
                        <span>Conectada como</span>
                        <strong><?= htmlspecialchars($alumnaNombre) ?></strong>
                    </div>
                    <a href="<?= base_url('alumnas/logout') ?>" class="dropdown-logout">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Cerrar sesión
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== CONTENIDO ==================== -->
    <div class="main">

        <div class="search-hero">
            <p class="search-hero-label">Buscar libros</p>
            <div class="search-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="buscador" placeholder="Buscar por título o autor…">
            </div>

            <!-- Filtros dinámicos generados desde PHP -->
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

        <div id="resultados" class="books-grid" style="margin-bottom: 32px;"></div>

        <p class="section-label" id="label-recomendados">Todos los libros</p>
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

                        <button class="btn-fav" data-id="<?= (int)($libro['idrecurso'] ?? 0) ?>" title="Agregar a favoritos">
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

    </div>

    <script>
        // ─── MENÚ DE USUARIO ────────────────────────────────────────────────
        const userBtn = document.getElementById('userBtn');
        const userDropdown = document.getElementById('userDropdown');

        userBtn.addEventListener('click', e => {
            e.stopPropagation();
            const open = userDropdown.classList.toggle('open');
            userBtn.setAttribute('aria-expanded', open);
        });

        document.addEventListener('click', () => {
            userDropdown.classList.remove('open');
            userBtn.setAttribute('aria-expanded', false);
        });

        // ─── DRAWER FAVORITOS ────────────────────────────────────────────────
        const drawerFav = document.getElementById('drawerFav');
        const drawerOverlay = document.getElementById('drawerOverlay');
        const drawerBody = document.getElementById('drawerBody');
        const drawerVacio = document.getElementById('drawerVacio');
        const drawerCount = document.getElementById('drawer-count');
        const favBadge = document.getElementById('favBadge');

        document.getElementById('btnAbrirFav').addEventListener('click', e => {
            e.stopPropagation();
            drawerFav.classList.add('open');
            drawerOverlay.classList.add('open');
        });

        document.getElementById('drawerClose').addEventListener('click', cerrarDrawer);
        drawerOverlay.addEventListener('click', cerrarDrawer);

        function cerrarDrawer() {
            drawerFav.classList.remove('open');
            drawerOverlay.classList.remove('open');
        }

        // ─── BUSCADOR ────────────────────────────────────────────────────────
        const input = document.getElementById('buscador');
        const resultados = document.getElementById('resultados');
        const grid = document.getElementById('grid');
        const labelRecom = document.getElementById('label-recomendados');

        input.addEventListener('input', function() {
            const q = this.value.trim();

            if (q.length === 0) {
                resultados.innerHTML = '';
                grid.style.display = '';
                labelRecom.style.display = '';
                return;
            }

            grid.style.display = 'none';
            labelRecom.style.display = 'none';

            fetch("<?= base_url('buscar-libros') ?>?q=" + encodeURIComponent(q))
                .then(res => res.json())
                .then(data => {
                    if (!Array.isArray(data)) {
                        resultados.innerHTML = '<p class="no-resultados">Error en el servidor.</p>';
                        return;
                    }
                    if (data.length === 0) {
                        resultados.innerHTML = `<p class="no-resultados">No se encontraron resultados para "<strong>${q}</strong>".</p>`;
                        return;
                    }
                    resultados.innerHTML = data.map(libro => `
                        <div class="book-card" data-id="${libro.idrecurso}"
                            data-portada="${libro.portada ?? ''}"
                            data-autortxt="${libro.autores ?? 'Sin autor'}"
                            data-titulotxt="${libro.titulo}">
                            <button class="btn-fav ${favIds.has(Number(libro.idrecurso)) ? 'activo' : ''}"
                                    data-id="${libro.idrecurso}">
                                <i class="fa-${favIds.has(Number(libro.idrecurso)) ? 'solid' : 'regular'} fa-heart"></i>
                            </button>
                            <div class="book-cover">
                                ${libro.portada
                                    ? `<img src="/uploads/portadas/${libro.portada}" alt="${libro.titulo}">`
                                    : `<i class="fas fa-book fa-3x"></i>`}
                            </div>
                            <div class="book-info">
                                <p class="book-title">${libro.titulo}</p>
                                <p class="book-author">${libro.autores ?? 'Sin autor'}</p>
                                <a href="/biblioteca/detalle/${libro.idrecurso}" class="book-btn">Ver detalle</a>
                            </div>
                        </div>
                    `).join('');
                    bindFavButtons(resultados);
                })
                .catch(() => {
                    resultados.innerHTML = '<p class="no-resultados">Error de conexión.</p>';
                });
        });

        // ─── FAVORITOS ────────────────────────────────────────────────────────
        let favIds = new Set();
        let favDatos = {}; // cache de datos de libros favoritos

        fetch("<?= base_url('favoritos/ids') ?>")
            .then(res => res.json())
            .then(ids => {
                favIds = new Set(ids.map(Number));
                marcarCorazones();
                actualizarBadge();
                renderDrawer();
            })
            .catch(() => {});

        function marcarCorazones() {
            document.querySelectorAll('.btn-fav').forEach(btn => {
                const id = Number(btn.dataset.id);
                if (favIds.has(id)) activarBtn(btn);
                else desactivarBtn(btn);
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
            // Limpiar items anteriores
            Array.from(drawerBody.children).forEach(el => {
                if (el.id !== 'drawerVacio') el.remove();
            });

            if (favIds.size === 0) {
                drawerVacio.style.display = 'flex';
                return;
            }

            drawerVacio.style.display = 'none';

            favIds.forEach(id => {
                // Buscar datos del libro en el grid o en el cache
                let datos = favDatos[id];
                if (!datos) {
                    const card = document.querySelector(`.book-card[data-id="${id}"]`);
                    if (card) {
                        datos = {
                            titulo: card.dataset.titulotxt || '—',
                            autor: card.dataset.autortxt || 'Sin autor',
                            portada: card.dataset.portada || '',
                            id: id
                        };
                        favDatos[id] = datos;
                    }
                }

                if (!datos) return;

                const portadaHtml = datos.portada ?
                    `<img src="/uploads/portadas/${datos.portada}" alt="${datos.titulo}">` :
                    `<i class="fas fa-book"></i>`;

                const item = document.createElement('div');
                item.className = 'fav-drawer-item';
                item.dataset.id = id;
                item.innerHTML = `
                    <div class="fav-drawer-cover">${portadaHtml}</div>
                    <div class="fav-drawer-info">
                        <div class="fav-drawer-titulo">${datos.titulo}</div>
                        <div class="fav-drawer-autor">${datos.autor}</div>
                        <a href="/biblioteca/detalle/${id}" class="fav-drawer-btn">Ver detalle</a>
                    </div>
                    <button class="fav-drawer-remove" data-id="${id}" title="Quitar de favoritos">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                `;

                item.querySelector('.fav-drawer-remove').addEventListener('click', () => {
                    toggleFavorito(id);
                });

                drawerBody.appendChild(item);
            });
        }

        function bindFavButtons(container) {
            const btns = container.classList?.contains('btn-fav') ? [container] :
                container.querySelectorAll('.btn-fav');

            btns.forEach(btn => {
                btn.addEventListener('click', e => {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleFavorito(Number(btn.dataset.id));
                });
            });
        }

        function toggleFavorito(idrecurso) {
            fetch("<?= base_url('favoritos/toggle') ?>", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        idrecurso
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.favorito) {
                        favIds.add(idrecurso);
                    } else {
                        favIds.delete(idrecurso);
                        delete favDatos[idrecurso];
                    }
                    marcarCorazones();
                    actualizarBadge();
                    renderDrawer();
                })
                .catch(() => alert('Error al actualizar favoritos.'));
        }

        bindFavButtons(grid);

        // ─── FILTROS POR CATEGORÍA ────────────────────────────────────────────
        let filtroActual = 'todos';

        document.querySelectorAll('.filtro-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                // Si hay búsqueda activa, limpiarla primero
                if (input.value.trim() !== '') {
                    input.value = '';
                    resultados.innerHTML = '';
                    grid.style.display = '';
                    labelRecom.style.display = '';
                }

                filtroActual = btn.dataset.cat;

                document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('activo'));
                btn.classList.add('activo');

                const cards = grid.querySelectorAll('.book-card');
                cards.forEach(card => {
                    const cat = card.dataset.categoria;
                    const visible = filtroActual === 'todos' || cat === filtroActual;
                    card.style.display = visible ? '' : 'none';
                });
            });
        });

        // Resetear filtro al escribir en el buscador
        input.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('activo'));
                document.querySelector('.filtro-btn[data-cat="todos"]')?.classList.add('activo');
                filtroActual = 'todos';
            }
        }, true); // capture: true para que corra antes del listener existente
    </script>

</body>

</html>