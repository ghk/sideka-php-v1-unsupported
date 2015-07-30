-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2015 at 09:26 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sideka`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_anggaran`
--

CREATE TABLE IF NOT EXISTS `tbl_anggaran` (
`id_anggaran` int(10) NOT NULL,
  `nomor` varchar(10) NOT NULL,
  `id_apbdes` int(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jumlah` int(30) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `id_parent` int(10) DEFAULT NULL,
  `tipe_apbdes` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tbl_anggaran`
--

INSERT INTO `tbl_anggaran` (`id_anggaran`, `nomor`, `id_apbdes`, `nama`, `jumlah`, `keterangan`, `id_parent`, `tipe_apbdes`) VALUES
(1, '1', 1, 'Pendapatan Asli Desa', 3000000, 'Pendapatan Asli Desa', 0, 0),
(2, '2', 1, 'Pendapatan Transfer', 3000000, 'Pendapatan Transfer', 0, 0),
(3, '3', 1, 'Pendapatan Lain lain', 4000000, 'Pendapatan Lain lain', 0, 0),
(4, '4', 1, 'Penyelenggaraan Pemerintahan Desa', 20000000, 'Penyelenggaraan Pemerintahan Desa', 0, 1),
(5, '5', 1, 'Pelaksanaan Pembangunan Desa', 20000000, 'Pelaksanaan Pembangunan Desa', 0, 1),
(6, '6', 1, 'Pembinaan Kemasyarakatan', 1400, 'Pembinaan Kemasyarakatan', 0, 1),
(7, '7', 1, 'Pemberdayaan Masyarakat', 20000000, 'Pemberdayaan Masyarakat', 0, 1),
(8, '', 1, 'Bidang Tak Terduga', 20000000, 'Bidang Tak Terduga', 0, 1),
(9, '6.1', 1, 'Pendapatan Anu1', 1400, 'alala1', 6, 0),
(10, '6.9.1', 1, 'pendapatan anu1nya anu', 400, 'anu nu', 9, 0),
(11, '6.9.2', 1, 'pendapatan anunya anu 2', 1000, 'pendapatan anunya anu 2', 9, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_apbdes`
--

CREATE TABLE IF NOT EXISTS `tbl_apbdes` (
`id_apbdes` int(10) NOT NULL,
  `tahun` int(11) NOT NULL,
  `is_perubahan` tinyint(1) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_apbdes`
--

INSERT INTO `tbl_apbdes` (`id_apbdes`, `tahun`, `is_perubahan`, `nama`) VALUES
(1, 2015, 1, 'APBDes-P 2015');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_realisasi`
--

CREATE TABLE IF NOT EXISTS `tbl_realisasi` (
`id_realisasi` int(10) NOT NULL,
  `id_anggaran` int(10) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `jumlah` int(30) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `tbl_realisasi`
--

INSERT INTO `tbl_realisasi` (`id_realisasi`, `id_anggaran`, `tanggal`, `jumlah`) VALUES
(1, 1, '2015-07-27 16:10:37', 1000000),
(2, 2, '2015-07-27 16:10:37', 2000000),
(3, 3, '2015-07-26 17:00:00', 3000001),
(4, 4, '2015-07-27 17:08:56', 10000000),
(5, 5, '2015-07-27 17:08:56', 10000000),
(6, 6, '2015-07-27 17:09:13', 10000000),
(7, 7, '2015-07-27 17:09:13', 10000000),
(8, 8, '2015-07-27 17:09:21', 10000000),
(17, 8, '2015-07-29 17:00:00', 999999999);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_anggaran`
--
ALTER TABLE `tbl_anggaran`
 ADD PRIMARY KEY (`id_anggaran`);

--
-- Indexes for table `tbl_apbdes`
--
ALTER TABLE `tbl_apbdes`
 ADD PRIMARY KEY (`id_apbdes`);

--
-- Indexes for table `tbl_realisasi`
--
ALTER TABLE `tbl_realisasi`
 ADD PRIMARY KEY (`id_realisasi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_anggaran`
--
ALTER TABLE `tbl_anggaran`
MODIFY `id_anggaran` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tbl_apbdes`
--
ALTER TABLE `tbl_apbdes`
MODIFY `id_apbdes` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_realisasi`
--
ALTER TABLE `tbl_realisasi`
MODIFY `id_realisasi` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
