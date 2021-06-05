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





















