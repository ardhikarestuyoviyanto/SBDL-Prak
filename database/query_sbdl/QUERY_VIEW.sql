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




















