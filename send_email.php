<?php
// Kirim Email Notifikasi Status Laporan

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php'; // composer autoload

function sendEmailStatus($email, $nama, $judulLaporan, $statusBaru) {
    $mail = new PHPMailer(true);

    try {
        // Konfigurasi SMTP Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'akunmu@gmail.com';        // GANTI
        $mail->Password = 'app_password_googlemu';   // GANTI
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('akunmu@gmail.com', 'Layanan Aspirasi');
        $mail->addAddress($email, $nama);

        $mail->isHTML(true);
        $mail->Subject = 'Update Status Laporan Anda';
        $mail->Body = "
            Halo <b>$nama</b>,<br><br>
            Laporan Anda dengan judul <i>\"$judulLaporan\"</i> telah diperbarui.<br>
            Status terkini: <b>$statusBaru</b><br><br>
            Terima kasih telah menggunakan layanan kami.
        ";

        $mail->send();
    } catch (Exception $e) {
        error_log("Gagal kirim email: " . $mail->ErrorInfo);
    }
}
