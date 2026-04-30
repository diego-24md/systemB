<?= $header ?>

<style>
    body {
        background-color: #f4f6f9;
    }

    .page-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 2px;
    }

    .page-subtitle {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .panel {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 24px;
        margin-bottom: 20px;
    }

    .panel-label {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        color: #94a3b8;
        text-transform: uppercase;
        margin-bottom: 20px;
    }

    /* Tarjeta libro */
    .book-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        height: 100%;
    }

    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.10);
        border-color: #cbd5e1;
    }

    .cover-area {
        height: 240px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px;
    }

    .cover-area img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .book-card:hover .cover-area img {
        transform: scale(1.04);
    }

    .book-info {
        padding: 16px;
    }

    .book-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1e293b;
        line-height: 1.35;
        margin-bottom: 6px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .book-author {
        font-size: 0.8rem;
        color: #94a3b8;
        margin-bottom: 12px;
    }

    .book-meta {
        font-size: 0.78rem;
        color: #64748b;
    }

    .book-meta span.label {
        font-weight: 600;
        color: #1e3a5f;
        display: inline-block;
        width: 46px;
    }

    .book-footer {
        padding: 12px 16px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
    }

    .btn-agregar {
        background-color: #2e7d52;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 9px 18px;
        font-size: 0.88rem;
        text-decoration: none;
    }

    .btn-agregar:hover {
        background-color: #256743;
        color: #fff;
    }

    .btn-accion {
        border: none;
        background: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.8rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
    }

    .btn-accion.editar {
        color: #d97706;
        background-color: #fef3c7;
    }

    .btn-accion.editar:hover {
        background-color: #fde68a;
    }

    .btn-accion.eliminar {
        color: #dc2626;
        background-color: #fee2e2;
    }

    .btn-accion.eliminar:hover {
        background-color: #fecaca;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 12px;
        display: block;
    }

    .empty-state p {
        font-size: 0.88rem;
        margin: 0;
    }
</style>

<div class="container-fluid px-4 py-4">

    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="page-title">Gestión de Libros</div>
            <div class="page-subtitle">Catálogo de recursos bibliográficos</div>
        </div>
        <a href="<?= base_url('libros/registrar') ?>" class="btn-agregar">
            <i class="fas fa-plus me-2"></i> Agregar Libro
        </a>
    </div>

    <!-- Grid de libros -->
    <div class="panel">
        <div class="panel-label">Catálogo</div>

        <?php if (!empty($libros)): ?>
            <div class="row g-3">
                <?php foreach ($libros as $libro): ?>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="book-card">

                            <!-- Portada -->
                            <div class="cover-area">
                                <?php if (!empty($libro['portada']) && file_exists('uploads/portadas/' . $libro['portada'])): ?>
                                    <img src="<?= base_url('uploads/portadas/' . $libro['portada']) ?>"
                                        alt="<?= esc($libro['titulo']) ?>">
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

                            <!-- Info -->
                            <div class="book-info">
                                <div class="book-title"><?= esc($libro['titulo']) ?></div>
                                <div class="book-author">
                                    <i class="fas fa-user-edit me-1"></i><?= esc($libro['autores'] ?? '—') ?>
                                </div>
                                <div class="book-meta">
                                    <div class="mb-1"><span class="label">ISBN</span>: <?= esc($libro['isbn'] ?? '—') ?></div>
                                    <div class="mb-1"><span class="label">Año</span>: <?= esc($libro['anio'] ?? '—') ?></div>
                                    <div><span class="label">Págs.</span>: <?= esc($libro['numpaginas'] ?? '—') ?></div>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="book-footer">
                                <a href="<?= base_url('libros/editar/' . $libro['idrecurso']) ?>" class="btn-accion editar">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="<?= base_url('libros/eliminar/' . $libro['idrecurso']) ?>" method="POST"
                                    onsubmit="return confirm('¿Estás seguro de eliminar este libro?')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn-accion eliminar">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
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