<?php

/** @var array $libro */
/** @var array $relacionados */
?>
<?= $this->extend('Biblioteca/layout') ?>

<?= $this->section('titulo') ?>Reservar — <?= esc($libro['titulo']) ?><?= $this->endSection() ?>

<?= $this->section('estilos') ?>
<link rel="stylesheet" href="<?= base_url('css/biblioteca/reservar.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

<?php
/** @var array $libro */
?>

<div class="page">

    <a href="<?= base_url('biblioteca/detalle/' . $libro['idrecurso']) ?>" class="back-link">
        <i class="fas fa-arrow-left"></i> Volver al detalle
    </a>

    <!-- Flash de error -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="flash error">
            <i class="fas fa-circle-exclamation"></i>
            <?= esc((string)session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <!-- Resumen del libro -->
    <div class="libro-card">
        <div class="libro-cover">
            <?php if (!empty($libro['portada']) && file_exists('uploads/portadas/' . $libro['portada'])): ?>
                <img src="<?= base_url('uploads/portadas/' . $libro['portada']) ?>" alt="<?= esc($libro['titulo']) ?>">
            <?php else: ?>
                <i class="fas fa-book"></i>
            <?php endif; ?>
        </div>
        <div class="libro-meta">
            <div class="libro-titulo"><?= esc($libro['titulo']) ?></div>
            <div class="libro-autor">por <?= esc($libro['autores']) ?></div>
            <span class="libro-disp">
                <i class="fas fa-check-circle"></i>
                <?= $libro['disponibles'] ?> de <?= $libro['total_ejemplares'] ?> disponibles
            </span>
        </div>
    </div>

    <!-- Aviso -->
    <div class="aviso">
        <div class="aviso-head"><i class="fas fa-triangle-exclamation"></i> Antes de confirmar</div>
        <div class="aviso-item"><i class="fas fa-sun"></i> El libro debe devolverse el <strong>mismo día</strong> antes del fin del horario escolar.</div>
        <div class="aviso-item"><i class="fas fa-hand"></i> Solo puedes tener <strong>un libro prestado</strong> a la vez.</div>
        <div class="aviso-item"><i class="fas fa-location-dot"></i> Recoge y devuelve el libro en la <strong>biblioteca del colegio</strong>.</div>
    </div>

    <!-- Confirmación -->
    <div class="form-card">
        <div class="form-title">Confirmación de reserva</div>

        <div class="confirm-row">
            <div class="confirm-icon"><i class="fas fa-user"></i></div>
            <div>
                <div class="confirm-label">Alumna</div>
                <div class="confirm-value"><?= htmlspecialchars((string)session()->get('alumna_nombre')) ?></div>
            </div>
        </div>

        <div class="confirm-row">
            <div class="confirm-icon"><i class="fas fa-book"></i></div>
            <div>
                <div class="confirm-label">Libro</div>
                <div class="confirm-value"><?= esc($libro['titulo']) ?></div>
            </div>
        </div>

        <div class="confirm-row">
            <div class="confirm-icon"><i class="fas fa-calendar-day"></i></div>
            <div>
                <div class="confirm-label">Fecha de préstamo</div>
                <div class="confirm-value"><?= date('d/m/Y') ?></div>
            </div>
        </div>

        <div class="confirm-row">
            <div class="confirm-icon"><i class="fas fa-star"></i></div>
            <div>
                <div class="confirm-label">Condición del libro</div>
                <div class="confirm-value">Bueno</div>
            </div>
        </div>
    </div>

    <!-- Formulario POST -->
    <form action="<?= base_url('biblioteca/procesarReserva') ?>" method="post">
        <?= csrf_field() ?> <!-- ← debe estar aquí -->
        <input type="hidden" name="idactivo" value="<?= (int)$libro['idactivo'] ?>">
        <input type="hidden" name="idrecurso" value="<?= (int)$libro['idrecurso'] ?>">
        <button type="submit" class="btn-confirmar">
            <i class="fas fa-bookmark"></i> Confirmar reserva
        </button>
    </form>

    <a href="<?= base_url('biblioteca/detalle/' . $libro['idrecurso']) ?>" class="btn-cancelar">
        <i class="fas fa-xmark"></i> Cancelar
    </a>

</div>

<?= $this->endSection() ?>