<?php
http_response_code(404);

$url_actual = htmlspecialchars($_SERVER['REQUEST_URI'] ?? '/');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 | Biblioteca Escolar</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #07111f;
            --card: rgba(15, 23, 42, .78);
            --line: rgba(255, 255, 255, .08);
            --primary: #3b82f6;
            --text: #f8fafc;
            --muted: #94a3b8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            color: var(--text);

            background:
                radial-gradient(circle at top left, rgba(59, 130, 246, .15), transparent 30%),
                radial-gradient(circle at bottom right, rgba(96, 165, 250, .18), transparent 28%),
                linear-gradient(135deg, #020617 0%, #07111f 45%, #0f172a 100%);

            overflow-y: auto;
            overflow-x: hidden;
        }

        .wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .card {
            width: 100%;
            max-width: 1100px;
            min-height: auto;

            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 24px;
            overflow: hidden;

            display: grid;
            grid-template-columns: 1.1fr .9fr;

            box-shadow:
                0 20px 60px rgba(0, 0, 0, .35);
        }

        /* LEFT */

        .left {
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            width: fit-content;

            padding: 10px 18px;
            border-radius: 999px;

            background: rgba(59, 130, 246, .10);
            border: 1px solid rgba(96, 165, 250, .18);

            color: #bfdbfe;
            font-size: .8rem;
            font-weight: 700;
            margin-bottom: 24px;
        }

        .code {
            font-size: 7rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 12px;

            background: linear-gradient(180deg, #ffffff, #60a5fa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .title {
            font-size: 2.2rem;
            font-weight: 700;
            line-height: 1.15;
            margin-bottom: 20px;
        }

        .desc {
            color: var(--muted);
            font-size: 1rem;
            line-height: 1.8;
            margin-bottom: 28px;
            max-width: 520px;
        }

        .actions {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 28px;
        }

        .btn {
            height: 52px;
            padding: 0 24px;
            border-radius: 14px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            text-decoration: none;
            font-weight: 600;
            font-size: .95rem;
            transition: .2s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: white;
        }

        .btn-secondary {
            border: 1px solid rgba(255, 255, 255, .08);
            background: rgba(255, 255, 255, .04);
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .url-box {
            padding: 20px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .04);
            border: 1px solid rgba(255, 255, 255, .06);
        }

        .url-label {
            font-size: .75rem;
            color: #60a5fa;
            font-weight: 700;
            letter-spacing: .08em;
            margin-bottom: 10px;
        }

        .url-text {
            color: #cbd5e1;
            font-size: .92rem;
            word-break: break-word;
        }

        /* RIGHT */

        .right {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            min-height: 500px;
            background:
                linear-gradient(180deg,
                    rgba(255, 255, 255, .02),
                    rgba(255, 255, 255, .01));
        }

        .circle {
            width: 320px;
            height: 320px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .05);

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .book {
            width: 160px;
            height: 200px;
            border-radius: 18px;

            background: linear-gradient(145deg, #3b82f6, #1d4ed8);

            display: flex;
            align-items: center;
            justify-content: center;

            transform: rotate(-12deg);

            box-shadow:
                0 20px 50px rgba(37, 99, 235, .35);
        }

        .book svg {
            width: 60px;
            height: 60px;
            stroke: white;
            fill: none;
            stroke-width: 1.8;
        }

        /* RESPONSIVE */

        @media (max-width: 900px) {
            .card {
                grid-template-columns: 1fr;
            }

            .right {
                min-height: 300px;
            }

            .left {
                padding: 36px 28px;
            }

            .code {
                font-size: 5rem;
            }

            .title {
                font-size: 1.7rem;
            }
        }

        @media (max-width: 600px) {
            .actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .code {
                font-size: 4rem;
            }

            .title {
                font-size: 1.4rem;
            }

            .circle {
                width: 240px;
                height: 240px;
            }

            .book {
                width: 120px;
                height: 150px;
            }
        }
    </style>
</head>

<body>

    <div class="wrapper">

        <div class="card">

            <div class="left">

                <div class="badge">
                    ● SISTEMA DE BIBLIOTECA ESCOLAR
                </div>

                <div class="code">404</div>

                <h1 class="title">
                    La página se perdió entre los libros.
                </h1>

                <p class="desc">
                    La dirección que intentas abrir no existe, fue movida
                    o ya no está disponible dentro del sistema.
                    Puedes regresar al panel principal o volver a la página anterior.
                </p>

                <div class="actions">
                    <a href="<?= base_url('/') ?>" class="btn btn-primary">
                        ⌂ Volver al inicio
                    </a>

                    <a href="javascript:history.back()" class="btn btn-secondary">
                        ← Regresar
                    </a>
                </div>

                <div class="url-box">
                    <div class="url-label">
                        RUTA SOLICITADA
                    </div>

                    <div class="url-text">
                        <?= $url_actual ?>
                    </div>
                </div>

            </div>

            <div class="right">

                <div class="circle">
                    <div class="book">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                        </svg>
                    </div>
                </div>

            </div>

        </div>

    </div>

</body>

</html>