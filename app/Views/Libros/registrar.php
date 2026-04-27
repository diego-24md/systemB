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

    #autores-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .autor-item {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f4f6f9;
        padding: 8px;
        border-radius: 8px;
        border: 1px solid #dce3ea;
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

<div class="form-container">
    <h2>Registrar Libro</h2>

    <form action="<?= base_url('libros/guardar') ?>" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label>Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Autores</label>
            <div id="autores-container">
                <div class="autor-item">
                    <input type="text" name="autores[]" placeholder="Escribe el autor">
                    <button type="button" class="btn-remove" onclick="this.parentElement.remove()">✕</button>
                </div>
            </div>
            <button type="button" class="btn-add" onclick="agregarAutor()">+ Agregar autor</button>
        </div>

        <div class="form-group">
            <label>ISBN</label>
            <input type="text" name="isbn" class="form-control" maxlength="13" pattern="\d{10,13}"
                title="El ISBN debe tener 10 o 13 dígitos numéricos"
                oninput="this.value = this.value.replace(/\D/g, '').slice(0, 13)"
                placeholder="Ej: 9780306406157" required>
            <small class="text-muted" id="isbn-contador">0 / 13 dígitos</small>
        </div>

        <div class="form-group">
            <label>Año</label>
            <input type="number" name="anio" class="form-control" min="1900" max="2026" required>
        </div>

        <div class="form-group">
            <label>Número de Páginas</label>
            <input type="number" name="numpaginas" class="form-control" min="1" required>
        </div>

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
            <div class="mb-4">
                <div class="input-group">
                    <button class="btn btn-outline-secondary" type="button"
                        onclick="document.getElementById('portada').click()">
                        <i class="fas fa-upload"></i> Seleccionar archivo
                    </button>
                    <input type="text" id="file-name" class="form-control"
                        placeholder="Ningún archivo seleccionado" readonly>
                    <input type="file" name="portada" id="portada" class="d-none"
                        accept="image/*" onchange="updateFileName(this)">
                </div>
                <div class="mt-3 text-center">
                    <img id="previewImg"
                        style="max-height: 220px; max-width: 100%; border-radius: 8px; display: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1);"
                        alt="Vista previa">
                </div>
            </div>
        </div>

        <div class="btn-group">
            <a href="<?= base_url('libros') ?>" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-submit">Guardar Libro</button>
        </div>

    </form>
</div>

<script>
    document.querySelector('input[name="isbn"]').addEventListener('input', function() {
        document.getElementById('isbn-contador').textContent = this.value.length + ' / 13 dígitos';
    });

    function updateFileName(input) {
        const fileNameField = document.getElementById('file-name');
        const previewImg = document.getElementById('previewImg');

        if (input.files.length > 0) {
            const file = input.files[0];
            fileNameField.value = file.name;

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            fileNameField.value = "Ningún archivo seleccionado";
            previewImg.style.display = 'none';
        }
    }

    function agregarAutor() {
        const container = document.getElementById('autores-container');
        const div = document.createElement('div');
        div.className = 'autor-item'; // ✅ misma clase y estilo
        div.innerHTML = `
            <input type="text" name="autores[]" placeholder="Escribe el autor">
            <button type="button" class="btn-remove" onclick="this.parentElement.remove()">✕</button>
        `;
        container.appendChild(div);
    }

    // ✅ Un solo evento submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const autores = document.querySelectorAll('input[name="autores[]"]');
        let valido = false;

        autores.forEach(input => {
            if (input.value.trim() !== '') {
                valido = true;
            }
        });

        if (!valido) {
            e.preventDefault();
            alert('Debe ingresar al menos un autor válido');
        }
    });
</script>

<?= $footer ?>