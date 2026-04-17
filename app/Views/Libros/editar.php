<?= $header ?>

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

                        <!-- Título -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Título del libro <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="titulo"
                                class="form-control <?= session('errors.titulo') ? 'is-invalid' : '' ?>"
                                value="<?= old('titulo', esc($libro['titulo'])) ?>" required>
                            <?= session('errors.titulo') ? '<div class="invalid-feedback">' . session('errors.titulo') . '</div>' : '' ?>
                        </div>

                        <!-- ISBN -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">ISBN</label>
                            <input type="text" name="isbn"
                                class="form-control <?= session('errors.isbn') ? 'is-invalid' : '' ?>"
                                value="<?= old('isbn', esc($libro['isbn'] ?? '')) ?>">
                            <?= session('errors.isbn') ? '<div class="invalid-feedback">' . session('errors.isbn') . '</div>' : '' ?>
                        </div>

                        <div class="row">
                            <!-- Año -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Año de publicación</label>
                                <input type="number" name="anio"
                                    class="form-control <?= session('errors.anio') ? 'is-invalid' : '' ?>"
                                    value="<?= old('anio', esc($libro['anio'] ?? '')) ?>">
                                <?= session('errors.anio') ? '<div class="invalid-feedback">' . session('errors.anio') . '</div>' : '' ?>
                            </div>

                            <!-- Número de páginas -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Número de páginas</label>
                                <input type="number" name="numpaginas"
                                    class="form-control <?= session('errors.numpaginas') ? 'is-invalid' : '' ?>"
                                    value="<?= old('numpaginas', esc($libro['numpaginas'] ?? '')) ?>">
                                <?= session('errors.numpaginas') ? '<div class="invalid-feedback">' . session('errors.numpaginas') . '</div>' : '' ?>
                            </div>
                        </div>

                        <!-- Portada del libro -->
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

                            <!-- Input de archivo mejorado -->
                            <div class="input-group">
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="document.getElementById('portada').click()">
                                    <i class="fas fa-upload"></i> Seleccionar archivo
                                </button>
                                <input type="text" id="file-name" class="form-control"
                                    placeholder="Ningún archivo seleccionado" readonly>
                                <input type="file" name="portada" id="portada"
                                    class="d-none <?= session('errors.portada') ? 'is-invalid' : '' ?>" accept="image/*"
                                    onchange="updateFileName(this)">
                            </div>

                            <small class="text-muted d-block mt-1">Dejar vacío si no se quiere cambiar la
                                portada.</small>

                            <?= session('errors.portada') ? '<div class="invalid-feedback d-block">' . session('errors.portada') . '</div>' : '' ?>
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
</script>

<?= $footer ?>