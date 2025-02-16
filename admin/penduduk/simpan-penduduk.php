<?php
    include ('../../config/koneksi.php');

    if (isset($_POST['submit'])){
        $nik = $_POST['fnik'];
        $nama = $_POST['fnama'];
        $tempat_lahir = $_POST['ftempat_lahir'];
        $tgl_lahir = $_POST['ftgl_lahir'];
        $jenis_kelamin = $_POST['fjenis_kelamin'];
        $agama = $_POST['fagama'];
        $jalan = addslashes($_POST['fjalan']);
        $rt = $_POST['frt'];
        $rw = $_POST['frw'];
        $desa = $_POST['fdesa'];
        $kecamatan = $_POST['fkecamatan'];
        $kabupaten = $_POST['fkabupaten'];
        $no_kk = $_POST['fno_kk'];
        $pend_kk = $_POST['fpend_kk'];
        $pend_terakhir = $_POST['fpend_terakhir'];
        $pekerjaan = $_POST['fpekerjaan'];
        $status_perkawinan = $_POST['fstatus_perkawinan'];
        $status_dlm_keluarga = $_POST['fstatus_dlm_keluarga'];
        $kewarganegaraan = $_POST['fkewarganegaraan'];
        $nama_ayah = $_POST['fnama_ayah'];
        $nama_ibu = $_POST['fnama_ibu'];

        $stmt = $connect->prepare("SELECT nik FROM penduduk WHERE nik = ?");
        $stmt->bind_param("s", $nik);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>alert('Gagal! NIK sudah terdaftar.'); window.location.href='http://localhost/desa/admin/dashboard/';</script>";
        } else {
            $stmt = $connect->prepare("INSERT INTO penduduk (nik, nama, tempat_lahir, tgl_lahir, jenis_kelamin, agama, jalan, rt, rw, desa, kecamatan, kabupaten, no_kk, pend_kk, pend_terakhir, pekerjaan, status_perkawinan, status_dlm_keluarga, kewarganegaraan, nama_ayah, nama_ibu) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssssssssssssss", $nik, $nama, $tempat_lahir, $tgl_lahir, $jenis_kelamin, $agama, $jalan, $rt, $rw, $desa, $kecamatan, $kabupaten, $no_kk, $pend_kk, $pend_terakhir, $pekerjaan, $status_perkawinan, $status_dlm_keluarga, $kewarganegaraan, $nama_ayah, $nama_ibu);

            if ($stmt->execute()) {
                echo "<script>alert('Data berhasil disimpan!'); window.location.href='http://localhost/desa/admin/dashboard/';</script>";
            } else {
                echo "<script>alert('Gagal menyimpan data!'); window.location.href='http://localhost/desa/admin/dashboard/';</script>";
            }
        }
        $stmt->close();
        $connect->close();
    }
?>
