<?php
include "koneksi.php";
session_start();

// Periksa apakah pengguna telah login
if (!isset($_SESSION["username"])) {
  header("Location: login.php"); // Jika tidak ada sesi username, redirect ke halaman login
  exit;
}

// Mengambil username dari sesi
$username = $_SESSION["username"];

// Mendapatkan tanggal hari ini dalam format Y-m-d
$today = date("Y-m-d");

// Query untuk mendapatkan data pesanan hari ini
$query = "SELECT pemesanan.*, user.nama_lengkap, daftar_perjalanan.kota_asal, daftar_perjalanan.kota_tujuan
          FROM pemesanan
          JOIN user ON pemesanan.id_user = user.id_user
          JOIN daftar_perjalanan ON pemesanan.id_perjalanan = daftar_perjalanan.id_perjalanan WHERE DATE(tanggal_pesan) = '$today'";
$result = $conn->query($query);

$querySopir = "SELECT * FROM sopir";

$res = $conn->query($querySopir);
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
        <li class="nav-item dropdown d-none d-lg-block user-dropdown">
          <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="img-xs rounded-circle profile-initials" id="profileInitials"></div>
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
            <a class="dropdown-item dropdown-header" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
              <i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Logout
            </a>
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
          <?php 
          $queryPelanggan = "SELECT COUNT(*) AS total_pelanggan FROM user WHERE id_role = '3'";
          $resultPelanggan = $conn->query($queryPelanggan);
          $totalPelanggan = ($resultPelanggan->num_rows > 0) ? $resultPelanggan->fetch_assoc()['total_pelanggan'] : 0;

          $queryPesanan = "SELECT COUNT(*) AS total_pesanan FROM pemesanan";
          $resultPesanan = $conn->query($queryPesanan);
          $totalPesanan = ($resultPesanan->num_rows > 0) ? $resultPesanan->fetch_assoc()['total_pesanan'] : 0;

          $queryPendapatan = "SELECT SUM(harga) AS total_pendapatan FROM pemesanan";
          $resultPendapatan = $conn->query($queryPendapatan);
          $totalPendapatan = ($resultPendapatan->num_rows > 0) ? $resultPendapatan->fetch_assoc()['total_pendapatan'] : 0;

          $formattedHarga = number_format($totalPendapatan, 2, ',', '.');
          ?>
          <div class="col-sm-12">
            <div class="statistics-details d-flex align-items-center justify-content-between">
              <div class="card card-rounded p-4 w-100 m-2">
                <p class="statistics-title">Pelanggan</p>
                <h3 class="rate-percentage"><?php echo $totalPelanggan; ?></h3>
              </div>
              <div class="card card-rounded p-4 w-100 m-2">
                <p class="statistics-title">Pemesanan</p>
                <h3 class="rate-percentage"><?php echo $totalPesanan; ?></h3>
              </div>
              <div class="card card-rounded p-4 w-100 m-2">
                <p class="statistics-title">Pendapatan</p>
                <h3 class="rate-percentage">Rp. <?php echo $formattedHarga ?></h3>
              </div>
            </div>
          </div>

          <div class="col-sm-12">
            <div class="home-tab">
              <div class="tab-content tab-content-basic">
                <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                  <div class="row">
                    <div class="col-lg-8 d-flex flex-column">
                      <div class="card card-rounded">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                  <h4 class="card-title card-title-dash">Pemesanan Tahun Ini</h4>
                                </div>
                              </div>
                              <div class="mt-3">
                                <canvas id="pemesananReport" width="277" height="150" style="display: block; box-sizing: border-box; height: 150px; width: 277px;"></canvas>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <!-- Tabel kecil -->
                      <div class="card">
                        <div class="card-body">
                          <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Driver</h4>
                          </div>
                          <div class="table-responsive">
                            <table class="table table-hover">
                              <thead>
                                <tr>
                                  <th>Nama</th>
                                  <th>Status</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                // Periksa apakah ada data
                                if ($res->num_rows > 0) {
                                  // Loop untuk menampilkan data
                                  while ($row = $res->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["nama_lengkap"] . "</td>";
                                    $status = $row["status"];
                                    $class = '';

                                    if ($status == 'active') {
                                      $class = 'badge-opacity-success';
                                    } elseif ($status == 'non_active') {
                                      $class = 'badge-opacity-warning';
                                    }
                                    echo "<td><div class='badge $class'>$status</div></td>";
                                    echo "</tr>";
                                  }
                                } else {
                                  // Jika tidak ada data
                                  echo "<tr><td colspan='9'>Belum Ada Pesanan Hari ini</td></tr>";
                                }
                                ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <h4 class="card-title">Pesanan Terbaru</h4>
                  <button type="submit" class="btn btn-primary"><i class="mdi mdi-apps"></i>Selengkapnya</button>
                </div>
                <div class="table-responsive">
                  <table class="table table-Hover">
                    <thead>
                      <tr>
                        <th>Nama</th>
                        <th>Kota Asal</th>
                        <th>Kota Tujuan</th>
                        <th>Tanggal Keberangkatan</th>
                        <th>Harga</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      // Periksa apakah ada data
                      if ($result->num_rows > 0) {
                        // Loop untuk menampilkan data
                        while ($row = $result->fetch_assoc()) {
                          echo "<tr>";
                          echo "<td>" . $row["nama_lengkap"] . "</td>";
                          echo "<td>" . $row["kota_asal"] . "</td>";
                          echo "<td>" . $row["kota_tujuan"] . "</td>";
                          echo "<td>" . $row["tanggal_berangkat"] . "</td>";
                          echo "<td>" . $row["harga"] . "</td>";
                          $status = $row["status"];
                          $class = '';

                          if ($status == 'Menunggu') {
                            $class = 'badge-opacity-warning';
                          } elseif ($status == 'Selesai') {
                            $class = 'badge-opacity-success';
                          } elseif ($status == 'Gagal') {
                            $class = 'badge-opacity-danger';
                          }
                          echo "<td><div class='badge $class'>$status</div></td>";
                          echo "</tr>";
                        }
                      } else {
                        // Jika tidak ada data
                        echo "<tr><td colspan='9'>Belum Ada Pesanan Hari ini</td></tr>";
                      }
                      ?>
                    </tbody>
                  </table>
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
      <!-- partial:partials/_footer.html -->
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
    // Inisialisasi modal
    var myModal = new bootstrap.Modal(document.getElementById('logoutModal'), {
      keyboard: false
    });
  </script>

  <script>
    <?php
      $thisYear = date('Y');
      $queryChart = "
        SELECT 
            months.month_name,
            COALESCE(pemesanan.total, 0) as total
        FROM 
            (SELECT 1 as month_num, 'Jan' as month_name
            UNION ALL SELECT 2, 'Feb'
            UNION ALL SELECT 3, 'Mar'
            UNION ALL SELECT 4, 'Apr'
            UNION ALL SELECT 5, 'May'
            UNION ALL SELECT 6, 'Jun'
            UNION ALL SELECT 7, 'Jul'
            UNION ALL SELECT 8, 'Aug'
            UNION ALL SELECT 9, 'Sept'
            UNION ALL SELECT 10, 'Oct'
            UNION ALL SELECT 11, 'Nov'
            UNION ALL SELECT 12, 'Dec') as months
        LEFT JOIN 
            (SELECT 
                MONTH(tanggal_pesan) as month_num, 
                COUNT(harga) as total 
            FROM pemesanan 
            WHERE pemesanan.status = 'Selesai' 
            AND YEAR(tanggal_pesan) = '$thisYear' 
            GROUP BY MONTH(tanggal_pesan)
            ) as pemesanan 
        ON months.month_num = pemesanan.month_num
        ORDER BY months.month_num;
      ";
      $result = $conn->query($queryChart);
      $monthNames = [];
      $totals = [];

      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              $monthNames[] = $row['month_name'];
              $totals[] = $row['total'];
          }
      }

      $monthNamesJson = json_encode($monthNames);
      $totalsJson = json_encode($totals);
    ?>
    if ($("#pemesananReport").length) {
      var leaveReportChart = document.getElementById("pemesananReport").getContext('2d');
      var leaveReportData = {
          labels: <?= $monthNamesJson ?>,
          datasets: [{
              label: 'Bulan Ini',
              data: <?= $totalsJson ?>,
              backgroundColor: "#52CDFF",
              borderColor: [
                  '#52CDFF',
              ],
              borderWidth: 0,
              fill: true, // 3: no fill
              
          }]
      };
  
      var leaveReportOptions = {
        responsive: true,
        maintainAspectRatio: false,
          scales: {
              yAxes: [{
                  gridLines: {
                      display: true,
                      drawBorder: false,
                      color:"rgba(255,255,255,.05)",
                      zeroLineColor: "rgba(255,255,255,.05)",
                  },
                  ticks: {
                    beginAtZero: true,
                    autoSkip: true,
                    maxTicksLimit: 5,
                    fontSize: 10,
                    color:"#6B778C"
                  }
              }],
              xAxes: [{
                barPercentage: 0.5,
                gridLines: {
                    display: false,
                    drawBorder: false,
                },
                ticks: {
                  beginAtZero: false,
                  autoSkip: true,
                  maxTicksLimit: 12,
                  fontSize: 10,
                  color:"#6B778C"
                }
            }],
          },
          legend:false,
          
          elements: {
              line: {
                  tension: 0.4,
              }
          },
          tooltips: {
              backgroundColor: 'rgba(31, 59, 179, 1)',
          }
      }
      var leaveReport = new Chart(leaveReportChart, {
          type: 'bar',
          data: leaveReportData,
          options: leaveReportOptions
      });
    }
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