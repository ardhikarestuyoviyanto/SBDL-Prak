<?php
require_once('./php/Auth.php');
require_once('./php/Buku.php');
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
      <h1 class="h2">Kategori Buku</h1>
    </div>
  
    <div class="card">
        <div class="card-header">
            Kategori Buku
            <a data-bs-toggle="modal" data-bs-target="#tambahKategori" class="btn btn-primary btn-sm" style="float:right; margin-left:5px;"><i class="fas fa-plus-circle"></i> Tambah Data</a>
        </div>

        <div class="card-body">
        <table class="table table-bordered" id="DataTable">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Id Kategori</th>
              <th scope="col">Nama Kategori</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($Buku->TampilkanKategoriBuku())): ?>
            <?php $i=1; foreach ($Buku->TampilkanKategoriBuku() as $x): ?>
            <tr>
              <td><?= $i++; ?></td>
              <td><?= $x->id_kategoribuku; ?></td>
              <td><?= $x->nama_kategoribuku; ?></td>
              <td>
                <center>
                  <a onclick="return confirm('Yakin Mau Menghapus Data Ini ? ')" href="../../../php/Buku.php?hapus_kategoribuku&id=<?= $x->id_kategoribuku; ?>"><span class="badge bg-danger"><i class="fas fa-trash"></i></span></a> 
                  <a href="#" data-bs-toggle="modal" data-bs-target=".edit" <?= "data-id=".$x->id_kategoribuku.""; ?>><span class="badge bg-primary"><i class="fas fa-edit"></i></span></a>
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

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="tambahKategori" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori Buku</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="TambahData">
          <div class="row mb-3">
              <label for="nim" class="col-sm-2 col-form-label">Nama Kategori</label>
              <div class="col-sm-10">
              <input type="text" class="form-control" id="nama_kategoribuku" name="nama_kategoribuku" required placeholder="Masukkan Kategori Buku">
              </div>
          </div>
      </div>
      <div class="card-footer bg-white">
          <button type="submit" class="btn btn-primary text-white" style="float:right;">
              <div class="spinner-border text-light spinner-border-sm loading" role="status">
                  <span class="visually-hidden">Loading...</span>
              </div>
              Tambah
          </button>
      </div>
  </form>
    </div>
  </div>
</div>

<!-- modal edit kategoribuku -->
<div class="modal fade edit" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal_edit"></div>
  </div>
</div>

<script>
$(document).ready(function(){
    $('#DataTable').DataTable();
    $('.loading').hide();

    //insert
    $('#TambahData').submit(function(e){
      e.preventDefault();
      $.ajax({
        url : '../../php/Buku.php?insert_kategoribuku',
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
          url : '../../php/Buku.php?prepare_edit_kategoribuku',
          type : 'POST',
          data : {'id_kategoribuku':id},
          success : function(data){
              $('.modal_edit').html(data);
          }
      });
  });

});
</script>
</body>
</html>
