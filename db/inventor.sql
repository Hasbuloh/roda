-- MySQL dump 10.16  Distrib 10.1.22-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: inventor
-- ------------------------------------------------------
-- Server version	10.1.22-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_pemesanantmp`
--

DROP TABLE IF EXISTS `tbl_pemesanantmp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_pemesanantmp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_pemesanantmp`
--

LOCK TABLES `tbl_pemesanantmp` WRITE;
/*!40000 ALTER TABLE `tbl_pemesanantmp` DISABLE KEYS */;
INSERT INTO `tbl_pemesanantmp` VALUES (15,25,21),(16,33,21),(17,32,2);
/*!40000 ALTER TABLE `tbl_pemesanantmp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_stok`
--

DROP TABLE IF EXISTS `tbl_stok`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_stok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_part` varchar(30) DEFAULT NULL,
  `nama_part` varchar(70) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `harga_jual` double DEFAULT NULL,
  `harga_beli` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_stok`
--

LOCK TABLES `tbl_stok` WRITE;
/*!40000 ALTER TABLE `tbl_stok` DISABLE KEYS */;
INSERT INTO `tbl_stok` VALUES (25,'06141GN5505','CAM CHAIN KIT',2,47000,41000),(26,'06141GN5505','CAM CHAIN KIT',3,42000,41000),(29,'06141KQ5505','CAM CHAIN KIT',2,40000,36000),(31,'06141GN5505','Tidak Boleh Kosong',2,45000,40000),(32,'06141GN5506','Tidak Boleh Kosong',2,45000,40000),(33,'06141GN5507','Tidak Boleh Kosong',3,45000,41000),(34,'06141GN5508','Tidak Boleh Kosong',12,50000,45000),(35,'06141KR5512','Tidak Boleh Kosong',20,460000,450000),(36,'06141KR5513','Tidak Kosong',22,468000,460000),(37,'06141KR5514','Tidak Kosong',21,468000,460000),(38,'06141KR5515','Tidak Kosong',21,468000,460000);
/*!40000 ALTER TABLE `tbl_stok` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user` (
  `id` varchar(10) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(30) DEFAULT NULL,
  `bagian` char(2) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `token` varchar(256) DEFAULT NULL,
  `_last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user`
--

LOCK TABLES `tbl_user` WRITE;
/*!40000 ALTER TABLE `tbl_user` DISABLE KEYS */;
INSERT INTO `tbl_user` VALUES ('USR-001','Gudang','9893e41bfebf5034139e0fccb8f5cba0f1f98a4a0b752ee4814a7881684f557bc3ffa0f4dd897304bf65d63176e07b19f6d53e209bb6f59a55cd627b07793e11','Asri Fadila','1996-07-20','P','GD',1,'b65a09e10b1609903215e96dd5799c5326b73c4c26c39f995a103741ca082656a337735e52653e39ea02ad7049ea267479e5a0df3ffaf4dda193a790864529db','2017-08-14 14:45:55');
/*!40000 ALTER TABLE `tbl_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-20 20:04:27
