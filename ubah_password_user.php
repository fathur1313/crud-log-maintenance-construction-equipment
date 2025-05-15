<?php
include 'koneksi.php';

// Ambil data dari form
$id_user = $_POST['id_user'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password

// Query untuk mengubah kata sandi user
$query = "UPDATE tb_akun SET password = '$password' WHERE id_user = $id_user AND role = 'user'";
$message = mysqli_query($conn, $query) ? 'Kata sandi berhasil diubah' : 'Gagal mengubah kata sandi';

// Redirect dengan pesan
echo "<script>alert('$message'); window.location.href='tabel_user.php';</script>";

// Tutup koneksi
mysqli_close($conn);
?>