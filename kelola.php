<!DOCTYPE html>
<?php
	include 'koneksi.php';
	session_start();

	function redirect_dashboard($pesan) {
        $role = $_SESSION['role'] ?? '';
        $hash = '#1'; // tab Data Alat
        if ($role == 'admin') {
            echo "<script>alert('$pesan'); window.location.href='dashboard_admin.php$hash';</script>";
        } elseif ($role == 'mekanik') {
            echo "<script>alert('$pesan'); window.location.href='dashboard_mekanik.php$hash';</script>";
        } elseif ($role == 'manager') {
            echo "<script>alert('$pesan'); window.location.href='dashboard_manager.php$hash';</script>";
        } else {
            echo "<script>alert('$pesan'); window.location.href='masuk.php';</script>";
        }
        exit;
    }

	$no				= '';
	$tanggal		= '';
	$alat_berat		= '';
	$part_name		= '';
	$part_number	= '';
	$qty			= '';
	$harga_satuan	= '';
	$harga_total	= '';
	$keterangan		= '';
	$foto			= '';


	if(isset($_GET['ubah'])){
		$no = $_GET['ubah'];

		$query = "SELECT * FROM tb_laporan_unit WHERE no = '$no';";
		$sql = mysqli_query($conn, $query);

		$result = mysqli_fetch_assoc($sql);

		$tanggal		= $result['tanggal'];
		$alat_berat		= $result['alat_berat'];
		$part_name		= $result['part_name'];
		$part_number	= $result['part_number'];
		$qty			= $result['qty'];
		$harga_satuan	= $result['harga_satuan'];
		$harga_total	= $result['harga_total'];
		$keterangan		= $result['keterangan'];
		$foto			= $result['foto_dokumentasi'];

	}
?>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="js/bootstrap.bundle.min.js" ></script>
	
	<!-- Font Awesome -->
	<link rel="stylesheet" href="fontawesome/css/font-awesome.min.css">

	<title>crud_perusahaan</title>
</head>
<body>
    <nav class="navbar navbar-light bg-light">
      <div class="d-flex align-items-center ps-3">
        <img src="img/Logo/ITP_LOGO.png" width="30" height="30" alt="Logo" class="me-2">
        <span class="navbar-brand mb-0 h1">INDO TRAKTORS PAPUA</span>
      </div>
    </nav>

	<!-- Main Form Start -->
	<div class="container">
		<form method="POST" action="proses.php" enctype="multipart/form-data">
			<input type="hidden" value="<?php echo $no; ?>" name='no'>

			<!-- Form Start -->
			<div class="mb-3 row">
			    <label for="tanggal" class="col-sm-2 col-form-label">
			    Tanggal</label>
			    <div class="col-sm-10">
			      <input required type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo $tanggal; ?>">
				</div>
	  		</div>
	  		<div class="mb-3 row">
			    <label for="alat_berat" class="col-sm-2 col-form-label">
			    Alat Berat</label>
			    <div class="col-sm-10">
			    	<select required id="alat_berat" name="alat_berat" class="form-select">
					  <option value="Z1" <?php if($alat_berat == 'Z1'){echo "selected";} ?>>Z1</option>
					  <option value="Z2" <?php if($alat_berat == 'Z2'){echo "selected";} ?>>Z2</option>
					  <option value="Z3" <?php if($alat_berat == 'Z3'){echo "selected";} ?>>Z3</option>
					  <option value="Z4" <?php if($alat_berat == 'Z4'){echo "selected";} ?>>Z4</option>
					  <option value="Z5" <?php if($alat_berat == 'Z5'){echo "selected";} ?>>Z5</option>
					  <option value="Z6" <?php if($alat_berat == 'Z6'){echo "selected";} ?>>Z6</option>
					  <option value="Z7" <?php if($alat_berat == 'Z7'){echo "selected";} ?>>Z7</option>
					  <option value="Z8" <?php if($alat_berat == 'Z8'){echo "selected";} ?>>Z8</option>
					  <option value="K6" <?php if($alat_berat == 'K6'){echo "selected";} ?>>K6</option>
					  <option value="X1" <?php if($alat_berat == 'X1'){echo "selected";} ?>>X1</option>
					  <option value="FOR-KLIF" <?php if($alat_berat == 'FOR-KLIF'){echo "selected";} ?>>FOR-KLIF</option>
					  <option value="T1" <?php if($alat_berat == 'T1'){echo "selected";} ?>>T1</option>
					  <option value="T2" <?php if($alat_berat == 'T2'){echo "selected";} ?>>T2</option>
					  <option value="V1" <?php if($alat_berat == 'V1'){echo "selected";} ?>>V1</option>
					  <option value="TR1" <?php if($alat_berat == 'TR1'){echo "selected";} ?>>TR1</option>
					  <option value="TR2" <?php if($alat_berat == 'TR2'){echo "selected";} ?>>TR2</option>
					  <option value="TR3" <?php if($alat_berat == 'TR3'){echo "selected";} ?>>TR3</option>
					  <option value="P1" <?php if($alat_berat == 'P1'){echo "selected";} ?>>P1</option>
					</select>
				</div>
	  		</div>
	  		<div class="mb-3 row">
			    <label for="part_name" class="col-sm-2 col-form-label">
			    Part Name</label>
			    <div class="col-sm-10">
			      <input required type="part_name" name="part_name" class="form-control" id="part_name" placeholder="Ex: Oil Engine" value="<?php echo $part_name; ?>">
				</div>
	  		</div>
	  		<div class="mb-3 row">
			    <label for="part_number" class="col-sm-2 col-form-label">
			    Part Number</label>
			    <div class="col-sm-10">
			      <input required type="part_number" name="part_number" class="form-control" id="part_number" placeholder="Ex: sae 40" value="<?php echo $part_number; ?>">
				</div>
	  		</div>
	  		<div class="mb-3 row">
			    <label for="qty" class="col-sm-2 col-form-label">
			    Qty</label>
			    <div class="col-sm-10">
			      <input required type="qty" name="qty" class="form-control" id="qty" placeholder="Ex: 10" value="<?php echo $qty; ?>">
				</div>
	  		</div>
	  		<div class="mb-3 row">
			    <label for="harga_satuan" class="col-sm-2 col-form-label">
			    Harga Satuan</label>
			    <div class="col-sm-10">
			      <input required type="harga_satuan" name="harga_satuan" class="form-control" id="harga_satuan" placeholder="Ex: 100000" value="<?php echo $harga_satuan; ?>">
				</div>
	  		</div>
	  		<div class="mb-3 row">
			    <label for="harga_total" class="col-sm-2 col-form-label">
			    Harga Total</label>
			    <div class="col-sm-10">
			      <input required type="harga_total" name="harga_total" class="form-control" id="harga_total" placeholder="Ex: 1000000" value="<?php echo $harga_total; ?>">
				</div>
	  		</div>
	  		<div class="mb-3 row">
			    <label for="foto" class="col-sm-2 col-form-label">
			    Foto Dokumentasi</label>
			    <div class="col-sm-10">
			      <input <?php if (!isset($_GET['ubah'])) { echo "required";} ?> class="form-control" type="file" name="foto_dokumentasi" id="foto_dokumentasi" accept="image/*">
				</div>
	  		</div>		
	  		<div class="mb-3 row">
			    <label for="keterangan" class="col-sm-2 col-form-label">
			    Keterangan</label>
			    <div class="col-sm-10">
			  		<textarea required class="form-control" id="keterangan" name="keterangan" rows="3"><?php echo $keterangan; ?></textarea>
				</div>
	  		</div>
	  		<!-- Form End -->

	  		<!-- Button Save and Cancel Start -->
	  		<div class="mb-3 row mt-4">
	  			<div class="col">
	  				<?php
	  					if(isset($_GET['ubah'])){
	  				?>
		  				<button type="submit" name="aksi" value="edit" class="btn btn-primary">
		  					<i class="fa fa-floppy-o" aria-hidden="true"></i>
		  					Simpan Perubahan
		  				</button>
	  				<?php
	  					} else {
	  				?>
		  				<button type="submit" name="aksi" value="add" class="btn btn-primary">
		  					<i class="fa fa-floppy-o" aria-hidden="true"></i>
		  					Tambahkan
		  				</button>
		  			<?php
		  				}
		  				$role = $_SESSION['role'] ?? '';
					    if ($role == 'admin') {
					        $batal_link = 'dashboard_admin.php#1';
					    } elseif ($role == 'mekanik') {
					        $batal_link = 'dashboard_mekanik.php#1';
					    } elseif ($role == 'manager') {
					        $batal_link = 'dashboard_manager.php#1';
					    } else {
					        $batal_link = 'masuk.php';
					    }
		  			?>
	  					<a href="<?= $batal_link ?>" type="button" class="btn btn-danger">
	  					<i class="fa fa-times" aria-hidden="true"></i>
	  				Batal
	  				</a>
	  			</div>
	  		</div>
	  		<!-- Button Save and Cancel End -->

		</form>
	</div>
	<!-- Main Form End -->

</body>
</html>