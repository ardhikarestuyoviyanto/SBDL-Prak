<?php
require_once ('Database');

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

}

$Petugas = new Petugas;

?>