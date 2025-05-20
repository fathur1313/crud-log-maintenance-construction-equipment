<?php
	include 'fungsi.php';
	session_start();

	function redirect_dashboard($pesan) {
        $role = $_SESSION['role'] ?? '';
        $hash = '#1'; // tab Data Alat
        if ($role == 'admin') {
            echo "<script>alert('$pesan'); window.location.href='dashboard_admin.php$hash';</script>";
        } elseif ($role == 'user') {
            echo "<script>alert('$pesan'); window.location.href='dashboard_user.php$hash';</script>";
        } elseif ($role == 'manager') {
            echo "<script>alert('$pesan'); window.location.href='dashboard_manager.php$hash';</script>";
        } else {
            echo "<script>alert('$pesan'); window.location.href='masuk.php';</script>";
        }
        exit;
    }

	if(isset($_POST['aksi'])){
		if($_POST['aksi'] == "add") {
			$berhasil = tambah_data($_POST, $_FILES);
			if($berhasil){
				redirect_dashboard("Data Berhasil Ditambahkan");
			} else {
				echo $berhasil;
			}
		} else if ($_POST['aksi'] == "edit"){
			$berhasil = ubah_data($_POST, $_FILES);
			if($berhasil){
				redirect_dashboard("Data Berhasil Diperbarui");
			} else {
				echo $berhasil;
			}
		}
	}
	if (isset($_GET['hapus'])) {
		$no = $_GET['hapus'];
		$berhasil = hapus_data($no);
		if($berhasil){
			redirect_dashboard("Data Berhasil Dihapus");
		} else {
			echo $berhasil;
		}
	}
?>