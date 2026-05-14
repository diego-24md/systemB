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
    <link rel="stylesheet" href="<?= base_url('css/biblioteca/reservar.css') ?>">
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