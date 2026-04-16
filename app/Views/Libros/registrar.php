<?= $header ?>

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

        <!-- ✅ ISBN -->
        <div class="form-group">
            <label>ISBN</label>
            <input type="text" name="isbn" class="form-control" required>
        </div>

        <!-- ✅ TIPO DE RECURSO DESDE BD -->
        <div class="form-group">
            <label>Tipo de Recurso</label>
            <select name="id_categoria" class="form-control" required>
                <option value="">Seleccione...</option>

                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= $cat['id'] ?>">
                        <?= esc($cat['nombre']) ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <div class="form-group">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label>Portada</label>
            <input type="file" name="portada" class="form-control" accept="image/*" onchange="previewImage(event)">

            <div class="preview">
                <img id="previewImg">
            </div>
        </div>

        <button type="submit" class="btn-submit">Guardar Libro</button>

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