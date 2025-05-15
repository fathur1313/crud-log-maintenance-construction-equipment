<?php
require 'vendor/autoload.php'; // Composer autoload

use Dompdf\Dompdf;

// Ambil koneksi
include 'koneksi.php';

// Query dasar
$query = "SELECT * FROM tb_laporan_unit WHERE 1=1";

// Query untuk menghitung total biaya
$query_total = "SELECT SUM(harga_total) AS total_biaya FROM tb_laporan_unit WHERE 1=1";

// Tambahkan filter bulan dan tahun jika ada
if (isset($_GET['filter_bulan_tahun']) && $_GET['filter_bulan_tahun'] != '') {
    $filter_bulan_tahun = $_GET['filter_bulan_tahun'];
    if (preg_match('/^\d{4}-\d{2}$/', $filter_bulan_tahun)) { // Validasi format YYYY-MM
        $filter_bulan = date('m', strtotime($filter_bulan_tahun));
        $filter_tahun = date('Y', strtotime($filter_bulan_tahun));
        $query .= " AND MONTH(tanggal) = '$filter_bulan' AND YEAR(tanggal) = '$filter_tahun'";
        $query_total .= " AND MONTH(tanggal) = '$filter_bulan' AND YEAR(tanggal) = '$filter_tahun'";
    }
}

// Tambahkan filter alat berat jika ada
if (isset($_GET['filter_alat_berat']) && $_GET['filter_alat_berat'] != '') {
    $filter_alat_berat = $_GET['filter_alat_berat'];
    $query .= " AND alat_berat = '$filter_alat_berat'";
    $query_total .= " AND alat_berat = '$filter_alat_berat'";
}

// Eksekusi query untuk data tabel
$result = mysqli_query($conn, $query);
if (!$result) {
    die('Query Error: ' . mysqli_error($conn));
}

// Eksekusi query untuk total biaya
$result_total = mysqli_query($conn, $query_total);
$total_biaya = 0;
if ($result_total) {
    $row_total = mysqli_fetch_assoc($result_total);
    $total_biaya = $row_total['total_biaya'] ?? 0; // Jika null, set ke 0
}

// Mulai output HTML untuk PDF
$kop_surat_path = realpath(__DIR__ . '/img/Logo/kop_surat.png');
if ($kop_surat_path && file_exists($kop_surat_path)) {
    $kop_surat_data = base64_encode(file_get_contents($kop_surat_path));
    $kop_surat_type = mime_content_type($kop_surat_path);
    $html = '<div style="text-align: center; margin-bottom: 20px;">
                <img src="data:' . $kop_surat_type . ';base64,' . $kop_surat_data . '" style="width: 100%; max-height: 150px;" alt="Kop Surat">
             </div>';
} else {
    $html = '<div style="text-align: center; margin-bottom: 20px;">
                <p style="color: red;">Kop surat tidak ditemukan.</p>
             </div>';
}

$html .= '<h2 style="text-align: center;">Laporan Perawatan Alat Berat</h2>';

// Tambahkan keterangan filter
$periode = '';
if (isset($filter_bulan_tahun)) {
    $bulan = date('F', strtotime($filter_bulan_tahun));
    $tahun = date('Y', strtotime($filter_bulan_tahun));
    $periode = "Periode: Bulan $bulan Tahun $tahun";
}
if (isset($filter_alat_berat) && $filter_alat_berat != '') {
    $periode .= "<br>Alat Berat: $filter_alat_berat";
}
$html .= '<p style="text-align: left; margin-left: 10px;">' . $periode . '</p>';

$html .= '<table border="1" cellspacing="0" cellpadding="5" style="width: 100%; border-collapse: collapse;">';
$html .= '<thead>
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Part Name</th>
                <th>Part Number</th>
                <th>Qty</th>
                <th>Harga Satuan</th>
                <th>Harga Total</th>
                <th>Keterangan</th>
                <th>Foto</th>
            </tr>
          </thead>';
$html .= '<tbody>';

$no = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $html .= '<tr>
                <td>' . (++$no) . '</td>
                <td>' . date('d F Y', strtotime($row['tanggal'])) . '</td>
                <td>' . $row['part_name'] . '</td>
                <td>' . $row['part_number'] . '</td>
                <td>' . $row['qty'] . '</td>
                <td>' . number_format($row['harga_satuan'], 0, ',', '.') . '</td>
                <td>' . number_format($row['harga_total'], 0, ',', '.') . '</td>
                <td>' . $row['keterangan'] . '</td>';
    $img_path = realpath($_SERVER['DOCUMENT_ROOT'] . '/crud_perusahaan/img/' . $row['foto_dokumentasi']);
    if ($img_path && file_exists($img_path)) {
        $img_data = base64_encode(file_get_contents($img_path));
        $img_type = mime_content_type($img_path);
        $html .= '<td><img src="data:' . $img_type . ';base64,' . $img_data . '" style="width: 125px"></td>';
    } else {
        $html .= '<td>Gambar tidak ditemukan</td>';
    }
      $html .= '</tr>';
}

$html .= '</tbody></table>';

// Tambahkan total biaya di bawah tabel
$html .= '<p style="text-align: right; margin-top: 20px; font-size: 16px;">
            <strong>Total Biaya: Rp ' . number_format($total_biaya, 0, ',', '.') . '</strong>
          </p>';

// Inisialisasi Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// Set ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'portrait');

// Tentukan nama file berdasarkan filter
$nama_file = "laporan_perawatan";
if (isset($filter_bulan_tahun) && $filter_bulan_tahun != '') {
    $bulan = date('F', strtotime($filter_bulan_tahun));
    $tahun = date('Y', strtotime($filter_bulan_tahun));
    $nama_file .= "_{$bulan}_{$tahun}";
}
if (isset($filter_alat_berat) && $filter_alat_berat != '') {
    $nama_file .= "_{$filter_alat_berat}";
}
$nama_file .= ".pdf";

// Render HTML ke PDF
$dompdf->render();

// Output file PDF
$dompdf->stream($nama_file, ["Attachment" => true]);
?>
