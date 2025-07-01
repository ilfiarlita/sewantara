<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user']) || !isset($_POST['pesan'])) {
  exit();
}

$email = $_SESSION['user'];
$pesan = trim($_POST['pesan']);

if ($pesan !== '') {
  $pesan = mysqli_real_escape_string($conn, $pesan);
  $query = "INSERT INTO chat (pengirim, email_user, pesan) VALUES ('user', '$email', '$pesan')";
  mysqli_query($conn, $query);
}
?>
