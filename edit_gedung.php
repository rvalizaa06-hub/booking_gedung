<?php
session_start();

// proteksi dashboard
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

    $NAMA_GEDUNG_DEFAULT = "Gedung Pertemuan - Karawaci";
    $FASILITAS_GEDUNG_DEFAULT = "Parkir, Toilet, Mushola, Lift, CCTV";

    $id = $_GET['id_gedung'] ?? null;
    if (!$id) {
        header("Location: gedung.php");
        exit;
    }

    $query = mysqli_query($koneksi, "SELECT * FROM gedung WHERE id_gedung='$id'");
    $data = mysqli_fetch_assoc($query);
    if (!$data) {
        header("Location: gedung.php");
        exit;
    }
    ?>

    <!doctype html>
    <html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <title>Edit Gedung</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <style>

         body {
  background-color: #fffde8ff; /* soft pink, ganti sesuai selera */
}

            .navbar-brand img {
                max-height: 80px;
            }
            /* rapikan jarak konten ke footer */


    /* perkecil card edit gedung */
    .card-body {
        padding: 20px !important;
    }

    .form-group {
        margin-bottom: 15px;
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
    background-color: #e2e2e2ff !important;
    color: #495057;
    opacity: 1;
}

/* samakan warna icon addon */
.input-group-addon {
    background-color: #ffffff !important;
    border-color: #ced4da;
}

/* CARD HEADER EDIT GEDUNG */
.card-header-edit {
    background: linear-gradient(135deg, #ff006a); /* GANTI SESUKA KAMU */
    color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* judul */
.card-header-edit h4 {
    color: #fff;
    font-weight: 700;
    margin-bottom: 6px;
}

/* subjudul */
.card-header-edit p {
    color: rgba(255,255,255,0.9);
    margin-bottom: 0;
}

/* SAMAKAN WARNA SELURUH HALAMAN */
body,
#right-panel,
.right-panel,
.content,
.animated,
.fadeIn {
    background-color: #fffde8ff !important;
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

    <!-- CARD JUDUL (SAMA DENGAN GEDUNG) -->
  <div class="card mb-3 card-header-edit">
    <div class="card-body">
        <h4>
            <i class="fa fa-edit"></i> Edit Data Gedung
        </h4>
        <p>Perbarui informasi gedung yang sudah ada</p>
    </div>
</div>


    <!-- CARD FORM -->
    <div class="card">
    <div class="card-body">

    <form action="simpan_gedung.php" method="POST">
    <input type="hidden" name="id_gedung" value="<?= $data['id_gedung']; ?>">

     <div class="form-group">
                                  <label class="form-control-label">Nama Gedung</label>
                                      <div class="input-group">
                                          <div class="input-group-addon"><i class="fa fa-building"></i></div>
                                          <input
                                                type="text"
                                                name="nama_gedung"
                                                class="form-control field-readonly"
                                                value="<?= $NAMA_GEDUNG_DEFAULT ?>"
                                                readonly>
                                      </div>
                                </div>



    <div class="form-group">
        <label>Jenis Ruangan</label>
        <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-tags"></i></div>
            <select name="jenis_ruangan" class="form-control" required>
                <option value="Aula" <?= $data['jenis_ruangan']=='Aula'?'selected':''; ?>>Aula</option>
                <option value="Balai Pertemuan" <?= $data['jenis_ruangan']=='Balai Pertemuan'?'selected':''; ?>>Balai Pertemuan</option>
                <option value="Ruang Konferensi" <?= $data['jenis_ruangan']=='Ruang Konferensi'?'selected':''; ?>>Ruang Konferensi</option>
                <option value="Ruang Serbaguna" <?= $data['jenis_ruangan']=='Ruang Serbaguna'?'selected':''; ?>>Ruang Serbaguna</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label>Kapasitas</label>
        <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-users"></i></div>
            <select name="kapasitas" class="form-control" required>
                <?php
                $opsi = [50,100,200,300,500];
                foreach ($opsi as $o) {
                    $sel = $data['kapasitas']==$o ? 'selected' : '';
                    echo "<option value='$o' $sel>$o Orang</option>";
                }
                ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label>Tarif</label>
        <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-money"></i></div>
           <input
    type="text"
    name="tarif"
    id="tarif"
    class="form-control"
    value="Rp <?= number_format($data['tarif'], 0, ',', '.'); ?>"
    required
>

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

<div class="footer text-right">
    <button type="submit" class="btn btn-success btn-anim mr-2">
        <i class="fa fa-check"></i> Simpan
    </button>

    <a href="tampil_gedung.php" class="btn btn-secondary btn-anim">
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

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
<script src="assets/js/main.js"></script>

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
