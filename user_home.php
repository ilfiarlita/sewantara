<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$produkCarousel = mysqli_query($conn, "SELECT * FROM SEWANTARA LIMIT 5");
$kategoriResult = mysqli_query($conn, "SELECT DISTINCT kategori FROM SEWANTARA");

$kategoriList = [];
while ($row = mysqli_fetch_assoc($kategoriResult)) {
    $kategoriList[] = $row['kategori'];
}
?>

<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Sewantara - Beranda</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style/user_style.css">
    </head>
    <body>
        <header>
            <div class="logo">
                <img src="assets/logo-sewantara.png" alt="Logo">
                <span>Sewantara</span>
            </div>
            <nav>
                <a href="#beranda">Beranda</a>
                <a href="#kategori"><img src="assets/icon-kategori.png" alt="Kategori"></a>
                <a href="cart.php"><img src="assets/icon-cart.png" alt="Keranjang"></a>
                <a href="history.php"><img src="assets/icon-history.png" alt="histori"></a>
                <a href="chat_user.php"><img src="assets/icon-chat.png" alt="Chat"></a>
                <a href="logout.php"><img src="assets/icon-logout.png" alt="logout"></a>
            </nav>
        </header>

        <section class="carousel" id="beranda">
            <div class="carousel-inner">
                <?php while ($row = mysqli_fetch_assoc($produkCarousel)) : ?>
                    <img src="foto_mentah/<?= $row['image']; ?>" alt="<?= $row['judul']; ?>">
                <?php endwhile; ?>
            </div>
        </section>

        <section class="intro">
            <img src="assets/logo-sewantara.png" alt="Sewantara">
            <div class="intro-text">
                <p><strong>Sewantara</strong> adalah platform penyewaan lapak jualan seperti ruko, kios pasar, booth bazaar, dan lapak outdoor. Sekali Klik, Lapak Impianmu Terwujud!</p>
            </div>
        </section>

        <section class="kategori-section" id="kategori">
            <h2>Kategori</h2>
            <div class="kategori-grid">
                <?php foreach ($kategoriList as $kategori) : 
                    $idKategori = strtolower(str_replace([' ', '/'], '-', $kategori));
                ?>
                <a href="#<?= $idKategori; ?>" class="kategori-link">
                    <div class="kategori-item">
                        <img src="assets/icon-<?= $idKategori; ?>.png" alt="<?= $kategori; ?>">
                        <span><?= $kategori; ?></span>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="produk-per-kategori">
            <?php foreach ($kategoriList as $kategori) :
                $idKategori = strtolower(str_replace([' ', '/'], '-', $kategori));
                $produkQuery = mysqli_query($conn, "SELECT * FROM SEWANTARA WHERE kategori = '$kategori'");
            ?>
            <div class="produk-kategori" id="<?= $idKategori; ?>">
                <h3><?= $kategori; ?></h3>
                <div class="produk-grid">
                    <?php while ($produk = mysqli_fetch_assoc($produkQuery)) : ?>
                    <div class="produk-card">
                        <img src="foto_mentah/<?= $produk['image']; ?>" alt="<?= $produk['judul']; ?>">
                        <h4><?= $produk['judul']; ?></h4>
                        <p><strong>Pemilik:</strong> <?= $produk['pemilik']; ?></p>
                        <p><strong>Alamat:</strong> <?= $produk['alamat']; ?></p>
                        <p><strong>Status:</strong> <?= $produk['status']; ?></p>
                        <p><strong>Periode:</strong> <?= $produk['periode']; ?></p>
                        <p class="harga">Rp<?= number_format($produk['harga'], 0, ',', '.'); ?></p>
                        <div class="produk-actions">
                            <a href="add_to_cart.php?id=<?= $produk['id']; ?>">
                                <img src="assets/icon-cart.png" alt="Tambah ke Keranjang"> Tambah
                            </a>
                            <a href="checkout.php?id=<?= $produk['id']; ?>">
                                <img src="assets/icon-checkout.png" alt="Pesan Sekarang"> Sewa
                            </a>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </section>

        <section class="ajakan">
            <p>Hubungi nomor berikut untuk mendaftarkan lapakmu: <strong>085646224839</strong></p>
        </section>

    </body>
</html>
