<?php
include('../part/akses.php');
include('../part/header.php');
?>

<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <?php
        if (isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Administrator')) {
          echo '<img src="../../assets/img/ava-admin-female.png" class="img-circle" alt="User Image">';
        } else if (isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Kepala Desa')) {
          echo '<img src="../../assets/img/ava-kades.png" class="img-circle" alt="User Image">';
        } else if (isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Penduduk')) {
          echo '<img src="../../assets/img/ava-admin-male.png" class="img-circle" alt="User Image">';
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
        <a href="../dashboard/">
          <i class="fas fa-tachometer-alt"></i> <span>&nbsp;&nbsp;Dashboard</span>
        </a>
      </li>
      <li>
        <a href="../penduduk/">
          <i class="fa fa-users"></i> <span>Data Penduduk</span>
        </a>
      </li>

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
              <a href="../surat/permintaan_surat/"><i class="fa fa-circle-notch"></i> Permintaan Surat</a>
            </li>
            <li>
              <a href="../surat/surat_selesai/"><i class="fa fa-circle-notch"></i> Surat Selesai</a>
            </li>
          </ul>
        </li>
      <?php
      } else if (isset($_SESSION['lvl']) && $_SESSION['lvl'] == 'Penduduk') {
      ?>
        <!-- Penduduk hanya bisa akses Surat Selesai -->
        <li class="treeview">
          <a href="#">
            <i class="fas fa-envelope-open-text"></i> <span>&nbsp;&nbsp;Surat</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
          <ul class="treeview-menu">
            <li>
              <!-- <a href="../surat/permintaan_surat/"><i class="fa fa-circle-notch"></i> Permintaan Surat</a> -->
            </li>
            <li>
              <a href="../surat/surat_selesai/"><i class="fa fa-circle-notch"></i> Surat Selesai</a>
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
        <li class="active">
          <a href="http://localhost/Desa/admin/laporan/"><i class="fas fa-chart-line"></i> <span>&nbsp;&nbsp;Laporan</span></a>
        </li>
      <?php
      }
      ?>
    </ul>


  </section>
</aside>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Data Penduduk</h1>
    <ol class="breadcrumb">
      <li><a href="../dashboard/"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
      <li class="active">Data Penduduk</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div>
          <?php
          if (isset($_GET['pesan'])) {
            if ($_GET['pesan'] == "gagal-menambah") {
              echo "<div class='alert alert-danger'><center>Anda tidak bisa menambah data. NIK tersebut sudah digunakan.</center></div>";
            }
            if ($_GET['pesan'] == "gagal-menghapus") {
              echo "<div class='alert alert-danger'><center>Anda tidak bisa menghapus data tersebut.</center></div>";
            }
          }
          ?>
        </div>
        <?php
        if (isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Administrator')) {
          // Tampilkan tombol export jika level Administrator
        ?>
          <a class="btn btn-success btn-md" href='tambah-penduduk.php'><i class="fa fa-user-plus"></i> Tambah Data Penduduk</a>
          <a target="_blank" class="btn btn-info btn-md" href='export-penduduk.php'><i class="fas fa-file-export"></i> Export .XLS</a>
        <?php
        } else if (isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Penduduk')) {
          // Tampilkan tombol tambah data penduduk untuk level Penduduk
        ?>
          <!-- <a class="btn btn-success btn-md" href='tambah-penduduk.php'><i class="fa fa-user-plus"></i> Tambah Data Diri</a> -->
        <?php
        }
        ?>

        <br><br>
        <?php
        if (isset($_SESSION['lvl']) && in_array($_SESSION['lvl'], ['Administrator', 'Kepala Desa'])) {
        ?>
          <table class="table table-striped table-bordered table-responsive" id="data-table" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th><strong>No</strong></th>
                <th><strong>NIK</strong></th>
                <th><strong>Nama</strong></th>
                <th><strong>Tempat/Tgl Lahir</strong></th>
                <th><strong>Jenis Kelamin</strong></th>
                <th><strong>Agama</strong></th>
                <th><strong>Alamat</strong></th>
                <th><strong>Aksi</strong></th>
              </tr>
            </thead>
            <tbody>
              <?php
              include('../../config/koneksi.php');
              $no = 1;
              $qTampil = mysqli_query($connect, "SELECT * FROM penduduk");
              foreach ($qTampil as $row) {
                $tanggal = date('d', strtotime($row['tgl_lahir']));
                $bulan = date('F', strtotime($row['tgl_lahir']));
                $tahun = date('Y', strtotime($row['tgl_lahir']));
                $bulanIndo = array(
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
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><?php echo $row['nik']; ?></td>
                  <td style="text-transform: capitalize;"><?php echo $row['nama']; ?></td>
                  <td style="text-transform: capitalize;"><?php echo $row['tempat_lahir'] . ", " . $tanggal . " " . $bulanIndo[$bulan] . " " . $tahun; ?></td>
                  <td style="text-transform: capitalize;"><?php echo $row['jenis_kelamin']; ?></td>
                  <td style="text-transform: capitalize;"><?php echo $row['agama']; ?></td>
                  <td style="text-transform: capitalize;"><?php echo ', RT', $row['rt'], '/RW', $row['rw']; ?></td>
                  <td>
                    <a class="btn btn-success btn-sm" href='edit-penduduk.php?id=<?php echo $row['id_penduduk']; ?>'><i class="fa fa-edit"></i></a>
                    <a class="btn btn-danger btn-sm" href='hapus-penduduk.php?id=<?php echo $row['id_penduduk']; ?>' onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        <?php
        } elseif (isset($_SESSION['lvl']) && $_SESSION['lvl'] == 'Penduduk') {
        ?>
          <div class="text-center" style="margin-top: 20px;">
            <a href="tambah-penduduk.php" class="btn btn-success btn-md">
              <i class="fa fa-user-plus"></i> Tambah Data Diri
            </a>
          </div>
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