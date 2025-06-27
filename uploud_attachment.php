
<?php
header('Content-Type: application/json');

// Folder tujuan upload (pastikan folder ini sudah ada dan permission-nya benar)
$targetDir = "uploads/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['attachment']['tmp_name'];
    $fileName = basename($_FILES['attachment']['name']);
    $fileSize = $_FILES['attachment']['size'];
    $fileType = $_FILES['attachment']['type'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Validasi ekstensi file (misal: hanya gambar/pdf)
    $allowedExts = ['jpg', 'jpeg', 'png', 'pdf'];
    if (!in_array($fileExt, $allowedExts)) {
        echo json_encode(['success' => false, 'message' => 'Ekstensi file tidak diizinkan']);
        exit;
    }

    // Rename file agar unik
    $newFileName = uniqid('lampiran_', true) . '.' . $fileExt;
    $destPath = $targetDir . $newFileName;

    if (move_uploaded_file($fileTmpPath, $destPath)) {
        echo json_encode([
            'success' => true,
            'file' => $newFileName,
            'url' => $destPath // atau bisa pakai URL lengkap jika perlu
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal upload file']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Tidak ada file yang diupload']);
}
?>