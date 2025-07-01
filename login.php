<?php
session_start();
include 'koneksi.php';

// Jika form login dikirim
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cek ke database
    $query = "SELECT * FROM USERS WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['user'] = $email;
        header("Location: user_home.php");
        exit();
    } else {
        $error = "Email atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sewantara</title>
    <link rel="stylesheet" href="style/login_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="left">
        <h1>Sewantara</h1>
        <img src="assets/logo-sewantara-removebg.png" style="width: 200px; height: 200px;" alt="Logo">
        <p>Platform sewa dengan perantara.</p>
    </div>
    <div class="right">
        <div class="form-box">
            <h2>Login</h2>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            <form method="post">
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <input type="submit" name="login" value="Login" />
            </form>
            <div class="switch-link">
                Belum punya akun? <a href="register.php">Daftar di sini</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>

