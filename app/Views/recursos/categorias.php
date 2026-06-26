<?php

/** @var string $header */
/** @var string $footer */
/** @var array $categorias */
/** @var array $tipos */
?>
<?= $header ?>

<link rel="stylesheet" href="<?= base_url('css/recursos/categorias.css') ?>">

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="page-title">Categorías</div>
            <div class="page-subtitle">Gestiona las categorías agrupadas por tipo de recurso</div>
        </div>
        <div class="d-flex" style="gap: 12px;">
            <a href="<?= base_url('libros') ?>" class="btn-volver">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <button class="btn-nuevo" onclick="abrirModalCrear()">
                <i class="fas fa-plus"></i> Nueva Categoría
            </button>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert-success-bar"><i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert-error-bar"><i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="row g-4">

        <!-- Tabla -->
        <div class="col-lg-8">
            <div class="panel">
                <div class="panel-label">
                    <i class="fas fa-list" style="color:#2563eb;"></i>
                    Categorías registradas
                </div>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th style="width:60px;">#</th>
                                <th>Categoría</th>
                                <th>Tipo de Recurso</th>
                                <th style="width:140px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($categorias)): ?>
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-state">
                                            <i class="fas fa-folder-open"></i>
                                            <h5>Sin categorías registradas</h5>
                                            <p>Crea la primera usando el botón "Nueva Categoría".</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($categorias as $i => $cat): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><strong><?= esc($cat['categoria']) ?></strong></td>
                                        <td>
                                            <span class="badge-tipo">
                                                <i class="fas fa-book"></i> <?= esc($cat['tipo'] ?? '—') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="actions-cell">
                                                <button class="btn-edit" title="Editar"
                                                    onclick="abrirModalEditar(
                                                        <?= $cat['idcategoria'] ?>,
                                                        '<?= esc($cat['categoria']) ?>',
                                                        <?= (int)($cat['idtiporecurso'] ?? 0) ?>
                                                    )">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                                <button class="btn-delete" title="Eliminar"
                                                    onclick="confirmarEliminar('<?= base_url('recursos/categorias/eliminar/' . $cat['idcategoria']) ?>', '<?= esc($cat['categoria']) ?>')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Panel informativo -->
        <div class="col-lg-4">
            <div class="panel panel-info">
                <div class="panel-label" style="color:#1b2436;">
                    <i class="fas fa-info-circle" style="color:#2563eb;"></i>
                    ¿Para qué sirven las categorías?
                </div>
                <p class="info-text">
                    Las <strong>categorías</strong> permiten organizar los recursos dentro de cada tipo, facilitando la búsqueda y el orden del catálogo.
                </p>
                <div class="step-item">
                    <div class="step-icon"><i class="fas fa-list"></i></div>
                    <div class="step-text">Cada categoría pertenece a un <strong>tipo de recurso</strong> (Ej: "Matemática" pertenece a "Libro").</div>
                </div>
                <div class="step-item">
                    <div class="step-icon"><i class="fas fa-search"></i></div>
                    <div class="step-text">Al registrar un recurso, primero se elige el tipo y luego la categoría correspondiente.</div>
                </div>
                <div class="step-item">
                    <div class="step-icon warn"><i class="fas fa-exclamation-triangle"></i></div>
                    <div class="step-text">No puedes eliminar una categoría si tiene recursos asignados.</div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- ===== MODAL CREAR ===== -->
<div id="modal-crear" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fas fa-plus-circle"></i> Nueva Categoría</h3>
            <button class="modal-close" onclick="cerrarModal('modal-crear')">&times;</button>
        </div>
        <form action="<?= base_url('recursos/categorias/guardar') ?>" method="post">
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="tipo-crear">Tipo de Recurso <span class="required">*</span></label>
                    <select id="tipo-crear" name="idtiporecurso" class="form-input" required>
                        <option value="">— Selecciona un tipo —</option>
                        <?php foreach ($tipos as $t): ?>
                            <option value="<?= $t['idtiporecurso'] ?>"><?= esc($t['tipo']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small class="form-hint">
                        ¿No está el tipo? <a href="<?= base_url('recursos/tipos') ?>">Crea uno nuevo aquí.</a>
                    </small>
                </div>
                <div class="form-group">
                    <label for="categoria-crear">Nombre de la Categoría <span class="required">*</span></label>
                    <input type="text" id="categoria-crear" name="categoria" class="form-input"
                        placeholder="Ej: Literatura, Ciencias, Historia..." required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="cerrarModal('modal-crear')">Cancelar</button>
                <button type="submit" class="btn-save"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- ===== MODAL EDITAR ===== -->
<div id="modal-editar" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fas fa-pencil-alt"></i> Editar Categoría</h3>
            <button class="modal-close" onclick="cerrarModal('modal-editar')">&times;</button>
        </div>
        <form id="form-editar" action="" method="post">
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="tipo-editar">Tipo de Recurso <span class="required">*</span></label>
                    <select id="tipo-editar" name="idtiporecurso" class="form-input" required>
                        <option value="">— Selecciona un tipo —</option>
                        <?php foreach ($tipos as $t): ?>
                            <option value="<?= $t['idtiporecurso'] ?>"><?= esc($t['tipo']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="categoria-editar">Nombre de la Categoría <span class="required">*</span></label>
                    <input type="text" id="categoria-editar" name="categoria" class="form-input" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="cerrarModal('modal-editar')">Cancelar</button>
                <button type="submit" class="btn-save"><i class="fas fa-save"></i> Actualizar</button>
            </div>
        </form>
    </div>
</div>

<!-- ===== MODAL ELIMINAR ===== -->
<div id="modal-eliminar" class="modal-overlay" style="display:none;">
    <div class="modal-box modal-box-sm">
        <div class="modal-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <h3>¿Eliminar categoría?</h3>
        <p id="modal-eliminar-texto">Esta acción no se puede deshacer.</p>
        <div class="modal-footer justify-content-center">
            <button class="btn-cancel" onclick="cerrarModal('modal-eliminar')">Cancelar</button>
            <a id="modal-eliminar-btn" href="#" class="btn-confirm-delete">Sí, eliminar</a>
        </div>
    </div>
</div>

<script>
    function abrirModalCrear() {
        document.getElementById('modal-crear').style.display = 'flex';
    }

    function abrirModalEditar(id, nombre, idTipo) {
        document.getElementById('categoria-editar').value = nombre;
        document.getElementById('form-editar').action = '<?= base_url('recursos/categorias/actualizar/') ?>' + id;
        const select = document.getElementById('tipo-editar');
        for (let opt of select.options) {
            opt.selected = (parseInt(opt.value) === idTipo);
        }
        document.getElementById('modal-editar').style.display = 'flex';
    }

    function confirmarEliminar(url, nombre) {
        document.getElementById('modal-eliminar-texto').textContent = '¿Seguro que quieres eliminar "' + nombre + '"?';
        document.getElementById('modal-eliminar-btn').href = url;
        document.getElementById('modal-eliminar').style.display = 'flex';
    }

    function cerrarModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) cerrarModal(this.id);
        });
    });
</script>

<?= $footer ?>