<?php
 //filepath: c:\xampp\htdocs\Baru\FinalProject15\update_status.php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "pengaduan");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Koneksi gagal']);
    exit;
}
$id = $_POST['id'] ?? '';
$status = $_POST['status'] ?? '';
if (!$id || !$status) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    exit;
}
$stmt = $conn->prepare("UPDATE reports SET status=? WHERE id=?");
$stmt->bind_param("si", $status, $id);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal update status']);
}
$stmt->close();
$conn->close();
?> 