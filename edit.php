<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM sewantara WHERE id = $id");
    $data = mysqli_fetch_assoc($result);
} else {
    echo "ID tidak ditemukan.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $pemilik = $_POST['pemilik'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $periode = $_POST['periode'];
    $alamat = $_POST['alamat'];
    $status = $_POST['status'];

    // Cek apakah ada file baru yang diupload
    if ($_FILES['image']['name'] != "") {
        $gambar_name = $_FILES['image']['name'];
        $gambar_tmp = $_FILES['image']['tmp_name'];
        $upload_dir = "foto_mentah/";

        // Hapus gambar lama
        if (file_exists($upload_dir . $data['image'])) {
            unlink($upload_dir . $data['image']);
        }

        move_uploaded_file($gambar_tmp, $upload_dir . $gambar_name);

        $sql = "UPDATE sewantara SET 
                judul='$judul', pemilik='$pemilik', kategori='$kategori', harga='$harga', 
                periode='$periode', alamat='$alamat', status='$status', image='$gambar_name' 
                WHERE id=$id";
    } else {
        $sql = "UPDATE sewantara SET 
                judul='$judul', pemilik='$pemilik', kategori='$kategori', harga='$harga', 
                periode='$periode', alamat='$alamat', status='$status' 
                WHERE id=$id";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data berhasil diupdate!'); window.location.href='read.php';</script>";
    } else {
        echo "Gagal update: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Kios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Data Kios</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Judul</label>
                <input type="text" name="judul" class="form-control" value="<?= $data['judul']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Pemilik</label>
                <input type="text" name="pemilik" class="form-control" value="<?= $data['pemilik']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Kategori</label>
                <select name="kategori" class="form-control" required>
                    <option value="Ruko" <?= ($data['kategori'] == "Ruko") ? 'selected' : '' ?>>Ruko</option>
                    <option value="Kios Pasar" <?= ($data['kategori'] == "Kios Pasar") ? 'selected' : '' ?>>Kios Pasar</option>
                    <option value="Booth/Bazaar" <?= ($data['kategori'] == "Booth/Bazaar") ? 'selected' : '' ?>>Booth/Bazaar</option>
                    <option value="Lapak Outdoor" <?= ($data['kategori'] == "Lapak Outdoor") ? 'selected' : '' ?>>Lapak Outdoor</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" value="<?= $data['harga']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Periode</label>
                <select name="periode" class="form-control" required>
                    <option value="Harian" <?= ($data['periode'] == "Harian") ? 'selected' : '' ?>>Harian</option>
                    <option value="Mingguan" <?= ($data['periode'] == "Mingguan") ? 'selected' : '' ?>>Mingguan</option>
                    <option value="Bulanan" <?= ($data['periode'] == "Bulanan") ? 'selected' : '' ?>>Bulanan</option>
                    <option value="Tahunan" <?= ($data['periode'] == "Tahunan") ? 'selected' : '' ?>>Tahunan</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" value="<?= $data['alamat']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="Tersedia" <?= ($data['status'] == "Tersedia") ? 'selected' : '' ?>>Tersedia</option>
                    <option value="Tidak Tersedia" <?= ($data['status'] == "Tidak Tersedia") ? 'selected' : '' ?>>Tidak Tersedia</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Gambar (kosongkan jika tidak ingin ganti)</label>
                <input type="file" name="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="read.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
