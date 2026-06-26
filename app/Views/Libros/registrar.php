<?php

/** @var string $header */
/** @var string $footer */
/** @var array<int, array<string, string>> $tipos_recurso */
/** @var array<int, array<string, string>> $categorias_por_tipo */
?>
<?= $header ?>

<link rel="stylesheet" href="<?= base_url('css/libros/registrar.css') ?>">

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="page-title">Registrar Recurso</div>
            <div class="page-subtitle">Completa los datos del nuevo recurso bibliográfico</div>
        </div>
        <a href="<?= base_url('libros') ?>" class="btn-cancelar">
            <i class="fas fa-arrow-left me-2"></i> Volver
        </a>
    </div>

    <form action="<?= base_url('libros/guardar') ?>" method="post" enctype="multipart/form-data">

        <div class="row g-4">

            <!-- Columna izquierda -->
            <div class="col-lg-8">

                <div class="panel">
                    <div class="panel-label">Información General</div>
                    <div class="row g-3">

                        <div class="col-12 form-group">
                            <label>Título <span class="text-danger">*</span></label>
                            <input type="text" name="titulo" class="form-control" required>
                        </div>

                        <!-- AUTORES CON AUTOCOMPLETE -->
                        <div class="col-12 form-group">
                            <label>Autores <span class="text-danger">*</span></label>
                            <div id="autores-tags" class="autores-tags-container"></div>
                            <div class="autor-input-wrap">
                                <input type="text" id="autor-input" class="form-control"
                                    placeholder="Escribe el nombre del autor..."
                                    autocomplete="off">
                                <div id="autor-sugerencias" class="autor-sugerencias"></div>
                            </div>
                            <small class="text-muted">Escribe para buscar o agregar un autor. Presiona <kbd>Enter</kbd> para agregar.</small>
                            <!-- Aquí se insertarán los inputs hidden -->
                            <div id="autores-inputs"></div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>ISBN <span class="text-muted" style="font-size:0.78rem;">(opcional)</span></label>
                            <input type="text" name="isbn" class="form-control" maxlength="13"
                                oninput="this.value = this.value.replace(/\D/g, '').slice(0, 13); document.getElementById('isbn-contador').textContent = this.value.length + ' / 13 dígitos'"
                                placeholder="Ej: 9780306406157">
                            <small class="text-muted" id="isbn-contador">0 / 13 dígitos</small>
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Año <span class="text-danger">*</span></label>
                            <input type="number" name="anio" class="form-control" min="1900" max="2026" required>
                        </div>

                        <div class="col-md-3 form-group">
                            <label>N° Páginas <span class="text-danger">*</span></label>
                            <input type="number" name="numpaginas" class="form-control" min="1" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Tipo de Recurso <span class="text-danger">*</span></label>
                            <select name="id_tipo_recurso" id="tipo_recurso" class="form-select" required>
                                <option value="">Seleccione...</option>
                                <?php foreach ($tipos_recurso as $tipo): ?>
                                    <option value="<?= $tipo['idtiporecurso'] ?>"><?= esc($tipo['tipo']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Categoría <span class="text-danger">*</span></label>
                            <select name="categoria_id" id="categoria" class="form-select" required disabled>
                                <option value="">Seleccione primero el tipo...</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Cantidad de Ejemplares <span class="text-danger">*</span></label>
                            <input type="number" name="cantidad" class="form-control" min="1" value="1" required>
                        </div>

                        <div class="col-12 form-group">
                            <label>Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="4"></textarea>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Columna derecha -->
            <div class="col-lg-4">

                <div class="panel">
                    <div class="panel-label">Portada</div>
                    <div class="form-group">
                        <div class="input-group">
                            <button class="btn btn-outline-secondary" type="button"
                                onclick="document.getElementById('portada').click()">
                                <i class="fas fa-upload"></i> Seleccionar
                            </button>
                            <input type="text" id="file-name" class="form-control"
                                placeholder="Ningún archivo" readonly>
                            <input type="file" name="portada" id="portada" class="d-none"
                                accept="image/*" onchange="updateFileName(this)">
                        </div>
                        <div class="text-center">
                            <img id="previewImg" alt="Vista previa">
                        </div>
                    </div>
                </div>

                <!-- Panel de ayuda -->
                <div class="panel" style="border-color:#d1d5db; background:#f9fafb;">
                    <div class="panel-label" style="color:#FFCE1B;">
                        <i class="fas fa-lightbulb me-1"></i> ¿No encuentras el Tipo de Recurso o la Categoría?
                    </div>
                    <p style="font-size:0.83rem; color:#374151; margin-bottom:0.75rem;">
                        Si el tipo de recurso o categoría que necesitas no aparece en los desplegables,
                        puedes crearlos aquí mismo:
                    </p>
                    <button type="button" onclick="document.getElementById('modal-tipo').style.display='flex'"
                        style="display:block; width:100%; text-align:left; background:none; border:none; padding:0; font-size:0.83rem; color:#111827; font-weight:600; margin-bottom:0.5rem; cursor:pointer;">
                        <i class="fas fa-book me-1"></i> Nuevo Tipo de Recurso
                    </button>
                    <button type="button" onclick="document.getElementById('modal-categoria').style.display='flex'"
                        style="display:block; width:100%; text-align:left; background:none; border:none; padding:0; font-size:0.83rem; color:#111827; font-weight:600; cursor:pointer;">
                        <i class="fas fa-list me-1"></i> Nueva Categoría
                    </button>
                </div>

                <button type="submit" class="btn-guardar w-100">
                    <i class="fas fa-save me-2"></i> Guardar
                </button>

            </div>

        </div>

    </form>

</div>

<!-- ===== MODAL NUEVO TIPO ===== -->
<div id="modal-tipo" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fas fa-tags me-2"></i> Nuevo Tipo de Recurso</h3>
            <button type="button" class="modal-close" onclick="document.getElementById('modal-tipo').style.display='none'">&times;</button>
        </div>
        <div class="modal-body">
            <div id="modal-tipo-msg"></div>
            <div class="form-group">
                <label>Nombre del Tipo <span class="text-danger">*</span></label>
                <input type="text" id="nuevo-tipo" class="form-control"
                    placeholder="Ej: Libro, Revista, Folleto, Biblia...">
                <small class="text-muted">Este nombre aparecerá en el desplegable de Tipo de Recurso.</small>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-cancelar-modal"
                onclick="document.getElementById('modal-tipo').style.display='none'">Cancelar</button>
            <button type="button" class="btn-guardar-modal" onclick="guardarTipo()">
                <i class="fas fa-save me-1"></i> Guardar Tipo
            </button>
        </div>
    </div>
</div>

<!-- ===== MODAL NUEVA CATEGORÍA ===== -->
<div id="modal-categoria" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fas fa-folder-open me-2"></i> Nueva Categoría</h3>
            <button type="button" class="modal-close" onclick="document.getElementById('modal-categoria').style.display='none'">&times;</button>
        </div>
        <div class="modal-body">
            <div id="modal-cat-msg"></div>
            <div class="form-group mb-3">
                <label>Tipo de Recurso <span class="text-danger">*</span></label>
                <select id="nuevo-cat-tipo" class="form-select">
                    <option value="">— Selecciona un tipo —</option>
                    <?php foreach ($tipos_recurso as $tipo): ?>
                        <option value="<?= $tipo['idtiporecurso'] ?>"><?= esc($tipo['tipo']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Nombre de la Categoría <span class="text-danger">*</span></label>
                <input type="text" id="nuevo-cat-nombre" class="form-control"
                    placeholder="Ej: Literatura, Ciencias, Historia...">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-cancelar-modal"
                onclick="document.getElementById('modal-categoria').style.display='none'">Cancelar</button>
            <button type="button" class="btn-guardar-modal" onclick="guardarCategoria()">
                <i class="fas fa-save me-1"></i> Guardar Categoría
            </button>
        </div>
    </div>
</div>

<script>
    // ===== AUTOCOMPLETE AUTORES =====
    const autoresAgregados = [];
    const autorInput = document.getElementById('autor-input');
    const sugerenciasDiv = document.getElementById('autor-sugerencias');
    const tagsContainer = document.getElementById('autores-tags');
    const inputsContainer = document.getElementById('autores-inputs');
    let timeoutBuscar = null;

    autorInput.addEventListener('input', function() {
        clearTimeout(timeoutBuscar);
        const q = this.value.trim();
        if (q.length < 1) {
            sugerenciasDiv.style.display = 'none';
            return;
        }

        timeoutBuscar = setTimeout(() => buscarAutores(q), 250);
    });

    autorInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const val = this.value.trim();
            if (val) agregarAutorTag(val);
        }
        if (e.key === 'Escape') {
            sugerenciasDiv.style.display = 'none';
        }
    });

    document.addEventListener('click', function(e) {
        if (!autorInput.contains(e.target) && !sugerenciasDiv.contains(e.target)) {
            sugerenciasDiv.style.display = 'none';
        }
    });

    async function buscarAutores(q) {
        try {
            const res = await fetch(`<?= base_url('libros/buscarAutores') ?>?q=${encodeURIComponent(q)}`);
            const data = await res.json();
            mostrarSugerencias(q, data);
        } catch (e) {
            mostrarSugerencias(q, []);
        }
    }

    function mostrarSugerencias(q, resultados) {
        sugerenciasDiv.innerHTML = '';

        // Filtrar los que ya están agregados
        const filtrados = resultados.filter(a => !autoresAgregados.includes(a.nombre));

        filtrados.forEach(autor => {
            const div = document.createElement('div');
            div.className = 'autor-sugerencia-item';
            div.innerHTML = `<i class="fas fa-user"></i> ${autor.nombre}`;
            div.addEventListener('click', () => agregarAutorTag(autor.nombre));
            sugerenciasDiv.appendChild(div);
        });

        // Opción para agregar nuevo si no existe exactamente
        const yaExiste = resultados.some(a => a.nombre.toLowerCase() === q.toLowerCase());
        if (!yaExiste && q.length > 0) {
            const div = document.createElement('div');
            div.className = 'autor-sugerencia-item nuevo';
            div.innerHTML = `<i class="fas fa-plus-circle"></i> Agregar "${q}" como nuevo autor`;
            div.addEventListener('click', () => agregarAutorTag(q));
            sugerenciasDiv.appendChild(div);
        }

        sugerenciasDiv.style.display = sugerenciasDiv.children.length > 0 ? 'block' : 'none';
    }

    function agregarAutorTag(nombre) {
        nombre = nombre.trim();
        if (!nombre || autoresAgregados.includes(nombre)) {
            autorInput.value = '';
            sugerenciasDiv.style.display = 'none';
            return;
        }

        autoresAgregados.push(nombre);

        // Tag visual
        const tag = document.createElement('div');
        tag.className = 'autor-tag';
        tag.innerHTML = `<i class="fas fa-user"></i> ${nombre} <button type="button" onclick="eliminarAutorTag(this, '${nombre.replace(/'/g, "\\'")}')">✕</button>`;
        tagsContainer.appendChild(tag);

        // Input hidden para el form
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'autores[]';
        input.value = nombre;
        input.setAttribute('data-autor', nombre);
        inputsContainer.appendChild(input);

        autorInput.value = '';
        sugerenciasDiv.style.display = 'none';
    }

    function eliminarAutorTag(btn, nombre) {
        const idx = autoresAgregados.indexOf(nombre);
        if (idx > -1) autoresAgregados.splice(idx, 1);
        btn.closest('.autor-tag').remove();
        const input = inputsContainer.querySelector(`[data-autor="${nombre}"]`);
        if (input) input.remove();
    }

    // ===== FOTO =====
    function updateFileName(input) {
        const fileNameField = document.getElementById('file-name');
        const previewImg = document.getElementById('previewImg');
        if (input.files.length > 0) {
            const file = input.files[0];
            fileNameField.value = file.name;
            const reader = new FileReader();
            reader.onload = e => {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            fileNameField.value = 'Ningún archivo';
            previewImg.style.display = 'none';
        }
    }

    // ===== VALIDACIÓN SUBMIT =====
    document.querySelector('form').addEventListener('submit', function(e) {
        if (autoresAgregados.length === 0) {
            e.preventDefault();
            alert('Debe ingresar al menos un autor.');
            autorInput.focus();
        }
    });

    // ===== TIPO / CATEGORÍA =====
    const tipoSelect = document.getElementById('tipo_recurso');
    const categoriaSelect = document.getElementById('categoria');
    let categoriasPorTipo = <?= json_encode($categorias_por_tipo ?? []) ?>;

    tipoSelect.addEventListener('change', function() {
        refrescarCategorias(this.value, null);
    });

    function refrescarCategorias(tipoId, seleccionarId) {
        categoriaSelect.innerHTML = '<option value="">Seleccione una categoría...</option>';
        if (tipoId) {
            categoriaSelect.disabled = false;
            if (categoriasPorTipo[tipoId]?.length > 0) {
                categoriasPorTipo[tipoId].forEach(cat => {
                    const option = document.createElement('option');
                    option.value = cat.id;
                    option.textContent = cat.nombre;
                    if (seleccionarId && String(cat.id) === String(seleccionarId)) option.selected = true;
                    categoriaSelect.appendChild(option);
                });
            } else {
                categoriaSelect.innerHTML = '<option value="">No hay categorías disponibles</option>';
            }
        } else {
            categoriaSelect.disabled = true;
        }
    }

    // Cerrar modales al clic fuera
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) this.style.display = 'none';
        });
    });

    // ===== AJAX NUEVO TIPO =====
    async function guardarTipo() {
        const nombre = document.getElementById('nuevo-tipo').value.trim();
        const msgDiv = document.getElementById('modal-tipo-msg');
        if (!nombre) {
            msgDiv.innerHTML = '<div class="modal-msg-error"><i class="fas fa-exclamation-circle me-1"></i> El nombre es obligatorio.</div>';
            return;
        }
        const formData = new FormData();
        formData.append('tipo', nombre);
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
        try {
            const res = await fetch('<?= base_url('recursos/tipos/guardar-ajax') ?>', {
                method: 'POST',
                body: formData
            });
            const data = await res.json();
            if (data.success) {
                const opt = document.createElement('option');
                opt.value = data.id;
                opt.textContent = data.tipo;
                tipoSelect.appendChild(opt);
                const optCat = document.createElement('option');
                optCat.value = data.id;
                optCat.textContent = data.tipo;
                document.getElementById('nuevo-cat-tipo').appendChild(optCat);
                tipoSelect.value = data.id;
                categoriasPorTipo[data.id] = [];
                refrescarCategorias(data.id, null);
                msgDiv.innerHTML = '<div class="modal-msg-ok"><i class="fas fa-check-circle me-1"></i> Tipo creado correctamente.</div>';
                document.getElementById('nuevo-tipo').value = '';
                setTimeout(() => {
                    document.getElementById('modal-tipo').style.display = 'none';
                    msgDiv.innerHTML = '';
                }, 1200);
            } else {
                msgDiv.innerHTML = '<div class="modal-msg-error"><i class="fas fa-exclamation-circle me-1"></i> ' + data.message + '</div>';
            }
        } catch (e) {
            msgDiv.innerHTML = '<div class="modal-msg-error">Error de conexión.</div>';
        }
    }

    // ===== AJAX NUEVA CATEGORÍA =====
    async function guardarCategoria() {
        const idTipo = document.getElementById('nuevo-cat-tipo').value;
        const nombre = document.getElementById('nuevo-cat-nombre').value.trim();
        const msgDiv = document.getElementById('modal-cat-msg');
        if (!idTipo || !nombre) {
            msgDiv.innerHTML = '<div class="modal-msg-error"><i class="fas fa-exclamation-circle me-1"></i> Completa todos los campos.</div>';
            return;
        }
        const formData = new FormData();
        formData.append('idtiporecurso', idTipo);
        formData.append('categoria', nombre);
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
        try {
            const res = await fetch('<?= base_url('recursos/categorias/guardar-ajax') ?>', {
                method: 'POST',
                body: formData
            });
            const data = await res.json();
            if (data.success) {
                if (!categoriasPorTipo[idTipo]) categoriasPorTipo[idTipo] = [];
                categoriasPorTipo[idTipo].push({
                    id: data.id,
                    nombre: data.categoria
                });
                if (tipoSelect.value === String(idTipo)) refrescarCategorias(idTipo, data.id);
                msgDiv.innerHTML = '<div class="modal-msg-ok"><i class="fas fa-check-circle me-1"></i> Categoría creada correctamente.</div>';
                document.getElementById('nuevo-cat-nombre').value = '';
                setTimeout(() => {
                    document.getElementById('modal-categoria').style.display = 'none';
                    msgDiv.innerHTML = '';
                }, 1200);
            } else {
                msgDiv.innerHTML = '<div class="modal-msg-error"><i class="fas fa-exclamation-circle me-1"></i> ' + data.message + '</div>';
            }
        } catch (e) {
            msgDiv.innerHTML = '<div class="modal-msg-error">Error de conexión.</div>';
        }
    }
</script>

<?= $footer ?>