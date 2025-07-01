<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['pesanan_id']);
    $status = $_POST['status'];

    // Validasi status
    $allowed = ['diproses', 'disewa', 'dibatalkan', 'selesai'];
    if (!in_array($status, $allowed)) {
        die('Status tidak valid.');
    }

    // Gunakan prepared statement untuk keamanan
    $stmt = $conn->prepare("UPDATE pesanan SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: admin_checkout.php?status=updated");
    } else {
        header("Location: admin_checkout.php?status=failed");
    }

    $stmt->close();
}
?>