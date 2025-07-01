<?php
session_start();
include 'koneksi.php';

// Ambil semua data checkout
$checkoutList = mysqli_query($conn, "SELECT * FROM checkout ORDER BY waktu DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin - Checkout</title>
  <link rel="stylesheet" href="style/chat_style.css">
  <link rel="stylesheet" href="style/admin_checkout_style.css">
</head>

<body>

  <div class="checkout-admin-container">
    <h2>Dashboard Admin - Daftar Checkout</h2>
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Waktu</th>
          <th>Email</th>
          <th>Nama</th>
          <th>Kontak</th>
          <th>Total</th>
          <th>Catatan</th>
          <th>Produk</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        if (mysqli_num_rows($checkoutList) > 0) {
          while ($checkout = mysqli_fetch_assoc($checkoutList)) {
            $checkoutId = $checkout['id'];
            $pesananQuery = "
              SELECT pesanan.id AS pesanan_id, pesanan.status, SEWANTARA.judul
              FROM pesanan
              JOIN SEWANTARA ON pesanan.produk_id = SEWANTARA.id
              WHERE pesanan.checkout_id = $checkoutId
            ";
            $pesananResult = mysqli_query($conn, $pesananQuery);

            $firstRow = true;
            while ($pesanan = mysqli_fetch_assoc($pesananResult)) {
              echo "<tr>";
              if ($firstRow) {
                $rowspan = mysqli_num_rows($pesananResult);
                echo "<td rowspan='$rowspan'>" . $no++ . "</td>";
                echo "<td rowspan='$rowspan'>" . date('d/m/Y H:i', strtotime($checkout['waktu'])) . "</td>";
                echo "<td rowspan='$rowspan'>" . htmlspecialchars($checkout['email_user']) . "</td>";
                echo "<td rowspan='$rowspan'>" . htmlspecialchars($checkout['nama']) . "</td>";
                echo "<td rowspan='$rowspan'>" . htmlspecialchars($checkout['kontak']) . "</td>";
                echo "<td rowspan='$rowspan'>Rp" . number_format($checkout['total'], 0, ',', '.') . "</td>";
                echo "<td rowspan='$rowspan'>" . nl2br(htmlspecialchars($checkout['catatan'])) . "</td>";
                $firstRow = false;
              }
              echo "<td>" . htmlspecialchars($pesanan['judul']) . "</td>";
              echo "<td>
                      <form method='post' action='update_status.php'>
                        <input type='hidden' name='pesanan_id' value='" . $pesanan['pesanan_id'] . "'>
                        <select name='status' onchange='this.form.submit()'>";
              $statuses = ['diproses', 'disewa', 'selesai', 'dibatalkan'];
              foreach ($statuses as $status) {
                $selected = $pesanan['status'] === $status ? 'selected' : '';
                echo "<option value='$status' $selected>$status</option>";
              }
              echo "    </select>
                      </form>
                    </td>";
              echo "</tr>";
            }
          }
        } else {
          echo "<tr><td colspan='9' style='text-align:center;'>Tidak ada data checkout ditemukan.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

</body>

</html>