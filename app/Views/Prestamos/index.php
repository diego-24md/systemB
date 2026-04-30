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

    .form-group label {
        font-size: 0.82rem;
        color: #64748b;
        margin-bottom: 5px;
        display: block;
    }

    .form-control,
    .form-select {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.88rem;
        padding: 10px 14px;
        color: #475569;
        width: 100%;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #1e3a5f;
        box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.08);
        outline: none;
    }

    .btn-guardar {
        background-color: #1e3a5f;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 24px;
        font-size: 0.88rem;
        cursor: pointer;
    }

    .btn-guardar:hover {
        background-color: #16304f;
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

    .num-col {
        color: #cbd5e1;
        font-size: 0.82rem;
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

    .estado-activo {
        background-color: #fef3c7;
        color: #d97706;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.78rem;
    }

    .estado-devuelto {
        background-color: #f0fdf4;
        color: #15803d;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.78rem;
    }

    .estado-vencido {
        background-color: #fef2f2;
        color: #dc2626;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.78rem;
    }
</style>

<div class="container-fluid px-4 py-4">

    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="page-title">Gestión de Préstamos</div>
            <div class="page-subtitle">Registro y seguimiento de préstamos de libros</div>
        </div>
    </div>

    <!-- Mensajes -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-dismissible fade show rounded-3 border-0 mb-3" style="background:#f0fdf4;color:#15803d;">
            <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-dismissible fade show rounded-3 border-0 mb-3" style="background:#fef2f2;color:#dc2626;">
            <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Formulario -->
    <div class="panel">
        <div class="panel-label">Registrar Préstamo</div>
        <form action="<?= base_url('prestamos/guardar') ?>" method="post">
            <?= csrf_field() ?>
            <div class="row g-3">

                <div class="col-md-3 form-group">
                    <label>DNI Alumna</label>
                    <input type="text" name="alumna_id" class="form-control" placeholder="Ej: 72894561" required>
                </div>

                <div class="col-md-3 form-group">
                    <label>Nombre del Libro</label>
                    <input type="text" name="libro_id" class="form-control" placeholder="Ej: Matemática 3°" required>
                </div>

                <div class="col-md-2 form-group">
                    <label>Fecha Préstamo</label>
                    <input type="date" name="fecha_prestamo" class="form-control" required>
                </div>

                <div class="col-md-2 form-group">
                    <label>Fecha Devolución</label>
                    <input type="date" name="fecha_devolucion" class="form-control" required>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn-guardar w-100">
                        <i class="fas fa-save me-2"></i> Guardar
                    </button>
                </div>

            </div>
        </form>
    </div>

    <!-- Tabla -->
    <div class="panel">
        <div class="panel-label">Listado de Préstamos</div>

        <table class="table mb-0">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Alumna</th>
                    <th>Libro</th>
                    <th>F. Préstamo</th>
                    <th>F. Devolución</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($prestamos)): ?>
                    <?php foreach ($prestamos as $i => $p): ?>
                        <tr>
                            <td class="num-col"><?= $i + 1 ?></td>
                            <td><?= esc($p['alumna_id']) ?></td>
                            <td><?= esc($p['libro_id']) ?></td>
                            <td><?= esc($p['fecha_prestamo']) ?></td>
                            <td><?= esc($p['fecha_devolucion']) ?></td>
                            <td>
                                <?php
                                $estado = strtolower($p['estado'] ?? '');
                                $clase = match ($estado) {
                                    'devuelto' => 'estado-devuelto',
                                    'vencido' => 'estado-vencido',
                                    default => 'estado-activo',
                                };
                                ?>
                                <span class="<?= $clase ?>"><?= esc(ucfirst($p['estado'])) ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-book-open"></i>
                                <p>No hay préstamos registrados</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?= $footer ?>