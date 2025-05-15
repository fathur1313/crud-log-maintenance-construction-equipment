<?php
include 'koneksi.php';

// Ambil data dari form
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password
$role = 'user'; // Role default

// Query untuk menambahkan user baru
$query = "INSERT INTO tb_akun (username, password, role) VALUES ('$username', '$password', '$role')";
if (mysqli_query($conn, $query)) {
    echo "<script>alert('User berhasil ditambahkan'); window.location.href='tabel_user.php';</script>";
} else {
    echo "<script>alert('Gagal menambahkan user'); window.location.href='tabel_user.php';</script>";
}

// Tutup koneksi
mysqli_close($conn);
?>