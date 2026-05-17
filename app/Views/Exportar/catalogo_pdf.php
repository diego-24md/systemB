<?php

/** @var array<int, array<string, mixed>> $libros */
/** @var string $fecha */

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Catálogo de Libros — Biblioteca</title>
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

        .badge-disp {
            background: #f0fdf4;
            color: #15803d;
        }

        .badge-agot {
            background: #fef2f2;
            color: #dc2626;
        }

        /* SOLO corregido el footer */
        .doc-footer {
            position: absolute;
            bottom: 20px;
            left: 28px;
            right: 28px;
            border-top: 1px solid #e2e8f0;
            padding-top: 12px;
            display: flex;
            justify-content: space-between;
            font-size: 9.5px;
            color: #94a3b8;
        }

        .acciones {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

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
            text-decoration: none;
            font-family: inherit;
            transition: all .2s;
        }

        .btn-volver:hover {
            background: #f8fafc;
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
        <button class="btn-print" onclick="window.print()">🖨️ Imprimir / Guardar PDF</button>
    </div>

    <div class="doc-header">
        <div class="doc-header-left">
            <img src="<?= base_url('img/insignia.jpg') ?>" class="doc-logo" alt="Logo IE">
            <div class="doc-ie">
                Institución Educativa Chinchaysuyo
                <small>Biblioteca Escolar</small>
            </div>
        </div>
        <div class="doc-header-right">
            <div class="doc-title">Catálogo de Libros</div>
            <div class="doc-fecha">Generado: <?= $fecha ?></div>
            <div class="doc-total">Total libros: <?= count($libros) ?></div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:28px;">#</th>
                <th>Título</th>
                <th>Autor(es)</th>
                <th>Categoría</th>
                <th>Tipo</th>
                <th>Año</th>
                <th>Págs.</th>
                <th>Total</th>
                <th>Disponibles</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($libros)): ?>
                <?php foreach ($libros as $i => $l): ?>
                    <?php $disp = (int)($l['cantidad_disponible'] ?? 0); ?>
                    <tr>
                        <td class="num-col"><?= $i + 1 ?></td>
                        <td><strong><?= esc((string)$l['titulo']) ?></strong></td>
                        <td><?= esc((string)($l['autores'] ?? '—')) ?></td>
                        <td><?= esc((string)($l['categoria'] ?? '—')) ?></td>
                        <td><?= esc((string)($l['tipo'] ?? '—')) ?></td>
                        <td><?= esc((string)($l['anio'] ?? '—')) ?></td>
                        <td><?= esc((string)($l['numpaginas'] ?? '—')) ?></td>
                        <td><?= (int)($l['cantidad_total'] ?? 0) ?></td>
                        <td><?= $disp ?></td>
                        <td>
                            <span class="badge <?= $disp > 0 ? 'badge-disp' : 'badge-agot' ?>">
                                <?= $disp > 0 ? 'Disponible' : 'Agotado' ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10" style="text-align:center; padding:24px; color:#94a3b8;">
                        No hay libros registrados
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