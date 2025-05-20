<!DOCTYPE html>
<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location: masuk.php');
        exit;
    };

    // Koneksi ke database
    include 'koneksi.php';

    // Query untuk menghitung jumlah data di tabel maintenance
    $query_maintenance = "SELECT COUNT(*) AS total_maintenance FROM tb_laporan_unit";
    $result_maintenance = mysqli_query($conn, $query_maintenance);
    $data_maintenance = mysqli_fetch_assoc($result_maintenance);
    $total_maintenance = $data_maintenance['total_maintenance'];

    // Query untuk menghitung jumlah pengguna (role = 'user')
    $query_user = "SELECT COUNT(*) AS total_user FROM tb_akun WHERE role = 'user'";
    $result_user = mysqli_query($conn, $query_user);
    $data_user = mysqli_fetch_assoc($result_user);
    $total_user = $data_user['total_user'];

    // Query untuk menghitung jumlah admin (role = 'admin')
    $query_admin = "SELECT COUNT(*) AS total_admin FROM tb_akun WHERE role = 'admin'";
    $result_admin = mysqli_query($conn, $query_admin);
    $data_admin = mysqli_fetch_assoc($result_admin);
    $total_admin = $data_admin['total_admin'];

    // Query untuk menghitung jumlah manager (role = 'manager')
    $query_manager = "SELECT COUNT(*) AS total_manager FROM tb_akun WHERE role = 'manager'";
    $result_manager = mysqli_query($conn, $query_manager);
    $data_manager = mysqli_fetch_assoc($result_manager);
    $total_manager = $data_manager['total_manager'];
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin Perusahaan</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="fontawesome/css/font-awesome.min.css">
    <style>
        body { background: #f8f9fa; }
        .navbar-custom {
            background: #343a40 !important;
            color: #fff !important;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 2001;
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .hamburger,
        .navbar-custom .fa-bars {
            color: #fff !important;
        }
        .sidebar {
            min-height: 100vh;
            height: 100vh;
            background: #343a40;
            color: #fff;
            padding-top: 30px;
            transition: margin-left 0.3s, width 0.3s;
            position: fixed;
            left: 0;
            top: 56px; /* di bawah navbar */
            width: 220px;
            z-index: 1000;
        }
        .sidebar.hide {
            margin-left: -220px;
        }
        .sidebar a {
            color: #fff !important;
            display: block;
            padding: 15px 20px;
            text-decoration: none !important;
            transition: background 0.2s;
        }
        .sidebar a.active, .sidebar a:hover {
            background: #495057;
            color: #fff !important;
            text-decoration: none !important;
        }
        .content-area {
            padding: 40px 30px;
            background: #fff;
            min-height: 100vh;
            transition: margin-left 0.3s;
            margin-left: 220px;
            margin-top: 56px; /* agar tidak tertutup navbar */
        }
        .logo-img-wrapper {
            background: #fff;
            display: inline-block;
            padding: 10px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 10px;
        }
        .logo-img {
            width: 60px;
            display: block;
        }
        .hamburger {
            font-size: 1.5rem;
            background: none;
            border: none;
            color: #fff;
            margin-right: 15px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 220px;
                height: 100vh;
                left: 0;
                top: 56px;
            }
            .sidebar.hide {
                margin-left: -220px;
            }
            .content-area {
                padding: 20px 10px;
                margin-left: 0;
                margin-top: 56px;
            }
            .navbar-custom {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 2001;
            }
            body {
                padding-top: 0;
            }
        }
        .sidebar.hide ~ .content-area {
            margin-left: 0 !important;
        }
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-custom">
    <button class="hamburger" id="toggleSidebar" aria-label="Toggle sidebar">
        <i class="fa fa-bars"></i>
    </button>
    <span class="navbar-brand mb-0 h1">Dashboard Admin</span>
</nav>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="sidebar col-md-2" id="sidebar">
            <div class="text-center">
                <div class="logo-img-wrapper">
                    <img src="img/Logo/ITP_LOGO.png" class="logo-img" alt="Logo">
                </div>
                <h5 class="mt-3">INDO TRAKTORS PAPUA</h5>
            </div>
            <a href="#1" class="active" onclick="showContent('maintenance')"><i class="fa fa-cogs"></i> Data Alat</a>
            <a href="#2" onclick="showContent('petugas')"><i class="fa fa-users"></i> Data Petugas</a>
            <a href="logout.php" class="mt-5 btn btn-danger w-100"><i class="fa fa-sign-out"></i> Keluar</a>
        </nav>
        <!-- Content -->
        <main class="content-area col" id="main-content">
            <h2>Selamat Datang, <?php echo $_SESSION['username']; ?></h2>
            <div id="maintenance" class="dashboard-content">
                <h3>Data Alat</h3>
                <?php
                    $sql = mysqli_query($conn, "SELECT * FROM tb_laporan_unit WHERE tanggal IS NOT NULL");
                    include 'partial_tabel_maintenance.php';
                ?>
                <!-- Modal untuk Menampilkan Gambar -->
                <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Foto Dokumentasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body text-center">
                        <img id="modalImage" src="" alt="Foto Dokumentasi" style="width: 100%; max-height: 500px; object-fit: contain;">
                      </div>
                    </div>
                  </div>
                </div>
                <script>
                    function showImage(src) {
                        document.getElementById('modalImage').src = src;
                    }
                </script>
            </div>
            <div id="petugas" class="dashboard-content" style="display:none;">
                <h3>Data Petugas</h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $query = "SELECT id_user, username, role FROM tb_akun";
                        $result = mysqli_query($conn, $query);
                        $no = 1;
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                                echo "<td class='text-center'>
                                        <a href=\"ubah_password_petugas.php?id_user={$row['id_user']}\" class=\"btn btn-warning btn-sm\">Ubah Password</a>
                                        <a href=\"hapus_petugas.php?id_user={$row['id_user']}\" class=\"btn btn-danger btn-sm\" onclick=\"return confirm('Yakin hapus petugas ini?')\">Hapus</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center'>Tidak ada data petugas</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
<script>
function showContent(id) {
    document.querySelectorAll('.dashboard-content').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.sidebar a').forEach(el => el.classList.remove('active'));
    document.getElementById(id).style.display = 'block';
    event.target.classList.add('active');
}

// Hash detection agar langsung ke tab petugas jika ada #2
window.onload = function() {
    if (window.location.hash === "#2") {
        showContent('petugas');
        document.querySelectorAll('.sidebar a').forEach(el => el.classList.remove('active'));
        document.querySelector('.sidebar a[href="#2"]').classList.add('active');
    } else {
        showContent('maintenance');
        document.querySelectorAll('.sidebar a').forEach(el => el.classList.remove('active'));
        document.querySelector('.sidebar a[href="#1"]').classList.add('active');
    }
};
// Sidebar toggle
document.getElementById('toggleSidebar').onclick = function() {
    document.getElementById('sidebar').classList.toggle('hide');
    // Toggle margin for content-area
    if(window.innerWidth > 768){
        document.getElementById('main-content').style.marginLeft = 
            document.getElementById('sidebar').classList.contains('hide') ? '0' : '220px';
    }
};
window.addEventListener('resize', function() {
    if(window.innerWidth <= 768){
        document.getElementById('main-content').style.marginLeft = '0';
    } else if(!document.getElementById('sidebar').classList.contains('hide')){
        document.getElementById('main-content').style.marginLeft = '220px';
    }
});
</script>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>