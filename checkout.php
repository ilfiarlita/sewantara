<?php
session_start();
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    header("Location: cart.php");
    exit();
}
$filteredCart = $cart;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Checkout - Sewantara</title>
    <link rel="stylesheet" href="style/checkout_style.css">
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
            <a href="cart.php"><img src="assets/icon-cart.png" alt="Cart" style="width: 20px; height: 20px;"></a>
        </nav>
    </header>

    <div class="checkout-container">
        <h2>Checkout</h2>

        <div class="checkout-summary">
            <?php
            $total = 0;
            foreach ($filteredCart as $item): ?>
                <div class="line-item">
                    <span><strong><?= htmlspecialchars($item['judul']); ?></strong></span>
                    <span class="price">Rp<?= number_format($item['harga'], 0, ',', '.'); ?></span>
                </div>
                <?php $total += $item['harga']; ?>
            <?php endforeach;

            $biaya_admin = $total * 0.05;
            $total_final = $total + $biaya_admin;
            ?>

            <div class="line-item">
                <span><strong>Subtotal</strong></span>
                <span class="price">Rp<?= number_format($total, 0, ',', '.'); ?></span>
            </div>
            <div class="line-item">
                <span><strong>Biaya Admin (5%)</strong></span>
                <span class="price">Rp<?= number_format($biaya_admin, 0, ',', '.'); ?></span>
            </div>
            <div class="line-item total-akhir">
                <span>Total Akhir</span>
                <span class="price">Rp<?= number_format($total_final, 0, ',', '.'); ?></span>
            </div>
        </div>
        <form action="checkout_proses.php" method="post" class="checkout-form">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" required>

            <label>Nomor WhatsApp</label>
            <input type="text" name="kontak" required>

            <label>Catatan (opsional)</label>
            <textarea name="catatan" rows="3"></textarea>

            <button type="submit">Konfirmasi Checkout</button>
        </form>

    </div>

</body>

</html>