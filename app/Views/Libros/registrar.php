<?php

/** @var string $header */
/** @var string $footer */
/** @var array<int, array<string, string>> $tipos_recurso */
/** @var array<int, array<string, string>> $categorias_por_tipo */
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
        font-weight: 600;
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

    .autor-item {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f8fafc;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        margin-bottom: 8px;
    }

    .autor-item input {
        border: none;
        outline: none;
        flex: 1;
        background: transparent;
        font-size: 0.88rem;
        color: #475569;
    }

    .btn-remove {
        background: #fee2e2;
        color: #dc2626;
        border: none;
        border-radius: 6px;
        padding: 5px 10px;
        cursor: pointer;
        font-size: 0.8rem;
    }

    .btn-remove:hover {
        background: #fecaca;
    }

    .btn-add {
        background: #eff6ff;
        color: #2563eb;
        border: none;
        padding: 8px 14px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.82rem;
        font-weight: 600;
        margin-top: 6px;
    }

    .btn-add:hover {
        background: #dbeafe;
    }

    .btn-guardar {
        background-color: #1e3a5f;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 24px;
        font-size: 0.88rem;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-guardar:hover {
        background-color: #16304f;
    }

    .btn-cancelar {
        background-color: #f1f5f9;
        color: #64748b;
        border: none;
        border-radius: 8px;
        padding: 10px 24px;
        font-size: 0.88rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
    }

    .btn-cancelar:hover {
        background-color: #e2e8f0;
        color: #475569;
    }

    #previewImg {
        max-height: 200px;
        max-width: 100%;
        border-radius: 8px;
        display: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin-top: 12px;
    }
</style>

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="page-title">Registrar Libro</div>
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

                        <div class="col-12 form-group">
                            <label>Autores <span class="text-danger">*</span></label>
                            <div id="autores-container">
                                <div class="autor-item">
                                    <input type="text" name="autores[]" placeholder="Escribe el autor">
                                    <button type="button" class="btn-remove" onclick="this.parentElement.remove()">✕</button>
                                </div>
                            </div>
                            <button type="button" class="btn-add" onclick="agregarAutor()">
                                <i class="fas fa-plus me-1"></i> Agregar autor
                            </button>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>ISBN <span class="text-danger">*</span></label>
                            <input type="text" name="isbn" class="form-control" maxlength="13"
                                oninput="this.value = this.value.replace(/\D/g, '').slice(0, 13); document.getElementById('isbn-contador').textContent = this.value.length + ' / 13 dígitos'"
                                placeholder="Ej: 9780306406157" required>
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

                <button type="submit" class="btn-guardar w-100">
                    <i class="fas fa-save me-2"></i> Guardar
                </button>

            </div>

        </div>

    </form>

</div>

<script>
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

    function agregarAutor() {
        const container = document.getElementById('autores-container');
        const div = document.createElement('div');
        div.className = 'autor-item';
        div.innerHTML = `
            <input type="text" name="autores[]" placeholder="Escribe el autor">
            <button type="button" class="btn-remove" onclick="this.parentElement.remove()">✕</button>
        `;
        container.appendChild(div);
    }

    document.querySelector('form').addEventListener('submit', function(e) {
        const autores = document.querySelectorAll('input[name="autores[]"]');
        let valido = false;
        autores.forEach(input => {
            if (input.value.trim() !== '') valido = true;
        });
        if (!valido) {
            e.preventDefault();
            alert('Debe ingresar al menos un autor válido');
        }
    });

    const tipoSelect = document.getElementById('tipo_recurso');
    const categoriaSelect = document.getElementById('categoria');

    tipoSelect.addEventListener('change', function() {
        const tipoId = this.value;
        categoriaSelect.innerHTML = '<option value="">Seleccione una categoría...</option>';

        if (tipoId) {
            categoriaSelect.disabled = false;
            const categoriasPorTipo = <?= json_encode($categorias_por_tipo ?? []) ?>;

            if (categoriasPorTipo[tipoId]?.length > 0) {
                categoriasPorTipo[tipoId].forEach(cat => {
                    const option = document.createElement('option');
                    option.value = cat.id;
                    option.textContent = cat.nombre;
                    categoriaSelect.appendChild(option);
                });
            } else {
                categoriaSelect.innerHTML = '<option value="">No hay categorías disponibles</option>';
            }
        } else {
            categoriaSelect.disabled = true;
        }
    });
</script>

<?= $footer ?>