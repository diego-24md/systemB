<?php

/** @var string $header */
/** @var string $footer */
/** @var array $libro */
/** @var array $autores */
/** @var array $tipos_recurso */
/** @var array $categorias */
/** @var array|null $activo */
?>
<?= $header ?>

<link rel="stylesheet" href="<?= base_url('css/libros/editar.css') ?>">

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="page-title">Editar Libro</div>
            <div class="page-subtitle">Modifica los datos del recurso bibliográfico</div>
        </div>
        <a href="<?= base_url('libros') ?>" class="btn-cancelar">
            <i class="fas fa-arrow-left me-2"></i> Volver
        </a>
    </div>

    <form action="<?= base_url('libros/actualizar/' . $libro['idrecurso']) ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="portada_actual" value="<?= esc((string)$libro['portada'] ?? '') ?>">

        <div class="row g-4">

            <!-- Columna izquierda -->
            <div class="col-lg-8">

                <div class="panel">
                    <div class="panel-label">Información General</div>
                    <div class="row g-3">

                        <div class="col-12 form-group">
                            <label>Título <span class="text-danger">*</span></label>
                            <input type="text" name="titulo" class="form-control"
                                value="<?= esc((string)$libro['titulo']) ?>" required>
                        </div>

                        <div class="col-12 form-group">
                            <label>Autores <span class="text-danger">*</span></label>
                            <div id="autores-container">
                                <?php if (!empty($autores)): ?>
                                    <?php foreach ($autores as $autor): ?>
                                        <div class="autor-item">
                                            <input type="text" name="autores[]"
                                                value="<?= esc((string)$autor['nombre']) ?>"
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
                            <button type="button" class="btn-add" onclick="agregarAutor()">
                                <i class="fas fa-plus me-1"></i> Agregar autor
                            </button>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>ISBN</label>
                            <input type="text" name="isbn" class="form-control"
                                value="<?= esc((string)$libro['isbn'] ?? '') ?>"
                                maxlength="13"
                                oninput="this.value = this.value.replace(/\D/g, '').slice(0, 13)">
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Año</label>
                            <input type="number" name="anio" class="form-control"
                                value="<?= esc((string)$libro['anio'] ?? '') ?>" min="1900" max="2026">
                        </div>

                        <div class="col-md-3 form-group">
                            <label>N° Páginas</label>
                            <input type="number" name="numpaginas" class="form-control"
                                value="<?= esc((string)$libro['numpaginas'] ?? '') ?>" min="1">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Tipo de Recurso <span class="text-danger">*</span></label>
                            <select name="id_tipo_recurso" class="form-select" required>
                                <option value="">Seleccione...</option>
                                <?php foreach ($tipos_recurso as $tipo): ?>
                                    <option value="<?= $tipo['idtiporecurso'] ?>"
                                        <?= $libro['idtiporecurso'] == $tipo['idtiporecurso'] ? 'selected' : '' ?>>
                                        <?= esc((string)$tipo['tipo']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Categoría <span class="text-danger">*</span></label>
                            <select name="categoria_id" class="form-select" required>
                                <option value="">Seleccione...</option>
                                <?php foreach ($categorias as $cat): ?>
                                    <option value="<?= $cat['idcategoria'] ?>"
                                        <?= $libro['idcategoria'] == $cat['idcategoria'] ? 'selected' : '' ?>>
                                        <?= esc((string)$cat['categoria']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Cantidad de Ejemplares <span class="text-danger">*</span></label>
                            <input type="number" name="cantidad" class="form-control" min="1"
                                value="<?= (int)($activo['cantidad_total'] ?? 1) ?>" required>
                            <?php if (!empty($activo)): ?>
                                <div class="ejemplares-info">
                                    <i class="fas fa-info-circle me-1"></i>
                                    <strong><?= (int)$activo['cantidad_total'] ?></strong> totales,
                                    <strong><?= (int)$activo['cantidad_disponible'] ?></strong> disponibles.
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-12 form-group">
                            <label>Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="4"><?= esc((string)$libro['descripcion'] ?? '') ?></textarea>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Columna derecha -->
            <div class="col-lg-4">

                <div class="panel">
                    <div class="panel-label">Portada</div>

                    <?php if (!empty($libro['portada']) && file_exists('uploads/portadas/' . $libro['portada'])): ?>
                        <div class="text-center mb-3">
                            <img src="<?= base_url('uploads/portadas/' . $libro['portada']) ?>"
                                style="max-height:200px; max-width:100%; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.1);"
                                alt="Portada actual">
                            <p class="text-muted small mt-2">Portada actual</p>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <div class="input-group">
                            <button class="btn btn-outline-secondary" type="button"
                                onclick="document.getElementById('portada').click()">
                                <i class="fas fa-upload"></i> Seleccionar
                            </button>
                            <input type="text" id="file-name" class="form-control"
                                placeholder="Ningún archivo" readonly>
                            <input type="file" name="portada" id="portada"
                                class="d-none" accept="image/*"
                                onchange="updateFileName(this)">
                        </div>
                        <small class="text-muted">Dejar vacío para mantener la portada actual.</small>
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
        if (input.files.length > 0) {
            fileNameField.value = input.files[0].name;
        } else {
            fileNameField.value = 'Ningún archivo';
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
</script>

<?= $footer ?>