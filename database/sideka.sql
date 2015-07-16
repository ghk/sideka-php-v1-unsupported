-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2015 at 12:03 PM
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
-- Table structure for table `tbl_akun`
--

CREATE TABLE IF NOT EXISTS `tbl_akun` (
`id_akun` int(10) NOT NULL,
  `nomor` varchar(10) NOT NULL,
  `id_apbdes` int(10) NOT NULL,
  `nama_akun` varchar(100) NOT NULL,
  `jumlah` int(30) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tbl_akun`
--

INSERT INTO `tbl_akun` (`id_akun`, `nomor`, `id_apbdes`, `nama_akun`, `jumlah`, `keterangan`) VALUES
(1, '1', 1, 'Pendapatan Asli Desa', 3000000, 'Pendapatan Asli Desa'),
(2, '2', 1, 'Pendapatan Transfer', 3000000, 'Pendapatan Transfer'),
(3, '3', 1, 'Pendapatan Lain lain', 4000000, 'Pendapatan Lain lain'),
(4, '4', 3, 'Penyelenggaraan Pemerintahan Desa', 20000000, 'Penyelenggaraan Pemerintahan Desa'),
(5, '5', 3, 'Pelaksanaan Pembangunan Desa', 20000000, 'Pelaksanaan Pembangunan Desa'),
(6, '6', 3, 'Pembinaan Kemasyarakatan', 20000000, 'Pembinaan Kemasyarakatan'),
(7, '7', 3, 'Pemberdayaan Masyarakat', 20000000, 'Pemberdayaan Masyarakat'),
(8, '', 3, 'Bidang Tak Terduga', 20000000, 'Bidang Tak Terduga');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_apbdes`
--

CREATE TABLE IF NOT EXISTS `tbl_apbdes` (
`id_apbdes` int(10) NOT NULL,
  `tahun` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_perubahan` tinyint(1) NOT NULL,
  `nama` varchar(75) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_apbdes`
--

INSERT INTO `tbl_apbdes` (`id_apbdes`, `tahun`, `is_perubahan`, `nama`) VALUES
(1, '2015-07-15 13:22:06', 0, 'Pendapatan'),
(3, '2015-07-16 07:56:06', 0, 'Belanja');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_realisasi`
--

CREATE TABLE IF NOT EXISTS `tbl_realisasi` (
`id_realisasi` int(10) NOT NULL,
  `id_akun` int(10) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `jumlah` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_akun`
--
ALTER TABLE `tbl_akun`
 ADD PRIMARY KEY (`id_akun`);

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
-- AUTO_INCREMENT for table `tbl_akun`
--
ALTER TABLE `tbl_akun`
MODIFY `id_akun` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tbl_apbdes`
--
ALTER TABLE `tbl_apbdes`
MODIFY `id_apbdes` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_realisasi`
--
ALTER TABLE `tbl_realisasi`
MODIFY `id_realisasi` int(10) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
