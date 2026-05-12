<?php

/** @var array{
 *   titulo: string,
 *   autores: string,
 *   isbn: string|null,
 *   anio: string|null,
 *   numpaginas: string|null,
 *   categoria: string|null,
 *   tipo: string|null,
 *   portada: string|null,
 *   descripcion: string|null,
 *   total_ejemplares: int|string,
 *   disponibles: int|string,
 *   idrecurso: int|string
 * } $libro
 * @var array $relacionados
 */

if (! session()->get('alumna_id')) {
    return redirect()->to(base_url('login'));
}
$alumnaNombre = (string)(session()->get('alumna_nombre') ?? 'Alumna');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc((string)($libro['titulo'] ?? 'Libro')) ?> — Biblioteca</title>
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
            min-height: 100vh;
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
            letter-spacing: .01em;
        }

        .topbar-sep {
            flex: 1;
        }

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
            background: rgba(255, 255, 255, .14);
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
        }

        .user-dd.open {
            display: block;
        }

        .dd-head {
            padding: 14px 18px 12px;
            border-bottom: 1px solid var(--border);
        }

        .dd-head small {
            display: block;
            font-size: 11px;
            color: var(--ink-light);
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

        /* ── STAGE (full-width header area) ────── */
        .stage {
            background: var(--ink);
            padding: 0 24px 0;
            position: relative;
            overflow: hidden;
        }

        /* subtle dot-grid texture */
        .stage::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255, 255, 255, .06) 1px, transparent 1px);
            background-size: 28px 28px;
            pointer-events: none;
        }

        /* teal arc */
        .stage::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 380px;
            height: 380px;
            border-radius: 50%;
            background: radial-gradient(circle at center, rgba(29, 158, 117, .18) 0%, transparent 70%);
            pointer-events: none;
        }

        .stage-inner {
            position: relative;
            z-index: 2;
            max-width: 780px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 160px 1fr;
            gap: 36px;
            align-items: end;
            padding: 48px 0 0;
        }

        .stage-cover {
            position: relative;
            align-self: end;
        }

        .cover-img {
            display: block;
            width: 160px;
            height: 224px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
            box-shadow: 0 -4px 40px rgba(0, 0, 0, .4), 4px 4px 0 var(--teal-mid);
        }

        .cover-placeholder {
            width: 160px;
            height: 224px;
            background: rgba(255, 255, 255, .07);
            border-radius: 10px 10px 0 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, .2);
            font-size: 3rem;
        }

        .stage-meta {
            padding-bottom: 36px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: rgba(255, 255, 255, .5);
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 20px;
            transition: color .2s;
        }

        .back-link:hover {
            color: rgba(255, 255, 255, .85);
        }

        .cat-pill {
            display: inline-block;
            background: var(--teal-pale);
            color: var(--teal);
            font-size: 11px;
            font-weight: 600;
            padding: 3px 12px;
            border-radius: 20px;
            letter-spacing: .06em;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        .stage-title {
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: clamp(22px, 4vw, 32px);
            color: #fff;
            line-height: 1.2;
            margin-bottom: 10px;
        }

        .stage-author {
            font-size: 15px;
            color: rgba(255, 255, 255, .5);
            font-weight: 300;
        }

        .stage-author span {
            color: rgba(255, 255, 255, .8);
            font-weight: 500;
        }

        /* ── BODY ───────────────────────────────── */
        .body-wrap {
            max-width: 780px;
            margin: 0 auto;
            padding: 32px 24px 60px;
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 24px;
            align-items: start;
        }

        .col-main {
            min-width: 0;
        }

        .col-side {
            min-width: 0;
        }

        /* ── CARD base ──────────────────────────── */
        .card {
            background: var(--white);
            border-radius: 16px;
            border: 1px solid var(--border);
            padding: 24px;
            margin-bottom: 20px;
        }

        .card-label {
            font-size: 10.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: var(--ink-light);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── AVAILABILITY ───────────────────────── */
        .avail-block {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .avail-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .avail-ring {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .avail-ring.ok {
            background: var(--teal-pale);
            color: var(--teal);
        }

        .avail-ring.out {
            background: var(--amber-pale);
            color: var(--amber);
        }

        .avail-label {
            font-size: 15px;
            font-weight: 600;
        }

        .avail-sub {
            font-size: 12.5px;
            color: var(--ink-light);
            margin-top: 2px;
        }

        .btn-reservar {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 26px;
            background: var(--teal);
            color: #fff;
            border-radius: 10px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: .01em;
            transition: background .2s, transform .15s;
            box-shadow: 0 4px 16px rgba(15, 110, 86, .25);
            white-space: nowrap;
            font-family: inherit;
            border: none;
            cursor: pointer;
        }

        .btn-reservar:hover {
            background: var(--teal-mid);
            transform: translateY(-2px);
        }

        .btn-reservar.disabled {
            background: #e2e8f0;
            color: #94a3b8;
            cursor: not-allowed;
            pointer-events: none;
            box-shadow: none;
        }

        /* ── META INFO ──────────────────────────── */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .info-item-icon {
            font-size: 13px;
            color: var(--teal-mid);
            margin-bottom: 2px;
        }

        .info-item-label {
            font-size: 10.5px;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--ink-light);
        }

        .info-item-value {
            font-size: 14px;
            font-weight: 500;
            color: var(--ink);
        }

        /* ── DESCRIPTION ────────────────────────── */
        .desc-text {
            font-size: 15px;
            line-height: 1.85;
            color: #3d4a5e;
        }

        /* ── FAVORITE ───────────────────────────── */
        .fav-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .fav-label {
            font-size: 14px;
            font-weight: 500;
        }

        .fav-sub {
            font-size: 12px;
            color: var(--ink-light);
            margin-top: 2px;
        }

        .btn-fav {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            background: transparent;
            color: var(--ink);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            white-space: nowrap;
            transition: all .2s;
        }

        .btn-fav:hover {
            border-color: var(--teal-mid);
            color: var(--teal);
        }

        .btn-fav.activo {
            background: var(--teal-pale);
            color: var(--teal);
            border-color: var(--teal-mid);
        }

        /* ── NOTICE CARD ────────────────────────── */
        .notice-card {
            background: var(--amber-pale);
            border: 1px solid rgba(186, 117, 23, .2);
            border-left: 4px solid var(--amber);
            border-radius: 14px;
            padding: 20px 22px;
            margin-bottom: 20px;
        }

        .notice-head {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 14px;
            font-weight: 600;
            color: var(--amber);
            margin-bottom: 14px;
        }

        .notice-rule {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 13px;
            color: #5a4010;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .notice-rule:last-child {
            margin-bottom: 0;
        }

        .notice-rule i {
            color: var(--amber);
            margin-top: 2px;
            flex-shrink: 0;
        }

        /* ── RELATED ────────────────────────────── */
        .related-title {
            font-size: 10.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: var(--ink-light);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .related-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .related-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .rel-item {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 10px 12px;
            text-decoration: none;
            transition: border-color .2s, transform .15s;
        }

        .rel-item:hover {
            border-color: var(--teal-mid);
            transform: translateX(4px);
        }

        .rel-thumb {
            width: 40px;
            height: 54px;
            border-radius: 6px;
            background: var(--sand);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
            color: #bbb;
            font-size: 1.2rem;
        }

        .rel-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .rel-meta {
            min-width: 0;
        }

        .rel-titulo {
            font-size: 13px;
            font-weight: 600;
            color: var(--ink);
            line-height: 1.3;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .rel-autor {
            font-size: 11px;
            color: var(--ink-light);
            margin: 2px 0 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .rel-avail {
            font-size: 10.5px;
            font-weight: 600;
            color: var(--teal);
            background: var(--teal-pale);
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
        }

        .rel-empty {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 28px 20px;
            text-align: center;
            color: var(--ink-light);
            font-size: 13px;
        }

        /* ── RESPONSIVE ─────────────────────────── */

        /* Tablet: colapsa a 1 columna antes de que se vea apretado */
        @media (max-width: 780px) {
            .body-wrap {
                grid-template-columns: 1fr;
                padding: 24px 20px 48px;
                gap: 0;
            }

            /* En tablet la columna lateral va DESPUÉS del main */
            .col-side {
                order: 2;
                margin-top: 4px;
            }

            .col-main {
                order: 1;
            }

            /* Libros relacionados en tablet: scroll horizontal */
            .related-list {
                display: flex;
                flex-direction: row;
                overflow-x: auto;
                gap: 12px;
                padding-bottom: 8px;
                scrollbar-width: none;
            }

            .related-list::-webkit-scrollbar {
                display: none;
            }

            .rel-item {
                flex-direction: column;
                align-items: flex-start;
                min-width: 140px;
                max-width: 140px;
                padding: 10px;
            }

            .rel-item:hover {
                transform: translateY(-3px);
            }

            .rel-thumb {
                width: 100%;
                height: 120px;
                border-radius: 8px;
                margin-bottom: 8px;
            }

            .rel-titulo {
                white-space: normal;
                -webkit-line-clamp: 2;
                display: -webkit-box;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .rel-autor {
                white-space: normal;
            }
        }

        /* Mobile */
        @media (max-width: 520px) {

            /* Topbar: oculta el nombre en pantallas muy pequeñas */
            .topbar {
                padding: 0 16px;
                gap: 10px;
            }

            .topbar-brand {
                font-size: 12px;
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

            /* Stage */
            .stage {
                padding: 0 16px;
            }

            .stage-inner {
                grid-template-columns: 1fr;
                gap: 0;
                padding: 28px 0 0;
            }

            .stage-cover {
                display: flex;
                justify-content: center;
                margin-bottom: 20px;
            }

            .cover-img {
                width: 120px;
                height: 168px;
                border-radius: 8px 8px 0 0;
                box-shadow: 0 -4px 30px rgba(0, 0, 0, .35), 3px 3px 0 var(--teal-mid);
            }

            .cover-placeholder {
                width: 120px;
                height: 168px;
                border-radius: 8px 8px 0 0;
            }

            .stage-meta {
                padding-bottom: 28px;
            }

            .stage-title {
                font-size: 22px;
            }

            .stage-author {
                font-size: 14px;
            }

            .back-link {
                font-size: 11px;
            }

            /* Body */
            .body-wrap {
                padding: 16px 16px 48px;
            }

            .card {
                padding: 18px 16px;
                margin-bottom: 14px;
                border-radius: 14px;
            }

            /* Disponibilidad: apila verticalmente */
            .avail-block {
                flex-direction: column;
                align-items: flex-start;
                gap: 14px;
            }

            .btn-reservar {
                width: 100%;
                justify-content: center;
                padding: 13px 20px;
                font-size: 15px;
            }

            /* Info: 1 columna */
            .info-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            /* Favorito: apila verticalmente */
            .fav-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .btn-fav {
                width: 100%;
                justify-content: center;
                padding: 11px 18px;
            }

            /* Aviso */
            .notice-card {
                padding: 16px;
                border-radius: 12px;
            }

            .notice-rule {
                font-size: 12.5px;
            }

            /* Relacionados: scroll horizontal compacto */
            .related-list {
                gap: 10px;
            }

            .rel-item {
                min-width: 120px;
                max-width: 120px;
            }

            .rel-thumb {
                height: 100px;
            }
        }

        /* Extra pequeño (≤360px) */
        @media (max-width: 360px) {
            .stage-title {
                font-size: 19px;
            }

            .avail-label {
                font-size: 14px;
            }

            .avail-ring {
                width: 44px;
                height: 44px;
                font-size: 15px;
            }
        }
    </style>
</head>

<body>

    <!-- TOPBAR -->
    <header class="topbar">
        <img src="<?= base_url('/img/insignia.jpg') ?>" alt="Logo" class="topbar-logo">
        <div class="topbar-brand">
            Institución Educativa Chinchaysuyo
            <small>Biblioteca escolar</small>
        </div>
        <div class="topbar-sep"></div>
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
    </header>

    <!-- STAGE -->
    <div class="stage">
        <div class="stage-inner">

            <!-- Cover -->
            <div class="stage-cover">
                <?php if (!empty($libro['portada']) && file_exists('uploads/portadas/' . $libro['portada'])): ?>
                    <img class="cover-img"
                        src="<?= base_url('uploads/portadas/' . $libro['portada']) ?>"
                        alt="<?= esc($libro['titulo']) ?>">
                <?php else: ?>
                    <div class="cover-placeholder"><i class="fas fa-book"></i></div>
                <?php endif; ?>
            </div>

            <!-- Meta -->
            <div class="stage-meta">
                <a href="<?= base_url('catalogo') ?>" class="back-link">
                    <i class="fas fa-arrow-left"></i> Catálogo
                </a>

                <?php if (!empty($libro['categoria'])): ?>
                    <div><span class="cat-pill"><?= esc($libro['categoria']) ?></span></div>
                <?php endif; ?>

                <h1 class="stage-title"><?= esc($libro['titulo']) ?></h1>
                <p class="stage-author">por <span><?= esc($libro['autores'] ?? 'Autor desconocido') ?></span></p>
            </div>

        </div>
    </div>

    <!-- BODY -->
    <div class="body-wrap">

        <!-- ═══ COLUMNA PRINCIPAL ═══ -->
        <div class="col-main">

            <!-- Disponibilidad + botón -->
            <div class="card">
                <div class="avail-block">
                    <div class="avail-left">
                        <div class="avail-ring <?= (int)($libro['disponibles'] ?? 0) > 0 ? 'ok' : 'out' ?>">
                            <i class="fas <?= (int)($libro['disponibles'] ?? 0) > 0 ? 'fa-check' : 'fa-clock' ?>"></i>
                        </div>
                        <div>
                            <?php if ((int)($libro['disponibles'] ?? 0) > 0): ?>
                                <div class="avail-label">Disponible para préstamo</div>
                                <div class="avail-sub"><?= (int)$libro['disponibles'] ?> de <?= (int)$libro['total_ejemplares'] ?> ejemplares libres</div>
                            <?php else: ?>
                                <div class="avail-label">No disponible ahora</div>
                                <div class="avail-sub">Todos los ejemplares están prestados</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ((int)($libro['total_ejemplares'] ?? 0) === 0): ?>
                        <span class="btn-reservar disabled"><i class="fas fa-ban"></i> Sin ejemplares</span>
                    <?php elseif ((int)($libro['disponibles'] ?? 0) > 0): ?>
                        <a href="<?= base_url('biblioteca/reservar/' . ($libro['idrecurso'] ?? '')) ?>" class="btn-reservar">
                            <i class="fas fa-bookmark"></i> Reservar
                        </a>
                    <?php else: ?>
                        <span class="btn-reservar disabled"><i class="fas fa-clock"></i> No disponible</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Información del libro -->
            <div class="card">
                <div class="card-label">Información</div>
                <div class="info-grid">
                    <?php if (!empty($libro['autores'])): ?>
                        <div class="info-item">
                            <div class="info-item-icon"><i class="fas fa-feather-alt"></i></div>
                            <div class="info-item-label">Autor(es)</div>
                            <div class="info-item-value"><?= esc($libro['autores']) ?></div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($libro['anio'])): ?>
                        <div class="info-item">
                            <div class="info-item-icon"><i class="fas fa-calendar-alt"></i></div>
                            <div class="info-item-label">Año de publicación</div>
                            <div class="info-item-value"><?= esc($libro['anio']) ?></div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($libro['numpaginas'])): ?>
                        <div class="info-item">
                            <div class="info-item-icon"><i class="fas fa-file-alt"></i></div>
                            <div class="info-item-label">Páginas</div>
                            <div class="info-item-value"><?= esc($libro['numpaginas']) ?></div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($libro['isbn'])): ?>
                        <div class="info-item">
                            <div class="info-item-icon"><i class="fas fa-barcode"></i></div>
                            <div class="info-item-label">ISBN</div>
                            <div class="info-item-value"><?= esc($libro['isbn']) ?></div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($libro['tipo'])): ?>
                        <div class="info-item">
                            <div class="info-item-icon"><i class="fas fa-tag"></i></div>
                            <div class="info-item-label">Tipo de recurso</div>
                            <div class="info-item-value"><?= esc($libro['tipo']) ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Descripción -->
            <?php if (!empty($libro['descripcion'])): ?>
                <div class="card">
                    <div class="card-label">Descripción</div>
                    <p class="desc-text"><?= esc($libro['descripcion']) ?></p>
                </div>
            <?php endif; ?>

            <!-- Favorito -->
            <div class="card">
                <div class="fav-row">
                    <div>
                        <div class="fav-label">Agregar a favoritos</div>
                        <div class="fav-sub">Guarda este libro en tu lista personal</div>
                    </div>
                    <button class="btn-fav" id="btnFav" data-id="<?= (int)($libro['idrecurso'] ?? 0) ?>">
                        <i class="fa-regular fa-heart"></i> Guardar
                    </button>
                </div>
            </div>

        </div><!-- /col-main -->

        <!-- ═══ COLUMNA LATERAL ═══ -->
        <div class="col-side">

            <!-- Aviso préstamo -->
            <div class="notice-card">
                <div class="notice-head">
                    <i class="fas fa-triangle-exclamation"></i>
                    Antes de reservar
                </div>
                <div class="notice-rule">
                    <i class="fas fa-sun"></i>
                    Devuelve el libro el <strong>mismo día</strong>, antes de que termine el horario escolar.
                </div>
                <div class="notice-rule">
                    <i class="fas fa-star"></i>
                    Regrésalo en las <strong>mismas condiciones</strong> en que lo recibiste.
                </div>
                <div class="notice-rule">
                    <i class="fas fa-hand"></i>
                    Solo puedes tener <strong>un libro prestado</strong> a la vez.
                </div>
                <div class="notice-rule">
                    <i class="fas fa-location-dot"></i>
                    Entrega y devolución solo en la <strong>biblioteca del colegio</strong>.
                </div>
            </div>

            <!-- Libros relacionados -->
            <div class="related-title"><i class="fas fa-layer-group"></i> En esta categoría</div>

            <?php if (!empty($relacionados)): ?>
                <div class="related-list">
                    <?php foreach ($relacionados as $rel): ?>
                        <a href="<?= base_url('biblioteca/detalle/' . $rel['idrecurso']) ?>" class="rel-item">
                            <div class="rel-thumb">
                                <?php if (!empty($rel['portada']) && file_exists('uploads/portadas/' . $rel['portada'])): ?>
                                    <img src="<?= base_url('uploads/portadas/' . $rel['portada']) ?>" alt="<?= esc((string)$rel['titulo']) ?>">
                                <?php else: ?>
                                    <i class="fas fa-book"></i>
                                <?php endif; ?>
                            </div>
                            <div class="rel-meta">
                                <div class="rel-titulo"><?= esc((string)$rel['titulo']) ?></div>
                                <div class="rel-autor"><?= esc((string)($rel['autores'] ?? 'Sin autor')) ?></div>
                                <span class="rel-avail"><?= (int)$rel['cantidad_disponible'] ?> disponible(s)</span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="rel-empty">
                    <i class="fas fa-book-open" style="display:block;font-size:1.6rem;margin-bottom:8px;color:#c8d5df;"></i>
                    No hay más libros en esta categoría
                </div>
            <?php endif; ?>

        </div><!-- /col-side -->
    </div><!-- /body-wrap -->

    <script>
        /* ── dropdown ── */
        const userBtn = document.getElementById('userBtn');
        const userDd = document.getElementById('userDd');
        userBtn.addEventListener('click', e => {
            e.stopPropagation();
            const open = userDd.classList.toggle('open');
            userBtn.setAttribute('aria-expanded', open);
        });
        document.addEventListener('click', () => userDd.classList.remove('open'));

        /* ── favoritos ── */
        const btnFav = document.getElementById('btnFav');
        const libroId = Number(btnFav.dataset.id);

        fetch("<?= base_url('favoritos/ids') ?>")
            .then(r => r.json())
            .then(ids => {
                if (new Set(ids.map(Number)).has(libroId)) activarFav();
            })
            .catch(() => {});

        btnFav.addEventListener('click', () => {
            fetch("<?= base_url('favoritos/toggle') ?>", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        idrecurso: libroId
                    })
                })
                .then(r => r.json())
                .then(d => d.favorito ? activarFav() : desactivarFav())
                .catch(() => alert('Error al actualizar favoritos.'));
        });

        function activarFav() {
            btnFav.classList.add('activo');
            btnFav.innerHTML = '<i class="fa-solid fa-heart"></i> Guardado';
        }

        function desactivarFav() {
            btnFav.classList.remove('activo');
            btnFav.innerHTML = '<i class="fa-regular fa-heart"></i> Guardar';
        }
    </script>

</body>

</html>