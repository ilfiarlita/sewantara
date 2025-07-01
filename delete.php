<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus gambar dari folder juga (opsional)
    $getGambar = mysqli_query($conn, "SELECT image FROM sewantara WHERE id = $id");
    $dataGambar = mysqli_fetch_assoc($getGambar);
    $gambarPath = 'foto_mentah/' . $dataGambar['image'];
    if (file_exists($gambarPath)) {
        unlink($gambarPath);
    }

    // Hapus data dari database
    $query = "DELETE FROM sewantara WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil dihapus!'); window.location.href='read.php';</script>";
    } else {
        echo "Gagal menghapus: " . mysqli_error($conn);
    }
} else {
    echo "ID tidak ditemukan.";
}
?>
