<?php
require_once('./php/Auth.php');
require_once('./php/Dashboard.php');
$Auth->Proteksi();
$Data = $Dashboard->getData();
?>
<!doctype html>
<html lang="en">
<?php include_once('./views/partisi/head.php'); ?>
<link rel="stylesheet" href="../../public/assets/css/admin.css">
<body>
<?php include_once('./views/partisi/navbar.php'); ?>

<div class="container-fluid">
<div class="row">
<?php include_once('./views/partisi/sidebar.php'); ?>
  <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Selamat Datang, <?php echo $_SESSION['login']['nama_petugas']; ?></h1>
    </div>

  <!-- Konten Aplikasi  -->

  <div class="row mt-5">
  <div class="col-sm-3">
    <div class="card text-white bg-primary">
      <div class="card-header">
      <h6>Jumlah Buku</h6>
      </div>
      <div class="card-body">
        <h3><i class="fas fa-book"></i> <?= $Data['buku']; ?>  Buku</h3>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card text-white bg-success">
      <div class="card-header">
      <h6>Total Anggota</h6>
      </div>
      <div class="card-body">
        <h3><i class="fas fa-user"></i><?= $Data['anggota']; ?> Anggota</h3>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card text-white bg-warning">
      <div class="card-header">
      <h6>Total Peminjam Aktif</h6>
      </div>
      <div class="card-body">
        <h3><i class="fas fa-user-tag"></i> <?= $Data['peminjam']; ?> Peminjam</h3>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card text-white bg-danger">
      <div class="card-header">
      <h6>Total Petugas</h6>
      </div>
      <div class="card-body">
        <h3><i class="fas fa-user-tie"></i> <?= $Data['petugas']; ?> Pentugas</h3>
      </div>
    </div>
  </div>
</div>


<div class="card mt-4">
    <div class="card-header">
      <div class="btn-group btn-group-sm" role="group" aria-label="Basic radio toggle button group">

          <input type="radio" class="btn-check" name="btnradio" id="btnradio1">
          <label class="btn btn-success" for="btnradio1">Log Anggota</label>

          <input type="radio" class="btn-check" name="btnradio" id="btnradio2">
          <label class="btn btn-success" for="btnradio2">Log Buku</label>

      </div>
    </div>

    <div class="collapse multi-collapse show" id="multiCollapseExample1">
      <div class="card card-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Tanggal / Waktu</th>
              <th scope="col">Nama Anggota</th>
              <th scope="col">Status</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($Dashboard->getLogAnggota())): ?>
            <?php $i=1; foreach ($Dashboard->getLogAnggota() as $x): ?>
            <tr>
              <th scope="row"><?= $i++; ?></th>
              <td><?= $x->tgl; ?></td>
              <td><?= $x->nama_anggota; ?></td>
              <td><?= ucfirst($x->status_anggota); ?></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="collapse multi-collapse" id="multiCollapseExample2">
      <div class="card card-body">
      <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Tanggal / Waktu</th>
              <th scope="col">Judul Buku</th>
              <th scope="col">Status</th>
            </tr>
          </thead>
          <tbody>
          <?php if(!empty($Dashboard->getLogBuku())): ?>
          <?php $i=1; foreach ($Dashboard->getLogBuku() as $x): ?>
            <tr>
              <th scope="row"><?= $i++; ?></th>
              <td><?= $x->tgl; ?></td>
              <td><?= $x->judul_buku; ?></td>
              <td><?= ucfirst($x->status_buku); ?></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
    

</div>

  </main>
</div>
</div>
<script>
$(document).ready(function(){

  $('#btnradio1').click(function(e) {
      e.preventDefault();
      $('#multiCollapseExample1').addClass('show');
      $('#multiCollapseExample2').removeClass('show');

      $('#btnradio1').prop('checked', true);

  });

  $('#btnradio2').click(function(e) {
      e.preventDefault();
      $('#multiCollapseExample2').addClass('show');
      $('#multiCollapseExample1').removeClass('show');

      $('#btnradio2').prop('checked', true);
  });

});

</script>
</body>
</html>
