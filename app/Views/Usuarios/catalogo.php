<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Catálogo de Libros</title>

    <style>
        /* ================== BASE ================== */
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
            margin: 0;
        }

        /* ================== HEADER ================== */
        .header {
            background: linear-gradient(90deg, #e41e26, #b88a2a);
            padding: 15px 30px;
            display: flex;
            align-items: center;
            gap: 15px;
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .header img {
            height: 60px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        /* ================== CONTENEDOR ================== */
        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 20px;
        }

        /* ================== BUSCADOR ================== */
        #buscador {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            border: 2px solid #b88a2a;
            font-size: 16px;
            outline: none;
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        #buscador:focus {
            border-color: #e41e26;
            box-shadow: 0 0 10px rgba(228, 30, 38, 0.3);
        }

        /* ================== GRID ================== */
        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
            align-items: stretch;
            /* ← Importante */
        }

        .col {
            width: calc(25% - 15px);
            display: flex;
            /* ← Para que el card ocupe toda la altura */
        }

        /* ================== CARD ================== */
        .card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            border: 2px solid #b88a2a;
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 0.5s forwards;

            display: flex;
            /* ← Flex columna */
            flex-direction: column;
            width: 100%;
            /* ← Ocupa todo el .col */
            height: 100%;
            /* ← Clave para igualar alturas */
        }

        .card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            border-color: #e41e26;
        }

        /* ================== IMAGEN ================== */
        .card img {
            width: 100%;
            height: 220px;
            /* altura fija */
            object-fit: cover;
            flex-shrink: 0;
            /* no se encoja */
        }

        /* ================== BODY ================== */
        .card-body {
            padding: 15px;
            flex: 1;
            /* ← Ocupa todo el espacio restante */
            display: flex;
            flex-direction: column;
        }

        .card-body h5 {
            margin: 0 0 8px 0;
            color: #1c2d5a;
            font-size: 1.05rem;
            line-height: 1.3;
        }

        .card-body p {
            margin: 5px 0 15px 0;
            color: #666;
            flex: 1;
            /* empuja el botón hacia abajo */
        }

        /* ================== BOTÓN ================== */
        .btn {
            display: inline-block;
            align-self: flex-start;
            /* 🔥 evita que se estire */
            padding: 6px 10px;
            background: #e41e26;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            transition: 0.3s;
        }

        .btn:hover {
            background: #b0171c;
        }

        /* ================== ANIMACIÓN ================== */
        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ================== RESPONSIVE ================== */
        @media (max-width: 900px) {
            .col {
                width: calc(50% - 10px);
            }
        }

        @media (max-width: 500px) {
            .col {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <img src="<?= base_url('/img/insignia.png') ?>" alt="Logo">
        <h1>Institución Educativa Chinchaysuyo - Biblioteca</h1>
    </div>

    <div class="container">

        <h2>Buscar libros</h2>

        <<<<<<< HEAD
            <!-- BUSCADOR -->
            <input type="text" id="buscador" placeholder="Buscar libro...">
            =======

            <!-- RESULTADOS -->
            <div id="resultados" class="row"></div>

            <!-- RECOMENDADOS -->
            <h3>Libros recomendados</h3>
            <div class="row">

                <?php foreach ($libros as $libro): ?>
                    <div class="col">
                        <div class="card">
                            <img src="<?= base_url('uploads/portadas/' . $libro['portada']) ?>">

                            <div class="card-body">
                                <h5><?= esc($libro['titulo']) ?></h5>
                                <p><?= esc($libro['autor'] ?? 'Sin autor') ?></p>

                                <a href="#" class="btn">Ver detalle</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

    </div>

    <script>
        const input = document.getElementById('buscador');

        input.addEventListener('keyup', function() {

            let query = this.value.trim();

            // 🔹 Evita búsquedas vacías
            if (query.length === 0) {
                document.getElementById('resultados').innerHTML = '';
                return;
            }

            fetch("<?= base_url('buscar-libros') ?>?q=" + encodeURIComponent(query))
                .then(res => res.json())
                .then(data => {

                    let html = '';

                    // 🔹 Protección por si el backend falla
                    if (!Array.isArray(data)) {
                        document.getElementById('resultados').innerHTML =
                            '<p>Error en servidor</p>';
                        return;
                    }

                    // 🔹 Sin resultados
                    if (data.length === 0) {
                        html = '<p>No se encontraron resultados</p>';
                    }

                    // 🔹 Render de libros
                    data.forEach(libro => {
                        html += `
                    <div class="col">
                        <div class="card">
                            <img src="/uploads/portadas/${libro.portada}">
                            <div class="card-body">
                                <h5>${libro.titulo}</h5>
                                <p>Libro disponible</p>
                                <a href="#" class="btn">Ver detalle</a>
                            </div>
                        </div>
                    </div>
                `;
                    });

                    document.getElementById('resultados').innerHTML = html;
                })
                .catch(err => {
                    console.error(err);
                    document.getElementById('resultados').innerHTML =
                        '<p>Error de conexión</p>';
                });

        });
    </script>

</body>

</html>