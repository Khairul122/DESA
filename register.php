<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('config/koneksi.php'); // Pastikan path benar

// Proses form ketika data dikirimkan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form dan lakukan sanitasi
    $nik              = mysqli_real_escape_string($connect, $_POST['nik']);
    $username         = mysqli_real_escape_string($connect, $_POST['username']);
    $email            = mysqli_real_escape_string($connect, $_POST['email']);
    $password         = mysqli_real_escape_string($connect, $_POST['password']);
    $password_confirm = mysqli_real_escape_string($connect, $_POST['password_confirm']);
    $nama             = mysqli_real_escape_string($connect, $_POST['nama']);
    $level            = "penduduk"; // Level default untuk registrasi penduduk

    // Validasi: pastikan password dan konfirmasi sama
    if ($password !== $password_confirm) {
        $error = "Password dan konfirmasi tidak sama.";
    } else {
        // Periksa apakah NIK sudah digunakan di tabel login
        $cek_nik_login = mysqli_query($connect, "SELECT * FROM login WHERE nik = '$nik'");
        if (mysqli_num_rows($cek_nik_login) > 0) {
            $error = "NIK sudah digunakan untuk akun lain.";
        } else {
            // Hash password dengan MD5 (disarankan menggunakan bcrypt di masa depan)
            $password_hash = md5($password);

            // Simpan akun login dengan NIK
            $query_login = "INSERT INTO login (nik, username, email, password, nama, level) 
                            VALUES ('$nik', '$username', '$email', '$password_hash', '$nama', '$level')";

            if (mysqli_query($connect, $query_login)) {
                // Registrasi berhasil, tampilkan pesan sukses
                $success = "Registrasi berhasil! Silakan login.";
            } else {
                $error = "Registrasi gagal: " . mysqli_error($connect);
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="assets/img/mini-logo.png">
	<title>Registrasi Akun Penduduk</title>
	<link rel="stylesheet" href="assets/fontawesome-5.10.2/css/all.css">
	<link rel="stylesheet" href="assets/bootstrap-4.3.1/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/loginCSS/loginn.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
	<style>
		body {
			font-family: 'Poppins', sans-serif;
			background: url('assets/img/background.jpg') no-repeat center center fixed;
			background-size: cover;
			min-height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
			padding: 0 15px;
		}

		.container {
			background-color: #ffffff;
			border-radius: 8px;
			box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
			padding: 30px;
			max-width: 400px;
			width: 100%;
			height: auto;
		}

		.form-control {
			border-radius: 20px;
			border: 1px solid #ddd;
			padding: 12px 20px;
		}

		.btn-primary {
			background-color: #007bff;
			border-color: #007bff;
			padding: 10px 10px;
			border-radius: 10px;
		}

		.btn-primary:hover {
			background-color: #0056b3;
			border-color: #0056b3;
		}

		.alert {
			margin-bottom: 20px;
			border-radius: 10px;
		}

		h2 {
			font-size: 24px;
			margin-bottom: 20px;
			font-weight: 500;
		}

		.login-link {
			text-align: center;
			margin-top: 20px;
			font-size: 14px;
		}

		.login-link a {
			color: #007bff;
			text-decoration: none;
		}

		.login-link a:hover {
			text-decoration: underline;
		}

		/* Notifikasi sukses */
		.success-message {
			background-color: #d4edda;
			border: 1px solid #c3e6cb;
			color: #155724;
			padding: 15px;
			border-radius: 5px;
			margin-bottom: 20px;
			font-size: 16px;
		}

		.success-message i {
			margin-right: 10px;
		}
	</style>
</head>

<body>
	<div class="container">
		<h2 class="text-center">Registrasi Akun Penduduk</h2>
		<?php if (isset($error)) : ?>
			<div class="alert alert-danger"><?php echo $error; ?></div>
		<?php endif; ?>

		<?php if (isset($success)) : ?>
			<div class="success-message">
				<i class="fas fa-check-circle"></i> <?php echo $success; ?>
			</div>
		<?php endif; ?>

		<form method="POST" action="">
			<div class="mb-2">
				<label for="username" class="form-label">Username:</label>
				<input type="text" name="username" class="form-control" id="username" placeholder="Username" required>
			</div>
			<div class="mb-2">
				<label for="email" class="form-label">Email:</label>
				<input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
			</div>
			<div class="mb-2">
				<label for="password" class="form-label">Password:</label>
				<input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
			</div>
			<div class="mb-2">
				<label for="password_confirm" class="form-label">Konfirmasi Password:</label>
				<input type="password" name="password_confirm" class="form-control" id="password_confirm" placeholder="Konfirmasi Password" required>
			</div>
			<div class="mb-2">
				<label for="nama" class="form-label">Nama Lengkap:</label>
				<input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Lengkap" required>
			</div>
			 <div class="mb-2">
				 <label for="nik" class="form-label">NIK:</label>
				 <input type="text" name="nik" class="form-control" id="nik" placeholder="NIK" required>
			 </div><br>
			<div class="mb-2 text-center">
				<button type="submit" class="btn btn-primary mr-5">Registrasi</button>
				<button type="button" onclick="window.location.href='/Desa/index.php'" class="btn btn-primary mr-1">Cancel</button>
			</div>
		</form>
		<div class="login-link">
			<p>Sudah punya akun? <a href="/desa/login/">Login di sini</a>.</p>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>