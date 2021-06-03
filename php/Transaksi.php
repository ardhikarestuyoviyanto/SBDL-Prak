<?php
require_once('Database.php');

class Transaksi{

    private $db;

    public function __construct(){

        $this->db = Database::getKoneksi();

    }

    public function FilterAnggota(){

        $res = $this->db->query("SELECT *FROM anggota WHERE nama_anggota LIKE '%$_GET[search]%' OR nim_anggota = '%$_GET[search]%'");

        while($row = $res->fetch_object()):

            $data[] = $row;

        endwhile;

        echo json_encode($data);

    }

    public function FilterBuku(){

        $res = $this->db->query("SELECT *FROM buku WHERE judul_buku LIKE '%$_GET[buku]%' OR penulis_buku LIKE '%$_GET[buku]%'");

        while($row = $res->fetch_object()):

            $data[] = $row;

        endwhile;

        echo json_encode($data);

    }

    public function TampilkanBukuDipinjam($id_anggota){

        //query view

        $res = $this->db->query("SELECT *FROM view_datapeminjam WHERE id_anggota = '$id_anggota' AND status_pinjam = 'pinjam' ORDER BY id_peminjam DESC");

        while($row = $res->fetch_object()):

            $data[] = $row;

        endwhile;

        if(empty($data)){

            return null;

        }else{

            return $data;

        }

    }

    public function TampilkanBukuDipinjamByIdPinjam($id_peminjam){

        //query view

        $res = $this->db->query("SELECT *FROM view_datapeminjam WHERE id_peminjam = '$id_peminjam'");

        while($row = $res->fetch_object()):

            $data[] = $row;

        endwhile;

        if(empty($data)){

            return null;

        }else{

            return $data;

        }

    }

    public function TambahBukuDipinjam(){

        $this->db->query("CALL insertpeminjam('$_POST[tgl_pinjam]', '$_POST[tgl_kembali]', '$_POST[id_buku]', '$_POST[id_anggota]', '$_POST[id_petugas]', '$_POST[jumlah_pinjam]')");

    }

    public function HapusPeminjam(){

        if(!empty($_POST['id'])){

            foreach ($_POST['id'] as $x):

                $this->db->query("CALL hapuspeminjam('$x')");
            
            endforeach;

            echo json_encode(count($_POST['id']).' Data Berhasil Terhapus');

        }else{

            echo json_encode('Gagal Hapus, Checklist Minimal 1 Data');

        }


    }

    public function KembalikanBuku(){

        //update status yg semula pinjam menjadi kembali

        $this->db->query("UPDATE peminjam SET status_pinjam = 'kembali' WHERE id_peminjam = '$_POST[id_peminjam]'");

        //insert tabel pengembalian 

        $this->db->query("CALL insertpengembalian('$_POST[tgl_pengembalian]', '$_POST[denda]', '$_POST[id_peminjam]', '$_POST[id_petugas]')");

        echo json_encode('Berhasil Mengembalikan Buku');

    }

    public function TampilkanBukuDikembalikan($id_anggota){

        $res = $this->db->query("SELECT *FROM view_datapengembalian WHERE id_anggota = '$id_anggota' ORDER BY id_pengembalian DESC");

        while($row = $res->fetch_object()):

            $data[] = $row;

        endwhile;

        if(empty($data)){

            return null;

        }else{

            return $data;

        }

    }



}

$Transaksi = new Transaksi;

if(isset($_GET['filter'])):

    $Transaksi->FilterAnggota();

endif;

if(isset($_GET['filterbuku'])):

    $Transaksi->FilterBuku();

endif;

if(isset($_GET['insert_peminjam'])):

    $Transaksi->TambahBukuDipinjam();

    echo json_encode('Input Peminjaman Berhasil');

endif;

if(isset($_GET['hapus_peminjam'])):

    $Transaksi->HapusPeminjam();

endif;

if(isset($_GET['prepare_kembalikan_buku'])):
    
    //load body modal
    
    header('location:../views/admin/modal/modal_kembalikanbuku.php?id='.$_POST['id_peminjam']);

endif;

if(isset($_GET['kembalikan_buku'])):

    $Transaksi->KembalikanBuku();


endif;

?>