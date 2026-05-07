<?php

/** @var string $header */
/** @var string $footer */
/** @var array $usuario */
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

    .avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.3s;
    }

    .avatar:hover {
        border-color: #4e73df;
        transform: scale(1.05);
    }

    .form-label-custom {
        font-size: 0.82rem;
        color: #475569;
        font-weight: 600;
        margin-bottom: 6px;
    }

    /* CORRECCIÓN DEL OJO */

    .password-toggle {
        position: relative;
    }

    .password-toggle input {
        padding-right: 45px;
    }

    .toggle-password {
        position: absolute;
        right: 15px;
        top: 42px;
        color: #4e73df;
        font-size: 1.1rem;
        cursor: pointer;
        z-index: 10;
    }

    .toggle-password:hover {
        color: #2c4a9c;
        transform: scale(1.1);
    }

    .btn-guardar {
        background-color: #1e3a5f;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 11px 24px;
        font-size: 0.95rem;
        font-weight: 600;
    }

    .btn-guardar:hover {
        background-color: #16304f;
        transform: translateY(-2px);
    }

    .upload-label {
        cursor: pointer;
        color: #4e73df;
        font-weight: 600;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: #1a1a2e;
    }

    .badge-rol {
        display: inline-block;
        background: #eef2ff;
        color: #1e40af;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
    }
</style>

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="page-title">Mi perfil</div>
            <div class="page-subtitle">Gestiona tu información personal</div>
        </div>
    </div>

    <!-- Alertas -->
    <?php if (session()->getFlashdata('success')): ?>
        <div id="success-alert" class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div id="error-alert" class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="row g-4">

        <!-- FOTO DE PERFIL -->
        <div class="col-md-4">
            <div class="panel text-center">

                <form method="POST"
                    action="<?= base_url('perfil/actualizar-foto') ?>"
                    enctype="multipart/form-data"
                    id="form-foto">

                    <?= csrf_field() ?>

                    <?php
                    $foto = $usuario['foto'] ?? '1778168204_5dcdf5ba90d9177c6739.png';
                    ?>

                    <label for="foto" class="d-inline-block">
                        <img
                            src="<?= base_url('uploads/perfiles/' . $foto) ?>"
                            class="avatar mb-3"
                            id="preview-avatar">
                    </label>

                    <input
                        type="file"
                        name="foto"
                        id="foto"
                        accept="image/*"
                        style="display:none;"
                        onchange="previewImage(event)">

                    <div class="mt-2">
                        <label for="foto" class="upload-label">
                            <i class="fas fa-camera"></i> Cambiar foto
                        </label>
                    </div>
                </form>

                <div class="mt-4">
                    <div class="panel-label">Datos actuales</div>

                    <div class="info-value">
                        <?= esc((string)($usuario['nombre'] ?? '')) ?>
                    </div>

                    <div class="badge-rol mt-2">
                        <i class="fas fa-shield-alt me-1"></i>
                        <?= ucfirst(esc((string)($usuario['rol'] ?? ''))) ?>
                    </div>
                </div>

            </div>
        </div>

        <!-- FORMULARIOS -->
        <div class="col-md-8">

            <!-- ACTUALIZAR NOMBRE -->
            <div class="panel">
                <div class="panel-label">
                    Actualizar Nombre Completo
                </div>

                <form method="POST" action="<?= base_url('perfil/actualizar') ?>">
                    <?= csrf_field() ?>

                    <input type="hidden" name="tipo" value="nombre">

                    <div class="mb-4">
                        <label class="form-label-custom">
                            Nombre completo
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="nombre"
                            value="<?= esc((string)($usuario['nombre'] ?? '')) ?>"
                            class="form-control"
                            required>
                    </div>

                    <button type="submit" class="btn btn-guardar">
                        <i class="fas fa-save me-2"></i>
                        Actualizar Nombre
                    </button>
                </form>
            </div>

            <!-- CAMBIAR CONTRASEÑA -->
            <div class="panel">
                <div class="panel-label">
                    Cambiar Contraseña
                </div>

                <form method="POST" action="<?= base_url('perfil/actualizar') ?>">
                    <?= csrf_field() ?>

                    <input type="hidden" name="tipo" value="password">

                    <!-- Contraseña actual -->
                    <div class="mb-3 password-toggle">
                        <label class="form-label-custom">
                            Contraseña actual
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="password"
                            name="password_actual"
                            id="password_actual"
                            class="form-control"
                            required>

                        <i
                            class="toggle-password fas fa-eye"
                            data-target="password_actual">
                        </i>
                    </div>

                    <!-- Nueva contraseña -->
                    <div class="mb-3 password-toggle">
                        <label class="form-label-custom">
                            Nueva contraseña
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="password"
                            name="password_nueva"
                            id="password_nueva"
                            class="form-control"
                            required>

                        <i
                            class="toggle-password fas fa-eye"
                            data-target="password_nueva">
                        </i>
                    </div>

                    <!-- Confirmar contraseña -->
                    <div class="mb-4 password-toggle">
                        <label class="form-label-custom">
                            Confirmar nueva contraseña
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="password"
                            name="password_confirmar"
                            id="password_confirmar"
                            class="form-control"
                            required>

                        <i
                            class="toggle-password fas fa-eye"
                            data-target="password_confirmar">
                        </i>
                    </div>

                    <button type="submit" class="btn btn-guardar">
                        <i class="fas fa-key me-2"></i>
                        Cambiar Contraseña
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<?= $footer ?>

<script>
    // Preview de imagen antes de subir
    function previewImage(event) {
        const reader = new FileReader();

        reader.onload = function() {
            document.getElementById('preview-avatar').src = reader.result;
        }

        reader.readAsDataURL(event.target.files[0]);

        // Enviar automáticamente el formulario
        setTimeout(() => {
            document.getElementById('form-foto').submit();
        }, 800);
    }

    // Mostrar / ocultar contraseña
    document.querySelectorAll('.toggle-password').forEach(icon => {
        icon.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);

            if (input.type === "password") {
                input.type = "text";
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });
    });

    // Auto ocultar alertas
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            alert.remove();
        });
    }, 5000);
</script>