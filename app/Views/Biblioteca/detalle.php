<?= $header ?? '' ?>

<div class="container-fluid">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('libros') ?>">Buscador</a>
            </li>
            <li class="breadcrumb-item active">Detalle del libro</li>
        </ol>
    </nav>

    <?php if (!$libro): ?>
        <div class="alert alert-danger">El libro no fue encontrado.</div>
    <?php else: ?>

    <div class="row">

        <!-- Columna izquierda: Portada -->
        <div class="col-md-3 text-center mb-4">
            <?php if ($libro->portada): ?>
                <img src="<?= base_url('uploads/portadas/' . $libro->portada) ?>"
                     alt="Portada"
                     class="img-fluid rounded shadow"
                     style="max-height: 350px; object-fit: cover;">
            <?php else: ?>
                <div class="rounded shadow d-flex align-items-center justify-content-center bg-light"
                     style="height:300px;">
                    <i class="fas fa-book fa-5x text-muted"></i>
                </div>
            <?php endif; ?>

            <!-- Disponibilidad -->
            <div class="mt-3">
                <?php if ($libro->disponibles > 0): ?>
                    <span class="badge badge-success p-2" style="font-size:1rem;">
                        <i class="fas fa-check-circle"></i>
                        <?= $libro->disponibles ?> ejemplar(es) disponible(s)
                    </span>
                <?php else: ?>
                    <span class="badge badge-danger p-2" style="font-size:1rem;">
                        <i class="fas fa-times-circle"></i> No disponible
                    </span>
                <?php endif; ?>
            </div>

            <!-- Botón reservar -->
            <?php if ($libro->disponibles > 0): ?>
                <button onclick="reservar(<?= $libro->idrecurso ?>)"
                        class="btn btn-primary btn-block mt-3">
                    <i class="fas fa-bookmark"></i> Reservar
                </button>
            <?php endif; ?>

            <a href="<?= base_url('libros') ?>" class="btn btn-secondary btn-block mt-2">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        <!-- Columna derecha: Información -->
        <div class="col-md-9">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle"></i> Información del Recurso
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-8">
                            <h3 class="font-weight-bold"><?= esc($libro->titulo) ?></h3>
                            <p class="text-muted mb-1">
                                <i class="fas fa-user"></i>
                                <strong>Autor(es):</strong>
                                <?= esc($libro->autores ?? 'Sin autor') ?>
                            </p>
                        </div>

                        <div class="col-md-4 text-md-right">
                            <span class="badge badge-info p-2">
                                <?= esc($libro->tipo ?? 'Sin tipo') ?>
                            </span>
                        </div>

                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <small class="text-muted d-block">ISBN</small>
                            <strong><?= esc($libro->isbn ?? '—') ?></strong>
                        </div>
                        <div class="col-md-4 mb-3">
                            <small class="text-muted d-block">Año</small>
                            <strong><?= esc($libro->año ?? '—') ?></strong>
                        </div>
                        <div class="col-md-4 mb-3">
                            <small class="text-muted d-block">Páginas</small>
                            <strong><?= esc($libro->numpaginas ?? '—') ?></strong>
                        </div>
                        <div class="col-md-4 mb-3">
                            <small class="text-muted d-block">Categoría</small>
                            <strong><?= esc($libro->categoria ?? '—') ?></strong>
                        </div>
                        <div class="col-md-4 mb-3">
                            <small class="text-muted d-block">Subcategoría</small>
                            <strong><?= esc($libro->subcategoria ?? '—') ?></strong>
                        </div>
                        <div class="col-md-4 mb-3">
                            <small class="text-muted d-block">Total ejemplares</small>
                            <strong><?= $libro->total_ejemplares ?? 0 ?></strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de ejemplares -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-layer-group"></i> Ejemplares
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>ID Activo</th>
                                    <th>Condición</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($activos)): ?>
                                    <?php foreach ($activos as $i => $activo): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= $activo->idactivo ?></td>
                                        <td><?= esc($activo->condicion ?? '—') ?></td>
                                        <td>
                                            <?php if ($activo->prestado): ?>
                                                <span class="badge badge-danger">Prestado</span>
                                            <?php else: ?>
                                                <span class="badge badge-success">Disponible</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            Sin ejemplares registrados
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Historial de préstamos -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history"></i> Historial de Préstamos
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Usuario</th>
                                    <th>Entrega</th>
                                    <th>Devolución</th>
                                    <th>Condición entrega</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($prestamos)): ?>
                                    <?php foreach ($prestamos as $p): ?>
                                    <tr>
                                        <td><?= esc($p->nombreusuario ?? '—') ?></td>
                                        <td><?= $p->entrega ?? '—' ?></td>
                                        <td><?= $p->devolucion ?? '<em class="text-warning">Pendiente</em>' ?></td>
                                        <td><?= esc($p->condicionentrega ?? '—') ?></td>
                                        <td>
                                            <?php if (!$p->devolucion): ?>
                                                <span class="badge badge-warning">Activo</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">Devuelto</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            Sin historial de préstamos
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php endif; ?>
</div>

<script>
function reservar(idrecurso) {
    fetch(`<?= base_url('libros/activoDisponible/') ?>${idrecurso}`)
        .then(res => res.json())
        .then(data => {
            if (!data.idactivo) {
                Swal.fire('Sin ejemplares', 'No hay ejemplares disponibles.', 'warning');
                return;
            }
            Swal.fire({
                title: '¿Reservar este libro?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, reservar',
                cancelButtonText: 'Cancelar'
            }).then(result => {
                if (!result.isConfirmed) return;

                fetch('<?= base_url('libros/reservar') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `idactivo=${data.idactivo}`
                })
                .then(res => res.json())
                .then(resp => {
                    if (resp.success) {
                        Swal.fire('¡Reservado!', 'Reservado correctamente.', 'success')
                            .then(() => location.reload());
                    } else {
                        Swal.fire('Error', resp.error || 'No se pudo reservar.', 'error');
                    }
                });
            });
        });
}
</script>

<?= $footer ?? '' ?>