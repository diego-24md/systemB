<?= $this->extend('Biblioteca/layout') ?>

<?= $this->section('titulo') ?><?= esc((string)($libro['titulo'] ?? 'Libro')) ?><?= $this->endSection() ?>

<?= $this->section('estilos') ?>
<link rel="stylesheet" href="<?= base_url('css/biblioteca/detalles.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

<?php
/** @var array $libro */
/** @var array $relacionados */
?>

<!-- STAGE -->
<div class="stage">
    <div class="stage-inner">
        <div class="stage-cover">
            <?php if (!empty($libro['portada']) && file_exists('uploads/portadas/' . $libro['portada'])): ?>
                <img class="cover-img"
                    src="<?= base_url('uploads/portadas/' . $libro['portada']) ?>"
                    alt="<?= esc($libro['titulo']) ?>">
            <?php else: ?>
                <div class="cover-placeholder"><i class="fas fa-book"></i></div>
            <?php endif; ?>
        </div>
        <div class="stage-meta">
            <a href="<?= base_url('catalogo') ?>" class="back-link">
                <i class="fas fa-arrow-left"></i> Catálogo
            </a>
            <?php if (!empty($libro['categoria'])): ?>
                <div><span class="cat-pill"><?= esc($libro['categoria']) ?></span></div>
            <?php endif; ?>
            <h1 class="stage-title"><?= esc($libro['titulo']) ?></h1>
            <p class="stage-author">por <span><?= esc($libro['autores'] ?? 'Autor desconocido') ?></span></p>
        </div>
    </div>
</div>

<!-- BODY -->
<div class="body-wrap">

    <!-- COLUMNA PRINCIPAL -->
    <div class="col-main">

        <!-- Disponibilidad + botón -->
        <div class="card">
            <div class="avail-block">
                <div class="avail-left">
                    <div class="avail-ring <?= (int)($libro['disponibles'] ?? 0) > 0 ? 'ok' : 'out' ?>">
                        <i class="fas <?= (int)($libro['disponibles'] ?? 0) > 0 ? 'fa-check' : 'fa-clock' ?>"></i>
                    </div>
                    <div>
                        <?php if ((int)($libro['disponibles'] ?? 0) > 0): ?>
                            <div class="avail-label">Disponible para préstamo</div>
                            <div class="avail-sub"><?= (int)$libro['disponibles'] ?> de <?= (int)$libro['total_ejemplares'] ?> ejemplares libres</div>
                        <?php else: ?>
                            <div class="avail-label">No disponible ahora</div>
                            <div class="avail-sub">Todos los ejemplares están prestados</div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ((int)($libro['total_ejemplares'] ?? 0) === 0): ?>
                    <span class="btn-reservar disabled"><i class="fas fa-ban"></i> Sin ejemplares</span>
                <?php elseif ((int)($libro['disponibles'] ?? 0) > 0): ?>
                    <a href="<?= base_url('biblioteca/reservar/' . ($libro['idrecurso'] ?? '')) ?>" class="btn-reservar">
                        <i class="fas fa-bookmark"></i> Reservar
                    </a>
                <?php else: ?>
                    <span class="btn-reservar disabled"><i class="fas fa-clock"></i> No disponible</span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Información -->
        <div class="card">
            <div class="card-label">Información</div>
            <div class="info-grid">
                <?php if (!empty($libro['autores'])): ?>
                    <div class="info-item">
                        <div class="info-item-icon"><i class="fas fa-feather-alt"></i></div>
                        <div class="info-item-label">Autor(es)</div>
                        <div class="info-item-value"><?= esc($libro['autores']) ?></div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($libro['anio'])): ?>
                    <div class="info-item">
                        <div class="info-item-icon"><i class="fas fa-calendar-alt"></i></div>
                        <div class="info-item-label">Año de publicación</div>
                        <div class="info-item-value"><?= esc($libro['anio']) ?></div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($libro['numpaginas'])): ?>
                    <div class="info-item">
                        <div class="info-item-icon"><i class="fas fa-file-alt"></i></div>
                        <div class="info-item-label">Páginas</div>
                        <div class="info-item-value"><?= esc($libro['numpaginas']) ?></div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($libro['isbn'])): ?>
                    <div class="info-item">
                        <div class="info-item-icon"><i class="fas fa-barcode"></i></div>
                        <div class="info-item-label">ISBN</div>
                        <div class="info-item-value"><?= esc($libro['isbn']) ?></div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($libro['tipo'])): ?>
                    <div class="info-item">
                        <div class="info-item-icon"><i class="fas fa-tag"></i></div>
                        <div class="info-item-label">Tipo de recurso</div>
                        <div class="info-item-value"><?= esc($libro['tipo']) ?></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Descripción -->
        <?php if (!empty($libro['descripcion'])): ?>
            <div class="card">
                <div class="card-label">Descripción</div>
                <p class="desc-text"><?= esc($libro['descripcion']) ?></p>
            </div>
        <?php endif; ?>

        <!-- Favorito -->
        <div class="card">
            <div class="fav-row">
                <div>
                    <div class="fav-label">Agregar a favoritos</div>
                    <div class="fav-sub">Guarda este libro en tu lista personal</div>
                </div>
                <button class="btn-fav" id="btnFav" data-id="<?= (int)($libro['idrecurso'] ?? 0) ?>">
                    <i class="fa-regular fa-heart"></i> Guardar
                </button>
            </div>
        </div>

    </div>

    <!-- COLUMNA LATERAL -->
    <div class="col-side">

        <div class="notice-card">
            <div class="notice-head">
                <i class="fas fa-triangle-exclamation"></i> Antes de reservar
            </div>
            <div class="notice-rule"><i class="fas fa-sun"></i><span>Devuelve el libro el <strong>mismo día</strong>, antes de que termine el horario escolar.</span></div>
            <div class="notice-rule"><i class="fas fa-star"></i><span>Regrésalo en las <strong>mismas condiciones</strong> en que lo recibiste.</span></div>
            <div class="notice-rule"><i class="fas fa-hand"></i><span>Solo puedes tener <strong>un libro prestado</strong> a la vez.</span></div>
            <div class="notice-rule"><i class="fas fa-location-dot"></i><span>Entrega y devolución solo en la <strong>biblioteca del colegio</strong>.</span></div>
        </div>

        <div class="related-title"><i class="fas fa-layer-group"></i> En esta categoría</div>

        <?php if (!empty($relacionados)): ?>
            <div class="related-list">
                <?php foreach ($relacionados as $rel): ?>
                    <a href="<?= base_url('biblioteca/detalle/' . $rel['idrecurso']) ?>" class="rel-item">
                        <div class="rel-thumb">
                            <?php if (!empty($rel['portada']) && file_exists('uploads/portadas/' . $rel['portada'])): ?>
                                <img src="<?= base_url('uploads/portadas/' . $rel['portada']) ?>" alt="<?= esc((string)$rel['titulo']) ?>">
                            <?php else: ?>
                                <i class="fas fa-book"></i>
                            <?php endif; ?>
                        </div>
                        <div class="rel-meta">
                            <div class="rel-titulo"><?= esc((string)$rel['titulo']) ?></div>
                            <div class="rel-autor"><?= esc((string)($rel['autores'] ?? 'Sin autor')) ?></div>
                            <span class="rel-avail"><?= (int)$rel['cantidad_disponible'] ?> disponible(s)</span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="rel-empty">
                <i class="fas fa-book-open" style="display:block;font-size:1.6rem;margin-bottom:8px;color:#c8d5df;"></i>
                No hay más libros en esta categoría
            </div>
        <?php endif; ?>

    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const btnFav = document.getElementById('btnFav');
    const libroId = Number(btnFav.dataset.id);

    fetch("<?= base_url('favoritos/ids') ?>")
        .then(r => r.json())
        .then(ids => {
            if (new Set(ids.map(Number)).has(libroId)) activarFav();
        })
        .catch(() => {});

    btnFav.addEventListener('click', () => {
        fetch("<?= base_url('favoritos/toggle') ?>", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    idrecurso: libroId
                })
            })
            .then(r => r.json())
            .then(d => d.favorito ? activarFav() : desactivarFav())
            .catch(() => alert('Error al actualizar favoritos.'));
    });

    function activarFav() {
        btnFav.classList.add('activo');
        btnFav.innerHTML = '<i class="fa-solid fa-heart"></i> Guardado';
    }

    function desactivarFav() {
        btnFav.classList.remove('activo');
        btnFav.innerHTML = '<i class="fa-regular fa-heart"></i> Guardar';
    }
</script>
<?= $this->endSection() ?>