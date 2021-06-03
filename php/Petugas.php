<?php
require_once ('Database.php');
class Petugas{

    private $db;

    public function __construct(){

        $this->db = Database::getKoneksi();

    }

    public function TampilkanPetugas(){
        
        $res = $this->db->query("SELECT *FROM petugas");

        while($row = $res->fetch_object()):
            
            $data[] = $row;

        endwhile;

        if(empty($data)){

            return null;

        }else{

            return $data;

        }

    }

    public function TampilkanPetugasById($id_petugas){

        $res = $this->db->query("SELECT *FROM petugas WHERE id_petugas = '$id_petugas'");

        while($row = $res->fetch_object()):
            
            $data[] = $row;

        endwhile;

        if(empty($data)){

            return null;

        }else{

            return $data;

        }

    }

    public function InsertPetugas(){

        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $this->db->query("CALL insertpetugas('$_POST[nama_petugas]', '$_POST[alamat_petugas]', '$_POST[notelp_petugas]', '$_POST[jeniskelamin_petugas]', '$_POST[username]', '$password')");

    }

    public function EditPetugas(){

        if(!empty($_POST['password_baru'])){

            $password_baru = password_hash($_POST['password_baru'], PASSWORD_DEFAULT);

            $this->db->query("UPDATE petugas SET password = '$password_baru' WHERE id_petugas = '$_POST[id]'");

        }

        $this->db->query("CALL editpetugas ('$_POST[nama_petugas]', '$_POST[alamat_petugas]', '$_POST[notelp_petugas]', '$_POST[jeniskelamin_petugas]', '$_POST[username]', '$_POST[id]')");

    }

    public function HapusPetugas(){

        $this->db->query("CALL hapusPetugas('$_GET[id]')");

    }

}

$Petugas = new Petugas;

if(isset($_GET['insert'])):

    $Petugas->InsertPetugas();

    echo json_encode('Data Berhasil Ditambahkan');

endif;

if(isset($_GET['prepare_edit'])):
    
    //load body modal
    
    header('location:../views/admin/modal/modal_editpetugas.php?id='.$_POST['id_petugas']);

endif;

if(isset($_GET['edit'])):

    $Petugas->EditPetugas();

    echo json_encode('Data Berhasil Diedit');

endif;

if(isset($_GET['hapus'])):
    
    $Petugas->HapusPetugas();

    header('location:../petugas');

endif;

?>