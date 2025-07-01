<?php
session_start();
$index = $_GET['index'] ?? null;

if (isset($index) && isset($_SESSION['cart'][$index])) {
    unset($_SESSION['cart'][$index]);
    $_SESSION['cart'] = array_values($_SESSION['cart']); // rapikan indeks
}

header("Location: cart.php");
exit();
