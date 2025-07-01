<?php
session_start();
include 'koneksi.php';

// Buat admin sederhana tanpa login dulu (opsional bisa ditambah login admin nanti)
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Admin Chat - Sewantara</title>
  <link rel="stylesheet" href="style/chat_style.css">
  <link rel="stylesheet" href="style/chat_admin.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

</head>

<body>

  <div class="chat-admin-container">
    <h2>Obrolan Pengguna - Admin Panel</h2>
    <?php
    $emails = mysqli_query($conn, "SELECT email_user FROM chat GROUP BY email_user ORDER BY MAX(waktu) DESC");
    if (!$emails) {
      die("Query gagal: " . mysqli_error($conn));
    }
    while ($user = mysqli_fetch_assoc($emails)):
      $email = $user['email_user'];
      $chat = mysqli_query($conn, "SELECT * FROM chat WHERE email_user = '$email' ORDER BY waktu ASC");
      ?>
      <div class="user-thread">
        <div class="user-email">👤 <?= htmlspecialchars($email); ?></div>
        <div class="chat-box-admin">
          <?php
          $query = "
            SELECT email_user,
                  MAX(waktu) AS waktu_terakhir,
                  (SELECT pesan FROM chat c2 WHERE c2.email_user = c1.email_user ORDER BY waktu DESC LIMIT 1) AS pesan_terakhir,
                  SUM(CASE WHEN pengirim = 'user' AND status_baca = 'belum_dibaca' THEN 1 ELSE 0 END) AS unread
            FROM chat c1
            GROUP BY email_user
            ORDER BY waktu_terakhir DESC
          ";

          $result = mysqli_query($conn, $query);
          ?>

          <div class="chat-admin-container">
            <h2>Obrolan Pengguna - Admin Panel</h2>

            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <a href="chat_admin_view.php?user=<?= urlencode($row['email_user']) ?>" class="chat-list-item">
                <div class="chat-user-email">👤 <?= htmlspecialchars($row['email_user']); ?></div>
                <div class="chat-preview"><?= htmlspecialchars(mb_strimwidth($row['pesan_terakhir'], 0, 50, '...')); ?>
                </div>
                <div class="chat-time"><?= date('d M H:i', strtotime($row['waktu_terakhir'])); ?></div>
                <?php if ($row['unread'] > 0): ?>
                  <div class="chat-unread-badge"><?= $row['unread']; ?></div>
                <?php endif; ?>
              </a>
            <?php endwhile; ?>
          </div>
        </div>
        <form class="chat-reply" action="chat_admin_send.php" method="post">
          <input type="hidden" name="email" value="<?= $email; ?>">
          <input type="text" name="pesan" placeholder="Balas ke <?= $email; ?>..." required>
          <button type="submit">Kirim</button>
        </form>
      </div>
    <?php endwhile; ?>
  </div>

</body>

</html>