<?php
include('../part/akses.php');
include('../part/header.php');
include('../../../config/koneksi.php');
?>

<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <?php
        if (isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Administrator')) {
          echo '<img src="../../../assets/img/ava-admin-female.png" class="img-circle" alt="User Image">';
        } else if (isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Kepala Desa')) {
          echo '<img src="../../../assets/img/ava-kades.png" class="img-circle" alt="User Image">';
        } else if (isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Penduduk')) {
          echo '<img src="../../../assets/img/ava-admin-male.png" class="img-circle" alt="User Image">';
        }
        ?>
      </div>
      <div class="pull-left info">
        <p><?php echo $_SESSION['lvl']; ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      <li>
        <a href="../../dashboard/">
          <i class="fas fa-tachometer-alt"></i> <span>&nbsp;&nbsp;Dashboard</span>
        </a>
      </li>
      <?php if (!isset($_SESSION['lvl']) || $_SESSION['lvl'] != 'Penduduk') : ?>
        <li>
          <a href="../penduduk/">
            <i class="fa fa-users"></i> <span>Data Penduduk</span>
          </a>
        </li>
      <?php endif; ?>

      <?php
      if (isset($_SESSION['lvl']) && $_SESSION['lvl'] == 'Administrator') {
      ?>
        <li class="treeview">
          <a href="#">
            <i class="fas fa-envelope-open-text"></i> <span>&nbsp;&nbsp;Surat</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="../../surat/permintaan_surat/"><i class="fa fa-circle-notch"></i> Permintaan Surat</a>
            </li>
            <li>
              <a href="../../surat/surat_selesai/"><i class="fa fa-circle-notch"></i> Surat Selesai</a>
            </li>
          </ul>
        </li>
      <?php
      } else if (isset($_SESSION['lvl']) && $_SESSION['lvl'] == '') {
      ?>
        <!-- Surat Selesai untuk Penduduk -->
        <li class="treeview">
          <a href="#">
            <i class="fas fa-envelope-open-text"></i> <span>&nbsp;&nbsp;Surat</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="../../surat/surat_selesai/"><i class="fa fa-circle-notch"></i> Surat Selesai</a>
            </li>
            <li>
              <a href="http://localhost/Desa/surat/"><i class="fa fa-circle-notch"></i> Buat Surat</a>
            </li>
          </ul>
        </li>
      <?php
      }
      ?>

      <?php
      if (isset($_SESSION['lvl']) && $_SESSION['lvl'] != 'Penduduk') {
      ?>
        <li>
          <a href="../../laporan/">
            <i class="fas fa-chart-line"></i> <span>&nbsp;&nbsp;Laporan</span>
          </a>
        </li>
      <?php
      }
      ?>
    </ul>

  </section>
</aside>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Surat Selesai</h1>
    <ol class="breadcrumb">
      <li><a href="../../dashboard/"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
      <li class="active">Surat Selesai</li>
    </ol>
  </section>
  <section class="content">
    <?php
    include('../../../config/koneksi.php');

    $nik_login = isset($_SESSION['nik']) ? $_SESSION['nik'] : '';

    ?>
    <div class="row">
      <div class="col-md-12">
        <br><br>
        <table class="table table-striped table-bordered table-responsive" id="data-table" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th><strong>Tanggal</strong></th>
              <th><strong>No. Surat</strong></th>
              <th><strong>NIK</strong></th>
              <th><strong>Nama</strong></th>
              <th><strong>Jenis Surat</strong></th>
              <th><strong>Status</strong></th>
              <th><strong>Aksi</strong></th>
            </tr>
          </thead>
          <tbody>
            <?php

            $no = 1;
            $qTampil = mysqli_query($connect, "
            SELECT penduduk.nama, surat_keterangan.id_sk, surat_keterangan.no_surat, surat_keterangan.nik, surat_keterangan.jenis_surat, surat_keterangan.status_surat, surat_keterangan.tanggal_surat 
            FROM penduduk 
            LEFT JOIN surat_keterangan ON surat_keterangan.nik = penduduk.nik 
            WHERE surat_keterangan.status_surat='selesai' AND surat_keterangan.nik='$nik_login'
            
            UNION 

            SELECT penduduk.nama, surat_keterangan_tidak_mampu.id_sktm, surat_keterangan_tidak_mampu.no_surat, surat_keterangan_tidak_mampu.nik, surat_keterangan_tidak_mampu.jenis_surat, surat_keterangan_tidak_mampu.status_surat, surat_keterangan_tidak_mampu.tanggal_surat 
            FROM penduduk 
            LEFT JOIN surat_keterangan_tidak_mampu ON surat_keterangan_tidak_mampu.nik = penduduk.nik 
            WHERE surat_keterangan_tidak_mampu.status_surat='selesai' AND surat_keterangan_tidak_mampu.nik='$nik_login'
            
            UNION 

            SELECT penduduk.nama, surat_ktp_sementara.id_ks, surat_ktp_sementara.no_surat, surat_ktp_sementara.nik, surat_ktp_sementara.jenis_surat, surat_ktp_sementara.status_surat, surat_ktp_sementara.tanggal_surat 
            FROM penduduk 
            LEFT JOIN surat_ktp_sementara ON surat_ktp_sementara.nik = penduduk.nik 
            WHERE surat_ktp_sementara.status_surat='selesai' AND surat_ktp_sementara.nik='$nik_login'
        ");

        foreach ($qTampil as $row) {
        ?>
              <tr>
                <?php
                $tgl_lhr = date($row['tanggal_surat']);
                $tgl = date('d ', strtotime($tgl_lhr));
                $bln = date('F', strtotime($tgl_lhr));
                $thn = date(' Y', strtotime($tgl_lhr));
                $blnIndo = array(
                  'January' => 'Januari',
                  'February' => 'Februari',
                  'March' => 'Maret',
                  'April' => 'April',
                  'May' => 'Mei',
                  'June' => 'Juni',
                  'July' => 'Juli',
                  'August' => 'Agustus',
                  'September' => 'September',
                  'October' => 'Oktober',
                  'November' => 'November',
                  'December' => 'Desember'
                );
                ?>
                <td><?php echo $tgl . $blnIndo[$bln] . $thn; ?></td>
                <td><?php echo $row['no_surat']; ?></td>
                <td><?php echo $row['nik']; ?></td>
                <td style="text-transform: capitalize;"><?php echo $row['nama']; ?></td>
                <td><?php echo $row['jenis_surat']; ?></td>
                <td><a class="btn btn-success btn-sm" href='#'><i class="fa fa-check"></i><b> <?php echo $row['status_surat']; ?></b></a></td>
                <td>
                  <?php
                  if ($row['jenis_surat'] == "Surat Keterangan") {
                  ?>
                    <a name="cetak" target="output" class="btn btn-primary btn-sm" href='../cetak/surat_keterangan/index.php?id=<?php echo $row['id_sk']; ?>'><i class="fa fa-print"></i><b> CETAK</b></a>
                  <?php
                  } else if ($row['jenis_surat'] == "Surat Keterangan Berkelakuan Baik") {
                  ?>
                    <a name="cetak" target="output" class="btn btn-primary btn-sm" href='../cetak/surat_keterangan_berkelakuan_baik/index.php?id=<?php echo $row['id_sk']; ?>'><i class="fa fa-print"></i><b> CETAK</b></a>
                  <?php
                  } else if ($row['jenis_surat'] == "Surat Keterangan tidak mampu") {
                  ?>
                    <a name="cetak" target="output" class="btn btn-primary btn-sm" href='../cetak/surat_keterangan_tidak_mampu/index.php?id=<?php echo $row['id_sk']; ?>'><i class="fa fa-print"></i><b> CETAK</b></a>
                  <?php
                  } else if ($row['jenis_surat'] == "Surat Keterangan lahir") {
                  ?>
                    <a name="cetak" target="output" class="btn btn-primary btn-sm" href='../cetak/surat_keterangan_lahir/index.php?id=<?php echo $row['id_sk']; ?>'><i class="fa fa-print"></i><b> CETAK</b></a>
                  <?php
                  } else if ($row['jenis_surat'] == "Surat ktp sementara") {
                  ?>
                    <a name="cetak" target="output" class="btn btn-primary btn-sm" href="../cetak/surat_ktp_sementara/index.php?id=<?php echo $row['id_sk']; ?>"><i class="fa fa-print"></i><b> CETAK</b></a>
                  <?php
                  } else if ($row['jenis_surat'] == "Surat Keterangan Domisili") {
                  ?>
                    <a name="cetak" target="output" class="btn btn-primary btn-sm" href='../cetak/surat_keterangan_domisili/index.php?id=<?php echo $row['id_sk']; ?>'><i class="fa fa-print"></i><b> CETAK</b></a>
                  <?php
                  } else if ($row['jenis_surat'] == "Surat Keterangan usaha") {
                  ?>
                    <a name="cetak" target="output" class="btn btn-primary btn-sm" href='../cetak/surat_keterangan_usaha/index.php?id=<?php echo $row['id_sk']; ?>'><i class="fa fa-print"></i><b> CETAK</b></a>
                  <?php
                  } else if ($row['jenis_surat'] == "Surat Pengantar SKCK") {
                  ?>
                    <a name="cetak" target="output" class="btn btn-primary btn-sm" href='../cetak/surat_pengantar_skck/index.php?id=<?php echo $row['id_sk']; ?>'><i class="fa fa-print"></i><b> CETAK</b></a>
                  <?php
                  } else if ($row['jenis_surat'] == "Surat pengantar pindah") {
                  ?>
                    <a name="cetak" target="output" class="btn btn-primary btn-sm" href='../cetak/surat_pengantar_pindah/index.php?id=<?php echo $row['id_sk']; ?>'><i class="fa fa-print"></i><b> CETAK</b></a>
                  <?php
                  } else if ($row['jenis_surat'] == "Surat Keterangan Tidak Mampu") {
                  ?>
                    <a name="cetak" target="output" class="btn btn-primary btn-sm" href='../cetak/surat_keterangan_tidak_mampu/index.php?id=<?php echo $row['id_sk']; ?>'><i class="fa fa-print"></i><b> CETAK</b></a>
                  <?php
                  } ?>
                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<?php
include('../part/footer.php');
?>