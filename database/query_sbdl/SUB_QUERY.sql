/*VIEW TABEL PETUGAS INNER JOIN PEMINJAM INNER JOIN PENGEMBALIAN*/

/*SUB QUERY BUKU*/

CREATE OR REPLACE VIEW view_rekapitulasi AS
SELECT nama_anggota, tgl_pengembalian, denda, peminjam.`id_buku` FROM anggota INNER JOIN peminjam 
ON anggota.`id_anggota` = peminjam.`id_anggota` INNER JOIN pengembalian ON peminjam.`id_peminjam` = pengembalian.`id_peminjam`
WHERE id_buku IN (
	SELECT id_buku FROM buku
);