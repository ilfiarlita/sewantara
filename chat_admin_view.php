<?php
session_start();
include 'koneksi.php';

if (!isset($_GET['user'])) {
  die("Pengguna tidak ditemukan.");
}

$email = $_GET['user'];

// Tandai semua pesan dari user ini sebagai 'dibaca'
mysqli_query($conn, "UPDATE chat SET status_baca = 'dibaca' WHERE email_user = '$email' AND pengirim = 'user'");

$chat = mysqli_query($conn, "SELECT * FROM chat WHERE email_user = '$email' ORDER BY waktu ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Chat - <?= htmlspecialchars($email) ?></title>
  <link rel="stylesheet" href="style/chat_style.css">
  <link rel="stylesheet" href="style/chat_admin_view.css">
</head>
<body>
  <div class="chat-container chat-admin">
    <h2>Obrolan dengan <?= htmlspecialchars($email) ?></h2>
    <div id="chat-box">
      <?php
        $lastDate = '';
        while ($row = mysqli_fetch_assoc($chat)) {
          $tanggal = date('Y-m-d', strtotime($row['waktu']));
          $jam = date('H:i', strtotime($row['waktu']));

          if ($tanggal !== $lastDate) {
            $label = ($tanggal === date('Y-m-d')) ? 'Hari Ini' : date('d M Y', strtotime($tanggal));
            echo '<div class="chat-date-separator">' . $label . '</div>';
            $lastDate = $tanggal;
          }

          $class = $row['pengirim'] === 'admin' ? 'bubble admin' : 'bubble user-from-user';
          echo '<div class="' . $class . '">';
          echo '<span>' . htmlspecialchars($row['pesan']) . '</span>';
          echo '<div class="time">' . $jam . '</div>';
          echo '</div>';
        }
      ?>
    </div>

    <form id="chat-form" action="chat_admin_send.php" method="post">
      <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
      <input type="text" name="pesan" id="pesan" placeholder="Tulis pesan..." required>
      <button type="submit">Kirim</button>
    </form>
  </div>
</body>
</html>