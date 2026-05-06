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
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e2e8f0;
    }

    .info-label {
        font-size: 0.75rem;
        color: #94a3b8;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 2px;
    }

    .info-value {
        font-size: 0.92rem;
        color: #1a1a2e;
        font-weight: 600;
    }

    .badge-rol {
        background-color: #e0f2fe;
        color: #0369a1;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.78rem;
    }

    .form-label-custom {
        font-size: 0.82rem;
        color: #475569;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .form-control {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.88rem;
        padding: 10px 14px;
        color: #475569;
    }

    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15);
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
        color: #fff;
    }
</style>

<div class="container-fluid px-4 py-4">

    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="page-title">Mi perfil</div>
            <div class="page-subtitle">Información de tu cuenta</div>
        </div>
    </div>

    <!-- Mensajes -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" style="background:#f0fdf4;color:#15803d;">
            <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" style="background:#fef2f2;color:#dc2626;">
            <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">

        <!-- Columna izquierda - Info -->
        <div class="col-md-4">
            <div class="panel text-center">
                <img src="<?= base_url('img/bibliotecario.png') ?>" class="avatar mb-3">
                <div style="font-size:1.1rem;font-weight:700;color:#1a1a2e;">
                    <?= esc((string)($usuario['nombre'] ?? '')) ?>
                </div>
                <div class="mt-2">
                    <span class="badge-rol">
                        <i class="fas fa-shield-alt me-1"></i>
                        <?= ucfirst(esc((string)($usuario['rol'] ?? ''))) ?>
                    </span>
                </div>
            </div>

            <div class="panel">
                <div class="panel-label">Información de cuenta</div>
                <div class="mb-3">
                    <div class="info-label">Usuario</div>
                    <div class="info-value"><?= esc((string)($usuario['usuario'] ?? '')) ?></div>
                </div>
                <div class="mb-3">
                    <div class="info-label">Nombre completo</div>
                    <div class="info-value"><?= esc((string)($usuario['nombre'] ?? '')) ?></div>
                </div>
                <div>
                    <div class="info-label">Estado</div>
                    <div class="info-value">
                        <?php if ($usuario['activo']): ?>
                            <span style="color:#15803d;"><i class="fas fa-circle me-1" style="font-size:0.6rem;"></i>Activo</span>
                        <?php else: ?>
                            <span style="color:#dc2626;"><i class="fas fa-circle me-1" style="font-size:0.6rem;"></i>Inactivo</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna derecha - Cambiar contraseña -->
        <div class="col-md-8">
            <div class="panel">
                <div class="panel-label">Cambiar contraseña</div>

                <form method="POST" action="<?= base_url('perfil/cambiar-password') ?>">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label-custom">Contraseña actual <span class="text-danger">*</span></label>
                        <input type="password" name="password_actual" class="form-control"
                            placeholder="Ingresa tu contraseña actual" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Nueva contraseña <span class="text-danger">*</span></label>
                        <input type="password" name="password_nueva" class="form-control"
                            placeholder="Mínimo 6 caracteres" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Confirmar nueva contraseña <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmar" class="form-control"
                            placeholder="Repite la nueva contraseña" required>
                    </div>

                    <button type="submit" class="btn btn-guardar">
                        <i class="fas fa-save me-2"></i> Guardar cambios
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<?= $footer ?>