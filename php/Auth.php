<?php
require_once('Database.php');

class Auth{

    private $db;

    public function __construct(){

        session_start();

        $this->db = Database::getKoneksi();

    }

    public function login(){

        //Jawaban Asli captcha
        $captcha = $_POST['number_1'] + $_POST['number_2'];

        if($captcha == $_POST['captcha']){

            $res = $this->db->query("SELECT *FROM petugas WHERE username = '$_POST[username]'");

            while ($row = $res->fetch_object()):

                if(password_verify($_POST['password'], $row->password)){

                    //login sukses

                    $this->CreateSession($row->nama_petugas, $row->id_petugas);

                    header('location:../dashboard');


                }else{

                    //username atau password salah

                    header('location:../login?error');

                }

            endwhile;

        }else{

            //captcha salah

            header('location:../login?captcha');

        }

    }

    public function CreateSession($nama_petugas, $id_petugas){

        $data = array(
            'username' => $_POST['username'],
            'nama_petugas' => $nama_petugas,
            'id_petugas' => $id_petugas
        );

        $_SESSION['login'] = $data;

    }

    public function Logout(){

        unset(
            $_SESSION['login']
        );

        session_destroy();

        header('location:../login');

    }

    public function CekSession(){

        //berfungsi untuk nge cek apakah ada session laman login, jika ada akan langsung teredirect ke laman admin

        if(isset($_SESSION['login'])){

            header('location:../dashboard');
        
        }

    }

    public function Proteksi(){

        //berfungsi untuk nge cek apakah di laman admin ada session atau nggak, jika gk ada halaman akan teredirect ke login

        if(empty($_SESSION['login'])){

            header('location:../login');

        }

    }

}

$Auth = new Auth;

if(isset($_GET['login'])):

    $Auth->login();

endif;

if(isset($_GET['logout'])):

    $Auth->Logout();

endif;

?>