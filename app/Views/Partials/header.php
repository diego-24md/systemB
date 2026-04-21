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

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<style>
    .nav-buscar-libros {
        display: flex;
        align-items: center;
        gap: 10px;

        width: 100%;
        padding: 0.75rem 1rem;

        color: #fff !important;
        border-radius: 0.35rem;

        background: linear-gradient(135deg, #4e73df, #224abe);

        transition: all 0.2s ease;
        text-decoration: none;
    }

    .nav-buscar-libros:hover {
        background: linear-gradient(135deg, #5a8dee, #2e59d9);
        transform: translateX(3px);
    }
</style>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="sidebar-brand-text mx-4"> Sistema de Biblioteca <sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="http://localhost:8080/">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Menú Principal
            </div>

            <!-- CATÁLOGO -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#"
                    data-toggle="collapse"
                    data-target="#collapseCatalogo"
                    aria-expanded="false"
                    aria-controls="collapseCatalogo">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Libros</span>
                </a>
                <div id="collapseCatalogo" class="collapse" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Libros</h6>
                        <a class="collapse-item" href="<?= base_url('libros') ?>">Libros</a>
                    </div>
                </div>
            </li>

            <!-- USUARIOS -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#"
                    data-toggle="collapse"
                    data-target="#collapseUsuarios"
                    aria-expanded="false"
                    aria-controls="collapseUsuarios">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Usuarios</span>
                </a>
                <div id="collapseUsuarios" class="collapse" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Usuarios</h6>
                        <a class="collapse-item" href="<?= base_url('alumnos') ?>">Alumnos</a>
                        <a class="collapse-item" href="<?= base_url('docentes') ?>">Docentes</a>
                    </div>
                </div>
            </li>

            <!-- PRÉSTAMOS -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#"
                    data-toggle="collapse"
                    data-target="#collapsePrestamos"
                    aria-expanded="false"
                    aria-controls="collapsePrestamos">
                    <i class="fas fa-fw fa-book-reader"></i>
                    <span>Préstamos</span>
                </a>
                <div id="collapsePrestamos" class="collapse" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Préstamos</h6>
                        <a class="collapse-item" href="<?= base_url('prestamos') ?>">Registrar préstamo</a>
                        <a class="collapse-item" href="<?= base_url('devoluciones') ?>">Devoluciones</a>
                        <a class="collapse-item" href="<?= base_url('prestamos/activos') ?>">Préstamos activos</a>
                        <a class="collapse-item" href="<?= base_url('prestamos/historial') ?>">Historial</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Reportes</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header"></h6>
                        <a class="collapse-item" href="utilities-color.html">Préstamos pendientes</a>
                        <a class="collapse-item" href="utilities-border.html">Préstamos vencidos</a>
                        <a class="collapse-item" href="utilities-animation.html">Ver historial</a>
                        <a class="collapse-item" href="utilities-other.html">Exportar a PDF</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Sidebar Toggler (Sidebar) -->
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

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
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

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">1+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notificaciones
                                </h6>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Mostrar todas las notificaciones</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Bibliotecario Raúl</span>
                                <img class="img-profile rounded-circle" src="<?= base_url('img/bibliotecario.png') ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
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