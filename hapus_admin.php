<?php
include 'koneksi.php';

// Ambil ID Admin dari URL
$id_user = $_GET['id_user'];

// Query untuk menghapus admin
$query = "DELETE FROM tb_akun WHERE id_user = $id_user AND role = 'admin'";
if (mysqli_query($conn, $query)) {
    echo "<script>alert('Admin berhasil dihapus'); window.location.href='tabel_admin.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus admin'); window.location.href='tabel_admin.php';</script>";
}

// Tutup koneksi
mysqli_close($conn);
?>