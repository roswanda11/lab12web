<?php
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "lat1";

$conn = mysqli_connect($host, $user, $pass, $db_name);
if ($conn == false)
{
    echo "Koneksi ke server gagal.";
    die();
} #else echo "Koneksi berhasil";
?>