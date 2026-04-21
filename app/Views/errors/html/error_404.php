<?php
http_response_code(404);

$titulo_sistema = "Sistema de Biblioteca";
$nombre_biblioteca = "Biblioteca - Colegio Chinchaysuyo";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página no encontrada | <?php echo $titulo_sistema; ?></title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #f1f3f6 100%);
            color: #1e2937;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background: linear-gradient(90deg, #9c1c2b 0%, #b81e2f 100%);
            color: white;
            padding: 18px 30px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 4px 15px rgba(156, 28, 43, 0.3);
        }

        header .logo-icon {
            font-size: 34px;
        }

        header h1 {
            font-size: 23px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .error-card {
            background: white;
            border-radius: 16px;
            padding: 60px 50px;
            text-align: center;
            max-width: 560px;
            width: 100%;
            box-shadow: 0 10px 35px rgba(156, 28, 43, 0.12);
            border-top: 7px solid #d4af37;
        }

        .book-icon {
            font-size: 92px;
            margin-bottom: 20px;
        }

        .error-code {
            font-size: 96px;
            font-weight: 800;
            color: #9c1c2b;
            line-height: 1;
            margin-bottom: 10px;
        }

        .error-title {
            font-size: 27px;
            font-weight: 700;
            color: #9c1c2b;
            margin-bottom: 16px;
        }

        .error-description {
            font-size: 16.5px;
            color: #475569;
            line-height: 1.75;
            margin-bottom: 32px;
        }

        .url-info {
            background: #fef3f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 16px 20px;
            font-size: 14.5px;
            color: #334155;
            margin-bottom: 32px;
            text-align: left;
            word-break: break-all;
        }

        .url-info span {
            color: #9c1c2b;
            font-weight: 600;
        }

        .btn-group {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }

        .btn {
            padding: 14px 32px;
            border-radius: 10px;
            font-size: 15.5px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.25s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background-color: #9c1c2b;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #b81e2f;
            box-shadow: 0 8px 20px rgba(156, 28, 43, 0.35);
        }

        .btn-secondary {
            background: white;
            color: #9c1c2b;
            border: 2px solid #9c1c2b;
        }

        .btn-secondary:hover {
            background: #fef3f2;
        }

        .divider {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 35px 0;
        }

        .quick-links h3 {
            font-size: 14.5px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1.1px;
            margin-bottom: 16px;
        }

        .links-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(145px, 1fr));
            gap: 12px;
        }

        .link-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 18px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            text-decoration: none;
            color: #1e2937;
            font-weight: 500;
            transition: all 0.25s;
        }

        .link-item:hover {
            background: #9c1c2b;
            color: white;
            border-color: #9c1c2b;
            transform: translateY(-3px);
        }

        footer {
            background: #9c1c2b;
            color: #fcd9d4;
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }

        footer a {
            color: #ffe4c4;
            text-decoration: none;
        }

        @media (max-width: 480px) {
            .error-card { padding: 40px 25px; }
            .error-code { font-size: 78px; }
        }
    </style>
</head>
<body>

<header>
    <span class="logo-icon">📘</span>
    <h1><?php echo $nombre_biblioteca; ?></h1>
</header>

<div class="container">
    <div class="error-card">
        <span class="book-icon">🔍</span>
        <div class="error-code">404</div>
        <div class="error-title">Página no encontrada</div>
        <p class="error-description">
            Lo sentimos, la página que buscas no existe o ha sido movida.<br>
            Verifica la dirección URL o regresa al inicio.
        </p>

        <div class="url-info">
            <strong>URL solicitada:</strong><br>
            <span><?php echo htmlspecialchars($_SERVER['REQUEST_URI'] ?? '/'); ?></span>
        </div>

        <div class="btn-group">
            <a href="index.php" class="btn btn-primary">🏠 Ir al Inicio</a>
            <a href="javascript:history.back()" class="btn btn-secondary">← Regresar</a>
        </div>

        <hr class="divider">

        <div class="quick-links">
            <h3>Accesos Rápidos</h3>
            <div class="links-grid">
                <a href="catalogo.php" class="link-item">📚 Catálogo</a>
                <a href="buscar.php" class="link-item">🔎 Buscar Libros</a>
                <a href="prestamos.php" class="link-item">📋 Mis Préstamos</a>
                <a href="contacto.php" class="link-item">✉️ Contacto</a>
            </div>
        </div>
    </div>
</div>

<footer>
    &copy; <?php echo date('Y'); ?> Colegio Chinchaysuyo — Biblioteca Central<br>
    <a href="index.php">Inicio</a> • <a href="ayuda.php">Ayuda</a>
</footer>

</body>
</html>