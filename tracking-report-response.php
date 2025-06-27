<?php
require('fpdf/fpdf.php');

// Ambil ID dari GET
$id_laporan = $_GET['id'] ?? '';
$status = $_GET['status'] ?? 'pending';

// Query data laporan dari database
$stmt = $conn->prepare("SELECT id, title, created_at FROM reports WHERE id = ?");
$stmt->bind_param("s", $id_laporan);
$stmt->execute();
$result = $stmt->get_result();
$report = $result->fetch_assoc();

if (!$report) {
    die('Laporan tidak ditemukan');
}

// Data dinamis dari database
$judul = $report['title'];
$tanggal_laporan = $report['created_at'];
$tanggal_surat = date("d F Y");

// MULAI BUAT PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetMargins(20, 20, 20);

// KOP SURAT
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 7, 'LAYANAN ASPIRASI DAN PENGADUAN ONLINE', 0, 1, 'C');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 6, 'Jl. Pelayanan Publik No.1, Jakarta | Email: layanan@aspirasi.go.id', 0, 1, 'C');
$pdf->Ln(2);
$pdf->Line(20, $pdf->GetY(), 190, $pdf->GetY()); // Garis horizontal
$pdf->Ln(10);

// JUDUL SURAT
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, 'TANGGAPAN RESMI LAPORAN MASYARAKAT', 0, 1, 'C');
$pdf->Ln(5);

// INFORMASI LAPORAN
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 8,
    "Kepada Yth,\nPelapor Laporan ID: $id_laporan\n\nDengan hormat,\n\nKami ingin menyampaikan status laporan Anda dengan rincian sebagai berikut:\n\n".
    "Judul Laporan: $judul\nTanggal Dikirim: $tanggal_laporan\nStatus Saat Ini: ".strtoupper($status)."\n"
);
$pdf->Ln(5);

// ISI TANGGAPAN BERDASARKAN STATUS
if ($status == 'pending') {
    $pesan = "Kami mengucapkan terima kasih atas laporan yang telah Anda sampaikan. Laporan Anda sudah kami terima dan akan segera kami teruskan ke instansi terkait untuk diproses lebih lanjut. Mohon bersabar dan tetap pantau perkembangan melalui situs kami.";
} elseif ($status == 'inprogress') {
    $pesan = "Kami informasikan bahwa laporan Anda telah kami teruskan kepada instansi terkait dan saat ini sedang dalam proses penanganan. Terima kasih atas partisipasi Anda dalam membantu memperbaiki layanan publik.";
} elseif ($status == 'done') {
    $pesan = "Kami menginformasikan bahwa laporan Anda telah diselesaikan oleh pihak yang berwenang. Kami sangat menghargai kontribusi Anda terhadap perbaikan fasilitas dan layanan publik.";
} else {
    $pesan = "Status laporan tidak dikenali. Silakan hubungi admin untuk informasi lebih lanjut.";
}

$pdf->MultiCell(0, 8, $pesan);
$pdf->Ln(10);

// PENUTUP
$pdf->MultiCell(0, 8, "Demikian tanggapan dari kami. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.\n\nHormat kami,");
$pdf->Ln(20);

// TANDA TANGAN
$pdf->Cell(0, 8, 'Kepala Layanan Aspirasi dan Pengaduan', 0, 1, 'L');
$pdf->Ln(15);
$pdf->Cell(0, 8, 'Drs. Ahmad Subari', 0, 1, 'L');
$pdf->Cell(0, 8, 'NIP. 19651112 199003 1 003', 0, 1, 'L');

// KAKI SURAT (opsional tanggal)
$pdf->SetY(-30);
$pdf->SetFont('Arial','I',9);
$pdf->Cell(0, 10, 'Dicetak pada tanggal: ' . $tanggal_surat, 0, 0, 'C');

$pdf->Output();
?>
