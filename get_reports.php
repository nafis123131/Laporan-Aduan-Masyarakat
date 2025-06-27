<?php
header('Content-Type: application/json');
$status = $_GET['status'] ?? '';
$conn = new mysqli('localhost', 'root', '', 'pengaduan');

if ($status) {
    // Jika ada parameter status, filter berdasarkan status
    $stmt = $conn->prepare("SELECT id, title, type, created_at, status, attachment FROM reports WHERE status = ?");
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT id, title, type, created_at, status, attachment FROM reports";
    $result = $conn->query($sql);
}

$reports = [];
while($row = $result->fetch_assoc()) {
    $reports[] = $row;
}
echo json_encode([
    'success' => true,
    'reports' => $reports
]);
?>