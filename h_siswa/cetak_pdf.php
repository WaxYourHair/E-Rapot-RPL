<?php
session_start();
include_once '../functions.php'; // Ensure this path is correct

// Ensure no output before PDF creation
ob_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'siswa') {
    header("Location: login.php");
    exit();
}

// Include autoload file from Composer
require_once('../vendor/autoload.php'); // Ensure this path is correct

$nis = $_SESSION['user']['nis'];
$nilai_siswa = getNilaiSiswa($nis);

// Example student data
$nama_siswa = $_SESSION['user']['nama']; // Get name from session
$kelas = "1A - Kelas 1A";
$semester = "Ganjil";
$tahun_ajaran = "2018-2019";
$tanggal_cetak = date("d M Y");

$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sistem Raport');
$pdf->SetTitle('Cetak Raport');
$pdf->SetHeaderData('', '', 'Cetak Raport', '');
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(10, 10, 10); // Set margin
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->SetFont('helvetica', '', 10); // Adjust font size
$pdf->AddPage();

// Create header
$html = '
<h3 style="text-align:center;">SD NEGERI 02 AMBAN</h3>
<h3 style="text-align:center;">Akreditasi B</h3>
<hr style="border:1px solid;">
<p style="text-align:right;">Alamat : Jl. Gunung Salju RT 001 / RW 001 Amban, Kel. Amban, Kec. Manokwari Barat, Kab. Manokwari - Papua Barat</p>
<h4 style="text-align:center;">DATA HASIL BELAJAR SISWA</h4>
<h4 style="text-align:center;">RAPORT SISWA</h4>
<br>
<table>
    <tr>
        <td width="150"><b>NIS</b></td>
        <td width="20">:</td>
        <td width="250">' . htmlspecialchars($nis) . '</td>
        <td width="100"><b>Tahun Ajaran</b></td>
        <td width="20">:</td>
        <td>' . htmlspecialchars($tahun_ajaran) . '</td>
    </tr>
    <tr>
        <td width="150"><b>Nama Siswa</b></td>
        <td width="20">:</td>
        <td width="250">' . htmlspecialchars($nama_siswa) . '</td>
        <td width="100"><b>Semester</b></td>
        <td width="20">:</td>
        <td>' . htmlspecialchars($semester) . '</td>
    </tr>
    <tr>
        <td width="150"><b>Kelas</b></td>
        <td width="20">:</td>
        <td width="250">' . htmlspecialchars($kelas) . '</td>
    </tr>
</table>
<br>
<table border="1" cellpadding="4">
    <thead>
        <tr>
            <th rowspan="2" style="text-align:center;">MATA PELAJARAN</th>
            <th colspan="4" style="text-align:center;">NILAI</th>
            <th rowspan="2" style="text-align:center;">NILAI AKHIR</th>
            <th rowspan="2" style="text-align:center;">PREDIKAT</th>
            <th rowspan="2" style="text-align:center;">KETERANGAN</th>
        </tr>
        <tr>
            <th style="text-align:center;">RTP</th>
            <th style="text-align:center;">RNU</th>
            <th style="text-align:center;">PTS</th>
            <th style="text-align:center;">UAS</th>
        </tr>
    </thead>
    <tbody>';

foreach ($nilai_siswa as $nilai) {
    // Convert predikat to letter grades
    $predikat = '';
    if ($nilai['nilai_akhir'] >= 90) {
        $predikat = 'A';
    } elseif ($nilai['nilai_akhir'] >= 80) {
        $predikat = 'B';
    } elseif ($nilai['nilai_akhir'] >= 70) {
        $predikat = 'C';
    } else {
        $predikat = 'D';
    }

    $html .= '<tr>
                <td>' . htmlspecialchars($nilai['nama_mp']) . '</td>
                <td style="text-align:center;">' . htmlspecialchars($nilai['nilai_tp1']) . '</td>
                <td style="text-align:center;">' . htmlspecialchars($nilai['nilai_tp2']) . '</td>
                <td style="text-align:center;">' . htmlspecialchars($nilai['nilai_tp3']) . '</td>
                <td style="text-align:center;">' . htmlspecialchars($nilai['nilai_tp4']) . '</td>
                <td style="text-align:center;">' . htmlspecialchars($nilai['nilai_akhir']) . '</td>
                <td style="text-align:center;">' . htmlspecialchars($predikat) . '</td>
                <td>' . htmlspecialchars($nilai['deskripsi']) . '</td>
            </tr>';
}

$html .= '</tbody>
</table>
<p style="text-align:right;">Manokwari, ' . htmlspecialchars($tanggal_cetak) . '</p>
<table>
    <tr>
        <td class="text-center" width="500">
            Kepala Sekolah
            <br>
            SD NEGERI 02 AMBAN
            <br>
            <br>
            <br>
            <br>
            <u>Nama Kepala Sekolah</u>
            <br>
            NIP. 123456789
        </td>
        <td class="text-center" width="500">
            Wali Kelas
            <br>
            <br>
            <br>
            <br>
            <u>Nama Wali Kelas</u>
            <br>
            NIP. 987654321
        </td>
    </tr>
</table>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('raport.pdf', 'I');

ob_end_flush(); // Stop output buffering and output everything
?>
