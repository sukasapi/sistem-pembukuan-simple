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
  `category_id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` enum('in','out') NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`category_id`),
  KEY `nama_akun` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `ukdw_akun` */

insert  into `ukdw_akun`(`category_id`,`name`,`description`,`type`,`status`) values 
(4,'test',NULL,'in','inactive'),
(5,'0ktest','test','out','inactive'),
(6,'Test','test','out','active'),
(7,'0ktest','test','in','active');

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

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
