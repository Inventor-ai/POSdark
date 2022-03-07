<?php
$session_user = session();

$tabTitle  = $session_user->tabTitle;
$brandName = $session_user->brandName;
$webpage   = $session_user->webpage;


// if ($session_user->nombre == null) {
//     return redirect()->to(base_url().'/');
// }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?= $tabTitle ?></title>
        <link href="<?=base_url('css/datatables/style.css')?>" rel="stylesheet" />
        <link href="<?=base_url('css/styles.css')?>" rel="stylesheet" />
        <link href="<?=base_url('js/jquery-ui/jquery-ui.min.css')?>" rel="stylesheet" />
        <script src="<?=base_url('js/all.min.js')?>"></script>
        <script src="<?=base_url('js/fancy-zoom/FancyZoom.js')?>"></script>
        <script src="<?=base_url('js/fancy-zoom/FancyZoomHTML.js')?>"></script>
        <link href="<?=base_url('assets/dropify/css/dropify.min.css')?>" rel="stylesheet" />
    </head>
    <!-- <body class="sb-nav-fixed" onload="setupZoom()"> -->
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- <div class="sidebar-brand-icon rotate-n-15">
               <i class="fas fa-laugh-wink"></i>
            </div> -->
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="<?=$webpage?>" target="blank"><?= $brandName ?></a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <!--
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            -->
            <!-- <div class="sb-sidenav-footer"> -->
            <!-- <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"> -->
            <!-- <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"> -->
             <!-- edit it to display this -->
            <!-- <div class="sb-nav-link-icon"> -->
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto me-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <!-- <div class="d-none d-md-inline-block">Start Bootstrap</div> -->
                        <?=substr($session_user->nombre, 0, 15)?>
                        <!-- Start Bootstrap
                        123456789012345 -->
                        <i class="fas fa-user fa-fw"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?=base_url('usuarios/cambia_password')?>">
                           <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Cambiar contraseña
                        </a></li>
                        <li><a class="dropdown-item" href="#!">
                           <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Activity Log
                        </a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="<?=base_url()?>/usuarios/logout">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Cerrar sesión
                        </a></li>
                    </ul>
                </li>
<!-- ***
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
*** -->
            </ul>
        </nav>
        <div id="layoutSidenav">
          <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
              <div class="sb-sidenav-menu">
                <div class="nav">
                  <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseArticulos" aria-expanded="false" aria-controls="collapseArticulos">
                    <div class="sb-nav-link-icon"></div>
                     <i class="fas fa-dolly"></i>&nbsp; Artículos
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                  </a>
                  <div class="collapse" id="collapseArticulos" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                      <a class="nav-link" href="<?=base_url()?>/articulos">Artículos</a>
                      <a class="nav-link" href="<?=base_url()?>/unidades">Unidades</a>
                      <a class="nav-link" href="<?=base_url()?>/categorias">Categorias</a>
                    </nav>
                  </div>
                </div>
                <a class="nav-link" href="<?=base_url()?>/clientes"><i class="fas fa-users"></i>  Clientes</a>
                <div class="nav">
                  <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCompras" aria-expanded="false" aria-controls="collapseCompras">
                    <div class="sb-nav-link-icon"><i class="fas fa-truck"></i></div>
                      Compras
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                  </a>
                  <div class="collapse" id="collapseCompras" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                      <a class="nav-link" href="<?=base_url()?>/compras/nueva">Nueva compra</a>
                      <a class="nav-link" href="<?=base_url()?>/compras">Compras</a>
                    </nav>
                  </div>
                </div>
                <a class="nav-link" href="<?=base_url()?>/ventas/venta"><i class="fas fa-cash-register"></i>  Caja</a>
                <a class="nav-link" href="<?=base_url()?>/ventas/index"><i class="fas fa-shopping-cart"></i>  Ventas</a>
                <div class="nav">
                  <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAdmon" aria-expanded="false" aria-controls="collapseAdmon">
                    <div class="sb-nav-link-icon"><i class="fas fa-tools"></i></div>
                      Administración
                     <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                  </a>
                  <div class="collapse" id="collapseAdmon" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                      <a class="nav-link" href="<?=base_url()?>/configurar">Configuración</a>
                      <a class="nav-link" href="<?=base_url()?>/usuarios">Usuarios</a>
                      <a class="nav-link" href="<?=base_url()?>/roles">Roles</a>
                      <a class="nav-link" href="<?=base_url()?>/cajas">Cajas</a>
                    </nav>
                  </div>

                  <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
                    <div class="sb-nav-link-icon"><i class="fas fa-dolly"></i></div>
                      Users
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                  </a>
                  <div class="collapse" id="collapseUsers" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                      <a class="nav-link" href="<?=base_url()?>/users">Usuarios.</a>
                      <a class="nav-link" href="<?=base_url()?>/users/cambia_password">Cambiar contraseña.</a>
                    </nav>
                  </div>

                </div>
              </div>
            </nav>
          </div>
          <div id="layoutSidenav_content">
            <main>
              <div class="container-fluid px-4">
              <?php //var_dump ($session_user->mainWebPg) ?>