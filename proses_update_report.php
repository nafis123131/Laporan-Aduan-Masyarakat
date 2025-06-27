<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "pengaduan");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Koneksi gagal']);
    exit;
}

$id = $_POST['id'] ?? '';
$type = $_POST['type'] ?? '';
$agency = $_POST['agency'] ?? '';

$stmt = $conn->prepare("UPDATE reports SET type=?, agency=? WHERE id=?");
$stmt->bind_param("ssi", $type, $agency, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Update gagal']);
}
$stmt->close();
$conn->close();
?>