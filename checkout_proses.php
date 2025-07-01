<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = htmlspecialchars($_POST['nama']);
    $kontak = htmlspecialchars($_POST['kontak']);
    $catatan = htmlspecialchars($_POST['catatan']);
    $user = $_SESSION['user'];
    $cart = $_SESSION['cart'] ?? [];

    // Simpan semua produk ke tabel pesanan
    foreach ($cart as $item) {
        $produk_id = $item['id'];
        mysqli_query($conn, "INSERT INTO pesanan (user_email, produk_id) VALUES ('$user', $produk_id)");
    }

    // Hitung total dan biaya admin
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['harga'];
    }
    $biaya_admin = $total * 0.05;
    $total_final = $total + $biaya_admin;

    // Simpan data ke tabel checkout
    $stmt_checkout = $conn->prepare("INSERT INTO checkout (email_user, total, nama, kontak, catatan) VALUES (?, ?, ?, ?, ?)");
    $stmt_checkout->bind_param("sdsss", $user, $total_final, $nama, $kontak, $catatan);
    $stmt_checkout->execute();

    // Ambil ID dari checkout yang baru dibuat
    $checkout_id = $conn->insert_id;

    // Simpan semua produk ke tabel pesanan
    $stmt_pesanan = $conn->prepare("INSERT INTO pesanan (user_email, produk_id, checkout_id) VALUES (?, ?, ?)");
    foreach ($cart as $item) {
        $produk_id = $item['id'];
        $stmt_pesanan->bind_param("sii", $user, $produk_id, $checkout_id);
        $stmt_pesanan->execute();
    }

    // Hapus keranjang
    unset($_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout Berhasil - Sewantara</title>
    <link rel="stylesheet" href="style/checkout_proses.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <div class="logo">
        <img src="assets/logo-sewantara.png" alt="Logo">
        <span>Sewantara</span>
    </div>
</header>

<div class="success-box">
    <h2>Terima kasih, <?= $nama; ?>! 🎉</h2>
    <p>Pesananmu sudah kami terima dan sedang diproses.</p>
    <p>Kami akan menghubungi kamu lewat WhatsApp di <strong><?= $kontak; ?></strong>.</p>

    <?php if (!empty($catatan)) : ?>
        <p><em>Catatan: <?= nl2br($catatan); ?></em></p>
    <?php endif; ?>

    <a href="user_home.php" class="btn-home">Kembali ke Beranda</a>
</div>

</body>
</html>
