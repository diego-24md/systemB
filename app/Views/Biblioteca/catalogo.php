<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Catálogo de Libros</title>
    <!-- Font Awesome 6 (Free) -->
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

        /* ==================== MAIN ==================== */
        .main {
            max-width: 1080px;
            margin: 0 auto;
            padding: 32px 20px;
        }

        /* Etiquetas de sección */
        .section-label {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 14px;
        }

        /* ==================== BUSCADOR ==================== */
        .search-wrap {
            position: relative;
            margin-bottom: 42px;
        }

        .search-wrap i.fa-magnifying-glass {
            position: absolute;
            right: 14px;
            /* mover a la derecha */
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
            /* espacio a la derecha para la lupa */
            border: 1px solid #cfcfcf;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
            background: #e9ecef;
            /* gris claro */
            color: #333;
            transition: all 0.2s ease;
            box-shadow: none;
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

        /* Tarjeta de libro mejorada */
        .book-card {
            background: white;
            border: 1px solid #f0f0f0;
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .book-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
            border-color: #ddd;
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

        /* Información del libro */
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

        /* Botón */
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

        /* Mensaje de no resultados */
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
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="<?= base_url('/img/insignia.jpg') ?>" alt="Logo">
        <div class="header-text">
            <h1>Institución Educativa Chinchaysuyo</h1>
            <p>Biblioteca escolar</p>
        </div>
    </div>

    <div class="main">

        <p class="section-label">Buscar libros</p>
        <div class="search-wrap">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="buscador" placeholder="Buscar">
        </div>

        <div id="resultados" class="books-grid" style="margin-bottom: 32px;"></div>

        <p class="section-label" id="label-recomendados">Recomendados</p>
        <div class="books-grid" id="grid">
            <?php foreach ($libros as $libro): ?>
                <div class="book-card" data-titulo="<?= strtolower(esc((string) $libro['titulo'])) ?>"
                    data-autor="<?= strtolower(esc((string) ($libro['autores'] ?? ''))) ?>">

                    <div class="book-cover">
                        <?php if (!empty($libro['portada']) && file_exists('uploads/portadas/' . $libro['portada'])): ?>
                            <img src="<?= base_url('uploads/portadas/' . $libro['portada']) ?>"
                                alt="<?= esc($libro['titulo']) ?>">
                        <?php else: ?>
                            <i class="fas fa-book fa-3x"></i>
                        <?php endif; ?>
                    </div>

                    <div class="book-info">
                        <p class="book-title"><?= esc($libro['titulo']) ?></p>
                        <p class="book-author"><?= esc($libro['autores'] ?? 'Sin autor') ?></p>
                        <a href="<?= base_url('biblioteca/detalle/' . $libro['idrecurso']) ?>" class="book-btn">Ver
                            detalle</a>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <script>
        const input = document.getElementById('buscador');
        const resultados = document.getElementById('resultados');
        const grid = document.getElementById('grid');
        const labelRecom = document.getElementById('label-recomendados');

        input.addEventListener('input', function () {
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
                        resultados.innerHTML = '<p class="no-resultados">No se encontraron resultados para "<strong>' + q + '</strong>".</p>';
                        return;
                    }

                    resultados.innerHTML = data.map(libro => `
                        <div class="book-card">
                            <div class="book-cover">
                                ${libro.portada
                            ? `<img src="/uploads/portadas/${libro.portada}" alt="${libro.titulo}">`
                            : `<i class="fas fa-book fa-3x"></i>`
                        }
                            </div>
                            <div class="book-info">
                                <p class="book-title">${libro.titulo}</p>
                                <p class="book-author">${libro.autores ?? 'Sin autor'}</p> <!-- ✅ corregido -->
                                <a href="/biblioteca/detalle/${libro.idrecurso}" class="book-btn">Ver detalle</a> <!-- ✅ corregido -->
                            </div>
                        </div>
                    `).join('');
                })
                .catch(() => {
                    resultados.innerHTML = '<p class="no-resultados">Error de conexión.</p>';
                });
        });
    </script>

</body>

</html>