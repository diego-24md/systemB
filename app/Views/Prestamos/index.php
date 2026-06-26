<?php

/** @var string $header */
/** @var string $footer */
?>
<?= $header ?>

<link rel="stylesheet" href="<?= base_url('css/prestamos/index.css') ?>">

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="page-title">Gestión de Préstamos</div>
            <div class="page-subtitle">Registro de préstamos de recursos</div>
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

    <div class="row g-4">

        <!-- ══ FORMULARIO ══════════════════════════════ -->
        <div class="col-lg-8">
            <div class="panel">
                <div class="panel-label">Registrar Préstamo</div>
                <form action="<?= base_url('prestamos/guardar') ?>" method="post" id="form-prestamo">
                    <?= csrf_field() ?>
                    <input type="hidden" name="idalumna" id="idalumna">

                    <div class="row g-3">

                        <!-- FILA 1: Buscar Alumna + Condición -->
                        <div class="col-md-7 form-group">
                            <label>Buscar Alumna</label>
                            <div class="alumna-search-wrap">
                                <input type="text" id="dni-input" class="form-control"
                                    placeholder="Nombre o DNI..."
                                    autocomplete="off">
                                <i class="fas fa-search alumna-search-icon"></i>
                                <div id="alumna-sugerencias" class="alumna-sugerencias"></div>
                            </div>
                            <small class="text-muted" style="font-size:0.75rem;">
                                Escribe el nombre o los 8 dígitos del DNI
                            </small>
                            <div class="alumna-card" id="alumna-card">
                                <div class="alumna-card-info">
                                    <i class="fas fa-user-circle alumna-avatar"></i>
                                    <div>
                                        <div id="alumna-nombre" class="alumna-nombre"></div>
                                        <div id="alumna-detalle" class="alumna-detalle"></div>
                                    </div>
                                </div>
                                <button type="button" class="alumna-clear" onclick="limpiarAlumna()" title="Cambiar alumna">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-5 form-group">
                            <label>Condición de Entrega</label>
                            <select name="condicionentrega" class="form-select" required>
                                <option value="Bueno" selected>Bueno</option>
                                <option value="Regular">Regular</option>
                                <option value="Malo">Malo</option>
                            </select>
                        </div>

                        <!-- FILA 2: Recurso ancho completo -->
                        <div class="col-md-12 form-group">
                            <label>Recurso / Activo</label>
                            <select id="libro-select" name="idactivo" placeholder="Buscar recurso..." required></select>
                            <div id="libro-preview" style="margin-top:10px; padding:12px; border:1px solid #e2e8f0; border-radius:8px; display:flex; gap:10px; align-items:center;">
                                <img id="libro-img" src="<?= base_url('img/default-book.jpg') ?>" style="width:70px; height:90px; object-fit:cover; border-radius:6px;">
                                <div>
                                    <div id="libro-title" style="font-weight:600; color:#475569;">Selecciona un recurso</div>
                                    <div id="libro-author" style="font-size:12px; color:#64748b;">Autor: —</div>
                                    <div id="libro-category" style="font-size:12px; color:#64748b;">Categoría: —</div>
                                    <div id="libro-stock" style="font-size:12px; color:#64748b;">— disponibles</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 d-flex align-items-end justify-content-end">
                            <button type="submit" class="btn-guardar">
                                <i class="fas fa-save me-2"></i> Registrar Préstamo
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- ══ PANEL INFORMATIVO ══════════════════════════════ -->
        <div class="col-lg-4">
            <div class="panel panel-aviso">
                <div class="panel-label" style="color:#b45309;">
                    <i class="fas fa-triangle-exclamation" style="color:#f59e0b;"></i>
                    Antes de registrar
                </div>
                <div class="aviso-item">
                    <div class="aviso-icon"><i class="fas fa-calendar-day"></i></div>
                    <div class="aviso-text">
                        La alumna debe devolver el libro el <strong>mismo día</strong> antes del fin del horario escolar.
                    </div>
                </div>
                <div class="aviso-item">
                    <div class="aviso-icon"><i class="fas fa-book"></i></div>
                    <div class="aviso-text">
                        Solo se permite <strong>un préstamo activo</strong> por alumna a la vez.
                    </div>
                </div>
                <div class="aviso-item" style="margin-bottom:0;">
                    <div class="aviso-icon"><i class="fas fa-user-check"></i></div>
                    <div class="aviso-text">
                        Registra el préstamo solo cuando la alumna esté <strong>presente</strong> en la biblioteca.
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<?= $footer ?>

<style>
    /* Búsqueda alumna */
    .alumna-search-wrap {
        position: relative;
    }

    .alumna-search-icon {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.85rem;
        pointer-events: none;
    }

    .alumna-sugerencias {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, .1);
        z-index: 999;
        max-height: 240px;
        overflow-y: auto;
        display: none;
    }

    .alumna-sug-item {
        padding: 0.65rem 1rem;
        cursor: pointer;
        border-bottom: 1px solid #f1f5f9;
        transition: background .15s;
    }

    .alumna-sug-item:last-child {
        border-bottom: none;
    }

    .alumna-sug-item:hover {
        background: #f8fafc;
    }

    .alumna-sug-nombre {
        font-size: 0.875rem;
        font-weight: 600;
        color: #1b2436;
    }

    .alumna-sug-detalle {
        font-size: 0.75rem;
        color: #64748b;
        margin-top: 1px;
    }

    .alumna-sug-empty {
        padding: 1rem;
        text-align: center;
        font-size: 0.875rem;
        color: #94a3b8;
    }

    /* Card alumna */
    .alumna-card {
        display: none;
        margin-top: 0.6rem;
        padding: 0.75rem 1rem;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
    }

    .alumna-card.error {
        background: #fef2f2;
        border-color: #fecaca;
    }

    .alumna-card-info {
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .alumna-avatar {
        font-size: 1.5rem;
        color: #16a34a;
    }

    .alumna-card.error .alumna-avatar {
        color: #dc2626;
    }

    .alumna-nombre {
        font-size: 0.875rem;
        font-weight: 700;
        color: #166534;
    }

    .alumna-card.error .alumna-nombre {
        color: #991b1b;
    }

    .alumna-detalle {
        font-size: 0.75rem;
        color: #4ade80;
    }

    .alumna-card.error .alumna-detalle {
        color: #f87171;
    }

    .alumna-clear {
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        font-size: 0.85rem;
        padding: 0;
        flex-shrink: 0;
    }

    .alumna-clear:hover {
        color: #dc2626;
    }

    /* Panel aviso */
    .panel-aviso {
        border: 1px solid #fde68a;
        background: #fffbeb;
    }

    .aviso-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .aviso-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #fef3c7;
        color: #d97706;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        flex-shrink: 0;
    }

    .aviso-text {
        font-size: 0.83rem;
        color: #92400e;
        line-height: 1.5;
        padding-top: 0.4rem;
    }
</style>

<script>
    const defaultImg = "<?= base_url('img/default-book.jpg') ?>";
    let buscarTimeout;
    let alumnaSeleccionada = false;

    const dniInput = document.getElementById('dni-input');
    const sugerenciasDiv = document.getElementById('alumna-sugerencias');
    const alumnaCard = document.getElementById('alumna-card');
    const alumnaHidden = document.getElementById('idalumna');

    dniInput.addEventListener('input', function() {
        const q = this.value.trim();
        clearTimeout(buscarTimeout);
        if (alumnaSeleccionada) return;
        if (q.length < 2) {
            sugerenciasDiv.style.display = 'none';
            return;
        }
        buscarTimeout = setTimeout(() => buscarAlumna(q), 350);
    });

    document.addEventListener('click', function(e) {
        if (!dniInput.contains(e.target) && !sugerenciasDiv.contains(e.target)) {
            sugerenciasDiv.style.display = 'none';
        }
    });

    async function buscarAlumna(q) {
        try {
            const res = await fetch(`<?= base_url('prestamos/buscar-alumna') ?>?q=${encodeURIComponent(q)}`);
            const data = await res.json();
            mostrarSugerencias(data);
        } catch (e) {
            sugerenciasDiv.style.display = 'none';
        }
    }

    function mostrarSugerencias(data) {
        sugerenciasDiv.innerHTML = '';
        if (!data.resultados || data.resultados.length === 0) {
            sugerenciasDiv.innerHTML = '<div class="alumna-sug-empty"><i class="fas fa-user-slash me-1"></i> No se encontró ninguna alumna</div>';
            sugerenciasDiv.style.display = 'block';
            return;
        }
        if (data.unico) {
            seleccionarAlumna(data.resultados[0]);
            return;
        }
        data.resultados.forEach(alumna => {
            const div = document.createElement('div');
            div.className = 'alumna-sug-item';
            div.innerHTML = `
                <div class="alumna-sug-nombre"><i class="fas fa-user me-1" style="color:#2563eb;font-size:0.75rem;"></i> ${alumna.nombre}</div>
                <div class="alumna-sug-detalle">DNI: ${alumna.dni} · ${alumna.grado ?? ''} ${alumna.seccion ?? ''} · ${alumna.turno === 'manana' ? 'Mañana' : 'Tarde'}</div>
            `;
            div.addEventListener('click', () => seleccionarAlumna(alumna));
            sugerenciasDiv.appendChild(div);
        });
        sugerenciasDiv.style.display = 'block';
    }

    function seleccionarAlumna(alumna) {
        alumnaSeleccionada = true;
        alumnaHidden.value = alumna.id;
        dniInput.value = alumna.nombre;
        document.getElementById('alumna-nombre').textContent = alumna.nombre;
        document.getElementById('alumna-detalle').textContent =
            `DNI: ${alumna.dni} · ${alumna.grado ?? ''} ${alumna.seccion ?? ''} · ${alumna.turno === 'manana' ? 'Mañana' : 'Tarde'}`;
        alumnaCard.classList.remove('error');
        alumnaCard.style.display = 'flex';
        sugerenciasDiv.style.display = 'none';
    }

    function limpiarAlumna() {
        alumnaSeleccionada = false;
        alumnaHidden.value = '';
        dniInput.value = '';
        alumnaCard.style.display = 'none';
        dniInput.focus();
    }

    document.getElementById('form-prestamo').addEventListener('submit', function(e) {
        if (!alumnaHidden.value) {
            e.preventDefault();
            alert('Debes buscar y seleccionar una alumna.');
            dniInput.focus();
        }
    });

    new TomSelect("#libro-select", {
        valueField: "idactivo",
        labelField: "titulo",
        searchField: "titulo",
        placeholder: "Buscar recurso...",
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
            } else {
                document.getElementById('libro-stock').textContent = `${libro.cantidad_disponible} disponibles`;
            }
            const img = new Image();
            const imageUrl = libro.foto_url || defaultImg;
            img.src = imageUrl;
            img.onload = () => document.getElementById('libro-img').src = img.src;
            img.onerror = () => document.getElementById('libro-img').src = defaultImg;
        },
        render: {
            no_results: function() {
                return '<div class="no-results">No se encontró el recurso</div>';
            },
            option: function(data, escape) {
                return `<div>
                    <strong>${escape(data.titulo)}</strong><br>
                    <small>${escape(data.autor || '')} | ${escape(data.categoria || '')} | ${data.cantidad_disponible} disponibles</small>
                </div>`;
            }
        }
    });

    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(a => a.remove());
    }, 5000);
</script>