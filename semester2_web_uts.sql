-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `anggota`;
CREATE TABLE `anggota` (
  `nrp` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  PRIMARY KEY (`nrp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `anggota` (`nrp`, `nama`, `tgl_lahir`, `alamat`, `no_hp`) VALUES
(1231,	'Defri Indra Mahardika',	'2021-12-31',	'RT 03 RW 03 Dukuh Krajan Desa Pulung',	'085604845436'),
(123123214,	'Defri Indra Mahardika',	'2021-12-31',	'RT 03 RW 03 Dukuh Krajan Desa Pulung',	'085604845436');

DROP TABLE IF EXISTS `buku`;
CREATE TABLE `buku` (
  `kode_buku` int(11) NOT NULL AUTO_INCREMENT,
  `judul` text NOT NULL,
  `pengarang` varchar(100) NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  PRIMARY KEY (`kode_buku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `buku` (`kode_buku`, `judul`, `pengarang`, `penerbit`) VALUES
(31,	'Coba buku',	'asd',	'-'),
(123,	'Coba buku',	'dsa',	'-');

DROP TABLE IF EXISTS `pinjam`;
CREATE TABLE `pinjam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nrp` int(11) NOT NULL,
  `kode_buku` int(11) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nrp` (`nrp`),
  KEY `kode_buku` (`kode_buku`),
  CONSTRAINT `pinjam_ibfk_1` FOREIGN KEY (`nrp`) REFERENCES `anggota` (`nrp`),
  CONSTRAINT `pinjam_ibfk_2` FOREIGN KEY (`kode_buku`) REFERENCES `buku` (`kode_buku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `pinjam` (`id`, `nrp`, `kode_buku`, `tgl_pinjam`) VALUES
(1,	1231,	31,	'2021-12-30'),
(4,	1231,	31,	'1222-12-12'),
(5,	1231,	31,	'1222-12-12');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) DEFAULT NULL,
  `image` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `user` (`id`, `gid`, `image`, `email`, `name`) VALUES
(1,	2147483647,	'https://lh3.googleusercontent.com/a-/AOh14GhTVv9U-sI_CL1CZSjWNewi7sXZIgDhkXfpMQYHrw=s96-c',	'defrindr@gmail.com',	'Defri Indra Mahardika');

-- 2021-06-16 11:54:02
