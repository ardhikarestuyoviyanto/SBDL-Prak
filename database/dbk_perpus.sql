/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.18-MariaDB : Database - dbk_perpus
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dbk_perpus` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `dbk_perpus`;

/*Table structure for table `anggota` */

DROP TABLE IF EXISTS `anggota`;

CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL AUTO_INCREMENT,
  `nama_anggota` varchar(55) DEFAULT NULL,
  `jeniskelamin_anggota` enum('L','P') DEFAULT NULL,
  `notelp_anggota` varchar(30) DEFAULT NULL,
  `alamat_anggota` varchar(55) DEFAULT NULL,
  `nim_anggota` varchar(55) DEFAULT NULL,
  `jurusan` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id_anggota`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

/*Data for the table `anggota` */

insert  into `anggota`(`id_anggota`,`nama_anggota`,`jeniskelamin_anggota`,`notelp_anggota`,`alamat_anggota`,`nim_anggota`,`jurusan`) values 
(1,'Royan Chusaii','P','0876545412','Karanganyar, Jawa Tengah','5190411312','Matematika'),
(2,'Bagus Sidiq','L','0865432345','Karanganyar, Jawa Tengah','5190411313','Teknik Informatika'),
(3,'Putri Indah Lestari','P','0898765354','Jatirahayu, Jakarta','5190411314','Teknik Informatika'),
(4,'Fatimah','P','0922435272','Karanganyar, Jawa Tengah','5190411315','Teknik Informatika'),
(5,'Rio Pratama','L','0876524232','Jatiyoso, Jawa Tengah','5190411316','Teknik Informatika'),
(6,'Dani Setiawan','L','0876524232','Jumapolo, Jawa Tengah','5190411317','Teknik Informatika'),
(7,'Riyan Okta Ferdian','L','0854231527','Jumapolo, Jawa Tengah','5190411318','Teknik Informatika'),
(13,'Diyan Seftiyana','L','0872621413','Solo, Jawa Tengah','5190411320','Matematika');

/*Table structure for table `buku` */

DROP TABLE IF EXISTS `buku`;

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL AUTO_INCREMENT,
  `judul_buku` varchar(30) DEFAULT NULL,
  `penulis_buku` varchar(55) DEFAULT NULL,
  `stok_buku` int(11) DEFAULT NULL,
  `id_kategoribuku` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_buku`),
  KEY `IdKategoribuku` (`id_kategoribuku`),
  CONSTRAINT `Idkategoribuku` FOREIGN KEY (`id_kategoribuku`) REFERENCES `kategori_buku` (`id_kategoribuku`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

/*Data for the table `buku` */

insert  into `buku`(`id_buku`,`judul_buku`,`penulis_buku`,`stok_buku`,`id_kategoribuku`) values 
(1,'Mekanika Teknik','Rinaldi Munir',15,2),
(2,'Algoritma dan Pemrograman','Rinaldi Munir',20,2),
(3,'Struktur Data','Rinaldi Munir',17,2),
(4,'Basis Data','Eva Kirania',30,2),
(5,'Kalkulus','Robert Smith',22,2),
(6,'Pemrograman Java','James Gosling',34,1),
(7,'Tutorial Laravel','Riyan Prastowo',22,1),
(8,'Matematika Diskrit','Rinaldi Munir',20,2),
(9,'Aljabar Linear','Wahyu Pratama',19,2);

/*Table structure for table `kategori_buku` */

DROP TABLE IF EXISTS `kategori_buku`;

CREATE TABLE `kategori_buku` (
  `id_kategoribuku` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategoribuku` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id_kategoribuku`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `kategori_buku` */

insert  into `kategori_buku`(`id_kategoribuku`,`nama_kategoribuku`) values 
(1,'Sains'),
(2,'Pemrograman');

/*Table structure for table `peminjam` */

DROP TABLE IF EXISTS `peminjam`;

CREATE TABLE `peminjam` (
  `id_peminjam` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_pinjam` date DEFAULT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `id_anggota` int(11) DEFAULT NULL,
  `id_petugas` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_peminjam`),
  KEY `Anggota` (`id_anggota`),
  KEY `Buku` (`id_buku`),
  KEY `Petugas` (`id_petugas`),
  CONSTRAINT `IdAnggota` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `IdBuku` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `IdPetugas` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

/*Data for the table `peminjam` */

insert  into `peminjam`(`id_peminjam`,`tgl_pinjam`,`tgl_kembali`,`id_buku`,`id_anggota`,`id_petugas`) values 
(1,'2021-02-15','2021-02-23',1,1,1),
(2,'2021-02-16','2021-02-24',1,1,1),
(3,'2021-02-23','2021-02-25',2,1,1),
(4,'2021-02-16','2021-02-24',3,2,1);

/*Table structure for table `pengembalian` */

DROP TABLE IF EXISTS `pengembalian`;

CREATE TABLE `pengembalian` (
  `id_pengembalian` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_pengembalian` date DEFAULT NULL,
  `denda` double DEFAULT NULL,
  `id_peminjam` int(11) DEFAULT NULL,
  `id_petugas` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pengembalian`),
  KEY `IdPeminjam` (`id_peminjam`),
  KEY `IdPetugas` (`id_petugas`),
  CONSTRAINT `_IdPeminjam` FOREIGN KEY (`id_peminjam`) REFERENCES `peminjam` (`id_peminjam`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `_IdPetugas` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `pengembalian` */

insert  into `pengembalian`(`id_pengembalian`,`tgl_pengembalian`,`denda`,`id_peminjam`,`id_petugas`) values 
(1,'2021-02-24',1000,1,1),
(2,'2021-02-24',0,2,1);

/*Table structure for table `petugas` */

DROP TABLE IF EXISTS `petugas`;

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL AUTO_INCREMENT,
  `nama_petugas` varchar(55) DEFAULT NULL,
  `alamat_petugas` varchar(55) DEFAULT NULL,
  `notelp_petugas` varchar(30) DEFAULT NULL,
  `jeniskelamin_petugas` enum('L','P') DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_petugas`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `petugas` */

insert  into `petugas`(`id_petugas`,`nama_petugas`,`alamat_petugas`,`notelp_petugas`,`jeniskelamin_petugas`,`username`,`password`) values 
(1,'Roni Febrianto, S.I.P','Sukoharjo, Jawa Tengah','08762524223','L','admin','$2y$10$6GC9gdxpGYQ0czmj/tXuReGgOgSWVa5puqLK7CBTs0jEJqx8zt6.G');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
