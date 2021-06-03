<?php
require_once('Database.php');

class Setting{

    private $db;

    public function __construct(){

        $this->db = Database::getKoneksi();

    }

    public function TampilkanSetting(){

        $res = $this->db->query("SELECT *FROM setting");

        while($row = $res->fetch_object()):

            $data[] = $row;

        endwhile;

        if(empty($data)){

            return null;

        }else{

            return $data;

        }

    }

    public function UpdateSetting(){

        $this->db->query("UPDATE setting SET nama_aplikasi = '$_POST[nama_aplikasi]', denda = '$_POST[denda]'");

    }

}

$Setting = new Setting;

if(isset($_GET['update'])):

    $Setting->UpdateSetting();

    header('location:../setting');

endif;


?>