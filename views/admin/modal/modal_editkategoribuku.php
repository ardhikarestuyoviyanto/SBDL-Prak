<?php require_once('../../../php/Buku.php'); ?>
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<?php foreach ($Buku->TampilkanKategoriBukuById($_GET['id']) as $x): ?>

<form id="EditData">
    <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">Kategori Buku</label>
        <div class="col-sm-10">
        <input type="text"  class="form-control" name="nama_kategoribuku" required placeholder="Nama Kategori Buku" value="<?= $x->nama_kategoribuku; ?>">
        </div>
    </div>
    
    <input type="hidden" name="id" value="<?= $x->id_kategoribuku; ?>">
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
        url : '../../php/Buku.php?edit_kategoribuku',
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