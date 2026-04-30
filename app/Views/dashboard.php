<?= $header ?>

<style>
    body {
        background-color: #f4f6f9;
    }

    .page-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 2px;
    }

    .page-subtitle {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .panel {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 24px;
        margin-bottom: 20px;
    }

    .panel-label {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        color: #94a3b8;
        text-transform: uppercase;
        margin-bottom: 16px;
    }

    /* Stat cards */
    .stat-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .stat-icon.azul {
        background: #eff6ff;
        color: #2563eb;
    }

    .stat-icon.rojo {
        background: #fef2f2;
        color: #dc2626;
    }

    .stat-icon.verde {
        background: #f0fdf4;
        color: #16a34a;
    }

    .stat-icon.amarillo {
        background: #fefce8;
        color: #ca8a04;
    }

    .stat-label {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #94a3b8;
        margin-bottom: 4px;
    }

    .stat-value {
        font-size: 1.6rem;
        font-weight: 700;
        color: #1e293b;
        line-height: 1;
    }

    /* Calendario */
    .fc .fc-toolbar-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
    }

    .fc .fc-button-primary {
        background-color: #1e3a5f !important;
        border-color: #1e3a5f !important;
        font-size: 0.78rem;
        border-radius: 6px !important;
    }

    .fc .fc-button-primary:hover {
        background-color: #16304f !important;
    }

    .fc .fc-daygrid-day-number {
        font-size: 0.82rem;
        color: #64748b;
    }

    .fc .fc-col-header-cell-cushion {
        font-size: 0.75rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
    }

    .fc .fc-event {
        border-radius: 4px;
        font-size: 0.75rem;
        border: none;
        padding: 2px 5px;
    }
</style>

<div class="container-fluid px-4 py-4">

    <!-- Encabezado -->
    <div class="mb-4">
        <div class="page-title">Dashboard</div>
        <div class="page-subtitle">Resumen general del sistema de biblioteca</div>
    </div>

    <!-- Estadísticas -->
    <div class="row g-3 mb-4">

        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon azul">
                    <i class="fas fa-book"></i>
                </div>
                <div>
                    <div class="stat-label">Libros Totales</div>
                    <div class="stat-value"><?= $totalLibros ?></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon rojo">
                    <i class="fas fa-book-reader"></i>
                </div>
                <div>
                    <div class="stat-label">Libros Prestados</div>
                    <div class="stat-value"><?= $prestados ?></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon verde">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <div class="stat-label">Libros Disponibles</div>
                    <div class="stat-value"><?= $disponibles ?></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon amarillo">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <div class="stat-label">Usuarios</div>
                    <div class="stat-value"><?= $usuarios ?></div>
                </div>
            </div>
        </div>

    </div>

    <!-- Calendario -->
    <div class="panel">
        <div class="panel-label">Calendario de Préstamos</div>
        <div id="calendar"></div>
    </div>

</div>

<!-- FullCalendar -->
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
                día: 'Día'
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