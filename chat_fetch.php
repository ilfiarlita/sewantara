<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
  exit();
}

$email = $_SESSION['user'];

// Ambil pesan yang terkait dengan user ini
$query = "SELECT * FROM chat WHERE email_user = '$email' ORDER BY waktu ASC";
$result = mysqli_query($conn, $query);

$lastDate = '';

while ($row = mysqli_fetch_assoc($result)) {
  $tanggal = date('Y-m-d', strtotime($row['waktu']));
  $jam = date('H:i', strtotime($row['waktu']));

  // Tampilkan pemisah tanggal jika tanggal berbeda
  if ($tanggal !== $lastDate) {
    $label = ($tanggal === date('Y-m-d')) ? 'Today' : date('d M Y', strtotime($tanggal));
    echo '<div class="chat-date-separator">' . $label . '</div>';
    $lastDate = $tanggal;
  }

  $class = $row['pengirim'] === 'user' ? 'bubble user' : 'bubble admin';
  echo '<div class="' . $class . '">';
  echo '<span>' . htmlspecialchars($row['pesan']) . '</span>';
  echo '<div class="time">' . $jam . '</div>';
  echo '</div>';
}
?>
