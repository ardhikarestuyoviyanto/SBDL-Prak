-- **************************
-- TAMBAHAN QUERY
-- **************************

/*TAMBAH KOLOM STATUS PADA TABEL PEMINJAM*/

ALTER TABLE peminjam ADD status_pinjam ENUM('pinjam', 'kembali');

/*TAMBAH KOLOM TOTAL PINJAM PADA TABEL PEMINJAM*/

ALTER TABLE peminjam ADD jumlah_pinjam INT(10);

/*TAMBAH TABEL SETTING*/

CREATE OR REPLACE TABLE setting(
   nama_aplikasi VARCHAR(50),
   denda INT(11)
);

/*TAMBAH DATA TABEL SETTING*/

INSERT INTO setting(nama_aplikasi, denda) VALUES ('Aplikasi Manajemen Perpustakaan', '5000');

/*Buat Tabel Log anggota*/

CREATE OR REPLACE TABLE log_anggota(
    id INT NOT NULL AUTO_INCREMENT,
    tgl DATETIME,
    nama_anggota VARCHAR (255),
    status_anggota ENUM ('insert', 'delete'),
    PRIMARY KEY (id)
);

/*Buat Tabel Log buku*/

CREATE OR REPLACE TABLE log_buku(
    id INT NOT NULL AUTO_INCREMENT,
    tgl DATETIME,
    judul_buku VARCHAR (255),
    status_buku ENUM ('insert', 'delete'),
    PRIMARY KEY (id)
);


-- ************************************
-- TRIGGER QUERY
-- ************************************

/* Tabel Log Anggota */

/* After Insert */

DELIMITER $$
CREATE TRIGGER log_insert_anggota
	AFTER INSERT
	ON anggota
	FOR EACH ROW
BEGIN
	INSERT INTO log_anggota
	(tgl, nama_anggota, status_anggota) VALUES
	(NOW(), new.nama_anggota, 'insert'); 
END$$ 


/* Before Delete */

DELIMITER $$
CREATE TRIGGER log_delete_anggota
	BEFORE DELETE
	ON anggota
	FOR EACH ROW
BEGIN
	INSERT INTO log_anggota
	(tgl, nama_anggota, status_anggota) VALUES
	(NOW(), old.nama_anggota, 'delete'); 
END$$ 



/* Tabel Log Buku */

/* After Insert */

DELIMITER $$
CREATE TRIGGER log_insert_buku
	AFTER INSERT
	ON buku
	FOR EACH ROW
BEGIN
	INSERT INTO log_buku
	(tgl, judul_buku , status_buku) VALUES
	(NOW(), new.judul_buku, 'insert'); 
END$$ 


/* Before Delete */

DELIMITER $$
CREATE TRIGGER log_delete_buku
	BEFORE DELETE
	ON buku
	FOR EACH ROW
BEGIN
	INSERT INTO log_buku
	(tgl, judul_buku , status_buku) VALUES
	(NOW(), old.judul_buku, 'delete'); 
END$$ 


-- ************************************
-- VIEW QUERY
-- ************************************

/*VIEW TABEL BUKU INNER JOIN KATEGORI_BUKU*/

CREATE OR REPLACE VIEW view_buku AS
SELECT nama_kategoribuku, buku.id_kategoribuku, id_buku, judul_buku, penulis_buku, stok_buku FROM buku INNER JOIN kategori_buku ON buku.`id_kategoribuku` = kategori_buku.`id_kategoribuku`;

/*VIEW TABEL PETUGAS INNER JOIN PEMINJAM INNER JOIN BUKU*/

CREATE OR REPLACE VIEW view_datapeminjam AS
SELECT judul_buku, jumlah_pinjam, tgl_pinjam, tgl_kembali, nama_petugas, id_peminjam, id_anggota, status_pinjam, peminjam.id_petugas
FROM buku INNER JOIN peminjam ON buku.`id_buku` = peminjam.`id_buku` INNER JOIN petugas ON
petugas.`id_petugas` = peminjam.`id_petugas`;

/*VIEW TABEL PETUGAS INNER JOIN PEMINJAM INNER JOIN BUKU INNER JOIN PENGEMBALIAN*/

CREATE OR REPLACE VIEW view_datapengembalian AS
SELECT judul_buku, jumlah_pinjam, tgl_pengembalian, tgl_pinjam, tgl_kembali, denda, pengembalian.id_peminjam, id_anggota, id_pengembalian, nama_petugas
FROM buku INNER JOIN peminjam ON buku.`id_buku` = peminjam.`id_buku` INNER JOIN pengembalian ON peminjam.`id_peminjam` = pengembalian.`id_peminjam`
INNER JOIN petugas ON petugas.`id_petugas` = pengembalian.`id_petugas`;

/*VIEW TABEL PETUGAS INNER JOIN PEMINJAM INNER JOIN BUKU INNER JOIN PENGEMBALIAN*/

CREATE OR REPLACE VIEW view_rekapitulasi AS
SELECT nama_anggota, tgl_pengembalian, denda, judul_buku FROM anggota INNER JOIN peminjam 
ON anggota.`id_anggota` = peminjam.`id_anggota` INNER JOIN pengembalian ON peminjam.`id_peminjam` = pengembalian.`id_peminjam`
INNER JOIN buku ON buku.`id_buku` = peminjam.`id_buku` WHERE denda != 0;

SELECT *FROM view_rekapitulasi WHERE tgl_pengembalian BETWEEN '2021-06-02' AND '2021-06-03';


-- ************************************
-- PROCEDURE QUERY
-- ************************************

/*PROSEDURE TABEL PETUGAS*/


/*Prosedure Insert Petugas*/
DELIMITER $$
CREATE OR REPLACE PROCEDURE insertpetugas(
	nama_petugas VARCHAR(55),
	alamat_petugas VARCHAR(55),
	notelp_petugas VARCHAR(30),
	jeniskelamin_petugas ENUM('L', 'P'),
	username VARCHAR(55),
	PASSWORD VARCHAR (255)	
)
BEGIN
    INSERT INTO petugas (nama_petugas, alamat_petugas, notelp_petugas, jeniskelamin_petugas, username, PASSWORD)
    VALUES (nama_petugas, alamat_petugas, notelp_petugas, jeniskelamin_petugas, username, PASSWORD);

END$$

/*Prosedure Edit Petugas*/
DELIMITER $$
CREATE OR REPLACE PROCEDURE editpetugas(
	var_nama_petugas VARCHAR(55),
	var_alamat_petugas VARCHAR(55),
	var_notelp_petugas VARCHAR(30),
	var_jeniskelamin_petugas ENUM('L', 'P'),
	var_username VARCHAR(55),
	var_id_petugas INT(11)	
)
BEGIN
    UPDATE petugas SET nama_petugas = var_nama_petugas, alamat_petugas = var_alamat_petugas, notelp_petugas = var_notelp_petugas,
    jeniskelamin_petugas = var_jeniskelamin_petugas, username = var_username WHERE id_petugas = var_id_petugas;

END$$

/*Prosedure Hapus Petugas*/
DELIMITER $$
CREATE OR REPLACE PROCEDURE hapuspetugas(
	var_id_petugas INT(11)	
)
BEGIN
    DELETE FROM petugas WHERE id_petugas = var_id_petugas;
END$$


/*PROSEDURE TABEL ANGGOTA*/


/*Prosedure Tambah Anggota*/
DELIMITER $$
CREATE OR REPLACE PROCEDURE insertanggota(
	nama_anggota VARCHAR(55),
	jeniskelamin_anggota ENUM('L', 'P'),
	notelp_anggota VARCHAR(30),
	alamat_anggota VARCHAR(30),
	nim_anggota VARCHAR(30),
	jurusan VARCHAR (255)	
)
BEGIN
    INSERT INTO anggota (nama_anggota, jeniskelamin_anggota, notelp_anggota, alamat_anggota, nim_anggota, jurusan)
    VALUES (nama_anggota, jeniskelamin_anggota, notelp_anggota, alamat_anggota, nim_anggota, jurusan);

END$$

/*Prosedure Edit Anggota*/
DELIMITER $$
CREATE OR REPLACE PROCEDURE editanggota(
	var_nama_anggota VARCHAR(55),
	var_jeniskelamin_anggota ENUM('L', 'P'),
	var_notelp_anggota VARCHAR(30),
	var_alamat_anggota VARCHAR(30),
	var_nim_anggota VARCHAR(30),
	var_jurusan VARCHAR (255),
	var_id INT(11)
)
BEGIN
    UPDATE anggota SET nama_anggota = var_nama_anggota, jeniskelamin_anggota = var_jeniskelamin_anggota, notelp_anggota = var_notelp_anggota,
    alamat_anggota = var_alamat_anggota, nim_anggota = var_nim_anggota, jurusan = var_jurusan WHERE id_anggota = var_id;

END$$

/*Prosedure Hapus Anggota*/
DELIMITER $$
CREATE OR REPLACE PROCEDURE hapusanggota(
	var_id_anggota INT(11)	
)
BEGIN
    DELETE FROM anggota WHERE id_anggota = var_id_anggota;
END$$


/*PROSEDURE TABEL KATEGORI BUKU*/


/*Prosedure Tambah Kategori Buku*/
DELIMITER $$
CREATE OR REPLACE PROCEDURE insertkategoribuku(
	nama_kategoribuku VARCHAR(55)	
)
BEGIN
    INSERT INTO kategori_buku(nama_kategoribuku) VALUES (nama_kategoribuku);
END$$

/*Prosedure Edit Kategori Buku*/
DELIMITER $$
CREATE OR REPLACE PROCEDURE editkategoribuku(
	var_nama_kategoribuku VARCHAR(55),
	var_id_kategoribuku INT(11)	
)
BEGIN
    UPDATE kategori_buku SET nama_kategoribuku = var_nama_kategoribuku WHERE id_kategoribuku = var_id_kategoribuku;
END$$

/*Prosedure Hapus Kategori Buku*/
DELIMITER $$
CREATE OR REPLACE PROCEDURE hapuskategoribuku(
	var_id_kategoribuku INT(11)	
)
BEGIN
    DELETE FROM kategori_buku WHERE id_kategoribuku = var_id_kategoribuku;
END$$


/*PROSEDURE TABEL BUKU*/


/*Prosedure Tambah Buku*/
DELIMITER $$
CREATE OR REPLACE PROCEDURE insertbuku(
	var_judul_buku VARCHAR(55),
	var_penulis_buku VARCHAR(55),
	var_stok_buku INT(11),
	var_kategoribuku VARCHAR(55)
)
BEGIN
    INSERT INTO buku(judul_buku, penulis_buku, stok_buku, id_kategoribuku)VALUES(var_judul_buku, var_penulis_buku, var_stok_buku, var_kategoribuku);
END$$

/*Prosedure Edit Buku*/
DELIMITER $$
CREATE OR REPLACE PROCEDURE editbuku(
	var_judul_buku VARCHAR(55),
	var_penulis_buku VARCHAR(55),
	var_stok_buku INT(11),
	var_kategoribuku VARCHAR(55),
	var_id_buku INT(11)
)
BEGIN
    UPDATE buku SET judul_buku = var_judul_buku, penulis_buku = var_penulis_buku , stok_buku = var_stok_buku, id_kategoribuku = var_kategoribuku
    WHERE id_buku = var_id_buku;
END$$

/*Prosedure Hapus Buku*/
DELIMITER $$
CREATE OR REPLACE PROCEDURE hapusbuku(
	var_id_buku INT(11)	
)
BEGIN
    DELETE FROM buku WHERE id_buku = var_id_buku;
END$$


/*PROSEDURE TABEL PEMINJAM*/


/*Prosedure Tambah Peminjam*/
DELIMITER $$
CREATE OR REPLACE PROCEDURE insertpeminjam(
	var_tgl_pinjam DATE,
	var_tgl_kembali DATE,
	var_id_buku INT(11),
	var_id_anggota INT(11),
	var_id_petugas INT(11),
	var_jumlah_pinjam INT(11)
)
BEGIN
    INSERT INTO peminjam(tgl_pinjam, tgl_kembali, id_buku, id_anggota, id_petugas, jumlah_pinjam, status_pinjam)VALUES
    (var_tgl_pinjam, var_tgl_kembali, var_id_buku, var_id_anggota, var_id_petugas, var_jumlah_pinjam, 'pinjam');
END$$

/*Prosedure Hapus Peminjam*/
DELIMITER $$
CREATE OR REPLACE PROCEDURE hapuspeminjam(
	var_id_peminjam INT(11)	
)
BEGIN
    DELETE FROM peminjam WHERE id_peminjam = var_id_peminjam;
END$$



/*PROSEDURE TABEL PENGEMBALIAN*/


/*Prosedure Tambah Pengembalian*/
DELIMITER $$
CREATE OR REPLACE PROCEDURE insertpengembalian(
	var_tglpengembalian DATE,
	var_total_keterlambatan INT(11),
	var_id_peminjam INT(11),
	var_id_petugas INT(11)
)
BEGIN
    INSERT INTO pengembalian(tgl_pengembalian, denda, id_peminjam, id_petugas)VALUES
    (var_tglpengembalian, hitungdenda(var_total_keterlambatan), var_id_peminjam, var_id_petugas);
END$$


-- ************************************
-- FUNCTION QUERY
-- ************************************

/*FUNCTION PENGHITUNG DENDA*/


DELIMITER $$
CREATE OR REPLACE FUNCTION hitungdenda(
	keterlambatan INT(11)
)

RETURNS INT(11)
DETERMINISTIC
BEGIN

	DECLARE total_denda INT(11);
	DECLARE denda_perhari INT(11);
	
	SELECT denda INTO denda_perhari FROM setting;
	
	SET total_denda = denda_perhari * keterlambatan;
	
	RETURN total_denda;

END$$






































