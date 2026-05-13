<?php

/** @var int $totalLibros */
/** @var int $prestados */
/** @var int $disponibles */
/** @var int $usuarios */
/** @var string $header */
/** @var string $footer */
?>
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

    /* ── STAT CARDS ─────────────────────────── */
    .stat-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: transform .2s, box-shadow .2s;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
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
        letter-spacing: .06em;
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

    /* ── CHART TOOLBAR ──────────────────────── */
    .chart-toolbar {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .chart-toolbar-left {
        flex: 1;
        min-width: 200px;
    }

    .chart-toolbar-left h3 {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 2px;
    }

    .chart-toolbar-left p {
        font-size: 0.78rem;
        color: #94a3b8;
        margin: 0;
    }

    /* modo tabs */
    .modo-tabs {
        display: flex;
        gap: 4px;
        background: #f1f5f9;
        border-radius: 8px;
        padding: 4px;
    }

    .modo-btn {
        padding: 6px 14px;
        font-size: 0.78rem;
        font-weight: 600;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        background: transparent;
        color: #64748b;
        font-family: inherit;
        transition: all .18s;
        white-space: nowrap;
    }

    .modo-btn.active {
        background: #fff;
        color: #1e3a5f;
        box-shadow: 0 1px 4px rgba(0, 0, 0, .1);
    }

    .modo-btn:hover:not(.active) {
        color: #1e3a5f;
    }

    /* controles de filtro */
    .chart-filters {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .chart-filters input[type="date"],
    .chart-filters select {
        border: 1px solid #e2e8f0;
        border-radius: 7px;
        padding: 6px 10px;
        font-size: 0.82rem;
        color: #475569;
        font-family: inherit;
        outline: none;
        background: #f8fafc;
        cursor: pointer;
    }

    .chart-filters input[type="date"]:focus,
    .chart-filters select:focus {
        border-color: #1e3a5f;
        background: #fff;
    }

    .btn-aplicar {
        padding: 6px 16px;
        font-size: 0.82rem;
        font-weight: 600;
        background: #1e3a5f;
        color: #fff;
        border: none;
        border-radius: 7px;
        cursor: pointer;
        font-family: inherit;
        transition: background .18s;
    }

    .btn-aplicar:hover {
        background: #16304f;
    }

    /* total badge */
    .chart-total {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 6px 16px;
        text-align: center;
        white-space: nowrap;
    }

    .chart-total-value {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1e3a5f;
        line-height: 1;
    }

    .chart-total-label {
        font-size: 0.68rem;
        color: #94a3b8;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .04em;
        margin-top: 2px;
    }

    /* canvas */
    .chart-wrap {
        position: relative;
        height: 300px;
    }

    .chart-loading {
        display: none;
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, .8);
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-size: 0.88rem;
        color: #94a3b8;
        gap: 8px;
        z-index: 10;
    }

    .chart-loading.show {
        display: flex;
    }

    .chart-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 240px;
        color: #94a3b8;
        font-size: 0.88rem;
        gap: 10px;
    }

    .chart-empty i {
        font-size: 2rem;
        color: #e2e8f0;
    }
</style>

<div class="container-fluid px-4 py-4">

    <div class="mb-4">
        <div class="page-title">Dashboard</div>
        <div class="page-subtitle">Resumen general del sistema de biblioteca</div>
    </div>

    <!-- Estadísticas -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon azul"><i class="fas fa-book"></i></div>
                <div>
                    <div class="stat-label">Recursos Totales</div>
                    <div class="stat-value"><?= $totalLibros ?></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon rojo"><i class="fas fa-book-reader"></i></div>
                <div>
                    <div class="stat-label">Libros Prestados</div>
                    <div class="stat-value"><?= $prestados ?></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon verde"><i class="fas fa-check-circle"></i></div>
                <div>
                    <div class="stat-label">Libros Disponibles</div>
                    <div class="stat-value"><?= $disponibles ?></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon amarillo"><i class="fas fa-users"></i></div>
                <div>
                    <div class="stat-label">Usuarios</div>
                    <div class="stat-value"><?= $usuarios ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico -->
    <div class="panel">

        <div class="chart-toolbar">
            <div class="chart-toolbar-left">
                <h3><i class="fas fa-chart-bar me-2" style="color:#1e3a5f;"></i>Préstamos registrados</h3>
                <p id="chart-subtitle">Últimos 30 días</p>
            </div>

            <!-- Modo -->
            <div class="modo-tabs">
                <button class="modo-btn" data-modo="horas" onclick="cambiarModo('horas')">Por horas</button>
                <button class="modo-btn active" data-modo="dias" onclick="cambiarModo('dias')">Por días</button>
                <button class="modo-btn" data-modo="meses" onclick="cambiarModo('meses')">Por meses</button>
            </div>

            <!-- Total -->
            <div class="chart-total">
                <div class="chart-total-value" id="chart-total">—</div>
                <div class="chart-total-label">Total</div>
            </div>
        </div>

        <!-- Filtros dinámicos -->
        <div class="chart-filters mb-3" id="filtros-horas" style="display:none;">
            <label style="font-size:.8rem;color:#64748b;font-weight:600;">Fecha:</label>
            <input type="date" id="fecha-horas">
            <button class="btn-aplicar" onclick="cargarGrafico()">Aplicar</button>
        </div>

        <div class="chart-filters mb-3" id="filtros-dias" style="display:flex;">
            <label style="font-size:.8rem;color:#64748b;font-weight:600;">Desde:</label>
            <input type="date" id="fecha-inicio">
            <label style="font-size:.8rem;color:#64748b;font-weight:600;">Hasta:</label>
            <input type="date" id="fecha-fin">
            <button class="btn-aplicar" onclick="cargarGrafico()">Aplicar</button>
        </div>

        <div class="chart-filters mb-3" id="filtros-meses" style="display:none;">
            <label style="font-size:.8rem;color:#64748b;font-weight:600;">Año:</label>
            <select id="select-anio"></select>
            <button class="btn-aplicar" onclick="cargarGrafico()">Aplicar</button>
        </div>

        <!-- Canvas -->
        <div class="chart-wrap">
            <div class="chart-loading" id="chart-loading">
                <i class="fas fa-spinner fa-spin"></i> Cargando...
            </div>
            <canvas id="chartPrestamos"></canvas>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const URL_CHART = "<?= base_url('home/chartData') ?>";

    // Fechas por defecto
    const hoy = new Date();
    const pad = n => String(n).padStart(2, '0');
    const fmt = d => `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}`;

    const hace30 = new Date(hoy);
    hace30.setDate(hoy.getDate() - 29);

    document.getElementById('fecha-horas').value = fmt(hoy);
    document.getElementById('fecha-inicio').value = fmt(hace30);
    document.getElementById('fecha-fin').value = fmt(hoy);

    // Selector de años
    const selectAnio = document.getElementById('select-anio');
    for (let y = hoy.getFullYear(); y >= hoy.getFullYear() - 4; y--) {
        const opt = document.createElement('option');
        opt.value = y;
        opt.textContent = y;
        selectAnio.appendChild(opt);
    }

    // Chart.js
    let chart = null;

    function initChart(labels, datos) {
        const ctx = document.getElementById('chartPrestamos').getContext('2d');
        const maxVal = Math.max(...datos, 1);

        if (chart) chart.destroy();

        chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Préstamos',
                    data: datos,
                    backgroundColor: datos.map(v => v === Math.max(...datos) && v > 0 ? '#1e3a5f' : '#93afd4'),
                    borderRadius: 6,
                    borderSkipped: false,
                    maxBarThickness: 52,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => ` ${ctx.parsed.y} préstamo(s)`,
                        },
                        backgroundColor: '#1e293b',
                        titleFont: {
                            size: 12
                        },
                        bodyFont: {
                            size: 13,
                            weight: '600'
                        },
                        padding: 10,
                        cornerRadius: 8,
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            },
                            color: '#94a3b8',
                            maxRotation: 45
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 11
                            },
                            color: '#94a3b8'
                        },
                        grid: {
                            color: '#f1f5f9'
                        }
                    }
                }
            }
        });
    }

    let modoActual = 'dias';

    function cambiarModo(modo) {
        modoActual = modo;

        document.querySelectorAll('.modo-btn').forEach(b => b.classList.remove('active'));
        document.querySelector(`[data-modo="${modo}"]`).classList.add('active');

        document.getElementById('filtros-horas').style.display = modo === 'horas' ? 'flex' : 'none';
        document.getElementById('filtros-dias').style.display = modo === 'dias' ? 'flex' : 'none';
        document.getElementById('filtros-meses').style.display = modo === 'meses' ? 'flex' : 'none';

        cargarGrafico();
    }

    function cargarGrafico() {
        const loading = document.getElementById('chart-loading');
        loading.classList.add('show');

        let url = `${URL_CHART}?modo=${modoActual}`;
        let subtitulo = '';

        if (modoActual === 'horas') {
            const fecha = document.getElementById('fecha-horas').value;
            url += `&fecha=${fecha}`;
            subtitulo = `Horas del ${fecha.split('-').reverse().join('/')}`;
        } else if (modoActual === 'dias') {
            const inicio = document.getElementById('fecha-inicio').value;
            const fin = document.getElementById('fecha-fin').value;
            url += `&inicio=${inicio}&fin=${fin}`;
            subtitulo = `Del ${inicio.split('-').reverse().join('/')} al ${fin.split('-').reverse().join('/')}`;
        } else {
            const anio = document.getElementById('select-anio').value;
            url += `&anio=${anio}`;
            subtitulo = `Año ${anio}`;
        }

        fetch(url)
            .then(r => r.json())
            .then(data => {
                loading.classList.remove('show');
                document.getElementById('chart-subtitle').textContent = subtitulo;
                document.getElementById('chart-total').textContent = data.total;
                initChart(data.labels, data.datos);
            })
            .catch(() => loading.classList.remove('show'));
    }

    // Carga inicial
    cargarGrafico();
</script>

<?= $footer ?>