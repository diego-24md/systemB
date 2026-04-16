<?= $header ?>
<div class="row">
  <div class="col-md-12">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Lista de Alumnos</h1>
    </div>

    <!-- Card importar -->
    <div class="card border-left-primary shadow mb-4">
      <div class="card-header py-3 d-flex align-items-center">
        <i class="fas fa-file-excel text-primary mr-2"></i>
        <h6 class="m-0 font-weight-bold text-primary">Importar alumnos desde Excel</h6>
      </div>
      <div class="card-body">
        <form action="<?= base_url('alumnos/importar') ?>" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label class="font-weight-bold">Grado y Sección</label>
                <select name="idgrupo" class="form-control" required>
                  <option value="">-- Seleccionar --</option>
                  <?php foreach ($grupos as $grupo): ?>
                    <option value="<?= $grupo['idgrupo'] ?>">
                      <?= $grupo['grado'] ?> - <?= $grupo['seccion'] ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="font-weight-bold">Archivo Excel</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="archivo_excel" accept=".xlsx,.xls" required>
                    <label class="custom-file-label">Seleccionar archivo...</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-2 d-flex align-items-end">
              <button type="submit" class="btn btn-primary btn-block mb-3">
                <i class="fas fa-upload mr-1"></i> Cargar
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Mensajes -->
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><i class="fas fa-check-circle mr-1"></i><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger"><i class="fas fa-exclamation-circle mr-1"></i><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <!-- Tabla -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Alumnos registrados</h6>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-hover" id="content-table">
          <thead class="thead-dark">
            <tr>
              <th>#</th>
              <th>Apellidos</th>
              <th>Nombres</th>
              <th>Tipo Doc</th>
              <th>Num Doc</th>
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
  document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    document.querySelector('.custom-file-label').textContent = fileName;
  });
</script>

<?= $footer ?>