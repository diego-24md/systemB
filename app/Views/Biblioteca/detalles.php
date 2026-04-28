<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?= esc($libro['titulo']) ?> - Biblioteca</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
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
            max-width: 860px;
            margin: 32px auto;
            padding: 0 20px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #b8001e;
            font-size: 14px;
            text-decoration: none;
            margin-bottom: 20px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            display: flex;
            gap: 0;
        }

        .cover-side {
            width: 240px;
            background: #f0f0f0;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ccc;
            padding: 16px;
        }

        .cover-side img {
            width: 100%;
            height: auto;
            object-fit: contain;
            border-radius: 8px;
        }

        .info-side {
            padding: 32px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .book-titulo {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a1a;
            line-height: 1.3;
        }

        .book-autores {
            font-size: 14px;
            color: #666;
        }

        .divider {
            border: none;
            border-top: 1px solid #eee;
            margin: 4px 0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .info-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #999;
        }

        .info-value {
            font-size: 14px;
            color: #333;
        }

        .descripcion {
            font-size: 14px;
            color: #555;
            line-height: 1.6;
        }

        .disponibilidad {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
        }

        .disponible {
            background: #e6f9ee;
            color: #1a7f3c;
        }

        .no-disponible {
            background: #fdecea;
            color: #b8001e;
        }

        .btn-reservar {
            display: inline-block;
            padding: 12px 24px;
            background: #b8001e;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            text-align: center;
            transition: background 0.2s;
            margin-top: auto;
        }

        .btn-reservar:hover {
            background: #8f0017;
        }

        .btn-reservar.disabled {
            background: #ccc;
            cursor: not-allowed;
            pointer-events: none;
        }

        @media (max-width: 600px) {
            .card {
                flex-direction: column;
            }

            .cover-side {
                width: 100%;
                height: 250px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
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

        <a href="<?= base_url('catalogo') ?>" class="back-link">
            ← Volver al catálogo
        </a>

        <div class="card">

            <!-- PORTADA -->
            <div class="cover-side">
                <?php if (!empty($libro['portada']) && file_exists('uploads/portadas/' . $libro['portada'])): ?>
                    <img src="<?= base_url('uploads/portadas/' . $libro['portada']) ?>"
                        alt="<?= esc($libro['titulo']) ?>">
                <?php else: ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="none"
                        viewBox="0 0 24 24" stroke="#ccc" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18 9.246 18 10.832 18.477 12 19.253zm0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18 14.754 18 13.168 18.477 12 19.253z" />
                    </svg>
                <?php endif; ?>
            </div>

            <!-- INFORMACIÓN -->
            <div class="info-side">

                <h1 class="book-titulo"><?= esc($libro['titulo']) ?></h1>
                <p class="book-autores">✍️ <?= esc($libro['autores'] ?? 'Sin autor') ?></p>

                <hr class="divider">

                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">ISBN</span>
                        <span class="info-value"><?= esc($libro['isbn'] ?? '—') ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Año</span>
                        <span class="info-value"><?= esc($libro['anio'] ?? '—') ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Páginas</span>
                        <span class="info-value"><?= esc($libro['numpaginas'] ?? '—') ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Categoría</span>
                        <span class="info-value"><?= esc($libro['categoria'] ?? '—') ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tipo</span>
                        <span class="info-value"><?= esc($libro['tipo'] ?? '—') ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Ejemplares</span>
                        <span class="info-value"><?= $libro['total_ejemplares'] > 0 ? $libro['total_ejemplares'] : 'Sin ejemplares' ?></span>
                    </div>
                </div>

                <?php if (!empty($libro['descripcion'])): ?>
                    <hr class="divider">
                    <p class="descripcion"><?= esc($libro['descripcion']) ?></p>
                <?php endif; ?>

                <hr class="divider">

                <!-- DISPONIBILIDAD -->
                <?php if ($libro['total_ejemplares'] == 0): ?>
                    <div class="disponibilidad no-disponible">
                        📚 Sin ejemplares registrados
                    </div>
                    <a class="btn-reservar disabled">No disponible</a>

                <?php elseif ($libro['disponibles'] > 0): ?>
                    <div class="disponibilidad disponible">
                        ✅ <?= $libro['disponibles'] ?> ejemplar(es) disponible(s)
                    </div>
                    <a href="<?= base_url('biblioteca/reservar/' . $libro['idrecurso']) ?>"
                        class="btn-reservar">Reservar</a>

                <?php else: ?>
                    <div class="disponibilidad no-disponible">
                        ❌ No hay ejemplares disponibles
                    </div>
                    <a class="btn-reservar disabled">No disponible</a>
                <?php endif; ?>

            </div>
        </div>
    </div>

</body>

</html>