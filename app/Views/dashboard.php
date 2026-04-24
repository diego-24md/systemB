<?= $header ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"></h1>
    </div>

    <!-- Estadísticas estilo SB Admin -->
    <div class="row">

        <!-- LIBROS -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Libros Totales
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?= $totalLibros ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- PRESTADOS -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                        Libros Prestados
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?= $prestados ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- DISPONIBLES -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Libros Disponibles
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?= $disponibles ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- USUARIOS -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Usuarios
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?= $usuarios ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Tu Calendario -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Calendario de Préstamos</h6>
                </div>
                <div class="card-body">
                    <div id="calendar" style="max-width: 1100px; margin: 0 auto;"></div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- FullCalendar Script -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 'auto',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día'
            },
            events: [
                { title: "Cien Años de Soledad - Ana García", start: "2026-04-10", end: "2026-04-12", color: "#3b82f6" },
                { title: "Don Quijote - Luis Mendoza", start: "2026-04-14", end: "2026-04-18", color: "#10b981" },
                { title: "1984 - María Torres (VENCIDO)", start: "2026-04-05", end: "2026-04-07", color: "#ef4444" },
                { title: "El Principito - Carlos Ruiz", start: "2026-04-20", end: "2026-04-22", color: "#3b82f6" }
            ]
        });
        calendar.render();
    });
</script>

<?= $footer ?>