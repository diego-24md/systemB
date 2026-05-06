<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión — Sistema de Biblioteca</title>
    <link href="<?= base_url('vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800" rel="stylesheet">
    <link href="<?= base_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .login-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #4e73df, #224abe);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .login-icon i {
            font-size: 1.8rem;
            color: #fff;
        }

        .login-title {
            font-size: 1.3rem;
            font-weight: 800;
            color: #1a1a2e;
            text-align: center;
            margin-bottom: 4px;
        }

        .login-subtitle {
            font-size: 0.83rem;
            color: #94a3b8;
            text-align: center;
            margin-bottom: 28px;
        }

        .form-label {
            font-size: 0.82rem;
            color: #475569;
            font-weight: 600;
        }

        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.88rem;
            color: #334155;
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15);
        }

        .btn-login {
            background: linear-gradient(135deg, #4e73df, #224abe);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 11px;
            font-size: 0.9rem;
            font-weight: 700;
            width: 100%;
            margin-top: 8px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #5a7fe8, #2e59d9);
            color: #fff;
        }

        .alert-error {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.84rem;
            margin-bottom: 16px;
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.85rem;
        }

        .input-icon .form-control {
            padding-left: 34px;
        }
    </style>
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