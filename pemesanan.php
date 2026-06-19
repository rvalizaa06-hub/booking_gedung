<?php
session_start();

// proteksi dashboard
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

// ambil peminjam
$qPeminjam = mysqli_query($koneksi, "SELECT * FROM peminjam");

// ambil data gedung (karena 1 gedung, kita pakai jenis_ruangan)
$qJenis = mysqli_query($koneksi, "SELECT jenis_ruangan, kapasitas, tarif FROM gedung");
?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ela Admin - HTML5 Admin Template</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="https://i.imgur.com/QRAUqs9.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/lib/chosen/chosen.min.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>


    <style>

body {
  background-color: #fffde8ff; /* soft pink, ganti sesuai selera */
}

#right-panel {
    background: #f1f2f7;
}

/* BIAR TIDAK MENTOK KE FOOTER */


    .navbar-brand img {
  max-height: 80px;
  width: auto;
}


/* paksa field readonly jadi putih */
.field-readonly,
.field-readonly[readonly] {
    background-color: #ffffff !important;
    color: #495057;
    opacity: 1;
}

/* FIX FOOTER AGAR BENAR-BENAR TENGAH DI ELA ADMIN */
.footer {
    width: 100%;
}

.footer .container {
    max-width: 100% !important;
    padding-left: 15px;
    padding-right: 15px;
}

.footer .card {
    margin-left: auto;
    margin-right: auto;
    text-align: center;
}

/* UBAH CARD HEADER BIRU (bg-primary) JADI PINK */
.card-header.bg-primary {
    background-color: #ff006aff !important; /* PINK */
    color: #ffffff !important;
}

/* teks kecil */
.card-header.bg-primary small {
    color: #ffffffff !important;
}

/* icon */
.card-header.bg-primary i {
    color: #ffffff !important;
}

/* TEKS DATA PEMESANAN PINK */
.text-pink {
    color: #ff006aff !important; /* pink pilihan kamu */
}

/* SAMAKAN WARNA INPUT TIME */
input[type="time"] {
    background-color: #ffffff !important;
    color: #495057;
    opacity: 1;
}

</style>
</head>
<body>

   <!-- Left Panel -->
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
                  ><a href="page-login.html">Login</a>
                </li>
                <li>
                  <i class="menu-icon fa fa-sign-in"></i
                  ><a href="page-register.html">Logout</a>
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


<div class="content">
  <div class="animated fadeIn">

    <div class="card mb-4">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">
          <i class="fa fa-calendar-check-o"></i> Form Pemesanan Gedung
        </h4>
        <small>Masukkan data pemesanan gedung</small>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
         <div class="card-header">
    <strong class="text-pink">Data Pemesanan</strong>
</div>
          
          <div class="card-body card-block">

<form action="simpan_pemesanan.php" method="POST">

  <!-- PILIH PEMINJAM -->
  <div class="form-group row">
    <label class="col-sm-12 col-md-2 col-form-label">Pilih Peminjam</label>
    <div class="col-sm-12 col-md-10">
                    <select class="custom-select col-12" name="id_peminjam" id="id_peminjam" required>
                <option value="">-- Pilih Peminjam --</option>
                <?php while ($p = mysqli_fetch_assoc($qPeminjam)) { ?>
                  <option 
                  value="<?= $p['id_peminjam']; ?>"
                  data-tanggal="<?= $p['tanggal_pinjam']; ?>">
                    <?= $p['nama_lengkap']; ?> - <?= $p['no_telepon']; ?>
                  </option>
                <?php } ?>
              </select>
    </div>
  </div>

  <!-- PILIH JENIS Ruangans -->
 <div class="form-group row">
  <label class="col-sm-12 col-md-2 col-form-label">Jenis Ruangan</label>
  <div class="col-sm-12 col-md-10">
    <select class="custom-select col-12" name="jenis_ruangan" required>
      <option value="">-- Pilih Jenis Ruangan --</option>

      <?php while ($j = mysqli_fetch_assoc($qJenis)) { ?>
        <option value="<?= $j['jenis_ruangan']; ?>">
          <?= $j['jenis_ruangan']; ?> | Kap: <?= $j['kapasitas']; ?> | Rp<?= number_format($j['tarif']); ?>
        </option>
      <?php } ?>

    </select>
  </div>
</div>

  <!-- TANGGAL -->
  <div class="form-group row">
  <label class="col-sm-12 col-md-2 col-form-label">
    Tanggal Pinjam
  </label>

  <div class="col-sm-12 col-md-10 d-flex align-items-center">
  <input 
  type="date" 
  name="tanggal_mulai" 
  id="tanggal_mulai"
  class="form-control mr-2">

    <span class="mx-2 fw-bold">s/d</span>

    <input type="date" name="tanggal_selesai" class="form-control ml-2" required>
  </div>
</div>


  <!-- JAM (INI TETAP 2 INPUT, TAPI 1 BARIS) -->
  <div class="form-group row">
  <label class="col-md-2 col-form-label">Jam</label>

  <div class="col-md-10 d-flex align-items-center">
    <input type="time" name="jam_mulai" class="form-control mr-2" required>

    <span class="mx-2 fw-bold">s/d</span>

    <input type="time" name="jam_selesai" class="form-control ml-2" required>
  </div>
</div>


  <!-- JENIS ACARA -->
  <div class="form-group row">
    <label class="col-sm-12 col-md-2 col-form-label">Jenis Acara</label>
    <div class="col-sm-12 col-md-10">
      <input type="text" name="jenis_acara" class="form-control"
             placeholder="Contoh: Seminar, Rapat, Pernikahan" required>
    </div>
  </div>

  <!-- BUTTON -->
  <div class="form-group row">
    <div class="col-sm-12 col-md-10 offset-md-2">
      <button type="submit" class="btn btn-success">
        <i class="fa fa-save"></i> Ambil Pemesanan
      </button>
    </div>
  </div>

</form>

</div>


 
  </div>
</div>

<?php include 'footer.php'; ?>

<!-- js -->
<!-- Tambahkan ini SEBELUM core.js -->
<!-- Tambahkan sebelum penutup </body> -->

<!-- jQuery versi terbaru -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap bundle (sudah termasuk Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- MetisMenu untuk sidebar toggle -->
<script src="https://cdn.jsdelivr.net/npm/metismenu/dist/metisMenu.min.js"></script>

<script>
(function ($) {
    "use strict";

    $('#menuToggle').on('click', function (event) {
        var windowWidth = $(window).width();

        if (windowWidth < 1010) {
            $('body').removeClass('open');
            if ($('body').hasClass('menu-open')) {
                $('body').removeClass('menu-open');
            } else {
                $('body').addClass('menu-open');
            }
        } else {
            $('body').toggleClass('open');
        }
    });

})(jQuery);
</script>

<script>
$(document).ready(function () {
  $('select[name="id_peminjam"]').on('change', function () {
    let tanggalFull = $(this).find(':selected').data('tanggal');

    console.log('Tanggal dari peminjam:', tanggalFull);

    if (tanggalFull) {
      // ambil hanya tanggal (YYYY-MM-DD)
      let tanggal = tanggalFull.split(' ')[0];
      $('#tanggal_mulai').val(tanggal);
    }
  });
});
</script>


</body>
</html>