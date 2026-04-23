<?= $header ?>

<style>
    .btn-primary-custom {
        background: var(--bs-primary, #0d6efd);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 9px 20px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: opacity .15s;
    }

    .btn-primary-custom:hover {
        opacity: .88;
    }

    .btn-success-custom {
        background: #198754;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 9px 20px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: opacity .15s;
    }

    .btn-success-custom:hover {
        opacity: .88;
    }

    .btn-secondary-custom {
        background: #f0f0f0;
        color: #555;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 9px 20px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: background .15s;
    }

    .btn-secondary-custom:hover {
        background: #e2e2e2;
    }

    .page-card {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 12px;
        overflow: hidden;
    }

    .page-card-body {
        padding: 1.5rem;
    }

    .section-label {
        font-size: 11px;
        font-weight: 600;
        color: #888;
        text-transform: uppercase;
        letter-spacing: .06em;
        margin: 0 0 14px;
    }

    .form-label-custom {
        font-size: 13px;
        color: #666;
        display: block;
        margin-bottom: 6px;
    }

    .form-select-custom,
    .form-input-custom {
        width: 100%;
        padding: 10px 13px;
        font-size: 14px;
        border: 1px solid #dde1e7;
        border-radius: 8px;
        background: #fff;
        color: #1a1a1a;
        box-sizing: border-box;
        transition: border-color .15s, box-shadow .15s;
    }

    .form-select-custom:focus,
    .form-input-custom:focus {
        outline: none;
        border-color: #86b7fe;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, .12);
    }

    .results-badge {
        background: #e7f1ff;
        color: #0a58ca;
        font-size: 11px;
        padding: 4px 14px;
        border-radius: 20px;
        font-weight: 600;
    }

    .alumnas-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .alumnas-table thead tr {
        background: #f8f9fa;
    }

    .alumnas-table thead th {
        padding: 12px 20px;
        text-align: left;
        font-weight: 600;
        font-size: 12px;
        color: #888;
        text-transform: uppercase;
        letter-spacing: .05em;
        border-bottom: 1px solid #eee;
    }

    .alumnas-table tbody tr {
        border-top: 1px solid #f2f2f2;
        transition: background .1s;
    }

    .alumnas-table tbody tr:nth-child(even) {
        background: #fafafa;
    }

    .alumnas-table tbody tr:hover {
        background: #f0f5ff;
    }

    .alumnas-table tbody td {
        padding: 13px 20px;
        color: #1a1a1a;
    }

    .alumnas-table .td-num {
        color: #bbb;
        font-size: 13px;
        width: 52px;
    }

    .alumnas-table .td-dni {
        font-family: monospace;
        font-size: 13px;
        color: #666;
        width: 140px;
    }

    .alumnas-table .td-nombre {
        font-weight: 500;
    }

    .empty-state {
        text-align: center;
        padding: 3.5rem 1rem;
        color: #aaa;
    }

    .empty-state svg {
        margin-bottom: 12px;
        opacity: .4;
    }

    .empty-state p {
        margin: 0;
        font-size: 14px;
    }

    .drop-zone {
        background: #f8f9fa;
        border: 2px dashed #cdd3da;
        border-radius: 10px;
        padding: 2.5rem 2rem;
        text-align: center;
        cursor: pointer;
        transition: border-color .15s, background .15s;
    }

    .drop-zone:hover,
    .drop-zone.drag-over {
        background: #eef4ff;
        border-color: #86b7fe;
    }

    .drop-zone svg {
        opacity: .45;
        margin-bottom: 10px;
    }

    .drop-zone p {
        margin: 0;
        font-size: 14px;
        color: #666;
    }

    .drop-zone small {
        font-size: 12px;
        color: #aaa;
    }

    .modal-header-custom {
        background: #f0f7ff;
        padding: 1.1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #d0e4ff;
    }

    .modal-header-custom span {
        font-size: 15px;
        font-weight: 600;
        color: #0a58ca;
    }

    .modal-close {
        background: none;
        border: none;
        cursor: pointer;
        color: #0a58ca;
        font-size: 18px;
        line-height: 1;
        padding: 0;
    }

    .modal-footer-custom {
        padding: 1.1rem 1.5rem;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }
</style>

<div class="container-fluid py-5 px-4 px-lg-5">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-2">
        <div>
            <h5 class="mb-1 fw-semibold">Gestión de alumnas</h5>
            <small class="text-muted">Consulta e importación por grado y sección</small>
        </div>
        <button class="btn-success-custom" data-bs-toggle="modal" data-bs-target="#modalImportar">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3" />
            </svg>
            Importar Excel
        </button>
    </div>

    <!-- FILTROS -->
    <div class="page-card mb-4">
        <div class="page-card-body">
            <p class="section-label">Filtrar alumnas</p>
            <div class="row g-3 align-items-end">

                <div class="col-md-4">
                    <label class="form-label-custom">Grado</label>
                    <select id="grado" class="form-select-custom">
                        <option value="">Seleccione grado</option>
                        <?php foreach ($grados as $g): ?>
                            <option value="<?= $g['id'] ?>"><?= esc($g['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label-custom">Sección</label>
                    <select id="seccion" class="form-select-custom">
                        <option value="">Seleccione sección</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <button class="btn-primary-custom w-100" onclick="cargar()"
                        style="justify-content:center; background:#1a3c6e;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <circle cx="11" cy="11" r="8" />
                            <path d="M21 21l-4.35-4.35" />
                        </svg>
                        Buscar alumnas
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- TABLA -->
    <div class="page-card">

        <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-bottom:1px solid #eee;">
            <p class="section-label mb-0">Resultados</p>
            <span class="results-badge" id="contadorBadge" style="display:none;"></span>
        </div>

        <div class="table-responsive">
            <table class="alumnas-table">
                <thead>
                    <tr>
                        <th class="td-num">#</th>
                        <th class="td-dni">DNI</th>
                        <th>Nombre completo</th>
                    </tr>
                </thead>
                <tbody id="tablaAlumnas">
                    <tr>
                        <td colspan="3">
                            <div class="empty-state">
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#999"
                                    stroke-width="1.5">
                                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                                </svg>
                                <p>Selecciona un grado y sección para ver las alumnas</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</div>


<!-- MODAL IMPORTAR -->
<div class="modal fade" id="modalImportar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm" style="border-radius:14px;overflow:hidden;">

            <div class="modal-header-custom">
                <span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0a58ca" stroke-width="2"
                        style="margin-right:6px;vertical-align:middle;">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3" />
                    </svg>
                    Importar alumnas
                </span>
                <button class="modal-close" data-bs-dismiss="modal">✕</button>
            </div>

            <div class="modal-body p-4">
                <div class="drop-zone mb-3" onclick="document.getElementById('excel').click()">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#555" stroke-width="1.5">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3" />
                    </svg>
                    <p id="dropLabel">Arrastra tu archivo aquí o haz clic para seleccionar</p>
                    <small>Solo archivos .xlsx o .xls · Formato SIAGIE</small>
                    <input type="file" id="excel" accept=".xlsx,.xls" style="display:none;"
                        onchange="document.getElementById('dropLabel').textContent = this.files[0]?.name || 'Arrastra tu archivo aquí'">
                </div>
            </div>

            <div class="modal-footer-custom">
                <button class="btn-secondary-custom" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn-success-custom" onclick="importar()">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3" />
                    </svg>
                    Subir archivo
                </button>
            </div>

        </div>
    </div>
</div>


<!-- JS -->
<script>
    document.getElementById('grado').addEventListener('change', function () {
        const grado_id = this.value;
        const sel = document.getElementById('seccion');
        sel.innerHTML = '<option value="">Seleccione sección</option>';
        if (!grado_id) return;
        fetch("<?= base_url('secciones') ?>?grado_id=" + grado_id)
            .then(r => r.json())
            .then(data => {
                data.forEach(s => {
                    sel.innerHTML += `<option value="${s.id}">${s.nombre}</option>`;
                });
            });
    });

    function cargar() {
        const grado_id = document.getElementById('grado').value;
        const seccion_id = document.getElementById('seccion').value;
        if (!grado_id || !seccion_id) {
            alert('Selecciona grado y sección');
            return;
        }
        fetch(`<?= base_url('obtener-alumnas') ?>?grado_id=${grado_id}&seccion_id=${seccion_id}`)
            .then(r => r.json())
            .then(data => {
                const badge = document.getElementById('contadorBadge');
                let html = '';
                if (data.length === 0) {
                    badge.style.display = 'none';
                    html = `<tr><td colspan="3">
                        <div class="empty-state">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="1.5">
                                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                            </svg>
                            <p>No hay alumnas registradas en esta sección</p>
                        </div>
                    </td></tr>`;
                } else {
                    const gradoText = document.getElementById('grado').options[document.getElementById('grado').selectedIndex].text;
                    const seccionText = document.getElementById('seccion').options[document.getElementById('seccion').selectedIndex].text;
                    badge.style.display = 'inline-block';
                    badge.textContent = `${gradoText} · ${seccionText} — ${data.length} alumnas`;
                    data.forEach((a, i) => {
                        html += `<tr>
                            <td class="td-num">${i + 1}</td>
                            <td class="td-dni">${a.dni}</td>
                            <td class="td-nombre">${a.nombre}</td>
                        </tr>`;
                    });
                }
                document.getElementById('tablaAlumnas').innerHTML = html;
            });
    }

    function importar() {
        const grado_id = document.getElementById('grado').value;
        const seccion_id = document.getElementById('seccion').value;
        const file = document.getElementById('excel').files[0];
        if (!file) { alert('Selecciona un archivo Excel'); return; }
        if (!confirm('Se actualizarán las alumnas de esta sección. ¿Deseas continuar?')) return;

        const formData = new FormData();
        formData.append('archivo', file);
        formData.append('grado_id', grado_id);
        formData.append('seccion_id', seccion_id);

        fetch("<?= base_url('importar-alumnas') ?>", { method: 'POST', body: formData })
            .then(r => r.json())
            .then(() => {
                alert('Importación exitosa');
                cargar();
                bootstrap.Modal.getInstance(document.getElementById('modalImportar')).hide();
            });
    }
</script>

<?= $footer ?>