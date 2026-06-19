<?php
session_start();
// proteksi dashboard
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$tarifKapasitas = [
    50 => 500000,
    100 => 1000000,
    200 => 1500000,
    300 => 2000000,
    400 => 2500000,
    500 => 3000000
];

// hitung data

$qPemesanan = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pemesanan");

$pemesanan = mysqli_fetch_assoc($qPemesanan)['total'];

// Hitung total kapasitas semua gedung
$totalKapasitas = 0;
$qKapasitas = mysqli_query($koneksi, "SELECT kapasitas FROM gedung");
if ($qKapasitas) {
    while($row = mysqli_fetch_assoc($qKapasitas)) {
        $totalKapasitas += $row['kapasitas'];
    }
}

// === Fungsi mapping tarif berdasarkan kapasitas ===
function tarif_per_kapasitas($kapasitas) {
    if ($kapasitas <= 50) return 500000;
    if ($kapasitas <= 100) return 1000000;
    if ($kapasitas <= 200) return 1500000;
    if ($kapasitas <= 300) return 2000000;
    if ($kapasitas <= 400) return 2500000;
    if ($kapasitas <= 500) return 3000000;
    return 0;
}

// Hitung total tarif gedung
$totalTarif = 0;
$qTarif = mysqli_query($koneksi, "SELECT kapasitas FROM gedung");
if ($qTarif) {
    while($row = mysqli_fetch_assoc($qTarif)) {
        $totalTarif += tarif_per_kapasitas($row['kapasitas']);
    }
} else {
    $totalTarif = 0; // jika query gagal
}

$qTotalPemesanan = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pemesanan");
$totalPemesanan = mysqli_fetch_assoc($qTotalPemesanan)['total'];

$qRuanganDigunakan = mysqli_query($koneksi, "
    SELECT COUNT(DISTINCT id_gedung) AS total
    FROM pemesanan
    WHERE CURDATE() >= DATE(tanggal_mulai)
      AND CURDATE() <= DATE(tanggal_selesai)
");
$ruanganDigunakan = mysqli_fetch_assoc($qRuanganDigunakan)['total'];


$totalRuangan = 4; 



?>


<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="">
  <!--<![endif]-->
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Ela Admin - HTML5 Admin Template</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png" />
    <link rel="shortcut icon" href="https://i.imgur.com/QRAUqs9.png" />

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css"
    />
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
    <link
      href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css"
      rel="stylesheet"
    />

    <link
      href="https://cdn.jsdelivr.net/npm/weathericons@2.1.0/css/weather-icons.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css"
      rel="stylesheet"
    />

    <style>

      body {
  background-color: #fffde8ff; /* soft pink, ganti sesuai selera */
}

      #weatherWidget .currentDesc {
        color: #ffffff !important;
      }
      .traffic-chart {
        min-height: 335px;
      }
      #flotPie1 {
        height: 150px;
      }
      #flotPie1 td {
        padding: 3px;
      }
      #flotPie1 table {
        top: 20px !important;
        right: -10px !important;
      }
      .chart-container {
        display: table;
        min-width: 270px;
        text-align: left;
        padding-top: 10px;
        padding-bottom: 10px;
      }
      #flotLine5 {
        height: 105px;
      }

      #flotBarChart {
        height: 150px;
      }
      #cellPaiChart {
        height: 160px;
      }

      .navbar-brand img {
  max-height: 80px;
  width: auto;
}

.welcome-card {
  border-radius: 12px;
  border: none;
}

.welcome-title {
  font-size: 20px;
  color: #333;
  margin-bottom: 5px;
}

.welcome-name {
  color: #ff006aff;
  font-weight: bold;
  margin-bottom: 10px;
}

.welcome-desc {
  color: #555;
  font-size: 14px;
  line-height: 1.6;
}

.welcome-img {
  max-width: 220px;
}

/* CARD PINK ESTETIK */
.card-pink {
    background: linear-gradient(135deg, #ff006aff);
    border-radius: 18px;
    border: none;
    box-shadow: 0 10px 25px rgba(255, 242, 247, 0.64);
    color: #fff;
    transition: all 0.3s ease;
}

.card-pink:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 35px rgba(255, 211, 233, 0.45);
}

/* ICON */
.card-pink .stat-icon {
    background: rgba(255,255,255,0.25);
    color: #fff;
    border-radius: 50%;
    width: 55px;
    height: 55px;
    line-height: 55px;
    text-align: center;
    font-size: 26px;
}

/* JUDUL */
.card-pink .stat-heading {
    font-size: 17px;
    font-weight: 700;
    margin-bottom: 8px;
}

/* LIST TARIF */
.card-pink ul {
    margin: 0;
}
    /* PAKSA SEMUA TEKS PUTIH */
.card-pink,
.card-pink * {
    color: #ffffff !important;
}

.card-pink ul li {
    font-size: 14px;
    opacity: 0.95;
}

.card-pink ul li {
    font-size: 14px;
    margin-bottom: 4px;
    opacity: 0.95;
}

/* UKURAN CARD SEDANG */
.card-pink {
    min-height: 190px;          /* tinggi sedang */
    padding: 6px;               /* nafas di dalam card */
}

.card-pink .card-body {
    padding: 20px 18px;         /* isi lebih lega */
}

/* JARAK ICON & TEKS */
.card-pink .stat-widget-five {
    align-items: center;
}

.card-pink .stat-icon {
    margin-right: 12px;
}


/* ===============================
   CARD DASHBOARD PERSEGI (FIX)
================================ */
.stat-card {
  height: 170px;
  border-radius: 14px;
  border: none;
  box-shadow: 0 8px 22px rgba(0,0,0,0.08);
}

.stat-body {
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.stat-icon i {
  font-size: 36px;
  color: #ff006aff;
}

.stat-number {
  font-size: 36px;
  font-weight: 700;
}

.stat-title {
  font-size: 14px;
  color: #777;
}


/* CARD STAT */
.stat-card {
  border-radius: 12px;
  border: none;
  box-shadow: 0 6px 18px rgba(0,0,0,0.08);
}

/* ICON TENGAH */
.stat-card .stat-icon i {
  font-size: 34px;
  color: #ff006aff;
}

/* ANGKA */
.stat-card h2 {
  font-size: 36px;
  font-weight: 700;
  margin: 6px 0;
}

/* BADGE HARI INI */
.badge-hari-ini {
  background: linear-gradient(135deg,#ff006aff);
  color: #fff;
  font-size: 11px;
  padding: 4px 8px;
  border-radius: 12px;
  margin-left: 6px;
}

/* ===== STAT CARD ===== */
.stat-card {
  border: none;
  border-radius: 14px;
  height: 170px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 8px 22px rgba(0,0,0,0.08);
  transition: all 0.3s ease;
}

.stat-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 30px rgba(255,79,139,0.25);
}

/* ICON */
.stat-icon i {
  font-size: 38px;
  color: #ff006aff;
}

/* ANGKA */
.stat-number {
  font-size: 36px;
  font-weight: 700;
  margin: 8px 0 4px;
  color: #222;
}

/* JUDUL */
.stat-title {
  font-size: 14px;
  color: #777;
  font-weight: 500;
}

/* =========================
   CARD TARIF GEDUNG
========================= */
.tarif-card {
  border: none;
  border-radius: 16px;
  background: linear-gradient(135deg, #ff006aff);
  color: #fff;
  box-shadow: 0 10px 28px rgba(255,79,139,0.35);
}

/* HEADER */
.tarif-header {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 14px;
}

.tarif-header i {
  font-size: 32px;
  background: rgba(255,255,255,0.25);
  padding: 10px;
  border-radius: 50%;
}

.tarif-header h5 {
  margin: 0;
  font-weight: 700;
}

/* LIST TARIF */
.tarif-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.tarif-list li {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 6px 0;
  font-size: 14px;
  border-bottom: 1px dashed rgba(255,255,255,0.4);
}

.tarif-list li:last-child {
  border-bottom: none;
}

/* SEMUA TEKS PUTIH */
.tarif-card * {
  color: #fff !important;
}

/* =========================
   CARD JENIS RUANGAN - PINK
========================= */
.jenis-ruangan-card {
  border: none;
  border-radius: 18px;
  background: linear-gradient(135deg,#ff006aff); /* pink gradient */
  color: #fff;
  box-shadow: 0 12px 30px rgba(255, 79, 139, 0.25);
  transition: all 0.3s ease;
}

.jenis-ruangan-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 18px 35px rgba(255, 79, 139, 0.45);
}

/* HEADER */
.jenis-ruangan-card .tarif-header {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 16px;
}

.jenis-ruangan-card .tarif-header i {
  font-size: 32px;
  background: rgba(255,255,255,0.25);
  padding: 12px;
  border-radius: 50%;
}

/* JUDUL HEADER */
.jenis-ruangan-card .tarif-header h5 {
  margin: 0;
  font-weight: 700;
  font-size: 18px;
}

/* LIST JENIS RUANGAN */
.jenis-ruangan-card .tarif-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.jenis-ruangan-card .tarif-list li {
  padding: 8px 0;
  font-size: 15px;
  border-bottom: 1px dashed rgba(255,255,255,0.4);
  display: flex;
  align-items: center;
}

.jenis-ruangan-card .tarif-list li:last-child {
  border-bottom: none;
}

/* ICON BULLET CUSTOM */
.jenis-ruangan-card .tarif-list li::before {
  content: '•';
  margin-right: 10px;
  color: rgba(255,255,255,0.9);
  font-size: 18px;
}

/* SEMUA TEKS PUTIH */
.jenis-ruangan-card * {
  color: #fff !important;
}


.tarif-card.active {
  opacity: 1;
  transform: translateY(0);
}

.tarif-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 18px 35px rgba(255,79,139,0.45);
}

.card {
  overflow: visible;
}

    </style>
  </head>

  <body>
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


                <a class="nav-link" href="logout.php"
                  ><i class="fa fa-power-off"></i>Logout</a>
              </div>
            </div>
          </div>
        </div>
      </header>
      <!-- /#header -->
      <!-- Content -->
      <div class="content">
        <!-- Animated -->
        <div class="animated fadeIn">

         <!--  Traffic  -->
         <div class="row">
  <div class="col-lg-11">
    <div class="card welcome-card">
      <div class="card-body">
        <div class="row align-items-center">

          <!-- TEXT -->
          <div class="col-md-8">
            <h4 class="welcome-title">Selamat Datang</h4>
            <h2 class="welcome-name">Revaliza</h2>
            <p class="welcome-desc">
              Selamat Datang
Selamat Datang di Sistem Pemesanan Gedung Pertemuan Karawaci.<br>
Platform ini membantu Anda memesan gedung pertemuan,<br>
mengatur jadwal acara, dan memastikan ketersediaan gedung
dengan lebih praktis dan efisien.</p></div>

          <!-- IMAGE -->
          <div class="col-md-2 text-center">
            <img src="images/gedungpink.png" 
                class="gedungpink-img">
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
          <!-- Widgets  -->
    <!-- Widgets -->
<div class="row mt-4">

  <div class="col-lg-4 col-md-6 mb-4">
    <div class="card stat-card">
      <div class="card-body stat-body text-center">
        <div class="stat-icon">
          <i class="pe-7s-home"></i>
        </div>
        <h2 class="stat-number countup" data-target="<?= $totalRuangan ?>">4</h2>
        <span class="badge badge-hari-ini">Total Ruangan</span>
      </div>
    </div>
  </div>

  <div class="col-lg-4 col-md-6 mb-4">
    <div class="card stat-card">
      <div class="card-body stat-body text-center">
        <div class="stat-icon">
          <i class="pe-7s-door-lock"></i>
        </div>
        <h2 class="stat-number countup" data-target="<?= $ruanganDigunakan ?>">0</h2>
        <span class="badge badge-hari-ini">Ruangan Digunakan</span>
      </div>
    </div>
  </div>

  <div class="col-lg-4 col-md-6 mb-4">
    <div class="card stat-card">
      <div class="card-body stat-body text-center">
        <div class="stat-icon">
          <i class="pe-7s-note2"></i>
        </div>
<h2 class="stat-number countup" data-target="<?= $totalPemesanan ?>"><?= $totalPemesanan ?></h2>
 <span class="badge badge-hari-ini">Total Pesanan</span>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /Widgets -->

         

 

<div class="row mt-4">

<div class="row mt-4 justify-content-center">
  <!-- Card Tarif -->
  <div class="col-lg-4 col-md-6 mb-4">
    <div class="card tarif-card h-100">
      <div class="card-body">
        <div class="tarif-header">
          <i class="pe-7s-note2"></i>
          <h5>Tarif Gedung</h5>
        </div>
        <ul class="tarif-list">
          <?php foreach($tarifKapasitas as $kap => $tarif): ?>
            <li>
              <span><?= $kap ?> orang</span>
              <strong>Rp <?= number_format($tarif,0,",",".") ?></strong>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>

  <div class="row mt-66 justify-content-center">
  <!-- Card Jenis Ruangan -->
  <div class="col-lg-10 col-md-8 mb-4">
    <div class="card jenis-ruangan-card h-100">
      <div class="card-body">
        <div class="tarif-header">
          <i class="pe-7s-door-lock"></i>
          <h5>Jenis Ruangan</h5>
        </div>
        <ul class="tarif-list">
          <li>Aula</li>
          <li>Balai Pertemuan</li>
          <li>Ruang Konferensi</li>
          <li>Ruang Serbaguna</li>
        </ul>
      </div>
    </div>
  </div>

</div>


      <!-- Footer -->
     <footer class="footer">
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                Development Sistem Informasi Pemesanan Gedung Pertemuan |
                © 2025 Revaliza Maheppy – Global Institute
            </div>
        </div>
    </div>
</footer>

    <!-- /#right-panel -->

  <!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
<script src="assets/js/main.js"></script>

<!-- Chart js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.bundle.min.js"></script>

<!-- Chartist Chart -->
<script src="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartist-plugin-legend@0.6.2/chartist-plugin-legend.min.js"></script>

<!-- Flot Charts -->
<script src="https://cdn.jsdelivr.net/npm/jquery.flot@0.8.3/jquery.flot.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flot-pie@1.0.0/src/jquery.flot.pie.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flot-spline@0.0.1/js/jquery.flot.spline.min.js"></script>

<!-- Weather & Calendar -->
<script src="https://cdn.jsdelivr.net/npm/simpleweather@3.1.0/jquery.simpleWeather.min.js"></script>
<script src="assets/js/init/weather-init.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.22.2/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js"></script>
<script src="assets/js/init/fullcalendar-init.js"></script>

<!-- Local Scripts -->
<script>
jQuery(document).ready(function ($) {
  "use strict";

  // Pie chart flotPie1
  var piedata = [
    { label: "Desktop visits", data: [[1, 32]], color: "#5c6bc0" },
    { label: "Tab visits", data: [[1, 33]], color: "#ef5350" },
    { label: "Mobile visits", data: [[1, 35]], color: "#66bb6a" },
  ];

  $.plot("#flotPie1", piedata, {
    series: {
      pie: {
        show: true,
        radius: 1,
        innerRadius: 0.65,
        label: { show: true, radius: 2 / 3, threshold: 1 },
        stroke: { width: 0 },
      },
    },
    grid: { hoverable: true, clickable: true },
  });

  // cellPaiChart
  var cellPaiChart = [
    { label: "Direct Sell", data: [[1, 65]], color: "#5b83de" },
    { label: "Channel Sell", data: [[1, 35]], color: "#00bfa5" },
  ];
  $.plot("#cellPaiChart", cellPaiChart, {
    series: { pie: { show: true, stroke: { width: 0 } } },
    legend: { show: false },
    grid: { hoverable: true, clickable: true },
  });

  // Line Chart #flotLine5
  var newCust = [
    [0, 3],[1, 5],[2, 4],[3, 7],[4, 9],[5, 3],[6, 6],[7, 4],[8, 10],
  ];
  $.plot("#flotLine5", [{ data: newCust, label: "New Data Flow", color: "#fff" }], {
    series: {
      lines: { show: true, lineColor: "#fff", lineWidth: 2 },
      points: { show: true, fill: true, fillColor: "#ffffff", symbol: "circle", radius: 3 },
      shadowSize: 0,
    },
    points: { show: true },
    legend: { show: false },
    grid: { show: false },
  });

  // Traffic Chart Chartist
  if ($("#traffic-chart").length) {
    var chart = new Chartist.Line("#traffic-chart", {
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
      series: [
        [0, 18000, 35000, 25000, 22000, 0],
        [0, 33000, 15000, 20000, 15000, 300],
        [0, 15000, 28000, 15000, 30000, 5000],
      ]
    }, {
      low: 0, showArea: true, showLine: false, showPoint: false, fullWidth: true,
      axisX: { showGrid: true }
    });

    chart.on("draw", function (data) {
      if (data.type === "line" || data.type === "area") {
        data.element.animate({
          d: {
            begin: 2000 * data.index,
            dur: 2000,
            from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
            to: data.path.clone().stringify(),
            easing: Chartist.Svg.Easing.easeOutQuint,
          },
        });
      }
    });
  }

  // Traffic Chart Chart.js
  if ($("#TrafficChart").length) {
    var ctx = document.getElementById("TrafficChart");
    ctx.height = 150;
    new Chart(ctx, {
      type: "line",
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
        datasets: [
          { label: "Visit", borderColor: "rgba(4,73,203,.09)", borderWidth: 1, backgroundColor: "rgba(4,73,203,.5)", data: [0,2900,5000,3300,6000,3250,0] },
          { label: "Bounce", borderColor: "rgba(245,23,66,0.9)", borderWidth: 1, backgroundColor: "rgba(245,23,66,.5)", data: [0,4200,4500,1600,4200,1500,4000] },
          { label: "Targeted", borderColor: "rgba(40,169,46,0.9)", borderWidth: 1, backgroundColor: "rgba(40,169,46,.5)", data: [1000,5200,3600,2600,4200,5300,0] }
        ]
      },
      options: { responsive: true, tooltips: { mode: "index", intersect: false }, hover: { mode: "nearest", intersect: true } }
    });
  }

  // Bar Chart #flotBarChart
  $.plot("#flotBarChart", [{ data: [[0,18],[2,8],[4,5],[6,13],[8,5],[10,7],[12,4],[14,6],[16,15],[18,9],[20,17],[22,7],[24,4],[26,9],[28,11]], bars: { show: true, lineWidth: 0, fillColor: "#ffffff8a" } }], { grid: { show: false } });

});

// Animasi countup (angka)
document.querySelectorAll('.countup').forEach(el => {
  const target = parseInt(el.dataset.target) || 0;
  let count = 0;
  const step = Math.max(1, Math.ceil(target / 30));
  const interval = setInterval(() => {
    count += step;
    if (count >= target) {
      count = target;
      clearInterval(interval);
    }
    el.textContent = count;
  }, 20);
});

// Animasi muncul saat scroll
const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if(entry.isIntersecting){
      entry.target.classList.add('active');
    }
  });
}, { threshold: 0.3 });

document.querySelectorAll('.tarif-card, .jenis-ruangan-card').forEach(card => {
  observer.observe(card);
});
</script>


  </body>
</html>
