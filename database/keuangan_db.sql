/*
SQLyog Community v13.3.0 (64 bit)
MySQL - 8.0.30 : Database - sia_ukdw
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sia_ukdw` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `sia_ukdw`;

/*Table structure for table `ukdw_akun` */

DROP TABLE IF EXISTS `ukdw_akun`;

CREATE TABLE `ukdw_akun` (
  `akun_id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `jenis` enum('in','out') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `tipe` enum('program','rutin') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT 'program',
  PRIMARY KEY (`akun_id`),
  KEY `nama_akun` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `ukdw_akun` */

insert  into `ukdw_akun`(`akun_id`,`name`,`description`,`jenis`,`status`,`tipe`) values 
(4,'test',NULL,'in','inactive','program'),
(5,'0ktest','test','out','inactive','program'),
(6,'641-202-112-2','TANGGAP BENCANA','out','active','rutin'),
(7,'641-202-112-1','PKM BEKERJASAMA DENGAN MITRA UKDW - TINDAK LANJUT KKN DAN MBKM','out','active','program'),
(8,'641-202-112-3','PENGEMBANGAN KEMITRAAN UTK PENELITIAN DAN PKM','out','active','rutin');

/*Table structure for table `ukdw_anggaran` */

DROP TABLE IF EXISTS `ukdw_anggaran`;

CREATE TABLE `ukdw_anggaran` (
  `kode_anggaran` varchar(200) NOT NULL,
  `kode_akun` int NOT NULL,
  `tahun_anggaran` year NOT NULL,
  `total_anggaran` decimal(10,0) NOT NULL,
  `create_date` datetime NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `kode_user` varchar(200) NOT NULL,
  `tipe_anggaran` enum('debit','kredit') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'debit'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `ukdw_anggaran` */

insert  into `ukdw_anggaran`(`kode_anggaran`,`kode_akun`,`tahun_anggaran`,`total_anggaran`,`create_date`,`status`,`kode_user`,`tipe_anggaran`) values 
('AGRN6740913dc7f1b5.62071323',7,2024,21000000,'2024-11-22 21:12:13','1','USR674068090fd396.43485430','debit'),
('AGRN674091485cf465.36153180',6,2024,18000000,'2024-11-22 21:12:24','1','USR674068090fd396.43485430','debit'),
('AGRN67458df35ffff2.89803375',0,2024,20000000,'2024-11-26 15:59:31','1','USR674068090fd396.43485430','debit');

/*Table structure for table `ukdw_transaksi` */

DROP TABLE IF EXISTS `ukdw_transaksi`;

CREATE TABLE `ukdw_transaksi` (
  `transaction_id` int unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int unsigned NOT NULL,
  `create_date` datetime NOT NULL,
  `nominal` float NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `ukdw_transaksi` */

insert  into `ukdw_transaksi`(`transaction_id`,`category_id`,`create_date`,`nominal`,`description`,`status`) values 
(1,6,'2019-07-30 11:03:22',0,'','inactive'),
(2,7,'2019-07-30 11:03:22',100000,'test','active'),
(3,6,'2019-07-30 11:09:38',1000,'keluar','active');

/*Table structure for table `ukdw_user` */

DROP TABLE IF EXISTS `ukdw_user`;

CREATE TABLE `ukdw_user` (
  `id_user` varchar(200) NOT NULL,
  `nama_user` varchar(60) NOT NULL,
  `login_user` varchar(20) NOT NULL,
  `pass_user` varchar(255) NOT NULL,
  `role` enum('admin','manager','kasir') NOT NULL DEFAULT 'admin',
  `create_date` datetime NOT NULL,
  `status` enum('1','0') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `ukdw_user` */

insert  into `ukdw_user`(`id_user`,`nama_user`,`login_user`,`pass_user`,`role`,`create_date`,`status`) values 
('USR674068090fd396.43485430','toni joss','admin','827ccb0eea8a706c4c34a16891f84e7b','admin','2024-11-22 00:00:01','1'),
('USR67481d48bc92b6.91784585','admin baru','admin2','$2y$10$TEtMqWOJcJt1Qps770ZAguePgrQuMpkYHbzPitqGPBAlF.QQCD0IS','admin','2024-11-28 14:35:36','0'),
('USR67481e070ecdc9.42691873','kasir satu','kasir','$2y$10$ADQH5VB7E3B0LdR/NKMFfuKSYNqzEa/au5PMK8GazW79r8X9FPZqO','kasir','2024-11-28 14:38:47','1'),
('USR67481f00b1ec29.21345981','manajer satu','manajer','$2y$10$EfM.u4HQV4sPSrpL7itNt.IxIk8Y8XfC6FVhqbw2eVEvPM7q4E14G','manager','2024-11-28 14:42:56','1');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
