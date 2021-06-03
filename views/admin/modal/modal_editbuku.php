<?php require_once('../../../php/Buku.php'); ?>
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<?php foreach ($Buku->TampilkanBukuById($_GET['id']) as $x): ?>
    <form id="EditData">
        <input type="hidden" name="id_buku" value="<?= $x->id_buku; ?>">
          <div class="row mb-3">
              <label for="nim" class="col-sm-2 col-form-label">Judul Buku</label>
              <div class="col-sm-10">
              <input type="text" class="form-control" name="judul_buku" required placeholder="Masukkan Judul" value="<?= $x->judul_buku; ?>">
              </div>
          </div>

          <div class="row mb-3">
              <label for="nama" class="col-sm-2 col-form-label">Kategori Buku</label>
              <div class="col-sm-10">
                  <select class="form-select" aria-label="Default select example" required name="id_kategoribuku">
                      <option selected value="">- Pilih Kategori Buku -</option>
                      <?php foreach ($Buku->TampilkanKategoriBuku() as $y): ?>
                      
                      <?php if($y->id_kategoribuku == $x->id_kategoribuku){ ?>
                      
                      <option selected value="<?= $y->id_kategoribuku; ?>"><?= $y->nama_kategoribuku; ?></option>
                      
                      <?php }else{ ?>
                    
                      <option value="<?= $y->id_kategoribuku; ?>"><?= $y->nama_kategoribuku; ?></option>

                      <?php } ?>
                      
                      <?php endforeach; ?>
                  </select>
              </div>
          </div>

          <div class="row mb-3">
              <label for="nama" class="col-sm-2 col-form-label">Penulis Buku</label>
              <div class="col-sm-10">
              <input type="text" class="form-control" name="penulis_buku" required placeholder="Masukkan Penulis" value="<?= $x->penulis_buku; ?>">
              </div>
          </div>

          <div class="row mb-3">
              <label for="nama" class="col-sm-2 col-form-label">Stok</label>
              <div class="col-sm-10">
              <input type="number" class="form-control" name="stok_buku" required placeholder="Masukkan Stok" value="<?= $x->stok_buku;?>">
              </div>
          </div>

            <div class="card-footer bg-white">
            <button type="submit" class="btn btn-primary text-white" style="float:right;">
                <div class="spinner-border text-light spinner-border-sm" id="loading" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                Update
            </button>
            </div>
        </form>

      </div>
    </div>
</div>


<?php endforeach; ?>
</div>
</div>
</div>
<script>
$(document).ready(function(){
$('#loading').hide();

//edit data
$('#EditData').submit(function(e){
    e.preventDefault();
    $.ajax({
        url : '../../php/Buku.php?edit_buku',
        data : $(this).serialize(),
        type : 'POST',
        beforeSend : function(){
            $('#loading').show();
        },
        complete : function(){
            $('#loading').hide();
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

});
</script>