<?php
require_once('Database.php');
require_once('libraries/Excel/vendor/autoload.php');

class Buku{

    private $db;

    public function __construct(){

        $this->db = Database::getKoneksi();

    }

    //Start Method atau Fungsi untuk Menu Kategori Buku

    public function TampilkanKategoriBuku(){

        $res = $this->db->query("SELECT *FROM kategori_buku");

        while($row = $res->fetch_object()):

            $data[] = $row;

        endwhile;

        if(empty($data)){

            return null;

        }else{

            return $data;

        }
 
    }

    public function TampilkanKategoriBukuById($id){

        $res = $this->db->query("SELECT *FROM kategori_buku WHERE id_kategoribuku = '$id'");

        while($row = $res->fetch_object()):

            $data[] = $row;

        endwhile;

        if(empty($data)){

            return null;

        }else{

            return $data;

        }

    }

    public function InsertKategoriBuku(){

        $this->db->query("CALL insertkategoribuku('$_POST[nama_kategoribuku]')");

    }

    public function EditKategoriBuku(){

        $this->db->query("CALL editkategoribuku('$_POST[nama_kategoribuku]', '$_POST[id]')");

    }

    public function HapusKategoriBuku(){

        $this->db->query("CALL hapuskategoribuku('$_GET[id]')");

    }

    //End Method atau Fungsi untuk Menu Kategori Buku



    //Start Method atau Fungsi untuk Menu Buku

    public function TampilkanBuku(){

        $res = $this->db->query("SELECT *FROM view_buku ORDER BY id_buku DESC");

        while($row = $res->fetch_object()):

            $data[] = $row;

        endwhile;

        if(empty($data)){

            return null;

        }else{

            return $data;

        }

    }

    public function TampilkanBukuById($id){

        $res = $this->db->query("SELECT *FROM buku WHERE id_buku = '$id' ORDER BY id_buku DESC");

        while($row = $res->fetch_object()):

            $data[] = $row;

        endwhile;

        if(empty($data)){

            return null;

        }else{

            return $data;

        }

    }

    public function FilterBuku($search){

        $res = $this->db->query("SELECT *FROM view_buku WHERE id_kategoribuku = '$search'");

        while($row = $res->fetch_object()):

            $data[] = $row;

        endwhile;

        if(empty($data)){

            return null;

        }else{

            return $data;

        }

    }

    public function InsertBuku(){

        $this->db->query("CALL insertbuku('$_POST[judul_buku]', '$_POST[penulis_buku]', '$_POST[stok_buku]', '$_POST[id_kategoribuku]')");

    }

    public function EditBuku(){

        $this->db->query("CALL editbuku('$_POST[judul_buku]', '$_POST[penulis_buku]', '$_POST[stok_buku]', '$_POST[id_kategoribuku]', '$_POST[id_buku]')");

    }

    public function HapusBuku(){

        if(!empty($_POST['id'])){

            foreach ($_POST['id'] as $x):

                $this->db->query("CALL hapusbuku('$x')");

            endforeach;

            echo json_encode(count($_POST['id'])." Data Buku Berhasil dihapus");

        }else{

            echo json_encode("Gagal Hapus, Checklist Minimal 1 Buku");

        }

    }

    public function ImportBuku(){

        $file_mimes = array(
            'application/octet-stream', 
            'application/vnd.ms-excel', 
            'application/x-csv', 
            'text/x-csv', 
            'text/csv', 
            'application/csv', 
            'application/excel', 
            'application/vnd.msexcel', 
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );

        if(isset($_FILES['excel']['name']) && in_array($_FILES['excel']['type'], $file_mimes)) {
 
            $arr_file = explode('.', $_FILES['excel']['name']);
            $extension = end($arr_file);
         
            if('csv' == $extension) {

                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();

            } else {

                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

            }
         
            $spreadsheet = $reader->load($_FILES['excel']['tmp_name']);
             
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            
            for($i = 1;$i < count($sheetData);$i++){

                $this->db->query("CALL insertbuku("."'".$sheetData[$i][1]."'".", "."'".$sheetData[$i][2]."'".", "."'".$sheetData[$i][3]."'".", "."'".$sheetData[$i][4]."'".")");

            }

            echo json_encode("Import Buku Berhasil");


        }else{

            echo json_encode('Ekstensi File Salah (Harus .xlsx)');

        }

    }


}

$Buku = new Buku;

//--------------------------------------------------------------------------------

if(isset($_GET['insert_kategoribuku'])):

    $Buku->InsertKategoriBuku();

    echo json_encode('Tambah Kategori Buku Berhasil');

endif;

if(isset($_GET['prepare_edit_kategoribuku'])):

    //load body modal

    header('location:../views/admin/modal/modal_editkategoribuku.php?id='.$_POST['id_kategoribuku']);

endif;

if(isset($_GET['edit_kategoribuku'])):

    $Buku->EditKategoriBuku();

    echo json_encode('Edit Kategori Buku Berhasil');

endif;

if(isset($_GET['hapus_kategoribuku'])):

    $Buku->HapusKategoriBuku();

    header('location:../kategoribuku');

endif;

//--------------------------------------------------------------------------------

if(isset($_GET['insert_buku'])):

    $Buku->InsertBuku();

    echo json_encode('Tambah Buku Berhasil');

endif;

if(isset($_GET['prepare_edit_buku'])):

    //load body modal

    header('location:../views/admin/modal/modal_editbuku.php?id='.$_POST['id_buku']);

endif;

if(isset($_GET['edit_buku'])):

    $Buku->EditBuku();

    echo json_encode('Edit Buku Berhasil');

endif;

if(isset($_GET['hapus_buku'])):

    $Buku->HapusBuku();
    
endif;

if(isset($_GET['import'])):

    $Buku->ImportBuku();

endif;

?>    