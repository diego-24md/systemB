<?= $header ?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Lista de Libros</h4>
        <a href="<?= base_url('libros/registrar') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Agregar Libro
        </a>
    </div>

    <div class="row">

        <?php if (!empty($libros)): ?>
            <?php foreach ($libros as $libro): ?>
                <div class="col-md-6 col-lg-4 col-xl-3 mb-4">

                    <div class="book-card h-100 bg-white border border-light rounded-3 overflow-hidden shadow-sm">

                        <!-- Portada -->
                        <div class="cover-area position-relative"
                            style="height: 280px; background-color: #f8fafc; padding: 12px; display: flex; align-items: center; justify-content: center; border-bottom: 1px solid #e2e8f0;">

                            <?php if (!empty($libro['portada']) && file_exists('uploads/portadas/' . $libro['portada'])): ?>
                                <img src="<?= base_url('uploads/portadas/' . $libro['portada']) ?>"
                                    class="w-100 h-100"
                                    style="object-fit: contain; max-height: 100%;"
                                    alt="<?= esc($libro['titulo']) ?>">
                            <?php else: ?>
                                <div class="h-100 d-flex flex-column align-items-center justify-content-center text-center p-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="none"
                                        viewBox="0 0 24 24" stroke="#cbd5e1" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18 9.246 18 10.832 18.477 12 19.253zm0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18 14.754 18 13.168 18.477 12 19.253z" />
                                    </svg>
                                    <p class="text-muted small mt-3 mb-0">Sin portada</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Información -->
                        <div class="p-4">
                            <h6 class="fw-bold text-dark mb-2 line-clamp-2"
                                style="font-size: 1.05rem; line-height: 1.35;">
                                <?= esc($libro['titulo']) ?>
                            </h6>

                            <!-- ✅ Autores -->
                            <p class="text-muted small mb-3" style="font-size: 0.85rem;">
                                <i class="fas fa-user-edit me-1"></i><?= esc($libro['autores'] ?? '—') ?>
                            </p>

                            <div class="small text-muted">
                                <div class="d-flex mb-1">
                                    <span class="fw-semibold text-primary" style="width: 52px;">ISBN</span>
                                    <span>: <?= esc($libro['isbn'] ?? '—') ?></span>
                                </div>
                                <div class="d-flex mb-1">
                                    <span class="fw-semibold text-primary" style="width: 52px;">Año</span>
                                    <span>: <?= esc($libro['anio'] ?? '—') ?></span>
                                </div>
                                <div class="d-flex">
                                    <span class="fw-semibold text-primary" style="width: 52px;">Págs.</span>
                                    <span>: <?= esc($libro['numpaginas'] ?? '—') ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="border-top p-3 bg-light d-flex justify-content-between align-items-center">
                            <a href="<?= base_url('libros/editar/' . $libro['idrecurso']) ?>"
                                class="btn btn-sm btn-outline-primary d-flex align-items-center gap-2">
                                <i class="fas fa-edit"></i> Editar
                            </a>

                            <!-- ✅ Eliminar como formulario POST -->
                            <form action="<?= base_url('libros/eliminar/' . $libro['idrecurso']) ?>"
                                method="POST"
                                onsubmit="return confirm('¿Estás seguro de eliminar este libro?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center gap-2">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning text-center py-4">
                    <i class="fas fa-book-open fa-2x mb-3 text-muted"></i>
                    <h5>No hay libros registrados aún</h5>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<style>
    .book-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .book-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12) !important;
        border-color: #cbd5e1;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .cover-area img {
        transition: transform 0.4s ease;
    }

    .book-card:hover .cover-area img {
        transform: scale(1.04);
    }
</style>

<?= $footer ?>