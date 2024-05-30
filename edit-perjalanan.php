<?php
include "koneksi.php";

// Cek apakah ID sopir disediakan
if (isset($_GET['id_perjalanan'])) {
  $id_perjalanan = $_GET['id_perjalanan'];

  // Query untuk mendapatkan data sopir berdasarkan ID
  $query = "SELECT dp.*, s.nama_lengkap AS nama_sopir, s.id_sopir AS idSopir
                      FROM daftar_perjalanan dp
                      LEFT JOIN sopir s ON dp.id_sopir = s.id_sopir
                      WHERE dp.id_perjalanan = '$id_perjalanan'";
  $result = $conn->query($query);

  // Periksa apakah data ditemukan
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $kotaasal = $row['kota_asal'];
    $kotatujuan = $row['kota_tujuan'];
    $waktu_keberangkatan = $row['waktu_keberangkatan'];
    $harga = $row["harga"];
    $tanggal = $row["tanggal"];
    $status = $row["status"];
    $jumlah_penumpang = $row["jumlah_penumpang"];
    $nama_sopir = $row["nama_sopir"];
    $idSopir = $row["idSopir"];
  } else {
    // Redirect jika data tidak ditemukan
    header("Location: jurusan.php");
    exit;
  }
}

// Proses pengeditan data sopir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id_perjalanan = $_POST["id_perjalanan"];
  $kotaasal = $_POST['kota_asal'];
  $kotatujuan = $_POST['kota_tujuan'];
  $waktu_keberangkatan = $_POST['waktu_keberangkatan'];
  $harga = $_POST["harga"];
  $tanggal = $_POST["tanggal"];
  $status = $_POST["status"];
  $jumlah_penumpang = $_POST["jumlah_penumpang"];
  $id_sopir = $_POST["id_sopir"];
  $mobil_id = $_POST["mobil_id"];

  // Query UPDATE
  $sql = "UPDATE daftar_perjalanan SET kota_asal='$kotaasal', kota_tujuan='$kotatujuan', waktu_keberangkatan='$waktu_keberangkatan', tanggal = '$tanggal', harga='$harga', status='$status',id_sopir='$id_sopir', mobil_id='$mobil_id', jumlah_penumpang='$jumlah_penumpang' WHERE id_perjalanan='$id_perjalanan'";

  // Eksekusi query
  if ($conn->query($sql) === TRUE) {
    $isSuccess = true;
  }
}

// Pastikan koneksi terbuka
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

session_start();

// Periksa apakah pengguna telah login
if (!isset($_SESSION["username"])) {
  header("Location: login.php"); // Jika tidak ada sesi username, redirect ke halaman login
  exit;
}

// Mengambil username dari sesi
$username = $_SESSION["username"];

// Redirect to driver.php when click cancel
if (isset($_POST['cancel'])) {
  header('Location: driver.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Star Admin2 </title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/typicons/typicons.css">
  <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>
  <!-- partial:partials/_navbar.html -->
  <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
      <div class="me-3">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
      </div>
      <div>
        <a class="navbar-brand brand-logo" href="index.html">
          <img src="img/logo.svg" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="index.html">
          <img src="img/logo-mini.svg" alt="logo" />
        </a>
      </div>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-top">
      <ul class="navbar-nav">
        <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
          <h1 class="welcome-text">Semangat Kerja, <span class="text-black fw-bold"><?php echo $username ?></span></h1>
          <h3 class="welcome-sub-text">PETTA TOUR & TRAVEL EXPRESS BANYUWANGI </h3>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item d-none d-lg-block">
          <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
            <span class="input-group-addon input-group-prepend border-right">
              <span class="icon-calendar input-group-text calendar-icon"></span>
            </span>
            <input type="text" class="form-control">
          </div>
        </li>
        <li class="nav-item">
          <form class="search-form" action="#">
            <i class="icon-search"></i>
            <input type="search" class="form-control" placeholder="Search Here" title="Search here">
          </form>
        </li>
        <li class="nav-item dropdown d-none d-lg-block user-dropdown">
          <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="img-xs rounded-circle profile-initials" id="profileInitials"></div>
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
            <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign Out</a>
          </div>
        </li>
      </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
        <span class="mdi mdi-menu"></span>
      </button>
    </div>
  </nav>
  <!-- partial -->
  <div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">
            <i class="mdi mdi-grid-large menu-icon"></i>
            <span class="menu-title">Dashboard</span>
          </a>
        </li>
        <li class="nav-item nav-category">Pengguna</li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
            <i class="menu-icon mdi mdi-floor-plan"></i>
            <span class="menu-title">Pengguna</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="ui-basic">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="pelanggan.php">Pelanggan</a></li>
              <li class="nav-item"> <a class="nav-link" href="driver.php">Sopir</a></li>
            </ul>
          </div>
        </li>
        <li class="nav-item nav-category">Semua Data</li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
            <i class="menu-icon mdi mdi-card-text-outline"></i>
            <span class="menu-title">Pemesanan</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="form-elements">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"><a class="nav-link" href="pemesanan.php">Data Pemesanan</a></li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
            <i class="menu-icon mdi mdi-chart-line"></i>
            <span class="menu-title">Data Perjalanan</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="charts">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="jurusan.php">Daftar Perjalanan</a></li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="mobil.php">
            <i class="menu-icon mdi mdi-table"></i>
            <span class="menu-title">Mobil</span>
          </a>
        </li>
      </ul>
    </nav>
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Edit Daftar perjalanan</h4>
                <form method="post" action="edit-perjalanan.php">
                  <input type="hidden" name="id_perjalanan" value="<?php echo $id_perjalanan; ?>">

                  <div class="form-group">
                    <label for="exampleInputKotaAsal">Kota Asal</label>
                    <input type="text" class="form-control" id="exampleInputKotaAsal" name="kota_asal" value="<?php echo $kotaasal; ?>" placeholder="Kota Asal">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputKotaTujuan">Kota Tujuan</label>
                    <input type="text" class="form-control" id="exampleInputKotaTujuan" name="kota_tujuan" value="<?php echo $kotatujuan; ?>" placeholder="Kota Tujuan">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputWaktuKeberangkatan">Waktu Keberangkatan</label>
                    <input type="time" class="form-control" id="exampleInputWaktuKeberangkatan" name="waktu_keberangkatan" value="<?php echo $waktu_keberangkatan; ?>">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputWaktuKeberangkatan">Tanggal Keberangkatan</label>
                    <input type="date" class="form-control" id="exampleInputWaktuKeberangkatan" name="tanggal" value="<?php echo $tanggal; ?>">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputHarga">Harga</label>
                    <input type="number" class="form-control" id="exampleInputHarga" name="harga" value="<?php echo $harga; ?>" placeholder="Harga">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputHarga">Jumlah Penumpang</label>
                    <input type="number" class="form-control" id="exampleInputHarga" name="jumlah_penumpang" value="<?php echo $jumlah_penumpang; ?>" placeholder="Jumlah">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputStatus">Sopir</label>
                    <select class="form-control" id="exampleInputStatus" name="id_sopir">
                      <?php
                      $sql_sopir = "SELECT id_sopir, nama_lengkap FROM sopir";
                      $result_sopir = $conn->query($sql_sopir);
                      if ($result_sopir->num_rows > 0) {
                        while ($row_sopir = $result_sopir->fetch_assoc()) {
                          $selected = ($row_sopir['id_sopir'] == $idSopir) ? "selected" : ""; // Periksa apakah ini harus menjadi nilai awal yang dipilih
                          echo "<option value='" . $row_sopir["id_sopir"] . "' $selected>" . $row_sopir["nama_lengkap"] . "</option>";
                        }
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputStatus">Mobil</label>
                    <select class="form-control" id="exampleInputStatus" name="mobil_id">
                      <?php
                      $sql_sopir = "SELECT id_mobil, nama_mobil FROM mobil";
                      $result_sopir = $conn->query($sql_sopir);
                      if ($result_sopir->num_rows > 0) {
                        while ($row_sopir = $result_sopir->fetch_assoc()) {
                          $selected = ($row_sopir['id_mobil'] == $idSopir) ? "selected" : ""; // Periksa apakah ini harus menjadi nilai awal yang dipilih
                          echo "<option value='" . $row_sopir["id_mobil"] . "' $selected>" . $row_sopir["nama_mobil"] . "</option>";
                        }
                      }
                      ?>
                    </select>
                  </div>


                  <div class="form-group">
                    <label for="exampleInputStatus">Status</label>
                    <select class="form-control" id="exampleInputStatus" name="status">
                      <option value="tersedia" <?php echo ($status == 'tersedia') ? 'selected' : ''; ?>>Tersedia</option>
                      <option value="kosong" <?php echo ($status == 'kosong') ? 'selected' : ''; ?>>Kosong</option>
                    </select>
                  </div>

                  <button type="submit" class="btn btn-primary me-2" name="action" value="edit">Submit</button>
                  <button type="button" class="btn btn-light" name="cancel" onclick="window.location.href='jurusan.php'">Cancel</button>
                </form>

                <!-- Modal Sukses -->
                <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Sukses!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Data berhasil di Edit!
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.href='edit-perjalanan.php'">Tutup</button>
                        <a class="btn btn-primary" href="jurusan.php">Lihat Data</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal Logout -->
      <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Apakah Anda yakin ingin logout?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
      <!-- partial:../../partials/_footer.html -->
      <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
          <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2021. All rights reserved.</span>
        </div>
      </footer>
      <!-- partial -->
    </div>
    <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="vendors/chart.js/Chart.min.js"></script>
  <script src="vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="vendors/progressbar.js/progressbar.min.js"></script>

  <!-- End plugin js for this page -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Mengambil nama pengguna dari sesi PHP
      fetch('get_username.php')
        .then(response => response.json())
        .then(data => {
          var name = data.username; // Sesuaikan dengan struktur data yang diambil dari sesi
          var initials = getInitials(name);
          document.getElementById('profileInitials').innerText = initials;
        })
        .catch(error => console.error('Error:', error));
    });

    function getInitials(name) {
      var names = name.split(' ');
      var initials = names[0].charAt(0).toUpperCase();
      if (names.length > 1) {
        initials += names[names.length - 1].charAt(0).toUpperCase();
      }
      return initials;
    }
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Pastikan variabel isSuccess diatur oleh PHP setelah operasi penambahan data berhasil
      var isSuccess = <?php echo json_encode($isSuccess); ?>;

      if (isSuccess) {
        $('#successModal').modal('show');
      }
    });
  </script>
  <script>
    // Inisialisasi modal
    var myModal = new bootstrap.Modal(document.getElementById('logoutModal'), {
      keyboard: false
    });
  </script>

  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/jquery.cookie.js" type="text/javascript"></script>
  <script src="js/dashboard.js"></script>
  <script src="js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->
</body>

</html>