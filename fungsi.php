<?php
include 'koneksi.php';

function tambah_data($data, $files){
    global $conn;

    $tanggal        = isset($data['tanggal']) ? $data['tanggal'] : '';
    $alat_berat     = isset($data['alat_berat']) ? $data['alat_berat'] : '';
    $part_name      = isset($data['part_name']) ? $data['part_name'] : '';
    $part_number    = isset($data['part_number']) ? $data['part_number'] : '';
    $qty            = isset($data['qty']) ? (int)$data['qty'] : 0;
    $harga_satuan   = isset($data['harga_satuan']) ? $data['harga_satuan'] : '';
    $harga_total    = isset($data['harga_total']) ? $data['harga_total'] : '';
    $keterangan     = isset($data['keterangan']) ? $data['keterangan'] : '';

    $uniqueName = '';
    // Handle upload if present
    if (isset($files['foto_dokumentasi']) && isset($files['foto_dokumentasi']['name']) && $files['foto_dokumentasi']['name'] != "") {
        // prefer using tmp_name from $files if available
        $tmp = $files['foto_dokumentasi']['tmp_name'] ?? $_FILES['foto_dokumentasi']['tmp_name'] ?? null;
        $orig = basename($files['foto_dokumentasi']['name']);
        $uniqueName = time() . '_' . $orig;
        if ($tmp) {
            @move_uploaded_file($tmp, __DIR__ . '/img/' . $uniqueName);
        }
    }

    $sql = "INSERT INTO tb_laporan_unit (tanggal, alat_berat, part_name, part_number, qty, harga_satuan, harga_total, keterangan, foto_dokumentasi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, 'ssssissss', $tanggal, $alat_berat, $part_name, $part_number, $qty, $harga_satuan, $harga_total, $keterangan, $uniqueName);
    $res = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $res;
}

function ubah_data($data, $files){
    global $conn;

    $no             = isset($data['no']) ? $data['no'] : '';
    $tanggal        = isset($data['tanggal']) ? $data['tanggal'] : '';
    $alat_berat     = isset($data['alat_berat']) ? $data['alat_berat'] : '';
    $part_name      = isset($data['part_name']) ? $data['part_name'] : '';
    $part_number    = isset($data['part_number']) ? $data['part_number'] : '';
    $qty            = isset($data['qty']) ? (int)$data['qty'] : 0;
    $harga_satuan   = isset($data['harga_satuan']) ? $data['harga_satuan'] : '';
    $harga_total    = isset($data['harga_total']) ? $data['harga_total'] : '';
    $keterangan     = isset($data['keterangan']) ? $data['keterangan'] : '';

    // Ambil data lama untuk menghapus file jika ada perubahan foto
    $queryShow = "SELECT foto_dokumentasi FROM tb_laporan_unit WHERE no = ?";
    $stmtShow = mysqli_prepare($conn, $queryShow);
    if (!$stmtShow) {
        return false;
    }
    mysqli_stmt_bind_param($stmtShow, 's', $no);
    mysqli_stmt_execute($stmtShow);
    mysqli_stmt_bind_result($stmtShow, $oldFoto);
    mysqli_stmt_fetch($stmtShow);
    mysqli_stmt_close($stmtShow);

    $uniqueName = $oldFoto;
    if (isset($files['foto_dokumentasi']) && isset($files['foto_dokumentasi']['name']) && $files['foto_dokumentasi']['name'] != "") {
        $tmp = $files['foto_dokumentasi']['tmp_name'] ?? $_FILES['foto_dokumentasi']['tmp_name'] ?? null;
        $orig = basename($files['foto_dokumentasi']['name']);
        $newName = time() . '_' . $orig;
        if ($tmp && @move_uploaded_file($tmp, __DIR__ . '/img/' . $newName)) {
            // remove old file if exists
            if (!empty($oldFoto) && file_exists(__DIR__ . '/img/' . $oldFoto)) {
                @unlink(__DIR__ . '/img/' . $oldFoto);
            }
            $uniqueName = $newName;
        }
    }

    $query = "UPDATE tb_laporan_unit SET tanggal = ?, alat_berat = ?, part_name = ?, part_number = ?, qty = ?, harga_satuan = ?, harga_total = ?, keterangan = ?, foto_dokumentasi = ? WHERE no = ?";
    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, 'ssssisssss', $tanggal, $alat_berat, $part_name, $part_number, $qty, $harga_satuan, $harga_total, $keterangan, $uniqueName, $no);
    $res = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $res;
}

function hapus_data($no){
    global $conn;

    $queryShow = "SELECT foto_dokumentasi FROM tb_laporan_unit WHERE no = ?";
    $stmtShow = mysqli_prepare($conn, $queryShow);
    if ($stmtShow) {
        mysqli_stmt_bind_param($stmtShow, 's', $no);
        mysqli_stmt_execute($stmtShow);
        mysqli_stmt_bind_result($stmtShow, $foto);
        mysqli_stmt_fetch($stmtShow);
        mysqli_stmt_close($stmtShow);

        if (!empty($foto) && file_exists(__DIR__ . '/img/' . $foto)) {
            @unlink(__DIR__ . '/img/' . $foto);
        }
    }

    $query = "DELETE FROM tb_laporan_unit WHERE no = ?";
    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, 's', $no);
    $res = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $res;
}

?>