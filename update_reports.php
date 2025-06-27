<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "pengaduan");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Koneksi gagal']);
    exit;
}

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM reports WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Opsi dropdown jenis laporan
    $jenis_options = [
        ['value' => 'Pengaduan', 'label' => 'Pengaduan'],
        ['value' => 'Aspirasi', 'label' => 'Aspirasi']
    ];
    // Opsi dropdown instansi
    $instansi_options = [
        ['value' => 'pu', 'label' => 'Dinas Pekerjaan Umum'],
        ['value' => 'health', 'label' => 'Dinas Kesehatan'],
        ['value' => 'education', 'label' => 'Dinas Pendidikan'],
        ['value' => 'transportation', 'label' => 'Dinas Perhubungan']
    ];

    echo json_encode([
        'success' => true,
        'report' => $row,
        'jenis_options' => $jenis_options,
        'instansi_options' => $instansi_options
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Laporan tidak ditemukan']);
}
?>