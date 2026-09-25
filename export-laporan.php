<?php
require 'vendor/autoload.php';
require_once 'koneksi.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Header Kolom Excel
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'ID Tamu');
$sheet->setCellValue('C1', 'Tanggal');
$sheet->setCellValue('D1', 'Nama Tamu');
$sheet->setCellValue('E1', 'Alamat');
$sheet->setCellValue('F1', 'No. HP');
$sheet->setCellValue('G1', 'Bertemu');
$sheet->setCellValue('H1', 'Kepentingan');

$tgl_awal = $_POST['tgl_awal'] ?? '';
$tgl_akhir = $_POST['tgl_akhir'] ?? '';

if (!empty($tgl_awal) && !empty($tgl_akhir)) {
    $query = "SELECT * FROM buku_tamu WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY tanggal ASC";
} else {
    $query = "SELECT * FROM buku_tamu ORDER BY tanggal ASC";
}

$data = mysqli_query($koneksi, $query);

$i = 2;
$no = 1;

while ($d = mysqli_fetch_array($data)) {
    $sheet->setCellValue('A' . $i, $no++);
    $sheet->setCellValue('B' . $i, $d['id_tamu']);
    $sheet->setCellValue('C' . $i, $d['tanggal']);
    $sheet->setCellValue('D' . $i, $d['nama_tamu']);
    $sheet->setCellValue('E' . $i, $d['alamat']);
    $sheet->setCellValue('F' . $i, $d['no_hp']);
    $sheet->setCellValue('G' . $i, $d['bertemu']);
    $sheet->setCellValue('H' . $i, $d['kepentingan']);
    $i++;
}

$filename = 'Laporan_Buku_Tamu_' . date('Y-m-d_H-i-s') . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>