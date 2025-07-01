<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $pemilik = $_POST['pemilik'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $periode = $_POST['periode'];
    $alamat = $_POST['alamat'];
    $status = $_POST['status'];

    // handle upload gambar
    $gambar_name = $_FILES['image']['name'];
    $gambar_tmp = $_FILES['image']['tmp_name'];
    $upload_dir = "foto_mentah/";

    // Simpan gambar ke folder
    move_uploaded_file($gambar_tmp, $upload_dir . $gambar_name);

    // Masukkan data ke database
    $sql = "INSERT INTO sewantara (judul, pemilik, kategori, harga, periode, alamat, status, image) 
            VALUES ('$judul', '$pemilik', '$kategori', '$harga', '$periode', '$alamat', '$status', '$gambar_name')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data berhasil ditambahkan!'); window.location.href='read.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Data Kios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Tambah Data Kios</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Judul</label>
                <input type="text" name="judul" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Pemilik</label>
                <input type="text" name="pemilik" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Kategori</label>
                <select name="kategori" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Ruko">Ruko</option>
                    <option value="Kios-Pasar">Kios Pasar</option>
                    <option value="Booth-Bazaar">Booth/Bazaar</option>
                    <option value="Lapak-Outdoor">Lapak Outdoor</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Periode</label>
                <select name="periode" class="form-control" required>
                    <option value="">-- Pilih Periode --</option>
                    <option value="Ruko">Harian</option>
                    <option value="Kios-Pasar">Mingguan</option>
                    <option value="Booth-Bazaar">Bulanan</option>
                    <option value="Lapak-Outdoor">Tahunan</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Ruko">Tersedia</option>
                    <option value="Kios Pasar">Tidak Tersedia</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Gambar</label>
                <input type="file" name="image" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="read.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>

</html>