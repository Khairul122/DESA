<?php
session_start();
include('../config/koneksi.php');

$username 	= $_POST['username'];
$password 	= md5($_POST['password']);  // Tetap menggunakan MD5 untuk login

$qLogin 	= mysqli_query($connect, "SELECT * FROM login WHERE username='$username' AND password='$password'");
$row 		= mysqli_num_rows($qLogin);

if ($row > 0) {
	$login = mysqli_fetch_assoc($qLogin);

	// Simpan username, level, dan nik ke dalam session
	$_SESSION['username'] = $username;
	$_SESSION['nik'] = $login['nik'];  // Menyimpan NIK dari database ke session

	if ($login['level'] == "admin") {
		$_SESSION['lvl'] = "Administrator";
		header("location:../admin/");
	} else if ($login['level'] == "kades") {
		$_SESSION['lvl'] = "Kepala Desa";
		header("location:../admin/");
	} else if ($login['level'] == "penduduk") {
		$_SESSION['lvl'] = "Penduduk";
		header("location:../admin/");
	} else {
		header("location:index.php?pesan=login-gagal");
	}
} else {
	header("location:index.php?pesan=login-gagal");
}
?>
