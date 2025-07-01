<?php
session_start();
include 'koneksi.php';

$id = $_GET['id'] ?? '';
if (!$id) {
    header("Location: read.php");
    exit;
}

// Ambil data dari database
$query = "SELECT * FROM sewantara WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    header("Location: read.php");
    exit;
}

// Masukkan satu item ini ke cart (ganti cart jadi hanya item ini)
$_SESSION['cart'] = [[
    'id' => $data['id'],
    'judul' => $data['judul'],
    'pemilik' => $data['pemilik'],
    'alamat' => $data['alamat'],
    'harga' => $data['harga'],
    'image' => $data['image']
]];

// Simulasikan bahwa item ini dipilih
$_POST['selected_items'] = [$data['id']];

// Redirect ke checkout
header("Location: checkout.php");
exit;
