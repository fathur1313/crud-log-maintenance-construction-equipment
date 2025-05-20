<?php
include 'koneksi.php';

if (!isset($_GET['id_user'])) {
    header("Location: dashboard_admin.php#2");
    exit;
}
$id_user = $_GET['id_user'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $query = "UPDATE tb_akun SET password='$password' WHERE id_user='$id_user'";
    mysqli_query($conn, $query);
    echo "<script>
        alert('Password berhasil diubah!');
        window.location.href='dashboard_admin.php#2';
    </script>";
    exit;
}

// Ambil username untuk ditampilkan
$result = mysqli_query($conn, "SELECT username FROM tb_akun WHERE id_user='$id_user'");
$data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ubah Password Petugas</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Ubah Password Petugas</h2>
    <form method="post">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($data['username']); ?>" disabled>
        </div>
        <div class="mb-3">
            <label>Password Baru</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-warning">Ubah</button>
        <a href="dashboard_admin.php#2" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>