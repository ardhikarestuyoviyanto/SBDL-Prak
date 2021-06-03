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
      <h1 class="h2">Data Buku</h1>
    </div>
 

    <div class="card">
      <div class="card-header">
          Data Buku
          <a data-bs-toggle="modal" data-bs-target="#tambahBuku" class="btn btn-primary btn-sm" style="float:right; margin-left:5px;"><i class="fas fa-plus-circle"></i> Tambah Data</a>
          <a data-bs-toggle="modal" data-bs-target="#import" class="btn btn-success btn-sm" style="float:right;"><i class="fas fa-file-excel"></i> Import Excle</a>
      </div>
      <div class="card-header">
        <form action="/buku" method="post">
          <div class="row">
            <div class="col-6 col-md-4">
              <select class="form-select form-select-sm" aria-label="Default select example" required name="search">
                  <option selected value="">- Pilih Kategori Buku -</option>
                  <?php foreach ($Buku->TampilkanKategoriBuku() as $x): ?>
                  
                  <?php if(isset($_POST['search'])){ ?>

                  <?php if($_POST['search'] == $x->id_kategoribuku){ ?>
                    
                  <option selected value="<?= $x->id_kategoribuku; ?>"><?= $x->nama_kategoribuku; ?></option>
                  
                  <?php }else{ ?>
                
                  <option value="<?= $x->id_kategoribuku; ?>"><?= $x->nama_kategoribuku; ?></option>

                  <?php } ?>
                  
                  <?php }else{ ?>

                  <option value="<?= $x->id_kategoribuku; ?>"><?= $x->nama_kategoribuku; ?></option>

                  <?php } ?>

                  <?php endforeach; ?>
              </select>
            </div>
            
            <div class="col-6 col-md-4" style="margin-right: 6px;">
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                <a href="/buku" class="btn btn-success btn-sm" type="button">Reset</a>
            </div>
          </div>
        
        </form>
      </div>
      <div class="card-body">
        <div class="card-body">
          <form id="HapusData">
          <table class="table table-bordered" id="DataTable">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col"><input type="checkbox" id="parent"></th>
                <th scope="col">Kategori Buku</th>
                <th scope="col">Judul Buku</th>
                <th scope="col">Penulis</th>
                <th scope="col">Stok Buku</th>
                <th scope="col" style="width:10px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              
              <?php if(empty($_POST['search'])): ?>  
              <?php if(!empty($Buku->TampilkanBuku())): ?>
              <?php $i=1; foreach ($Buku->TampilkanBuku() as $x): ?>
              <tr>
                <td><?= $i++; ?></td>
                <td><input name="id[]" class="child" type="checkbox" value="<?php echo $x->id_buku; ?>"></td>
                <td><?= $x->nama_kategoribuku; ?></td>
                <td><?= $x->judul_buku; ?></td>
                <td><?= $x->penulis_buku; ?></td>
                <td><?= $x->stok_buku; ?></td>
                <td>
                    <a href="#" data-bs-toggle="modal" data-bs-target=".edit" <?= "data-id=".$x->id_buku.""; ?>><span class="badge bg-primary"><i class="fas fa-edit"></i></span></a>
                </td>

              </tr>
              <?php endforeach; ?>
              <?php endif; ?>
              <?php endif; ?>


              <?php if(isset($_POST['search'])): ?>

                <?php if(!empty($Buku->FilterBuku($_POST['search']))): ?>
                <?php $i=1; foreach ($Buku->FilterBuku($_POST['search']) as $x): ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><input name="id[]" class="child" type="checkbox" value="<?php echo $x->id_buku; ?>"></td>
                  <td><?= $x->nama_kategoribuku; ?></td>
                  <td><?= $x->judul_buku; ?></td>
                  <td><?= $x->penulis_buku; ?></td>
                  <td><?= $x->stok_buku; ?></td>
                  <td>
                      <a href="#" data-bs-toggle="modal" data-bs-target=".edit" <?= "data-id=".$x->id_buku.""; ?>><span class="badge bg-primary"><i class="fas fa-edit"></i></span></a>
                  </td>

                </tr>
                <?php endforeach; ?>
                <?php endif; ?>

              <?php endif; ?>

            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer">
          <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-user-times"></i> Hapus Global</button>
      </div>
      </form>
  </div>

<!-- Modal Tambah Buku -->
<div class="modal fade" id="tambahBuku" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Buku</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="TambahData">
          <div class="row mb-3">
              <label for="nim" class="col-sm-2 col-form-label">Judul Buku</label>
              <div class="col-sm-10">
              <input type="text" class="form-control" name="judul_buku" required placeholder="Masukkan Judul">
              </div>
          </div>

          <div class="row mb-3">
              <label for="nama" class="col-sm-2 col-form-label">Kategori Buku</label>
              <div class="col-sm-10">
                  <select class="form-select" aria-label="Default select example" required name="id_kategoribuku">
                      <option selected value="">- Pilih Kategori Buku -</option>
                      <?php foreach ($Buku->TampilkanKategoriBuku() as $x): ?>
                      <option value="<?= $x->id_kategoribuku; ?>"><?= $x->nama_kategoribuku; ?></option>
                      <?php endforeach; ?>
                  </select>
              </div>
          </div>

          <div class="row mb-3">
              <label for="nama" class="col-sm-2 col-form-label">Penulis Buku</label>
              <div class="col-sm-10">
              <input type="text" class="form-control" name="penulis_buku" required placeholder="Masukkan Penulis">
              </div>
          </div>

          <div class="row mb-3">
              <label for="nama" class="col-sm-2 col-form-label">Stok</label>
              <div class="col-sm-10">
              <input type="number" class="form-control" name="stok_buku" required placeholder="Masukkan Stok">
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

<!-- modal edit buku -->
<div class="modal fade edit" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal_edit"></div>
  </div>
</div>

<!-- Modal Import Buku -->
<div class="modal fade" id="import" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-small">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Import Buku</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="ImportExcel">
          <div class="mb-3">
            <input class="form-control" type="file" name="excel" id="formFile">
          </div>
          <a href="../../../public/file/import_buku.xlsx" style="text-decoration:none;">Download Templeate</a>
      </div>
      <div class="card-footer bg-white">
          <button type="submit" class="btn btn-primary text-white" style="float:right;">
              <div class="spinner-border text-light spinner-border-sm loading" role="status">
                  <span class="visually-hidden">Loading...</span>
              </div>
              Import
          </button>
      </div>
    </form>
  </div>
</div>
</div>

  </main>
</div>
</div>
<script>
$(document).ready(function(){
  $('#DataTable').DataTable();

  $('.loading').hide();

  $('#parent').click(function(){
      $('.child').prop('checked', this.checked);
  });

  $('.child').click(function() {
      if ($('.child:checked').length == $('.child').length) {
        $('#parent').prop('checked', true);
      } else {
        $('#parent').prop('checked', false);
      }
  });

   //tambah data
   $('#TambahData').submit(function(e){
      e.preventDefault();
      $.ajax({
        url : '../../php/Buku.php?insert_buku',
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
        url : '../../php/Buku.php?prepare_edit_buku',
        type : 'POST',
        data : {'id_buku':id},
        success : function(data){
            $('.modal_edit').html(data);
        }
    });
  });

  //hapus data
  $('#HapusData').submit(function(e){
      e.preventDefault();
      var confirmed = confirm("Yakin Mau Menghapus Data Yang Ter-Checklist");
      if(confirmed){
        $.ajax({
          url : '../../php/Buku.php?hapus_buku',
          data : $(this).serialize(),
          type : 'POST',
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

      }
  });


  $('#ImportExcel').submit(function(e){
      e.preventDefault();
      $.ajax({
          url : '../../php/Buku.php?import',
          type : 'POST',
          data : new FormData(this),
          dataType : 'JSON',
          contentType : false,
          cache : false,
          processData : false,
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
          error : function(data){
              console.log(data);
          }
      });
  });

});
</script>
</body>
</html>
