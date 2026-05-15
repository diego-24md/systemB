<?php
if (! session()->get('alumna_id')) {
    return redirect()->to(base_url('login'));
}
$alumnaNombre = (string)(session()->get('alumna_nombre') ?? 'Alumna');
$alumnaId     = (int) session()->get('alumna_id');

/** @var array $rankingAlumnas */
/** @var array $rankingAulas */
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Más lectoras — Biblioteca</title>
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
            --gold: #f59e0b;
            --silver: #94a3b8;
            --bronze: #d97706;
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

        /* ── HERO ───────────────────────────────── */
        .hero {
            background: var(--ink);
            padding: 40px 24px 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255, 255, 255, .05) 1px, transparent 1px);
            background-size: 28px 28px;
        }

        .hero-back {
            position: absolute;
            top: 18px;
            left: 20px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: rgba(255, 255, 255, .6);
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: .04em;
            transition: color .2s;
        }

        .hero-back:hover {
            color: #fff;
        }

        .hero-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), #d97706);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            box-shadow: 0 8px 24px rgba(245, 158, 11, .4);
            font-size: 1.6rem;
            color: #fff;
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: clamp(22px, 4vw, 30px);
            color: #fff;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .hero-sub {
            font-size: 14px;
            color: rgba(255, 255, 255, .55);
            position: relative;
            z-index: 1;
        }

        /* ── MAIN ───────────────────────────────── */
        .main {
            max-width: 720px;
            margin: -40px auto 0;
            padding: 0 20px 60px;
            position: relative;
            z-index: 10;
        }

        /* ── TABS ───────────────────────────────── */
        .tabs {
            display: flex;
            gap: 4px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px 14px 0 0;
            padding: 6px;
            box-shadow: 0 2px 12px rgba(27, 36, 54, .06);
        }

        .tab-btn {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 10px;
            background: transparent;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            color: var(--ink-light);
            cursor: pointer;
            transition: all .18s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
        }

        .tab-btn.active {
            background: var(--ink);
            color: #fff;
        }

        .tab-btn:not(.active):hover {
            background: var(--sand);
            color: var(--ink);
        }

        .tab-panel {
            display: none;
        }

        .tab-panel.active {
            display: block;
        }

        /* ── CARD ───────────────────────────────── */
        .ranking-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-top: none;
            border-radius: 0 0 16px 16px;
            padding: 24px;
            box-shadow: 0 4px 16px rgba(27, 36, 54, .06);
            margin-bottom: 20px;
        }

        /* ── PODIO TOP 3 ────────────────────────── */
        .podio {
            display: flex;
            align-items: flex-end;
            justify-content: center;
            gap: 12px;
            margin-bottom: 28px;
            padding: 0 8px;
        }

        .podio-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            max-width: 150px;
        }

        .podio-corona {
            font-size: 1.2rem;
            margin-bottom: 4px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .podio-avatar {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 8px;
            flex-shrink: 0;
        }

        .podio-avatar.oro {
            background: linear-gradient(135deg, #fbbf24, #d97706);
            box-shadow: 0 4px 16px rgba(251, 191, 36, .4);
        }

        .podio-avatar.plata {
            background: linear-gradient(135deg, #cbd5e1, #94a3b8);
            box-shadow: 0 4px 16px rgba(148, 163, 184, .35);
        }

        .podio-avatar.bronce {
            background: linear-gradient(135deg, #fb923c, #c2410c);
            box-shadow: 0 4px 16px rgba(251, 146, 60, .35);
        }

        .podio-nombre {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--ink);
            text-align: center;
            line-height: 1.3;
            margin-bottom: 2px;
        }

        .podio-grado {
            font-size: 0.7rem;
            color: var(--ink-light);
            text-align: center;
            margin-bottom: 8px;
        }

        .podio-barra {
            width: 100%;
            border-radius: 8px 8px 0 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 8px 0;
        }

        .podio-barra.oro {
            background: linear-gradient(135deg, #fbbf24, #d97706);
        }

        .podio-barra.plata {
            background: linear-gradient(135deg, #cbd5e1, #94a3b8);
        }

        .podio-barra.bronce {
            background: linear-gradient(135deg, #fb923c, #c2410c);
        }

        /* orden visual: plata izq, oro centro, bronce der */
        .podio-item.pos-1 {
            order: 2;
        }

        .podio-item.pos-2 {
            order: 1;
        }

        .podio-item.pos-3 {
            order: 3;
        }

        .podio-item.pos-1 .podio-barra {
            min-height: 80px;
        }

        .podio-item.pos-2 .podio-barra {
            min-height: 56px;
        }

        .podio-item.pos-3 .podio-barra {
            min-height: 44px;
        }

        /* ── LISTA RESTO ────────────────────────── */
        .rank-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .rank-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border: 1px solid var(--border);
            border-radius: 12px;
            transition: border-color .18s, background .18s;
        }

        .rank-item:hover {
            background: var(--sand);
            border-color: rgba(27, 36, 54, .18);
        }

        .rank-item.es-yo {
            border-color: var(--teal-mid);
            background: var(--teal-pale);
        }

        .rank-num {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--sand);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: var(--ink-light);
            flex-shrink: 0;
        }

        .rank-info {
            flex: 1;
            min-width: 0;
        }

        .rank-nombre {
            font-size: 14px;
            font-weight: 600;
            color: var(--ink);
        }

        .rank-grado {
            font-size: 11.5px;
            color: var(--ink-light);
            margin-top: 1px;
        }

        .rank-badge {
            font-size: 12px;
            font-weight: 700;
            background: var(--teal-pale);
            color: var(--teal);
            padding: 3px 10px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .yo-tag {
            font-size: 10px;
            font-weight: 700;
            background: var(--teal);
            color: #fff;
            padding: 2px 8px;
            border-radius: 20px;
            margin-left: 6px;
        }

        /* ── AULAS ──────────────────────────────── */
        .aula-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            border: 1px solid var(--border);
            border-radius: 12px;
            margin-bottom: 10px;
            transition: all .18s;
        }

        .aula-item:hover {
            background: var(--sand);
            border-color: rgba(27, 36, 54, .18);
        }

        .aula-pos {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .aula-pos.p1 {
            background: linear-gradient(135deg, #fbbf24, #d97706);
        }

        .aula-pos.p2 {
            background: linear-gradient(135deg, #cbd5e1, #94a3b8);
        }

        .aula-pos.p3 {
            background: linear-gradient(135deg, #fb923c, #c2410c);
        }

        .aula-pos.pn {
            background: var(--sand);
            color: var(--ink-light);
            border: 1px solid var(--border);
        }

        .aula-info {
            flex: 1;
        }

        .aula-nombre {
            font-size: 14px;
            font-weight: 700;
            color: var(--ink);
        }

        .aula-detalle {
            font-size: 12px;
            color: var(--ink-light);
            margin-top: 2px;
        }

        .aula-barra-wrap {
            flex: 1;
            max-width: 160px;
        }

        .aula-barra-bg {
            background: var(--sand);
            border-radius: 20px;
            height: 8px;
            overflow: hidden;
        }

        .aula-barra-fill {
            height: 100%;
            border-radius: 20px;
            background: linear-gradient(90deg, var(--teal), var(--teal-mid));
            transition: width .6s ease;
        }

        .aula-count {
            font-size: 13px;
            font-weight: 700;
            color: var(--teal);
            white-space: nowrap;
            min-width: 60px;
            text-align: right;
        }

        .empty-rank {
            text-align: center;
            padding: 40px 20px;
            color: var(--ink-light);
            font-size: 14px;
        }

        .empty-rank i {
            display: block;
            font-size: 2rem;
            color: #ccc;
            margin-bottom: 10px;
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

            .main {
                padding: 0 14px 48px;
            }

            .hero {
                padding: 32px 16px 70px;
            }

            .podio {
                gap: 8px;
            }

            .podio-avatar {
                width: 44px;
                height: 44px;
                font-size: 1rem;
            }

            .aula-barra-wrap {
                display: none;
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

    <!-- HERO -->
    <div class="hero">
        <a href="<?= base_url('catalogo') ?>" class="hero-back">
            <i class="fas fa-arrow-left"></i> Catálogo
        </a>
        <div class="hero-icon"><i class="fas fa-trophy"></i></div>
        <h1 class="hero-title">Más lectoras</h1>
        <p class="hero-sub">Ranking de alumnas y aulas que más libros han leído</p>
    </div>

    <!-- MAIN -->
    <div class="main">

        <!-- TABS -->
        <div class="tabs">
            <button class="tab-btn active" onclick="cambiarTab('alumnas')" id="tab-alumnas">
                <i class="fas fa-user"></i> Alumnas
            </button>
            <button class="tab-btn" onclick="cambiarTab('aulas')" id="tab-aulas">
                <i class="fas fa-school"></i> Aulas
            </button>
        </div>

        <!-- TAB ALUMNAS -->
        <div class="tab-panel active ranking-card" id="panel-alumnas">
            <?php if (!empty($rankingAlumnas)): ?>

                <!-- PODIO TOP 3 -->
                <?php $top3 = array_slice($rankingAlumnas, 0, 3); ?>
                <?php $clases = ['oro', 'plata', 'bronce']; ?>
                <?php $coronas = ['👑', '🥈', '🥉']; ?>

                <div class="podio">
                    <?php foreach ($top3 as $i => $a): ?>
                        <div class="podio-item pos-<?= $i + 1 ?>">
                            <div class="podio-corona"><?= $coronas[$i] ?></div>
                            <div class="podio-avatar <?= $clases[$i] ?>">
                                <?= mb_strtoupper(mb_substr((string)$a['nombre'], 0, 1)) ?>
                            </div>
                            <div class="podio-nombre"><?= esc((string)$a['nombre']) ?></div>
                            <div class="podio-grado"><?= esc((string)($a['grado'] ?? '')) ?> <?= esc((string)($a['seccion'] ?? '')) ?></div>
                            <div class="podio-barra <?= $clases[$i] ?>">
                                <?= (int)$a['total_prestamos'] ?> libros
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- RESTO DE LA LISTA -->
                <?php $resto = array_slice($rankingAlumnas, 3); ?>
                <?php if (!empty($resto)): ?>
                    <div class="rank-list">
                        <?php foreach ($resto as $i => $a): ?>
                            <?php $esYo = (int)$a['idalumna'] === $alumnaId; ?>
                            <div class="rank-item <?= $esYo ? 'es-yo' : '' ?>">
                                <div class="rank-num"><?= $i + 4 ?></div>
                                <div class="rank-info">
                                    <div class="rank-nombre">
                                        <?= esc((string)$a['nombre']) ?>
                                        <?php if ($esYo): ?><span class="yo-tag">Tú</span><?php endif; ?>
                                    </div>
                                    <div class="rank-grado"><?= esc((string)($a['grado'] ?? '')) ?> <?= esc((string)($a['seccion'] ?? '')) ?></div>
                                </div>
                                <div class="rank-badge"><?= (int)$a['total_prestamos'] ?> libro(s)</div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="empty-rank">
                    <i class="fas fa-trophy"></i>
                    <p>Aún no hay préstamos registrados</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- TAB AULAS -->
        <div class="tab-panel ranking-card" id="panel-aulas">
            <?php if (!empty($rankingAulas)): ?>
                <?php
                $maxAula = max(array_column($rankingAulas, 'total_prestamos'));
                $posClases = ['p1', 'p2', 'p3'];
                ?>
                <?php foreach ($rankingAulas as $i => $au): ?>
                    <?php $pct = $maxAula > 0 ? round(((int)$au['total_prestamos'] / $maxAula) * 100) : 0; ?>
                    <div class="aula-item">
                        <div class="aula-pos <?= $posClases[$i] ?? 'pn' ?>">
                            <?= $i + 1 ?>
                        </div>
                        <div class="aula-info">
                            <div class="aula-nombre"><?= esc((string)($au['grado'] ?? '')) ?> — <?= esc((string)($au['seccion'] ?? '')) ?></div>
                            <div class="aula-detalle"><?= (int)$au['total_alumnas'] ?> alumna(s) activas</div>
                        </div>
                        <div class="aula-barra-wrap">
                            <div class="aula-barra-bg">
                                <div class="aula-barra-fill" style="width: <?= $pct ?>%;"></div>
                            </div>
                        </div>
                        <div class="aula-count"><?= (int)$au['total_prestamos'] ?> libro(s)</div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-rank">
                    <i class="fas fa-school"></i>
                    <p>Aún no hay datos de aulas</p>
                </div>
            <?php endif; ?>
        </div>

    </div>

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

        /* ── tabs ── */
        function cambiarTab(nombre) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            document.getElementById('tab-' + nombre).classList.add('active');
            document.getElementById('panel-' + nombre).classList.add('active');
        }
    </script>

</body>

</html>