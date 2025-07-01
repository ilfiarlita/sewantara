<?php
session_start();
include 'koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: user_home.php");
    exit();
}

$id = (int) $_GET['id'];

// Ambil data produk dari database
$query = mysqli_query($conn, "SELECT * FROM SEWANTARA WHERE id = $id");
$produk = mysqli_fetch_assoc($query);

if (!$produk) {
    header("Location: user_home.php");
    exit();
}

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Cek apakah produk sudah ada di keranjang
$found = false;
foreach ($_SESSION['cart'] as $item) {
    if ($item['id'] == $id) {
        $found = true;
        break;
    }
}

if (!$found) {
    $_SESSION['cart'][] = [
        'id' => $produk['id'],
        'judul' => $produk['judul'],
        'harga' => $produk['harga'],
        'image' => $produk['image'],
        'pemilik' => $produk['pemilik'],
        'alamat' => $produk['alamat'],
        'status' => $produk['status']
    ];
}

header("Location: cart.php");
exit();
