<?php
include 'koneksi.php';

if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cek apakah email sudah digunakan
    $check = mysqli_query($conn, "SELECT * FROM USERS WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Email sudah terdaftar.";
    } else {
        $query = "INSERT INTO USERS (email, password) VALUES ('$email', '$password')";
        if (mysqli_query($conn, $query)) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Pendaftaran gagal. Coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar - Sewantara</title>
    <link rel="stylesheet" href="style/login_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="left">
        <h1>Sewantara</h1>
        <img src="assets/logo-sewantara-removebg.png" style="width: 200px; height: 200px;" alt="Logo">
        <p>Buat akunmu dan mulai temukan lapak terbaik hanya di Sewantara.</p>
    </div>
    <div class="right">
        <div class="form-box">
            <h2>Daftar</h2>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            <form method="post">
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <input type="submit" name="register" value="Daftar" />
            </form>
            <div class="switch-link">
                Sudah punya akun? <a href="login.php">Login di sini</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
