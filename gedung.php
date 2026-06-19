<?php
session_start();

// proteksi dashboard
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

include 'koneksi.php';
// =======================
// KONFIGURASI GEDUNG
// =======================
$NAMA_GEDUNG_DEFAULT = "Gedung Pertemuan - Karawaci";
$FASILITAS_GEDUNG_DEFAULT = "Parkir, Toilet, Mushola, Lift, CCTV";

// hitung data
$qGedung = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM gedung");

$gedung = mysqli_fetch_assoc($qGedung)['total'];
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

.bg-custom-pink {
    background-color: #ff006aff;
    color: white;
}

/* HEADER INFORMASI GEDUNG */
.info-gedung-header {
    background-color: #fffde8ff !important; /* sama seperti tema */
    color: #5a4a2f !important;
    border-left: 5px solid #ff006aff;
}

/* judul */
.info-gedung-header strong {
    font-size: 16px;
    color: #ff006aff !important;
}

/* deskripsi */
.info-gedung-header small {
    color: #7a6a4a !important;
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
<!-- /#header -->

        <!-- Header-->

       
<div class="content">
    <div class="animated fadeIn">
      <div class="row justify-content-center">
    <div class="col-lg-11 col-md-11 col-12">
        <div class="card mb-4">

            <!-- CARD HEADER -->
            <div class="card-header bg-custom-pink text-white">
                <h4 class="mb-0">
                    <i class="fa fa-building"></i> Form Data Gedung
                </h4>
                <small>Kelola informasi utama gedung</small>
            </div>

            <!-- CARD BODY -->
            <div class="card-body card-block">

              <div class="card-header mb-3 info-gedung-header">
    <strong>Informasi Gedung</strong><br>
    <small>Silakan isi data gedung</small>
</div>


                <form action="simpan_gedung.php" method="POST">

                    <div class="form-group">
                        <label class="form-control-label">Nama Gedung</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-building"></i>
                            </div>
                            <input
                                type="text"
                                name="nama_gedung"
                                class="form-control field-readonly"
                                value="<?= $NAMA_GEDUNG_DEFAULT ?>"
                                readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-control-label">Jenis Ruangan</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-tags"></i>
                            </div>
                            <select name="jenis_ruangan" class="form-control" required>
                                <option value="">-- Pilih Jenis Ruangan --</option>
                                <option value="Aula">Aula</option>
                                <option value="Balai Pertemuan">Balai Pertemuan</option>
                                <option value="Ruang Konferensi">Ruang Konferensi</option>
                                <option value="Ruang Serbaguna">Ruang Serbaguna</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-control-label">Kapasitas</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-users"></i>
                            </div>
                            <select name="kapasitas" class="form-control" required>
                                <option value="">-- Pilih Kapasitas --</option>
                                <option value="50">50 Orang</option>
                                <option value="100">100 Orang</option>
                                <option value="200">200 Orang</option>
                                <option value="300">300 Orang</option>
                                <option value="500">500 Orang</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-control-label">Tarif</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-money"></i>
                            </div>
                            <input
                                type="text"
                                name="tarif"
                                id="tarif"
                                class="form-control"
                                placeholder="Rp 1.500.000"
                                required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-control-label">Fasilitas Gedung</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-check-circle"></i>
                            </div>
                            <textarea
                                name="fasilitas"
                                class="form-control fasilitas-same field-readonly"
                                readonly><?= $FASILITAS_GEDUNG_DEFAULT ?></textarea>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-success btn-anim mr-2">
                            <i class="fa fa-check"></i> Simpan
                        </button>

                        <a href="gedung.php" class="btn btn-secondary btn-anim">
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
<script>
const tarif = document.getElementById('tarif');

tarif.addEventListener('keyup', function () {
    let value = this.value.replace(/[^,\d]/g, '');
    let split = value.split(',');
    let sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/g);

    if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    this.value = rupiah ? 'Rp ' + rupiah : '';
});
</script>

</body>
</html>
