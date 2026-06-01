<?php

/** @var string $header */
/** @var string $footer */
/** @var array $grados */
/** @var array $secciones */
?>
<?= $header ?>

<link rel="stylesheet" href="<?= base_url('css/alumnas/importar.css') ?>">

<div class="container-fluid px-4 py-4">

    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="page-title">Importar alumnas</div>
            <div class="page-subtitle">Carga masiva desde archivo Excel por grado y sección</div>
        </div>
        <a href="<?= base_url('alumnas') ?>" class="btn btn-cancelar">
            <i class="fas fa-arrow-left me-2"></i> Volver
        </a>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div id="alerta-error" class="alert alert-danger rounded-3 border-0" style="background:#fef2f2;color:#dc2626;">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div id="alerta-success" class="alert alert-success rounded-3 border-0">
            <i class="fas fa-check-circle mr-2"></i>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= base_url('alumnas/guardar') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="row g-4">

            <!-- Columna izquierda -->
            <div class="col-md-8">

                <!-- Grado, Sección y Turno -->
                <div class="panel">
                    <div class="panel-label">Grado, sección y turno</div>
                    <div class="row g-3">

                        <!-- GRADO -->
                        <div class="col-md-4">
                            <label class="form-label-custom">Grado <span class="text-danger">*</span></label>
                            <select name="grado" id="grado" class="form-select" required onchange="filtrarSecciones(this.value)">
                                <option value="">Seleccione grado</option>
                                <?php if (!empty($grados)): ?>
                                    <?php foreach ($grados as $g): ?>
                                        <option value="<?= esc((string)$g['id']) ?>">
                                            <?= esc((string)$g['nombre']) ?> Secundaria
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">No hay grados disponibles</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- SECCIÓN -->
                        <div class="col-md-4">
                            <label class="form-label-custom">Sección <span class="text-danger">*</span></label>
                            <select name="seccion" id="seccion" class="form-select" required disabled>
                                <option value="">Primero seleccione un grado</option>
                            </select>
                        </div>

                        <!-- TURNO -->
                        <div class="col-md-4">
                            <label class="form-label-custom">Turno <span class="text-danger">*</span></label>
                            <select name="turno" id="turno" class="form-select" required>
                                <option value="">Seleccione turno</option>
                                <option value="manana">Mañana</option>
                                <option value="tarde">Tarde</option>
                            </select>
                        </div>

                    </div>
                </div>

                <!-- Archivo -->
                <div class="panel">
                    <div class="panel-label">Archivo Excel</div>
                    <div class="upload-area" onclick="document.getElementById('archivo').click()">
                        <i class="fas fa-file-excel"></i>
                        <p id="upload-text">Haz clic para seleccionar el archivo</p>
                        <small>.xlsx o .xls — máx. 5MB</small>
                    </div>
                    <input type="file" name="archivo" id="archivo" accept=".xlsx,.xls"
                        class="d-none" required onchange="mostrarNombre(this)">
                </div>

                <button type="submit" class="btn btn-guardar w-100">
                    <i class="fas fa-upload me-2"></i> Importar alumnas
                </button>

            </div>

            <!-- Columna derecha -->
            <div class="col-md-4">

                <div class="panel">
                    <div class="panel-label">¿Cómo importar?</div>
                    <div class="info-box mb-3">
                        <i class="fas fa-magic me-1"></i>
                        El sistema detecta automáticamente los datos del archivo SIAGIE.
                    </div>
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <div class="step-text">Ingresa al <strong>SIAGIE</strong> y exporta la nómina de matrícula del grado y sección que deseas importar.</div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <div class="step-text">Selecciona el <strong>grado, sección y turno</strong> correspondiente en los campos de arriba.</div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <div class="step-text">Sube el archivo <strong>.xlsx o .xls</strong> exportado del SIAGIE sin modificarlo.</div>
                    </div>
                    <div class="step-item mb-0">
                        <div class="step-number">4</div>
                        <div class="step-text">Haz clic en <strong>Importar alumnas</strong> y el sistema procesará todo automáticamente.</div>
                    </div>
                </div>

                <div class="panel" style="border-color:#fee2e2;background:#fef2f2;">
                    <div class="panel-label" style="color:#dc2626;">Advertencia</div>
                    <p style="font-size:0.83rem;color:#dc2626;margin:0;">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        Al importar se <strong>eliminarán</strong> las alumnas existentes del grado, sección y turno seleccionados.
                    </p>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
    const todasSecciones = <?= json_encode($secciones ?? []) ?>;

    function filtrarSecciones(gradoId) {
        const select = document.getElementById('seccion');
        select.innerHTML = '<option value="">Seleccione sección</option>';
        if (!gradoId) {
            select.disabled = true;
            return;
        }
        select.disabled = false;
        todasSecciones.filter(s => String(s.grado_id) === String(gradoId)).forEach(s => {
            const opt = document.createElement('option');
            opt.value = s.id;
            opt.textContent = s.nombre;
            select.appendChild(opt);
        });
    }

    function mostrarNombre(input) {
        document.getElementById('upload-text').textContent = input.files[0]?.name ?? 'Haz clic para seleccionar el archivo';
    }

    setTimeout(() => {
        document.getElementById('alerta-error')?.remove();
        document.getElementById('alerta-success')?.remove();
    }, 5000);
</script>

<?= $footer ?>