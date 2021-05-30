<?php
require_once('./php/Auth.php');
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
        <h3><i class="fas fa-book"></i> 56 Buku</h3>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card text-white bg-success">
      <div class="card-header">
      <h6>Total Anggota</h6>
      </div>
      <div class="card-body">
        <h3><i class="fas fa-user"></i> 56 Anggota</h3>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card text-white bg-warning">
      <div class="card-header">
      <h6>Total Peminjam Aktif</h6>
      </div>
      <div class="card-body">
        <h3><i class="fas fa-user-tag"></i> 56 Peminjam</h3>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card text-white bg-danger">
      <div class="card-header">
      <h6>Total Pengguna</h6>
      </div>
      <div class="card-body">
        <h3><i class="fas fa-user-tie"></i> 1 Pengguna</h3>
      </div>
    </div>
  </div>
</div>


  </main>
</div>
</div>

</body>
</html>
