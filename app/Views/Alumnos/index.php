<?= $header ?>

<div class="row">
  <div class="col-md-12">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Gestión de Alumnas - Secundaria</h1>
    </div>

    <!-- Card importar -->
    <div class="card border-left-primary shadow mb-4">
      <div class="card-header py-3 d-flex align-items-center">
        <i class="fas fa-file-excel text-primary mr-2"></i>
        <h6 class="m-0 font-weight-bold text-primary">
          Importar alumnas por grado y sección
        </h6>
      </div>

      <div class="card-body">

        <div class="alert alert-info">
          <i class="fas fa-info-circle mr-1"></i>
          La importación se realiza por <b>grado y sección</b>. Evita duplicados seleccionando correctamente el destino.
        </div>

        <form action="<?= base_url('alumnos/importar') ?>" method="post" enctype="multipart/form-data">

          <div class="row">

            <!-- Grado -->
            <div class="col-md-4">
              <div class="form-group">
                <label class="font-weight-bold">Grado (Secundaria)</label>
                <select name="idgrupo" class="form-control" required>
                  <option value="">-- Seleccionar grado y sección --</option>
                  <?php foreach ($grupos as $grupo): ?>
                    <option value="<?= $grupo['idgrupo'] ?>">
                      Secundaria - <?= $grupo['grado'] ?> "<?= $grupo['seccion'] ?>"
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <!-- Archivo -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold">Archivo Excel (.xlsx / .xls)</label>

                <div class="custom-file">
                  <input type="file"
                         class="custom-file-input"
                         name="archivo_excel"
                         accept=".xlsx,.xls"
                         required>
                  <label class="custom-file-label">Seleccionar archivo...</label>
                </div>

              </div>
            </div>

            <!-- Botón -->
            <div class="col-md-2 d-flex align-items-end">
              <button type="submit" class="btn btn-primary btn-block mb-3">
                <i class="fas fa-upload mr-1"></i> Importar
              </button>
            </div>

          </div>

        </form>

      </div>
    </div>

    <!-- Mensajes -->
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success">
        <i class="fas fa-check-circle mr-1"></i>
        <?= session()->getFlashdata('success') ?>
      </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle mr-1"></i>
        <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>


    <!-- Tabla -->
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
          Alumnas registradas (Secundaria)
        </h6>

        <!-- Filtro opcional -->
        <select id="filtroSeccion" class="form-control form-control-sm w-auto">
          <option value="">Todas las secciones</option>
          <?php foreach ($grupos as $grupo): ?>
            <option value="<?= $grupo['idgrupo'] ?>">
              <?= $grupo['grado'] ?> - <?= $grupo['seccion'] ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="card-body">
        <table class="table table-bordered table-hover" id="content-table">
          <thead class="thead-dark">
            <tr>
              <th>#</th>
              <th>Apellidos</th>
              <th>Nombres</th>
              <th>Doc</th>
              <th>Número</th>
              <th>Teléfono</th>
              <th>Grado</th>
              <th>Sección</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($personas as $persona): ?>
              <tr data-idgrupo="<?= $persona['idgrupo'] ?>">
                <td><?= $persona['idpersona'] ?></td>
                <td><?= $persona['apellidos'] ?></td>
                <td><?= $persona['nombres'] ?></td>
                <td><?= $persona['tipodoc'] ?></td>
                <td><?= $persona['numdoc'] ?></td>
                <td><?= $persona['telefono'] ?></td>
                <td><?= $persona['grado'] ?></td>
                <td><?= $persona['seccion'] ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>

        </table>
      </div>
    </div>

  </div>
</div>

<script>
  // mostrar nombre del archivo
  document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    let fileName = e.target.files[0].name;
    document.querySelector('.custom-file-label').textContent = fileName;
  });

  // filtro por sección
  document.getElementById('filtroSeccion').addEventListener('change', function () {
    let value = this.value;
    let rows = document.querySelectorAll('#content-table tbody tr');

    rows.forEach(row => {
      if (value === "" || row.dataset.idgrupo === value) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  });
</script>

<?= $footer ?>