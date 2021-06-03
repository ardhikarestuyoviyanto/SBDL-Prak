<?php require_once('../../../php/Anggota.php'); ?>
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<?php foreach ($Anggota->TampilkanAnggotaById($_GET['id']) as $x): ?>

    <form id="EditData">

        <input type="hidden" name="id" value="<?php echo $x->id_anggota ?>">

        <div class="row mb-3">
            <label for="nim" class="col-sm-2 col-form-label">NIM</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="nim_anggota" name="nim_anggota" required placeholder="Masukkan Nim" value="<?php echo $x->nim_anggota; ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="nama_anggota" name="nama_anggota" required placeholder="Masukkan Nama"  value="<?php echo $x->nama_anggota; ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label for="nama" class="col-sm-2 col-form-label">Jurusan</label>
            <div class="col-sm-10">
                <select class="form-select" aria-label="Default select example" required name="jurusan">
                    <option selected value="">- Pilih Jurusan -</option>
                    <?php if($x->jurusan == "Teknik Informatika"){ ?>
                    <option selected value="Teknik Informatika">Teknik Informatika</option>
                    <?php }else{ ?>
                    <option value="Teknik Informatika">Teknik Informatika</option>
                    <?php } ?>

                    <?php if($x->jurusan == "Matematika"){ ?>
                    <option selected value="Matematika">Matematika</option>
                    <?php }else{ ?>
                    <option value="Matematika">Matematika</option>
                    <?php } ?>

                    <?php if($x->jurusan == "Manajemen"){ ?>
                    <option selected value="Manajemen">Manajemen</option>
                    <?php }else{ ?>
                    <option value="Manajemen">Manajemen</option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="row mb-3">
              <label for="nama" class="col-sm-2 col-form-label">Alamat</label>
              <div class="col-sm-10">
              <input type="text" class="form-control" id="alamat_anggota" name="alamat_anggota" required placeholder="Masukkan Alamat" value="<?php echo $x->alamat_anggota; ?>">
              </div>
        </div>

        <div class="row mb-3">
            <label for="nama" class="col-sm-2 col-form-label">Jenis Kelamin</label>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jeniskelamin_anggota" id="exampleRadios11" <?php if($x->jeniskelamin_anggota == "L"): ?> checked <?php endif; ?> value="L" checked>
                    <label class="form-check-label" for="exampleRadios11">
                        Laki - Laki
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jeniskelamin_anggota" id="exampleRadios22" <?php if($x->jeniskelamin_anggota == "P"): ?> checked <?php endif; ?> value="P">
                    <label class="form-check-label" for="exampleRadios22">
                        Perempuan
                    </label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="nama" class="col-sm-2 col-form-label">No Hp</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="nama" name="notelp_anggota" required placeholder="Masukkan No Hp" value="<?php echo $x->notelp_anggota; ?>">
            </div>
        </div>

        <div class="card-footer bg-white">
            <button type="submit" class="btn btn-primary text-white" style="float:right;">
                Update
                <div class="spinner-border text-light spinner-border-sm" id="loading" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </button>
        </div>
    </form>
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
        url : '../../php/Anggota.php?edit',
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