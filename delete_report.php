<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "pengaduan");

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Koneksi database gagal']);
    exit;
}

$id = $_POST['id'] ?? 0;
$stmt = $conn->prepare("DELETE FROM reports WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menghapus laporan']);
}
$stmt->close();
$conn->close();
?>