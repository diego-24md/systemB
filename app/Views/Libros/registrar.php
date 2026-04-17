<?= $header ?>

<style>
    .btn-submit {
        background: #1a3c6e;
        color: #fff;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .btn-submit:hover {
        background: #2457a6;
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.2);
    }

    .btn-cancel {
        background: #6c757d;
        color: #fff;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #6c757d;
        color: #fff;
        transform: translateY(-2px);
        text-decoration: none;
    }

    .btn-group {
        display: flex;
        gap: 12px;
        margin-top: 20px;
    }
</style>

<div class="form-container">
    <h2>Registrar Libro</h2>

    <form action="<?= base_url('libros/guardar') ?>" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label>Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Autor</label>
            <input type="text" name="autor" class="form-control" required>
        </div>

        <div class="form-group">
            <label>ISBN</label>
            <input type="text" name="isbn" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Año</label>
            <input type="number" name="anio" class="form-control" min="1900" max="2026" required>
        </div>

        <div class="form-group">
            <label>Número de Páginas</label>
            <input type="number" name="numpaginas" class="form-control" min="1" required>
        </div>

        <!-- TIPO DE RECURSO -->
        <div class="form-group">
            <label>Tipo de Recurso</label>
            <select name="id_tipo_recurso" class="form-control" required>
                <option value="">Seleccione...</option>
                <?php foreach ($tipos_recurso as $tipo): ?>
                    <option value="<?= $tipo['idtiporecurso'] ?>">
                        <?= esc($tipo['tipo']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- CATEGORÍA -->
        <div class="form-group">
            <label>Categoría</label>
            <select name="categoria_id" class="form-control" required>
                <option value="">Seleccione...</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= $cat['idcategoria'] ?>">
                        <?= esc($cat['categoria']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" rows="4"></textarea>
        </div>

        <div class="form-group">
            <label>Portada</label>
            <input type="file" name="portada" class="form-control" accept="image/*" onchange="previewImage(event)">

            <div class="preview">
                <img id="previewImg" style="max-width: 200px; margin-top: 10px; display: none; border-radius: 6px;">
            </div>
        </div>

        <!-- Botones -->
        <div class="btn-group">
            <a href="<?= base_url('libros') ?>" class="btn-cancel">
                Cancelar
            </a>
            <button type="submit" class="btn-submit">
                Guardar Libro
            </button>
        </div>

    </form>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('previewImg');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<?= $footer ?>