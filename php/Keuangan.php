<?php
require_once('Database.php');

class Keuangan{

    private $db;

    public function __construct(){

        $this->db = Database::getKoneksi();

    }

    public function TampilkanRekapitulasiKeuangan($start, $finish){

        $res = $this->db->query("SELECT *FROM view_rekapitulasi WHERE tgl_pengembalian BETWEEN '$start' AND '$finish'");

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

$Keuangan = new Keuangan;

?>