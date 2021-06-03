<?php
require_once('../../../php/Transaksi.php'); 
require_once('../../../php/Setting.php');
?>
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Pengembalian Buku</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<?php foreach ($Transaksi->TampilkanBukuDipinjamByIdPinjam($_GET['id']) as $x): ?>

<form id="KembalikanBuku">

    <table class="table table-hover table-bordered">
        <tbody>
            <tr class="text-bold">
            <th scope="row">Judul Buku</th>
            <td><?= $x->judul_buku; ?></td>
            </tr>
            <tr>
            <th scope="row">Jumlah Pinjam</th>
            <td><?= $x->jumlah_pinjam; ?></td>
            </tr>
            <tr>
            <th scope="row">Tgl Pinjam</th>
            <td><?= date("d-m-Y", strtotime($x->tgl_pinjam)); ?></td>
            </tr>
            <tr>
            <th scope="row">Tgl Kembali</th>
            <td><?=date("d-m-Y", strtotime($x->tgl_kembali)); ?></td>
            </tr>
            <tr>
            <th scope="row">Keterlambatan (Hari)</th>
            <input type="hidden" name="denda" value="">
            <td>
                <?php
                    $now = date_create(Date('Y-m-d'));
                    $tgl_kembali = date_create($x->tgl_kembali); 
                    $diff = date_diff($now, $tgl_kembali);

                    if($diff->format("%R%a") < 0){

                        //ada keterlambatan per hari

                        echo '<input type="hidden" name="denda" value='.$diff->format('%a').'>';

                        echo $diff->format("%R%a")." Hari";

                    }else{

                        echo "<input type='hidden' name='denda' value='0'>";

                        echo "Belum Terlambat";

                    }
                ?>
            </td>
            </tr>
            <tr>
            <th scope="row" style="vertical-align:middle;">Tgl Transaksi</th>
            <td>
                <input type="date" class="form-control" name="tgl_pengembalian" required value="<?= date('Y-m-d'); ?>">
            </td>
            </tr>
        </tbody>
    </table>
    <hr>

    <table class="table table-hover table-bordered">
        <?php foreach ($Setting->TampilkanSetting() as $y): ?>
        <tbody>
            <tr class="text-bold">
                <th scope="row">Denda Per 1 Hari Keterlambatan</th>
                <td><?= "Rp. ".number_format($y->denda ,2,',','.'); ?></td>
            </tr>
            <tr>
                <th scope="row"></th>
                <td>
                    <?php
                        $total_denda = 0;
                        $now = date_create(Date('Y-m-d'));
                        $tgl_kembali = date_create($x->tgl_kembali); 
                        $diff = date_diff($now, $tgl_kembali);

                        if($diff->format("%R%a") < 0){

                            $total_denda = $diff->format("%a") * $y->denda;

                            echo number_format($y->denda ,2,',','.')." X ".$diff->format("%a")." Hari";

                        }else{

                            echo number_format($y->denda ,2,',','.')." X 0 Hari";

                        }
                    ?>
                </td>
            </tr>
            <tr class="text-bold table-success">
                <th scope="row">Total Denda</th>
                <th scope="row"><?= "Rp. ".number_format($total_denda ,2,',','.'); ?></th>
            </tr>
        </tbody>
        <?php endforeach; ?>
    </table>
    
    <input type="hidden" name="id_peminjam" value="<?= $x->id_peminjam; ?>">
    <input type="hidden" name="id_petugas" value="<?= $x->id_petugas; ?>">

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">
            <div class="spinner-border text-light spinner-border-sm" id="loading" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            Kembalikan Buku
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
$('#KembalikanBuku').submit(function(e){
    e.preventDefault();
    $.ajax({
        url : '../../php/Transaksi.php?kembalikan_buku',
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