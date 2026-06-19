<?php
session_start();

// proteksi dashboard
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

include 'koneksi.php';
$NAMA_PEMINJAM_DEFAULT = "Peminjam Gedung";

$id = $_GET['id_peminjam'] ?? null;
if (!$id) {
    header("Location: peminjam.php");
    exit;
}

$query = mysqli_query($koneksi, "SELECT * FROM peminjam WHERE id_peminjam='$id'");
$data = mysqli_fetch_assoc($query);
if (!$data) {
    header("Location: peminjam.php");
    exit;
}
?>

<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <title>Edit Peminjam</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">

<style>
body {
    background: #f1f2f7;
}
.navbar-brand img {
    max-height: 80px;
}
.card-body {
    padding: 20px !important;
}
.form-group {
    margin-bottom: 15px;
}
.field-readonly,
.field-readonly[readonly] {
    background-color: #ffffff !important;
    color: #495057;
    opacity: 1;
}
.input-group-addon {
    background-color: #ffffff !important;
    border-color: #ced4da;
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

<div class="row">
<div class="col-lg-10 col-xl-10 mx-auto">

<!-- CARD JUDUL -->
<div class="card mb-3">
    <div class="card-body">
        <h4 class="text-blue h4">
            <i class="fa fa-edit"></i> Edit Data Peminjam
        </h4>
        <p>Perbarui informasi peminjam yang sudah ada</p>
    </div>
</div>

<!-- CARD FORM -->
<div class="card">
<div class="card-body">

<form action="simpan_peminjam.php" method="POST">
<input type="hidden" name="id_peminjam" value="<?= $data['id_peminjam']; ?>">

<div class="form-group">
    <label class="form-control-label">Nama Lengkap</label>
    <div class="input-group">
        <div class="input-group-addon"><i class="fa fa-user"></i></div>
        <input
            type="text"
            name="nama_lengkap"
            class="form-control"
            value="<?= $data['nama_lengkap']; ?>"
            required>
    </div>
</div>

<div class="form-group">
    <label class="form-control-label">Email</label>
    <div class="input-group">
        <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
        <input
            type="email"
            name="email"
            class="form-control"
            value="<?= $data['email']; ?>">
    </div>
</div>

<div class="form-group">
    <label class="form-control-label">No Telepon</label>
    <div class="input-group">
        <div class="input-group-addon"><i class="fa fa-phone"></i></div>
        <input
            type="text"
            name="no_telepon"
            class="form-control"
            value="<?= $data['no_telepon']; ?>">
    </div>
</div>

<div class="form-group">
    <label class="form-control-label">Alamat</label>
    <div class="input-group">
        <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
        <textarea
            name="alamat"
            class="form-control"
            rows="2"><?= $data['alamat']; ?></textarea>
    </div>
</div>

<div class="form-group">
    <label class="form-control-label">Tanggal Pinjam</label>
    <div class="input-group">
        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
        <input
            type="date"
            name="tanggal_pinjam"
            class="form-control"
            value="<?= $data['tanggal_pinjam']; ?>"
            required>
    </div>
</div>

<div class="footer text-right">
    <button type="submit" class="btn btn-success btn-anim mr-2">
        <i class="fa fa-check"></i> Simpan
    </button>

    <a href="peminjam.php" class="btn btn-secondary btn-anim">
        <i class="fa fa-times"></i> Batal
    </a>
</div>

</form>

</div>
</div>

</div>
</div>

</div>
</div>

<div class="clearfix"></div>
<?php include 'footer.php'; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>
