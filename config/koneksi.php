<?php
$host       = "localhost";
$username   = "root";
$password   = "";
$db_name    = "db_e-suratdesa";

$connect = mysqli_connect($host, $username, $password, $db_name);

if (!$connect) {
	die("Koneksi database gagal: " . mysqli_connect_error());
}
