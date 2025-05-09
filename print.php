<?php
require 'vendor/autoload.php'; // Composer autoload

use Dompdf\Dompdf;

// Ambil koneksi
include 'koneksi.php';

// Ambil filter dari URL
$query = "SELECT * FROM tb_laporan_unit WHERE 1=1";

// Tambahkan filter tahun jika ada
if (isset($_GET['filter_tahun']) && $_GET['filter_tahun'] != '') {
    $filter_tahun = $_GET['filter_tahun'];
    $query .= " AND YEAR(tanggal) = '$filter_tahun'";
}

// Tambahkan filter bulan jika ada
if (isset($_GET['filter_bulan']) && $_GET['filter_bulan'] != '') {
    $filter_bulan = $_GET['filter_bulan'];
    $filter_tahun = date('Y', strtotime($filter_bulan));
    $filter_bulan = date('m', strtotime($filter_bulan));
    $query .= " AND MONTH(tanggal) = '$filter_bulan' AND YEAR(tanggal) = '$filter_tahun'";
}

// Tambahkan filter alat berat jika ada
if (isset($_GET['filter_alat_berat']) && $_GET['filter_alat_berat'] != '') {
    $filter_alat_berat = $_GET['filter_alat_berat'];
    $query .= " AND alat_berat = '$filter_alat_berat'";
}

// Eksekusi query
$result = mysqli_query($conn, $query);

// Mulai output HTML untuk PDF
$html = '<h2 style="text-align: center;">Laporan Perawatan Alat Berat</h2>';
$html .= '<table border="1" cellspacing="0" cellpadding="5" style="width: 100%; border-collapse: collapse;">';
$html .= '<thead>
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Alat Berat</th>
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
                <td>' . $row['alat_berat'] . '</td>
                <td>' . $row['part_name'] . '</td>
                <td>' . $row['part_number'] . '</td>
                <td>' . $row['qty'] . '</td>
                <td>' . $row['harga_satuan'] . '</td>
                <td>' . $row['harga_total'] . '</td>
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

// Inisialisasi Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// Set ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'portrait');

// Tentukan nama file berdasarkan filter
$nama_file = "laporan_perawatan";

if (isset($_GET['filter_bulan']) && $_GET['filter_bulan'] != '') {
    $bulan = date('F', strtotime($_GET['filter_bulan'])); // Nama bulan
    $nama_file .= "_$bulan";
}

if (isset($_GET['filter_tahun']) && $_GET['filter_tahun'] != '') {
    $tahun = $_GET['filter_tahun'];
    $nama_file .= "_$tahun";
}

if (isset($_GET['filter_alat_berat']) && $_GET['filter_alat_berat'] != '') {
    $alat_berat = str_replace(' ', '_', $_GET['filter_alat_berat']); // Ganti spasi dengan underscore
    $nama_file .= "_$alat_berat";
}

$nama_file .= ".pdf"; // Tambahkan ekstensi file

// Render HTML ke PDF
$dompdf->render();

// Output file PDF
$dompdf->stream($nama_file, ["Attachment" => true]);
?>