<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Keranjang - Sewantara</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/user_style.css">
    <link rel="stylesheet" href="style/cart_style.css">
</head>

<body>

    <header>
        <div class="logo">
            <img src="assets/logo-sewantara.png" alt="Logo">
            <span>Sewantara</span>
        </div>
        <nav>
            <a href="user_home.php">Beranda</a>
        </nav>
    </header>

    <div class="cart-container">
        <h2>Keranjang Belanja</h2>

        <?php if (count($cart) === 0): ?>
            <div class="empty">
                Keranjangmu masih kosong 😢<br><br>
                <a href="user_home.php" class="checkout-btn">Mulai Belanja</a>
            </div>
        <?php else: ?>
            <form action="checkout.php" method="post">
                <?php foreach ($cart as $index => $item): ?>
                    <div class="cart-item">
                        <input type="checkbox" name="selected_items[]" value="<?= $item['id']; ?>" checked>
                        <img src="foto_mentah/<?= $item['image']; ?>" alt="<?= $item['judul']; ?>">
                        <h3><?= $item['judul']; ?></h3>
                        <p><strong>Pemilik:</strong> <?= $item['pemilik']; ?></p>
                        <p><strong>Alamat:</strong> <?= $item['alamat']; ?></p>
                        <p class="harga">Rp<?= number_format($item['harga'], 0, ',', '.'); ?></p>
                    </div>
                    <div class="cart-action">
                        <a href="remove_from_cart.php?index=<?= $index; ?>">Hapus</a>
                    </div>
                <?php endforeach; ?>

                <div style="text-align:center;">
                    <button type="submit" class="checkout-btn">Checkout Produk Terpilih</button>
                </div>
            </form>
        <?php endif; ?>
    </div>

</body>

</html>