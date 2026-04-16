<?= $header ?>

<div class="row">
  <div class="col-md-12">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4>Lista de Libros</h4>

      <a href="<?= base_url('libros/registrar') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Agregar Libro
      </a>
    </div>

    <div class="row">

      <?php if (!empty($recursos)): ?>
        <?php foreach ($recursos as $recurso): ?>
          <div class="col-md-3 mb-4">
            <div class="card shadow h-100">

              <img src="<?= base_url('uploads/portadas/' . $recurso['portada']) ?>" 
                   class="card-img-top"
                   style="height:200px; object-fit:cover;"
                   onerror="this.src='https://via.placeholder.com/300x200?text=Sin+Imagen'">

              <div class="card-body text-center">
                <h6 class="font-weight-bold"><?= esc($recurso['titulo']) ?></h6>
                <p class="mb-1">ISBN: <?= esc($recurso['isbn']) ?></p>
                <p class="mb-1">Año: <?= esc($recurso['anio']) ?></p>
                <p class="mb-0">Páginas: <?= esc($recurso['numpaginas']) ?></p>
              </div>

              <div class="card-footer text-center bg-white">
                <a href="<?= base_url('libros/editar/' . $recurso['id']) ?>" class="btn btn-sm btn-info">
                  ✏ Editar
                </a>

                <a href="<?= base_url('libros/eliminar/' . $recurso['id']) ?>" 
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('¿Seguro que deseas eliminar este libro?')">
                  🗑 Eliminar
                </a>
              </div>

            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>

        <div class="col-12">
          <div class="alert alert-warning text-center">
            No hay libros registrados aún.
          </div>
        </div>

      <?php endif; ?>

    </div>
  </div>
</div>

<?= $footer ?>