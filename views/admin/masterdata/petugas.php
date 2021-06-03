<?php
require_once('./php/Auth.php');
require_once('./php/Petugas.php');
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
      <h1 class="h2">Data Petugas</h1>
    </div>
    <div class="card">
      <div class="card-header">
          Data Pengguna
          <a type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahPengguna" style="float:right;"><i class="fas fa-user-plus"></i> Tambah Data</a>
      </div>

      <div class="card-body">
        <table class="table table-bordered" id="DataTable">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Username</th>
              <th scope="col">Nama Petugas</th>
              <th scope="col">No Hp</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($Petugas->TampilkanPetugas())): ?>
            <?php $i=1; foreach ($Petugas->TampilkanPetugas() as $x): ?>
            <tr>
              <td><?= $i++; ?></td>
              <td><?= $x->username; ?></td>
              <td><?= $x->nama_petugas; ?></td>
              <td><?= $x->notelp_petugas; ?></td>
              <td>
                <center>
                  <a onclick="return confirm('Yakin Mau Menghapus Data Ini ? ')" href="../../../php/Petugas.php?hapus&id=<?= $x->id_petugas; ?>"><span class="badge bg-danger"><i class="fas fa-trash"></i></span></a> 
                  <a href="#" data-bs-toggle="modal" data-bs-target=".edit" <?= "data-id=".$x->id_petugas.""; ?>><span class="badge bg-primary"><i class="fas fa-edit"></i></span></a>
                </center>
              </td>

            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
  </div>

  </main>
</div>
</div>

<!-- Modal Tambah Pengguna -->
<div class="modal fade" id="tambahPengguna" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Petugas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <form id="TambahData">
            <div class="mb-3 row">
              <label class="col-sm-2 col-form-label">Nama Petugas</label>
              <div class="col-sm-10">
                <input type="text"  class="form-control" name="nama_petugas" required placeholder="Nama Petugas">
              </div>
            </div>

            <div class="mb-3 row">
              <label class="col-sm-2 col-form-label">Alamat</label>
              <div class="col-sm-10">
                <input type="text"  class="form-control" name="alamat_petugas" required placeholder="Alamat">
              </div>
            </div>

            <div class="mb-3 row">
              <label class="col-sm-2 col-form-label">No Telp</label>
              <div class="col-sm-10">
                <input type="text"  class="form-control" name="notelp_petugas" required placeholder="No Telp">
              </div>
            </div>

            <div class="mb-3 row">
              <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
              <div class="col-sm-10">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="jeniskelamin_petugas" id="flexRadioDefault1" checked value="L">
                  <label class="form-check-label" for="flexRadioDefault1">
                    Laki - Laki
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="jeniskelamin_petugas" id="flexRadioDefault2" value="P">
                  <label class="form-check-label" for="flexRadioDefault2">
                    Perempuan
                  </label>
                </div>
              </div>
            </div>

            <div class="mb-3 row">
              <label class="col-sm-2 col-form-label">Username</label>
              <div class="col-sm-10">
                <input type="text"  class="form-control" name="username" required placeholder="Username">
              </div>
            </div>

            <div class="mb-3 row">
              <label class="col-sm-2 col-form-label">Password</label>
              <div class="col-sm-10">
                <input type="password"  class="form-control" name="password" required placeholder="Password">
              </div>
            </div>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">
          <div class="spinner-border text-light spinner-border-sm loading" role="status">
              <span class="visually-hidden">Loading...</span>
          </div>
          Simpan
        </button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- modal edit petugas -->
<div class="modal fade edit" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal_edit"></div>
  </div>
</div>

<script>
$(document).ready(function() {
  $('#DataTable').DataTable();

  //sembunyikan spinner Loading
  $('.loading').hide();

  //tambah data
  $('#TambahData').submit(function(e){
      e.preventDefault();
      $.ajax({
        url : '../../php/Petugas.php?insert',
        data : $(this).serialize(),
        type : 'POST',
        beforeSend : function(){
          $('.loading').show();
        },
        complete : function(){
          $('.loading').hide();
        },
        success : function(data){
          swal(data)
          .then((value) => {
            location.reload();
          });
        },
        error : function(err){
          console.log(err);
        }
      });
  });

  //load modal edit
  $('.edit').on('show.bs.modal', function(e){
      var id = $(e.relatedTarget).data('id');
      $.ajax({
          url : '../../php/Petugas.php?prepare_edit',
          type : 'POST',
          data : {'id_petugas':id},
          success : function(data){
              $('.modal_edit').html(data);
          }
      });
  });

} );
</script>
</body>
</html>
