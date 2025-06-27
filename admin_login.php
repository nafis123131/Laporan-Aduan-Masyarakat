<?php
// filepath: c:\xampp\htdocs\FinalProject15\admin_login.php
header('Content-Type: application/json');

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "pengaduan");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Koneksi database gagal']);
    exit;
}

// Ambil data dari POST
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Validasi input
if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Email dan password wajib diisi']);
    exit;
}

// Query cek admin
$stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Bandingkan password plain text
    if ($password === $row['password']) {
        echo json_encode(['success' => true, 'admin_id' => $row['id_admin']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Password salah']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Email tidak ditemukan']);
}

$stmt->close();
$conn->close();
?>