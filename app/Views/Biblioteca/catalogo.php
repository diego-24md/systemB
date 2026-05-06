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

        /* ===== MENÚ DE USUARIO (esquina superior derecha) ===== */
        .user-menu-wrap {
            margin-left: auto;
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

        /* Dropdown */
        .user-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            min-width: 190px;
            z-index: 100;
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

        .section-label i {
            font-size: 14px;
        }

        .section-label i.fa-heart {
            color: #b8001e;
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

        /* Botón corazón sobre la portada */
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

        .btn-fav.activo i {
            font-weight: 900;
            /* fa-solid */
        }

        /* Portada */
        .book-cover {
            height: 240px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
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

        /* Info */
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

        /* ===== SECCIÓN FAVORITOS ===== */
        .seccion-favoritos {
            margin-bottom: 48px;
        }

        .favoritos-vacio {
            color: #aaa;
            font-size: 14px;
            padding: 24px 0 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* No resultados */
        .no-resultados {
            color: #888;
            font-size: 15px;
            padding: 20px 0;
            text-align: center;
            grid-column: 1 / -1;
        }

        /* ==================== RESPONSIVE ==================== */
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

            /* Solo ícono en móvil */
        }
    </style>
</head>

<body>

    <?php
    // ─── PROTECCIÓN: Solo alumnas registradas ───────────────────────────────────
    // Si no hay sesión activa, redirige al login.
    // Ajusta 'alumna_id' al nombre que usas al guardar la sesión en tu login.
    if (! session()->get('alumna_id')) {
        return redirect()->to(base_url('login'));
    }

    $alumnaId     = session()->get('alumna_id');
    $alumnaNombre = (string)(session()->get('alumna_nombre') ?? 'Alumna');
    $libros       = $libros ?? [];
    ?>

    <!-- ==================== HEADER ==================== -->
    <div class="header">
        <img src="<?= base_url('/img/insignia.jpg') ?>" alt="Logo">
        <div class="header-text">
            <h1>Institución Educativa Chinchaysuyo</h1>
            <p>Biblioteca escolar</p>
        </div>

        <!-- Menú de usuario -->
        <div class="user-menu-wrap">
            <button class="user-btn" id="userBtn" aria-expanded="false">
                <i class="fa-solid fa-circle-user"></i>
                <span><?= htmlspecialchars($alumnaNombre) ?></span>
                <i class="fa-solid fa-chevron-down" style="font-size:11px; opacity:0.7;"></i>
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

    <!-- ==================== CONTENIDO ==================== -->
    <div class="main">

        <!-- Buscador -->
        <p class="section-label">Buscar libros</p>
        <div class="search-wrap">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="buscador" placeholder="Buscar">
        </div>

        <!-- Resultados de búsqueda -->
        <div id="resultados" class="books-grid" style="margin-bottom: 32px;"></div>

        <!-- ===== SECCIÓN FAVORITOS ===== -->
        <div class="seccion-favoritos" id="seccionFavoritos">
            <p class="section-label">
                <i class="fa-solid fa-heart"></i> Libros Favoritos
            </p>
            <div class="books-grid" id="gridFavoritos">
                <p class="favoritos-vacio" id="msgFavVacio">
                    <i class="fa-regular fa-heart"></i>
                    Aún no tienes libros favoritos. ¡Presiona el corazón en cualquier libro!
                </p>
            </div>
        </div>

        <!-- ===== SECCIÓN RECOMENDADOS ===== -->
        <p class="section-label" id="label-recomendados">Recomendados</p>
        <div class="books-grid" id="grid">

            <?php if (!empty($libros)): ?>
                <?php foreach ($libros as $libro): ?>
                    <div class="book-card"
                        data-id="<?= (int)($libro['idrecurso'] ?? 0) ?>"
                        data-titulo="<?= strtolower(esc((string)($libro['titulo'] ?? ''))) ?>"
                        data-autor="<?= strtolower(esc((string)($libro['autores'] ?? ''))) ?>">

                        <!-- Botón favorito -->
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

        userBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            const open = userDropdown.classList.toggle('open');
            userBtn.setAttribute('aria-expanded', open);
        });

        document.addEventListener('click', () => {
            userDropdown.classList.remove('open');
            userBtn.setAttribute('aria-expanded', false);
        });

        // ─── BUSCADOR ───────────────────────────────────────────────────────
        const input = document.getElementById('buscador');
        const resultados = document.getElementById('resultados');
        const grid = document.getElementById('grid');
        const labelRecom = document.getElementById('label-recomendados');
        const secFav = document.getElementById('seccionFavoritos');

        input.addEventListener('input', function() {
            const q = this.value.trim();

            if (q.length === 0) {
                resultados.innerHTML = '';
                grid.style.display = '';
                labelRecom.style.display = '';
                secFav.style.display = '';
                return;
            }

            grid.style.display = 'none';
            labelRecom.style.display = 'none';
            secFav.style.display = 'none';

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
                        <div class="book-card" data-id="${libro.idrecurso}">
                            <button class="btn-fav ${favIds.has(Number(libro.idrecurso)) ? 'activo' : ''}"
                                    data-id="${libro.idrecurso}" title="Agregar a favoritos">
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
                    // Activar corazones en los resultados recién pintados
                    bindFavButtons(resultados);
                })
                .catch(() => {
                    resultados.innerHTML = '<p class="no-resultados">Error de conexión.</p>';
                });
        });

        // ─── FAVORITOS ──────────────────────────────────────────────────────
        const gridFavoritos = document.getElementById('gridFavoritos');
        const msgFavVacio = document.getElementById('msgFavVacio');
        let favIds = new Set(); // IDs de libros favoritos de esta alumna

        // Cargar IDs favoritos al inicio
        fetch("<?= base_url('favoritos/ids') ?>")
            .then(res => res.json())
            .then(ids => {
                favIds = new Set(ids.map(Number));
                marcarCorazones();
                renderFavoritos();
            })
            .catch(() => {});

        // Marca los corazones de los libros ya en favoritos
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

        // Renderiza la sección de favoritos leyendo las tarjetas del grid principal
        function renderFavoritos() {
            // Limpiar (excepto el mensaje vacío)
            Array.from(gridFavoritos.children).forEach(el => {
                if (el.id !== 'msgFavVacio') el.remove();
            });

            if (favIds.size === 0) {
                msgFavVacio.style.display = '';
                return;
            }
            msgFavVacio.style.display = 'none';

            favIds.forEach(id => {
                // Clonar la tarjeta del grid principal
                const original = grid.querySelector(`.book-card[data-id="${id}"]`);
                if (!original) return;
                const clone = original.cloneNode(true);
                bindFavButtons(clone); // re-bindear eventos en el clon
                gridFavoritos.appendChild(clone);
            });
        }

        // Asigna eventos a los botones de corazón dentro de un contenedor
        function bindFavButtons(container) {
            const btns = container.classList?.contains('btn-fav') ? [container] :
                container.querySelectorAll('.btn-fav');

            btns.forEach(btn => {
                btn.addEventListener('click', (e) => {
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
                    }
                    marcarCorazones();
                    renderFavoritos();
                })
                .catch(() => alert('Error al actualizar favoritos.'));
        }

        // Bindear corazones del grid inicial al cargar
        bindFavButtons(grid);
    </script>

</body>

</html>