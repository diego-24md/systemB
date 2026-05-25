<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('titulo') ?> — Biblioteca Chinchaysuyo</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Estilos -->
    <link rel="stylesheet" href="<?= base_url('css/biblioteca/catalogo.css') ?>">

    <!-- Estilos específicos de cada vista -->
    <?= $this->renderSection('estilos') ?>
</head>

<body>

    <?= $this->include('Biblioteca/partials/header') ?>

    <main class="main-content">
        <?= $this->renderSection('contenido') ?>
    </main>

    <?= $this->include('Biblioteca/partials/footer') ?>

    <?= $this->renderSection('scripts') ?>

</body>

</html>