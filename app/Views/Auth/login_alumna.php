<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceso Alumnas — Biblioteca</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: linear-gradient(135deg, #b8001e 0%, #7a0012 50%, #1a0005 100%);
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

        .login-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .login-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #b8001e, #7a0012);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .login-icon i {
            font-size: 1.8rem;
            color: #fff;
        }

        .login-title {
            font-size: 1.3rem;
            font-weight: 800;
            color: #1a1a2e;
            margin-bottom: 4px;
        }

        .login-subtitle {
            font-size: 0.83rem;
            color: #94a3b8;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 0.82rem;
            color: #475569;
            font-weight: 600;
            margin-bottom: 6px;
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

        .input-icon input {
            width: 100%;
            padding: 10px 14px 10px 34px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.88rem;
            color: #334155;
            outline: none;
            transition: border-color 0.2s;
        }

        .input-icon input:focus {
            border-color: #b8001e;
            box-shadow: 0 0 0 3px rgba(184, 0, 30, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 11px;
            background: linear-gradient(135deg, #b8001e, #7a0012);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 8px;
            transition: opacity 0.2s;
        }

        .btn-login:hover {
            opacity: 0.9;
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

        .hint {
            font-size: 0.78rem;
            color: #94a3b8;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <div class="login-header">
            <div class="login-icon">
                <i class="fas fa-graduation-cap"></i>
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