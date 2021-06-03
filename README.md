# Tugas Besar SBDL-Prak
Aplikasi Manajemen Data Perpustakaan SBDL Prak

# Tampilan Aplikasi

![1](https://user-images.githubusercontent.com/61740978/120602404-2ec7dd00-c475-11eb-85c3-72c601b6e507.PNG)
![2](https://user-images.githubusercontent.com/61740978/120602438-37b8ae80-c475-11eb-9c7d-0a31c7ec2291.PNG)
![3](https://user-images.githubusercontent.com/61740978/120602452-3b4c3580-c475-11eb-9f1b-e68ef3ac0593.PNG)
![4](https://user-images.githubusercontent.com/61740978/120602469-3e472600-c475-11eb-8783-06871f6ead90.PNG)


# Instalasi

git clone https://github.com/ardhikarestuyoviyanto/SBDL-Prak.git

1. Importkan dbk_perpus ke localhost anda (Database/dbk_perpus.sql)
2. Pengaturan database ada di folder php/Database.php
3. Masuk ke direktori root (index.php) jalankan aplikasi dengan perintah php -S localhost:8080
4. Buka browser dan akses localhost:8080

# Arsitektur aplikasi

![1](https://user-images.githubusercontent.com/61740978/120088364-c6e26100-c119-11eb-81ed-3eba81c2fa8f.PNG)

Penjelasan
1. index.php => Sebagai root direktori, Berfungsi untuk menampilkan halaman views yang akan ditampilkan, jika ingin membuat halaman baru jangan lupa tentukan route / jalan menuju ke halaman tersebut dengan menentukan routing nya di index.php
2. Folder views =>  Sebagai views aplikasi "Jangan melakukan query di folder views", pada direktori ini anda hanya dapat melakukan request dan response data dengan memanggil method yang ada di folder php
3. Folder php => Tempat eksekusi query dan menghandle response dan request dari views serta menentukan routing ke index.php, dengan perintah 
   header(location: menuju root direktori/nama-routing pada index.php)

#  Penjelasan Folder Yang Lain
1. folder public untuk meletakan file css dan js (bootstrap)
2. folder partisi => views/partisi, didalamnya terdapat konten yang sifatnya statis (yg selalu di include kan di halaman yang sama) misalnya head dan sidebar (selalu ada dihalaman yang sama pada admin) jika membuat views yang baru pada halaman admin jangan lupa include kan file di partisi. tujuan penggunaan folder partisi ini pada intinya hanya untuk mempersingkat dan menghindari perulangan kode.

# Update
1. Timpakan File TAMBAHAN_QUERY.sql ke database dbk_perpus.sql
