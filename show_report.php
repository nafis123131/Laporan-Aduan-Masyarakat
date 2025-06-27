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
    echo json_encode(['success' => true, 'report' => $row]);
} else {
    echo json_encode(['success' => false, 'message' => 'Laporan tidak ditemukan']);
}
?>