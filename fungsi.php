<?php 
	include 'koneksi.php';

    function tambah_data($data, $files){
        $tanggal        = $data['tanggal'];
        $alat_berat     = $data['alat_berat'];
        $part_name      = $data['part_name'];
        $part_number    = $data['part_number'];
        $qty            = $data['qty'];
        $harga_satuan   = $data['harga_satuan'];
        $harga_total    = $data['harga_total'];
        $keterangan     = $data['keterangan'];
        $foto           = $files['foto_dokumentasi']['name'];

        $dir            = "img/";
        $uniqueName     = time() . '_' . $foto; // Tambahkan prefix unik
        $tmpFile        = $_FILES['foto_dokumentasi']['tmp_name'];

        move_uploaded_file($tmpFile, $dir . $uniqueName);

        $query = "INSERT INTO tb_laporan_unit VALUES(null, '$tanggal', '$alat_berat', '$part_name', '$part_number', '$qty', '$harga_satuan', '$harga_total', '$keterangan', '$uniqueName')";
        $sql = mysqli_query($GLOBALS['conn'], $query);

        return true;
    }

    function ubah_data($data, $files){
        $no             = $data['no'];
        $tanggal        = $data['tanggal'];
        $alat_berat     = $data['alat_berat'];
        $part_name      = $data['part_name'];
        $part_number    = $data['part_number'];
        $qty            = $data['qty'];
        $harga_satuan   = $data['harga_satuan'];
        $harga_total    = $data['harga_total'];
        $keterangan     = $data['keterangan'];

        // Ambil data lama untuk menghapus file jika ada perubahan foto
        $queryShow = "SELECT * FROM tb_laporan_unit WHERE no = '$no';";
        $sqlShow = mysqli_query($GLOBALS['conn'], $queryShow);
        $result = mysqli_fetch_assoc($sqlShow);

        if (isset($files['foto_dokumentasi']) && $files['foto_dokumentasi']['name'] != "") {
            $foto = $files['foto_dokumentasi']['name'];
            $uniqueName = time() . '_' . $foto; // Tambahkan prefix unik
            move_uploaded_file($files['foto_dokumentasi']['tmp_name'], 'img/' . $uniqueName);

            // Hapus foto lama jika ada
            if (file_exists('img/' . $result['foto_dokumentasi'])) {
                unlink('img/' . $result['foto_dokumentasi']);
            }
        } else {
            $uniqueName = $result['foto_dokumentasi']; // Gunakan foto lama
        }

        // Update query
        $query = "UPDATE tb_laporan_unit SET 
            tanggal         ='$tanggal', 
            alat_berat      ='$alat_berat', 
            part_name       ='$part_name', 
            part_number     ='$part_number', 
            qty             ='$qty', 
            harga_satuan    ='$harga_satuan', 
            harga_total     ='$harga_total', 
            keterangan      ='$keterangan', 
            foto_dokumentasi='$uniqueName' 
            WHERE no='$no';";

        mysqli_query($GLOBALS['conn'], $query);

        return true;
    }

    function hapus_data($no){
        $queryShow = "SELECT * FROM tb_laporan_unit WHERE no = '$no';";
        $sqlShow = mysqli_query($GLOBALS['conn'], $queryShow);
        $result = mysqli_fetch_assoc($sqlShow);

        // Hapus file foto jika ada
        if (file_exists("img/" . $result['foto_dokumentasi'])) {
            unlink("img/" . $result['foto_dokumentasi']);
        }

        $query = "DELETE FROM tb_laporan_unit WHERE no = '$no';";
        $sql = mysqli_query($GLOBALS['conn'], $query);

        return true;
    }

?>