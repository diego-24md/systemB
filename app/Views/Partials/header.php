<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Proyecto de Innovación</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Tom Select -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="http://localhost:8080/">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="sidebar-brand-text mx-4">Sistema de Biblioteca <sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="http://localhost:8080/">
                    <i class="fas fa-fw fa-laptop"></i>
                    <span>Pantalla de Inicio</span>
                </a>
            </li>

            <hr class="sidebar-divider my-0">
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">Menú Principal</div>

            <!-- LIBROS -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCatalogo"
                    aria-expanded="false" aria-controls="collapseCatalogo">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Libros</span>
                </a>
                <div id="collapseCatalogo" class="collapse" data-parent="#accordionSidebar">
                    <div class="py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Libros</h6>
                        <a class="collapse-item" href="<?= base_url('libros') ?>">Libros</a>
                    </div>
                </div>
            </li>

            <!-- USUARIOS -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsuarios"
                    aria-expanded="false" aria-controls="collapseUsuarios">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Usuarios</span>
                </a>
                <div id="collapseUsuarios" class="collapse" data-parent="#accordionSidebar">
                    <div class="py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Usuarios</h6>
                        <a class="collapse-item" href="<?= base_url('alumnas') ?>">Alumnas</a>
                    </div>
                </div>
            </li>

            <!-- PRÉSTAMOS -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePrestamos"
                    aria-expanded="false" aria-controls="collapsePrestamos">
                    <i class="fas fa-fw fa-book-reader"></i>
                    <span>Préstamos</span>
                </a>
                <div id="collapsePrestamos" class="collapse" data-parent="#accordionSidebar">
                    <div class="py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Préstamos</h6>
                        <a class="collapse-item" href="<?= base_url('prestamos') ?>">Registrar préstamo</a>
                        <a class="collapse-item" href="<?= base_url('prestamos/devoluciones') ?>">Devoluciones</a>
                        <a class="collapse-item" href="<?= base_url('prestamos/historial') ?>">Ver Historial</a>
                        <a class="collapse-item" href="<?= base_url('prestamos/ranking') ?>">Ranking</a>
                    </div>
                </div>
            </li>

            <!-- EXPORTAR -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="false" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-file-export"></i>
                    <span>Exportar</span>
                </a>
                <div id="collapseUtilities" class="collapse" data-parent="#accordionSidebar">
                    <div class="py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Descargar Historial</h6>
                        <a class="collapse-item" href="utilities-other.html">Exportar a PDF</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider">

            <!-- Sidebar Toggler -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Search XS -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <?php
                        $notifModel = new \App\Models\NotificacionesModel();
                        $notificaciones = $notifModel->getNoLeidas();
                        $totalNoLeidas  = $notifModel->contarNoLeidas();
                        ?>

                        <!-- NOTIFICACIONES -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <?php if ($totalNoLeidas > 0): ?>
                                    <span class="badge badge-danger badge-counter">
                                        <?= $totalNoLeidas > 9 ? '9+' : $totalNoLeidas ?>
                                    </span>
                                <?php endif; ?>
                            </a>

                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header d-flex justify-content-between align-items-center">
                                    <span>Notificaciones</span>
                                    <?php if ($totalNoLeidas > 0): ?>
                                        <div>
                                            <span class="badge badge-light mr-2"><?= $totalNoLeidas ?> nuevas</span>
                                            <a href="#" id="marcarTodasBtn" class="small text-warning" style="font-size:11px;">
                                                Marcar todas ✓
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </h6>

                                <div id="lista-notificaciones">
                                    <?php if (!empty($notificaciones)): ?>
                                        <?php foreach ($notificaciones as $n): ?>
                                            <a class="dropdown-item d-flex align-items-center notif-item"
                                                data-id="<?= $n['id'] ?>"
                                                href="#"
                                                style="cursor:pointer; transition: all 0.4s ease;">
                                                <div class="mr-3">
                                                    <div class="icon-circle bg-<?= esc((string)$n['color']) ?>">
                                                        <i class="<?= esc((string)$n['icono']) ?> text-white"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="small text-gray-500">
                                                        <?= date('d/m/Y H:i', strtotime((string)$n['created_at'])) ?>
                                                    </div>
                                                    <span class="font-weight-bold"><?= esc((string)$n['mensaje']) ?></span>
                                                </div>
                                                <div class="ml-2">
                                                    <span class="badge badge-pill badge-primary small">Nueva</span>
                                                </div>
                                            </a>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="dropdown-item text-center small text-gray-500 py-3" id="sin-notificaciones">
                                            <i class="fas fa-check-circle text-success mr-1"></i>
                                            Sin notificaciones nuevas
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <a class="dropdown-item text-center small text-gray-500"
                                    href="<?= base_url('notificaciones') ?>">
                                    Mostrar todas las notificaciones
                                </a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= session()->get('nombre') ?? 'Bibliotecario' ?></span>
                                <img class="img-profile rounded-circle"
                                    src="<?= base_url('uploads/perfiles/' . (session()->get('foto') ?? 'perfil.png')) ?>">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= base_url('perfil') ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('logout') ?>">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cerrar Sesión
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- JavaScript Notificaciones -->
                    <script>
                        document.addEventListener('click', function(e) {
                            const item = e.target.closest('.notif-item');
                            if (!item) return;

                            e.preventDefault();
                            e.stopPropagation();
                            const id = item.dataset.id;

                            item.style.opacity = '0';
                            item.style.transform = 'translateX(20px)';

                            setTimeout(() => {
                                item.remove();
                                actualizarContador(-1);
                                verificarVacia();
                            }, 400);

                            fetch('<?= base_url('notificaciones/marcar/') ?>' + id, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            });
                        });

                        const marcarTodasBtn = document.getElementById('marcarTodasBtn');
                        if (marcarTodasBtn) {
                            marcarTodasBtn.addEventListener('click', function(e) {
                                e.preventDefault();
                                e.stopPropagation();

                                const items = document.querySelectorAll('.notif-item');
                                items.forEach((item, i) => {
                                    setTimeout(() => {
                                        item.style.opacity = '0';
                                        item.style.transform = 'translateX(20px)';
                                        setTimeout(() => item.remove(), 400);
                                    }, i * 80);
                                });

                                setTimeout(() => {
                                    actualizarContador(-items.length);
                                    verificarVacia();
                                }, items.length * 80 + 400);

                                fetch('<?= base_url('notificaciones/marcarTodas') ?>', {
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                });
                            });
                        }

                        function actualizarContador(cambio) {
                            const badge = document.querySelector('.badge-counter');
                            const badgeHeader = document.querySelector('.badge-light');
                            if (!badge) return;

                            let count = parseInt(badge.textContent) || 0;
                            count = Math.max(0, count + cambio);

                            if (count <= 0) {
                                badge.remove();
                                if (badgeHeader) badgeHeader.parentElement.remove();
                            } else {
                                badge.textContent = count > 9 ? '9+' : count;
                                if (badgeHeader) badgeHeader.textContent = count + ' nuevas';
                            }
                        }

                        function verificarVacia() {
                            const items = document.querySelectorAll('.notif-item');
                            if (items.length === 0) {
                                const lista = document.getElementById('lista-notificaciones');
                                lista.innerHTML = `
                                    <div class="dropdown-item text-center small text-gray-500 py-3">
                                        <i class="fas fa-check-circle text-success mr-1"></i>
                                        Sin notificaciones nuevas
                                    </div>`;
                            }
                        }
                    </script>