<?= view('Partials/header') ?>

<div class="container p-4">

    <h3>Devolución de Libros</h3>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Alumno</th>
                <th>Libro</th>
                <th>Acción</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($prestamos as $i => $p): ?>
            <tr>
                <td><?= $i+1 ?></td>
                <td><?= $p['nombre'] ?></td>
                <td><?= $p['titulo'] ?></td>
                <td>
                    <form action="<?= base_url('devoluciones/guardar') ?>" method="post">
                        <input type="hidden" name="idprestamo" value="<?= $p['idprestamo'] ?>">
                        <button class="btn btn-success">Devolver</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

</div>

<?= view('Partials/footer') ?>