<?php
http_response_code(404);
$nombre_biblioteca = "Biblioteca - Colegio Chinchaysuyo";
$url_actual = htmlspecialchars($_SERVER['REQUEST_URI'] ?? '/');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Página no encontrada</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: system-ui, sans-serif;
            background: #f6f4f1;
            color: #1a1a1a;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background: #b8001e;
            padding: 14px 28px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .hdr-logo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .hdr-logo svg {
            width: 20px;
            height: 20px;
            stroke: white;
            fill: none;
            stroke-width: 1.8;
        }

        header h1 {
            color: white;
            font-size: 14px;
            font-weight: 600;
        }

        header p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
            margin-top: 1px;
        }

        .body {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .card {
            background: white;
            border-radius: 16px;
            border: 1px solid #e0ddd8;
            border-top: 4px solid #b8001e;
            max-width: 520px;
            width: 100%;
            padding: 48px 40px;
            text-align: center;
        }

        .illus {
            width: 80px;
            height: 80px;
            margin: 0 auto 24px;
            background: #fdf0f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .illus svg {
            width: 36px;
            height: 36px;
            stroke: #b8001e;
            fill: none;
            stroke-width: 1.6;
            stroke-linecap: round;
        }

        .code {
            font-size: 72px;
            font-weight: 700;
            color: #b8001e;
            line-height: 1;
            margin-bottom: 8px;
        }

        .title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .desc {
            font-size: 14px;
            color: #777;
            line-height: 1.7;
            margin-bottom: 24px;
        }

        .url-box {
            background: #fdf0f0;
            border: 1px solid #f5c0c0;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 13px;
            color: #5a1a1a;
            text-align: left;
            margin-bottom: 28px;
            word-break: break-all;
        }

        .url-box strong {
            display: block;
            color: #b8001e;
            margin-bottom: 3px;
            font-size: 11px;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .btns {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 32px;
        }

        .btn-prim {
            padding: 10px 22px;
            border-radius: 8px;
            background: #b8001e;
            color: white;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
        }

        .btn-prim:hover {
            background: #8f0017;
        }

        .btn-sec {
            padding: 10px 22px;
            border-radius: 8px;
            background: white;
            color: #b8001e;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid #b8001e;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
        }

        .btn-sec:hover {
            background: #fdf0f0;
        }

        hr {
            border: none;
            border-top: 1px solid #e8e5e0;
            margin: 0 0 24px;
        }

        .ql-label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #aaa;
            margin-bottom: 14px;
        }

        .links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(110px, 1fr));
            gap: 10px;
        }

        .lnk {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            padding: 14px 10px;
            background: #faf9f7;
            border: 1px solid #e0ddd8;
            border-radius: 10px;
            text-decoration: none;
            color: #1a1a1a;
            font-size: 12px;
            font-weight: 500;
            transition: background 0.2s, border-color 0.2s, color 0.2s;
        }

        .lnk:hover {
            background: #fdf0f0;
            border-color: #f5c0c0;
            color: #b8001e;
        }

        .lnk svg {
            width: 20px;
            height: 20px;
            stroke: #b8001e;
            fill: none;
            stroke-width: 1.6;
            stroke-linecap: round;
        }

        footer {
            background: #b8001e;
            padding: 14px 20px;
            text-align: center;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
        }

        footer a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
        }

        footer a:hover {
            color: white;
        }

        @media (max-width: 480px) {
            .card {
                padding: 32px 20px;
            }

            .code {
                font-size: 56px;
            }
        }
    </style>
</head>

<body>

    <header>
        <div class="hdr-logo">
            <svg viewBox="0 0 24 24">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
            </svg>
        </div>
        <div>
            <h1>Institución Educativa Chinchaysuyo</h1>
            <p>Biblioteca escolar</p>
        </div>
    </header>

    <div class="body">
        <div class="card">

            <div class="illus">
                <svg viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    <line x1="11" y1="8" x2="11" y2="14" />
                    <line x1="11" y1="16" x2="11.01" y2="16" />
                </svg>
            </div>

            <div class="code">404</div>
            <div class="title">Página no encontrada</div>
            <p class="desc">La página que buscas no existe o fue movida.<br>Verifica la dirección o regresa al inicio.
            </p>

            <div class="url-box">
                <strong>URL solicitada</strong>
                <?= $url_actual ?>
            </div>

            <div class="btns">
                <a href="<?= base_url('/') ?>" class="btn-prim">&#8962; Ir al inicio</a>
                <a href="javascript:history.back()" class="btn-sec">&#8592; Regresar</a>
            </div>

            <hr>

            <p class="ql-label">Accesos rápidos</p>
            <div class="links">
                <a href="<?= base_url('catalogo') ?>" class="lnk">
                    <svg viewBox="0 0 24 24">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                    </svg>
                    Catálogo
                </a>
                <a href="<?= base_url('buscar-libros') ?>" class="lnk">
                    <svg viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    Buscar libros
                </a>
                <a href="<?= base_url('prestamos') ?>" class="lnk">
                    <svg viewBox="0 0 24 24">
                        <polyline points="9 11 12 14 22 4" />
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                    </svg>
                    Mis préstamos
                </a>
                <a href="<?= base_url('contacto') ?>" class="lnk">
                    <svg viewBox="0 0 24 24">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                        <polyline points="22,6 12,13 2,6" />
                    </svg>
                    Contacto
                </a>
            </div>

        </div>
    </div>

    <footer>
        &copy; <?= date('Y') ?> Colegio Chinchaysuyo — Biblioteca Central &nbsp;·&nbsp;
        <a href="<?= base_url('/') ?>">Inicio</a> &nbsp;·&nbsp;
        <a href="<?= base_url('ayuda') ?>">Ayuda</a>
    </footer>

</body>

</html>