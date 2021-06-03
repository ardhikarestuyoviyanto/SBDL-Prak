<?php
require_once('Database.php');
require_once('libraries/Excel/vendor/autoload.php');

class Anggota {

    private $db;

    public function __construct(){

        $this->db = Database::getKoneksi();

    }

    public function TampilkanAnggota(){

        $res = $this->db->query("SELECT *FROM anggota");

        while($row = $res->fetch_object()):

            $data[] = $row;
        
        endwhile;

        if(empty($data)){

            return null;

        }else{

            return $data;

        }

    }

    public function TampilkanAnggotaById($id){

        $res = $this->db->query("SELECT *FROM anggota WHERE id_anggota = '$id'");

        while($row = $res->fetch_object()):

            $data[] = $row;
        
        endwhile;

        if(empty($data)){

            return null;

        }else{

            return $data;

        }

    }

    public function InsertAnggota(){

        $this->db->query("CALL insertanggota('$_POST[nama_anggota]', '$_POST[jeniskelamin_anggota]', '$_POST[notelp_anggota]', '$_POST[alamat_anggota]', '$_POST[nim_anggota]', '$_POST[jurusan]')");

    }

    public function EditAnggota(){

        $this->db->query("CALL editanggota('$_POST[nama_anggota]', '$_POST[jeniskelamin_anggota]', '$_POST[notelp_anggota]', '$_POST[alamat_anggota]', '$_POST[nim_anggota]', '$_POST[jurusan]', '$_POST[id]')");

    }

    public function HapusAnggota(){

        if(!empty($_POST['id'])){

            foreach ($_POST['id'] as $x):

                $this->db->query("CALL hapusanggota('$x')");
            
            endforeach;

            echo json_encode(count($_POST['id']).' Data Anggota Terhapus.');

        }else{

            echo json_encode('Gagal Hapus. Pilih Minimal 1 Data');

        }

    }

    public function ImportExcel(){

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

                $this->db->query("CALL insertanggota("."'".$sheetData[$i][1]."'".", "."'".$sheetData[$i][2]."'".", "."'".$sheetData[$i][3]."'".", "."'".$sheetData[$i][4]."'".", "."'".$sheetData[$i][5]."'".", "."'".$sheetData[$i][6]."'".")");

            }

            echo json_encode("Import Berhasil");


        }else{

            echo json_encode('Ekstensi File Salah (Harus .xlsx)');

        }

    }

}

$Anggota = new Anggota;

if(isset($_GET['insert'])):

    $Anggota->InsertAnggota();

    echo json_encode('Tambah Anggota Baru Berhasil');

endif;

if(isset($_GET['prepare_edit'])):

    //load body modal

    header('location:../views/admin/modal/modal_editanggota.php?id='.$_POST['id_anggota']);

endif;

if(isset($_GET['edit'])):

    $Anggota->EditAnggota();

    echo json_encode('Edit Anggota Berhasil');

endif;

if(isset($_GET['delete'])):

    $Anggota->HapusAnggota();

endif;

if(isset($_GET['import'])):

    $Anggota->ImportExcel();

endif;

?>

