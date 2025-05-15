<?php
include 'koneksi.php';

// Ambil data dari form
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password
$role = 'admin'; // Role default

// Query untuk menambahkan admin baru
$query = "INSERT INTO tb_akun (username, password, role) VALUES ('$username', '$password', '$role')";
if (mysqli_query($conn, $query)) {
    echo "<script>alert('Admin berhasil ditambahkan'); window.location.href='tabel_admin.php';</script>";
} else {
    echo "<script>alert('Gagal menambahkan admin'); window.location.href='tabel_admin.php';</script>";
}

// Tutup koneksi
mysqli_close($conn);
?>