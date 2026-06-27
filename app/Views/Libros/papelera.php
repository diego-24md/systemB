<?php

/**
 * @var string $header
 * @var string $footer
 * @var array $libros
 */
?>
<?= $header ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="<?= base_url('css/libros/index.css') ?>">

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <div class="page-title">Papelera de Recursos</div>
            <div class="page-subtitle">Recursos eliminados — puedes restaurarlos o eliminarlos definitivamente</div>
        </div>
        <a href="<?= base_url('libros') ?>" class="btn-agregar">
            <i class="fas fa-arrow-left me-2"></i> Volver al catálogo
        </a>
    </div>

    <!-- Mensajes -->
    <?php if (session()->getFlashdata('success')): ?>
        <div id="success-alert" class="alert"
            style="background:#f0fdf4;color:#166534;border:1px solid #86efac;border-radius:12px;padding:14px 20px;margin-bottom:20px;display:flex;align-items:center;gap:12px;">
            <i class="fas fa-check-circle" style="font-size:1.3rem;color:#4ade80;"></i>
            <span style="font-size:1rem;font-weight:500;"><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" style="background:#fef2f2;color:#dc2626;">
            <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Buscador -->
    <div class="buscador-wrapper mb-4" style="max-width: 600px;">
        <i class="fas fa-search"></i>
        <input type="text" id="buscador-papelera" placeholder="Buscar por título o autor">
    </div>

    <div class="panel">
        <div class="panel-label">Recursos eliminados</div>

        <?php if (!empty($libros)): ?>
            <div class="row g-3" id="grid-papelera">
                <?php foreach ($libros as $libro): ?>
                    <div class="col-md-6 col-lg-4 col-xl-3 libro-col"
                        data-titulo="<?= strtolower(esc((string)$libro['titulo'])) ?>"
                        data-autor="<?= strtolower(esc((string)($libro['autores'] ?? ''))) ?>"
                        data-isbn="<?= strtolower(esc((string)($libro['isbn'] ?? ''))) ?>">
                        <div class="book-card" style="opacity: 0.82;">

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

                                <!-- Badge eliminado -->
                                <div style="position:absolute;top:10px;right:10px;background:#fee2e2;color:#dc2626;font-size:0.7rem;font-weight:700;padding:3px 8px;border-radius:20px;letter-spacing:0.05em;">
                                    ELIMINADO
                                </div>
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
                                <!-- Restaurar -->
                                <form id="form-restaurar-<?= $libro['idrecurso'] ?>"
                                    action="<?= base_url('libros/restaurar/' . $libro['idrecurso']) ?>"
                                    method="GET" class="m-0">
                                    <button type="button"
                                        class="btn-accion restaurar"
                                        onclick="confirmarRestaurar(<?= $libro['idrecurso'] ?>, '<?= esc((string)$libro['titulo']) ?>')">
                                        <i class="fas fa-trash-restore"></i> Restaurar
                                    </button>
                                </form>

                                <!-- Eliminar definitivo -->
                                <form id="form-definitivo-<?= $libro['idrecurso'] ?>"
                                    action="<?= base_url('libros/eliminar-definitivo/' . $libro['idrecurso']) ?>"
                                    method="POST" class="m-0">
                                    <?= csrf_field() ?>
                                    <button type="button"
                                        class="btn-accion eliminar"
                                        onclick="confirmarDefinitivo(<?= $libro['idrecurso'] ?>, '<?= esc((string)$libro['titulo']) ?>')">
                                        <i class="fas fa-times-circle"></i> Eliminar
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="no-resultados" id="no-resultados">
                <i class="fas fa-search"></i>
                No se encontraron recursos con ese criterio
            </div>

        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-trash-alt"></i>
                <p>La papelera está vacía</p>
            </div>
        <?php endif; ?>
    </div>

</div>

<?= $footer ?>

<script>
    // Buscador
    document.getElementById('buscador-papelera').addEventListener('input', function() {
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

    // Confirmar restaurar
    function confirmarRestaurar(id, titulo) {
        Swal.fire({
            title: '¿Restaurar libro?',
            text: `"${titulo}" volverá al catálogo.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2e7d52',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Sí, restaurar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`form-restaurar-${id}`).submit();
            }
        });
    }

    // Confirmar eliminar definitivo
    function confirmarDefinitivo(id, titulo) {
        Swal.fire({
            title: '¿Eliminar definitivamente?',
            text: `"${titulo}" se borrará para siempre y no podrá recuperarse.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Sí, eliminar para siempre',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`form-definitivo-${id}`).submit();
            }
        });
    }

    // Auto ocultar alerta de éxito
    setTimeout(() => {
        const alerta = document.getElementById('success-alert');
        if (alerta) {
            alerta.style.transition = "opacity 0.5s ease";
            alerta.style.opacity = "0";
            setTimeout(() => alerta.remove(), 500);
        }
    }, 5000);
</script>