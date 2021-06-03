<?php
require_once('./php/Auth.php');
require_once('./php/Anggota.php');

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
      <h1 class="h2">Data Anggota</h1>
    </div>
  <!-- Konten Aplikasi  -->

  <div class="card">
      <div class="card-header">
          Data Anggota
          <a data-bs-toggle="modal" data-bs-target="#tambahAnggota" class="btn btn-primary btn-sm" style="float:right; margin-left:5px;"><i class="fas fa-user-plus"></i> Tambah Data</a>
          <a data-bs-toggle="modal" data-bs-target="#import" class="btn btn-success btn-sm" style="float:right;"><i class="fas fa-file-excel"></i> Import Excle</a>
      </div>

      <div class="card-body">
        <div class="card-body">
          <form id="HapusData">
          <table class="table table-bordered" id="DataTable">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col"><input type="checkbox" id="parent"></th>
                <th scope="col">NIM</th>
                <th scope="col">Nama Anggota</th>
                <th scope="col">Jenis Kelamin</th>
                <th scope="col">Jurusan</th>
                <th scope="col">NoTelp</th>
                <th scope="col" style="width:10px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($Anggota->TampilkanAnggota())): ?>
              <?php $i=1; foreach ($Anggota->TampilkanAnggota() as $x): ?>
              <tr>
                <td><?= $i++; ?></td>
                <td><input name="id[]" class="child" type="checkbox" value="<?php echo $x->id_anggota; ?>"></td>
                <td><?= $x->nim_anggota; ?></td>
                <td><?= $x->nama_anggota; ?></td>
                <td><?= $x->jeniskelamin_anggota; ?></td>
                <td><?= $x->jurusan; ?></td>
                <td><?= $x->notelp_anggota; ?></td>
                <td>
                    <a href="#" data-bs-toggle="modal" data-bs-target=".edit" <?= "data-id=".$x->id_anggota.""; ?>><span class="badge bg-primary"><i class="fas fa-edit"></i></span></a>
                </td>

              </tr>
              <?php endforeach; ?>
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

  </main>
</div>
</div>

<!-- Modal Tambah Anggota -->
<div class="modal fade" id="tambahAnggota" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Anggota</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="TambahData">
          <div class="row mb-3">
              <label for="nim" class="col-sm-2 col-form-label">NIM</label>
              <div class="col-sm-10">
              <input type="text" class="form-control" id="nim_anggota" name="nim_anggota" required placeholder="Masukkan Nim">
              </div>
          </div>

          <div class="row mb-3">
              <label for="nama" class="col-sm-2 col-form-label">Nama</label>
              <div class="col-sm-10">
              <input type="text" class="form-control" id="nama_anggota" name="nama_anggota" required placeholder="Masukkan Nama">
              </div>
          </div>

          <div class="row mb-3">
              <label for="nama" class="col-sm-2 col-form-label">Alamat</label>
              <div class="col-sm-10">
              <input type="text" class="form-control" id="alamat_anggota" name="alamat_anggota" required placeholder="Masukkan Alamat">
              </div>
          </div>

          <div class="row mb-3">
              <label for="nama" class="col-sm-2 col-form-label">Jurusan</label>
              <div class="col-sm-10">
                  <select class="form-select" aria-label="Default select example" required name="jurusan">
                      <option selected value="">- Pilih Jurusan -</option>
                      <option value="Teknik Informatika">Teknik Informatika</option>
                      <option value="Matematika">Matematika</option>
                      <option value="Manajemen">Manajemen</option>
                  </select>
              </div>
          </div>

          <div class="row mb-3">
              <label for="nama" class="col-sm-2 col-form-label">Jenis Kelamin</label>
              <div class="col-sm-10">
                  <div class="form-check">
                      <input class="form-check-input" type="radio" name="jeniskelamin_anggota" id="exampleRadios1" value="L" checked>
                      <label class="form-check-label" for="exampleRadios1">
                          Laki - Laki
                      </label>
                  </div>
                  <div class="form-check">
                      <input class="form-check-input" type="radio" name="jeniskelamin_anggota" id="exampleRadios2" value="P">
                      <label class="form-check-label" for="exampleRadios2">
                          Perempuan
                      </label>
                  </div>
              </div>
          </div>

          <div class="row mb-3">
              <label for="nama" class="col-sm-2 col-form-label">No Hp</label>
              <div class="col-sm-10">
              <input type="text" class="form-control" id="nama" name="notelp_anggota" required placeholder="Masukkan No Hp">
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

<!-- modal edit petugas -->
<div class="modal fade edit" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal_edit"></div>
  </div>
</div>

<!-- Modal Import Anggota -->
<div class="modal fade" id="import" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-small">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="ImportExcel">
          <div class="mb-3">
            <input class="form-control" type="file" name="excel" id="formFile">
          </div>
          <a href="../../../public/file/import_anggota.xlsx">Download Templeate</a>
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

</body>
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
        url : '../../php/Anggota.php?insert',
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
          url : '../../php/Anggota.php?prepare_edit',
          type : 'POST',
          data : {'id_anggota':id},
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
          url : '../../php/Anggota.php?delete',
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
          url : '../../php/Anggota.php?import',
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
</html>
