<?php

/** @var string $header */
/** @var string $footer */
/** @var array<int, array<string, mixed>> $prestamos */
/** @var array<int, array<string, mixed>> $pendientes */
?>
<?= $header ?>

<style>
    body {
        background-color: #f4f6f9;
    }

    .page-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 2px;
    }

    .page-subtitle {
        font-size: 0.85rem;
        color: #6c757d;
    }

    /* ── PANEL ─────────────────────────────── */
    .panel {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 24px;
        margin-bottom: 20px;
    }

    /* ── TABS ───────────────────────────────── */
    .tabs-wrap {
        display: flex;
        gap: 4px;
        border-bottom: 2px solid #e2e8f0;
        margin-bottom: 24px;
    }

    .tab-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 18px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #64748b;
        background: none;
        border: none;
        border-bottom: 2px solid transparent;
        margin-bottom: -2px;
        cursor: pointer;
        transition: color .18s, border-color .18s;
        font-family: inherit;
        white-space: nowrap;
    }

    .tab-btn:hover {
        color: #1e3a5f;
    }

    .tab-btn.active {
        color: #1e3a5f;
        border-bottom-color: #1e3a5f;
    }

    .tab-badge {
        background: #fef3c7;
        color: #d97706;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 1px 7px;
        border-radius: 20px;
        min-width: 20px;
        text-align: center;
    }

    .tab-badge.blue {
        background: #eff6ff;
        color: #2563eb;
    }

    .tab-panel {
        display: none;
    }

    .tab-panel.active {
        display: block;
    }

    /* ── TABLA CON SCROLL ───────────────────── */
    .table-wrap {
        max-height: 420px;
        overflow-y: auto;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }

    .table-wrap::-webkit-scrollbar {
        width: 6px;
    }

    .table-wrap::-webkit-scrollbar-track {
        background: #f8fafc;
    }

    .table-wrap::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    .table {
        margin: 0;
        width: 100%;
        border-collapse: collapse;
    }

    .table thead th {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.07em;
        color: #94a3b8;
        text-transform: uppercase;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
        padding: 12px 16px;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .table tbody td {
        padding: 13px 16px;
        font-size: 0.88rem;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table tbody tr:hover {
        background-color: #f8fafc;
    }

    .num-col {
        color: #cbd5e1;
        font-size: 0.82rem;
    }

    /* ── FORMULARIO ─────────────────────────── */
    .form-group label {
        font-size: 0.82rem;
        color: #64748b;
        margin-bottom: 5px;
        display: block;
    }

    .form-control,
    .form-select {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.88rem;
        padding: 10px 14px;
        color: #475569;
        width: 100%;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #1e3a5f;
        box-shadow: 0 0 0 3px rgba(30, 58, 95, .08);
        outline: none;
    }

    .alumna-card {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.88rem;
        color: #15803d;
        font-weight: 600;
        display: none;
        margin-top: 8px;
    }

    .alumna-card.error {
        background: #fef2f2;
        border-color: #fecaca;
        color: #dc2626;
    }

    .btn-guardar {
        background-color: #1e3a5f;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 24px;
        font-size: 0.88rem;
        cursor: pointer;
        font-family: inherit;
    }

    .btn-guardar:hover {
        background-color: #16304f;
    }

    /* ── BOTONES APROBAR / RECHAZAR ─────────── */
    .btn-aprobar {
        background: #f0fdf4;
        color: #15803d;
        border: 1px solid #bbf7d0;
        border-radius: 7px;
        padding: 5px 12px;
        font-size: 0.78rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: background .15s;
        white-space: nowrap;
    }

    .btn-aprobar:hover {
        background: #dcfce7;
        color: #15803d;
    }

    .btn-rechazar {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        border-radius: 7px;
        padding: 5px 12px;
        font-size: 0.78rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: background .15s;
        white-space: nowrap;
    }

    .btn-rechazar:hover {
        background: #fee2e2;
        color: #dc2626;
    }

    /* ── BADGES ─────────────────────────────── */
    .badge-condicion {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
    }

    .condicion-bueno {
        background: #f0fdf4;
        color: #15803d;
    }

    .condicion-regular {
        background: #fef3c7;
        color: #d97706;
    }

    .condicion-malo {
        background: #fef2f2;
        color: #dc2626;
    }

    .badge-activo {
        background: #eff6ff;
        color: #2563eb;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
    }

    /* ── EMPTY STATE ────────────────────────── */
    .empty-state {
        text-align: center;
        padding: 48px 20px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 2rem;
        margin-bottom: 10px;
        display: block;
    }

    .empty-state p {
        font-size: 0.88rem;
        margin: 0;
    }

    /* ── ALERTA PENDIENTES ──────────────────── */
    .pendientes-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-left: 4px solid #f59e0b;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 20px;
        font-size: 0.88rem;
        color: #92400e;
        cursor: pointer;
        transition: background .15s;
    }

    .pendientes-alert:hover {
        background: #fef3c7;
    }

    .pendientes-alert i {
        color: #f59e0b;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .pendientes-alert .alert-action {
        margin-left: auto;
        font-size: 0.8rem;
        font-weight: 600;
        color: #d97706;
        display: flex;
        align-items: center;
        gap: 4px;
    }
</style>

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="page-title">Gestión de Préstamos</div>
            <div class="page-subtitle">Registro y seguimiento de préstamos de libros</div>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert fade show rounded-3 border-0 mb-3" style="background:#f0fdf4;color:#15803d;">
            <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert fade show rounded-3 border-0 mb-3" style="background:#fef2f2;color:#dc2626;">
            <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Alerta clickeable si hay pendientes -->
    <?php if (!empty($pendientes)): ?>
        <div class="pendientes-alert" onclick="activarTab('pendientes')">
            <i class="fas fa-clock"></i>
            Hay <strong><?= count($pendientes) ?> reserva(s) pendiente(s)</strong> esperando tu aprobación.
            <span class="alert-action">Ver reservas <i class="fas fa-arrow-right"></i></span>
        </div>
    <?php endif; ?>

    <!-- ══ PANEL PRINCIPAL CON TABS ════════════ -->
    <div class="panel">

        <div class="tabs-wrap">
            <button class="tab-btn active" onclick="activarTab('registrar')" id="tab-registrar">
                <i class="fas fa-plus-circle"></i> Registrar Préstamo
            </button>
            <button class="tab-btn" onclick="activarTab('pendientes')" id="tab-pendientes">
                <i class="fas fa-clock"></i> Reservas Pendientes
                <?php if (!empty($pendientes)): ?>
                    <span class="tab-badge"><?= count($pendientes) ?></span>
                <?php endif; ?>
            </button>
            <button class="tab-btn" onclick="activarTab('activos')" id="tab-activos">
                <i class="fas fa-book-open"></i> Préstamos Activos
                <?php if (!empty($prestamos)): ?>
                    <span class="tab-badge blue"><?= count($prestamos) ?></span>
                <?php endif; ?>
            </button>
        </div>

        <!-- TAB: REGISTRAR -->
        <div class="tab-panel active" id="panel-registrar">
            <form action="<?= base_url('prestamos/guardar') ?>" method="post" id="form-prestamo">
                <?= csrf_field() ?>
                <input type="hidden" name="idalumna" id="idalumna">
                <div class="row g-3">
                    <div class="col-md-3 form-group">
                        <label>DNI Alumna</label>
                        <input type="text" id="dni-input" class="form-control" placeholder="Ej: 72894561" maxlength="8">
                        <div class="alumna-card" id="alumna-card">
                            <i class="fas fa-user me-1"></i>
                            <span id="alumna-nombre"></span>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Libro / Activo</label>
                        <select id="libro-select" name="idactivo" placeholder="Buscar libro..." required></select>
                        <div id="libro-preview" style="margin-top:10px;padding:12px;border:1px solid #e2e8f0;border-radius:8px;display:flex;gap:10px;align-items:center;">
                            <img id="libro-img" src="<?= base_url('img/default-book.jpg') ?>" style="width:70px;height:90px;object-fit:cover;border-radius:6px;">
                            <div>
                                <div id="libro-title" style="font-weight:600;color:#475569;">Selecciona un libro</div>
                                <div id="libro-author" style="font-size:12px;color:#64748b;">Autor: —</div>
                                <div id="libro-category" style="font-size:12px;color:#64748b;">Categoría: —</div>
                                <div id="libro-stock" style="font-size:12px;color:#64748b;">— disponibles</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Condición Entrega</label>
                        <select name="condicionentrega" class="form-select" required>
                            <option value="">Seleccionar</option>
                            <option value="Bueno">Bueno</option>
                            <option value="Regular">Regular</option>
                            <option value="Malo">Malo</option>
                        </select>
                    </div>
                    <div class="col-md-12 d-flex align-items-end justify-content-end">
                        <button type="submit" class="btn-guardar">
                            <i class="fas fa-save me-2"></i> Registrar Préstamo
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- TAB: PENDIENTES -->
        <div class="tab-panel" id="panel-pendientes">
            <?php if (!empty($pendientes)): ?>
                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width:40px;">#</th>
                                <th>Alumna</th>
                                <th>DNI</th>
                                <th>Libro</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pendientes as $i => $p): ?>
                                <tr>
                                    <td class="num-col"><?= $i + 1 ?></td>
                                    <td><?= esc((string)$p['nombre']) ?></td>
                                    <td><?= esc((string)$p['dni']) ?></td>
                                    <td><?= esc((string)($p['titulo'] ?? '—')) ?></td>
                                    <td><?= esc((string)$p['entrega']) ?></td>
                                    <td><?= esc((string)$p['hora_entrega']) ?></td>
                                    <td>
                                        <div style="display:flex;gap:8px;">
                                            <a href="<?= base_url('prestamos/rechazar/' . $p['idprestamo']) ?>"
                                                class="btn-rechazar"
                                                onclick="return confirm('¿Rechazar esta reserva?')">
                                                <i class="fas fa-times"></i> Rechazar
                                            </a>
                                            <a href="<?= base_url('prestamos/aprobar/' . $p['idprestamo']) ?>"
                                                class="btn-aprobar"
                                                onclick="return confirm('¿Aprobar el préstamo de «<?= esc((string)($p['titulo'] ?? '')) ?>» a <?= esc((string)$p['nombre']) ?>?')">
                                                <i class="fas fa-check"></i> Aprobar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-check-circle" style="color:#86efac;"></i>
                    <p>No hay reservas pendientes</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- TAB: ACTIVOS -->
        <div class="tab-panel" id="panel-activos">
            <?php if (!empty($prestamos)): ?>
                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width:40px;">#</th>
                                <th>Alumna</th>
                                <th>DNI</th>
                                <th>Libro</th>
                                <th>Fecha</th>
                                <th>Hora Entrega</th>
                                <th>Condición</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($prestamos as $i => $p): ?>
                                <tr>
                                    <td class="num-col"><?= $i + 1 ?></td>
                                    <td><?= esc((string)$p['nombre']) ?></td>
                                    <td><?= esc((string)$p['dni']) ?></td>
                                    <td><?= esc((string)($p['titulo'] ?? '—')) ?></td>
                                    <td><?= esc((string)$p['entrega']) ?></td>
                                    <td><?= esc((string)$p['hora_entrega']) ?></td>
                                    <td>
                                        <?php
                                        $condicion = strtolower((string)($p['condicionentrega'] ?? ''));
                                        $clase = match ($condicion) {
                                            'bueno'   => 'condicion-bueno',
                                            'regular' => 'condicion-regular',
                                            'malo'    => 'condicion-malo',
                                            default   => ''
                                        };
                                        ?>
                                        <span class="badge-condicion <?= $clase ?>">
                                            <?= esc((string)$p['condicionentrega']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-activo">
                                            <i class="fas fa-circle me-1" style="font-size:0.5rem;"></i> Activo
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-book-open"></i>
                    <p>No hay préstamos activos</p>
                </div>
            <?php endif; ?>
        </div>

    </div><!-- /panel -->
</div>

<?= $footer ?>

<script>
    /* ── TABS ──────────────────────────────── */
    function activarTab(nombre) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
        document.getElementById('tab-' + nombre).classList.add('active');
        document.getElementById('panel-' + nombre).classList.add('active');
    }

    /* ── BUSCADOR ALUMNA ───────────────────── */
    const defaultImg = "<?= base_url('img/default-book.jpg') ?>";
    let buscarTimeout;

    document.getElementById('dni-input').addEventListener('input', function() {
        const dni = this.value.trim();
        const card = document.getElementById('alumna-card');
        const nombreSpan = document.getElementById('alumna-nombre');
        const inputHidden = document.getElementById('idalumna');
        clearTimeout(buscarTimeout);
        if (dni.length < 8) {
            card.style.display = 'none';
            inputHidden.value = '';
            return;
        }
        buscarTimeout = setTimeout(() => {
            fetch(`<?= base_url('prestamos/buscar-alumna') ?>?dni=${dni}`)
                .then(r => r.json())
                .then(data => {
                    card.style.display = 'block';
                    if (data.success) {
                        card.classList.remove('error');
                        nombreSpan.textContent = data.nombre;
                        inputHidden.value = data.id;
                    } else {
                        card.classList.add('error');
                        nombreSpan.textContent = 'DNI no encontrado';
                        inputHidden.value = '';
                    }
                });
        }, 500);
    });

    document.getElementById('form-prestamo').addEventListener('submit', function(e) {
        if (!document.getElementById('idalumna').value) {
            e.preventDefault();
            alert('Debes buscar y seleccionar una alumna por DNI.');
        }
    });

    /* ── TOM SELECT ────────────────────────── */
    new TomSelect("#libro-select", {
        valueField: "idactivo",
        labelField: "titulo",
        searchField: "titulo",
        placeholder: "Buscar libro...",
        load: function(query, callback) {
            if (!query.length) return callback();
            fetch(`<?= base_url('prestamos/buscar-libros?q=') ?>${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => callback(data))
                .catch(() => callback());
        },
        onChange: function(value) {
            if (!value) return;
            const libro = this.options[value];
            if (!libro) return;
            document.getElementById('libro-preview').style.display = 'flex';
            document.getElementById('libro-title').textContent = libro.titulo;
            document.getElementById('libro-author').textContent = "Autor: " + (libro.autor || '—');
            document.getElementById('libro-category').textContent = "Categoría: " + (libro.categoria || '—');
            if (libro.cantidad_disponible <= 0) {
                document.getElementById('libro-stock').innerHTML = `<span style="color:red;font-weight:600;">Sin stock</span>`;
                this.clear();
                alert("Este libro no tiene stock disponible");
                return;
            }
            document.getElementById('libro-stock').textContent = `${libro.cantidad_disponible} disponibles`;
            const img = new Image();
            img.src = libro.foto_url || defaultImg;
            img.onload = () => document.getElementById('libro-img').src = img.src;
            img.onerror = () => document.getElementById('libro-img').src = defaultImg;
        },
        render: {
            no_results: function() {
                return '<div class="no-results">No se encontró el libro</div>';
            },
            option: function(data, escape) {
                return `<div><strong>${escape(data.titulo)}</strong><br>
                    <small>${escape(data.autor || '')} | ${escape(data.categoria || '')} | ${data.cantidad_disponible} disponibles</small></div>`;
            }
        }
    });

    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(a => a.remove());
    }, 5000);
</script>