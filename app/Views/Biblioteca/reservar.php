<?php

/**
 * @var array{
 *   titulo: string,
 *   autores: string,
 *   portada: string|null,
 *   categoria: string|null,
 *   disponibles: int,
 *   total_ejemplares: int,
 *   idactivo: int,
 *   idrecurso: int
 * } $libro
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
    <title>Reservar — <?= esc($libro['titulo']) ?></title>
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
            background: rgba(255, 255, 255, .16);
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
            border: 1px solid var(--border);
        }

        .user-dd.open {
            display: block;
        }

        .dd-head {
            padding: 14px 18px 12px;
            border-bottom: 1px solid var(--border);
            background: var(--sand);
        }

        .dd-head small {
            display: block;
            font-size: 11px;
            color: var(--ink-light);
            text-transform: uppercase;
            letter-spacing: .04em;
            margin-bottom: 2px;
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

        /* ── PÁGINA ─────────────────────────────── */
        .page {
            max-width: 560px;
            margin: 0 auto;
            padding: 36px 24px 60px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--ink-light);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            margin-bottom: 24px;
            transition: color .2s;
        }

        .back-link:hover {
            color: var(--ink);
        }

        /* ── LIBRO CARD (resumen) ───────────────── */
        .libro-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            display: flex;
            gap: 18px;
            align-items: center;
            margin-bottom: 24px;
            box-shadow: 0 2px 12px rgba(27, 36, 54, .06);
        }

        .libro-cover {
            width: 72px;
            height: 100px;
            border-radius: 8px;
            object-fit: cover;
            background: var(--sand);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 1px solid var(--border);
            color: #ccc;
            font-size: 1.8rem;
        }

        .libro-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .libro-meta {
            min-width: 0;
        }

        .libro-titulo {
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: 18px;
            color: var(--ink);
            line-height: 1.25;
            margin-bottom: 5px;
        }

        .libro-autor {
            font-size: 13px;
            color: var(--ink-light);
            margin-bottom: 10px;
        }

        .libro-disp {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
            color: var(--teal);
            background: var(--teal-pale);
            padding: 3px 10px;
            border-radius: 20px;
        }

        .libro-disp i {
            font-size: 10px;
        }

        /* ── FLASH MENSAJES ─────────────────────── */
        .flash {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .flash.error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .flash.success {
            background: var(--teal-pale);
            color: var(--teal);
            border: 1px solid rgba(29, 158, 117, .3);
        }

        /* ── FORMULARIO ─────────────────────────── */
        .form-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 28px 26px;
            box-shadow: 0 2px 12px rgba(27, 36, 54, .06);
            margin-bottom: 20px;
        }

        .form-title {
            font-size: 10.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: var(--ink-light);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .confirm-row {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid var(--border);
        }

        .confirm-row:last-of-type {
            border-bottom: none;
            padding-bottom: 0;
        }

        .confirm-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: var(--teal-pale);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--teal);
            font-size: 14px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .confirm-label {
            font-size: 11px;
            color: var(--ink-light);
            text-transform: uppercase;
            letter-spacing: .05em;
            margin-bottom: 3px;
        }

        .confirm-value {
            font-size: 14px;
            font-weight: 500;
            color: var(--ink);
        }

        /* ── AVISO ──────────────────────────────── */
        .aviso {
            background: var(--amber-pale);
            border: 1px solid rgba(186, 117, 23, .2);
            border-left: 4px solid var(--amber);
            border-radius: 12px;
            padding: 16px 18px;
            margin-bottom: 24px;
        }

        .aviso-head {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--amber);
            margin-bottom: 10px;
        }

        .aviso-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            font-size: 12.5px;
            color: #5a4010;
            line-height: 1.55;
            margin-bottom: 8px;
        }

        .aviso-item:last-child {
            margin-bottom: 0;
        }

        .aviso-item i {
            color: var(--amber);
            font-size: 11px;
            margin-top: 3px;
            flex-shrink: 0;
        }

        /* ── BOTONES ─────────────────────────────── */
        .btn-confirmar {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            width: 100%;
            padding: 14px 24px;
            background: var(--teal);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            letter-spacing: .01em;
            transition: background .2s, transform .15s;
            box-shadow: 0 4px 16px rgba(15, 110, 86, .25);
            margin-bottom: 12px;
        }

        .btn-confirmar:hover {
            background: var(--teal-mid);
            transform: translateY(-1px);
        }

        .btn-confirmar:active {
            transform: translateY(0);
        }

        .btn-cancelar {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px 24px;
            background: transparent;
            color: var(--ink-light);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            font-family: inherit;
            text-decoration: none;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-cancelar:hover {
            border-color: var(--ink-light);
            color: var(--ink);
            background: var(--sand);
        }

        /* ── RESPONSIVE ─────────────────────────── */
        @media (max-width: 520px) {
            .topbar {
                padding: 0 16px;
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

            .page {
                padding: 24px 16px 48px;
            }

            .libro-card {
                padding: 16px;
                gap: 14px;
            }

            .libro-titulo {
                font-size: 16px;
            }

            .form-card {
                padding: 20px 18px;
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

    <!-- CONTENIDO -->
    <div class="page">

        <a href="<?= base_url('biblioteca/detalle/' . $libro['idrecurso']) ?>" class="back-link">
            <i class="fas fa-arrow-left"></i> Volver al detalle
        </a>

        <!-- Flash de error -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="flash error">
                <i class="fas fa-circle-exclamation"></i>
                <?= esc((string)session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <!-- Resumen del libro -->
        <div class="libro-card">
            <div class="libro-cover">
                <?php if (!empty($libro['portada']) && file_exists('uploads/portadas/' . $libro['portada'])): ?>
                    <img src="<?= base_url('uploads/portadas/' . $libro['portada']) ?>" alt="<?= esc($libro['titulo']) ?>">
                <?php else: ?>
                    <i class="fas fa-book"></i>
                <?php endif; ?>
            </div>
            <div class="libro-meta">
                <div class="libro-titulo"><?= esc($libro['titulo']) ?></div>
                <div class="libro-autor">por <?= esc($libro['autores']) ?></div>
                <span class="libro-disp">
                    <i class="fas fa-check-circle"></i>
                    <?= $libro['disponibles'] ?> de <?= $libro['total_ejemplares'] ?> disponibles
                </span>
            </div>
        </div>

        <!-- Aviso -->
        <div class="aviso">
            <div class="aviso-head"><i class="fas fa-triangle-exclamation"></i> Antes de confirmar</div>
            <div class="aviso-item"><i class="fas fa-sun"></i> El libro debe devolverse el <strong>mismo día</strong> antes del fin del horario escolar.</div>
            <div class="aviso-item"><i class="fas fa-hand"></i> Solo puedes tener <strong>un libro prestado</strong> a la vez.</div>
            <div class="aviso-item"><i class="fas fa-location-dot"></i> Recoge y devuelve el libro en la <strong>biblioteca del colegio</strong>.</div>
        </div>

        <!-- Formulario de confirmación -->
        <div class="form-card">
            <div class="form-title">Confirmación de reserva</div>

            <div class="confirm-row">
                <div class="confirm-icon"><i class="fas fa-user"></i></div>
                <div>
                    <div class="confirm-label">Alumna</div>
                    <div class="confirm-value"><?= htmlspecialchars($alumnaNombre) ?></div>
                </div>
            </div>

            <div class="confirm-row">
                <div class="confirm-icon"><i class="fas fa-book"></i></div>
                <div>
                    <div class="confirm-label">Libro</div>
                    <div class="confirm-value"><?= esc($libro['titulo']) ?></div>
                </div>
            </div>

            <div class="confirm-row">
                <div class="confirm-icon"><i class="fas fa-calendar-day"></i></div>
                <div>
                    <div class="confirm-label">Fecha de préstamo</div>
                    <div class="confirm-value"><?= date('d/m/Y') ?></div>
                </div>
            </div>

            <div class="confirm-row">
                <div class="confirm-icon"><i class="fas fa-star"></i></div>
                <div>
                    <div class="confirm-label">Condición del libro</div>
                    <div class="confirm-value">Bueno</div>
                </div>
            </div>
        </div>

        <!-- Formulario POST -->
        <form action="<?= base_url('biblioteca/procesarReserva') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="idactivo" value="<?= (int)$libro['idactivo'] ?>">
            <input type="hidden" name="idrecurso" value="<?= (int)$libro['idrecurso'] ?>">

            <button type="submit" class="btn-confirmar">
                <i class="fas fa-bookmark"></i> Confirmar reserva
            </button>
        </form>

        <a href="<?= base_url('biblioteca/detalle/' . $libro['idrecurso']) ?>" class="btn-cancelar">
            <i class="fas fa-xmark"></i> Cancelar
        </a>

    </div>

    <script>
        const userBtn = document.getElementById('userBtn');
        const userDd = document.getElementById('userDd');
        userBtn.addEventListener('click', e => {
            e.stopPropagation();
            const open = userDd.classList.toggle('open');
            userBtn.setAttribute('aria-expanded', open);
        });
        document.addEventListener('click', () => userDd.classList.remove('open'));
    </script>

</body>

</html>