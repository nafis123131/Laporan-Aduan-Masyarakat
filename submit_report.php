<?php
header('Content-Type: application/json');

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "pengaduan"); // Ganti nama_database_anda

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Koneksi database gagal']);
    exit;
}

// Ambil data dari POST
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$type = $_POST['type'] ?? '';
$title = $_POST['title'] ?? '';
$content = $_POST['content'] ?? '';
$location = $_POST['location'] ?? '';
$agency = $_POST['agency'] ?? '';
$attachment = $_POST['attachment'] ?? null;
$status = 'draf';

// Validasi data wajib
if ($name && $email && $type && $title && $content && $location && $agency) {
    $stmt = $conn->prepare("INSERT INTO reports (name, email, type, title, content, location, agency, attachment, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssssssss", $name, $email, $type, $title, $content, $location, $agency, $attachment, $status);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'report_id' => $stmt->insert_id]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan laporan']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
}
$conn->close();
?>