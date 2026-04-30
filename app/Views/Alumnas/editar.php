<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Alumna</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">

        <h2 class="mb-4">Editar Alumna</h2>

        <form action="<?= base_url('alumnasp/actualizar/' . $alumna['id']) ?>" method="post">
            <?= csrf_field() ?>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Nombres</label>
                    <input type="text" name="nombres" class="form-control" value="<?= esc($alumna['nombres']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label>Apellidos</label>
                    <input type="text" name="apellidos" class="form-control" value="<?= esc($alumna['apellidos']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label>DNI</label>
                    <input type="text" name="dni" class="form-control" value="<?= esc($alumna['dni']) ?>" required>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <label>Grado</label>
                    <select name="grado" class="form-control" required>
                        <option value="1" <?= $alumna['grado'] == '1' ? 'selected' : '' ?>>1° Secundaria</option>
                        <option value="2" <?= $alumna['grado'] == '2' ? 'selected' : '' ?>>2° Secundaria</option>
                        <option value="3" <?= $alumna['grado'] == '3' ? 'selected' : '' ?>>3° Secundaria</option>
                        <option value="4" <?= $alumna['grado'] == '4' ? 'selected' : '' ?>>4° Secundaria</option>
                        <option value="5" <?= $alumna['grado'] == '5' ? 'selected' : '' ?>>5° Secundaria</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Sección</label>
                    <select name="seccion" class="form-control" required>
                        <option value="A" <?= $alumna['seccion'] == 'A' ? 'selected' : '' ?>>A</option>
                        <option value="B" <?= $alumna['seccion'] == 'B' ? 'selected' : '' ?>>B</option>
                        <option value="C" <?= $alumna['seccion'] == 'C' ? 'selected' : '' ?>>C</option>
                        <option value="D" <?= $alumna['seccion'] == 'D' ? 'selected' : '' ?>>D</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-success w-100">Actualizar Alumna</button>
                </div>
            </div>

        </form>

        <a href="<?= base_url('alumnasp') ?>" class="btn btn-secondary">Volver al listado</a>

    </div>

</body>

</html>