<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'pbl_202';

$koneksi= mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
