<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
$query = "SELECT p.*, s.judul, s.image, s.harga, s.pemilik, s.alamat
          FROM pesanan p
          JOIN SEWANTARA s ON p.produk_id = s.id
          WHERE p.user_email = '$user'
          ORDER BY p.tanggal_pesan DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Histori Pesanan - Sewantara</title>
        <link rel="stylesheet" href="style/history_style.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    </head>
    <body>
        <header>
            <div class="logo">
                <img src="assets/logo-sewantara.png" alt="Logo">
                <span>Sewantara</span>
            </div>
            <nav>
                <a href="user_home.php">Beranda</a>
                <a href="cart.php">Keranjang</a>
                <a href="checkout.php">Checkout</a>
            </nav>
        </header>

        <div class="history-container">
            <h2>Histori Pesananmu</h2>

            <?php if (mysqli_num_rows($result) == 0): ?>
                <p class="empty">Belum ada pesanan yang dilakukan.</p>
            <?php else: ?>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <div class="history-card">
                        <img src="foto_mentah/<?= $row['image']; ?>" alt="<?= $row['judul']; ?>">
                        <div class="history-info">
                            <h3><?= $row['judul']; ?></h3>
                            <p><strong>Harga:</strong> Rp<?= number_format($row['harga'], 0, ',', '.'); ?></p>
                            <p><strong>Pemilik:</strong> <?= $row['pemilik']; ?></p>
                            <p><strong>Alamat:</strong> <?= $row['alamat']; ?></p>
                            <p><strong>Status:</strong> <?= ucfirst($row['status']); ?></p>
                            <p><em>Pesan pada <?= date('d M Y H:i', strtotime($row['tanggal_pesan'])); ?></em></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </body>
</html>
