<?= $header ?>

<div class="row">
  <div class="col-md-12">
    <h4 class="mb-4">📚 Lista de Libros</h4>

    <a href="<?= base_url('libros/registrar') ?>" class="btn btn-primary mb-4">
      <i class="fas fa-plus"></i> Agregar Libro
    </a>

    <div class="row">

      <!-- 🔥 DATOS REALES -->
      <?php foreach ($recursos as $recurso): ?>
        <div class="col-md-3 mb-4">
          <div class="card shadow h-100">

            <img src="<?= base_url('uploads/'.$recurso['imagen']) ?>" 
                 class="card-img-top"
                 style="height:200px; object-fit:cover;"
                 onerror="this.src='https://via.placeholder.com/300x200?text=Libro'">

            <div class="card-body text-center">
              <h6 class="font-weight-bold"><?= $recurso['titulo'] ?></h6>
              <p>ISBN: <?= $recurso['isbn'] ?></p>
            </div>

            <div class="card-footer text-center bg-white">
              <a href="#" class="btn btn-sm btn-info">✏ Editar</a>
              <a href="#" class="btn btn-sm btn-danger">🗑 Eliminar</a>
            </div>

          </div>
        </div>
      <?php endforeach; ?>

      <!-- 🔥 CARDS DE EJEMPLO -->
      <div class="col-md-3 mb-4">
        <div class="card shadow h-100">
          <img src="https://images-na.ssl-images-amazon.com/images/I/81gepf1eMqL.jpg"
               class="card-img-top" style="height:200px; object-fit:cover;">
          <div class="card-body text-center">
            <h6 class="font-weight-bold">Clean Code</h6>
            <p>ISBN: 9780132350884</p>
          </div>
          <div class="card-footer text-center bg-white">
            <button class="btn btn-sm btn-info">✏ Editar</button>
            <button class="btn btn-sm btn-danger">🗑 Eliminar</button>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="card shadow h-100">
          <img src="https://images-na.ssl-images-amazon.com/images/I/71g2ednj0JL.jpg"
               class="card-img-top" style="height:200px; object-fit:cover;">
          <div class="card-body text-center">
            <h6 class="font-weight-bold">The Pragmatic Programmer</h6>
            <p>ISBN: 9780201616224</p>
          </div>
          <div class="card-footer text-center bg-white">
            <button class="btn btn-sm btn-info">✏ Editar</button>
            <button class="btn btn-sm btn-danger">🗑 Eliminar</button>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="card shadow h-100">
          <img src="https://images-na.ssl-images-amazon.com/images/I/91bYsX41DVL.jpg"
               class="card-img-top" style="height:200px; object-fit:cover;">
          <div class="card-body text-center">
            <h6 class="font-weight-bold">Design Patterns</h6>
            <p>ISBN: 9780201633610</p>
          </div>
          <div class="card-footer text-center bg-white">
            <button class="btn btn-sm btn-info">✏ Editar</button>
            <button class="btn btn-sm btn-danger">🗑 Eliminar</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<?= $footer ?>