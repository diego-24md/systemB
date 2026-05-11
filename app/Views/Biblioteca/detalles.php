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
    <title><?= esc((string)($libro['titulo'] ?? 'Libro')) ?> - Biblioteca</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: #f4f6f9;
            color: #333;
        }

        /* ==================== HEADER ==================== */
        .header {
            background: linear-gradient(135deg, #ffcc00 30%, #b8001e 35%);
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
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
        }

        .header-text p {
            color: rgba(255, 255, 255, 0.75);
            font-size: 13px;
            margin-top: 2px;
        }

        .header-actions {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-menu-wrap {
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
            white-space: nowrap;
            transition: background 0.2s;
        }

        .user-btn:hover {
            background: rgba(255, 255, 255, 0.28);
        }

        .user-btn i {
            font-size: 18px;
        }

        .user-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            min-width: 190px;
            z-index: 200;
            overflow: hidden;
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

        /* ==================== HERO BANNER ==================== */
        .hero-banner {
            background: linear-gradient(135deg, #1a1a2e 0%, #2d1b3d 50%, #b8001e 100%);
            padding: 48px 20px 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .hero-back {
            position: absolute;
            top: 20px;
            left: 20px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .hero-back:hover {
            color: white;
        }

        .hero-cover-wrap {
            display: inline-block;
            margin-bottom: 24px;
        }

        .hero-cover {
            width: 160px;
            height: 220px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            display: block;
        }

        .hero-cover-placeholder {
            width: 160px;
            height: 220px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.3);
            font-size: 3.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        .hero-titulo {
            color: white;
            font-size: 24px;
            font-weight: 700;
            max-width: 600px;
            margin: 0 auto 8px;
            line-height: 1.3;
        }

        .hero-autor {
            color: rgba(255, 255, 255, 0.7);
            font-size: 15px;
            margin-bottom: 16px;
        }

        .hero-categoria {
            display: inline-block;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 14px;
            border-radius: 20px;
            letter-spacing: 0.05em;
        }

        /* ==================== MAIN ==================== */
        .main {
            max-width: 680px;
            margin: -40px auto 0;
            padding: 0 20px;
            position: relative;
            z-index: 10;
        }

        /* ==================== CARDS ==================== */
        .disp-card {
            background: white;
            border-radius: 16px;
            padding: 20px 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .disp-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .disp-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .disp-dot.verde {
            background: #22c55e;
            box-shadow: 0 0 8px rgba(34, 197, 94, 0.5);
        }

        .disp-dot.rojo {
            background: #ef4444;
            box-shadow: 0 0 8px rgba(239, 68, 68, 0.5);
        }

        .disp-texto strong {
            display: block;
            font-size: 15px;
            color: #1a1a1a;
        }

        .disp-texto span {
            font-size: 13px;
            color: #888;
        }

        .btn-reservar {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 24px;
            background: #b8001e;
            color: white;
            border-radius: 10px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(184, 0, 30, 0.3);
        }

        .btn-reservar:hover {
            background: #8f0017;
            transform: translateY(-1px);
        }

        .btn-reservar.disabled {
            background: #e2e8f0;
            color: #94a3b8;
            cursor: not-allowed;
            pointer-events: none;
            box-shadow: none;
        }

        .info-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            margin-bottom: 16px;
        }

        .info-card-title {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
            margin-bottom: 16px;
        }

        .info-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .info-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .info-row-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #f4f6f9;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #b8001e;
            font-size: 14px;
            flex-shrink: 0;
        }

        .info-row-label {
            font-size: 12px;
            color: #94a3b8;
            margin-bottom: 1px;
        }

        .info-row-value {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }

        .desc-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            margin-bottom: 16px;
        }

        .desc-card-title {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
            margin-bottom: 12px;
        }

        .desc-text {
            font-size: 15px;
            color: #4a5568;
            line-height: 1.8;
        }

        .fav-card {
            background: white;
            border-radius: 16px;
            padding: 20px 24px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 16px;
        }

        .fav-card-text strong {
            display: block;
            font-size: 15px;
            color: #1a1a1a;
        }

        .fav-card-text span {
            font-size: 13px;
            color: #888;
        }

        .btn-fav-toggle {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: white;
            color: #b8001e;
            border: 1.5px solid #b8001e;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s;
        }

        .btn-fav-toggle:hover {
            background: #fff5f5;
        }

        .btn-fav-toggle.activo {
            background: #b8001e;
            color: white;
        }

        .btn-fav-toggle.activo:hover {
            background: #8f0017;
        }

        /* ==================== AVISO PRÉSTAMO ==================== */
        .aviso-card {
            background: linear-gradient(135deg, #1a1a2e, #b8001e);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 16px rgba(184, 0, 30, 0.2);
            margin-bottom: 16px;
            color: white;
        }

        .aviso-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }

        .aviso-header i {
            font-size: 20px;
            color: #ffcc00;
        }

        .aviso-header strong {
            font-size: 15px;
            font-weight: 700;
        }

        .aviso-reglas {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .aviso-regla {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 13.5px;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.5;
        }

        .aviso-regla i {
            color: #ffcc00;
            margin-top: 2px;
            font-size: 13px;
            flex-shrink: 0;
        }

        /* ==================== LIBROS RELACIONADOS ==================== */
        .relacionados-section {
            margin-bottom: 40px;
        }

        .relacionados-title {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .scroll-wrap {
            display: flex;
            gap: 14px;
            overflow-x: auto;
            padding-bottom: 12px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .scroll-wrap::-webkit-scrollbar {
            display: none;
        }

        .rel-card {
            background: white;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
            overflow: hidden;
            flex-shrink: 0;
            width: 140px;
            display: flex;
            flex-direction: column;
            text-decoration: none;
            transition: transform 0.2s;
        }

        .rel-card:hover {
            transform: translateY(-4px);
        }

        .rel-cover {
            width: 100%;
            height: 160px;
            background: #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .rel-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .rel-cover i {
            font-size: 2.5rem;
            color: #ccc;
        }

        .rel-info {
            padding: 10px 12px;
        }

        .rel-titulo {
            font-size: 12.5px;
            font-weight: 600;
            color: #1e293b;
            line-height: 1.3;
            margin-bottom: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .rel-autor {
            font-size: 11px;
            color: #94a3b8;
            margin-bottom: 8px;
        }

        .rel-badge {
            display: inline-block;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
            background: #e6f9ee;
            color: #1a7f3c;
        }

        .rel-vacio {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            text-align: center;
            color: #94a3b8;
            font-size: 14px;
        }

        @media (max-width: 600px) {
            .hero-titulo {
                font-size: 20px;
            }

            .disp-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .fav-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .user-btn span {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <img src="<?= base_url('/img/insignia.jpg') ?>" alt="Logo">
        <div class="header-text">
            <h1>Institución Educativa Chinchaysuyo</h1>
            <p>Biblioteca escolar</p>
        </div>
        <div class="header-actions">
            <div class="user-menu-wrap">
                <button class="user-btn" id="userBtn" aria-expanded="false">
                    <i class="fa-solid fa-circle-user"></i>
                    <span><?= htmlspecialchars($alumnaNombre) ?></span>
                    <i class="fa-solid fa-chevron-down" style="font-size:11px;opacity:0.7;"></i>
                </button>
                <div class="user-dropdown" id="userDropdown">
                    <div class="dropdown-header">
                        <span>Conectada como</span>
                        <strong><?= htmlspecialchars($alumnaNombre) ?></strong>
                    </div>
                    <a href="<?= base_url('alumnas/logout') ?>" class="dropdown-logout">
                        <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- HERO BANNER -->
    <div class="hero-banner">
        <a href="<?= base_url('catalogo') ?>" class="hero-back">
            <i class="fa-solid fa-arrow-left"></i> Volver
        </a>
        <div class="hero-cover-wrap">
            <?php if (!empty($libro['portada']) && file_exists('uploads/portadas/' . $libro['portada'])): ?>
                <img class="hero-cover"
                    src="<?= base_url('uploads/portadas/' . $libro['portada']) ?>"
                    alt="<?= esc($libro['titulo']) ?>">
            <?php else: ?>
                <div class="hero-cover-placeholder"><i class="fas fa-book"></i></div>
            <?php endif; ?>
        </div>
        <h1 class="hero-titulo"><?= esc($libro['titulo']) ?></h1>
        <p class="hero-autor"><?= esc($libro['autores'] ?? 'Sin autor') ?></p>
        <?php if (!empty($libro['categoria'])): ?>
            <span class="hero-categoria"><?= esc($libro['categoria']) ?></span>
        <?php endif; ?>
    </div>

    <!-- MAIN -->
    <div class="main">

        <!-- Disponibilidad -->
        <div class="disp-card">
            <div class="disp-info">
                <div class="disp-dot <?= (int)($libro['disponibles'] ?? 0) > 0 ? 'verde' : 'rojo' ?>"></div>
                <div class="disp-texto">
                    <?php if ((int)($libro['disponibles'] ?? 0) > 0): ?>
                        <strong>Disponible para préstamo</strong>
                        <span><?= (int)$libro['disponibles'] ?> de <?= (int)$libro['total_ejemplares'] ?> ejemplares libres</span>
                    <?php else: ?>
                        <strong>No disponible</strong>
                        <span>Todos los ejemplares están prestados</span>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ((int)($libro['total_ejemplares'] ?? 0) === 0): ?>
                <a class="btn-reservar disabled"><i class="fas fa-ban"></i> Sin ejemplares</a>
            <?php elseif ((int)($libro['disponibles'] ?? 0) > 0): ?>
                <a href="<?= base_url('biblioteca/reservar/' . ($libro['idrecurso'] ?? '')) ?>" class="btn-reservar">
                    <i class="fas fa-bookmark"></i> Reservar
                </a>
            <?php else: ?>
                <a class="btn-reservar disabled"><i class="fas fa-clock"></i> No disponible</a>
            <?php endif; ?>
        </div>

        <!-- Info del libro -->
        <div class="info-card">
            <div class="info-card-title">Información del libro</div>
            <div class="info-list">
                <?php if (!empty($libro['autores'])): ?>
                    <div class="info-row">
                        <div class="info-row-icon"><i class="fas fa-user-edit"></i></div>
                        <div>
                            <div class="info-row-label">Autor(es)</div>
                            <div class="info-row-value"><?= esc($libro['autores']) ?></div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($libro['anio'])): ?>
                    <div class="info-row">
                        <div class="info-row-icon"><i class="fas fa-calendar"></i></div>
                        <div>
                            <div class="info-row-label">Año de publicación</div>
                            <div class="info-row-value"><?= esc($libro['anio']) ?></div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($libro['numpaginas'])): ?>
                    <div class="info-row">
                        <div class="info-row-icon"><i class="fas fa-file-alt"></i></div>
                        <div>
                            <div class="info-row-label">Páginas</div>
                            <div class="info-row-value"><?= esc($libro['numpaginas']) ?></div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($libro['isbn'])): ?>
                    <div class="info-row">
                        <div class="info-row-icon"><i class="fas fa-barcode"></i></div>
                        <div>
                            <div class="info-row-label">ISBN</div>
                            <div class="info-row-value"><?= esc($libro['isbn']) ?></div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($libro['tipo'])): ?>
                    <div class="info-row">
                        <div class="info-row-icon"><i class="fas fa-tag"></i></div>
                        <div>
                            <div class="info-row-label">Tipo de recurso</div>
                            <div class="info-row-value"><?= esc($libro['tipo']) ?></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Descripción -->
        <?php if (!empty($libro['descripcion'])): ?>
            <div class="desc-card">
                <div class="desc-card-title">Descripción</div>
                <p class="desc-text"><?= esc($libro['descripcion']) ?></p>
            </div>
        <?php endif; ?>

        <!-- Favorito -->
        <div class="fav-card">
            <div class="fav-card-text">
                <strong>¿Te gustó este libro?</strong>
                <span>Agrégalo a tu lista de favoritos</span>
            </div>
            <button class="btn-fav-toggle" id="btnFavToggle"
                data-id="<?= (int)($libro['idrecurso'] ?? 0) ?>">
                <i class="fa-regular fa-heart"></i> Guardar
            </button>
        </div>

        <!-- ==================== AVISO PRÉSTAMO ==================== -->
        <div class="aviso-card">
            <div class="aviso-header">
                <i class="fas fa-exclamation-circle"></i>
                <strong>Recuerda antes de pedir un préstamo</strong>
            </div>
            <div class="aviso-reglas">
                <div class="aviso-regla">
                    <i class="fas fa-clock"></i>
                    El libro debe ser devuelto el <strong>mismo día</strong> antes de que termine el horario escolar.
                </div>
                <div class="aviso-regla">
                    <i class="fas fa-book"></i>
                    Devuelve el libro en las <strong>mismas condiciones</strong> en que lo recibiste.
                </div>
                <div class="aviso-regla">
                    <i class="fas fa-hand-paper"></i>
                    Solo puedes tener <strong>un libro prestado</strong> a la vez.
                </div>
                <div class="aviso-regla">
                    <i class="fas fa-map-marker-alt"></i>
                    La entrega y devolución se realiza únicamente en la <strong>biblioteca del colegio</strong>.
                </div>
            </div>
        </div>

        <!-- ==================== LIBROS RELACIONADOS ==================== -->
        <div class="relacionados-section">
            <div class="relacionados-title">
                <i class="fas fa-th-large"></i>
                Más libros disponibles en esta categoría
            </div>

            <?php if (!empty($relacionados)): ?>
                <div class="scroll-wrap">
                    <?php foreach ($relacionados as $rel): ?>
                        <a href="<?= base_url('biblioteca/detalle/' . $rel['idrecurso']) ?>" class="rel-card">
                            <div class="rel-cover">
                                <?php if (!empty($rel['portada']) && file_exists('uploads/portadas/' . $rel['portada'])): ?>
                                    <img src="<?= base_url('uploads/portadas/' . $rel['portada']) ?>"
                                        alt="<?= esc((string)$rel['titulo']) ?>">
                                <?php else: ?>
                                    <i class="fas fa-book"></i>
                                <?php endif; ?>
                            </div>
                            <div class="rel-info">
                                <div class="rel-titulo"><?= esc((string)$rel['titulo']) ?></div>
                                <div class="rel-autor"><?= esc((string)$rel['autores'] ?? 'Sin autor') ?></div>
                                <span class="rel-badge">
                                    <?= (int)$rel['cantidad_disponible'] ?> disponible(s)
                                </span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="rel-vacio">
                    <i class="fas fa-books" style="font-size:1.8rem;display:block;margin-bottom:8px;color:#e2e8f0;"></i>
                    No hay otros libros disponibles en esta categoría
                </div>
            <?php endif; ?>
        </div>

    </div>

    <script>
        const userBtn = document.getElementById('userBtn');
        const userDropdown = document.getElementById('userDropdown');

        userBtn.addEventListener('click', e => {
            e.stopPropagation();
            const open = userDropdown.classList.toggle('open');
            userBtn.setAttribute('aria-expanded', open);
        });

        document.addEventListener('click', () => {
            userDropdown.classList.remove('open');
        });

        const btnFav = document.getElementById('btnFavToggle');
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
                .then(data => {
                    if (data.favorito) activarFav();
                    else desactivarFav();
                })
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