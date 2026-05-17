<?php

/** @var array<int, array<string, mixed>> $prestamos */
/** @var string $fecha */

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Historial de Préstamos — Biblioteca</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            background: #fff;
            padding: 20px 28px;
            min-height: 100vh;
            position: relative;
        }

        /* ── HEADER ── */
        .doc-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px solid #1b2436;
            padding-bottom: 14px;
            margin-bottom: 20px;
        }

        .doc-header-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .doc-logo {
            width: 52px;
            height: 52px;
            object-fit: contain;
        }

        .doc-ie {
            font-size: 13px;
            font-weight: 700;
            color: #1b2436;
            line-height: 1.3;
        }

        .doc-ie small {
            display: block;
            font-size: 10px;
            font-weight: 400;
            color: #64748b;
        }

        .doc-header-right {
            text-align: right;
        }

        .doc-title {
            font-size: 16px;
            font-weight: 800;
            color: #1b2436;
        }

        .doc-fecha {
            font-size: 10px;
            color: #64748b;
            margin-top: 3px;
        }

        .doc-total {
            font-size: 10.5px;
            color: #0f6e56;
            font-weight: 600;
            margin-top: 3px;
        }

        /* ── TABLA ── */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }

        thead th {
            background: #1b2436;
            color: #fff;
            padding: 8px 10px;
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        tbody tr:hover {
            background: #f1f5f9;
        }

        tbody td {
            padding: 7px 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10.5px;
            color: #334155;
            vertical-align: middle;
        }

        .num-col {
            color: #94a3b8;
            font-size: 10px;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 9.5px;
            font-weight: 700;
        }

        .badge-bueno {
            background: #f0fdf4;
            color: #15803d;
        }

        .badge-regular {
            background: #fef3c7;
            color: #d97706;
        }

        .badge-malo {
            background: #fef2f2;
            color: #dc2626;
        }

        /* ── FOOTER ── */
        .doc-footer {
            position: absolute;
            bottom: 20px;
            left: 28px;
            right: 28px;
            border-top: 1px solid #e2e8f0;
            padding-top: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 9.5px;
            color: #94a3b8;
        }

        /* ── BOTÓN IMPRIMIR ── */
        .btn-print {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            background: #1b2436;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 20px;
            font-family: inherit;
            transition: background .2s;
        }

        .btn-print:hover {
            background: #0f172a;
        }

        .btn-volver {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            background: transparent;
            color: #1b2436;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 20px;
            font-family: inherit;
            text-decoration: none;
            transition: all .2s;
        }

        .btn-volver:hover {
            background: #f8fafc;
        }

        .acciones {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        @media print {
            .acciones {
                display: none !important;
            }

            body {
                padding: 10px;
            }
        }
    </style>
</head>

<body>

    <div class="acciones">
        <a href="<?= base_url('/') ?>" class="btn-volver">← Volver</a>
        <button class="btn-print" onclick="window.print()">
            🖨️ Imprimir / Guardar PDF
        </button>
    </div>

    <!-- ENCABEZADO -->
    <div class="doc-header">
        <div class="doc-header-left">
            <img src="<?= base_url('img/insignia.jpg') ?>" class="doc-logo" alt="Logo IE">
            <div class="doc-ie">
                Institución Educativa Chinchaysuyo
                <small>Biblioteca Escolar</small>
            </div>
        </div>
        <div class="doc-header-right">
            <div class="doc-title">Historial de Préstamos</div>
            <div class="doc-fecha">Generado: <?= $fecha ?></div>
            <div class="doc-total">Total registros: <?= count($prestamos) ?></div>
        </div>
    </div>

    <!-- TABLA -->
    <table>
        <thead>
            <tr>
                <th style="width:28px;">#</th>
                <th>Alumna</th>
                <th>DNI</th>
                <th>Grado</th>
                <th>Sección</th>
                <th>Libro</th>
                <th>Fecha</th>
                <th>H. Entrega</th>
                <th>H. Devolución</th>
                <th>Duración</th>
                <th>Condición</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($prestamos)): ?>
                <?php foreach ($prestamos as $i => $p): ?>
                    <?php
                    $min = (int)$p['minutos'];
                    if ($min >= 60) {
                        $h   = floor($min / 60);
                        $m   = $min % 60;
                        $dur = $h . 'h' . ($m > 0 ? ' ' . $m . 'min' : '');
                    } else {
                        $dur = $min . ' min';
                    }
                    $condicion = strtolower((string)($p['condicionentrega'] ?? ''));
                    $badgeClass = match ($condicion) {
                        'bueno'   => 'badge-bueno',
                        'regular' => 'badge-regular',
                        'malo'    => 'badge-malo',
                        default   => ''
                    };
                    ?>
                    <tr>
                        <td class="num-col"><?= $i + 1 ?></td>
                        <td><?= esc((string)$p['nombre']) ?></td>
                        <td><?= esc((string)$p['dni']) ?></td>
                        <td><?= esc((string)($p['grado'] ?? '—')) ?></td>
                        <td><?= esc((string)($p['seccion'] ?? '—')) ?></td>
                        <td><?= esc((string)($p['titulo'] ?? '—')) ?></td>
                        <td><?= esc((string)$p['entrega']) ?></td>
                        <td><?= esc((string)$p['hora_entrega']) ?></td>
                        <td><?= esc((string)$p['hora_devolucion']) ?></td>
                        <td><?= $dur ?></td>
                        <td><span class="badge <?= $badgeClass ?>"><?= esc((string)$p['condicionentrega']) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11" style="text-align:center; padding:24px; color:#94a3b8;">
                        No hay registros en el historial
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="doc-footer">
        <span>I.E. Chinchaysuyo — Biblioteca Escolar</span>
        <span><?= $fecha ?></span>
    </div>

</body>

</html>