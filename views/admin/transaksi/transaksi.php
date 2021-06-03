<?php
require_once('./php/Auth.php');
require_once('./php/Anggota.php');
require_once('./php/Transaksi.php');
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
      <h1 class="h2">Transaksi</h1>
    </div>

    <div class="card">
      <div class="card-header bg-primary text-white">
        Cari Anggota
      </div>

      <div class="card-body">
          <div class="container">
              <form action="/transaksi" method="POST">
              <div class="form-group justify-content-center row">
                  <label class="col-sm-2 mt-2 mb-2 col-form-label"></label>
                  <div class="col-sm-6 mt-2 mb-2">
                      <select class="form-control select2" style="width: 100%;" name="search" required>
                          <option value="">- Filter Anggota -</option>
                      </select>
                  </div>
                  <div class="col-sm-3 mt-2 mb-2">
                      <button type="submit" class="btn btn-primary">Cari Anggota</button>
                  </div>
              </div>
              </form>
          </div>
      </div>


    </div>

    <?php if(isset($_POST['search'])): ?>

    <div class="card mt-4">
        <div class="card-header bg-success text-white">
            Data Peminjam
        </div>
        
        <?php foreach ($Anggota->TampilkanAnggotaById($_POST['search']) as $x): ?>
        <div class="card-body">
          <table class="table table-hover">
            <tbody>
              <tr class="text-bold">
                <th scope="row">NIM</th>
                <th scope="row"><?= $x->nim_anggota; ?></th>
              </tr>
              <tr>
                <th scope="row">Nama</th>
                <th scope="row"><?= $x->nama_anggota; ?></th>
              </tr>
              <tr>
                <th scope="row">Jurusan</th>
                <th scope="row"><?= $x->jurusan; ?></th>
              </tr>
              <tr>
                <th scope="row">Alamat</th>
                <th scope="row"><?= $x->alamat_anggota; ?></th>
              </tr>
            </tbody>
          </table>
        </div>
        <?php endforeach; ?>

    </div>

    <div class="card mt-4">
        <div class="card-header bg-secondary text-white">
            List Buku Dipinjam
            <a data-bs-toggle="modal" data-bs-target="#tambahPinjaman" class="btn btn-secondary active btn-sm" style="float:right; margin-left:5px;"><i class="fas fa-plus-circle"></i> Tambah Peminjaman</a>
        </div>
        
        <div class="card-body">
        <form id="HapusDataPeminjam">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col"><input type="checkbox" id="parent"></th>
                <th scope="col">Judul Buku</th>
                <th scope="col">Jumlah Pinjam</th>
                <th scope="col">Tgl Pinjam</th>
                <th scope="col">Tgl Kembali</th>
                <th scope="col">Petugas</th>
                <th scope="col">Status Pinjam</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=1; if(!empty($Transaksi->TampilkanBukuDipinjam($_POST['search']))): ?>
              <?php foreach ($Transaksi->TampilkanBukuDipinjam($_POST['search']) as $x): ?>
              <tr>
                <th scope="row"><?= $i++; ?></th>
                <td><input name="id[]" class="child" type="checkbox" value="<?php echo $x->id_peminjam; ?>"></td>
                <td><?= $x->judul_buku; ?></td>
                <td><?= $x->jumlah_pinjam; ?></td>
                <td><?=  date("d-m-Y", strtotime($x->tgl_pinjam)); ?></td>
                <td><?=  date("d-m-Y", strtotime($x->tgl_kembali)); ?></td>
                <td><?= $x->nama_petugas; ?></td>
                <?php if($x->tgl_kembali > date('Y-m-d')){ ?>
                <td> <span class="badge bg-success">Belum Terlambat</span> </td>
                <?php }else{ ?>
                <td><span class="badge bg-danger">Terlambat</span></td>
                <?php } ?>
                <td>
                    <a href="#" data-bs-toggle="modal" data-bs-target=".kembalikanbuku" <?= "data-id=".$x->id_peminjam.""; ?>><span class="badge bg-primary">Kembalikan</span></a>
                </td>
              </tr>
              <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <div class="card-footer">
            <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
        </div>
        </form>
    </div>



    <div class="card mt-4 mb-4">
        <div class="card-header bg-secondary text-white">
            List Buku Dikembalikan
        </div>
        
        <div class="card-body">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Judul Buku</th>
                <th scope="col">Jumlah Pinjam</th>
                <th scope="col">Tgl Pinjam</th>
                <th scope="col">Tgl Kembali</th>
                <th scope="col">Petugas</th>
                <th scope="col">Tgl Dikembalikan</th>
                <th scope="col">Keterlambatan</th>
                <th scope="col">Denda</th>
              </tr>
            </thead>
            <tbody>
              <?php $denda = 0; $i=1; if(!empty($Transaksi->TampilkanBukuDikembalikan($_POST['search']))): ?>
              <?php foreach ($Transaksi->TampilkanBukuDikembalikan($_POST['search']) as $x): ?>
              <tr>
                <th scope="row"><?= $i++; ?></th>
                <td><?= $x->judul_buku; ?></td>
                <td><?= $x->jumlah_pinjam; ?></td>
                <td><?=  date("d-m-Y", strtotime($x->tgl_pinjam)); ?></td>
                <td><?=  date("d-m-Y", strtotime($x->tgl_kembali)); ?></td>
                <td><?= $x->nama_petugas; ?></td>
                <td><?=  date("d-m-Y", strtotime($x->tgl_pengembalian)); ?></td>
                <td>
                  <?php
                      $tgl_pengembalian = date_create($x->tgl_pengembalian);
                      $tgl_kembali = date_create($x->tgl_kembali); 
                      $diff = date_diff($tgl_pengembalian, $tgl_kembali);

                      if($diff->format("%R%a") < 0){

                          //ada keterlambatan per hari

                          echo $diff->format("%R%a")." Hari";

                      }else{

                          echo "0 Hari";

                      }
                  ?>
                </td>
                <td>
                    <?php $denda = $denda + $x->denda; ?>
                    <?= "Rp. ".number_format($x->denda ,2,',','.'); ?>
                </td>
              </tr>
              <?php endforeach; ?>
              <tr class="text-bold">
                  <th colspan="8" scope="row" style="text-align:right">Total Denda</th>
                  <th scope="row"> <?= "Rp. ".number_format($denda ,2,',','.'); ?></th>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
    </div>

    <?php endif; ?>
  </main>

<!-- Modal Tambah Pinjaman -->
<div class="modal fade" id="tambahPinjaman" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Pinjaman Buku</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="TambahData">
          <div class="row mb-4">
              <label class="col-sm-2 col-form-label">Judul Buku</label>
              <div class="col-sm-10">
                <select class="form-control caribuku" style="width: 100%;" name="id_buku" required>
                    <option value="">- Cari Buku -</option>
                </select>
              </div>
          </div>

          <input type="hidden" name="id_anggota" value="<?= $_POST['search'] ?>">
          <input type="hidden" name="id_petugas" value="<?= $_SESSION['login']['id_petugas']; ?>">
          <div class="row mb-4">
              <label class="col-sm-2 col-form-label">Jumlah Pinjam</label>
              <div class="col-sm-10">
              <input type="number" class="form-control" name="jumlah_pinjam" required placeholder="Jumlah Pinjam">
              </div>
          </div>

          <div class="row mb-4">
              <label class="col-sm-2 col-form-label">Tgl Pinjam</label>
              <div class="col-sm-10">
              <input type="date" class="form-control" name="tgl_pinjam" required value="<?= date('Y-m-d'); ?>">
              </div>
          </div>

          <div class="row mb-4">
              <label class="col-sm-2 col-form-label">Tgl Kembali</label>
              <div class="col-sm-10">
              <input type="date" class="form-control" name="tgl_kembali" required >
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

<!-- modal Kembalikan Buku -->
<div class="modal fade kembalikanbuku" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal_edit"></div>
  </div>
</div>

</div>
</div>
<script>
$(document).ready(function(){
  $('.loading').hide();

  $('.select2').select2({
      theme: 'bootstrap4',
      minimumInputLength: 1,
        allowClear: true,
        placeholder: 'Masukkan NIM / Nama Anggota',
        ajax: {
          dataType: 'json',
          url: '../../php/Transaksi.php?filter',
          delay: 250,
          data: function(params) {
            return {
              search: params.term
            }
          },
          processResults: function (data) {
            var results = [];

            $.each(data, function(index, item){
                results.push({
                    id : item.id_anggota,
                    text : item.nim_anggota+" - "+item.nama_anggota
                });
            });

            return{
                results : results
            }
        },
      }
  });

  $('.caribuku').select2({
      theme: 'bootstrap4',
      minimumInputLength: 1,
        allowClear: true,
        placeholder: 'Masukkan Judul Buku / Penulis',
        ajax: {
          dataType: 'json',
          url: '../../php/Transaksi.php?filterbuku',
          delay: 250,
          data: function(params) {
            return {
              buku: params.term
            }
          },
          processResults: function (data) {
            var results = [];

            $.each(data, function(index, item){
                results.push({
                    id : item.id_buku,
                    text : item.penulis_buku+" - "+item.judul_buku
                });
            });

            return{
                results : results
            }
        },
      }
  });

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
        url : '../../php/Transaksi.php?insert_peminjam',
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

  //hapus data
  $('#HapusDataPeminjam').submit(function(e){
      e.preventDefault();
      var confirmed = confirm("Yakin Mau Menghapus Data Yang Ter-Checklist");
      if(confirmed){
        $.ajax({
          url : '../../php/Transaksi.php?hapus_peminjam',
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

  //load modal edit
  $('.kembalikanbuku').on('show.bs.modal', function(e){
      var id = $(e.relatedTarget).data('id');
      $.ajax({
          url : '../../php/Transaksi.php?prepare_kembalikan_buku',
          type : 'POST',
          data : {'id_peminjam':id},
          success : function(data){
              $('.modal_edit').html(data);
          }
      });
  });

})
</script>
</body>
</html>
