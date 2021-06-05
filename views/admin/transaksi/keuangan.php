<?php
require_once('./php/Auth.php');
require_once('./php/Keuangan.php');
$Auth->Proteksi();
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
      <h1 class="h2">Rekapitulasi Keuangan</h1>
    </div>
  

    <div class="card">
        <div class="card-header bg-primary text-white">
            Rekapitulasi Keuangan
        </div>

        <div class="card-body">
          <form class="row g-3" action="/keuangan" method="POST">
            <div class="col-md-6">
              <label for="inputEmail4" class="form-label">Dari Tanggal</label>
              <input type="date" class="form-control" name="start" required <?php if(isset($_POST['start'])): ?>  value="<?= $_POST['start']; ?>" <?php endif; ?>>
            </div>
            <div class="col-md-6">
              <label for="inputAddress" class="form-label">Sampai Tanggal</label>
              <input type="date" class="form-control" name="finish" required value="<?= date('Y-m-d'); ?>">
            </div>
            <div class="col-md-6">
              <button type="submit" class="btn btn-primary">Filter</button>
            </div>
          </form>
        </div>
    </div>

    <?php if(isset($_POST['start']) && isset($_POST['finish'])): ?>
    <div class="card mt-5">
        <div class="card-header bg-success text-white">
            Pendapatan Denda
        </div>

        <div class="card-body">
        <b>Rekapitulasi Denda Tgl : <?= $_POST['start']; ?> S.D <?= $_POST['finish']; ?></b>
          <table class="table table-bordered table-hover mt-3">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Anggota</th>
                <th scope="col">Tgl Pengembalian</th>
                <th scope="col">Buku Dipinjam</th>
                <th scope="col">Denda</th>
              </tr>
            </thead>
            <tbody>
            <?php if(!empty($Keuangan->TampilkanRekapitulasiKeuangan($_POST['start'], $_POST['finish']))): ?>
            <?php $denda=0; $i=1; foreach ($Keuangan->TampilkanRekapitulasiKeuangan($_POST['start'], $_POST['finish']) as $x): ?>
              <tr>
                <th scope="row"><?= $i++; ?></th>
                <td><?= $x->nama_anggota; ?></td>
                <td><?= $x->tgl_pengembalian; ?></td>
                <td><?= $Keuangan->getBuku($x->id_buku)['judul_buku']; ?></td>
                <td><?= "Rp. ".number_format($x->denda ,2,',','.'); ?></td>
              </tr>
              <?php $denda = $denda + $x->denda; ?>
              <?php endforeach; ?>
              <tr>
                  <th colspan="4" scope="row" style="text-align:right">Total Denda</th>
                  <th scope="row"> <?= "Rp. ".number_format($denda ,2,',','.'); ?></th>
              </tr>
            </tbody>
          </table>
        </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>

  </main>
</div>
</div>

</body>
</html>
