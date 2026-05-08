<?php

/** @var string $header */
/** @var string $footer */
/** @var array<int, array<string, mixed>> $prestamos */
/** @var array<int, array<string, mixed>> $activos */
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

    .panel {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 24px;
        margin-bottom: 20px;
    }

    .panel-label {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        color: #94a3b8;
        text-transform: uppercase;
        margin-bottom: 16px;
    }

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
        box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.08);
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
    }

    .btn-guardar:hover {
        background-color: #16304f;
    }

    .table thead th {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.07em;
        color: #94a3b8;
        text-transform: uppercase;
        border-bottom: 1px solid #e2e8f0;
        background: #fff;
        padding: 12px 16px;
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

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 12px;
        display: block;
    }

    .empty-state p {
        font-size: 0.88rem;
        margin: 0;
    }

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
</style>

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="page-title">Gestión de Préstamos</div>
            <div class="page-subtitle">Registro y seguimiento de préstamos de libros</div>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-dismissible fade show rounded-3 border-0 mb-3" style="background:#f0fdf4;color:#15803d;">
            <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-dismissible fade show rounded-3 border-0 mb-3" style="background:#fef2f2;color:#dc2626;">
            <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Formulario -->
    <div class="panel">
        <div class="panel-label">Registrar Préstamo</div>
        <form action="<?= base_url('prestamos/guardar') ?>" method="post" id="form-prestamo">
            <?= csrf_field() ?>
            <input type="hidden" name="idalumna" id="idalumna">

            <div class="row g-3">

                <!-- Buscar alumna por DNI -->
                <div class="col-md-3 form-group">
                    <label>DNI Alumna</label>
                    <input type="text" id="dni-input" class="form-control"
                        placeholder="Ej: 72894561" maxlength="8">
                    <div class="alumna-card" id="alumna-card">
                        <i class="fas fa-user me-1"></i>
                        <span id="alumna-nombre"></span>
                    </div>
                </div>

                <!-- Seleccionar activo -->
                <div class="col-md-4 form-group">
                    <label>Libro / Activo</label>

                    <select id="libro-select" name="idactivo" placeholder="Buscar libro..." required></select>

                    <!-- 👇 AQUÍ VA EL PREVIEW -->
                    <div id="libro-preview" style="display:none; margin-top:10px; padding:12px; border:1px solid #e2e8f0; border-radius:8px; display:flex; gap:10px; align-items:center;">

                        <img id="libro-img"
                            src=""
                            style="width:70px; height:90px; object-fit:cover; border-radius:6px;">

                        <div>
                            <div id="libro-title" style="font-weight:600;"></div>
                            <div id="libro-author" style="font-size:12px; color:#64748b;"></div>
                            <div id="libro-category" style="font-size:12px; color:#94a3b8;"></div>
                            <div id="libro-stock" style="font-size:12px;"></div>
                        </div>

                    </div>
                </div>

                <!-- Fecha entrega -->
                <div class="col-md-2 form-group">
                    <label>Fecha Entrega</label>
                    <input type="date" name="entrega" class="form-control" required>
                </div>

                <!-- Fecha devolución -->
                <div class="col-md-2 form-group">
                    <label>Fecha Devolución</label>
                    <input type="date" name="devolucion" class="form-control">
                </div>

                <!-- Condición -->
                <div class="col-md-3 form-group">
                    <label>Condición Entrega</label>
                    <select name="condicionentrega" class="form-select" required>
                        <option value="">Seleccionar</option>
                        <option value="Bueno">Bueno</option>
                        <option value="Regular">Regular</option>
                        <option value="Malo">Malo</option>
                    </select>
                </div>

                <div class="col-md-9 d-flex align-items-end justify-content-end">
                    <button type="submit" class="btn-guardar">
                        <i class="fas fa-save me-2"></i> Guardar Préstamo
                    </button>
                </div>

            </div>
        </form>
    </div>

    <!-- Tabla -->
    <div class="panel">
        <div class="panel-label">Listado de Préstamos</div>
        <table class="table mb-0">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Alumna</th>
                    <th>DNI</th>
                    <th>Libro</th>
                    <th>F. Entrega</th>
                    <th>F. Devolución</th>
                    <th>Condición</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($prestamos)): ?>
                    <?php foreach ($prestamos as $i => $p): ?>
                        <tr>
                            <td class="num-col"><?= $i + 1 ?></td>
                            <td><?= esc((string)$p['nombre']) ?></td>
                            <td><?= esc((string)$p['dni']) ?></td>
                            <td><?= esc((string)($p['titulo'] ?? '—')) ?></td>
                            <td><?= esc((string)$p['entrega']) ?></td>
                            <td><?= $p['devolucion'] ? esc((string)$p['devolucion']) : '<span style="color:#cbd5e1">—</span>' ?></td>
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
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-book-open"></i>
                                <p>No hay préstamos registrados</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?= $footer ?>

<script>
    const defaultImg = "<?= base_url('assets/img/default-book.png') ?>";

    // Buscar alumna por DNI
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

    // Validar que se encontró una alumna antes de enviar
    document.getElementById('form-prestamo').addEventListener('submit', function(e) {
        if (!document.getElementById('idalumna').value) {
            e.preventDefault();
            alert('Debes buscar y seleccionar una alumna por DNI.');
        }
    });

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

            fetch(`<?= base_url('prestamos/buscar-libros?q=') ?>` + value)
                .then(res => res.json())
                .then(data => {
                    const libro = data.find(l => l.idactivo == value);
                    if (!libro) return;

                    // Mostrar preview
                    document.getElementById('libro-preview').style.display = 'flex';
                    document.getElementById('libro-title').textContent = libro.titulo;
                    document.getElementById('libro-author').textContent = "Autor: " + (libro.autor || '—');
                    document.getElementById('libro-category').textContent = "Categoría: " + (libro.categoria || '—');

                    // 🚫 BLOQUEAR si no hay stock
                    if (libro.cantidad_disponible <= 0) {
                        document.getElementById('libro-stock').innerHTML = `<span style="color:red;font-weight:600;">Sin stock</span>`;
                        this.clear(); // evita selección
                        alert("Este libro no tiene stock disponible");
                        return;
                    } else {
                        document.getElementById('libro-stock').textContent =
                            `${libro.cantidad_disponible} disponibles`;
                    }

                    // 📦 Imagen con fallback + preload
                    const img = new Image();
                    const imageUrl = libro.foto_url || defaultImg;

                    console.log('=== DEBUG IMAGEN ===');
                    console.log('Nombre en BD:', libro.foto);
                    console.log('URL completa:', imageUrl);

                    img.src = imageUrl;

                    img.onload = () => {
                        document.getElementById('libro-img').src = img.src;
                        console.log('✅ Imagen cargada correctamente');
                    };

                    img.onerror = () => {
                        console.log('❌ Falló la carga de la imagen:', imageUrl);
                        document.getElementById('libro-img').src = defaultImg;
                    };
                });
        },

        render: {
            option: function(data, escape) {
                return `
                <div>
                    <strong>${escape(data.titulo)}</strong><br>
                    <small>
                        ${escape(data.autor || '')} |
                        ${escape(data.categoria || '')} |
                        ${data.cantidad_disponible} disponibles
                    </small>
                </div>
            `;
            }
        }
    });

    // Auto ocultar alertas
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(a => a.remove());
    }, 5000);
</script>