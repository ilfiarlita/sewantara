<?php
$conn = mysqli_connect("localhost", "root", "", "sewantara");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>