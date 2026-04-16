<div class="container mt-4">

    <div class="row">
        <div class="col-md-4">
            <img src="<?= $libro->portada ?>" class="img-fluid">
        </div>

        <div class="col-md-8">
            <h2><?= $libro->titulo ?></h2>

            <p><strong>Categoría:</strong> <?= $libro->categoria ?></p>
            <p><strong>Subcategoría:</strong> <?= $libro->subcategoria ?></p>
            <p><strong>Año:</strong> <?= $libro->anio ?></p>
            <p><strong>ISBN:</strong> <?= $libro->isbn ?></p>
            <p><strong>Páginas:</strong> <?= $libro->numpaginas ?></p>

            <p>
                Este libro pertenece a la categoría <?= $libro->categoria ?> y
                aborda temas relacionados con <?= $libro->subcategoria ?>.
                Es un recurso ideal para estudiantes y usuarios que buscan
                ampliar conocimientos en esta área.
            </p>

            <form method="post" action="<?= base_url('reservar') ?>">
                <input type="hidden" name="idactivo" value="<?= $libro->idrecurso ?>">
                <button class="btn btn-success">Reservar</button>
            </form>

        </div>
    </div>

</div>