<?= $header ?>

<!-- ================= ESTILOS ================= -->
<style>

    body {
        background: linear-gradient(to right, #eef2ff, #f8fafc);
    }

    .wrapper {
        padding: 30px;
    }

    .titulo {
        font-size: 1.8rem;
        font-weight: bold;
        color: #1e1b4b;
    }

    .subtitulo {
        font-size: 0.9rem;
        color: #6b7280;
    }

    .card-main {
        background: white;
        border-radius: 14px;
        padding: 25px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }

    .label {
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
    }

    .input, .select {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #c7d2fe;
    }

    .input:focus {
        border-color: #4f46e5;
        outline: none;
    }

    .btn-main {
        background: #4f46e5;
        color: white;
        border-radius: 8px;
        padding: 10px 20px;
        border: none;
    }

    .btn-main:hover {
        background: #3730a3;
    }

    .estado {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
    }

    .activo {
        background: #e0e7ff;
        color: #3730a3;
    }

    .tabla {
        width: 100%;
        border-collapse: collapse;
    }

    .tabla th {
        background: #eef2ff;
        padding: 10px;
        font-size: 0.75rem;
    }

    .tabla td {
        padding: 12px;
        border-bottom: 1px solid #eee;
    }

</style>

<div class="wrapper">

    <!-- ================= HEADER ================= -->
    <div class="mb-4">
        <div class="titulo">Sistema de Biblioteca</div>
        <div class="subtitulo">Gestión completa de préstamos</div>
    </div>

    <!-- ================= FORMULARIO ================= -->
    <div class="card-main">

        <h5>Registrar nuevo préstamo</h5>

        <form id="formPrestamo" method="post" action="<?= base_url('prestamos/guardar') ?>">
            <?= csrf_field() ?>

            <input type="hidden" name="idalumna" id="idalumna">

            <div class="row">

                <!-- DNI -->
                <div class="col-md-3">
                    <label class="label">DNI</label>
                    <input type="text" id="dni" class="input">
                    <small id="msgDni"></small>
                </div>

                <!-- LIBRO -->
                <div class="col-md-4">
                    <label class="label">Libro</label>
                    <select id="libro" name="idactivo"></select>
                </div>

                <!-- CONDICION -->
                <div class="col-md-3">
                    <label class="label">Condición</label>
                    <select name="condicionentrega" class="select">
                        <option value="">Seleccionar</option>
                        <option>Bueno</option>
                        <option>Regular</option>
                        <option>Malo</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn-main w-100">Guardar</button>
                </div>

            </div>
        </form>

    </div>

    <!-- ================= TABLA ================= -->
    <div class="card-main">

        <h5>Listado de préstamos</h5>

        <input type="text" id="buscador" class="input mb-3" placeholder="Filtrar registros...">

        <table class="tabla" id="tabla">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Estudiante</th>
                    <th>DNI</th>
                    <th>Libro</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Condición</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($prestamos as $i => $p): ?>
                <tr>
                    <td><?= $i+1 ?></td>
                    <td><?= esc($p['nombre']) ?></td>
                    <td><?= esc($p['dni']) ?></td>
                    <td><?= esc($p['titulo']) ?></td>
                    <td><?= esc($p['entrega']) ?></td>
                    <td><?= esc($p['hora_entrega']) ?></td>
                    <td><?= esc($p['condicionentrega']) ?></td>
                    <td><span class="estado activo">Activo</span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>

        </table>

    </div>

</div>

<!-- ================= SCRIPTS ================= -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

let timeout;

// ================= BUSCAR DNI =================
document.getElementById('dni').addEventListener('input', function() {

    clearTimeout(timeout);

    let dni = this.value;

    if(dni.length < 8) return;

    timeout = setTimeout(() => {

        fetch(`<?= base_url('prestamos/buscar-alumna') ?>?dni=${dni}`)
        .then(r => r.json())
        .then(data => {

            if(data.success){
                document.getElementById('msgDni').innerHTML = data.nombre;
                document.getElementById('idalumna').value = data.id;
            } else {
                document.getElementById('msgDni').innerHTML = "No encontrado";
            }

        });

    }, 500);

});

// ================= VALIDACION =================
document.getElementById('formPrestamo').addEventListener('submit', function(e){

    let dni = document.getElementById('dni').value;
    let libro = document.getElementById('libro').value;

    if(dni === "" || libro === ""){
        e.preventDefault();

        Swal.fire({
            icon: 'error',
            title: 'Faltan datos',
            text: 'Completa todos los campos'
        });
    }

});

// ================= FILTRO TABLA =================
document.getElementById('buscador').addEventListener('keyup', function(){

    let valor = this.value.toLowerCase();
    let filas = document.querySelectorAll("#tabla tbody tr");

    filas.forEach(fila => {
        fila.style.display = fila.textContent.toLowerCase().includes(valor) ? "" : "none";
    });

});

// ================= SELECT LIBROS =================
new TomSelect("#libro", {
    valueField: "idactivo",
    labelField: "titulo",
    searchField: "titulo",

    load: function(query, callback) {
        fetch(`<?= base_url('prestamos/buscar-libros?q=') ?>${query}`)
        .then(res => res.json())
        .then(data => callback(data));
    }
});

</script>

<?= $footer ?>