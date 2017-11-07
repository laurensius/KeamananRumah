/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 10.1.16-MariaDB : Database - db_keamanan_rumah
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_keamanan_rumah` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_keamanan_rumah`;

/*Table structure for table `t_ref_status_user` */

DROP TABLE IF EXISTS `t_ref_status_user`;

CREATE TABLE `t_ref_status_user` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `status` varchar(99) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `t_ref_status_user` */

insert  into `t_ref_status_user`(`id`,`status`) values (1,'Active'),(2,'Blocked');

/*Table structure for table `t_ref_tipe_user` */

DROP TABLE IF EXISTS `t_ref_tipe_user`;

CREATE TABLE `t_ref_tipe_user` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `tipe` varchar(99) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `t_ref_tipe_user` */

insert  into `t_ref_tipe_user`(`id`,`tipe`) values (1,'ROOT'),(2,'SIBLING COORDINATOR'),(3,'SIBLING MEMBER');

/*Table structure for table `t_user` */

DROP TABLE IF EXISTS `t_user`;

CREATE TABLE `t_user` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(99) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nama` varchar(199) NOT NULL,
  `alamat` text NOT NULL,
  `tipe` int(4) NOT NULL,
  `register_datetime` datetime NOT NULL,
  `status` int(4) NOT NULL,
  `last_login` datetime NOT NULL,
  `photo` varchar(199) NOT NULL,
  `parent` int(4) NOT NULL,
  `API_KEY` varchar(32) NOT NULL,
  `secure_key` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `t_user` */

insert  into `t_user`(`id`,`username`,`password`,`nama`,`alamat`,`tipe`,`register_datetime`,`status`,`last_login`,`photo`,`parent`,`API_KEY`,`secure_key`) values (1,'root','63a9f0ea7bb98050796b649e85481845','Super User','Desa Cikadu RT 001 Rw 002 Kecamatan Nusaherang Kabupaten Kuningan',1,'2017-10-21 00:00:00',1,'2017-10-26 16:16:47','',0,'1ebc728031def12d8abefee726dc7807','0000');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
