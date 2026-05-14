<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión — Sistema de Biblioteca</title>
    <link href="<?= base_url('vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800" rel="stylesheet">
    <link href="<?= base_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/auth/login.css') ?>">
</head>

<body>

    <div class="login-card">

        <div class="login-icon">
            <i class="fas fa-book-open"></i>
        </div>

        <div class="login-title">Sistema de Biblioteca</div>
        <div class="login-subtitle">Acceso para bibliotecarios</div>

        <?php if (!empty($error)): ?>
            <div class="alert-error">
                <i class="fas fa-exclamation-circle me-1"></i> <?= esc($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= base_url('login') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" name="usuario" class="form-control"
                        placeholder="Ingresa tu usuario" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="form-control"
                        placeholder="Ingresa tu contraseña" required>
                </div>
            </div>

            <button type="submit" class="btn btn-login">
                <i class="fas fa-sign-in-alt me-2"></i> Iniciar sesión
            </button>

        </form>

    </div>

</body>

</html>