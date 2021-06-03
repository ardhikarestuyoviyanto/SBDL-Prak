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



