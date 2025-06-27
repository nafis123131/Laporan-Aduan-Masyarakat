<?php
require('fpdf/fpdf.php');

// Contoh data dari laporan
$id_laporan = $_GET['id'] ?? 'RPT-9';
$judul = "Rambu lalu lintas di perempatan UPN mati";
$status = $_GET['status'] ?? 'inprogress'; // Bisa pending, inprogress, done
$tanggal = date("Y-m-d H:i:s");

// Membuat PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'Tanggapan Resmi Laporan',0,1,'C');
$pdf->Ln(10);

// Isi surat berdasarkan status
$pdf->SetFont('Arial','',12);
$pdf->MultiCell(0,8,"ID Laporan: $id_laporan\nTanggal: $tanggal\nJudul: $judul\nStatus: $status\n");

$pdf->Ln(5);
if ($status == 'pending') {
    $pdf->MultiCell(0,8,"Terima kasih atas laporan Anda.\nKami telah menerima laporan Anda dan akan segera menyampaikannya ke instansi terkait. Mohon bersabar menunggu proses selanjutnya.");
} elseif ($status == 'inprogress') {
    $pdf->MultiCell(0,8,"Laporan Anda telah diteruskan dan saat ini sedang dalam proses pengerjaan oleh instansi yang bersangkutan.\nKami akan terus memantau perkembangannya.");
} elseif ($status == 'done') {
    $pdf->MultiCell(0,8,"Laporan Anda telah diselesaikan.\nTerima kasih telah berkontribusi dalam peningkatan layanan publik.");
} else {
    $pdf->MultiCell(0,8,"Status laporan tidak dikenali.");
}

$pdf->Output();
?>
