<?php
include 'koneksi.php';

// Ambil data dari form
$id_user = $_POST['id_user'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password

// Query untuk mengubah kata sandi admin
$query = "UPDATE tb_akun SET password = '$password' WHERE id_user = $id_user AND role = 'admin'";
if (mysqli_query($conn, $query)) {
    echo "<script>alert('Kata sandi berhasil diubah'); window.location.href='tabel_admin.php';</script>";
} else {
    echo "<script>alert('Gagal mengubah kata sandi'); window.location.href='tabel_admin.php';</script>";
}

// Tutup koneksi
mysqli_close($conn);
?>