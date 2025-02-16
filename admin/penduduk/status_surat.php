<?php
include('../../../config/koneksi.php');
include('../part/akses.php');
include('../part/header.php');

// Ambil NIK dari session penduduk yang login
$nik = $_SESSION['nik'];

$query = mysqli_query($connect, "SELECT jenis_surat, status_surat, tanggal_surat 
                                FROM surat_ktp_sementara WHERE nik='$nik' 
                                UNION SELECT jenis_surat, status_surat, tanggal_surat FROM surat_keterangan_tidak_mampu WHERE nik='$nik' 
                                UNION SELECT jenis_surat, status_surat, tanggal_surat FROM surat_keterangan_lahir WHERE nik='$nik' 
                                UNION SELECT jenis_surat, status_surat, tanggal_surat FROM surat_pengantar_pindah WHERE nik='$nik' 
                                UNION SELECT jenis_surat, status_surat, tanggal_surat FROM surat_keterangan WHERE nik='$nik' 
                                UNION SELECT jenis_surat, status_surat, tanggal_surat FROM surat_keterangan_domisili WHERE nik='$nik' 
                                UNION SELECT jenis_surat, status_surat, tanggal_surat FROM surat_keterangan_usaha WHERE nik='$nik' 
                                UNION SELECT jenis_surat, status_surat, tanggal_surat FROM surat_pengantar_skck WHERE nik='$nik'");
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Status Permohonan Surat</h1>
    <ol class="breadcrumb">
      <li><a href="../../dashboard/"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
      <li class="active">Status Surat</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Jenis Surat</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($query)) { ?>
              <tr>
                <td><?php echo date('d-m-Y', strtotime($row['tanggal_surat'])); ?></td>
                <td><?php echo $row['jenis_surat']; ?></td>
                <td>
                  <?php if ($row['status_surat'] == 'pending') { ?>
                    <span class="badge badge-warning">Pending</span>
                  <?php } else if ($row['status_surat'] == 'selesai') { ?>
                    <span class="badge badge-success">Selesai</span>
                  <?php } ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<?php include('../part/footer.php'); ?>