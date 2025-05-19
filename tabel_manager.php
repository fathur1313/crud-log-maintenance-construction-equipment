<?php
// filepath: c:\xampp\htdocs\crud_perusahaan\tabel_manager.php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: masuk.php');
    exit;
}
include 'koneksi.php';

// Tambah Manager
if (isset($_POST['tambah'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $query = "INSERT INTO tb_akun (username, password, role) VALUES ('$username', '$password', 'manager')";
    mysqli_query($conn, $query);
    header("Location: tabel_manager.php");
    exit;
}

// Ubah Password Manager
if (isset($_POST['ubah_password'])) {
    $id = $_POST['id'];
    $password = password_hash($_POST['password_baru'], PASSWORD_DEFAULT);
    $query = "UPDATE tb_akun SET password='$password' WHERE id='$id' AND role='manager'";
    mysqli_query($conn, $query);
    header("Location: tabel_manager.php");
    exit;
}

// Hapus Manager
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $query = "DELETE FROM tb_akun WHERE id='$id' AND role='manager'";
    mysqli_query($conn, $query);
    header("Location: tabel_manager.php");
    exit;
}

// Ambil data manager
$managers = mysqli_query($conn, "SELECT * FROM tb_akun WHERE role='manager'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tabel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4">Data Manager</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Manager</button>
    <a href="dashboard_admin.php" class="btn btn-danger mb-3">Kembali</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; while($row = mysqli_fetch_assoc($managers)): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['username']); ?></td>
                <td><?= htmlspecialchars($row['role']); ?></td>
                <td>
                    <!-- Ubah Password -->
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $row['id']; ?>">Ubah Sandi</button>
                    <!-- Hapus -->
                    <a href="tabel_manager.php?hapus=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus manager ini?')">Hapus</a>
                </td>
            </tr>
            <!-- Modal Ubah Password -->
            <div class="modal fade" id="modalUbah<?= $row['id']; ?>" tabindex="-1">
              <div class="modal-dialog">
                <form method="post" class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Ubah Kata Sandi Manager</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                    <div class="mb-3">
                        <label>Password Baru</label>
                        <input type="password" name="password_baru" class="form-control" required>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="ubah_password" class="btn btn-warning">Ubah</button>
                  </div>
                </form>
              </div>
            </div>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah Manager -->
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog">
    <form method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Manager</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
      </div>
    </form>
  </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>