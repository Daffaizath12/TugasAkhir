<?php

include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "add") {
  $kotaasal = $_POST['kota_asal'];
  $kotatujuan = $_POST['kota_tujuan'];
  $waktu_keberangkatan = $_POST['waktu_keberangkatan'];
  $harga = $_POST["harga"];
  $status = $_POST["status"];
  $tanggal = $_POST["tanggal"];
  $jumlah_penumpang = $_POST["jumlah_penumpang"];

  $isSuccess = false;
  // Pesan error kosong
  $error_message = "";

  if ($kotaasal == $kotatujuan) {
      $error_message = "Kota asal dan kota tujuan tidak boleh sama.";
  } else {
      // Cek apakah sudah ada entri dengan kota asal, kota tujuan, dan tanggal yang sama
      $check_tanggal_sql = "SELECT * FROM daftar_perjalanan WHERE 
                            kota_asal = '$kotaasal' AND kota_tujuan = '$kotatujuan' AND tanggal = '$tanggal'";
      $result_tanggal = $conn->query($check_tanggal_sql);

      if ($result_tanggal->num_rows > 0) {
          $error_message = "Perjalanan dari kota $kotaasal ke kota $kotatujuan pada tanggal $tanggal sudah ditambahkan.";
      } else {
          // Tambahkan data perjalanan jika tidak ada entri dengan kota asal, kota tujuan, dan tanggal yang sama
          $sql = "INSERT INTO daftar_perjalanan (kota_asal, kota_tujuan, waktu_keberangkatan, harga, status, jumlah_penumpang, tanggal) 
                  VALUES ('$kotaasal', '$kotatujuan', '$waktu_keberangkatan', '$harga', '$status', '$jumlah_penumpang', '$tanggal')";

          if ($conn->query($sql) === TRUE) {
              $isSuccess = true;
          } else {
              $error_message = "Terjadi kesalahan saat menambahkan data perjalanan.";
          }
      }
  }
  // Tampilkan pesan error atau sukses
  if (!empty($error_message)) {
      echo $error_message;
  } else {
      echo "Data perjalanan berhasil ditambahkan.";
  }


}

session_start();

// Periksa apakah pengguna telah login
if (!isset($_SESSION["username"])) {
  header("Location: login.php"); // Jika tidak ada sesi username, redirect ke halaman login
  exit;
}

// Mengambil username dari sesi
$username = $_SESSION["username"];
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
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
        <a class="navbar-brand brand-logo" href="#">
        <strong>PettaExpress</strong>
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
            <span class="menu-title">Perjalanan</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="charts">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="perjalanan.php">Data Perjalanan</a></li>
              <li class="nav-item"> <a class="nav-link" href="add_perjalanan.php">Tambah Perjalanan</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </nav>

    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Tambah Data Perjalanan</h4>
                <form class="forms-sample" method="POST" action="">
                  <div class="form-group">
                    <label for="kota_asal">Kota Asal</label>
                    <input type="text" class="form-control" id="kota_asal" name="kota_asal" required>
                  </div>
                  <div class="form-group">
                    <label for="kota_tujuan">Kota Tujuan</label>
                    <input type="text" class="form-control" id="kota_tujuan" name="kota_tujuan" required>
                  </div>
                  <div class="form-group">
                    <label for="waktu_keberangkatan">Waktu Keberangkatan</label>
                    <input type="time" class="form-control" id="waktu_keberangkatan" name="waktu_keberangkatan" required>
                  </div>
                  <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga" required>
                  </div>
                  <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                      <option value="Tersedia">Tersedia</option>
                      <option value="Tidak Tersedia">Tidak Tersedia</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                  </div>
                  <div class="form-group">
                    <label for="jumlah_penumpang">Jumlah Penumpang</label>
                    <input type="number" class="form-control" id="jumlah_penumpang" name="jumlah_penumpang" required>
                  </div>
                  <button type="submit" class="btn btn-primary me-2" name="action" value="add">Submit</button>
                  <button type="button" class="btn btn-light" name="cancel" onclick="window.location.href='jurusan.php'">Cancel</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal untuk menampilkan pesan sukses -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Sukses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Data perjalanan berhasil ditambahkan.
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="window.location.href='jurusan.php'">Tutup</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal untuk menampilkan pesan kesalahan -->
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Kesalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <?php echo isset($error_message) ? $error_message : ''; ?>
              </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="window.location.href='jurusan.php'">Tutup</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
      <!-- partial:partials/_footer.html -->
      <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
          <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © pettaexpress.com 2023</span>
          <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Admin PettaExpress <i class="mdi mdi-heart text-danger"></i></span>
        </div>
      </footer>
      <!-- partial -->
    </div>
    <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
</div>

<!-- plugins:js -->
<script src="vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="vendors/chart.js/Chart.min.js"></script>
<script src="vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="vendors/progressbar.js/progressbar.min.js"></script>
<!-- End plugin js for this page -->
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

<script>
  // Cek apakah penambahan data berhasil atau terjadi kesalahan
  $(document).ready(function() {
    var isSuccess = <?php echo isset($isSuccess) && $isSuccess ? 'true' : 'false'; ?>;
    var errorMessage = "<?php echo isset($error_message) ? $error_message : ''; ?>";
    
    if (isSuccess) {
      $('#successModal').modal('show');
    } else if (errorMessage) {
      $('#errorModal').modal('show');
    }
  });
</script>

</body>

</html>
