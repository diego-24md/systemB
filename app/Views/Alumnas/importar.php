<?php

/** @var string $header */
/** @var string $footer */
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

    .upload-area {
        border: 2px dashed #e2e8f0;
        border-radius: 10px;
        padding: 40px 20px;
        text-align: center;
        color: #94a3b8;
        cursor: pointer;
        transition: border-color 0.2s;
    }

    .upload-area:hover {
        border-color: #2e7d52;
    }

    .upload-area i {
        font-size: 2rem;
        margin-bottom: 10px;
        display: block;
        color: #2e7d52;
    }

    .info-box {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 16px;
        font-size: 0.85rem;
        color: #15803d;
    }

    .step-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 14px;
    }

    .step-number {
        background-color: #1e3a5f;
        color: #fff;
        font-size: 0.75rem;
        font-weight: 700;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .step-text {
        font-size: 0.83rem;
        color: #475569;
        line-height: 1.5;
    }

    .step-text strong {
        color: #1a1a2e;
    }
</style>

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

    <!-- Mensajes -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0"
            style="background:#fef2f2;color:#dc2626;">
            <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= base_url('alumnas/guardar') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="row g-4">

            <!-- Columna izquierda -->
            <div class="col-md-8">

                <!-- Grado y Sección -->
                <div class="panel">
                    <div class="panel-label">Grado y sección</div>
                    <div class="row g-3">

                        <!-- GRADO -->
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <label class="form-label-custom">Sección <span class="text-danger">*</span></label>
                            <select name="seccion" id="seccion" class="form-select" required disabled>
                                <option value="">Primero seleccione un grado</option>
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

            </div>

            <!-- Columna derecha -->
            <div class="col-md-4">

                <!-- Instrucciones -->
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
                        <div class="step-text">Selecciona el <strong>grado y sección</strong> correspondiente en los campos de arriba.</div>
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

                <!-- Advertencia -->
                <div class="panel" style="border-color:#fee2e2;background:#fef2f2;">
                    <div class="panel-label" style="color:#dc2626;">Advertencia</div>
                    <p style="font-size:0.83rem;color:#dc2626;margin:0;">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        Al importar se <strong>eliminarán</strong> las alumnas existentes del grado y sección seleccionados.
                    </p>
                </div>

            </div>
        </div>

        <!-- Botones -->
        <div class="d-flex gap-2 mt-2">
            <button type="submit" class="btn btn-guardar">
                <i class="fas fa-upload me-2"></i> Importar alumnas
            </button>
            <a href="<?= base_url('alumnas') ?>" class="btn btn-cancelar">Cancelar</a>
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

        const filtradas = todasSecciones.filter(s => String(s.grado_id) === String(gradoId));

        filtradas.forEach(s => {
            const opt = document.createElement('option');
            opt.value = s.id;
            opt.textContent = s.nombre;
            select.appendChild(opt);
        });
    }

    function mostrarNombre(input) {
        const nombre = input.files[0]?.name ?? 'Haz clic para seleccionar el archivo';
        document.getElementById('upload-text').textContent = nombre;
    }
</script>

<?= $footer ?>