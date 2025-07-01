<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}
$email = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Obrolan - Sewantara</title>
  <link rel="stylesheet" href="style/chat_style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<header>
  <div class="logo">
    <img src="assets/logo-sewantara.png" alt="Logo">
    <span>Sewantara</span>
  </div>
  <nav>
    <a href="user_home.php">Beranda</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<div class="chat-container chat-user">
  <h2>Obrolan dengan Admin</h2>

  <div id="chat-box"></div>

  <form id="chat-form">
    <input type="text" name="pesan" id="pesan" placeholder="Ketik pesan..." required autocomplete="off">
    <button type="submit">Kirim</button>
  </form>
</div>

<script>
$(document).ready(function() {
  function loadChat() {
    $.get('chat_fetch.php', function(data) {
      $('#chat-box').html(data);
      $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
    });
  }

  loadChat();
  setInterval(loadChat, 2000); // refresh tiap 2 detik

  $('#chat-form').submit(function(e) {
    e.preventDefault();
    const pesan = $('#pesan').val();
    $.post('chat_send.php', { pesan: pesan }, function() {
      $('#pesan').val('');
      loadChat();
    });
  });
});
</script>

</body>
</html>
