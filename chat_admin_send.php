<?php
session_start();
include 'koneksi.php';

if (!isset($_POST['email']) || !isset($_POST['pesan'])) {
  header("Location: chat_admin.php");
  exit();
}

$email = $_POST['email'];
$pesan = trim($_POST['pesan']);

if ($pesan !== '') {
  $pesan = mysqli_real_escape_string($conn, $pesan);
  $query = "INSERT INTO chat (pengirim, email_user, pesan) VALUES ('admin', '$email', '$pesan')";
  mysqli_query($conn, $query);
}

header("Location: chat_admin_view.php?user=" . urlencode($email));
exit();

