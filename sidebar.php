<?php
session_start();
// proteksi dashboard
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("Location: login.php");
    exit;
}
include 'koneksi.php'; 
 ?>

 <!-- Left Panel -->
    <aside id="left-panel" class="left-panel">
      <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active">
              <a href="dashboard.php"
                ><i class="menu-icon fa fa-desktop"></i>Dashboard
              </a>
            </li>
            <!-- /.menu-title -->
            <li class="menu-item-has-children dropdown">
              <a
                href="#"
                class="dropdown-toggle"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="menu-icon fa fa-database"></i>Data Master</a
              >
              <ul class="sub-menu children dropdown-menu">
                      <li>
                        <i class="fa fa-building"></i>
                        <a href="gedung.php">Gedung</a>
                      </li>
                      <li>
                        <i class="fa fa-user"></i>
                        <a href="peminjam.php">Peminjam</a>
                      </li>
                    </ul>
            </li>
            <li class="menu-item-has-children dropdown">
              <a
                href="#"
                class="dropdown-toggle"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="menu-icon fa fa-exchange"></i>Transaksi</a
              >
              <ul class="sub-menu children dropdown-menu">
                <li>
                  <i class="fa fa-calendar-check-o"></i
                  ><a href="pemesanan.php">Pemesanan</a>
                </li>
               
                </li>
              </ul>
            </li>
            <li class="menu-item-has-children dropdown">
              <a
                href="#"
                class="dropdown-toggle"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="menu-icon fa fa-file-text-o"></i>Laporan</a
              >
              <ul class="sub-menu children dropdown-menu">
                <li>
                  <i class="menu-icon fa fa-file-text"></i
                  ><a href="laporan_pemesanan.php">Laporan Pemesanan</a>
                </li>
               
              </ul>
            </li>
                      
            <li class="menu-title">Extras</li>
            <!-- /.menu-title -->
            <li class="menu-item-has-children dropdown">
              <a
                href="#"
                class="dropdown-toggle"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="menu-icon fa fa-glass"></i>Pages</a
              >
              <ul class="sub-menu children dropdown-menu">
                <li>
                  <i class="menu-icon fa fa-sign-in"></i
                  ><a href="login.php">Login</a>
                </li>
                <li>
                  <i class="menu-icon fa fa-sign-in"></i
                  ><a href="logout.php">Logout</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- /.navbar-collapse -->
      </nav>
    </aside>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
      <!-- Header-->
      <header id="header" class="header">
        <div class="top-left">
          <div class="navbar-header">
            <a class="navbar-brand"
              ><i class="fa fa-building"></i>
            
            <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
          </div>
        </div>
        <div class="top-right">
          <div class="header-menu">
            <div class="header-left">
              <button class="search-trigger">
                <i class="fa fa-search"></i>
              </button>
              <div class="form-inline">
                <form class="search-form">
                  <input
                    class="form-control mr-sm-2"
                    type="text"
                    placeholder="Search ..."
                    aria-label="Search"
                  />
                  <button class="search-close" type="submit">
                    <i class="fa fa-close"></i>
                  </button>
                </form>
              </div>

          
            <div class="user-area dropdown float-right">
              <a
                href="#"
                class="dropdown-toggle active"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <img
                  class="user-avatar rounded-circle"
                  src="images/gedungpink.png"
                  alt="User Avatar"
                />
              </a>

              <div class="user-menu dropdown-menu">
                <a class="nav-link" href="#"
                  >

                <a class="nav-link" href="#"
                  ><i class="fa fa -cog"></i>Settings</a
                >

                <a class="nav-link" href="#"
                  ><i class="fa fa-power -off"></i>Logout</a
                >
              </div>
            </div>
          </div>
        </div>
      </header>