<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "pengaduan");

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Koneksi database gagal']);
    exit;
}

$id = $_POST['id'] ?? 0;
$status = $_POST['status'] ?? '';
$response = $_POST['response'] ?? '';

$stmt = $conn->prepare("UPDATE reports SET status = ?, response = ? WHERE id = ?");
$stmt->bind_param("ssi", $status, $response, $id);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal update laporan']);
}
$stmt->close();
$conn->close();
?>