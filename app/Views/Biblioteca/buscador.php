<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Biblioteca Chinchaysuyo</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: sans-serif; background: #f5f5f5; color: #111; }

    @keyframes fadeInDown {
      from { opacity: 0; transform: translateY(-10px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(12px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes scaleIn {
      from { opacity: 0; transform: scale(0.93); }
      to   { opacity: 1; transform: scale(1); }
    }

    .header {
      background: linear-gradient(135deg, #0C447C 0%, #185FA5 60%, #378ADD 100%);
      padding: 1.4rem 1.5rem;
      display: flex;
      align-items: center;
      gap: 14px;
      animation: fadeInDown 0.5s ease both;
    }
    .header-icon {
      width: 44px; height: 44px;
      background: rgba(255,255,255,0.18);
      border: 1px solid rgba(255,255,255,0.3);
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      color: #fff;
      font-size: 20px;
      flex-shrink: 0;
      transition: transform 0.3s ease;
    }
    .header-icon:hover { transform: rotate(-8deg) scale(1.1); }
    .header-title { font-size: 16px; font-weight: 500; color: #fff; letter-spacing: 0.01em; }
    .header-sub { font-size: 12px; color: rgba(255,255,255,0.7); margin-top: 2px; }

    .search-bar {
      padding: 1.1rem 1.5rem 0.6rem;
      display: flex; gap: 8px;
      background: #fff;
      animation: fadeInDown 0.5s 0.1s ease both;
    }
    .search-wrap { position: relative; flex: 1; }
    .search-wrap i {
      position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
      color: #888; font-size: 14px;
      transition: color 0.2s;
    }
    .search-wrap input {
      width: 100%; padding: 0 12px 0 34px;
      height: 38px;
      border: 1.5px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      background: #fff;
      color: #111;
      outline: none;
      transition: border-color 0.25s, box-shadow 0.25s;
    }
    .search-wrap input:focus {
      border-color: #185FA5;
      box-shadow: 0 0 0 3px rgba(24,95,165,0.18);
    }
    .search-wrap:focus-within i { color: #185FA5; }

    .filters {
      padding: 0.6rem 1.5rem 1rem;
      display: flex; gap: 8px; flex-wrap: wrap;
      background: #fff;
      border-bottom: 0.5px solid #ddd;
      animation: fadeInDown 0.5s 0.15s ease both;
    }
    .filter-btn {
      border: 1.5px solid #ccc;
      background: #fff;
      color: #555;
      border-radius: 20px;
      padding: 5px 13px;
      font-size: 12px;
      cursor: pointer;
      display: flex; align-items: center; gap: 6px;
      transition: background 0.2s, color 0.2s, border-color 0.2s, transform 0.15s, box-shadow 0.2s;
    }
    .filter-btn:hover {
      background: #f0f0f0;
      transform: translateY(-1px);
      box-shadow: 0 2px 8px rgba(24,95,165,0.10);
    }
    .filter-btn:active { transform: scale(0.96); }
    .filter-btn.active {
      background: #185FA5;
      color: #E6F1FB;
      border-color: #185FA5;
      box-shadow: 0 2px 10px rgba(24,95,165,0.25);
    }

    .results-header {
      padding: 0.6rem 1.5rem;
      font-size: 12px;
      color: #888;
      background: #fff;
      border-bottom: 0.5px solid #ddd;
    }

    .book-list { background: #fff; }

    .book-item {
      display: flex; align-items: flex-start; gap: 13px;
      padding: 0.9rem 1.5rem;
      border-bottom: 0.5px solid #eee;
      cursor: pointer;
      transition: background 0.18s, transform 0.18s;
      animation: fadeInUp 0.35s ease both;
    }
    .book-item:hover {
      background: #f7f9fc;
      transform: translateX(3px);
    }
    .book-item:active { transform: scale(0.99); }

    .book-cover {
      width: 42px; height: 56px;
      border-radius: 5px;
      display: flex; align-items: center; justify-content: center;
      font-size: 17px;
      flex-shrink: 0;
      color: #fff;
      transition: transform 0.25s;
      position: relative;
      overflow: hidden;
    }
    .book-cover::after {
      content: '';
      position: absolute; top: 0; left: -100%; width: 60%; height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
      transition: left 0.4s;
    }
    .book-item:hover .book-cover        { transform: scale(1.07) rotate(-2deg); }
    .book-item:hover .book-cover::after { left: 160%; }

    .book-info { flex: 1; min-width: 0; }
    .book-title  { font-size: 14px; font-weight: 500; color: #111; line-height: 1.4; }
    .book-author { font-size: 12px; color: #666; margin-top: 2px; }
    .book-meta   { display: flex; gap: 8px; margin-top: 6px; flex-wrap: wrap; }
    .badge {
      font-size: 11px; padding: 2px 9px;
      border-radius: 10px; font-weight: 400;
      transition: transform 0.15s;
    }
    .badge:hover { transform: scale(1.05); }
    .badge-cat   { background: #E6F1FB; color: #0C447C; }
    .badge-avail { background: #EAF3DE; color: #27500A; }
    .badge-loan  { background: #FAEEDA; color: #633806; }
    .book-code   { font-size: 11px; color: #aaa; margin-top: 4px; }

    .status-icon { font-size: 13px; padding-top: 4px; transition: transform 0.2s; }
    .avail-icon  { color: #3B6D11; }
    .loan-icon   { color: #854F0B; }
    .book-item:hover .status-icon { transform: scale(1.2); }

    .empty {
      padding: 3rem 1.5rem;
      text-align: center;
      color: #888;
      font-size: 14px;
      animation: fadeInUp 0.3s ease both;
    }
    .empty i { font-size: 32px; margin-bottom: 1rem; display: block; color: #ccc; }

    .modal-bg {
      display: none;
      position: fixed; top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(4,44,83,0.45);
      backdrop-filter: blur(2px);
      z-index: 100;
      align-items: center; justify-content: center;
    }
    .modal-bg.open { display: flex; }
    .modal {
      background: #fff;
      border-radius: 12px;
      border: 0.5px solid #ddd;
      padding: 1.5rem;
      max-width: 380px; width: 90%;
      position: relative;
      animation: scaleIn 0.25s cubic-bezier(.34,1.4,.64,1) both;
      box-shadow: 0 8px 40px rgba(4,44,83,0.18);
    }
    .modal-close {
      position: absolute; top: 12px; right: 14px;
      background: none; border: none; cursor: pointer;
      color: #888; font-size: 16px;
      transition: color 0.2s, transform 0.2s;
    }
    .modal-close:hover { color: #E24B4A; transform: rotate(90deg); }
    .modal-cover {
      width: 58px; height: 78px;
      border-radius: 7px;
      display: flex; align-items: center; justify-content: center;
      font-size: 24px; color: #fff;
      margin-bottom: 1rem;
      transition: transform 0.3s;
      position: relative; overflow: hidden;
    }
    .modal-cover::after {
      content: '';
      position: absolute; top: 0; left: 0; right: 0; height: 40%;
      background: linear-gradient(to bottom, rgba(255,255,255,0.18), transparent);
      border-radius: 7px 7px 0 0;
    }
    .modal-cover:hover { transform: scale(1.06) rotate(-3deg); }
    .modal-title  { font-size: 16px; font-weight: 500; color: #111; margin-bottom: 4px; }
    .modal-author { font-size: 13px; color: #666; margin-bottom: 1rem; }
    .modal-row {
      display: flex; gap: 8px; margin-bottom: 6px; font-size: 13px; align-items: center;
      padding: 5px 8px; border-radius: 8px;
      transition: background 0.15s;
    }
    .modal-row:hover { background: #f7f9fc; }
    .modal-label { color: #888; min-width: 90px; }
    .modal-val   { color: #111; }
    .modal-divider { border: none; border-top: 0.5px solid #eee; margin: 1rem 0; }
  </style>
</head>
<body>

<div class="header">
  <div class="header-icon"><i class="fa-solid fa-book-open"></i></div>
  <div>
    <div class="header-title">Biblioteca Chinchaysuyo</div>
    <div class="header-sub">Catalogo de libros</div>
  </div>
</div>

<div class="search-bar">
  <div class="search-wrap">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="text" id="searchInput" placeholder="Buscar por titulo, autor o codigo...">
  </div>
</div>

<div class="filters">
  <button class="filter-btn active" data-cat="all"><i class="fa-solid fa-border-all"></i> Todos</button>
  <button class="filter-btn" data-cat="Ciencias"><i class="fa-solid fa-flask"></i> Ciencias</button>
  <button class="filter-btn" data-cat="Literatura"><i class="fa-solid fa-feather-pointed"></i> Literatura</button>
  <button class="filter-btn" data-cat="Historia"><i class="fa-solid fa-landmark"></i> Historia</button>
  <button class="filter-btn" data-cat="Matematica"><i class="fa-solid fa-square-root-variable"></i> Matematica</button>
  <button class="filter-btn" data-cat="Arte"><i class="fa-solid fa-palette"></i> Arte</button>
</div>

<div class="results-header" id="resultsCount">Cargando...</div>
<div class="book-list" id="bookList"></div>

<div class="modal-bg" id="modalBg">
  <div class="modal">
    <button class="modal-close" id="modalClose"><i class="fa-solid fa-xmark"></i></button>
    <div class="modal-cover" id="mCover"></div>
    <div class="modal-title" id="mTitle"></div>
    <div class="modal-author" id="mAuthor"></div>
    <hr class="modal-divider">
    <div class="modal-row"><span class="modal-label"><i class="fa-solid fa-tag" style="margin-right:6px"></i>Categoria</span><span class="modal-val" id="mCat"></span></div>
    <div class="modal-row"><span class="modal-label"><i class="fa-solid fa-barcode" style="margin-right:6px"></i>Codigo</span><span class="modal-val" id="mCode"></span></div>
    <div class="modal-row"><span class="modal-label"><i class="fa-solid fa-calendar" style="margin-right:6px"></i>Año</span><span class="modal-val" id="mYear"></span></div>
    <div class="modal-row"><span class="modal-label"><i class="fa-solid fa-layer-group" style="margin-right:6px"></i>Ejemplares</span><span class="modal-val" id="mCopies"></span></div>
    <div class="modal-row"><span class="modal-label"><i class="fa-solid fa-circle-check" style="margin-right:6px"></i>Estado</span><span class="modal-val" id="mStatus"></span></div>
  </div>
</div>

<script>
const BOOKS = [
  { id:1,  title:"El Principito",                    author:"Antoine de Saint-Exupery",  cat:"Literatura",  code:"LIT-001", year:1943, copies:3, available:true,  color:"#185FA5" },
  { id:2,  title:"Cien años de soledad",              author:"Gabriel Garcia Marquez",     cat:"Literatura",  code:"LIT-002", year:1967, copies:2, available:false, color:"#185FA5" },
  { id:3,  title:"Fisica para ciencias e ingenieria", author:"Serway & Jewett",            cat:"Ciencias",    code:"CIE-001", year:2014, copies:4, available:true,  color:"#1D9E75" },
  { id:4,  title:"Biologia",                          author:"Campbell & Reece",           cat:"Ciencias",    code:"CIE-002", year:2018, copies:3, available:true,  color:"#1D9E75" },
  { id:5,  title:"Historia del Peru",                 author:"Jorge Basadre Grohmann",     cat:"Historia",    code:"HIS-001", year:1983, copies:2, available:true,  color:"#BA7517" },
  { id:6,  title:"La conquista del Imperio Inca",     author:"John Hemming",               cat:"Historia",    code:"HIS-002", year:1970, copies:1, available:false, color:"#BA7517" },
  { id:7,  title:"Algebra lineal y sus aplicaciones", author:"David C. Lay",               cat:"Matematica",  code:"MAT-001", year:2012, copies:5, available:true,  color:"#7F77DD" },
  { id:8,  title:"Calculo diferencial e integral",    author:"James Stewart",              cat:"Matematica",  code:"MAT-002", year:2016, copies:4, available:true,  color:"#7F77DD" },
  { id:9,  title:"Historia del arte",                 author:"Ernst Gombrich",             cat:"Arte",        code:"ART-001", year:1950, copies:2, available:true,  color:"#D4537E" },
  { id:10, title:"Taller de escritura creativa",      author:"Gianni Rodari",              cat:"Literatura",  code:"LIT-003", year:1973, copies:2, available:true,  color:"#185FA5" },
  { id:11, title:"Quimica general",                   author:"Chang & Goldsby",            cat:"Ciencias",    code:"CIE-003", year:2013, copies:3, available:false, color:"#1D9E75" },
  { id:12, title:"La ciudad y los perros",            author:"Mario Vargas Llosa",         cat:"Literatura",  code:"LIT-004", year:1963, copies:2, available:true,  color:"#185FA5" },
];

let activeFilter = "all";
let searchQuery = "";

function renderBooks() {
  const list  = document.getElementById("bookList");
  const count = document.getElementById("resultsCount");

  const filtered = BOOKS.filter(b => {
    const matchCat = activeFilter === "all" || b.cat === activeFilter;
    const q = searchQuery.toLowerCase();
    const matchQ = !q || b.title.toLowerCase().includes(q) || b.author.toLowerCase().includes(q) || b.code.toLowerCase().includes(q);
    return matchCat && matchQ;
  });

  count.textContent = filtered.length === 1 ? "1 resultado" : `${filtered.length} resultados`;

  if (filtered.length === 0) {
    list.innerHTML = `<div class="empty"><i class="fa-solid fa-box-open"></i>No se encontraron libros con ese criterio.</div>`;
    return;
  }

  list.innerHTML = filtered.map((b, i) => `
    <div class="book-item" style="animation-delay:${i * 0.045}s" onclick="openModal(${b.id})">
      <div class="book-cover" style="background:${b.color}"><i class="fa-solid fa-book"></i></div>
      <div class="book-info">
        <div class="book-title">${b.title}</div>
        <div class="book-author">${b.author}</div>
        <div class="book-meta">
          <span class="badge badge-cat">${b.cat}</span>
          ${b.available
            ? `<span class="badge badge-avail"><i class="fa-solid fa-circle-check" style="margin-right:4px"></i>Disponible</span>`
            : `<span class="badge badge-loan"><i class="fa-solid fa-clock" style="margin-right:4px"></i>En prestamo</span>`}
        </div>
        <div class="book-code">${b.code} &bull; ${b.year}</div>
      </div>
      <span class="status-icon ${b.available ? 'avail-icon' : 'loan-icon'}">
        <i class="fa-solid ${b.available ? 'fa-check' : 'fa-hourglass-half'}"></i>
      </span>
    </div>
  `).join("");
}

function openModal(id) {
  const b = BOOKS.find(x => x.id === id);
  document.getElementById("mCover").style.background = b.color;
  document.getElementById("mCover").innerHTML = `<i class="fa-solid fa-book" style="font-size:24px"></i>`;
  document.getElementById("mTitle").textContent  = b.title;
  document.getElementById("mAuthor").textContent = b.author;
  document.getElementById("mCat").textContent    = b.cat;
  document.getElementById("mCode").textContent   = b.code;
  document.getElementById("mYear").textContent   = b.year;
  document.getElementById("mCopies").textContent = b.copies + " ejemplar(es)";
  document.getElementById("mStatus").innerHTML   = b.available
    ? `<span style="color:#3B6D11"><i class="fa-solid fa-circle-check" style="margin-right:4px"></i>Disponible</span>`
    : `<span style="color:#854F0B"><i class="fa-solid fa-hourglass-half" style="margin-right:4px"></i>En prestamo</span>`;
  document.getElementById("modalBg").classList.add("open");
}

document.getElementById("modalClose").onclick = () => document.getElementById("modalBg").classList.remove("open");
document.getElementById("modalBg").onclick = (e) => { if (e.target === e.currentTarget) e.currentTarget.classList.remove("open"); };

document.getElementById("searchInput").addEventListener("input", e => {
  searchQuery = e.target.value;
  renderBooks();
});

document.querySelectorAll(".filter-btn").forEach(btn => {
  btn.addEventListener("click", () => {
    document.querySelectorAll(".filter-btn").forEach(b => b.classList.remove("active"));
    btn.classList.add("active");
    activeFilter = btn.dataset.cat;
    renderBooks();
  });
});

renderBooks();
</script>
</body>
</html>