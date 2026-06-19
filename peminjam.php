<?php
session_start();

// proteksi dashboard (konsisten)
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

// ... kode lainnya tetap sama ...

// =======================
// KONFIGURASI PEMINJAM
// =======================
$NAMA_PEMINJAM_DEFAULT = "Peminjam Baru"; // contoh default jika diperlukan

// hitung total data peminjam
$qPeminjam = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM peminjam");
$totalPeminjam = mysqli_fetch_assoc($qPeminjam)['total'];

// ambil semua data peminjam (untuk ditampilkan di tabel/index)
$qDataPeminjam = mysqli_query($koneksi, "SELECT * FROM peminjam ORDER BY id_peminjam ASC");
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

  /* SAMA PERSIS SEPERTI EDIT GEDUNG */
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
/* animasi tombol */
.btn-anim {
    transition: all 0.3s ease;
}

.btn-anim i {
    transition: transform 0.3s ease;
}

/* hover tombol */
.btn-anim:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.2);
}

/* ikon ikut gerak */
.btn-anim:hover i {
    transform: scale(1.2) rotate(-5deg);
}

.btn-anim:active {
    transform: scale(0.95);
}

/* samakan textarea dengan input */
textarea.fasilitas-same {
    height: calc(2.25rem + 2px); /* tinggi default input bootstrap */
    padding: 0.375rem 0.75rem;
    resize: none;
    overflow: hidden;
}


/* paksa field readonly jadi putih */
.field-readonly,
.field-readonly[readonly] {
    background-color: #ffffff !important;
    color: #495057;
    opacity: 1;
}

/* samakan warna icon addon */
.input-group-addon {
    background-color: #ffffff !important;
    border-color: #ced4da;
}

.bg-pink {
    background-color: #ff006aff !important; /* PINK PILIHAN KAMU */
}

.card-header-pink {
    background-color: #cececeff !important; /* PINK PILIHAN KAMU */
    border-bottom: none;
}

.card-header-pink small {
    color: #ffffffff; /* pink muda biar lembut */
}

/* CARD HEADER DATA PEMINJAM */
.card-header-pink {
    background-color: #e0e0e0ff !important; /* background abu2 (tetap) */
    border-bottom: none;
}

/* TEKS JUDUL: Data Peminjam → PINK */
.card-header-pink strong {
    color: #ff006aff !important; /* PINK */
}

/* TEKS SUBTITLE: Silakan isi data peminjam → HITAM */
.card-header-pink small {
    color: #000000 !important; /* HITAM */
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
        <!-- Header-->

       
          <div class="content">
  <div class="animated fadeIn">
    <div class="card mb-4">
     <div class="card-header bg-pink text-white">
    <h4 class="mb-0">
        <i class="fa fa-user"></i> Form Peminjam
    </h4>
    <small>Kelola informasi utama peminjam</small>
</div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
         <div class="card-header card-header-pink text-white">
  <strong>Data Peminjam</strong>
  <small class="d-block">Silakan isi data peminjam</small>
</div>
          <div class="card-body card-block">
            <form action="simpan_peminjam.php" method="POST">

              <div class="form-group">
                <label class="form-control-label">Nama Lengkap</label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-user"></i></div>
                  <textarea name="nama_lengkap" class="form-control" rows="1" placeholder="Masukkan nama lengkap"></textarea>
                </div>
              </div>

              <div class="form-group">
                <label class="form-control-label">Email</label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                  <input type="email" name="email" class="form-control" placeholder="contoh: email@domain.com">
                </div>
              </div>

              <div class="form-group">
                <label class="form-control-label">No Telepon</label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                  <input type="text" name="no_telepon" class="form-control" placeholder="Contoh: 08123456789">
                </div>
              </div>

              <div class="form-group">
                <label class="form-control-label">Alamat</label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                  <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                </div>
              </div>

              <div class="form-group">
                <label class="form-control-label">Tanggal Pinjam</label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                  <input type="date" name="tanggal_pinjam" class="form-control" required>
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



  </div>


</div><!-- .animated -->
</div><!-- .content -->
    <div class="clearfix"></div>

<?php include 'footer.php'; ?>


</div><!-- /#right-panel -->

<!-- Right Panel -->

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/lib/chosen/chosen.jquery.min.js"></script>

<script>
    jQuery(document).ready(function() {
        jQuery(".standardSelect").chosen({
            disable_search_threshold: 10,
            no_results_text: "Oops, nothing found!",
            width: "100%"
        });
    });
</script>

</body>
</html>
