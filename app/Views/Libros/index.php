<?php

/**
 * @var string $header
 * @var string $footer
 * @var array{
 *   titulo: string,
 *   autores: string,
 *   portada: string|null,
 *   isbn: string|null,
 *   anio: string|null,
 *   numpaginas: string|null
 * } $libro
 */
?>
<?= $header ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="<?= base_url('css/libros/index.css') ?>">

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <div class="page-title">Gestión de Libros</div>
            <div class="page-subtitle">Catálogo de recursos bibliográficos</div>
        </div>
        <a href="<?= base_url('libros/registrar') ?>" class="btn-agregar">
            <i class="fas fa-plus me-2"></i> Agregar Libro
        </a>
    </div>

    <!-- Buscador fuera del panel -->
    <div class="buscador-wrapper mb-4" style="max-width: 600px;">
        <i class="fas fa-search"></i>
        <input type="text" id="buscador-libros" placeholder="Buscar por título, autor o ISBN...">
    </div>

    <div class="panel">
        <div class="panel-label">Catálogo</div>

        <?php if (!empty($libros)): ?>
            <div class="row g-3" id="grid-libros">
                <?php foreach ($libros as $libro): ?>
                    <div class="col-md-6 col-lg-4 col-xl-3 libro-col"
                        data-titulo="<?= strtolower(esc((string)$libro['titulo'])) ?>"
                        data-autor="<?= strtolower(esc((string)($libro['autores'] ?? ''))) ?>"
                        data-isbn="<?= strtolower(esc((string)($libro['isbn'] ?? ''))) ?>">
                        <div class="book-card">

                            <div class="cover-area">
                                <?php if (!empty($libro['portada']) && file_exists('uploads/portadas/' . $libro['portada'])): ?>
                                    <img src="<?= base_url('uploads/portadas/' . $libro['portada']) ?>"
                                        alt="<?= esc((string)$libro['titulo']) ?>">
                                <?php else: ?>
                                    <div class="text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="none"
                                            viewBox="0 0 24 24" stroke="#cbd5e1" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18 9.246 18 10.832 18.477 12 19.253zm0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18 14.754 18 13.168 18.477 12 19.253z" />
                                        </svg>
                                        <p class="text-muted small mt-2 mb-0" style="font-size:0.78rem;">Sin portada</p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="book-info">
                                <div class="book-title"><?= esc((string)$libro['titulo']) ?></div>
                                <div class="book-author">
                                    <i class="fas fa-user-edit me-1"></i><?= esc((string)($libro['autores'] ?? '—')) ?>
                                </div>
                                <div class="book-meta">
                                    <div class="mb-1"><span class="label">Categoría:</span> <?= esc((string)($libro['categoria'] ?? '—')) ?></div>
                                    <div class="mb-1"><span class="label">Año:</span> <?= esc((string)($libro['anio'] ?? '—')) ?></div>
                                    <div><span class="label">Páginas:</span> <?= esc((string)($libro['numpaginas'] ?? '—')) ?></div>
                                </div>
                            </div>

                            <div class="book-footer">
                                <a href="<?= base_url('libros/editar/' . $libro['idrecurso']) ?>" class="btn-accion editar">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form id="form-eliminar-<?= $libro['idrecurso'] ?>"
                                    action="<?= base_url('libros/eliminar/' . $libro['idrecurso']) ?>"
                                    method="POST">
                                    <?= csrf_field() ?>
                                    <button type="button"
                                        class="btn-accion eliminar"
                                        onclick="confirmarEliminar(<?= $libro['idrecurso'] ?>, '<?= esc((string)$libro['titulo']) ?>')">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="no-resultados" id="no-resultados">
                <i class="fas fa-search"></i>
                No se encontraron libros con ese criterio
            </div>

        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-book-open"></i>
                <p>No hay libros registrados aún</p>
            </div>
        <?php endif; ?>
    </div>

</div>

<?= $footer ?>

<script>
    document.getElementById('buscador-libros').addEventListener('input', function() {
        const q = this.value.toLowerCase();
        const cols = document.querySelectorAll('.libro-col');
        let visibles = 0;

        cols.forEach(col => {
            const titulo = col.dataset.titulo ?? '';
            const autor = col.dataset.autor ?? '';
            const isbn = col.dataset.isbn ?? '';
            const match = titulo.includes(q) || autor.includes(q) || isbn.includes(q);
            col.style.display = match ? '' : 'none';
            if (match) visibles++;
        });

        document.getElementById('no-resultados').style.display = visibles === 0 ? 'block' : 'none';
    });

    function confirmarEliminar(id, titulo) {
        Swal.fire({
            title: '¿Eliminar libro?',
            text: `"${titulo}" será eliminado permanentemente.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`form-eliminar-${id}`).submit();
            }
        });
    }
</script>