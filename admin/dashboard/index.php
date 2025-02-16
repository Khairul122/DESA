<?php
include('../part/akses.php');
include('../part/header.php');
include('../../config/koneksi.php');
?>

p
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
      <?php if (!isset($_SESSION['lvl']) || $_SESSION['lvl'] != 'Penduduk') : ?>
        <li>
          <a href="../penduduk/">
            <i class="fa fa-users"></i> <span>Data Penduduk</span>
          </a>
        </li>
      <?php endif; ?>

      <?php
      if (isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Administrator')) {
      ?>
        <li class="treeview">
          <a href="#">
            <i class="fas fa-envelope-open-text"></i> <span>&nbsp;&nbsp;Surat</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
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
      } else if (isset($_SESSION['lvl']) && ($_SESSION['lvl'] == '')) {
      ?>
        <li class="treeview">
          <a href="#">
            <i class="fas fa-envelope-open-text"></i> <span>&nbsp;&nbsp;Surat</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
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
            <!-- <li>
              <a href="http://localhost/Desa/admin/surat/permintaan_surat/">
                <i class="fas fa-envelope"></i> <span>Status Surat</span>
              </a>
            </li> -->

          </ul>
        </li>
      <?php
      }
      ?>

      <?php
      if (isset($_SESSION['lvl']) && ($_SESSION['lvl'] != 'Penduduk')) {
      ?>
        <li class="active">
          <a href="#"><i class="fas fa-chart-line"></i> <span>&nbsp;&nbsp;Laporan</span></a>
        </li>
      <?php
      }
      ?>
    </ul>


  </section>
</aside>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Dashboard</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <?php
      if (isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Administrator')) {
      ?>
        <div class="col-lg-4 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>
                <?php
                include('../../config/koneksi.php');

                $qTampil = mysqli_query($connect, "SELECT * FROM penduduk");
                $jumlahPenduduk = mysqli_num_rows($qTampil);
                echo $jumlahPenduduk;
                ?>
              </h3>
              <p>Data Penduduk</p>
            </div>
            <div class="icon">
              <i class="fas fa-users" style="font-size:70px"></i>
            </div>
            <a href="../penduduk/" class="small-box-footer">Lihat detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-4 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>
                <?php
                $qTampil = mysqli_query($connect, "SELECT tanggal_surat FROM surat_keterangan WHERE status_surat='pending' 
                  UNION SELECT tanggal_surat FROM surat_keterangan_domisili WHERE status_surat='pending'
                   UNION SELECT tanggal_surat FROM surat_keterangan_berkelakuan_baik WHERE status_surat='pending'
                  UNION SELECT tanggal_surat FROM surat_ktp_sementara WHERE status_surat='pending'
                  UNION SELECT tanggal_surat FROM surat_keterangan_usaha WHERE status_surat='pending'
                  UNION SELECT tanggal_surat FROM surat_pengantar_pindah WHERE status_surat='pending'
                  UNION SELECT tanggal_surat FROM surat_keterangan_tidak_mampu WHERE status_surat='pending'
                  UNION SELECT tanggal_surat FROM surat_keterangan_lahir WHERE status_surat='pending'
                  UNION SELECT tanggal_surat FROM surat_pengantar_skck WHERE status_surat='pending'");
                $jumlahPermintaanSurat = mysqli_num_rows($qTampil);
                echo $jumlahPermintaanSurat;
                ?>
              </h3>
              <p>Permintaan Surat</p>
            </div>
            <div class="icon">
              <i class="fas fa-envelope-open-text" style="font-size:70px"></i>
            </div>
            <a href="../surat/permintaan_surat/" class="small-box-footer">Lihat detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-4 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>
                <?php
                $qTampil = mysqli_query($connect, "SELECT tanggal_surat FROM surat_keterangan WHERE status_surat='selesai' 
                  UNION SELECT tanggal_surat FROM surat_keterangan_domisili WHERE status_surat='selesai'
                  UNION SELECT tanggal_surat FROM surat_ktp_sementara WHERE status_surat='selesai'
                  UNION SELECT tanggal_surat FROM surat_keterangan_usaha WHERE status_surat='selesai'
                  UNION SELECT tanggal_surat FROM surat_pengantar_pindah WHERE status_surat='selesai'
                  UNION SELECT tanggal_surat FROM surat_keterangan_tidak_mampu WHERE status_surat='selesai'
                  UNION SELECT tanggal_surat FROM surat_keterangan_lahir WHERE status_surat='selesai'
                  UNION SELECT tanggal_surat FROM surat_pengantar_skck WHERE status_surat='selesai'");
                $jumlahPermintaanSurat = mysqli_num_rows($qTampil);
                echo $jumlahPermintaanSurat;
                ?>
              </h3>
              <p>Surat Selesai</p>
            </div>
            <div class="icon">
              <i class="fas fa-envelope" style="font-size:70px"></i>
            </div>
            <a href="../surat/surat_selesai/" class="small-box-footer">Lihat detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      <?php
      } else if (isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Kepala Desa')) {
      ?>
        <div class="col-lg-1"></div>
        <div class="col-lg-5 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>
                <?php
                include('../../config/koneksi.php');

                $qTampil = mysqli_query($connect, "SELECT * FROM penduduk");
                $jumlahPenduduk = mysqli_num_rows($qTampil);
                echo $jumlahPenduduk;
                ?>
              </h3>
              <p>Data Penduduk</p>
            </div>
            <div class="icon">
              <i class="fas fa-users" style="font-size:70px"></i>
            </div>
            <a href="../penduduk/" class="small-box-footer">Lihat detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-5 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">

              <h3>
                <?php
                include('../../config/koneksi.php');

                $qTampil = mysqli_query($connect, "SELECT jenis_surat FROM surat_keterangan WHERE status_surat='selesai' UNION SELECT tanggal_surat FROM surat_keterangan_domisili WHERE status_surat='selesai'
                  UNION SELECT tanggal_surat FROM surat_ktp_sementara WHERE status_surat='selesai'
                  UNION SELECT tanggal_surat FROM surat_keterangan_berkelakuan_baik WHERE status_surat='pending'
                  UNION SELECT tanggal_surat FROM surat_keterangan_usaha WHERE status_surat='selesai'
                  UNION SELECT tanggal_surat FROM surat_pengantar_pindah WHERE status_surat='selesai'
                  UNION SELECT tanggal_surat FROM surat_keterangan_tidak_mampu WHERE status_surat='selesai'
                  UNION SELECT tanggal_surat FROM surat_keterangan_lahir WHERE status_surat='selesai'
                  UNION SELECT tanggal_surat FROM surat_pengantar_skck WHERE status_surat='selesai'");
                $jumlahPermintaanSurat = mysqli_num_rows($qTampil);
                echo $jumlahPermintaanSurat;
                ?>
              </h3>
              <p>Laporan Surat Administrasi Desa - Surat Keluar</p>
            </div>
            <div class="icon">
              <i class="fas fa-envelope" style="font-size:70px"></i>
            </div>
            <a href="../laporan/" class="small-box-footer">Lihat detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-1"></div>
      <?php
      }
      ?>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Selamat Datang</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <form class="form-horizontal" method="post" action="simpan-penduduk.php">
                <div class="col-md-12">
                  <div class="col-md-4" style="text-align: center;">
                    <img style="max-width:300px; width:100%; height:auto;" src="../../assets/img/logo-agam.png"><br>
                    <?php
                    $qTampilDesa = mysqli_query($connect, "SELECT * FROM profil_desa WHERE id_profil_desa = '1'");
                    foreach ($qTampilDesa as $row) {
                    ?>
                      <p style="font-size: 20pt; font-weight: 500; text-transform: uppercase;"><strong>KENAGARIAN <?php echo $row['nama_desa']; ?></strong>
                        <hr>
                      <?php
                    }
                      ?>
                  </div>
                  <div class="col-md-8">
                    <div class="pull-right">
                      <?php
                      $tanggal = date('D d F Y');
                      $hari = date('D', strtotime($tanggal));
                      $bulan = date('F', strtotime($tanggal));
                      $hariIndo = array(
                        'Mon' => 'Senin',
                        'Tue' => 'Selasa',
                        'Wed' => 'Rabu',
                        'Thu' => 'Kamis',
                        'Fri' => 'Jumat',
                        'Sat' => 'Sabtu',
                        'Sun' => 'Minggu',
                      );
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
                      echo $hariIndo[$hari] . ', ' . date('d ') . $bulanIndo[$bulan] . date(' Y');
                      ?>
                    </div><br>
                    <div style="font-size: 35pt; font-weight: 500;">
                      <p>Hallo, <strong>
                          <?php
                          if (isset($_SESSION['lvl']) && $_SESSION['lvl'] == 'Penduduk') {
                            $username = $_SESSION['username']; 
                            $query = "SELECT nama FROM login WHERE username = '$username'";  
                            $result = mysqli_query($connect, $query);

                            // Cek apakah ada data yang ditemukan
                            if ($result && mysqli_num_rows($result) > 0) {
                              $data = mysqli_fetch_assoc($result);
                              echo $data['nama'];  
                            } else {
                              echo "Nama tidak ditemukan";  
                            }
                          } else {
                            echo $_SESSION['lvl'];  
                          }
                          ?>
                        </strong></p>
                    </div>

                    <?php
                    include '../../config/koneksi.php';
                    $nik = isset($_SESSION['nik']) ? $_SESSION['nik'] : '';

                    $query = "SELECT * FROM penduduk WHERE nik = '$nik'";
                    $result = mysqli_query($connect, $query);
                    $data_penduduk = mysqli_fetch_assoc($result);
                    ?>

                    <div style="font-size: 15pt; font-weight: 500;">
                      <p>Selamat datang di <a href="#" style="text-decoration:none"><strong>Web Aplikasi Pelayanan Surat Administrasi Desa Kenagarian Simarasok.</strong></a></p>

                      <?php if (isset($_SESSION['lvl']) && $_SESSION['lvl'] == 'Penduduk') : ?>
                        <div class="text-left" style="margin-top: 20px;">
                          <?php if (!$data_penduduk) : ?>
                            <a href="http://localhost/Desa/admin/penduduk/tambah-penduduk.php" class="btn btn-success btn-lg">
                              <i class="fa fa-file-alt"></i> Tambah Data Diri
                            </a>
                          <?php else : ?>
                            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#modalDataPenduduk">
                              <i class="fa fa-user"></i> Lihat Data Diri
                            </button>
                          <?php endif; ?>

                          <a href="http://localhost/Desa/surat/" class="btn btn-primary btn-lg">
                            <i class="fa fa-file-alt"></i> Buat Surat
                          </a>
                          <a href="http://localhost/Desa/admin/surat/surat_selesai/" class="btn btn-warning btn-lg">
                            <i class="fa fa-file-alt"></i> Surat Selesai
                          </a>
                        </div>
                      <?php endif; ?>
                    </div>

                    <?php if ($data_penduduk) : ?>
                      <div class="modal fade" id="modalDataPenduduk" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="modalTitle">Data Diri Penduduk</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <table class="table table-bordered">
                                <tr>
                                  <th>NIK</th>
                                  <td><?= $data_penduduk['nik']; ?></td>
                                </tr>
                                <tr>
                                  <th>Nama</th>
                                  <td><?= $data_penduduk['nama']; ?></td>
                                </tr>
                                <tr>
                                  <th>Tempat Lahir</th>
                                  <td><?= $data_penduduk['tempat_lahir']; ?></td>
                                </tr>
                                <tr>
                                  <th>Tanggal Lahir</th>
                                  <td><?= $data_penduduk['tgl_lahir']; ?></td>
                                </tr>
                                <tr>
                                  <th>Jenis Kelamin</th>
                                  <td><?= $data_penduduk['jenis_kelamin']; ?></td>
                                </tr>
                                <tr>
                                  <th>Agama</th>
                                  <td><?= $data_penduduk['agama']; ?></td>
                                </tr>
                                <tr>
                                  <th>Alamat</th>
                                  <td><?= $data_penduduk['jalan']; ?></td>
                                </tr>
                                <tr>
                                  <th>RT / RW</th>
                                  <td><?= $data_penduduk['rt'] . ' / ' . $data_penduduk['rw']; ?></td>
                                </tr>
                                <tr>
                                  <th>Desa</th>
                                  <td><?= $data_penduduk['desa']; ?></td>
                                </tr>
                                <tr>
                                  <th>Kecamatan</th>
                                  <td><?= $data_penduduk['kecamatan']; ?></td>
                                </tr>
                                <tr>
                                  <th>Kabupaten</th>
                                  <td><?= $data_penduduk['kabupaten']; ?></td>
                                </tr>
                                <tr>
                                  <th>No KK</th>
                                  <td><?= $data_penduduk['no_kk']; ?></td>
                                </tr>
                                <tr>
                                  <th>Pendidikan Terakhir</th>
                                  <td><?= $data_penduduk['pend_terakhir']; ?></td>
                                </tr>
                                <tr>
                                  <th>Pekerjaan</th>
                                  <td><?= $data_penduduk['pekerjaan']; ?></td>
                                </tr>
                                <tr>
                                  <th>Status Perkawinan</th>
                                  <td><?= $data_penduduk['status_perkawinan']; ?></td>
                                </tr>
                                <tr>
                                  <th>Nama Ayah</th>
                                  <td><?= $data_penduduk['nama_ayah']; ?></td>
                                </tr>
                                <tr>
                                  <th>Nama Ibu</th>
                                  <td><?= $data_penduduk['nama_ibu']; ?></td>
                                </tr>
                              </table>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php endif; ?>



                    <div style="font-size: 10pt; font-weight: 500;">© e-<b>SuratDesa</b> 2025. Hak Cipta Dilindungi.</div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Pastikan jQuery & Bootstrap untuk Modal -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</div>

<?php
include('../part/footer.php');
?>