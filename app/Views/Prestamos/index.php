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

    <!-- ══ FORMULARIO REGISTRO MANUAL ══════════════════════════════ -->
    <div class="panel">
        <div class="panel-label">Registrar Préstamo</div>
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
                    <div id="libro-preview" style="margin-top:10px; padding:12px; border:1px solid #e2e8f0; border-radius:8px; display:flex; gap:10px; align-items:center;">
                        <img id="libro-img" src="<?= base_url('img/default-book.jpg') ?>" style="width:70px; height:90px; object-fit:cover; border-radius:6px;">
                        <div>
                            <div id="libro-title" style="font-weight:600; color:#475569;">Selecciona un libro</div>
                            <div id="libro-author" style="font-size:12px; color:#64748b;">Autor: —</div>
                            <div id="libro-category" style="font-size:12px; color:#64748b;">Categoría: —</div>
                            <div id="libro-stock" style="font-size:12px; color:#64748b;">— disponibles</div>
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

</div>

<?= $footer ?>

<script>
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
                return '<div class="no-results">No se encontró el libro</div>';
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