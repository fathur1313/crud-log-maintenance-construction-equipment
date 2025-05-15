<?php
include 'koneksi.php';

// Ambil ID User dari URL
$id_user = $_GET['id_user'];

// Query untuk menghapus user
$query = "DELETE FROM tb_akun WHERE id_user = $id_user";
if (mysqli_query($conn, $query)) {
    echo "<script>alert('User berhasil dihapus'); window.location.href='tabel_user.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus user'); window.location.href='tabel_user.php';</script>";
}

// Tutup koneksi
mysqli_close($conn);
?>