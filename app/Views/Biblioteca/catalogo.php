<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Catálogo de Libros</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .header {
            background: #b8001e;
            padding: 20px 10px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .header img {
            height: 44px;
            border-radius: 8%;
        }

        .header-text h1 {
            color: white;
            font-size: 15px;
            font-weight: 600;
            margin: 0;
        }

        .header-text p {
            color: rgba(255, 255, 255, 0.65);
            font-size: 12px;
            margin: 2px 0 0;
        }

        .main {
            max-width: 960px;
            margin: 0 auto;
            padding: 24px 20px;
        }

        .section-label {
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 12px;
        }

        .search-wrap {
            position: relative;
            margin-bottom: 32px;
        }

        .search-wrap input {
            width: 100%;
            padding: 10px 14px 10px 38px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            background: #fff;
        }

        .search-wrap input:focus {
            border-color: #b8001e;
        }

        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
            gap: 16px;
        }

        .book-card {
            background: #fff;
            border: 1px solid #e8e8e8;
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .book-card:hover {
            border-color: #ccc;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        }

        .book-cover {
            height: 180px;
            background: #f5f5f5;
            overflow: hidden;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ccc;
        }

        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .book-info {
            padding: 12px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .book-title {
            font-size: 13px;
            font-weight: 600;
            color: #1a1a1a;
            line-height: 1.4;
            margin-bottom: 4px;
        }

        .book-author {
            font-size: 12px;
            color: #888;
            flex: 1;
        }

        .book-btn {
            display: inline-block;
            margin-top: 10px;
            align-self: flex-start;
            font-size: 12px;
            padding: 5px 12px;
            background: #b8001e;
            color: white;
            border-radius: 20px;
            text-decoration: none;
            transition: background 0.2s;
        }

        .book-btn:hover {
            background: #8f0017;
        }

        .no-resultados {
            color: #888;
            font-size: 14px;
            padding: 10px 0;
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="<?= base_url('/img/insignia.png') ?>" alt="Logo">
        <div class="header-text">
            <h1>Institución Educativa Chinchaysuyo</h1>
            <p>Biblioteca escolar</p>
        </div>
    </div>

    <div class="main">

        <p class="section-label">Buscar libros</p>
        <div class="search-wrap">
            <input type="text" id="buscador" placeholder="Título, autor o tema...">
        </div>

        <div id="resultados" class="books-grid" style="margin-bottom: 32px;"></div>

        <p class="section-label" id="label-recomendados">Recomendados</p>
        <div class="books-grid" id="grid">
            <?php foreach ($libros as $libro): ?>
                <div class="book-card"
                    data-titulo="<?= strtolower(esc((string)$libro['titulo'])) ?>"
                    data-autor="<?= strtolower(esc((string)($libro['autores'] ?? ''))) ?>">

                    <div class="book-cover">
                        <?php if (!empty($libro['portada']) && file_exists('uploads/portadas/' . $libro['portada'])): ?>
                            <img src="<?= base_url('uploads/portadas/' . $libro['portada']) ?>"
                                alt="<?= esc($libro['titulo']) ?>">
                        <?php else: ?>
                            <i class="fas fa-book fa-3x"></i> <!-- ✅ fallback -->
                        <?php endif; ?>
                    </div>

                    <div class="book-info">
                        <p class="book-title"><?= esc($libro['titulo']) ?></p>
                        <p class="book-author"><?= esc($libro['autores'] ?? 'Sin autor') ?></p> <!-- ✅ corregido -->
                        <a href="<?= base_url('usuarios/detalle/' . $libro['idrecurso']) ?>"
                            class="book-btn">Ver detalle</a> <!-- ✅ corregido -->
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
                                <a href="/usuarios/detalle/${libro.idrecurso}" class="book-btn">Ver detalle</a> <!-- ✅ corregido -->
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