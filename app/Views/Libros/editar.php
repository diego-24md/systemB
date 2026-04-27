<?= $header ?>

<style>
    .autor-item {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f4f6f9;
        padding: 8px;
        border-radius: 8px;
        border: 1px solid #dce3ea;
        margin-bottom: 8px;
    }

    .autor-item input {
        border: none;
        outline: none;
        flex: 1;
        background: transparent;
        font-size: 14px;
    }

    .btn-remove {
        background: #dc3545;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 5px 10px;
        cursor: pointer;
        font-size: 13px;
    }

    .btn-remove:hover {
        background: #c82333;
    }

    .btn-add {
        margin-top: 10px;
        background: #1a3c6e;
        color: #fff;
        border: none;
        padding: 8px 12px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-add:hover {
        background: #2457a6;
    }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-6">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Editar Libro</h4>
                <a href="<?= base_url('libros') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver a la lista
                </a>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-4">

                    <form action="<?= base_url('libros/actualizar/' . $libro['idrecurso']) ?>" method="POST"
                        enctype="multipart/form-data">

                        <?= csrf_field() ?>

                        <!-- Campo hidden para conservar portada actual -->
                        <input type="hidden" name="portada_actual" value="<?= esc($libro['portada'] ?? '') ?>">

                        <!-- Título -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Título <span class="text-danger">*</span></label>
                            <input type="text" name="titulo"
                                class="form-control <?= session('errors.titulo') ? 'is-invalid' : '' ?>"
                                value="<?= old('titulo', esc($libro['titulo'])) ?>" required>
                            <?= session('errors.titulo') ? '<div class="invalid-feedback">' . session('errors.titulo') . '</div>' : '' ?>
                        </div>

                        <!-- Autores -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Autores <span class="text-danger">*</span></label>
                            <div id="autores-container">
                                <?php if (!empty($autores)): ?>
                                    <?php foreach ($autores as $autor): ?>
                                        <div class="autor-item">
                                            <input type="text" name="autores[]"
                                                value="<?= esc($autor['nombre']) ?>"
                                                placeholder="Escribe el autor">
                                            <button type="button" class="btn-remove"
                                                onclick="this.parentElement.remove()">✕</button>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="autor-item">
                                        <input type="text" name="autores[]" placeholder="Escribe el autor">
                                        <button type="button" class="btn-remove"
                                            onclick="this.parentElement.remove()">✕</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <button type="button" class="btn-add" onclick="agregarAutor()">+ Agregar autor</button>
                        </div>

                        <!-- ISBN -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">ISBN</label>
                            <input type="text" name="isbn"
                                class="form-control <?= session('errors.isbn') ? 'is-invalid' : '' ?>"
                                value="<?= old('isbn', esc($libro['isbn'] ?? '')) ?>"
                                maxlength="13"
                                oninput="this.value = this.value.replace(/\D/g, '').slice(0, 13)">
                            <?= session('errors.isbn') ? '<div class="invalid-feedback">' . session('errors.isbn') . '</div>' : '' ?>
                        </div>

                        <div class="row">
                            <!-- Año -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Año de publicación</label>
                                <input type="number" name="anio"
                                    class="form-control <?= session('errors.anio') ? 'is-invalid' : '' ?>"
                                    value="<?= old('anio', esc($libro['anio'] ?? '')) ?>"
                                    min="1900" max="2026">
                                <?= session('errors.anio') ? '<div class="invalid-feedback">' . session('errors.anio') . '</div>' : '' ?>
                            </div>

                            <!-- Número de páginas -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Número de páginas</label>
                                <input type="number" name="numpaginas"
                                    class="form-control <?= session('errors.numpaginas') ? 'is-invalid' : '' ?>"
                                    value="<?= old('numpaginas', esc($libro['numpaginas'] ?? '')) ?>"
                                    min="1">
                                <?= session('errors.numpaginas') ? '<div class="invalid-feedback">' . session('errors.numpaginas') . '</div>' : '' ?>
                            </div>
                        </div>

                        <!-- Tipo de Recurso -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tipo de Recurso <span class="text-danger">*</span></label>
                            <select name="id_tipo_recurso" class="form-control" required>
                                <option value="">Seleccione...</option>
                                <?php foreach ($tipos_recurso as $tipo): ?>
                                    <option value="<?= $tipo['idtiporecurso'] ?>"
                                        <?= $libro['idtiporecurso'] == $tipo['idtiporecurso'] ? 'selected' : '' ?>>
                                        <?= esc($tipo['tipo']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Categoría -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Categoría <span class="text-danger">*</span></label>
                            <select name="categoria_id" class="form-control" required>
                                <option value="">Seleccione...</option>
                                <?php foreach ($categorias as $cat): ?>
                                    <option value="<?= $cat['idcategoria'] ?>"
                                        <?= $libro['idcategoria'] == $cat['idcategoria'] ? 'selected' : '' ?>>
                                        <?= esc($cat['categoria']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="4"><?= old('descripcion', esc($libro['descripcion'] ?? '')) ?></textarea>
                        </div>

                        <!-- Portada -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Portada del libro</label>

                            <?php if (!empty($libro['portada']) && file_exists('uploads/portadas/' . $libro['portada'])): ?>
                                <div class="mb-3">
                                    <p class="small text-muted mb-1">Portada actual:</p>
                                    <img src="<?= base_url('uploads/portadas/' . $libro['portada']) ?>"
                                        class="img-thumbnail shadow-sm"
                                        style="max-height: 200px; object-fit: cover; border-radius: 8px;">
                                </div>
                            <?php endif; ?>

                            <div class="input-group">
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="document.getElementById('portada').click()">
                                    <i class="fas fa-upload"></i> Seleccionar archivo
                                </button>
                                <input type="text" id="file-name" class="form-control"
                                    placeholder="Ningún archivo seleccionado" readonly>
                                <input type="file" name="portada" id="portada"
                                    class="d-none" accept="image/*"
                                    onchange="updateFileName(this)">
                            </div>
                            <small class="text-muted d-block mt-1">Dejar vacío si no se quiere cambiar la portada.</small>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-save"></i> Guardar Cambios
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateFileName(input) {
        const fileNameField = document.getElementById('file-name');
        if (input.files.length > 0) {
            fileNameField.value = input.files[0].name;
        } else {
            fileNameField.value = "Ningún archivo seleccionado";
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

    // Validar al menos un autor
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
</script>

<?= $footer ?>