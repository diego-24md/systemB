<?= $this->extend('Biblioteca/layout') ?>

<?= $this->section('titulo') ?>Catálogo<?= $this->endSection() ?>

<?= $this->section('estilos') ?>
<link rel="stylesheet" href="<?= base_url('css/biblioteca/catalogo.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

<?php
$libros     = $libros ?? [];
$categorias = [];
foreach ($libros as $l) {
    $id  = $l['idcategoria'] ?? null;
    $nom = $l['categoria']   ?? null;
    if ($id && $nom && !isset($categorias[$id])) {
        $categorias[$id] = ['nombre' => $nom, 'count' => 0];
    }
    if ($id) $categorias[$id]['count']++;
}
?>

<!-- Buscador + filtros -->
<div class="search-hero">
    <p class="search-label">Buscar libros</p>
    <div class="search-wrap">
        <i class="fas fa-magnifying-glass"></i>
        <input type="text" id="buscador" placeholder="Buscar por título o autor…">
    </div>

    <?php if (!empty($categorias)): ?>
        <div class="filtros-wrap" id="filtrosWrap">
            <button class="filtro-btn activo" data-cat="todos">
                Todos <span class="count">(<?= count($libros) ?>)</span>
            </button>
            <?php foreach ($categorias as $id => $cat): ?>
                <button class="filtro-btn" data-cat="<?= (int)$id ?>">
                    <?= esc((string)$cat['nombre']) ?>
                    <span class="count">(<?= $cat['count'] ?>)</span>
                </button>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Resultados de búsqueda -->
<div id="resultados" class="books-grid"></div>

<!-- Grid principal -->
<p class="section-label" id="label-todos">Todos los libros</p>
<div class="books-grid" id="grid">
    <?php if (!empty($libros)): ?>
        <?php foreach ($libros as $libro): ?>
            <div class="book-card"
                data-id="<?= (int)($libro['idrecurso'] ?? 0) ?>"
                data-titulo="<?= strtolower(esc((string)($libro['titulo'] ?? ''))) ?>"
                data-autor="<?= strtolower(esc((string)($libro['autores'] ?? ''))) ?>"
                data-portada="<?= esc((string)($libro['portada'] ?? '')) ?>"
                data-autortxt="<?= esc((string)($libro['autores'] ?? 'Sin autor')) ?>"
                data-titulotxt="<?= esc((string)($libro['titulo'] ?? '')) ?>"
                data-categoria="<?= (int)($libro['idcategoria'] ?? 0) ?>">

                <button class="btn-fav-card"
                    data-id="<?= (int)($libro['idrecurso'] ?? 0) ?>"
                    title="Agregar a favoritos">
                    <i class="fa-regular fa-heart"></i>
                </button>

                <div class="book-cover">
                    <?php if (!empty($libro['portada']) && file_exists('uploads/portadas/' . $libro['portada'])): ?>
                        <img src="<?= base_url('uploads/portadas/' . $libro['portada']) ?>"
                            alt="<?= esc((string)($libro['titulo'] ?? '')) ?>">
                    <?php else: ?>
                        <i class="fas fa-book fa-3x"></i>
                    <?php endif; ?>
                </div>

                <div class="book-info">
                    <p class="book-title"><?= esc((string)($libro['titulo'] ?? '')) ?></p>
                    <p class="book-author"><?= esc((string)($libro['autores'] ?? 'Sin autor')) ?></p>
                    <a href="<?= base_url('biblioteca/detalle/' . ($libro['idrecurso'] ?? '')) ?>"
                        class="book-btn">Ver detalle</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // ── Buscador ─────────────────────────────────────
    const input = document.getElementById('buscador');
    const resultados = document.getElementById('resultados');
    const grid = document.getElementById('grid');
    const labelTodos = document.getElementById('label-todos');

    input.addEventListener('input', function() {
        const q = this.value.trim();
        if (!q) {
            resultados.innerHTML = '';
            grid.style.display = '';
            labelTodos.style.display = '';
            return;
        }
        grid.style.display = 'none';
        labelTodos.style.display = 'none';

        fetch("<?= base_url('buscar-libros') ?>?q=" + encodeURIComponent(q))
            .then(r => r.json())
            .then(data => {
                if (!Array.isArray(data)) {
                    resultados.innerHTML = '<p class="no-resultados">Error en el servidor.</p>';
                    return;
                }
                if (!data.length) {
                    resultados.innerHTML = `<p class="no-resultados">Sin resultados para "<strong>${q}</strong>".</p>`;
                    return;
                }
                resultados.innerHTML = data.map(l => `
                    <div class="book-card" data-id="${l.idrecurso}"
                         data-portada="${l.portada ?? ''}"
                         data-autortxt="${l.autores ?? 'Sin autor'}"
                         data-titulotxt="${l.titulo}">
                        <button class="btn-fav-card ${favIds.has(Number(l.idrecurso)) ? 'activo' : ''}" data-id="${l.idrecurso}">
                            <i class="fa-${favIds.has(Number(l.idrecurso)) ? 'solid' : 'regular'} fa-heart"></i>
                        </button>
                        <div class="book-cover">
                            ${l.portada
                                ? `<img src="/uploads/portadas/${l.portada}" alt="${l.titulo}">`
                                : `<i class="fas fa-book fa-3x"></i>`}
                        </div>
                        <div class="book-info">
                            <p class="book-title">${l.titulo}</p>
                            <p class="book-author">${l.autores ?? 'Sin autor'}</p>
                            <a href="/biblioteca/detalle/${l.idrecurso}" class="book-btn">Ver detalle</a>
                        </div>
                    </div>
                `).join('');
                bindFavCards(resultados);
            })
            .catch(() => {
                resultados.innerHTML = '<p class="no-resultados">Error de conexión.</p>';
            });
    }, true);

    // ── Favoritos ─────────────────────────────────────
    let favIds = new Set();
    let favData = {};

    const favBadge = document.getElementById('favBadge');
    const drawerBody = document.getElementById('drawerBody');
    const drawerVacio = document.getElementById('drawerVacio');
    const drawerCount = document.getElementById('drawer-count');

    fetch("<?= base_url('favoritos/ids') ?>")
        .then(r => r.json())
        .then(ids => {
            favIds = new Set(ids.map(Number));
            marcarCorazones();
            actualizarBadge();
            renderDrawer();
        }).catch(() => {});

    function marcarCorazones() {
        document.querySelectorAll('.btn-fav-card').forEach(btn => {
            favIds.has(Number(btn.dataset.id)) ? activarBtn(btn) : desactivarBtn(btn);
        });
    }

    function activarBtn(btn) {
        btn.classList.add('activo');
        btn.querySelector('i').className = 'fa-solid fa-heart';
        btn.title = 'Quitar de favoritos';
    }

    function desactivarBtn(btn) {
        btn.classList.remove('activo');
        btn.querySelector('i').className = 'fa-regular fa-heart';
        btn.title = 'Agregar a favoritos';
    }

    function actualizarBadge() {
        const n = favIds.size;
        if (n > 0) {
            favBadge.textContent = n;
            favBadge.style.display = 'flex';
        } else {
            favBadge.style.display = 'none';
        }
        drawerCount.textContent = n > 0 ? `(${n})` : '';
    }

    function renderDrawer() {
        Array.from(drawerBody.children).forEach(el => {
            if (el.id !== 'drawerVacio') el.remove();
        });
        if (!favIds.size) {
            drawerVacio.style.display = 'flex';
            return;
        }
        drawerVacio.style.display = 'none';
        favIds.forEach(id => {
            let d = favData[id];
            if (!d) {
                const card = document.querySelector(`.book-card[data-id="${id}"]`);
                if (card) {
                    d = {
                        titulo: card.dataset.titulotxt || '—',
                        autor: card.dataset.autortxt || 'Sin autor',
                        portada: card.dataset.portada || '',
                        id
                    };
                    favData[id] = d;
                }
            }
            if (!d) return;
            const item = document.createElement('div');
            item.className = 'fav-item';
            item.dataset.id = id;
            item.innerHTML = `
                <div class="fav-thumb">
                    ${d.portada
                        ? `<img src="/uploads/portadas/${d.portada}" alt="${d.titulo}">`
                        : `<i class="fas fa-book"></i>`}
                </div>
                <div class="fav-info">
                    <div class="fav-titulo">${d.titulo}</div>
                    <div class="fav-autor">${d.autor}</div>
                    <a href="/biblioteca/detalle/${id}" class="fav-ver">Ver detalle</a>
                </div>
                <button class="fav-remove" data-id="${id}" title="Quitar">
                    <i class="fas fa-xmark"></i>
                </button>
            `;
            item.querySelector('.fav-remove').addEventListener('click', () => toggleFav(id));
            drawerBody.appendChild(item);
        });
    }

    function bindFavCards(container) {
        container.querySelectorAll('.btn-fav-card').forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();
                e.stopPropagation();
                toggleFav(Number(btn.dataset.id));
            });
        });
    }

    function toggleFav(idrecurso) {
        fetch("<?= base_url('favoritos/toggle') ?>", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    idrecurso
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.favorito) favIds.add(idrecurso);
                else {
                    favIds.delete(idrecurso);
                    delete favData[idrecurso];
                }
                marcarCorazones();
                actualizarBadge();
                renderDrawer();
            })
            .catch(() => alert('Error al actualizar favoritos.'));
    }

    bindFavCards(grid);

    // ── Filtros por categoría ─────────────────────────
    let filtroActual = 'todos';
    document.querySelectorAll('.filtro-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if (input.value.trim()) {
                input.value = '';
                resultados.innerHTML = '';
                grid.style.display = '';
                labelTodos.style.display = '';
            }
            filtroActual = btn.dataset.cat;
            document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('activo'));
            btn.classList.add('activo');
            grid.querySelectorAll('.book-card').forEach(card => {
                card.style.display = (filtroActual === 'todos' || card.dataset.categoria === filtroActual) ?
                    '' : 'none';
            });
        });
    });
</script>
<?= $this->endSection() ?>