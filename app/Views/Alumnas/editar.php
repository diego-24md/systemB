<?php

/** @var string $header */
/** @var string $footer */
/** @var array $alumna */
/** @var array $grados */
/** @var array $secciones */
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

    .form-label-custom {
        font-size: 0.82rem;
        color: #475569;
        margin-bottom: 6px;
    }

    .form-select,
    .form-control {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.88rem;
        padding: 10px 14px;
        color: #475569;
    }

    .btn-guardar {
        background-color: #1e3a5f;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 24px;
        font-size: 0.9rem;
    }

    .btn-guardar:hover {
        background-color: #16304f;
    }

    .btn-cancelar {
        border: 1px solid #e2e8f0;
        color: #64748b;
        border-radius: 8px;
        padding: 10px 24px;
        font-size: 0.9rem;
        background: #fff;
    }
</style>

<div class="container-fluid px-4 py-4">

    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="page-title">Editar alumna</div>
            <div class="page-subtitle">Modifica los datos de la alumna seleccionada</div>
        </div>
        <a href="<?= base_url('alumnas') ?>" class="btn btn-cancelar">
            <i class="fas fa-arrow-left me-2"></i> Volver
        </a>
    </div>

    <!-- Mensajes de error de validación -->
    <?php if (isset($validation)): ?>
        <div class="alert alert-danger alert-dismissible fade show" style="background:#fef2f2;color:#dc2626;">
            <?= $validation->listErrors() ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= base_url('alumnas/actualizar/' . $alumna['id']) ?>">
        <?= csrf_field() ?>

        <div class="row g-4">

            <!-- Columna izquierda -->
            <div class="col-md-8">

                <!-- Datos personales -->
                <div class="panel">
                    <div class="panel-label">Datos personales</div>
                    <div class="row g-3">

                        <div class="col-md-8">
                            <label class="form-label-custom">Apellidos y Nombres <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control"
                                value="<?= esc((string)($alumna['nombre'] ?? '')) ?>" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label-custom">DNI <span class="text-danger">*</span></label>
                            <input type="text" name="dni" class="form-control" maxlength="8"
                                value="<?= esc((string)($alumna['dni'] ?? '')) ?>" required>
                        </div>

                    </div>
                </div>

                <!-- Grado y Sección -->
                <div class="panel">
                    <div class="panel-label">Grado y sección</div>
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label-custom">Grado <span class="text-danger">*</span></label>
                            <select name="grado_id" id="selectGrado" class="form-select" required
                                onchange="filtrarSecciones(this.value)">
                                <option value="">Seleccione grado</option>
                                <?php foreach ($grados as $g): ?>
                                    <option value="<?= $g['id'] ?>"
                                        <?= $alumna['grado_id'] == $g['id'] ? 'selected' : '' ?>>
                                        <?= esc((string)$g['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-custom">Sección <span class="text-danger">*</span></label>
                            <select name="seccion_id" id="selectSeccion" class="form-select" required>
                                <option value="">Seleccione sección</option>
                                <?php foreach ($secciones as $s): ?>
                                    <?php if ($s['grado_id'] == $alumna['grado_id']): ?>
                                        <option value="<?= $s['id'] ?>"
                                            <?= $alumna['seccion_id'] == $s['id'] ? 'selected' : '' ?>>
                                            <?= esc((string)$s['nombre']) ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Columna derecha -->
            <div class="col-md-4">
                <div class="panel" style="background:#f0fdf4;border-color:#bbf7d0;">
                    <div class="panel-label" style="color:#15803d;">Información</div>
                    <p style="font-size:0.83rem;color:#15803d;margin:0;">
                        <i class="fas fa-info-circle me-1"></i>
                        El campo <strong>Apellidos y Nombres</strong> debe seguir el formato del SIAGIE:<br><br>
                        <strong>APELLIDOS, NOMBRES</strong><br>
                        Ejemplo: <em>FLORES GARCIA, ANA LUCIA</em>
                    </p>
                </div>
            </div>

        </div>

        <!-- Botones -->
        <div class="d-flex gap-2 mt-2">
            <button type="submit" class="btn btn-guardar">
                <i class="fas fa-save me-2"></i> Guardar cambios
            </button>
            <a href="<?= base_url('alumnas') ?>" class="btn btn-cancelar">Cancelar</a>
        </div>

    </form>
</div>

<script>
    const todasSecciones = <?= json_encode($secciones) ?>;

    function filtrarSecciones(gradoId) {
        const select = document.getElementById('selectSeccion');
        select.innerHTML = '<option value="">Seleccione sección</option>';

        if (!gradoId) return;

        todasSecciones.forEach(function(s) {
            if (String(s.grado_id) === String(gradoId)) {
                const opt = document.createElement('option');
                opt.value = s.id;
                opt.textContent = s.nombre;
                select.appendChild(opt);
            }
        });
    }
</script>

<?= $footer ?>