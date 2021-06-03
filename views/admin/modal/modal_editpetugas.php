<?php require_once('../../../php/Petugas.php'); ?>
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<?php foreach ($Petugas->TampilkanPetugasById($_GET['id']) as $x): ?>

<form id="EditData">
    <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">Nama Petugas</label>
        <div class="col-sm-10">
        <input type="text"  class="form-control" name="nama_petugas" required placeholder="Nama Petugas" value="<?= $x->nama_petugas; ?>">
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">Alamat</label>
        <div class="col-sm-10">
        <input type="text"  class="form-control" name="alamat_petugas" required placeholder="Alamat"  value="<?= $x->alamat_petugas; ?>">
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">No Telp</label>
        <div class="col-sm-10">
        <input type="text"  class="form-control" name="notelp_petugas" required placeholder="No Telp"  value="<?= $x->notelp_petugas; ?>">
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
        <div class="col-sm-10">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="jeniskelamin_petugas" id="flexRadioDefault11" checked value="L" <?php if($x->jeniskelamin_petugas == "L"): ?> checked <?php endif; ?>>
            <label class="form-check-label" for="flexRadioDefault11">
            Laki - Laki
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="jeniskelamin_petugas" id="flexRadioDefault22" value="P"  <?php if($x->jeniskelamin_petugas == "P"): ?> checked <?php endif; ?>>
            <label class="form-check-label" for="flexRadioDefault22">
            Perempuan
            </label>
        </div>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">Username</label>
        <div class="col-sm-10">
        <input type="text"  class="form-control" name="username" required placeholder="Username" value="<?= $x->username; ?>">
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">Password Baru</label>
        <div class="col-sm-10">
        <input type="password"  class="form-control" name="password_baru" placeholder="Password Baru">
        <small><i>Kosongkon Jika Tidak diubah</i></small>
        </div>
    </div>
    
    <input type="hidden" name="id" value="<?= $x->id_petugas; ?>">
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">
            <div class="spinner-border text-light spinner-border-sm" id="loading" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            Edit
        </button>
    </div>
</form>
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
        url : '../../php/Petugas.php?edit',
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