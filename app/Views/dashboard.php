<?php

/** @var int $totalLibros */
/** @var int $prestados */
/** @var int $disponibles */
/** @var int $usuarios */
/** @var int $pendientes */
/** @var string $header */
/** @var string $footer */
?>
<?= $header ?>

<link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">

<div class="container-fluid px-4 py-4">

    <div class="mb-4">
        <div class="page-title">Pantalla Principal</div>
        <div class="page-subtitle">Resumen general del sistema de biblioteca</div>
    </div>

    <!-- Estadísticas -->
    <div class="row g-3 mb-4">
        <div class="col-xl col-md-6">
            <div class="stat-card">
                <div class="stat-icon azul"><i class="fas fa-book"></i></div>
                <div>
                    <div class="stat-label">Recursos Totales</div>
                    <div class="stat-value"><?= $totalLibros ?></div>
                </div>
            </div>
        </div>

        <!-- NUEVO -->
        <div class="col-xl col-md-6">
            <a href="<?= base_url('prestamos/pendientes') ?>" style="text-decoration:none;">
                <div class="stat-card stat-card-pendientes">
                    <div class="stat-icon naranja"><i class="fas fa-clock"></i></div>
                    <div>
                        <div class="stat-label">Reservas Pendientes</div>
                        <div class="stat-value"><?= $pendientes ?></div>
                    </div>
                    <?php if ($pendientes > 0): ?>
                        <span class="stat-badge-pendiente">Ver</span>
                    <?php endif; ?>
                </div>
            </a>
        </div>

        <div class="col-xl col-md-6">
            <div class="stat-card">
                <div class="stat-icon rojo"><i class="fas fa-book-reader"></i></div>
                <div>
                    <div class="stat-label">Libros Prestados</div>
                    <div class="stat-value"><?= $prestados ?></div>
                </div>
            </div>
        </div>
        <div class="col-xl col-md-6">
            <div class="stat-card">
                <div class="stat-icon verde"><i class="fas fa-check-circle"></i></div>
                <div>
                    <div class="stat-label">Libros Disponibles</div>
                    <div class="stat-value"><?= $disponibles ?></div>
                </div>
            </div>
        </div>
        <div class="col-xl col-md-6">
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
                <h3><i class="fas fa-chart-bar me-2" style="color:#1e3a5f;"></i> Préstamos registrados</h3>
                <p id="chart-subtitle">Últimos 30 días</p>
            </div>

            <div class="modo-tabs">
                <button class="modo-btn" data-modo="horas" onclick="cambiarModo('horas')">Por horas</button>
                <button class="modo-btn active" data-modo="dias" onclick="cambiarModo('dias')">Por días</button>
                <button class="modo-btn" data-modo="meses" onclick="cambiarModo('meses')">Por meses</button>
            </div>

            <div class="chart-total">
                <div class="chart-total-value" id="chart-total">—</div>
                <div class="chart-total-label">Total</div>
            </div>
        </div>

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

    const hoy = new Date();
    const pad = n => String(n).padStart(2, '0');
    const fmt = d => `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}`;

    const hace30 = new Date(hoy);
    hace30.setDate(hoy.getDate() - 29);

    document.getElementById('fecha-horas').value = fmt(hoy);
    document.getElementById('fecha-inicio').value = fmt(hace30);
    document.getElementById('fecha-fin').value = fmt(hoy);

    const selectAnio = document.getElementById('select-anio');
    for (let y = hoy.getFullYear(); y >= hoy.getFullYear() - 4; y--) {
        const opt = document.createElement('option');
        opt.value = y;
        opt.textContent = y;
        selectAnio.appendChild(opt);
    }

    let chart = null;

    function initChart(labels, datos) {
        const ctx = document.getElementById('chartPrestamos').getContext('2d');
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
                            label: ctx => ` ${ctx.parsed.y} préstamo(s)`
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

    cargarGrafico();
</script>

<?= $footer ?>