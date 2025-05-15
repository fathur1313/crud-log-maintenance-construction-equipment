<?php
	include 'fungsi.php';
	session_start();

	if(isset($_POST['aksi'])){
		if($_POST['aksi'] == "add") {

			$berhasil = tambah_data($_POST, $_FILES);

			if($berhasil){
				$_SESSION['eksekusi'] = "Data Berhasil Ditambahkan";
				header("location: tabel_maintenance.php");
			} else {
				echo $berhasil;
			}

		} else if ($_POST['aksi'] == "edit"){
			
			$berhasil = ubah_data($_POST, $_FILES);
			if($berhasil){
				$_SESSION['eksekusi'] = "Data Berhasil Diperbarui";
				header("location: tabel_maintenance.php");
			} else {
				echo $berhasil;
			}
		}
		      
	}
	if (isset($_GET['hapus'])) {
		$no = $_GET['hapus'];

		$berhasil = hapus_data($no);

		if($berhasil){
			$_SESSION['eksekusi'] = "Data Berhasil Dihapus";
			header("location: tabel_maintenance.php");
		} else {
			echo $berhasil;
		}
	}
?>