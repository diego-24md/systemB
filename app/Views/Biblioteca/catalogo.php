<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Catálogo de Libros</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: #f8f9fa;
            color: #333;
            line-height: 1.5;
        }

        /* ==================== HEADER ==================== */
        .header {
            background: linear-gradient(135deg, #ffcc00 30%, #b8001e 35%);
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            position: relative;
        }

        .header img {
            height: 52px;
            width: 45px;
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .header-text h1 {
            color: white;
            font-size: 17px;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.02em;
        }

        .header-text p {
            color: rgba(255, 255, 255, 0.75);
            font-size: 13px;
            margin-top: 2px;
        }

        .header-actions {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* ===== BOTÓN FAVORITOS EN HEADER ===== */
        .btn-fav-header {
            position: relative;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: white;
            font-size: 17px;
            transition: background 0.2s;
        }

        .btn-fav-header:hover {
            background: rgba(255, 255, 255, 0.28);
        }

        .fav-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: white;
            color: #b8001e;
            font-size: 10px;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
        }

        /* ===== MENÚ DE USUARIO ===== */
        .user-menu-wrap {
            position: relative;
        }

        .user-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 30px;
            padding: 7px 14px 7px 10px;
            cursor: pointer;
            color: white;
            font-size: 14px;
            font-weight: 600;
            transition: background 0.2s;
            white-space: nowrap;
        }

        .user-btn:hover {
            background: rgba(255, 255, 255, 0.28);
        }

        .user-btn i {
            font-size: 18px;
        }

        .user-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            min-width: 190px;
            z-index: 200;
            overflow: hidden;
            animation: fadeDown 0.18s ease;
        }

        @keyframes fadeDown {
            from {
                opacity: 0;
                transform: translateY(-6px);
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
            border-bottom: 1px solid #f0f0f0;
        }

        .dropdown-header span {
            display: block;
            font-size: 13px;
            color: #999;
        }

        .dropdown-header strong {
            font-size: 15px;
            color: #222;
        }

        .dropdown-logout {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            color: #b8001e;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.15s;
        }

        .dropdown-logout:hover {
            background: #fff5f5;
        }

        /* ==================== DRAWER FAVORITOS ==================== */
        .drawer-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 300;
            animation: fadeIn 0.2s ease;
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
            background: white;
            z-index: 400;
            display: flex;
            flex-direction: column;
            transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: -8px 0 32px rgba(0, 0, 0, 0.15);
        }

        .drawer.open {
            right: 0;
        }

        .drawer-header {
            padding: 20px 20px 16px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .drawer-header h2 {
            font-size: 16px;
            font-weight: 700;
            color: #1f1f1f;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .drawer-header h2 i {
            color: #b8001e;
        }

        .drawer-close {
            background: #f1f3f5;
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 14px;
            color: #555;
            transition: background 0.15s;
        }

        .drawer-close:hover {
            background: #e2e6ea;
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
            height: 200px;
            color: #aaa;
            font-size: 14px;
            gap: 12px;
            text-align: center;
        }

        .drawer-vacio i {
            font-size: 2.5rem;
            color: #ddd;
        }

        /* Tarjeta de favorito en el drawer */
        .fav-drawer-item {
            display: flex;
            gap: 12px;
            align-items: center;
            padding: 12px;
            border: 1px solid #f0f0f0;
            border-radius: 12px;
            margin-bottom: 10px;
            transition: background 0.15s;
        }

        .fav-drawer-item:hover {
            background: #f8f9fa;
        }

        .fav-drawer-cover {
            width: 52px;
            height: 68px;
            border-radius: 6px;
            overflow: hidden;
            background: #f0f0f0;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .fav-drawer-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .fav-drawer-cover i {
            font-size: 1.5rem;
            color: #ccc;
        }

        .fav-drawer-info {
            flex: 1;
        }

        .fav-drawer-titulo {
            font-size: 13.5px;
            font-weight: 600;
            color: #1f1f1f;
            line-height: 1.3;
            margin-bottom: 4px;
        }

        .fav-drawer-autor {
            font-size: 12px;
            color: #888;
            margin-bottom: 8px;
        }

        .fav-drawer-btn {
            font-size: 12px;
            font-weight: 600;
            padding: 5px 12px;
            background: #b8001e;
            color: white;
            border-radius: 20px;
            text-decoration: none;
            display: inline-block;
            transition: background 0.2s;
        }

        .fav-drawer-btn:hover {
            background: #8f0017;
        }

        .fav-drawer-remove {
            background: none;
            border: none;
            color: #ccc;
            font-size: 16px;
            cursor: pointer;
            padding: 4px;
            transition: color 0.15s;
            flex-shrink: 0;
        }

        .fav-drawer-remove:hover {
            color: #b8001e;
        }

        /* ==================== MAIN ==================== */
        .main {
            max-width: 1080px;
            margin: 0 auto;
            padding: 32px 20px;
        }

        .section-label {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ==================== BUSCADOR ==================== */
        .search-wrap {
            position: relative;
            margin-bottom: 42px;
        }

        .search-wrap i.fa-magnifying-glass {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: #333;
            z-index: 2;
            pointer-events: none;
        }

        .search-wrap input {
            width: 100%;
            padding: 10px 40px 10px 14px;
            border: 1px solid #cfcfcf;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
            background: #e9ecef;
            color: #333;
            transition: all 0.2s ease;
        }

        .search-wrap input:focus {
            border-color: #999;
            background: #e3e6ea;
        }

        .search-wrap input::placeholder {
            color: #666;
        }

        /* ==================== GRID DE LIBROS ==================== */
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(185px, 1fr));
            gap: 24px;
        }

        .book-card {
            background: white;
            border: 1px solid #f0f0f0;
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .book-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
            border-color: #ddd;
        }

        .btn-fav {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.85);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            color: #ccc;
            transition: all 0.2s ease;
            z-index: 5;
            backdrop-filter: blur(4px);
        }

        .btn-fav:hover {
            background: white;
            transform: scale(1.15);
        }

        .btn-fav.activo {
            color: #b8001e;
        }

        .book-cover {
            height: 240px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .book-card:hover .book-cover img {
            transform: scale(1.06);
        }

        .book-cover i.fas {
            font-size: 4rem;
            color: #ccc;
        }

        .book-info {
            padding: 16px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .book-title {
            font-size: 14.5px;
            font-weight: 600;
            color: #1f1f1f;
            line-height: 1.35;
            margin-bottom: 6px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .book-author {
            font-size: 13px;
            color: #777;
            margin-bottom: 12px;
            flex: 1;
        }

        .book-btn {
            display: inline-block;
            margin-top: auto;
            font-size: 13px;
            font-weight: 600;
            padding: 8px 16px;
            background: #b8001e;
            color: white;
            border-radius: 30px;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(184, 0, 30, 0.2);
        }

        .book-btn:hover {
            background: #8f0017;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(184, 0, 30, 0.3);
        }

        .no-resultados {
            color: #888;
            font-size: 15px;
            padding: 20px 0;
            text-align: center;
            grid-column: 1 / -1;
        }

        @media (max-width: 640px) {
            .books-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 18px;
            }

            .book-cover {
                height: 210px;
            }

            .user-btn span {
                display: none;
            }

            .drawer {
                width: 100%;
                max-width: 100%;
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
            <h2><i class="fa-solid fa-heart"></i> Mis favoritos <span id="drawer-count" style="font-size:13px;color:#888;font-weight:400;"></span></h2>
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
                    <i class="fa-solid fa-chevron-down" style="font-size:11px;opacity:0.7;"></i>
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

        <p class="section-label">Buscar libros</p>
        <div class="search-wrap">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="buscador" placeholder="Buscar">
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
                        data-titulotxt="<?= esc((string)($libro['titulo'] ?? '')) ?>">

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
            const btns = container.classList?.contains('btn-fav') ?
                [container] :
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
    </script>

</body>

</html>