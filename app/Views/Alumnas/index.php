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
        margin-bottom: 16px;
    }

    .btn-buscar {
        background-color: #1e3a5f;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-size: 0.9rem;
        width: 100%;
        height: 100%;
    }

    .btn-buscar:hover {
        background-color: #16304f;
        color: #fff;
    }

    .btn-importar {
        background-color: #2e7d52;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 9px 18px;
        font-size: 0.88rem;
    }

    .btn-importar:hover {
        background-color: #256743;
        color: #fff;
    }

    .table thead th {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.07em;
        color: #94a3b8;
        text-transform: uppercase;
        border-bottom: 1px solid #e2e8f0;
        background: #fff;
        padding: 12px 16px;
    }

    .table tbody td {
        padding: 13px 16px;
        font-size: 0.88rem;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table tbody tr:hover {
        background-color: #f8fafc;
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

    .badge-grado {
        background-color: #e0f2fe;
        color: #0369a1;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.78rem;
    }

    .badge-seccion {
        background-color: #f0fdf4;
        color: #15803d;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.78rem;
    }

    .num-col {
        color: #cbd5e1;
        font-size: 0.82rem;
    }

    .btn-accion {
        border: none;
        background: none;
        padding: 5px 8px;
        border-radius: 6px;
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

    .form-select {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.88rem;
        padding: 10px 14px;
        color: #475569;
    }

    .total-badge {
        font-size: 0.82rem;
        color: #475569;
        background: #f1f5f9;
        border-radius: 20px;
        padding: 4px 12px;
    }
</style>

<div class="container-fluid px-4 py-4">

    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="page-title">Gestión de alumnas</div>
            <div class="page-subtitle">Consulta e importación por grado y sección</div>
        </div>
        <a href="<?= base_url('alumnas/importar') ?>" class="btn btn-importar">
            <i class="fas fa-file-excel me-2"></i> Importar Excel
        </a>
    </div>

    <!-- Mensajes -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0"
            style="background:#f0fdf4;color:#15803d;">
            <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0"
            style="background:#fef2f2;color:#dc2626;">
            <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Filtros -->
    <div class="panel">
        <div class="panel-label">Filtrar alumnas</div>
        <form method="GET" action="<?= base_url('alumnas') ?>">
            <div class="row g-3 align-items-end">

                <div class="col-md-3">
                    <label class="form-label text-muted" style="font-size:0.82rem;">Grado</label>
                    <select name="grado" class="form-select">
                        <option value="">Seleccione grado</option>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <option value="<?= $i ?>" <?= ($grado ?? '') == $i ? 'selected' : '' ?>>
                                <?= $i ?>° Secundaria
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label text-muted" style="font-size:0.82rem;">Sección</label>
                    <select name="seccion" class="form-select">
                        <option value="">Seleccione sección</option>
                        <option value="A" <?= ($seccion ?? '') == 'A' ? 'selected' : '' ?>>A</option>
                        <option value="B" <?= ($seccion ?? '') == 'B' ? 'selected' : '' ?>>B</option>
                        <option value="C" <?= ($seccion ?? '') == 'C' ? 'selected' : '' ?>>C</option>
                        <option value="D" <?= ($seccion ?? '') == 'D' ? 'selected' : '' ?>>D</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label text-muted" style="font-size:0.82rem;">Buscar por nombre o DNI</label>
                    <input type="text" name="buscar" class="form-select" placeholder="Ej: María o 72894561"
                        value="<?= esc($buscar ?? '') ?>">
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-buscar">
                        <i class="fas fa-search me-2"></i> Buscar alumnas
                    </button>
                </div>

                <div class="col-md-1">
                    <a href="<?= base_url('alumnas') ?>" class="btn w-100"
                        style="border:1px solid #e2e8f0;color:#64748b;border-radius:8px;padding:10px;">
                        <i class="fas fa-eraser"></i>
                    </a>
                </div>

            </div>
        </form>
    </div>

    <!-- Resultados -->
    <div class="panel">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="panel-label mb-0">Resultados</div>
            <?php if (!empty($alumnas)): ?>
                <span class="total-badge">
                    <?= esc($total ?? 0) ?> alumna<?= ($total ?? 0) != 1 ? 's' : '' ?>
                    <?= !empty($grado) ? ' · ' . $grado . '°' : '' ?>
                    <?= !empty($seccion) ? ' ' . $seccion : '' ?>
                </span>
            <?php endif; ?>
        </div>

        <table class="table mb-0">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>DNI</th>
                    <th>Nombre completo</th>
                    <th>Grado</th>
                    <th>Sección</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($alumnas)): ?>
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-user-friends"></i>
                                <p>Selecciona un grado y sección para ver las alumnas</p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($alumnas as $i => $alumna): ?>
                        <tr>
                            <td class="num-col"><?= $i + 1 ?></td>
                            <td><?= esc($alumna['dni']) ?></td>
                            <td><?= esc($alumna['apellidos'] . ', ' . $alumna['nombres']) ?></td>
                            <td><span class="badge-grado"><?= esc($alumna['grado']) ?>°</span></td>
                            <td><span class="badge-seccion"><?= esc($alumna['seccion']) ?></span></td>
                            <td class="text-center">
                                <a href="<?= base_url('alumnas/editar/' . $alumna['id']) ?>" class="btn-accion editar me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="<?= base_url('alumnas/eliminar/' . $alumna['id']) ?>"
                                    class="d-inline" onsubmit="return confirmarEliminar()">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn-accion eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Paginación -->
        <?php if (!empty($alumnas)): ?>
            <div class="mt-3 d-flex justify-content-end">
                <?= $pager->links() ?? '' ?>
            </div>
        <?php endif; ?>

    </div>

</div>

<script>
    function confirmarEliminar() {
        return confirm('¿Estás seguro de eliminar esta alumna?');
    }
</script>

<?= $footer ?>