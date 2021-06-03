<?php
require_once('Database.php');

class Dashboard {

    private $db;

    public function __construct(){

        $this->db = Database::getKoneksi();

    }

    public function getData(){

        $data = array();
        
        $jumlah_buku = $this->db->query("SELECT *FROM buku");

        $total_anggota = $this->db->query("SELECT *FROM anggota");

        $peminjam_aktif = $this->db->query("SELECT *FROM peminjam WHERE status_pinjam = 'pinjam'");

        $petugas = $this->db->query("SELECT *FROM petugas");

        $data = array(

            'buku' => $jumlah_buku->num_rows,
            'anggota' => $total_anggota->num_rows,
            'peminjam' => $peminjam_aktif->num_rows,
            'petugas' => $petugas->num_rows

        );

        return $data;

    }

    public function getLogBuku(){

        $res = $this->db->query("SELECT *FROM log_buku");

        while($row = $res->fetch_object()):

            $data[] = $row;

        endwhile;

        if(empty($data)){

            return null;

        }else{

            return $data;

        }

    }

    public function getLogAnggota(){

        $res = $this->db->query("SELECT *FROM log_anggota");

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

$Dashboard = new Dashboard;

?>