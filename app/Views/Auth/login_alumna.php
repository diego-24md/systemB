<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceso Alumnas — Biblioteca</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('css/auth/login_alumna.css') ?>">
</head>

<body>

    <div class="login-card">
        <div class="login-header">
            <div class="login-icon">
                <img src="<?= base_url('img/insignia.png') ?>" alt="Logo IE">
            </div>
            <div class="login-title">Biblioteca Escolar</div>
            <div class="login-subtitle">Institución Educativa Chinchaysuyo</div>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i> <?= esc($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= base_url('alumnas/login') ?>">
            <?= csrf_field() ?>

            <div class="form-group">
                <label class="form-label">DNI</label>
                <div class="input-icon">
                    <i class="fas fa-id-card"></i>
                    <input type="text" name="dni" placeholder="Ingresa tu DNI" maxlength="8" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Apellido paterno</label>
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" name="nombre" placeholder="Ingresa tu apellido paterno" required>
                </div>
                <p class="hint">Ingresa solo tu primer apellido tal como aparece en tu DNI.</p>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Ingresar
            </button>
        </form>
    </div>

</body>

</html>