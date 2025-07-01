<?php
include 'koneksi.php';

$keyword = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$query = "SELECT * FROM sewantara";
if (!empty($keyword)) {
    $query .= " WHERE judul LIKE '%$keyword%' OR pemilik LIKE '%$keyword%' OR alamat LIKE '%$keyword%'";
}
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Data Kios</title>
</head>

<body>
    <div class="container mt-5">
        <h2>Data Persediaan Kios</h2>

        <!-- Tombol + Search Bar -->
        <div class="d-flex align-items-center gap-2 mb-3">
            <a href="add.php" class="btn btn-secondary">Tambah Data</a>
            <a href="admin_checkout.php" class="btn btn-secondary">Dashboard</a>
            <a href="chat_admin.php" class="btn btn-secondary">
                <img src="assets/icon-chat.png" alt="Chat" style="width: 25px; height: 25px;">
            </a>

            <!-- Search bar -->
            <form method="GET" class="d-flex ms-auto" role="search">
                <input type="text" name="search" class="form-control me-2" placeholder="Masukkan judul..."
                    value="<?= htmlspecialchars($keyword); ?>">
                <button class="btn btn-outline-primary" type="submit">Cari</button>
            </form>
        </div>

        <!-- Tabel Data -->
        <table class="table table-bordered mt-2">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Pemilik</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Periode</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['judul']; ?></td>
                            <td><?= $row['pemilik']; ?></td>
                            <td><?= $row['kategori']; ?></td>
                            <td><?= $row['harga']; ?></td>
                            <td><?= $row['periode']; ?></td>
                            <td><?= $row['alamat']; ?></td>
                            <td><?= $row['status']; ?></td>
                            <td>
                                <img src="foto_mentah/<?= $row['image']; ?>" alt="gambar kios" width="100">
                            </td>
                            <td>
                                <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-secondary">Edit</a>
                                <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">Belum ada data kios yang sesuai.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>