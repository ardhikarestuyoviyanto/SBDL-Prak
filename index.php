<?php

//Halaman Routing Aplikasi

$request = $_SERVER['REQUEST_URI'];

switch($request){

    //router landing page

    case '/' :
        require __DIR__ . '/views/home/landingpage.php';
        break;

    case '' :
        require __DIR__ . '/views/home/landingpage.php';
        break;

    //end router landing page


    //router login

    case '/login' :
        require __DIR__ . '/views/home/login.php';
        break;

    case '/login?error' :
        require __DIR__ . '/views/home/login.php';
        break;

    case '/login?captcha' :
        require __DIR__ . '/views/home/login.php';
        break;

    //end router login
    

    //router dashboard

    case '/dashboard' :
        require __DIR__ . '/views/admin/dashboard.php';
        break;

    //end router dashboard


    //router master data

    case '/anggota' :
        require __DIR__ . '/views/admin/masterdata/anggota.php';
        break;

    case '/buku' :
        require __DIR__ . '/views/admin/masterdata/buku.php';
        break;

    case '/pengguna' :
        require __DIR__ . '/views/admin/masterdata/pengguna.php';
        break;

    //end router master data


    //router transaksi

    case '/denda' :
        require __DIR__ . '/views/admin/transaksi/denda.php';
        break;

    case '/peminjaman' :
        require __DIR__ . '/views/admin/transaksi/peminjaman.php';
        break;

    case '/pengembalian' :
        require __DIR__ . '/views/admin/transaksi/pengembalian.php';
        break;

    //end router transaksi


    //router Pengaturan

    case '/setting' :
        require __DIR__ . '/views/admin/pengaturan/setting.php';
        break;

    //end router Pengaturan

    default:

        http_response_code(404);

        echo "Ups Halaman Kosong | jangan lupa kalau jalanin pakek perintah php -S localhost:8080";

    break;

}

?>