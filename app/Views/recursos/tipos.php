<?php

/** @var string $header */
/** @var string $footer */
/** @var array $tipos */
?>
<?= $header ?>

<link rel="stylesheet" href="<?= base_url('css/recursos/tipos.css') ?>">

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="page-title">Tipos de Recurso</div>
            <div class="page-subtitle">
                Gestiona los tipos disponibles (Libros, Revistas, Folletos, Biblias, etc.)
            </div>
        </div>
        <div class="d-flex" style="gap: 15px;">
            <a href="<?= base_url('libros/registrar') ?>" class="btn-volver">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <button class="btn-nuevo" onclick="abrirModalCrear()">
                <i class="fas fa-plus"></i> Nuevo Tipo
            </button>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert-success-bar"><i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert-error-bar"><i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="panel">
        <div class="panel-label">
            <i class="fas fa-tags" style="color:#2563eb;"></i>
            Tipos registrados
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>Tipo de Recurso</th>
                        <th style="width:140px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tipos)): ?>
                        <tr>
                            <td colspan="3">
                                <div class="empty-state">
                                    <i class="fas fa-tags"></i>
                                    <h5>Sin tipos registrados</h5>
                                    <p>Crea el primero usando el botón "Nuevo Tipo".</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($tipos as $i => $t): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><span class="badge-tipo"><i class="fas fa-tag"></i> <?= esc($t['tipo']) ?></span></td>
                                <td>
                                    <div class="actions-cell">
                                        <button class="btn-edit" title="Editar"
                                            onclick="abrirModalEditar(<?= $t['idtiporecurso'] ?>, '<?= esc($t['tipo']) ?>')">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <button class="btn-delete" title="Eliminar"
                                            onclick="confirmarEliminar('<?= base_url('recursos/tipos/eliminar/' . $t['idtiporecurso']) ?>', '<?= esc($t['tipo']) ?>')">
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

<!-- ===== MODAL CREAR ===== -->
<div id="modal-crear" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fas fa-plus-circle"></i> Nuevo Tipo de Recurso</h3>
            <button class="modal-close" onclick="cerrarModal('modal-crear')">&times;</button>
        </div>
        <form action="<?= base_url('recursos/tipos/guardar') ?>" method="post">
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="tipo-crear">Nombre del Tipo <span class="required">*</span></label>
                    <input type="text" id="tipo-crear" name="tipo" class="form-input"
                        placeholder="Ej: Libro, Revista, Folleto, Biblia..." required>
                    <small class="form-hint">Este nombre aparecerá al registrar nuevos recursos.</small>
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
            <h3><i class="fas fa-pencil-alt"></i> Editar Tipo de Recurso</h3>
            <button class="modal-close" onclick="cerrarModal('modal-editar')">&times;</button>
        </div>
        <form id="form-editar" action="" method="post">
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="tipo-editar">Nombre del Tipo <span class="required">*</span></label>
                    <input type="text" id="tipo-editar" name="tipo" class="form-input" required>
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
        <h3>¿Eliminar tipo?</h3>
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

    function abrirModalEditar(id, nombre) {
        document.getElementById('tipo-editar').value = nombre;
        document.getElementById('form-editar').action = '<?= base_url('recursos/tipos/actualizar/') ?>' + id;
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

    // Cerrar al hacer clic fuera del modal
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) cerrarModal(this.id);
        });
    });
</script>

<?= $footer ?>