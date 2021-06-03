<?php
require_once('./php/Auth.php');
require_once('./php/Setting.php');
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
      <h1 class="h2">Settings</h1>
    </div>
  
    <div class="card">
        <div class="card-header">
            Setting Aplikasi
        </div>

        <div class="card-body">
          <?php foreach ($Setting->TampilkanSetting() as $x): ?>
          <form method="POST" action="../../../php/Setting.php?update">
            <div class="mb-3">
              <label class="form-label">Nama Aplikasi</label>
              <input type="text" name="nama_aplikasi" class="form-control" required value="<?= $x->nama_aplikasi; ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Denda Per 1 Hari Keterlambatan (Rp)</label>
              <input type="number" name="denda" class="form-control" required value="<?= $x->denda; ?>">
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Update</button>
          </form>
          <?php endforeach; ?>
        </div>
    
    </div>

  </main>
</div>
</div>

</body>
</html>
